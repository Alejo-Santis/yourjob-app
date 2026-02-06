<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\JobSeekerProfile;
use App\Services\JobMatchingService;
use App\Services\JobListingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class JobListingController extends Controller
{
    public function __construct(
        private JobListingService $jobListingService,
        private JobMatchingService $matchingService
    ) {}

    /**
     * Display a listing of all active jobs
     */
    public function index(Request $request)
    {
        $filters = $request->only(['title', 'work_mode', 'contract_type', 'city', 'state', 'industry', 'salary_min', 'salary_max']);
        $jobs = $this->jobListingService->search($filters)->paginate(12);

        return Inertia::render('Jobs/Index', [
            'jobs' => $jobs,
            'filters' => $filters,
        ]);
    }

    /**
     * Show a specific job listing
     */
    public function show(JobListing $listing)
    {
        $listing->load(['employer', 'applications']);

        $user = Auth::user();

        // Mark as viewed if it's the employer
        if (Auth::check() && $user->isEmployer()) {
            $this->markAsViewed($listing);
        }

        $isApplied = false;
        $isFavorited = false;

        if (Auth::check() && $user->isJobSeeker()) {
            $profile = $user->jobSeekerProfile;
            $isApplied = $profile->applications()->where('job_listing_id', $listing->id)->exists();
            $isFavorited = $profile->favorites()->where('job_listing_id', $listing->id)->exists();
        }

        return Inertia::render('Jobs/Show', [
            'job' => $listing,
            'isApplied' => $isApplied,
            'isFavorited' => $isFavorited,
            'matchScore' => $this->getMatchScore($listing),
        ]);
    }

    /**
     * Show the form for creating a new job listing
     */
    public function create()
    {
        Gate::authorize('create-job-listing');

        return Inertia::render('Jobs/Create');
    }

    /**
     * Store a newly created job listing
     */
    public function store(Request $request)
    {
        Gate::authorize('create-job-listing');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'position_level' => 'nullable|string|in:entry,mid,senior,lead',
            'years_experience_required' => 'nullable|integer|min:0',
            'industry_sector' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'salary_period' => 'nullable|string',
            'contract_type' => 'required|string',
            'work_mode' => 'required|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'required_skills' => 'nullable|array',
            'nice_to_have_skills' => 'nullable|array',
            'tags' => 'nullable|array',
            'vacancy_count' => 'nullable|integer|min:1',
            'deadline_at' => 'nullable|date|after:today',
        ]);

        $employer = Auth::user()->employerProfile;
        $job = $this->jobListingService->create($employer, $validated);

        return redirect()->route('jobs.edit', $job)->with('success', 'Job listing created successfully!');
    }

    /**
     * Show the form for editing a job listing
     */
    public function edit(JobListing $listing)
    {
        Gate::authorize('edit-job-listing', $listing);

        return Inertia::render('Jobs/Edit', [
            'job' => $listing,
        ]);
    }

    /**
     * Update a job listing
     */
    public function update(Request $request, JobListing $listing)
    {
        Gate::authorize('edit-job-listing', $listing);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'position_level' => 'nullable|string|in:entry,mid,senior,lead',
            'years_experience_required' => 'nullable|integer|min:0',
            'industry_sector' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'salary_period' => 'nullable|string',
            'contract_type' => 'required|string',
            'work_mode' => 'required|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'required_skills' => 'nullable|array',
            'nice_to_have_skills' => 'nullable|array',
            'tags' => 'nullable|array',
            'vacancy_count' => 'nullable|integer|min:1',
            'deadline_at' => 'nullable|date|after:today',
        ]);

        $this->jobListingService->update($listing, $validated);

        return redirect()->route('jobs.show', $listing)->with('success', 'Job listing updated successfully!');
    }

    /**
     * Publish a job listing
     */
    public function publish(JobListing $listing)
    {
        Gate::authorize('publish-job-listing', $listing);

        $this->jobListingService->publish($listing);

        return redirect()->back()->with('success', 'Job listing published successfully!');
    }

    /**
     * Close a job listing
     */
    public function close(JobListing $listing, Request $request)
    {
        Gate::authorize('close-job-listing', $listing);

        $reason = $request->input('reason', 'closed');
        $this->jobListingService->close($listing, $reason);

        return redirect()->back()->with('success', 'Job listing closed successfully!');
    }

    /**
     * Delete a job listing
     */
    public function destroy(JobListing $listing)
    {
        Gate::authorize('delete-job-listing', $listing);

        $listing->delete();

        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
    }

    /**
     * Get match score for authenticated job seeker
     */
    private function getMatchScore(JobListing $listing): ?int
    {
        $user = Auth::user();

        if (!$user || !$user->isJobSeeker()) {
            return null;
        }

        $profile = $user->jobSeekerProfile;
        return $this->matchingService->calculateMatch($profile, $listing);
    }

    /**
     * Mark job as viewed
     */
    private function markAsViewed(JobListing $listing): void
    {
        $listing->increment('view_count');
    }
}
