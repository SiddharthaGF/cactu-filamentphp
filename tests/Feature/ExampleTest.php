<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Whatsapp\Whatsapp;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {

        $json = '{
            "object": "whatsapp_business_account",
            "entry": [
                {
                    "id": "240297092497020",
                    "changes": [
                        {
                            "value": {
                                "messaging_product": "whatsapp",
                                "metadata": {
                                    "display_phone_number": "15551335615",
                                    "phone_number_id": "255764720944895"
                                },
                                "contacts": [
                                    {
                                        "profile": {
                                            "name": "James"
                                        },
                                        "wa_id": "593960800736"
                                    }
                                ],
                                "messages": [
                                    {
                                        "from": "593960800736",
                                        "id": "wamid.HBgMNTkzOTYwODAwNzM2FQIAEhggNkQ1REUxMDA0NTI5N0VFMzkyQkYyMDM1QzJFOTI5MTQA",
                                        "timestamp": "1708725160",
                                        "text": {
                                            "body": "Holaaa"
                                        },
                                        "type": "text"
                                    }
                                ]
                            },
                            "field": "messages"
                        }
                    ]
                }
            ]
        }';

        $wpp = new Whatsapp($json);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
