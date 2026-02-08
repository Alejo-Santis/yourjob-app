<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import StatsCard from '../../../Components/StatsCard.svelte';
    import { router } from '@inertiajs/svelte';

    let { stats = {}, activeListings = [] } = $props();

    function calculatePercentage(value, total) {
        if (!total || total === 0) return 0;
        return Math.round((value / total) * 100);
    }
</script>

<AppLayout>
    <div class="dashboard-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Employer Dashboard</h1>
            <p class="text-muted">Manage your job listings and applications</p>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Active Listings" value={stats.active_listings || 0} icon="briefcase" color="primary" />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Total Applications" value={stats.total_applications || 0} icon="file-earmark-text" color="success" />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Pending Reviews" value={stats.pending_applications || 0} icon="clock" color="warning" />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Total Listings" value={stats.total_listings || 0} icon="list-ul" color="info" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Active Job Listings</h5>
                        <div class="d-flex gap-2">
                            <a href="/employer/listings" class="btn btn-sm btn-outline-primary">View All</a>
                            <a href="/employer/jobs/create" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>New Job
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {#if activeListings && activeListings.length > 0}
                            <div class="list-group list-group-flush">
                                {#each activeListings as listing}
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    <a href="/jobs/{listing.id}" class="text-decoration-none">{listing.title}</a>
                                                </h6>
                                                <p class="mb-2 small text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>{listing.city}, {listing.state}
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-briefcase me-1"></i>{listing.contract_type}
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-laptop me-1"></i>{listing.work_mode}
                                                </p>
                                                <div class="d-flex gap-3 small">
                                                    <span><i class="bi bi-eye me-1"></i>{listing.view_count || 0} views</span>
                                                    <span><i class="bi bi-file-earmark-text me-1"></i>{listing.applications_count || 0} applications</span>
                                                </div>
                                            </div>
                                            <a href="/employer/jobs/{listing.id}/edit" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </div>
                                {/each}
                            </div>
                        {:else}
                            <p class="text-muted text-center py-3">No active job listings</p>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="/employer/jobs/create" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Post New Job
                            </a>
                            <a href="/employer/applications" class="btn btn-outline-primary">
                                <i class="bi bi-file-earmark-text me-2"></i>View Applications
                            </a>
                            <a href="/employer/analytics" class="btn btn-outline-secondary">
                                <i class="bi bi-graph-up me-2"></i>View Analytics
                            </a>
                            <a href="/employer/profile" class="btn btn-outline-secondary">
                                <i class="bi bi-building me-2"></i>Company Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Application Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Pending</small>
                                <small class="fw-bold text-warning">{stats.pending_applications || 0}</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {calculatePercentage(stats.pending_applications, stats.total_applications)}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Accepted</small>
                                <small class="fw-bold text-success">{stats.accepted_applications || 0}</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: {calculatePercentage(stats.accepted_applications, stats.total_applications)}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Rejected</small>
                                <small class="fw-bold text-danger">{stats.rejected_applications || 0}</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger" style="width: {calculatePercentage(stats.rejected_applications, stats.total_applications)}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .dashboard-container { max-width: 1400px; margin: 0 auto; }
    .card { border: none; border-radius: 0.5rem; }
    .card-header { border-bottom: 1px solid #e9ecef; padding: 1rem 1.25rem; }
    .list-group-item { border-left: none; border-right: none; }
    .list-group-item:first-child { border-top: none; }
    .list-group-item:last-child { border-bottom: none; }
</style>
