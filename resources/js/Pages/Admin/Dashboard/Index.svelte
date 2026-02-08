<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';

    let { stats = {} } = $props();

    function formatNumber(num) {
        if (num >= 1000) return (num / 1000).toFixed(1) + 'k';
        return num?.toString() || '0';
    }
</script>

<AppLayout>
    <div class="admin-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard</h1>
                <p class="dashboard-subtitle">Welcome back! Here's what's happening with your platform.</p>
            </div>
        </div>

        <!-- Main Stats Row -->
        <div class="stats-row">
            <div class="stat-card stat-gradient-primary">
                <div class="stat-body">
                    <div class="stat-info">
                        <span class="stat-label">Total Users</span>
                        <h3 class="stat-value">{formatNumber(stats.total_users)}</h3>
                        <span class="stat-detail">
                            <i class="bi bi-people-fill me-1"></i>
                            {stats.total_job_seekers} seekers, {stats.total_employers} employers
                        </span>
                    </div>
                    <div class="stat-icon-circle">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card stat-gradient-success">
                <div class="stat-body">
                    <div class="stat-info">
                        <span class="stat-label">Active Jobs</span>
                        <h3 class="stat-value">{formatNumber(stats.active_jobs)}</h3>
                        <span class="stat-detail">
                            <i class="bi bi-briefcase-fill me-1"></i>
                            {stats.total_jobs} total listings
                        </span>
                    </div>
                    <div class="stat-icon-circle">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card stat-gradient-warning">
                <div class="stat-body">
                    <div class="stat-info">
                        <span class="stat-label">Applications</span>
                        <h3 class="stat-value">{formatNumber(stats.total_applications)}</h3>
                        <span class="stat-detail">
                            <i class="bi bi-clock-fill me-1"></i>
                            {stats.pending_applications} pending review
                        </span>
                    </div>
                    <div class="stat-icon-circle">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card stat-gradient-info">
                <div class="stat-body">
                    <div class="stat-info">
                        <span class="stat-label">Job Seekers</span>
                        <h3 class="stat-value">{formatNumber(stats.total_job_seekers)}</h3>
                        <span class="stat-detail">
                            <i class="bi bi-building me-1"></i>
                            {stats.total_employers} employers
                        </span>
                    </div>
                    <div class="stat-icon-circle">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Section: Overview Cards -->
        <div class="row g-4 mb-4">
            <!-- Jobs Overview -->
            <div class="col-lg-4">
                <div class="overview-card">
                    <div class="overview-header">
                        <h6 class="overview-title">Jobs Overview</h6>
                        <a href="/admin/jobs" class="overview-link">View all</a>
                    </div>
                    <div class="overview-body">
                        <div class="overview-item">
                            <div class="overview-dot dot-success"></div>
                            <span class="overview-label">Active</span>
                            <span class="overview-value">{stats.active_jobs || 0}</span>
                        </div>
                        <div class="overview-item">
                            <div class="overview-dot dot-warning"></div>
                            <span class="overview-label">Draft</span>
                            <span class="overview-value">{stats.draft_jobs || 0}</span>
                        </div>
                        <div class="overview-item">
                            <div class="overview-dot dot-secondary"></div>
                            <span class="overview-label">Closed</span>
                            <span class="overview-value">{stats.closed_jobs || 0}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Overview -->
            <div class="col-lg-4">
                <div class="overview-card">
                    <div class="overview-header">
                        <h6 class="overview-title">Applications Overview</h6>
                        <a href="/admin/applications" class="overview-link">View all</a>
                    </div>
                    <div class="overview-body">
                        <div class="overview-item">
                            <div class="overview-dot dot-warning"></div>
                            <span class="overview-label">Pending</span>
                            <span class="overview-value">{stats.pending_applications || 0}</span>
                        </div>
                        <div class="overview-item">
                            <div class="overview-dot dot-success"></div>
                            <span class="overview-label">Accepted</span>
                            <span class="overview-value">{stats.accepted_applications || 0}</span>
                        </div>
                        <div class="overview-item">
                            <div class="overview-dot dot-danger"></div>
                            <span class="overview-label">Rejected</span>
                            <span class="overview-value">{stats.rejected_applications || 0}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="overview-card">
                    <div class="overview-header">
                        <h6 class="overview-title">Quick Actions</h6>
                    </div>
                    <div class="overview-body">
                        <a href="/admin/users" class="quick-action-btn">
                            <i class="bi bi-people"></i>
                            <span>Manage Users</span>
                        </a>
                        <a href="/admin/jobs" class="quick-action-btn">
                            <i class="bi bi-briefcase"></i>
                            <span>Manage Jobs</span>
                        </a>
                        <a href="/admin/applications" class="quick-action-btn">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>Review Applications</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="row g-4">
            <!-- Recent Users -->
            <div class="col-lg-6">
                <div class="table-card">
                    <div class="table-card-header">
                        <h6 class="table-card-title">
                            <i class="bi bi-people me-2"></i>Recent Users
                        </h6>
                        <a href="/admin/users" class="table-card-link">See all</a>
                    </div>
                    <div class="table-card-body">
                        {#if stats.recent_users && stats.recent_users.length > 0}
                            {#each stats.recent_users as user}
                                <div class="table-row">
                                    <div class="table-row-avatar">
                                        <div class="avatar avatar-{user.user_type}">
                                            {user.email.charAt(0).toUpperCase()}
                                        </div>
                                    </div>
                                    <div class="table-row-info">
                                        <span class="table-row-name">{user.email}</span>
                                        <span class="table-row-meta">{new Date(user.created_at).toLocaleDateString()}</span>
                                    </div>
                                    <div class="table-row-badge">
                                        <span class="type-badge type-{user.user_type}">
                                            {user.user_type === 'job_seeker' ? 'Seeker' : user.user_type === 'employer' ? 'Employer' : 'Admin'}
                                        </span>
                                    </div>
                                    <div class="table-row-status">
                                        <span class="status-dot {user.is_active ? 'active' : 'inactive'}"></span>
                                    </div>
                                </div>
                            {/each}
                        {:else}
                            <p class="empty-state">No users yet</p>
                        {/if}
                    </div>
                </div>
            </div>

            <!-- Recent Jobs -->
            <div class="col-lg-6">
                <div class="table-card">
                    <div class="table-card-header">
                        <h6 class="table-card-title">
                            <i class="bi bi-briefcase me-2"></i>Recent Job Listings
                        </h6>
                        <a href="/admin/jobs" class="table-card-link">See all</a>
                    </div>
                    <div class="table-card-body">
                        {#if stats.recent_jobs && stats.recent_jobs.length > 0}
                            {#each stats.recent_jobs as job}
                                <div class="table-row">
                                    <div class="table-row-avatar">
                                        <div class="avatar avatar-job">
                                            <i class="bi bi-briefcase-fill"></i>
                                        </div>
                                    </div>
                                    <div class="table-row-info">
                                        <span class="table-row-name">{job.title}</span>
                                        <span class="table-row-meta">{job.employer?.company_name || 'N/A'}</span>
                                    </div>
                                    <div class="table-row-badge">
                                        <span class="status-badge status-{job.status}">
                                            {job.status}
                                        </span>
                                    </div>
                                </div>
                            {/each}
                        {:else}
                            <p class="empty-state">No job listings yet</p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .admin-dashboard {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header */
    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1d29;
        margin-bottom: 0.25rem;
    }

    .dashboard-subtitle {
        color: #6c757d;
        font-size: 0.938rem;
        margin: 0;
    }

    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
    }

    .stat-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .stat-gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    .stat-body {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        z-index: 1;
    }

    .stat-label {
        font-size: 0.813rem;
        font-weight: 500;
        opacity: 0.85;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.25rem 0;
    }

    .stat-detail {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    .stat-icon-circle {
        width: 52px;
        height: 52px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Overview Cards */
    .overview-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        height: 100%;
    }

    .overview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .overview-title {
        font-weight: 600;
        color: #1a1d29;
        margin: 0;
    }

    .overview-link {
        font-size: 0.813rem;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }

    .overview-link:hover {
        text-decoration: underline;
    }

    .overview-body {
        padding: 1.25rem 1.5rem;
    }

    .overview-item {
        display: flex;
        align-items: center;
        padding: 0.625rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .overview-item:last-child {
        border-bottom: none;
    }

    .overview-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }

    .dot-success { background: #38ef7d; }
    .dot-warning { background: #ffc107; }
    .dot-danger { background: #f5576c; }
    .dot-secondary { background: #adb5bd; }

    .overview-label {
        flex: 1;
        font-size: 0.875rem;
        color: #495057;
    }

    .overview-value {
        font-weight: 700;
        font-size: 0.938rem;
        color: #1a1d29;
    }

    /* Quick Actions */
    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 10px;
        text-decoration: none;
        color: #495057;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        margin-bottom: 0.5rem;
    }

    .quick-action-btn:last-child {
        margin-bottom: 0;
    }

    .quick-action-btn:hover {
        background: #f0f0ff;
        color: #667eea;
    }

    .quick-action-btn i {
        font-size: 1.125rem;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .quick-action-btn:hover i {
        background: #667eea;
        color: white;
    }

    /* Table Cards */
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .table-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-card-title {
        font-weight: 600;
        color: #1a1d29;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .table-card-link {
        font-size: 0.813rem;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }

    .table-card-body {
        padding: 0.75rem 1.5rem;
    }

    .table-row {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
        gap: 0.75rem;
    }

    .table-row:last-child {
        border-bottom: none;
    }

    /* Avatars */
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .avatar-admin { background: #fce4ec; color: #e53935; }
    .avatar-employer { background: #e3f2fd; color: #1565c0; }
    .avatar-job_seeker { background: #e8f5e9; color: #2e7d32; }
    .avatar-job { background: #f3e5f5; color: #7b1fa2; }

    .table-row-info {
        flex: 1;
        min-width: 0;
    }

    .table-row-name {
        display: block;
        font-weight: 600;
        font-size: 0.875rem;
        color: #1a1d29;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table-row-meta {
        display: block;
        font-size: 0.75rem;
        color: #6c757d;
    }

    /* Badges */
    .type-badge {
        font-size: 0.688rem;
        font-weight: 600;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .type-job_seeker { background: #e8f5e9; color: #2e7d32; }
    .type-employer { background: #e3f2fd; color: #1565c0; }
    .type-admin { background: #fce4ec; color: #e53935; }

    .status-badge {
        font-size: 0.688rem;
        font-weight: 600;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-active { background: #e8f5e9; color: #2e7d32; }
    .status-draft { background: #fff8e1; color: #f57f17; }
    .status-closed { background: #f5f5f5; color: #616161; }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .status-dot.active { background: #38ef7d; }
    .status-dot.inactive { background: #e0e0e0; }

    .empty-state {
        text-align: center;
        color: #6c757d;
        padding: 2rem 0;
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: 1fr;
        }

        .stat-value {
            font-size: 1.5rem;
        }
    }
</style>
