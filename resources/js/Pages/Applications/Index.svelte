<script>
    import AppLayout from '../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    let { applications = { data: [] }, userType = 'job_seeker', status = null } = $props();

    function getStatusColor(appStatus) {
        const colors = {
            pending: 'warning',
            accepted: 'success',
            rejected: 'danger',
            withdrawn: 'secondary',
        };
        return colors[appStatus] || 'secondary';
    }
</script>

<AppLayout>
    <div class="applications-container">
        <div class="mb-4">
            <h1 class="page-title">My Applications</h1>
            <p class="text-muted">
                {#if userType === 'job_seeker'}
                    Track your job applications and their status
                {:else}
                    Review applications received for your job listings
                {/if}
            </p>
        </div>

        {#if applications.data && applications.data.length > 0}
            <!-- Desktop: Table view -->
            <div class="card shadow-sm desktop-view">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    {#if userType === 'job_seeker'}
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Location</th>
                                    {:else}
                                        <th>Candidate</th>
                                        <th>Job Position</th>
                                        <th>Email</th>
                                    {/if}
                                    <th>Applied Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {#each applications.data as application}
                                    <tr>
                                        {#if userType === 'job_seeker'}
                                            <td>
                                                <a
                                                    href="/jobs/{application.job_listing?.id}"
                                                    class="text-decoration-none fw-semibold"
                                                >
                                                    {application.job_listing?.title}
                                                </a>
                                            </td>
                                            <td>
                                                {application.job_listing?.employer?.company_name || 'Unknown'}
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    {application.job_listing?.city}, {application.job_listing?.state}
                                                </small>
                                            </td>
                                        {:else}
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-2">
                                                        {application.job_seeker?.full_name?.charAt(0).toUpperCase() || 'U'}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">
                                                            {application.job_seeker?.full_name || 'Unknown'}
                                                        </div>
                                                        <small class="text-muted">
                                                            {application.job_seeker?.profession || 'N/A'}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a
                                                    href="/jobs/{application.job_listing?.id}"
                                                    class="text-decoration-none fw-semibold"
                                                >
                                                    {application.job_listing?.title}
                                                </a>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {application.job_seeker?.user?.email || 'N/A'}
                                                </small>
                                            </td>
                                        {/if}
                                        <td>
                                            <small class="text-muted">
                                                {new Date(application.applied_at).toLocaleDateString()}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{getStatusColor(application.status)}">
                                                {application.status}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a
                                                href="/applications/{application.id}"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                <i class="bi bi-eye me-1"></i>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                {/each}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mobile: Card view -->
            <div class="mobile-view">
                {#each applications.data as application}
                    <div class="app-card">
                        <div class="app-card-header">
                            {#if userType === 'job_seeker'}
                                <a href="/jobs/{application.job_listing?.id}" class="app-card-title">
                                    {application.job_listing?.title}
                                </a>
                                <span class="badge bg-{getStatusColor(application.status)}">
                                    {application.status}
                                </span>
                            {:else}
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle-sm">
                                        {application.job_seeker?.full_name?.charAt(0).toUpperCase() || 'U'}
                                    </div>
                                    <span class="app-card-title">{application.job_seeker?.full_name || 'Unknown'}</span>
                                </div>
                                <span class="badge bg-{getStatusColor(application.status)}">
                                    {application.status}
                                </span>
                            {/if}
                        </div>

                        <div class="app-card-body">
                            {#if userType === 'job_seeker'}
                                <div class="app-card-row">
                                    <i class="bi bi-building"></i>
                                    <span>{application.job_listing?.employer?.company_name || 'Unknown'}</span>
                                </div>
                                <div class="app-card-row">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{application.job_listing?.city}, {application.job_listing?.state}</span>
                                </div>
                            {:else}
                                <div class="app-card-row">
                                    <i class="bi bi-briefcase"></i>
                                    <a href="/jobs/{application.job_listing?.id}" class="text-decoration-none">
                                        {application.job_listing?.title}
                                    </a>
                                </div>
                                <div class="app-card-row">
                                    <i class="bi bi-envelope"></i>
                                    <span>{application.job_seeker?.user?.email || 'N/A'}</span>
                                </div>
                            {/if}
                            <div class="app-card-row">
                                <i class="bi bi-calendar3"></i>
                                <span>{new Date(application.applied_at).toLocaleDateString()}</span>
                            </div>
                        </div>

                        <a href="/applications/{application.id}" class="app-card-action">
                            View Details
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                {/each}
            </div>

            <!-- Pagination -->
            {#if applications.links && applications.links.length > 3}
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {#each applications.links as link}
                            <li class="page-item {link.active ? 'active' : ''} {!link.url ? 'disabled' : ''}">
                                {#if link.url}
                                    <button
                                        class="page-link"
                                        onclick={() => router.visit(link.url)}
                                    >
                                        {@html link.label}
                                    </button>
                                {:else}
                                    <span class="page-link">{@html link.label}</span>
                                {/if}
                            </li>
                        {/each}
                    </ul>
                </nav>
            {/if}
        {:else}
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3.5rem;"></i>
                    <h5 class="mt-3 mb-2">No Applications</h5>
                    <p class="text-muted mb-4">
                        {#if userType === 'job_seeker'}
                            You haven't applied to any jobs yet
                        {:else}
                            No applications received yet
                        {/if}
                    </p>
                    {#if userType === 'job_seeker'}
                        <a href="/jobs" class="btn btn-primary">
                            <i class="bi bi-search me-2"></i>Browse Jobs
                        </a>
                    {/if}
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .applications-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1d29;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* ── Mobile Card View ── */
    .mobile-view {
        display: none;
    }

    .app-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        margin-bottom: 0.75rem;
        overflow: hidden;
    }

    .app-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        gap: 0.75rem;
    }

    .app-card-title {
        font-weight: 600;
        font-size: 0.925rem;
        color: #1e293b;
        text-decoration: none;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        min-width: 0;
    }

    a.app-card-title:hover {
        color: #3b82f6;
    }

    .avatar-circle-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .app-card-body {
        padding: 0.65rem 1rem;
    }

    .app-card-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.3rem 0;
        font-size: 0.825rem;
        color: #64748b;
    }

    .app-card-row i {
        font-size: 0.85rem;
        width: 16px;
        text-align: center;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .app-card-row span,
    .app-card-row a {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .app-card-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-top: 1px solid #f1f5f9;
        color: #3b82f6;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: background 0.15s;
        min-height: 48px;
    }

    .app-card-action:hover {
        background: #f8fafc;
    }

    .app-card-action i {
        font-size: 0.75rem;
    }

    /* ── Pagination touch targets ── */
    .page-link {
        min-width: 44px;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .desktop-view {
            display: none;
        }

        .mobile-view {
            display: block;
        }

        .page-title {
            font-size: 1.3rem;
        }
    }
</style>
