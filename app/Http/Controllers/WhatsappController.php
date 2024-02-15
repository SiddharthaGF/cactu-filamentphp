<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\MailStatus;
use App\Enums\WhatsappCommands;
use App\Models\Answers;
use App\Models\Child;
use App\Models\Mail;
use App\Models\MobileNumber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\Button;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\ButtonAction;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Throwable;

final class WhatsappController extends Controller
{
    public static function sendList($number_phone, $title, $message, $footer, $rows): void
    {
        $sections = [new Section('Stars', $rows)];
        $action = new Action('Submit', $sections);
        whatsapp()->sendList(
            $number_phone,
            $title,
            $message,
            $footer,
            $action
        );
    }

    public function webhook(): void
    {
        echo webhook();
    }

    /**
     * @throws ResponseException
     */
    #[NoReturn] public function receive(): void
    {
        $payload = file_get_contents('php://input');
        $message = $this->getMessage($payload);
        if (!$message) {
            exit;
        }
        $type = $message["type"];
        $number_phone = $message["from"];
        $timestamp = $message["timestamp"];

        switch ($type) {
            case 'text':
                $text = $message["text"]["body"];
                $action = $this->extractAction($text);
                if (!$this->validateAction($action)) {
                    self::sendTextMessage($number_phone, "No se reconoce el comando: " . $action);
                    exit;
                }
                $this->executeCommand($number_phone, $action);
                break;
            case 'interactive':
                $action = $message["interactive"]["button_reply"]["id"];
                $this->executeCommand($number_phone, $action);
                break;
            case 'image':
                break;
        }
        $this->saveContent($number_phone, json_decode($payload, true));
        exit;


        /*  $content = $this->extractContent(file_get_contents('php://input'));

        $type = $content["type"];

        $from = $content["from"];
        $text = $content["text"]["body"];

        $action = $this->extractAction($text);
        if (!$this->validateAction($action)) {
            self::sendTextMessage($from, "No se reconoce el comando: " . $action);
            exit;
        }
        $timestamp = $content["timestamp"];

        $new_data = [
            $action => [
                "type" => $type,
                "message" => $text,
                "timestamp" => $timestamp,
            ]
        ];*/
        $this->saveContent($number_phone, $payload);
    }

    private function getMessage($payload)
    {
        $data = json_decode($payload, true);
        return $data["entry"][0]["changes"][0]["value"]["messages"][0] ?? null;
    }

    private function extractAction($text): string
    {
        return Str::slug(Str::of($text)->trim());
    }

    private function validateAction($action): bool
    {
        return in_array($action, WhatsappCommands::forMigration());
    }

    /**
     * @throws ResponseException
     */
    public static function sendTextMessage($number_phone, $message): void
    {
        whatsapp()->sendTextMessage($number_phone, $message);
    }

    private function executeCommand($from, $command): void
    {
        $id = $this->extractIdFromCommand($command);
        $command = $this->cleanCommand($command);
        try {
            switch ($command) {
                case WhatsappCommands::ViewLetter->value:
                    $answer = Answers::findOrFail($id);
                    self::sendButtonReplyMessage(
                        $from,
                        $answer->content,
                        [new Button(WhatsappCommands::ReplyNow->value, WhatsappCommands::ReplyNow->getLabel())]
                    );
                    break;
                case WhatsappCommands::ViewNow->value:
                    $mobile_number = MobileNumber::whereNumber("+" . $from)->firstOrFail();
                    $rows = Mail::findOrFail($id)->answers->map(function ($answer) use ($mobile_number) {
                        $buttonId = Child::class === get_class($mobile_number->mobile_numerable) ? $answer->id : (string)$answer->id;
                        return new Button(WhatsappCommands::ViewLetter->value . ' ' . $answer->id, $buttonId);
                    });
                    self::sendButtonReplyMessage($from, "Selecciona una carta para leerla", $rows->toArray());
                    Mail::whereId($id)->update(["status" => MailStatus::View]);
                    whatsapp()->sendTextMessage($from, "{$status}");
                    break;
            }
        } catch (Throwable $th) {
            self::sendTextMessage($from, $th->getMessage());
        }
    }

    public function extractIdFromCommand($command): int
    {
        return (int)preg_replace('/[^0-9]+/', '', $command);
    }

    private function cleanCommand($command): string
    {
        return trim(preg_replace('/[0-9]+/', '', $command), " ");
    }

    public static function sendButtonReplyMessage($number_phone, $message, $buttons): void
    {
        $action = new ButtonAction($buttons);
        whatsapp()->sendButton(
            $number_phone,
            $message,
            $action
        );
    }

    public function saveContent($from, $data): void
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        if (Storage::exists($file_name)) {
            $current_data = json_decode(Storage::get($file_name), true);
        }
        $data = isset($current_data) ? array_merge($current_data, $data) : $data;
        Storage::put($file_name, json_encode($data));
    }

    private function getTypeMessage($message)
    {
        return $message["type"] ?? null;
    }
}
