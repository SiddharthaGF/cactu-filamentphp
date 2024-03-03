<?php

declare(strict_types=1);

use App\Whatsapp\Whatsapp;
use Netflie\WhatsAppCloudApi\WebHook;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

function whatsapp(): WhatsAppCloudApi
{
    return new WhatsAppCloudApi([
        'from_phone_number_id' => env('WHATSAPP_API_PHONE_NUMBER_ID'),
        'access_token' => env('WHATSAPP_API_TOKEN'),
    ]);
}

function webhook(): string
{
    $webhook = new WebHook();

    return $webhook->verify($_GET, env('WHATSAPP_API_TOKEN_VERIFICATION'));
}

function receiveWhatsapp(mixed $payload)
{
    return new Whatsapp($payload);
}
