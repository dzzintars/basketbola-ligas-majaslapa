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
            'name' => 'Admins',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345677'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Tiesnesis Andris',
            'email' => 'andris@gmail.com',
            'password' => Hash::make('12345677'),
            'role' => 'referee',
        ]);

        User::create([
            'name' => 'Tiesnesis Jānis',
            'email' => 'janis@gmail.com',
            'password' => Hash::make('12345677'),
            'role' => 'referee',
        ]);

        Team::factory()->count(4)
            ->has(Player::factory()->count(7))
            ->create();
    }
}
