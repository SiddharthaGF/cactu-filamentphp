<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ElementLetter;
use App\Models\Answers;
use App\Models\Child;
use App\Models\Mail;
use App\Models\MobileNumber;
use App\Models\Tutor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\Button;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\ButtonAction;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\WebHook;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Throwable;

final class WhatsappController extends Controller
{
    public static function sendList($number_phone, $title, $message, $footer, $rows): void
    {
        $sections = [new Section('Stars', $rows)];
        $action = new Action('Submit', $sections);
        self::getWhatsAppInstance()->sendList(
            $number_phone,
            $title,
            $message,
            $footer,
            $action
        );
    }

    public function webhook(): void
    {
        $webhock = new WebHook();
        $webhock->verify($_GET, env('WHATSAPP_API_TOKEN_VERIFICATION'));
    }

    public function receive(): void
    {
        $payload = file_get_contents('php://input');
        $message = $this->getMessage($payload);
        if (!$message) {
            exit;
        }
        $type = $message["type"];
        $from = $message["from"];
        $timestamp = $message["timestamp"];

        switch ($type) {
            case 'text':
                $text = $message["text"]["body"];
                $action = $this->extractAction($text);
                if (!$this->validateAction($action)) {
                    self::sendTextMessage($from, "No se reconoce el comando: " . $action);
                    exit;
                }
                $this->executeCommand($from, $action);
                break;
            case 'interactive':
                $action = $message["interactive"]["button_reply"]["id"];
                $this->executeCommand($from, $action);
            //self::sendTextMessage($from, "Este es un mensaje interactivo, ejecuta el comando $action");
            // no break
            case 'image':
                break;
        }
        $this->saveContent($from, json_decode($payload, true));
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
        $this->saveContent($from, $payload);
    }

    private function getMessage($payload)
    {
        $data = json_decode($payload, true);
        return $data["entry"][0]["changes"][0]["value"]["messages"][0] ?? null;
    }

    private function extractAction($text)
    {
        return Str::slug(Str::of($text)->trim());
    }

    private function validateAction($action)
    {
        return in_array($action, ElementLetter::forMigration());
    }

    public static function sendTextMessage($number_phone, $message): void
    {
        self::getWhatsAppInstance()->sendTextMessage($number_phone, $message);
    }

    private function executeCommand($from, $command): void
    {
        $id = $this->extractIdfromCommand($command);
        $command = $this->cleanCommand($command);
        try {
            switch ($command) {
                case ElementLetter::ViewLetter->value:
                    $answer = Answers::findOrFail($id);
                    self::sendTextMessage($from, $answer->content);
                    break;
                case ElementLetter::ViewNow->value:
                    $mobile_number = MobileNumber::whereNumber("+" . $from)->firstOrFail();
                    $class = get_class($mobile_number->mobile_numerable);
                    switch ($class) {
                        case Child::class:
                            $mail = Mail::latest()->first();
                            foreach ($mail->answers as $answer) {
                                $rows[] = new Button("ver-carta {$answer->id}", $answer->id);
                            }
                            self::sendButtonReplyMessage(
                                $from,
                                "Selecciona una carta para leerla",
                                $rows
                            );
                            break;
                        case Tutor::class:
                            self::sendTextMessage($from, "el numero pertence a un padre");
                            break;
                    }
                    break;
            }
        } catch (Throwable $th) {
            self::sendTextMessage($from, $th->getMessage());
        }
    }

    public function extractIdfromCommand($command): int
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
        self::getWhatsAppInstance()->sendButton(
            $number_phone,
            $message,
            $action
        );
    }

    private static function getWhatsAppInstance()
    {
        return new WhatsAppCloudApi([
            'from_phone_number_id' => env('WHATSAPP_API_PHONE_NUMBER_ID'),
            'access_token' => env('WHATSAPP_API_TOKEN'),
        ]);
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
