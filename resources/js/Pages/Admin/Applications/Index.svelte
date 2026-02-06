<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    export let applications = { data: [], links: [] };
    export let filters = {};

    let statusFilter = filters.status || '';

    function applyFilters() {
        const params = {};
        if (statusFilter) params.status = statusFilter;
        router.get('/admin/applications', params, { preserveState: true });
    }

    function clearFilters() {
        statusFilter = '';
        router.get('/admin/applications');
    }

    function getStatusColor(status) {
        const map = { pending: 'warning', accepted: 'success', rejected: 'danger', withdrawn: 'secondary' };
        return map[status] || 'secondary';
    }
</script>

<AppLayout>
    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Applications</h1>
                <p class="page-subtitle">Manage all job applications on the platform</p>
            </div>
            <div class="header-stats">
                <span class="header-stat">{applications.total || applications.data?.length || 0} total applications</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-row">
                <div class="filter-group">
                    <select class="filter-select" bind:value={statusFilter} on:change={applyFilters}>
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                        <option value="withdrawn">Withdrawn</option>
                    </select>
                </div>
                {#if statusFilter}
                    <button class="filter-btn-clear" on:click={clearFilters}>
                        <i class="bi bi-x-lg"></i> Clear
                    </button>
                {/if}
            </div>
        </div>

        <!-- Applications Table -->
        <div class="data-card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Job</th>
                            <th>Status</th>
                            <th>Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#if applications.data && applications.data.length > 0}
                            {#each applications.data as app}
                                <tr>
                                    <td>
                                        <div class="applicant-cell">
                                            <div class="cell-avatar-app">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <span class="cell-name">{app.job_seeker?.full_name || app.job_seeker?.email || 'N/A'}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="cell-job-title">{app.job_listing?.title || 'N/A'}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{getStatusColor(app.status)}">
                                            {app.status}
                                        </span>
                                    </td>
                                    <td class="cell-text-muted">
                                        {app.applied_at ? new Date(app.applied_at).toLocaleDateString() : 'N/A'}
                                    </td>
                                </tr>
                            {/each}
                        {:else}
                            <tr>
                                <td colspan="4" class="empty-cell">No applications found</td>
                            </tr>
                        {/if}
                    </tbody>
                </table>
            </div>

            {#if applications.links && applications.links.length > 3}
                <div class="pagination-bar">
                    {#each applications.links as link}
                        {#if link.url}
                            <button class="page-btn" class:active={link.active} on:click={() => router.get(link.url)}>
                                {@html link.label}
                            </button>
                        {:else}
                            <span class="page-btn disabled">{@html link.label}</span>
                        {/if}
                    {/each}
                </div>
            {/if}
        </div>
    </div>
</AppLayout>

<style>
    .admin-page { max-width: 1400px; margin: 0 auto; }

    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; }
    .page-title { font-size: 1.75rem; font-weight: 700; color: #1a1d29; margin-bottom: 0.25rem; }
    .page-subtitle { color: #6c757d; font-size: 0.938rem; margin: 0; }
    .header-stat { background: #f0f0ff; color: #667eea; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.813rem; font-weight: 600; }

    .filters-card { background: white; border-radius: 16px; padding: 1.25rem 1.5rem; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); margin-bottom: 1.25rem; }
    .filters-row { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }

    .filter-select {
        padding: 0.625rem 1rem; border: 1px solid #e9ecef; border-radius: 10px;
        font-size: 0.875rem; color: #495057; background: #f8f9fa; outline: none;
    }
    .filter-select:focus { border-color: #667eea; background: white; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
    .filter-btn-clear { padding: 0.625rem 1rem; background: transparent; color: #6c757d; border: 1px solid #e9ecef; border-radius: 10px; font-size: 0.875rem; cursor: pointer; }

    .data-card { background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead th { padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; background: #fafbfc; border-bottom: 1px solid #f0f0f0; }
    .data-table tbody td { padding: 1rem 1.5rem; border-bottom: 1px solid #f8f9fa; font-size: 0.875rem; vertical-align: middle; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    .applicant-cell { display: flex; align-items: center; gap: 0.75rem; }
    .cell-avatar-app { width: 36px; height: 36px; border-radius: 8px; background: #e8f5e9; color: #2e7d32; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .cell-name { font-weight: 500; color: #1a1d29; }
    .cell-job-title { font-weight: 500; color: #495057; }
    .cell-text-muted { color: #6c757d; }

    .status-badge { font-size: 0.688rem; font-weight: 600; padding: 0.25rem 0.625rem; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.3px; }
    .status-success { background: #e8f5e9; color: #2e7d32; }
    .status-warning { background: #fff8e1; color: #f57f17; }
    .status-danger { background: #fce4ec; color: #e53935; }
    .status-secondary { background: #f5f5f5; color: #616161; }

    .empty-cell { text-align: center; color: #6c757d; padding: 3rem 0 !important; }

    .pagination-bar { display: flex; justify-content: center; gap: 0.25rem; padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; }
    .page-btn { padding: 0.5rem 0.75rem; border: none; background: transparent; border-radius: 8px; font-size: 0.813rem; color: #495057; cursor: pointer; }
    .page-btn:hover { background: #f0f0ff; color: #667eea; }
    .page-btn.active { background: #667eea; color: white; }
    .page-btn.disabled { color: #dee2e6; cursor: default; }
</style>
