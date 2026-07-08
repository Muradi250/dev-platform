<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ ساخت نقش‌ها (استاندارد Spatie)
        $roles = ['super-admin', 'admin', 'manager', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        // ✅ ساخت سوپر ادمین استاندارد
        $superAdmin = User::firstOrCreate(
            ['email' => 'Amuradi250@gmail.com'],
            [
                'name' => 'super admin',
                'password' => bcrypt('Amuradi25000@@@'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super-admin');

        // ✅ ساخت کاربر تست (بدون خطا هنگام اجرای مجدد seeder)
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole('user');
    }
}