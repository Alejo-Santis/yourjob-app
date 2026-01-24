<?php

namespace App\Services;

use App\Models\Application;
use App\Models\JobListing;
use App\Models\JobSeekerProfile;
use App\Models\JobMatch;
use Illuminate\Database\Eloquent\Collection;

class JobMatchingService
{
    /**
     * Calculate match score between a job seeker and a job listing
     */
    public function calculateMatch(JobSeekerProfile $seeker, JobListing $listing): int
    {
        $skillsScore = $this->calculateSkillsMatch($seeker, $listing);
        $experienceScore = $this->calculateExperienceMatch($seeker, $listing);
        $locationScore = $this->calculateLocationMatch($seeker, $listing);
        $salaryScore = $this->calculateSalaryMatch($seeker, $listing);

        // Weighted average
        $matchScore = (
            ($skillsScore * 0.40) +
            ($experienceScore * 0.25) +
            ($locationScore * 0.20) +
            ($salaryScore * 0.15)
        );

        return (int)round($matchScore);
    }

    /**
     * Calculate skills match percentage
     */
    private function calculateSkillsMatch(JobSeekerProfile $seeker, JobListing $listing): int
    {
        $requiredSkills = $listing->required_skills ?? [];
        $seekerSkills = $seeker->skills ?? [];

        if (empty($requiredSkills)) {
            return 100;
        }

        $matched = 0;
        foreach ($requiredSkills as $skill) {
            if (in_array($skill, $seekerSkills)) {
                $matched++;
            }
        }

        return (int)round(($matched / count($requiredSkills)) * 100);
    }

    /**
     * Calculate experience match percentage
     */
    private function calculateExperienceMatch(JobSeekerProfile $seeker, JobListing $listing): int
    {
        $requiredYears = $listing->years_experience_required ?? 0;
        $seekerYears = $seeker->total_years_experience ?? 0;

        if ($seekerYears >= $requiredYears) {
            return 100;
        }

        if ($requiredYears === 0) {
            return 100;
        }

        return (int)(($seekerYears / $requiredYears) * 100);
    }

    /**
     * Calculate location match percentage
     */
    private function calculateLocationMatch(JobSeekerProfile $seeker, JobListing $listing): int
    {
        // Full score for remote
        if ($listing->work_mode === 'remote') {
            return 100;
        }

        // Partial score for hybrid
        if ($listing->work_mode === 'hybrid') {
            return 75;
        }

        // Check if cities match
        if (strtolower($seeker->city) === strtolower($listing->city)) {
            return 100;
        }

        // Same state/region
        if (strtolower($seeker->state) === strtolower($listing->state)) {
            return 60;
        }

        return 30;
    }

    /**
     * Calculate salary match percentage
     */
    private function calculateSalaryMatch(JobSeekerProfile $seeker, JobListing $listing): int
    {
        $seekerMin = $seeker->expected_salary_min ?? 0;
        $seekerMax = $seeker->expected_salary_max ?? 999999;
        $jobMin = $listing->salary_min ?? 0;
        $jobMax = $listing->salary_max ?? 999999;

        // If salary not specified in job, it's a match
        if (is_null($listing->salary_min) && is_null($listing->salary_max)) {
            return 75;
        }

        // If salary expectations not set, neutral
        if (is_null($seeker->expected_salary_min) && is_null($seeker->expected_salary_max)) {
            return 50;
        }

        // Check if ranges overlap
        if ($jobMax >= $seekerMin && $jobMin <= $seekerMax) {
            return 100;
        }

        // Check if close (within 20%)
        $margin = ($seekerMax - $seekerMin) * 0.20;
        if ($jobMin <= ($seekerMax + $margin) && $jobMax >= ($seekerMin - $margin)) {
            return 70;
        }

        return 40;
    }

    /**
     * Find best matches for a job seeker
     */
    public function findBestMatches(JobSeekerProfile $seeker, int $limit = 10, int $minScore = 50): Collection
    {
        $listings = JobListing::where('status', 'active')->get();
        $matches = [];

        foreach ($listings as $listing) {
            $score = $this->calculateMatch($seeker, $listing);
            if ($score >= $minScore) {
                $matches[] = [
                    'listing' => $listing,
                    'score' => $score,
                ];
            }
        }

        // Sort by score descending
        usort($matches, fn($a, $b) => $b['score'] <=> $a['score']);

        return collect($matches)->take($limit)->pluck('listing');
    }

    /**
     * Create or update job match record
     */
    public function createOrUpdateMatch(JobSeekerProfile $seeker, JobListing $listing): JobMatch
    {
        $matchScore = $this->calculateMatch($seeker, $listing);

        return JobMatch::updateOrCreate(
            [
                'job_seeker_id' => $seeker->id,
                'job_listing_id' => $listing->id,
            ],
            [
                'match_score' => $matchScore,
                'skills_match_score' => $this->calculateSkillsMatch($seeker, $listing),
                'experience_match_score' => $this->calculateExperienceMatch($seeker, $listing),
                'location_match_score' => $this->calculateLocationMatch($seeker, $listing),
                'salary_match_score' => $this->calculateSalaryMatch($seeker, $listing),
                'status' => 'active',
                'matched_at' => now(),
            ]
        );
    }

    /**
     * Generate all matches for a job seeker
     */
    public function generateAllMatches(JobSeekerProfile $seeker): void
    {
        $listings = JobListing::where('status', 'active')->get();

        foreach ($listings as $listing) {
            $this->createOrUpdateMatch($seeker, $listing);
        }
    }
}
