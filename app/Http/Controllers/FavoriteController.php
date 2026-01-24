<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    /**
     * Display all favorite jobs for the authenticated user
     */
    public function index()
    {
        $profile = Auth::user()->jobSeekerProfile;
        $favorites = $profile->favorites()
            ->with('jobListing')
            ->paginate(12);

        return Inertia::render('JobSeeker/Favorites/Index', [
            'favorites' => $favorites,
        ]);
    }

    /**
     * Add a job to favorites
     */
    public function store(JobListing $listing)
    {
        Gate::authorize('manage-favorite-jobs');

        $profile = Auth::user()->jobSeekerProfile;

        // Check if already favorited
        $existing = Favorite::where('job_seeker_id', $profile->id)
            ->where('job_listing_id', $listing->id)
            ->first();

        if ($existing) {
            return back()->with('info', 'This job is already in your favorites.');
        }

        Favorite::create([
            'job_seeker_id' => $profile->id,
            'job_listing_id' => $listing->id,
            'is_active' => true,
        ]);

        return back()->with('success', 'Job added to favorites!');
    }

    /**
     * Remove a job from favorites
     */
    public function destroy(Favorite $favorite)
    {
        Gate::authorize('manage-favorite-jobs');

        $profile = Auth::user()->jobSeekerProfile;

        if ($favorite->job_seeker_id !== $profile->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $favorite->delete();

        return back()->with('success', 'Job removed from favorites!');
    }

    /**
     * Toggle favorite status
     */
    public function toggle(JobListing $listing)
    {
        Gate::authorize('manage-favorite-jobs');

        $profile = Auth::user()->jobSeekerProfile;

        $favorite = Favorite::where('job_seeker_id', $profile->id)
            ->where('job_listing_id', $listing->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Job removed from favorites!');
        } else {
            Favorite::create([
                'job_seeker_id' => $profile->id,
                'job_listing_id' => $listing->id,
                'is_active' => true,
            ]);
            return back()->with('success', 'Job added to favorites!');
        }
    }

    /**
     * Check if a job is favorited by the authenticated user
     */
    public function isFavorited(JobListing $listing)
    {
        if (!Auth::check() || !Auth::user()->isJobSeeker()) {
            return response()->json(['isFavorited' => false]);
        }

        $profile = Auth::user()->jobSeekerProfile;
        $isFavorited = Favorite::where('job_seeker_id', $profile->id)
            ->where('job_listing_id', $listing->id)
            ->exists();

        return response()->json(['isFavorited' => $isFavorited]);
    }
}
