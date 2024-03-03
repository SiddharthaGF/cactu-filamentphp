<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use App\Models\Zone;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

final class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allowedCodesCities = City::pluck('code')->all();

        foreach ($allowedCodesCities as $code) {
            $client = new Client();
            $response = $client->get('https://polaris-sage.vercel.app/api/v1/dpa/'.$code);
            $zones = json_decode($response->getBody()->getContents(), true);

            foreach ($zones as $cityIndex => $zone) {
                // Almacenar la ciudad si no existe
                Zone::firstOrCreate([
                    'name' => $zone['name'],
                    'code' => $zone['code'],
                    'city_code' => $code,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
    }
}
