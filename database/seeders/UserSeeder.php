<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Mushe Abdul-Hakim',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('super-admin');
    }
}
