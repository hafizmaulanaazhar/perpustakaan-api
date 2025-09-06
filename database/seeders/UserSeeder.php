<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();
        User::create([
            'name' => 'Test User',
            'email' => 'marco@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
