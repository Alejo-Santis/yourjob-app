<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Job Seeker Permissions
        $jobSeekerPermissions = [
            'view-jobs',
            'apply-job',
            'withdraw-application',
            'view-own-applications',
            'view-own-profile',
            'edit-own-profile',
            'upload-cv',
            'manage-favorite-jobs',
            'view-matches',
        ];

        // Employer Permissions
        $employerPermissions = [
            'create-job-listing',
            'edit-job-listing',
            'publish-job-listing',
            'close-job-listing',
            'delete-job-listing',
            'view-own-listings',
            'view-applications',
            'accept-application',
            'reject-application',
            'view-own-profile',
            'edit-own-profile',
            'upload-logo',
            'view-analytics',
            'manage-team',
        ];

        // Admin Permissions
        $adminPermissions = [
            'manage-users',
            'verify-employers',
            'view-all-users',
            'view-all-jobs',
            'view-all-applications',
            'manage-permissions',
            'manage-roles',
            'view-analytics',
            'manage-system-settings',
            'delete-user',
            'ban-user',
        ];

        // Create all permissions
        $allPermissions = array_unique(array_merge(
            $jobSeekerPermissions,
            $employerPermissions,
            $adminPermissions
        ));

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        // Create Job Seeker Role
        $jobSeekerRole = Role::firstOrCreate(
            ['name' => 'job_seeker'],
            ['guard_name' => 'web']
        );
        $jobSeekerRole->syncPermissions($jobSeekerPermissions);

        // Create Employer Role
        $employerRole = Role::firstOrCreate(
            ['name' => 'employer'],
            ['guard_name' => 'web']
        );
        $employerRole->syncPermissions($employerPermissions);

        // Create Admin Role
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web']
        );
        $adminRole->syncPermissions($adminPermissions);

        $this->command->info('Permissions and roles have been created successfully!');
    }
}
