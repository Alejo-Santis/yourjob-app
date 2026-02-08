<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import StatsCard from '../../../Components/StatsCard.svelte';
    import JobCard from '../../../Components/JobCard.svelte';
    import { router, page } from '@inertiajs/svelte';

    let { summary = {}, recentApplications = [], favorites = [] } = $props();

    function handleApply(jobId) {
        router.post('/applications', { job_listing_id: jobId });
    }

    function handleFavoriteToggle(jobId) {
        router.post(`/favorites/jobs/${jobId}/toggle`);
    }

    function getStatusColor(status) {
        const colors = {
            pending: 'warning',
            accepted: 'success',
            rejected: 'danger',
            withdrawn: 'secondary',
        };
        return colors[status] || 'secondary';
    }
</script>

<AppLayout>
    <div class="dashboard-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Dashboard</h1>
            <p class="text-muted">Welcome back, {summary.name}!</p>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <StatsCard
                    title="Profile Completion"
                    value="{summary.completion}%"
                    icon="person-check"
                    color="primary"
                />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard
                    title="Applications"
                    value={summary.applications || 0}
                    icon="file-earmark-text"
                    color="success"
                />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard
                    title="Favorites"
                    value={summary.favorites || 0}
                    icon="heart"
                    color="danger"
                />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard
                    title="Skills"
                    value={summary.skills_count || 0}
                    icon="award"
                    color="info"
                />
            </div>
        </div>

        <!-- Profile Completion Alert -->
        {#if summary.completion < 80}
            <div class="alert alert-warning mb-4" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Your profile is {summary.completion}% complete.
                <a href="/job-seeker/profile/edit" class="alert-link">Complete your profile</a>
                to get better job matches!
            </div>
        {/if}

        <div class="row">
            <!-- Recent Applications -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Applications</h5>
                        <a href="/applications" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        {#if recentApplications.length > 0}
                            <div class="list-group list-group-flush">
                                {#each recentApplications as application}
                                    <a
                                        href="/applications/{application.id}"
                                        class="list-group-item list-group-item-action"
                                    >
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{application.job_listing?.title}</h6>
                                                <p class="mb-1 small text-muted">
                                                    {application.job_listing?.employer?.company_name}
                                                </p>
                                                <small class="text-muted">
                                                    Applied: {new Date(application.applied_at).toLocaleDateString()}
                                                </small>
                                            </div>
                                            <span class="badge bg-{getStatusColor(application.status)}">
                                                {application.status}
                                            </span>
                                        </div>
                                    </a>
                                {/each}
                            </div>
                        {:else}
                            <p class="text-muted text-center py-3">No applications yet</p>
                        {/if}
                    </div>
                </div>
            </div>

            <!-- Favorite Jobs -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Favorite Jobs</h5>
                        <a href="/job-seeker/favorites" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        {#if favorites.length > 0}
                            <div class="list-group list-group-flush">
                                {#each favorites as favorite}
                                    <a
                                        href="/jobs/{favorite.job_listing?.id}"
                                        class="list-group-item list-group-item-action"
                                    >
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{favorite.job_listing?.title}</h6>
                                                <p class="mb-1 small text-muted">
                                                    {favorite.job_listing?.employer?.company_name}
                                                </p>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i>
                                                    {favorite.job_listing?.city}, {favorite.job_listing?.state}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                {/each}
                            </div>
                        {:else}
                            <p class="text-muted text-center py-3">No favorite jobs yet</p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="/jobs" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Browse Jobs
                            </a>
                            <a href="/job-seeker/recommended-jobs" class="btn btn-outline-primary">
                                <i class="bi bi-lightbulb me-2"></i>Recommended Jobs
                            </a>
                            <a href="/job-seeker/matched-jobs" class="btn btn-outline-primary">
                                <i class="bi bi-bullseye me-2"></i>Matched Jobs
                            </a>
                            <a href="/job-seeker/profile/edit" class="btn btn-outline-secondary">
                                <i class="bi bi-pencil me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.25rem;
    }

    .list-group-item {
        border-left: none;
        border-right: none;
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
