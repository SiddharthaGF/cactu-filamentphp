<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Users Management',
            'Coordinators Management',
            'Managers Management',
            'Communities Management',
            'Children Management',
        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
        Role::findByName('SYSTEM')->syncPermissions(Permission::all());
    }
}
