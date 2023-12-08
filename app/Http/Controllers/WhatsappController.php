<?php

namespace App\Http\Controllers;

use App\Enums\ElementLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WhatsappController extends Controller
{
    public function send($number_phone, Request $request): void
    {
        $text = $request->input('text');
        $token = env('WHATSAPP_API_TOKEN');
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ];
        $message = '
            {
                "messaging_product": "whatsapp",
                "to": "' . $number_phone . '",
                "type": "text",
                "text": {
                    "body": "' . $text . '"
                }
            }
        ';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('WHATSAPP_API_URL'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    public function webhook(): void
    {
        $token = env('WHATSAPP_API_TOKEN_VERIFICATION');
        $hub_challenge = $_GET['hub_challenge'] ?? '';
        $hub_verify_token = $_GET['hub_verify_token'] ?? '';
        if ($hub_verify_token === $token) {
            echo $hub_challenge;
            exit;
        }
    }

    public function receive(): void
    {
        $response = file_get_contents('php://input');
        $response = json_decode($response, true);
        if (!isset($response["entry"][0]["changes"][0]["value"]["messages"][0])) exit;
        $response = $response["entry"][0]["changes"][0]["value"]["messages"][0];
        $sender = $response["from"];
        $message = $response["text"]["body"];
        $separator = strpos($message, ":");
        $prompt = Str::slug(substr($message, 0, $separator), "-");
        if (!in_array($prompt, ElementLetter::forMigration())) {
            $this->send($sender, "No se reconoce el comando: " . $prompt);
            exit;
        }
        $message = substr($message, $separator + 1);
        $timestamp = $response["timestamp"];
        $type = $response["type"];
        $file_name = "whatsapp-temp/" . $sender . ".json";
        $new_data = [
            $prompt => [
                "type" => $type,
                "message" => $message,
                "timestamp" => $timestamp,
            ]
        ];
        if (Storage::exists($file_name)) $current_data = json_decode(Storage::get($file_name), true);
        $data = isset($current_data) ? array_merge($current_data, $new_data) : $new_data;
        Storage::put($file_name, json_encode($data));
    }
}
