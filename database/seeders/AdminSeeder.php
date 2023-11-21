<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => env('NAME_ADMIN', env('MAIL_ADMIN')),
            'password' => Hash::make(env('PASS_ADMIN', env('MAIL_ADMIN'))),
            'email' => env('MAIL_ADMIN'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
