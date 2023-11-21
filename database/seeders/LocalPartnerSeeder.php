<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LocalPartner;
use Illuminate\Database\Seeder;

final class LocalPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LocalPartner::create([
            'name' => 'Corporación de Asociaciones de Cotopaxi y Tungurahua',
            'alias' => 'CACTU',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
