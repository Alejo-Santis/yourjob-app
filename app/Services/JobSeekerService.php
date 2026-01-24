<?php

namespace App\Services;

use App\Models\JobSeekerProfile;
use App\Models\User;

class JobSeekerService
{
    /**
     * Create a job seeker profile
     */
    public function create(User $user, array $data): JobSeekerProfile
    {
        $data['user_id'] = $user->id;
        $data['profile_completion_percentage'] = 0;

        return JobSeekerProfile::create($data);
    }

    /**
     * Update job seeker profile
     */
    public function update(JobSeekerProfile $profile, array $data): JobSeekerProfile
    {
        $profile->update($data);

        // Recalculate completion percentage
        $profile->profile_completion_percentage = $profile->calculateProfileCompletion();
        $profile->save();

        return $profile->refresh();
    }

    /**
     * Upload CV
     */
    public function uploadCV(JobSeekerProfile $profile, $file): string
    {
        $path = $file->store('cvs', 'public');
        $profile->update(['cv_url' => $path]);
        return $path;
    }

    /**
     * Add skills
     */
    public function addSkills(JobSeekerProfile $profile, array $skills): void
    {
        $currentSkills = $profile->skills ?? [];
        $newSkills = array_unique(array_merge($currentSkills, $skills));

        $profile->update(['skills' => $newSkills]);
    }

    /**
     * Remove skill
     */
    public function removeSkill(JobSeekerProfile $profile, string $skill): void
    {
        $skills = $profile->skills ?? [];
        $skills = array_filter($skills, fn($s) => $s !== $skill);

        $profile->update(['skills' => array_values($skills)]);
    }

    /**
     * Add languages
     */
    public function addLanguages(JobSeekerProfile $profile, array $languages): void
    {
        $currentLanguages = $profile->languages ?? [];
        $newLanguages = array_unique(array_merge($currentLanguages, $languages));

        $profile->update(['languages' => $newLanguages]);
    }

    /**
     * Get job seeker by user
     */
    public function getByUser(User $user): ?JobSeekerProfile
    {
        return $user->jobSeekerProfile;
    }

    /**
     * Get matching jobs for seeker
     */
    public function getMatchingJobs(JobSeekerProfile $profile, int $limit = 10)
    {
        $matchingService = app(JobMatchingService::class);
        return $matchingService->findBestMatches($profile, $limit);
    }

    /**
     * Get recommended jobs
     */
    public function getRecommendedJobs(JobSeekerProfile $profile, int $limit = 5)
    {
        return $profile->jobMatches()
            ->where('status', 'active')
            ->where('match_score', '>=', 75)
            ->orderBy('match_score', 'desc')
            ->limit($limit)
            ->get()
            ->pluck('jobListing');
    }

    /**
     * Validate profile completeness
     */
    public function isProfileComplete(JobSeekerProfile $profile): bool
    {
        return $profile->profile_completion_percentage >= 80;
    }

    /**
     * Get profile summary
     */
    public function getProfileSummary(JobSeekerProfile $profile): array
    {
        return [
            'name' => $profile->full_name,
            'profession' => $profile->profession,
            'experience' => $profile->total_years_experience,
            'skills_count' => count($profile->skills ?? []),
            'applications' => $profile->applications()->count(),
            'favorites' => $profile->favorites()->count(),
            'completion' => $profile->profile_completion_percentage,
        ];
    }
}
