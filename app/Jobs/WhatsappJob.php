<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Enums\Message;
use App\Enums\WhatsappCommands;
use App\Models\Answers;
use App\Models\Mail;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
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

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->payload = file_get_contents('php://input');
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
                }
                break;
        }
        exit;
    }

    public function extractIdFromCommand($command): int
    {
        return (int)preg_replace('/[^0-9]+/', '', $command);
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

    public function existTempEmptyFile($from): bool
    {
        return Storage::exists("whatsapp-temp/" . $from . ".json");
    }

    public function loadContent($from)
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        return json_decode(Storage::get($file_name), true);
    }

    public function deleteContentFile($from): void
    {
        $file_name = "whatsapp-temp/" . $from . ".json";
        Storage::delete($file_name);
    }

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
    }

    /**
     * @throws ResponseException
     */
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
    }
}
