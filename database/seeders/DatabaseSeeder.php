<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(AdminSeeder::class);
        $this->call(LocalPartnerSeeder::class);
        //$this->call(UserSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        sleep(1);
        $this->call(ZoneSeeder::class);
        sleep(1);
        $this->call(CommunitySeeder::class);
        sleep(1);
        //$this->call(CommunityManagersSeeder::class);
    }
}
