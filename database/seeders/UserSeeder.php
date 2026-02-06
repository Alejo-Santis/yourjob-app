<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobSeekerProfile;
use App\Models\EmployerProfile;
use App\Enums\UserType;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@yourjob.test'],
            [
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'user_type' => UserType::ADMIN,
                'is_active' => true,
            ]
        );
        $adminUser->assignRole('admin');

        // Create Job Seeker Users
        for ($i = 1; $i <= 5; $i++) {
            $seekerUser = User::firstOrCreate(
                ['email' => "seeker{$i}@yourjob.test"],
                [
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'user_type' => UserType::JOB_SEEKER,
                    'is_active' => true,
                ]
            );
            $seekerUser->assignRole('job_seeker');

            // Create corresponding job seeker profile
            JobSeekerProfile::firstOrCreate(
                ['user_id' => $seekerUser->id],
                [
                    'full_name' => "Job Seeker {$i}",
                    'email' => "seeker{$i}@yourjob.test",
                    'phone' => '555-000-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'city' => match($i % 3) {
                        0 => 'New York',
                        1 => 'Los Angeles',
                        default => 'Chicago'
                    },
                    'state' => match($i % 3) {
                        0 => 'NY',
                        1 => 'CA',
                        default => 'IL'
                    },
                    'country' => 'United States',
                    'profession' => match($i % 4) {
                        0 => 'Software Engineer',
                        1 => 'Product Manager',
                        2 => 'Data Scientist',
                        default => 'UX Designer'
                    },
                    'total_years_experience' => rand(1, 10),
                    'skills' => json_encode(['PHP', 'Laravel', 'JavaScript', 'React', 'MySQL']),
                    'education_level' => 'Bachelor',
                    'expected_salary_min' => 50000,
                    'expected_salary_max' => 120000,
                    'profile_completion_percentage' => rand(60, 100),
                ]
            );
        }

        // Create Employer Users
        for ($i = 1; $i <= 3; $i++) {
            $employerUser = User::firstOrCreate(
                ['email' => "employer{$i}@yourjob.test"],
                [
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'user_type' => UserType::EMPLOYER,
                    'is_active' => true,
                ]
            );
            $employerUser->assignRole('employer');

            // Create corresponding employer profile
            EmployerProfile::firstOrCreate(
                ['user_id' => $employerUser->id],
                [
                    'company_name' => "Tech Company {$i}",
                    'company_website' => "https://company{$i}.com",
                    'industry' => match($i % 3) {
                        0 => 'Technology',
                        1 => 'Finance',
                        default => 'E-Commerce'
                    },
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'country' => 'United States',
                    'employee_count' => rand(10, 500),
                    'company_size' => match($i) {
                        1 => 'small',
                        2 => 'medium',
                        default => 'large'
                    },
                    'phone' => '415-555-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'is_verified' => true,
                ]
            );
        }

        $this->command->info('Users and profiles have been created successfully!');
    }
}
