<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::create([
            'name' => 'Galvenais Administrators',
            'email' => 'admin@a',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        Team::factory()->count(4)
            ->has(Player::factory()->count(7))
            ->create();
    }
}
