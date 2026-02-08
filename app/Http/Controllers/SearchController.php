<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        // Search jobs (always available)
        $jobs = JobListing::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('title', 'ILIKE', "%{$query}%")
                  ->orWhere('city', 'ILIKE', "%{$query}%")
                  ->orWhere('industry_sector', 'ILIKE', "%{$query}%");
            })
            ->select('id', 'title', 'city', 'state', 'contract_type', 'work_mode')
            ->limit(6)
            ->get();

        foreach ($jobs as $job) {
            $results[] = [
                'type' => 'job',
                'id' => $job->id,
                'title' => $job->title,
                'subtitle' => "{$job->city}, {$job->state} · {$job->contract_type}",
                'url' => "/jobs/{$job->id}",
                'icon' => 'briefcase',
            ];
        }

        // Add navigation shortcuts matching the query
        $pages = $this->getNavigationItems($query);
        foreach ($pages as $page) {
            $results[] = $page;
        }

        return response()->json(['results' => $results]);
    }

    private function getNavigationItems(string $query): array
    {
        $user = Auth::user();
        $items = [
            ['title' => 'Browse Jobs', 'url' => '/jobs', 'icon' => 'search', 'keywords' => 'jobs browse search find'],
            ['title' => 'Home', 'url' => '/', 'icon' => 'house', 'keywords' => 'home landing welcome'],
        ];

        if ($user) {
            $type = $user->user_type;

            if ($type === 'job_seeker') {
                $items = array_merge($items, [
                    ['title' => 'Dashboard', 'url' => '/job-seeker/dashboard', 'icon' => 'grid-1x2', 'keywords' => 'dashboard home panel'],
                    ['title' => 'My Favorites', 'url' => '/job-seeker/favorites', 'icon' => 'heart', 'keywords' => 'favorites saved bookmarks'],
                    ['title' => 'My Applications', 'url' => '/applications', 'icon' => 'file-earmark-text', 'keywords' => 'applications applied status'],
                    ['title' => 'My Profile', 'url' => '/job-seeker/profile', 'icon' => 'person', 'keywords' => 'profile settings account edit'],
                ]);
            } elseif ($type === 'employer') {
                $items = array_merge($items, [
                    ['title' => 'Dashboard', 'url' => '/employer/dashboard', 'icon' => 'grid-1x2', 'keywords' => 'dashboard home panel'],
                    ['title' => 'Post New Job', 'url' => '/employer/jobs/create', 'icon' => 'plus-circle', 'keywords' => 'post create new job listing'],
                    ['title' => 'My Listings', 'url' => '/employer/listings', 'icon' => 'list-columns-reverse', 'keywords' => 'listings jobs manage'],
                    ['title' => 'Applications', 'url' => '/employer/applications', 'icon' => 'inbox', 'keywords' => 'applications candidates review'],
                    ['title' => 'Analytics', 'url' => '/employer/analytics', 'icon' => 'bar-chart-line', 'keywords' => 'analytics stats metrics performance'],
                    ['title' => 'Company Profile', 'url' => '/employer/profile', 'icon' => 'building', 'keywords' => 'profile company settings edit'],
                ]);
            } elseif ($type === 'admin') {
                $items = array_merge($items, [
                    ['title' => 'Admin Dashboard', 'url' => '/admin/dashboard', 'icon' => 'grid-1x2', 'keywords' => 'dashboard admin panel'],
                    ['title' => 'Manage Users', 'url' => '/admin/users', 'icon' => 'people', 'keywords' => 'users manage accounts'],
                    ['title' => 'Manage Jobs', 'url' => '/admin/jobs', 'icon' => 'briefcase', 'keywords' => 'jobs listings manage admin'],
                    ['title' => 'Manage Applications', 'url' => '/admin/applications', 'icon' => 'file-earmark-text', 'keywords' => 'applications manage admin'],
                ]);
            }
        }

        $lowerQuery = strtolower($query);
        $matched = [];

        foreach ($items as $item) {
            if (
                str_contains(strtolower($item['title']), $lowerQuery) ||
                str_contains($item['keywords'], $lowerQuery)
            ) {
                $matched[] = [
                    'type' => 'page',
                    'id' => $item['url'],
                    'title' => $item['title'],
                    'subtitle' => 'Go to page',
                    'url' => $item['url'],
                    'icon' => $item['icon'],
                ];
            }
        }

        return array_slice($matched, 0, 4);
    }
}
