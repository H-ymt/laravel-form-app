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
        if (app()->environment('local', 'testing')) {
            \App\Models\User::factory()->create([
                'name' => env('ADMIN_NAME', 'Test Admin'),
                'email' => env('ADMIN_EMAIL', 'admin@example.com'),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]);

            // \App\Models\FormEntry::factory(50)->create();
        }
    }
}
