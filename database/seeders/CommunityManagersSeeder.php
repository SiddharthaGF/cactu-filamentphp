<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CommunityManagers;
use Illuminate\Database\Seeder;

final class CommunityManagersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommunityManagers::factory()->count(5)->create();
    }
}
