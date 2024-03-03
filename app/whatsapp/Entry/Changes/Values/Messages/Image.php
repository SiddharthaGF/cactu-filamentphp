<?php

declare(strict_types=1);

namespace App\Whatsapp\Entry\Changes\Values\Messages;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;

final class Image
{
    private string $mimeType;

    private string $sha256;

    private int $id;

    public function __construct(mixed $payload)
    {
        $this->mimeType = $payload['mime_type'];
        $this->sha256 = $payload['sha256'];
        $this->id = (int) ($payload['id']);
    }

    public function mimeType(): string
    {
        return $this->mimeType;
    }

    public function sha256(): string
    {
        return $this->sha256;
    }

    public function save(): PromiseInterface
    {
        $media_id = $this->id;
        $token = env('WHATSAPP_API_TOKEN');
        $url = "https://graph.facebook.com/v19.0/{$media_id}/";
        $headers = ['Authorization' => "Bearer {$token}"];
        $client = new Client();
        $request = new Request('GET', $url, $headers);

        return $client->sendAsync($request)->then(
            function ($response) use ($media_id, $headers): PromiseInterface {
                $url = json_decode($response->getBody()->getContents(), true)['url'];
                $client = new Client();
                $request = new Request('GET', $url, $headers);

                return $client->sendAsync($request)->then(
                    function ($response) use ($media_id): string {
                        $path = "public/{$media_id}.jpg";
                        Storage::put($path, $response->getBody());

                        return $path;
                    }
                );
            }
        );
    }

    public function id(): int
    {
        return $this->id;
    }
}
