<?php

namespace App\Services;

use App\Models\EmployerProfile;
use App\Models\User;

class EmployerService
{
    /**
     * Create an employer profile
     */
    public function create(User $user, array $data): EmployerProfile
    {
        $data['user_id'] = $user->id;
        $data['is_verified'] = false;

        return EmployerProfile::create($data);
    }

    /**
     * Update employer profile
     */
    public function update(EmployerProfile $profile, array $data): EmployerProfile
    {
        $profile->update($data);
        return $profile->refresh();
    }

    /**
     * Upload company logo
     */
    public function uploadLogo(EmployerProfile $profile, $file): string
    {
        $path = $file->store('logos', 'public');
        $profile->update(['logo_url' => $path]);
        return $path;
    }

    /**
     * Verify employer profile
     */
    public function verify(EmployerProfile $profile, string $notes = ''): void
    {
        $profile->update([
            'is_verified' => true,
            'verification_notes' => $notes,
        ]);
    }

    /**
     * Get employer by user
     */
    public function getByUser(User $user): ?EmployerProfile
    {
        return $user->employerProfile;
    }

    /**
     * Get employer statistics
     */
    public function getStatistics(EmployerProfile $profile): array
    {
        $jobListingService = app(JobListingService::class);
        return $jobListingService->getEmployerStats($profile);
    }

    /**
     * Get recent applications
     */
    public function getRecentApplications(EmployerProfile $profile, int $days = 30, int $limit = 10)
    {
        return $profile->jobListings()
            ->with('applications')
            ->get()
            ->flatMap->applications
            ->where('applied_at', '>=', now()->subDays($days))
            ->sortByDesc('applied_at')
            ->take($limit);
    }

    /**
     * Get active positions
     */
    public function getActivePositions(EmployerProfile $profile)
    {
        return $profile->jobListings()
            ->where('status', 'active')
            ->orderBy('posted_at', 'desc')
            ->get();
    }

    /**
     * Get employer profile summary
     */
    public function getProfileSummary(EmployerProfile $profile): array
    {
        return [
            'company_name' => $profile->company_name,
            'industry' => $profile->industry,
            'employees' => $profile->employee_count,
            'active_listings' => $profile->getActiveJobCount(),
            'total_applications' => $profile->getTotalApplications(),
            'is_verified' => $profile->is_verified,
            'created_at' => $profile->created_at,
        ];
    }
}
