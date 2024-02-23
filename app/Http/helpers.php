<?php

declare(strict_types=1);

<<<<<<< HEAD
use App\Whatsapp\Entry;
=======
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
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
<<<<<<< HEAD

function receiveWhatsapp(string|false $payload)
{
    return new Entry($payload['entry']);
}
=======
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
