<?php

namespace Database\Seeders;

use App\Models\JobListing;
use App\Models\EmployerProfile;
use App\Enums\ContractType;
use App\Enums\WorkMode;
use App\Enums\JobListingStatus;
use Illuminate\Database\Seeder;

class JobListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employers = EmployerProfile::all();

        if ($employers->isEmpty()) {
            $this->command->warn('No employers found. Please run UserSeeder first.');
            return;
        }

        $jobTitles = [
            'Senior Laravel Developer',
            'Full Stack Developer',
            'Frontend Developer (React)',
            'DevOps Engineer',
            'Data Scientist',
            'Product Manager',
            'UI/UX Designer',
            'Mobile Developer (iOS)',
            'QA Engineer',
            'System Administrator',
        ];

        $descriptions = [
            'We are looking for an experienced developer to join our team. You will work on challenging projects and collaborate with talented professionals.',
            'Join our growing company and help us build innovative solutions. We offer competitive salary and great benefits.',
            'We are seeking a talented individual to work on cutting-edge technology projects. This is a great opportunity to grow your career.',
            'Help us transform the industry with your expertise. We value innovation and collaboration.',
            'Be part of a dynamic team working on exciting projects. We offer a great work environment and career growth opportunities.',
        ];

        $contractTypes = [
            ContractType::FULL_TIME,
            ContractType::PART_TIME,
            ContractType::CONTRACT,
        ];

        $workModes = [
            WorkMode::REMOTE,
            WorkMode::ON_SITE,
            WorkMode::HYBRID,
        ];

        $skills = [
            ['PHP', 'Laravel', 'MySQL', 'Git', 'Docker'],
            ['React', 'JavaScript', 'TypeScript', 'CSS', 'Node.js'],
            ['Python', 'Machine Learning', 'TensorFlow', 'SQL', 'AWS'],
            ['Kubernetes', 'Docker', 'CI/CD', 'Linux', 'AWS'],
            ['Swift', 'iOS', 'Objective-C', 'Xcode', 'Git'],
        ];

        $locations = [
            ['New York', 'NY'],
            ['Los Angeles', 'CA'],
            ['Chicago', 'IL'],
            ['San Francisco', 'CA'],
            ['Boston', 'MA'],
        ];

        $count = 0;
        foreach ($employers as $employer) {
            for ($i = 0; $i < 3; $i++) {
                $titleIndex = $count % count($jobTitles);
                $location = $locations[$count % count($locations)];

                JobListing::create([
                    'employer_id' => $employer->id,
                    'title' => $jobTitles[$titleIndex],
                    'description' => $descriptions[$count % count($descriptions)],
                    'requirements' => 'Strong communication skills and passion for technology.',
                    'benefits' => 'Competitive salary, health insurance, remote work, professional development.',
                    'position_level' => match($count % 3) {
                        0 => 'entry',
                        1 => 'mid',
                        default => 'senior'
                    },
                    'years_experience_required' => rand(1, 10),
                    'industry_sector' => $employer->industry,
                    'salary_min' => rand(50000, 80000),
                    'salary_max' => rand(90000, 150000),
                    'currency' => 'USD',
                    'salary_period' => 'yearly',
                    'contract_type' => $contractTypes[rand(0, count($contractTypes) - 1)],
                    'work_mode' => $workModes[rand(0, count($workModes) - 1)],
                    'city' => $location[0],
                    'state' => $location[1],
                    'country' => 'United States',
                    'required_skills' => $skills[$count % count($skills)],
                    'nice_to_have_skills' => ['Communication', 'Team Player', 'Problem Solver'],
                    'tags' => ['tech', 'hiring', 'remote'],
                    'status' => JobListingStatus::ACTIVE->value,
                    'vacancy_count' => rand(1, 5),
                    'posted_at' => now()->subDays(rand(0, 30)),
                    'deadline_at' => now()->addDays(rand(10, 60)),
                ]);

                $count++;
            }
        }

        $this->command->info("Created {$count} job listings successfully!");
    }
}
