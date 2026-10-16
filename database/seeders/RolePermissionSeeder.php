<?php

namespace Database\Seeders;

use App\Authorization\PermissionRegistry;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permission Groups
        |--------------------------------------------------------------------------
        */

        $allPermissions = array_keys(
            PermissionRegistry::all()
        );

        $adminPermissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            'roles.view',
            'roles.create',
            'roles.edit',

            'pages.view',
            'pages.create',
            'pages.edit',

            'testimonials.view',
            'testimonials.create',
            'testimonials.edit',
        ];

        $managerPermissions = [
            'users.view',

            'pages.view',
            'pages.create',
            'pages.edit',

            'testimonials.view',
            'testimonials.create',
            'testimonials.edit',
        ];

        $userPermissions = [
            'users.view',

            'pages.view',

            'testimonials.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $superAdmin->syncPermissions($allPermissions);

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions($adminPermissions);

        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

        $manager = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);

        $manager->syncPermissions($managerPermissions);

        /*
        |--------------------------------------------------------------------------
        | User
        |--------------------------------------------------------------------------
        */

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        $user->syncPermissions($userPermissions);

        /*
        |--------------------------------------------------------------------------
        | Clear Permission Cache
        |--------------------------------------------------------------------------
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info(
            'Role permissions synchronized successfully.'
        );
    }
}