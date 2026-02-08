<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import StatsCard from '../../../Components/StatsCard.svelte';

    let { analytics = {} } = $props();

    function calculatePercentage(value, total) {
        if (!total || total === 0) return 0;
        return Math.round((value / total) * 100);
    }

    function formatMonth(monthString) {
        const date = new Date(monthString + '-01');
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
    }
</script>

<AppLayout>
    <div class="analytics-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Analytics</h1>
            <p class="text-muted">Track your job listings performance</p>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Total Listings" value={analytics.total_listings || 0} icon="briefcase" color="primary" />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Active Listings" value={analytics.active_listings || 0} icon="check-circle" color="success" />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Total Applications" value={analytics.total_applications || 0} icon="file-earmark-text" color="info" />
            </div>
            <div class="col-md-3 col-sm-6">
                <StatsCard title="Avg. Applications" value={analytics.avg_applications ? analytics.avg_applications.toFixed(1) : 0} icon="graph-up" color="warning" />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white"><h5 class="mb-0">Applications by Status</h5></div>
                    <div class="card-body">
                        {#if analytics.applications_by_status}
                            {#each [
                                { label: 'Pending', key: 'pending', color: 'warning' },
                                { label: 'Accepted', key: 'accepted', color: 'success' },
                                { label: 'Rejected', key: 'rejected', color: 'danger' },
                                { label: 'Withdrawn', key: 'withdrawn', color: 'secondary' }
                            ] as item}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="status-dot bg-{item.color} me-2"></span>
                                            <span>{item.label}</span>
                                        </div>
                                        <span class="fw-bold">{analytics.applications_by_status[item.key] || 0}</span>
                                    </div>
                                    <div class="progress" style="height: 12px;">
                                        <div class="progress-bar bg-{item.color}" style="width: {calculatePercentage(analytics.applications_by_status[item.key], analytics.total_applications)}%"></div>
                                    </div>
                                </div>
                            {/each}
                        {:else}
                            <p class="text-muted text-center py-4">No application data available</p>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white"><h5 class="mb-0">Listings Posted by Month</h5></div>
                    <div class="card-body">
                        {#if analytics.listings_by_month && Object.keys(analytics.listings_by_month).length > 0}
                            <div class="list-group list-group-flush">
                                {#each Object.entries(analytics.listings_by_month) as [month, count]}
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-semibold">{formatMonth(month)}</span>
                                            <span class="badge bg-primary">{count}</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: {calculatePercentage(count, Math.max(...Object.values(analytics.listings_by_month)))}%"></div>
                                        </div>
                                    </div>
                                {/each}
                            </div>
                        {:else}
                            <p class="text-muted text-center py-4">No listing data available</p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white"><h5 class="mb-0">Summary</h5></div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="border-end">
                            <h3 class="mb-1 text-primary">{analytics.total_listings || 0}</h3>
                            <p class="text-muted mb-0 small">Total Jobs Posted</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="border-end">
                            <h3 class="mb-1 text-success">{analytics.total_applications || 0}</h3>
                            <p class="text-muted mb-0 small">Total Applications Received</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h3 class="mb-1 text-info">{analytics.avg_applications ? analytics.avg_applications.toFixed(1) : 0}</h3>
                        <p class="text-muted mb-0 small">Average Applications per Job</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .analytics-container { max-width: 1400px; margin: 0 auto; }
    .card { border: none; border-radius: 0.5rem; }
    .card-header { border-bottom: 1px solid #e9ecef; padding: 1rem 1.25rem; }
    .status-dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; }
    .list-group-item { border-left: none; border-right: none; }
    .list-group-item:first-child { border-top: none; }
    .list-group-item:last-child { border-bottom: none; }
</style>
