<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Example: Create a single specific user (useful for a known login)
        User::factory()->create([
            'fname' => 'John',
            'lname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'), // Always hash passwords!
        ]);
        // Example: Create 50 random users
        User::factory()->count(50)->create();
    }
}
