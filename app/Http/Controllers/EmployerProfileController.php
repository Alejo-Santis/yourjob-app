<?php

namespace App\Http\Controllers;

use App\Models\EmployerProfile;
use App\Services\EmployerService;
use App\Services\JobListingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EmployerProfileController extends Controller
{
    public function __construct(
        private EmployerService $employerService,
        private JobListingService $jobListingService
    ) {}

    /**
     * Display the employer's profile
     */
    public function show()
    {
        $profile = Auth::user()->employerProfile;

        return Inertia::render('Employer/Profile/Show', [
            'profile' => $profile,
            'summary' => $this->employerService->getProfileSummary($profile),
        ]);
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $profile = Auth::user()->employerProfile;

        return Inertia::render('Employer/Profile/Edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_website' => 'nullable|url',
            'company_description' => 'nullable|string',
            'industry' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'employee_count' => 'nullable|integer|min:0',
            'company_size' => 'nullable|string',
            'founding_year' => 'nullable|integer|min:1900|max:2099',
        ]);

        $profile = Auth::user()->employerProfile;
        $this->employerService->update($profile, $validated);

        return redirect()->route('employer.profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload company logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $profile = Auth::user()->employerProfile;
        $this->employerService->uploadLogo($profile, $request->file('logo'));

        return back()->with('success', 'Logo uploaded successfully!');
    }

    /**
     * Display employer dashboard
     */
    public function dashboard()
    {
        $profile = Auth::user()->employerProfile;
        $stats = $this->employerService->getStatistics($profile);
        $activeListings = $this->employerService->getActivePositions($profile)->take(5);

        return Inertia::render('Employer/Dashboard/Index', [
            'stats' => $stats,
            'activeListings' => $activeListings,
        ]);
    }

    /**
     * Display job listings management
     */
    public function managingListings()
    {
        $profile = Auth::user()->employerProfile;
        $listings = $this->jobListingService->getByEmployer($profile)->paginate(15);

        return Inertia::render('Employer/Listings/Index', [
            'listings' => $listings,
        ]);
    }

    /**
     * Display applications received
     */
    public function applications(Request $request)
    {
        $profile = Auth::user()->employerProfile;
        $status = $request->input('status');

        $applications = $profile->jobListings()
            ->with(['applications' => function ($query) use ($status) {
                if ($status) {
                    $query->where('status', $status);
                }
                $query->orderBy('applied_at', 'desc');
            }])
            ->get()
            ->flatMap->applications
            ->paginate(15);

        return Inertia::render('Employer/Applications/Index', [
            'applications' => $applications,
            'status' => $status,
        ]);
    }

    /**
     * Display analytics
     */
    public function analytics()
    {
        $profile = Auth::user()->employerProfile;
        $listings = $profile->jobListings;

        $analytics = [
            'total_listings' => $listings->count(),
            'active_listings' => $listings->where('status', 'active')->count(),
            'total_applications' => $profile->getTotalApplications(),
            'avg_applications' => $profile->getAverageApplicationsPerJob(),
            'applications_by_status' => $this->getApplicationsByStatus($profile),
            'listings_by_month' => $this->getListingsByMonth($profile),
        ];

        return Inertia::render('Employer/Analytics/Index', [
            'analytics' => $analytics,
        ]);
    }

    /**
     * Get applications grouped by status
     */
    private function getApplicationsByStatus(EmployerProfile $profile): array
    {
        $applications = $profile->jobListings()
            ->with('applications')
            ->get()
            ->flatMap->applications;

        return [
            'pending' => $applications->where('status', 'pending')->count(),
            'accepted' => $applications->where('status', 'accepted')->count(),
            'rejected' => $applications->where('status', 'rejected')->count(),
            'withdrawn' => $applications->where('status', 'withdrawn')->count(),
        ];
    }

    /**
     * Get listings posted by month
     */
    private function getListingsByMonth(EmployerProfile $profile): array
    {
        $listings = $profile->jobListings
            ->where('posted_at', '!=', null)
            ->groupBy(fn($listing) => $listing->posted_at->format('Y-m'));

        return $listings->map(fn($group) => $group->count())->toArray();
    }
}
