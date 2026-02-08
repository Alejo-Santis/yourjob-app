<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Authentication routes
require __DIR__.'/auth.php';

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Global search API
Route::get('/api/search', [SearchController::class, 'search'])->name('search');

// Job listings - public access
Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{listing}', [JobListingController::class, 'show'])->name('jobs.show');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Job Seeker routes
    Route::middleware(['role:job_seeker'])->prefix('job-seeker')->name('job-seeker.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [JobSeekerProfileController::class, 'dashboard'])->name('dashboard');

        // Profile
        Route::get('/profile', [JobSeekerProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [JobSeekerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [JobSeekerProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/cv', [JobSeekerProfileController::class, 'uploadCV'])->name('profile.upload-cv');

        // Skills
        Route::post('/profile/skills', [JobSeekerProfileController::class, 'addSkill'])->name('profile.add-skill');
        Route::delete('/profile/skills', [JobSeekerProfileController::class, 'removeSkill'])->name('profile.remove-skill');

        // Job recommendations and matches
        Route::get('/recommended-jobs', [JobSeekerProfileController::class, 'recommendedJobs'])->name('recommended-jobs');
        Route::get('/matched-jobs', [JobSeekerProfileController::class, 'matchedJobs'])->name('matched-jobs');

        // Favorites
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    });

    // Employer routes
    Route::middleware(['role:employer'])->prefix('employer')->name('employer.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [EmployerProfileController::class, 'dashboard'])->name('dashboard');

        // Profile
        Route::get('/profile', [EmployerProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [EmployerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [EmployerProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/logo', [EmployerProfileController::class, 'uploadLogo'])->name('profile.upload-logo');

        // Job listings management
        Route::get('/listings', [EmployerProfileController::class, 'managingListings'])->name('listings.index');

        // Applications
        Route::get('/applications', [EmployerProfileController::class, 'applications'])->name('applications.index');

        // Analytics
        Route::get('/analytics', [EmployerProfileController::class, 'analytics'])->name('analytics.index');

        // Job listing CRUD
        Route::get('/jobs/create', [JobListingController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobListingController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{listing}/edit', [JobListingController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{listing}', [JobListingController::class, 'update'])->name('jobs.update');
        Route::post('/jobs/{listing}/publish', [JobListingController::class, 'publish'])->name('jobs.publish');
        Route::post('/jobs/{listing}/close', [JobListingController::class, 'close'])->name('jobs.close');
        Route::delete('/jobs/{listing}', [JobListingController::class, 'destroy'])->name('jobs.destroy');
    });

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/jobs', [AdminController::class, 'jobListings'])->name('jobs');
        Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
    });

    // Applications routes (both job seekers and employers)
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [ApplicationController::class, 'index'])->name('index');
        Route::get('/{application}', [ApplicationController::class, 'show'])->name('show');
        Route::post('/', [ApplicationController::class, 'store'])->name('store');
        Route::post('/{application}/accept', [ApplicationController::class, 'accept'])->name('accept');
        Route::post('/{application}/reject', [ApplicationController::class, 'reject'])->name('reject');
        Route::post('/{application}/withdraw', [ApplicationController::class, 'withdraw'])->name('withdraw');
    });

    // Favorites routes
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::post('/jobs/{listing}', [FavoriteController::class, 'store'])->name('store');
        Route::delete('/{favorite}', [FavoriteController::class, 'destroy'])->name('destroy');
        Route::post('/jobs/{listing}/toggle', [FavoriteController::class, 'toggle'])->name('toggle');
        Route::get('/jobs/{listing}/check', [FavoriteController::class, 'isFavorited'])->name('check');
    });
});
