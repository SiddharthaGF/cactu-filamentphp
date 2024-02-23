<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Enums\Message;
use App\Enums\WhatsappCommands;
use App\Models\Answers;
use App\Models\Mail;
<<<<<<< HEAD
use App\Whatsapp\Whatsapp;
use Exception;
=======
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
<<<<<<< HEAD
=======
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
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
<<<<<<< HEAD
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
=======

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->payload = file_get_contents('php://input');
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
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
<<<<<<< HEAD
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
=======
    #[NoReturn] public function handle(): void
    {
        $message = self::getMessage($this->payload);
        if ( ! $message) {
            exit;
        }
        $type = $message["type"];
        $number_phone = $message["from"];
        $timestamp = $message["timestamp"];

        switch ($type) {
            case 'text':
                $text = $message["text"]["body"];
                $action = self::extractAction($text);
                self::executeCommand($number_phone, $text);
                break;
            case 'interactive':
                $action = $message["interactive"]["button_reply"]["id"];
                self::executeCommand($number_phone, $action);
                break;
            case 'image':
                if ($this->existTempEmptyFile($number_phone)) {
                    try {
                        $media_id = $message["image"]["id"];
                        $token = env('WHATSAPP_API_TOKEN');
                        $url = "https://graph.facebook.com/v19.0/{$media_id}/";
                        $headers = ['Authorization' => "Bearer {$token}"];
                        $client = new Client();
                        $request = new Request('GET', $url, $headers);
                        $client->sendAsync($request)->then(
                            function ($response) use ($media_id, $headers, $number_phone): void {
                                $url = json_decode($response->getBody()->getContents(), true)["url"];
                                $client = new Client();
                                $request = new Request('GET', $url, $headers);
                                $client->sendAsync($request)->then(
                                    function ($response) use ($media_id, $number_phone): void {
                                        try {
                                            Storage::put("public/{$media_id}.jpg", $response->getBody());
                                            $id = (int)($this->loadContent($number_phone)["id"]);
                                            Answers::whereId($id)->update(["attached_file_path" => "{$media_id}.jpg"]);
                                            self::sendTextMessage($number_phone, Message::ThanksForReply->value);
                                            $this->deleteContentFile($number_phone);
                                        } catch (Exception $e) {
                                            self::sendTextMessage($number_phone, $e->getMessage());
                                        }
                                    }
                                )->wait();
                            },
                            function ($exception) use ($number_phone): void {
                                self::sendTextMessage($number_phone, $exception->getMessage());
                            }
                        )->wait();
                        break;
                    } catch (GuzzleException $e) {
                        self::sendTextMessage($number_phone, $e->getMessage());
                    } catch (ResponseException $e) {

                    }
                } else {
                    self::sendTextMessage($number_phone, Message::NotHaveLetter->value);
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
                }
                break;
        }
        exit;
    }

<<<<<<< HEAD
    public function extractId($command): int
=======
    public function extractIdFromCommand($command): int
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    {
        return (int)preg_replace('/[^0-9]+/', '', $command);
    }

<<<<<<< HEAD
    public function saveOnTempJson(string $fileName, mixed $data, string $folder = "whatsapp-temp"): void
    {
        Storage::put("{$folder}/{$fileName}.json", json_encode($data));
=======
    public function saveContent($from, $data): void
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        if (Storage::exists($file_name)) {
            $current_data = json_decode(Storage::get($file_name), true);
        }
        $data = isset($current_data) ? array_merge($current_data, $data) : $data;
        Storage::put($file_name, json_encode($data));
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    }

    public function existTempEmptyFile($from): bool
    {
        return Storage::exists("whatsapp-temp/" . $from . ".json");
    }

<<<<<<< HEAD
    public function loadFromTempJson(string $fileName, $folder = "whatsapp-temp"): int
    {
        return (int)json_decode(Storage::get("{$folder}/{$fileName}.json"), true)["id"];
=======
    public function loadContent($from)
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        return json_decode(Storage::get($file_name), true);
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    }

    public function deleteContentFile($from): void
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        Storage::delete($file_name);
    }

<<<<<<< HEAD
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
=======
    public function createTempEmptyFile($from): void
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        Storage::put($file_name, json_encode([]));
    }

    private function getMessage($payload)
    {
        $data = json_decode($payload, true);
        return $data["entry"][0]["changes"][0]["value"]["messages"][0] ?? null;
    }

    private function extractAction($text): string
    {
        return Str::slug(Str::of($text)->trim());
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    }

    /**
     * @throws ResponseException
     */
<<<<<<< HEAD
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
=======
    private function executeCommand($from, $command): void
    {
        $id = self::extractIdFromCommand($command);
        $command = self::cleanCommand($command);
        try {
            switch ($command) {
                case WhatsappCommands::ViewNow->value:
                    $answers = Mail::findOrFail($id)->answers;
                    foreach ($answers as $answer) {
                        self::sendTextMessage($from, $answer->content);
                    }
                    self::sendButtonReplyMessage(
                        $from,
                        Message::QuestionReply->value,
                        [new Button(WhatsappCommands::ReplyNow->value . ' ' . $id, WhatsappCommands::ReplyNow->getLabel())]
                    );
                    break;
                case WhatsappCommands::ReplyNow->value:
                    self::sendTextMessage($from, str_replace("%id%", (string)$id, Message::ReplyNow->value));
                    self::saveContent($from, ["id" => $id]);
                    break;
                default:
                    if ($this->existTempEmptyFile($from)) {
                        try {
                            $reply_mail_id = (int)($this->loadContent($from)["id"]);
                            self::sendTextMessage($from, "Ahora, envía una foto que desees compartir con tu auspiciante. 😊📷");
                            Mail::whereId($reply_mail_id)->update(["status" => MailStatus::Replied]);
                            $mail = Mail::findOrFail($reply_mail_id);
                            $mailbox = $mail->mailbox;
                            $mail->status = MailStatus::IsResponse->value;
                            $createdBy = 1;
                            $updatedBy = 1;
                            $mailData = [
                                "mailbox_id" => $mailbox->id,
                                "type" => MailsTypes::Response,
                                "status" => MailStatus::Replied,
                                "reply_mail_id" => $reply_mail_id,
                                "created_by" => $createdBy,
                                "updated_by" => $updatedBy
                            ];
                            $mail = Mail::create($mailData);
                            $answerData = [
                                "mail_id" => $mail->id,
                                "content" => $command,
                                "attached_file_path" => "hola",
                                "created_by" => $createdBy,
                                "updated_by" => $updatedBy
                            ];
                            $answer = Answers::create($answerData);
                            $this->deleteContentFile($from);
                            $this->saveContent($from, ["id" => $answer->id]);
                        } catch (Exception $e) {
                            self::sendTextMessage($from, $e->getMessage());
                        }
                        break;
                    }
                    self::sendTextMessage($from, Message::NotHaveLetter->value);
                    break;
            }
        } catch (ResponseException $e) {
            self::sendTextMessage($from, $e->getMessage());
        }
    }

    private function cleanCommand($command): string
    {
        return trim(preg_replace('/[0-9]+/', '', $command), " ");
    }

    private function validateAction($action): bool
    {
        return in_array($action, WhatsappCommands::forMigration());
    }

    private function getTypeMessage($message)
    {
        return $message["type"] ?? null;
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    }
}
