<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndAdminSeeder extends Seeder
{
    public function run()
    {
        // ساخت نقش‌ها با guard_name
        $roles = ['super-admin', 'admin', 'manager', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web', // 👈 این را فراموش نکن
            ]);
        }

        // ساخت سوپر ادمین
        $admin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
            ]
        );

        // اختصاص دادن نقش به سوپر ادمین
        $admin->assignRole('super-admin');

        $this->command->info('Roles + Super Admin created successfully.');
    }
}