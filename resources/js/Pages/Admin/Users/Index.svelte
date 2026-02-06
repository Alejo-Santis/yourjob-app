<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    export let users = { data: [], links: [] };
    export let filters = {};

    let search = filters.search || '';
    let typeFilter = filters.type || '';

    function applyFilters() {
        const params = {};
        if (search) params.search = search;
        if (typeFilter) params.type = typeFilter;
        router.get('/admin/users', params, { preserveState: true });
    }

    function clearFilters() {
        search = '';
        typeFilter = '';
        router.get('/admin/users');
    }
</script>

<AppLayout>
    <div class="admin-page">
        <div class="page-header">
            <div>
                <h1 class="page-title">Users</h1>
                <p class="page-subtitle">Manage all registered users on the platform</p>
            </div>
            <div class="header-stats">
                <span class="header-stat">{users.total || users.data?.length || 0} total users</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-row">
                <div class="filter-group">
                    <input
                        type="text"
                        class="filter-input"
                        placeholder="Search by email..."
                        bind:value={search}
                        on:keydown={(e) => e.key === 'Enter' && applyFilters()}
                    />
                </div>
                <div class="filter-group">
                    <select class="filter-select" bind:value={typeFilter} on:change={applyFilters}>
                        <option value="">All Types</option>
                        <option value="job_seeker">Job Seekers</option>
                        <option value="employer">Employers</option>
                        <option value="admin">Admins</option>
                    </select>
                </div>
                <button class="filter-btn" on:click={applyFilters}>
                    <i class="bi bi-search"></i> Search
                </button>
                {#if search || typeFilter}
                    <button class="filter-btn-clear" on:click={clearFilters}>
                        <i class="bi bi-x-lg"></i> Clear
                    </button>
                {/if}
            </div>
        </div>

        <!-- Users Table -->
        <div class="data-card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#if users.data && users.data.length > 0}
                            {#each users.data as user}
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="cell-avatar avatar-{user.user_type}">
                                                {user.email.charAt(0).toUpperCase()}
                                            </div>
                                            <span class="cell-email">{user.email}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="type-badge type-{user.user_type}">
                                            {user.user_type === 'job_seeker' ? 'Job Seeker' : user.user_type === 'employer' ? 'Employer' : 'Admin'}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-pill {user.is_active ? 'active' : 'inactive'}">
                                            <span class="status-dot-pill"></span>
                                            {user.is_active ? 'Active' : 'Inactive'}
                                        </span>
                                    </td>
                                    <td class="text-muted-cell">
                                        {new Date(user.created_at).toLocaleDateString()}
                                    </td>
                                </tr>
                            {/each}
                        {:else}
                            <tr>
                                <td colspan="4" class="empty-cell">No users found</td>
                            </tr>
                        {/if}
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {#if users.links && users.links.length > 3}
                <div class="pagination-bar">
                    {#each users.links as link}
                        {#if link.url}
                            <button
                                class="page-btn"
                                class:active={link.active}
                                on:click={() => router.get(link.url)}
                            >
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

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .page-title { font-size: 1.75rem; font-weight: 700; color: #1a1d29; margin-bottom: 0.25rem; }
    .page-subtitle { color: #6c757d; font-size: 0.938rem; margin: 0; }

    .header-stats { display: flex; gap: 1rem; }
    .header-stat {
        background: #f0f0ff;
        color: #667eea;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.813rem;
        font-weight: 600;
    }

    /* Filters */
    .filters-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.25rem;
    }

    .filters-row { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }

    .filter-input, .filter-select {
        padding: 0.625rem 1rem;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #495057;
        background: #f8f9fa;
        outline: none;
        transition: all 0.2s;
    }

    .filter-input { min-width: 250px; }

    .filter-input:focus, .filter-select:focus {
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-btn {
        padding: 0.625rem 1.25rem;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-btn:hover { background: #5a6fd6; }

    .filter-btn-clear {
        padding: 0.625rem 1rem;
        background: transparent;
        color: #6c757d;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        font-size: 0.875rem;
        cursor: pointer;
    }

    .filter-btn-clear:hover { background: #f8f9fa; }

    /* Data Card */
    .data-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #fafbfc;
        border-bottom: 1px solid #f0f0f0;
    }

    .data-table tbody td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f8f9fa;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .data-table tbody tr:hover { background: #fafbfc; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    .user-cell { display: flex; align-items: center; gap: 0.75rem; }

    .cell-avatar {
        width: 36px; height: 36px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.813rem; flex-shrink: 0;
    }

    .avatar-admin { background: #fce4ec; color: #e53935; }
    .avatar-employer { background: #e3f2fd; color: #1565c0; }
    .avatar-job_seeker { background: #e8f5e9; color: #2e7d32; }

    .cell-email { font-weight: 500; color: #1a1d29; }

    .type-badge {
        font-size: 0.688rem; font-weight: 600;
        padding: 0.25rem 0.625rem; border-radius: 6px;
        text-transform: uppercase; letter-spacing: 0.3px;
    }

    .type-job_seeker { background: #e8f5e9; color: #2e7d32; }
    .type-employer { background: #e3f2fd; color: #1565c0; }
    .type-admin { background: #fce4ec; color: #e53935; }

    .status-pill {
        display: inline-flex; align-items: center; gap: 0.375rem;
        font-size: 0.813rem; font-weight: 500;
    }

    .status-dot-pill {
        width: 7px; height: 7px; border-radius: 50%;
    }

    .status-pill.active .status-dot-pill { background: #38ef7d; }
    .status-pill.active { color: #2e7d32; }
    .status-pill.inactive .status-dot-pill { background: #e0e0e0; }
    .status-pill.inactive { color: #9e9e9e; }

    .text-muted-cell { color: #6c757d; }
    .empty-cell { text-align: center; color: #6c757d; padding: 3rem 0 !important; }

    /* Pagination */
    .pagination-bar {
        display: flex; justify-content: center; gap: 0.25rem;
        padding: 1rem 1.5rem; border-top: 1px solid #f0f0f0;
    }

    .page-btn {
        padding: 0.5rem 0.75rem; border: none; background: transparent;
        border-radius: 8px; font-size: 0.813rem; color: #495057;
        cursor: pointer; transition: all 0.2s;
    }

    .page-btn:hover { background: #f0f0ff; color: #667eea; }
    .page-btn.active { background: #667eea; color: white; }
    .page-btn.disabled { color: #dee2e6; cursor: default; }
</style>
