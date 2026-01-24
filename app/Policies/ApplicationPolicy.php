<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;

class ApplicationPolicy
{
    /**
     * Determine if the user can view an application
     */
    public function view(User $user, Application $application): bool
    {
        // Employer can view applications for their job listings
        if ($user->isEmployer()) {
            return $user->employerProfile->id === $application->jobListing->employer_id;
        }

        // Job seeker can view their own applications
        if ($user->isJobSeeker()) {
            return $user->jobSeekerProfile->id === $application->job_seeker_id;
        }

        return false;
    }

    /**
     * Determine if the user can accept an application
     */
    public function accept(User $user, Application $application): bool
    {
        return $user->isEmployer() &&
               $user->employerProfile->id === $application->jobListing->employer_id &&
               $user->hasPermissionTo('accept-application');
    }

    /**
     * Determine if the user can reject an application
     */
    public function reject(User $user, Application $application): bool
    {
        return $user->isEmployer() &&
               $user->employerProfile->id === $application->jobListing->employer_id &&
               $user->hasPermissionTo('reject-application');
    }

    /**
     * Determine if the user can withdraw an application
     */
    public function withdraw(User $user, Application $application): bool
    {
        return $user->isJobSeeker() &&
               $user->jobSeekerProfile->id === $application->job_seeker_id &&
               $user->hasPermissionTo('withdraw-application');
    }
}
