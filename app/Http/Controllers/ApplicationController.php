<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function __construct(
        private ApplicationService $applicationService
    ) {}

    /**
     * Display applications for authenticated user
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isJobSeeker()) {
            return $this->jobSeekerApplications();
        } elseif ($user->isEmployer()) {
            return $this->employerApplications($request);
        }
    }

    /**
     * Show job seeker's own applications
     */
    private function jobSeekerApplications()
    {
        $user = Auth::user();

        $profile = $user->jobSeekerProfile;
        $applications = $this->applicationService->getApplicationsForSeeker($profile)->paginate(15);

        return Inertia::render('Applications/Index', [
            'applications' => $applications,
            'userType' => 'job_seeker',
        ]);
    }

    /**
     * Show employer's received applications
     */
    private function employerApplications(Request $request)
    {
        $user = Auth::user();

        $employer = $user->employerProfile;
        $status = $request->input('status');

        $applications = $employer->jobListings()
            ->with(['applications' => function ($query) use ($status) {
                if ($status) {
                    $query->where('status', $status);
                }
                $query->orderBy('applied_at', 'desc');
            }])
            ->get()
            ->flatMap->applications
            ->paginate(15);

        return Inertia::render('Applications/Index', [
            'applications' => $applications,
            'userType' => 'employer',
            'status' => $status,
        ]);
    }

    /**
     * Show a specific application
     */
    public function show(Application $application)
    {
        Gate::authorize('view', $application);

        $user = Auth::user();

        $application->load(['jobSeeker', 'jobListing', 'jobListing.employer']);

        // Mark as viewed
        if ($user->isEmployer()) {
            $this->applicationService->markAsViewed($application);
        }

        return Inertia::render('Applications/Show', [
            'application' => $application,
        ]);
    }

    /**
     * Store a new application
     */
    public function store(Request $request)
    {
        Gate::authorize('apply-job');

        $user = Auth::user();

        $validated = $request->validate([
            'job_listing_id' => 'required|uuid|exists:job_listings,id',
            'cover_letter' => 'nullable|string|max:5000',
            'additional_answers' => 'nullable|array',
        ]);

        try {
            $seeker = $user->jobSeekerProfile;
            $listing = JobListing::findOrFail($validated['job_listing_id']);

            $application = $this->applicationService->create($seeker, $listing, $validated);

            return redirect()->route('applications.show', $application)
                ->with('success', 'Application submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Accept an application
     */
    public function accept(Application $application)
    {
        Gate::authorize('accept-application', $application);

        $this->applicationService->accept($application);

        return redirect()->back()->with('success', 'Application accepted successfully!');
    }

    /**
     * Reject an application
     */
    public function reject(Request $request, Application $application)
    {
        Gate::authorize('accept-application', $application);

        $message = $request->input('message', '');
        $this->applicationService->reject($application, $message);

        return redirect()->back()->with('success', 'Application rejected successfully!');
    }

    /**
     * Withdraw an application
     */
    public function withdraw(Application $application)
    {
        Gate::authorize('withdraw-application', $application);

        $this->applicationService->withdraw($application);

        return redirect()->back()->with('success', 'Application withdrawn successfully!');
    }
}
