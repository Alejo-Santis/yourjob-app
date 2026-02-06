<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    export let jobs = { data: [], links: [] };
    export let filters = {};

    let search = filters.search || '';
    let statusFilter = filters.status || '';

    function applyFilters() {
        const params = {};
        if (search) params.search = search;
        if (statusFilter) params.status = statusFilter;
        router.get('/admin/jobs', params, { preserveState: true });
    }

    function clearFilters() {
        search = '';
        statusFilter = '';
        router.get('/admin/jobs');
    }
</script>

<AppLayout>
    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Job Listings</h1>
                <p class="page-subtitle">Manage all job listings on the platform</p>
            </div>
            <div class="header-stats">
                <span class="header-stat">{jobs.total || jobs.data?.length || 0} total listings</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-row">
                <div class="filter-group">
                    <input
                        type="text"
                        class="filter-input"
                        placeholder="Search by title..."
                        bind:value={search}
                        on:keydown={(e) => e.key === 'Enter' && applyFilters()}
                    />
                </div>
                <div class="filter-group">
                    <select class="filter-select" bind:value={statusFilter} on:change={applyFilters}>
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                        <option value="closed">Closed</option>
                        <option value="filled">Filled</option>
                    </select>
                </div>
                <button class="filter-btn" on:click={applyFilters}>
                    <i class="bi bi-search"></i> Search
                </button>
                {#if search || statusFilter}
                    <button class="filter-btn-clear" on:click={clearFilters}>
                        <i class="bi bi-x-lg"></i> Clear
                    </button>
                {/if}
            </div>
        </div>

        <!-- Jobs Table -->
        <div class="data-card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#if jobs.data && jobs.data.length > 0}
                            {#each jobs.data as job}
                                <tr>
                                    <td>
                                        <div class="job-cell">
                                            <div class="cell-icon">
                                                <i class="bi bi-briefcase-fill"></i>
                                            </div>
                                            <div>
                                                <span class="cell-title">{job.title}</span>
                                                <span class="cell-meta">{job.work_mode || 'N/A'}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cell-text">{job.employer?.company_name || 'N/A'}</td>
                                    <td class="cell-text-muted">{job.city}{job.state ? `, ${job.state}` : ''}</td>
                                    <td>
                                        <span class="contract-badge">{job.contract_type || 'N/A'}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{job.status}">{job.status}</span>
                                    </td>
                                </tr>
                            {/each}
                        {:else}
                            <tr>
                                <td colspan="5" class="empty-cell">No job listings found</td>
                            </tr>
                        {/if}
                    </tbody>
                </table>
            </div>

            {#if jobs.links && jobs.links.length > 3}
                <div class="pagination-bar">
                    {#each jobs.links as link}
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

    .filter-input, .filter-select {
        padding: 0.625rem 1rem; border: 1px solid #e9ecef; border-radius: 10px;
        font-size: 0.875rem; color: #495057; background: #f8f9fa; outline: none; transition: all 0.2s;
    }
    .filter-input { min-width: 250px; }
    .filter-input:focus, .filter-select:focus { border-color: #667eea; background: white; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }

    .filter-btn { padding: 0.625rem 1.25rem; background: #667eea; color: white; border: none; border-radius: 10px; font-size: 0.875rem; font-weight: 500; cursor: pointer; }
    .filter-btn:hover { background: #5a6fd6; }
    .filter-btn-clear { padding: 0.625rem 1rem; background: transparent; color: #6c757d; border: 1px solid #e9ecef; border-radius: 10px; font-size: 0.875rem; cursor: pointer; }

    .data-card { background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06); overflow: hidden; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead th { padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; background: #fafbfc; border-bottom: 1px solid #f0f0f0; }
    .data-table tbody td { padding: 1rem 1.5rem; border-bottom: 1px solid #f8f9fa; font-size: 0.875rem; vertical-align: middle; }
    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    .job-cell { display: flex; align-items: center; gap: 0.75rem; }
    .cell-icon { width: 36px; height: 36px; border-radius: 8px; background: #f3e5f5; color: #7b1fa2; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .cell-title { display: block; font-weight: 600; color: #1a1d29; }
    .cell-meta { display: block; font-size: 0.75rem; color: #6c757d; }
    .cell-text { font-weight: 500; color: #1a1d29; }
    .cell-text-muted { color: #6c757d; }

    .contract-badge { font-size: 0.75rem; font-weight: 500; padding: 0.25rem 0.5rem; border-radius: 6px; background: #f8f9fa; color: #495057; }

    .status-badge { font-size: 0.688rem; font-weight: 600; padding: 0.25rem 0.625rem; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.3px; }
    .status-active { background: #e8f5e9; color: #2e7d32; }
    .status-draft { background: #fff8e1; color: #f57f17; }
    .status-closed { background: #f5f5f5; color: #616161; }
    .status-filled { background: #e3f2fd; color: #1565c0; }

    .empty-cell { text-align: center; color: #6c757d; padding: 3rem 0 !important; }

    .pagination-bar { display: flex; justify-content: center; gap: 0.25rem; padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0; }
    .page-btn { padding: 0.5rem 0.75rem; border: none; background: transparent; border-radius: 8px; font-size: 0.813rem; color: #495057; cursor: pointer; }
    .page-btn:hover { background: #f0f0ff; color: #667eea; }
    .page-btn.active { background: #667eea; color: white; }
    .page-btn.disabled { color: #dee2e6; cursor: default; }
</style>
