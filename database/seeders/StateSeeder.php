<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

final class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allowedCodes = ['05', '18'];

        $client = new Client();
        $response = $client->get('https://polaris-sage.vercel.app/api/v1/dpa');
        $states = json_decode($response->getBody()->getContents(), true);

        foreach ($states as $state) {

            if ( ! in_array($state['code'], $allowedCodes)) {
                continue;
            }

            State::firstOrCreate([
                'name' => $state['name'],
                'code' => $state['code'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
