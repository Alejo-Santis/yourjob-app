<?php

namespace App\Services;

use App\Models\JobListing;
use App\Models\EmployerProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class JobListingService
{
    /**
     * Create a new job listing
     */
    public function create(EmployerProfile $employer, array $data): JobListing
    {
        $data['employer_id'] = $employer->id;
        $data['status'] = 'draft';

        return JobListing::create($data);
    }

    /**
     * Update a job listing
     */
    public function update(JobListing $listing, array $data): JobListing
    {
        $listing->update($data);
        return $listing->refresh();
    }

    /**
     * Publish a job listing
     */
    public function publish(JobListing $listing, array $data = []): JobListing
    {
        $data['status'] = 'active';
        $data['posted_at'] = $data['posted_at'] ?? now();

        return $this->update($listing, $data);
    }

    /**
     * Close a job listing
     */
    public function close(JobListing $listing, string $reason = 'closed'): JobListing
    {
        return $this->update($listing, [
            'status' => $reason, // 'closed', 'filled', 'archived'
            'closed_at' => now(),
        ]);
    }

    /**
     * Get active listings
     */
    public function getActive(): Collection
    {
        return JobListing::active()->get();
    }

    /**
     * Search job listings
     */
    public function search(array $filters): Builder
    {
        $query = JobListing::active();

        if (!empty($filters['title'])) {
            $query->searchByTitle($filters['title']);
        }

        if (!empty($filters['work_mode'])) {
            $query->byWorkMode($filters['work_mode']);
        }

        if (!empty($filters['contract_type'])) {
            $query->byContractType($filters['contract_type']);
        }

        if (!empty($filters['city'])) {
            $query->byLocation($filters['city'], $filters['state'] ?? null);
        }

        if (!empty($filters['industry'])) {
            $query->byIndustry($filters['industry']);
        }

        if (!empty($filters['salary_min'])) {
            $query->where('salary_max', '>=', $filters['salary_min']);
        }

        if (!empty($filters['salary_max'])) {
            $query->where('salary_min', '<=', $filters['salary_max']);
        }

        return $query->orderBy('posted_at', 'desc');
    }

    /**
     * Get trending jobs
     */
    public function getTrending(int $limit = 10): Collection
    {
        return JobListing::active()
            ->recentlyPosted(30)
            ->orderBy('applications_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get featured jobs
     */
    public function getFeatured(int $limit = 5): Collection
    {
        return JobListing::active()
            ->orderBy('applications_count', 'desc')
            ->orderBy('posted_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get listings query by employer
     */
    public function getByEmployer(EmployerProfile $employer, string $status = null)
    {
        $query = $employer->jobListings();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('posted_at', 'desc');
    }

    /**
     * Auto-close expired listings
     */
    public function closeExpiredListings(): int
    {
        $listings = JobListing::where('status', 'active')
            ->whereNotNull('deadline_at')
            ->where('deadline_at', '<', now())
            ->get();

        $count = 0;
        foreach ($listings as $listing) {
            $this->close($listing, 'closed');
            $count++;
        }

        return $count;
    }

    /**
     * Get job listing statistics for employer
     */
    public function getEmployerStats(EmployerProfile $employer): array
    {
        $listings = $employer->jobListings();

        return [
            'total' => $listings->count(),
            'active' => $listings->where('status', 'active')->count(),
            'draft' => $listings->where('status', 'draft')->count(),
            'closed' => $listings->where('status', 'closed')->count(),
            'filled' => $listings->where('status', 'filled')->count(),
            'total_applications' => $employer->getTotalApplications(),
            'avg_applications' => $employer->getAverageApplicationsPerJob(),
        ];
    }
}
