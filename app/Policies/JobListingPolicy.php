<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobListing;
use Illuminate\Auth\Access\Response;

class JobListingPolicy
{
    /**
     * Determine if the user can view a job listing
     */
    public function view(User $user, JobListing $listing): bool
    {
        return true; // All authenticated users can view active listings
    }

    /**
     * Determine if the user can create a job listing
     */
    public function create(User $user): bool
    {
        return $user->isEmployer() && $user->hasPermissionTo('create-job-listing');
    }

    /**
     * Determine if the user can edit a job listing
     */
    public function edit(User $user, JobListing $listing): bool
    {
        return $user->isEmployer() &&
               $user->employerProfile->id === $listing->employer_id &&
               $user->hasPermissionTo('edit-job-listing');
    }

    /**
     * Determine if the user can publish a job listing
     */
    public function publish(User $user, JobListing $listing): bool
    {
        return $user->isEmployer() &&
               $user->employerProfile->id === $listing->employer_id &&
               $user->hasPermissionTo('publish-job-listing');
    }

    /**
     * Determine if the user can close a job listing
     */
    public function close(User $user, JobListing $listing): bool
    {
        return $user->isEmployer() &&
               $user->employerProfile->id === $listing->employer_id &&
               $user->hasPermissionTo('close-job-listing');
    }

    /**
     * Determine if the user can delete a job listing
     */
    public function delete(User $user, JobListing $listing): bool
    {
        return $user->isEmployer() &&
               $user->employerProfile->id === $listing->employer_id &&
               $user->hasPermissionTo('delete-job-listing');
    }
}
