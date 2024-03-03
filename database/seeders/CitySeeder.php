<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

final class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $allowedCodesCommunities = State::pluck('code')->all();

        foreach ($allowedCodesCommunities as $code) {
            $client = new Client();
            $response = $client->get('https://polaris-sage.vercel.app/api/v1/dpa/'.$code);
            $cities = json_decode($response->getBody()->getContents(), true);

            foreach ($cities as $cityIndex => $city) {

                City::firstOrCreate([
                    'name' => $city['name'],
                    'code' => $city['code'],
                    'state_code' => $code,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
    }
}
