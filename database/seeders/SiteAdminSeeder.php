<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiteAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('app.site_manager_email', 'admin@icbarendrecht.nl');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Site beheerder',
                'password' => Hash::make('Icbb@2026'),
                'role' => User::ROLE_ADMIN,
            ]
        );
    }
}

