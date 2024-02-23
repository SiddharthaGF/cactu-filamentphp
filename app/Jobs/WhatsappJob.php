<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Enums\Message;
use App\Enums\WhatsappCommands;
use App\Models\Answers;
use App\Models\Mail;
use App\Whatsapp\Whatsapp;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\Button;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\ButtonAction;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Response\ResponseException;

final class WhatsappJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string|false $payload;
    private Whatsapp $whatsapp;

    public function __construct()
    {
        $this->payload = file_get_contents('php://input');
        $json = json_decode($this->payload, true);
        if (isset($json["entry"][0]["changes"][0]["value"]["messages"][0])) {
            $this->whatsapp = receiveWhatsapp($this->payload);
        } else {
            exit;
        }
    }

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

    /**
     * @throws ResponseException
     */
    public static function sendTextMessage($number_phone, $message): void
    {
        whatsapp()->sendTextMessage($number_phone, $message);
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

    /**
     * @throws ResponseException
     */
    public function handle(): void
    {
        $message = $this->whatsapp->entry()->changes()->value()->messages();
        $type = $message->type();
        $from = $message->from();
        switch ($type) {
            case 'text':
                $text = $message->text()->body();
                self::executeCommand($from, $text);
                break;
            case 'interactive':
                $action = $message->interactive()->buttonReply()->id();
                self::executeCommand($from, $action);
                break;
            case 'image':
                if ($this->existTempEmptyFile($from)) {
                    $this->handleImageMessage($from);
                }
                break;
        }
        exit;
    }

    public function extractId($command): int
    {
        return (int)preg_replace('/[^0-9]+/', '', $command);
    }

    public function saveOnTempJson(string $fileName, mixed $data, string $folder = "whatsapp-temp"): void
    {
        Storage::put("{$folder}/{$fileName}.json", json_encode($data));
    }

    public function existTempEmptyFile($from): bool
    {
        return Storage::exists("whatsapp-temp/" . $from . ".json");
    }

    public function loadFromTempJson(string $fileName, $folder = "whatsapp-temp"): int
    {
        return (int)json_decode(Storage::get("{$folder}/{$fileName}.json"), true)["id"];
    }

    public function deleteContentFile($from): void
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        Storage::delete($file_name);
    }

    /**
     * @throws ResponseException
     */
    private function executeCommand($from, $action): void
    {
        $id = $this->extractId($action);
        $command = $this->extractCommand($action);

        switch ($command) {
            case WhatsappCommands::ViewNow->value:
                $this->handleViewNowCommand($from, $id);
                break;
            case WhatsappCommands::ReplyNow->value:
                $this->handleReplyNowCommand($from, $id);
                break;
            default:
                $this->handleDefaultCommand($from, $command);
                break;
        }
    }

    private function extractCommand($command): string
    {
        return trim(str_replace(range(0, 9), '', $command));
    }

    /**
     * @throws ResponseException
     */
    private function handleViewNowCommand(string $from, int $id): void
    {
        $answers = Mail::findOrFail($id)->answers;
        foreach ($answers as $answer) {
            whatsapp()->sendTextMessage($from, $answer->content);
        }
        self::sendButtonReplyMessage(
            $from,
            Message::QuestionReply->value,
            [new Button(WhatsappCommands::ReplyNow->value . ' ' . $id, WhatsappCommands::ReplyNow->getLabel())]
        );
    }

    /**
     * @throws ResponseException
     */
    private function handleReplyNowCommand($from, int $id): void
    {
        whatsapp()->sendTextMessage($from, Message::ReplyNow->value);
        $this->saveOnTempJson($from, compact('id'));
    }

    /**
     * @throws ResponseException
     */
    private function handleDefaultCommand($from, string $command): void
    {
        if ($this->existTempEmptyFile($from)) {
            try {
                $reply_mail_id = $this->loadFromTempJson($from);
                Mail::whereId($reply_mail_id)->update(["status" => MailStatus::Replied]);
                $mail = Mail::findOrFail($reply_mail_id);
                $mailbox = $mail->mailbox;

                $mail = Mail::create([
                    "mailbox_id" => $mailbox->id,
                    "type" => MailsTypes::Response,
                    "status" => MailStatus::IsResponse,
                    "reply_mail_id" => $reply_mail_id,
                    "created_by" => 1,
                    "updated_by" => 1
                ]);

                $answer = Answers::create([
                    "mail_id" => $mail->id,
                    "content" => $command,
                    "attached_file_path" => "",
                    "created_by" => 1,
                    "updated_by" => 1
                ]);

                $id = $answer->id;

                $this->saveOnTempJson($from, compact('id'));
                self::sendTextMessage($from, "Ahora, envía una foto que desees compartir con tu auspiciante. 😊📷");
            } catch (Exception $e) {
                whatsapp()->sendTextMessage($from, $e->getMessage());
            }
            return;
        }
        whatsapp()->sendTextMessage($from, Message::NotHaveLetter->value);
    }

    private function handleImageMessage(string $from): void
    {
        $message = $this->whatsapp->entry()->changes()->value()->messages();
        $message->image()->save()->then(
            function (string $fileName) use ($from): void {
                $id = $this->loadFromTempJson($from);
                whatsapp()->sendTextMessage($from, "{$id} - {$fileName}");
                Answers::findOrFail($id)->update(["attached_file_path" => $fileName]);
                self::sendTextMessage($from, Message::ThanksForReply->value);
                $this->deleteContentFile($from);
            }
        )->wait();
    }
}
