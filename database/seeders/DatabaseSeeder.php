<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions and roles first
        $this->call(PermissionSeeder::class);

        // Create users and profiles
        $this->call(UserSeeder::class);

        // Create job listings
        $this->call(JobListingSeeder::class);

        $this->command->info('Database seeding completed successfully!');
    }
}
