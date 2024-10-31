<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'role_id' => null,
            'rank_id' => null,
            'name' => env('NAME'),
            'username' => env('USERNAMES'),
            'email' => env('EMAIL'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('PASSWORD')),
        ]);
    }
}