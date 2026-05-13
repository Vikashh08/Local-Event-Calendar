<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Seed Categories (safe to re-run) ---
        $categories = ['Music', 'Sports', 'Food & Drink', 'Arts & Culture', 'Technology', 'Networking', 'Fitness', 'Education'];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        // --- Seed a default test user (safe to re-run) ---
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'     => 'Test User',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        // --- Seed a default admin user (safe to re-run) ---
        User::firstOrCreate(
            ['email' => 'admin@lecs.com'],
            [
                'name'     => 'LECS Admin',
                'password' => Hash::make('admin@123'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Done! Default admin: admin@lecs.com / admin@123');
    }
}
