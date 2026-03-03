<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan role ada
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        // bikin atau ambil user kalau sudah ada
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'], // cek berdasarkan email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Password123!'),
                'status' => 'active',
            ]
        );

        // pastikan role ter-assign (tanpa duplikat)
        if (!$user->hasRole('super-admin')) {
            $user->assignRole($role);
        }
    }
}