<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Seeder;

final class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communities = [
            [
                'name' => 'GUAYTACAMA NORTE',
                'zone_code' => '050153',
            ],
            [
                'name' => 'POALÓ',
                'zone_code' => '050158',
            ],
            [
                'name' => 'GUAYTACAMA',
                'zone_code' => '050153',
            ],
            [
                'name' => 'IGNACIO FLORES',
                'zone_code' => '050102',
            ],
            [
                'name' => 'POALÓ NORTE',
                'zone_code' => '050158',
            ],
            [
                'name' => 'PASTOCALLE NORTE',
                'zone_code' => '050159',
            ],
            [
                'name' => 'PASTOCALLE ESTE',
                'zone_code' => '050159',
            ],
            [
                'name' => 'CHANTILÍN',
                'zone_code' => '050409',
            ],
            [
                'name' => 'SANTO SAMANA',
                'zone_code' => '050153',
            ],
            [
                'name' => 'GUAYTACAMA SUR',
                'zone_code' => '050153',
            ],
            [
                'name' => 'PASTOCALLE',
                'zone_code' => '050159',
            ],
            [
                'name' => 'ANGAMARCA',
                'zone_code' => '050451',
            ],
            [
                'name' => 'CRUZ LOMA',
                'zone_code' => '050409',
            ],
            [
                'name' => 'CEVALLOS',
                'zone_code' => '050153',
            ],
            [
                'name' => 'SAN JUAN PASTOCALLE - PTFM',
                'zone_code' => '050159',
            ],
            [
                'name' => 'SAN JUAN PASTOCALLE - PTFM1',
                'zone_code' => '050159',
            ],
        ];
        foreach ($communities as $community) {
            Community::create([
                'name' => $community['name'],
                'zone_code' => $community['zone_code'],
                'created_by' => 1,
                'updated_by' => 1,

            ]);
        }
    }
}
