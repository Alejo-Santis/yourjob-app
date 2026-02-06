<?php

namespace App\Http\Controllers;

use App\Models\JobSeekerProfile;
use App\Services\JobSeekerService;
use App\Services\JobMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class JobSeekerProfileController extends Controller
{
    public function __construct(
        private JobSeekerService $jobSeekerService,
        private JobMatchingService $matchingService
    ) {}

    /**
     * Display the job seeker's profile
     */
    public function show()
    {
        $profile = Auth::user()->jobSeekerProfile;

        return Inertia::render('JobSeeker/Profile/Show', [
            'profile' => $profile->load('workExperiences'),
            'summary' => $this->jobSeekerService->getProfileSummary($profile),
        ]);
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $profile = Auth::user()->jobSeekerProfile;

        return Inertia::render('JobSeeker/Profile/Edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'education_level' => 'nullable|string',
            'profession' => 'nullable|string',
            'total_years_experience' => 'nullable|integer|min:0',
            'expected_salary_min' => 'nullable|numeric|min:0',
            'expected_salary_max' => 'nullable|numeric|min:0',
            'preferred_contract_type' => 'nullable|string',
            'preferred_work_mode' => 'nullable|string',
        ]);

        $profile = Auth::user()->jobSeekerProfile;
        $this->jobSeekerService->update($profile, $validated);

        return redirect()->route('job-seeker.profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload CV
     */
    public function uploadCV(Request $request)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $profile = Auth::user()->jobSeekerProfile;
        $path = $this->jobSeekerService->uploadCV($profile, $request->file('cv'));

        return back()->with('success', 'CV uploaded successfully!');
    }

    /**
     * Display recommended jobs
     */
    public function recommendedJobs()
    {
        $profile = Auth::user()->jobSeekerProfile;
        $matches = $profile->jobMatches()
            ->where('status', 'active')
            ->where('match_score', '>=', 75)
            ->with('jobListing')
            ->orderBy('match_score', 'desc')
            ->paginate(12);

        return Inertia::render('JobSeeker/Dashboard/RecommendedJobs', [
            'matches' => $matches,
        ]);
    }

    /**
     * Display matching jobs
     */
    public function matchedJobs()
    {
        $profile = Auth::user()->jobSeekerProfile;
        $matches = $profile->jobMatches()
            ->where('status', 'active')
            ->with('jobListing')
            ->orderBy('match_score', 'desc')
            ->paginate(12);

        return Inertia::render('JobSeeker/Dashboard/MatchedJobs', [
            'matches' => $matches,
        ]);
    }

    /**
     * Display dashboard
     */
    public function dashboard()
    {
        $profile = Auth::user()->jobSeekerProfile;
        $summary = $this->jobSeekerService->getProfileSummary($profile);

        $recentApplications = $profile->applications()
            ->with('jobListing')
            ->orderBy('applied_at', 'desc')
            ->limit(5)
            ->get();

        $favorites = $profile->favorites()
            ->with('jobListing')
            ->limit(5)
            ->get();

        return Inertia::render('JobSeeker/Dashboard/Index', [
            'summary' => $summary,
            'recentApplications' => $recentApplications,
            'favorites' => $favorites,
        ]);
    }

    /**
     * Add skills to profile
     */
    public function addSkill(Request $request)
    {
        $validated = $request->validate([
            'skill' => 'required|string|max:100',
        ]);

        $profile = Auth::user()->jobSeekerProfile;
        $this->jobSeekerService->addSkills($profile, [$validated['skill']]);

        return back()->with('success', 'Skill added successfully!');
    }

    /**
     * Remove skill from profile
     */
    public function removeSkill(Request $request)
    {
        $validated = $request->validate([
            'skill' => 'required|string|max:100',
        ]);

        $profile = Auth::user()->jobSeekerProfile;
        $this->jobSeekerService->removeSkill($profile, $validated['skill']);

        return back()->with('success', 'Skill removed successfully!');
    }
}
