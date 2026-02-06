<?php

namespace App\Services;

use App\Models\Application;
use App\Models\JobListing;
use App\Models\JobSeekerProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ApplicationService
{
    /**
     * Create a new application
     */
    public function create(JobSeekerProfile $seeker, JobListing $listing, array $data): Application
    {
        // Check if already applied
        $existing = Application::where('job_seeker_id', $seeker->id)
            ->where('job_listing_id', $listing->id)
            ->first();

        if ($existing) {
            throw new \Exception('You have already applied for this job');
        }

        $application = new Application($data);
        $application->job_seeker_id = $seeker->id;
        $application->job_listing_id = $listing->id;
        $application->applied_at = now();
        $application->status = 'pending';
        $application->save();

        // Increment applications count
        $listing->increment('applications_count');

        return $application;
    }

    /**
     * Withdraw an application
     */
    public function withdraw(Application $application): void
    {
        $application->update(['status' => 'withdrawn']);
    }

    /**
     * Accept an application by employer
     */
    public function accept(Application $application, string $message = ''): void
    {
        $application->accept($message);
    }

    /**
     * Reject an application by employer
     */
    public function reject(Application $application, string $message = ''): void
    {
        $application->reject($message);
    }

    /**
     * Get applications for a job listing
     */
    public function getApplicationsForListing(JobListing $listing, string|null $status = null): Collection
    {
        $query = $listing->applications();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('applied_at', 'desc')->get();
    }

    /**
     * Get applications query for a job seeker
     */
    public function getApplicationsForSeeker(JobSeekerProfile $seeker)
    {
        return $seeker->applications()->with(['jobListing', 'jobListing.employer'])->orderBy('applied_at', 'desc');
    }

    /**
     * Get recent applications
     */
    public function getRecentApplications(int $days = 7, int $limit = 10): Collection
    {
        return Application::whereHas('jobListing', function ($query) {
            $query->where('employer_id', Auth::user()->employerProfile->id);
        })
            ->where('applied_at', '>=', now()->subDays($days))
            ->orderBy('applied_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mark application as viewed
     */
    public function markAsViewed(Application $application): void
    {
        $application->markAsViewed();
    }

    /**
     * Get statistics for applications
     */
    public function getStatistics(JobListing $listing): array
    {
        $applications = $listing->applications();

        return [
            'total' => $applications->count(),
            'pending' => $applications->where('status', 'pending')->count(),
            'accepted' => $applications->where('status', 'accepted')->count(),
            'rejected' => $applications->where('status', 'rejected')->count(),
            'withdrawn' => $applications->where('status', 'withdrawn')->count(),
            'viewed' => $applications->where('view_count', '>', 0)->count(),
        ];
    }
}
