<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router, page } from '@inertiajs/svelte';

    let { applications = { data: [] }, status = null } = $props();

    function filterByStatus(newStatus) {
        const url = newStatus ? `/employer/applications?status=${newStatus}` : '/employer/applications';
        router.visit(url);
    }

    function getStatusColor(appStatus) {
        const colors = { pending: 'warning', accepted: 'success', rejected: 'danger', withdrawn: 'secondary' };
        return colors[appStatus] || 'secondary';
    }
</script>

<AppLayout>
    <div class="applications-container">
        <div class="mb-4">
            <h1 class="page-title">Applications</h1>
            <p class="text-muted mb-0">Review and manage job applications</p>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body filter-body">
                <div class="btn-group filter-group" role="group">
                    <button class="btn {!status ? 'btn-primary' : 'btn-outline-primary'}" onclick={() => filterByStatus(null)}>All</button>
                    <button class="btn {status === 'pending' ? 'btn-warning' : 'btn-outline-warning'}" onclick={() => filterByStatus('pending')}>Pending</button>
                    <button class="btn {status === 'accepted' ? 'btn-success' : 'btn-outline-success'}" onclick={() => filterByStatus('accepted')}>Accepted</button>
                    <button class="btn {status === 'rejected' ? 'btn-danger' : 'btn-outline-danger'}" onclick={() => filterByStatus('rejected')}>Rejected</button>
                </div>
            </div>
        </div>

        {#if applications.data && applications.data.length > 0}
            <!-- Desktop: Table -->
            <div class="card shadow-sm desktop-view">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Candidate</th>
                                    <th>Job Position</th>
                                    <th>Applied Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {#each applications.data as application}
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    {application.job_seeker?.full_name?.charAt(0).toUpperCase() || 'U'}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{application.job_seeker?.full_name || 'Unknown'}</div>
                                                    <small class="text-muted">{application.job_seeker?.profession || 'N/A'}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="/jobs/{application.job_listing?.id}" class="text-decoration-none fw-semibold">{application.job_listing?.title}</a>
                                            <br /><small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{application.job_listing?.city}</small>
                                        </td>
                                        <td><small class="text-muted">{new Date(application.applied_at).toLocaleDateString()}</small></td>
                                        <td><span class="badge bg-{getStatusColor(application.status)}">{application.status}</span></td>
                                        <td class="text-end">
                                            <a href="/applications/{application.id}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>View Details
                                            </a>
                                        </td>
                                    </tr>
                                {/each}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mobile: Cards -->
            <div class="mobile-view">
                {#each applications.data as application}
                    <div class="app-card">
                        <div class="app-card-header">
                            <div class="d-flex align-items-center gap-2 min-width-0">
                                <div class="avatar-circle-sm">
                                    {application.job_seeker?.full_name?.charAt(0).toUpperCase() || 'U'}
                                </div>
                                <div class="min-width-0">
                                    <div class="app-card-name">{application.job_seeker?.full_name || 'Unknown'}</div>
                                    <div class="app-card-profession">{application.job_seeker?.profession || 'N/A'}</div>
                                </div>
                            </div>
                            <span class="badge bg-{getStatusColor(application.status)}">{application.status}</span>
                        </div>

                        <div class="app-card-body">
                            <div class="app-card-row">
                                <i class="bi bi-briefcase"></i>
                                <a href="/jobs/{application.job_listing?.id}" class="text-decoration-none app-card-job-link">
                                    {application.job_listing?.title}
                                </a>
                            </div>
                            <div class="app-card-row">
                                <i class="bi bi-geo-alt"></i>
                                <span>{application.job_listing?.city}</span>
                            </div>
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

            {#if applications.links && applications.links.length > 3}
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {#each applications.links as link}
                            <li class="page-item {link.active ? 'active' : ''} {!link.url ? 'disabled' : ''}">
                                {#if link.url}
                                    <button class="page-link" onclick={() => router.visit(link.url)}>{@html link.label}</button>
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
                    <p class="text-muted mb-0">
                        {#if status}No applications with status: {status}{:else}No applications received yet{/if}
                    </p>
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .applications-container { max-width: 1400px; margin: 0 auto; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: #1a1d29; }
    .card { border: none; border-radius: 0.75rem; }
    .table th { font-weight: 600; font-size: 0.8rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.05em; }
    .avatar-circle { width: 40px; height: 40px; border-radius: 50%; background-color: #0d6efd; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.1rem; flex-shrink: 0; }
    .min-width-0 { min-width: 0; }

    /* ── Filter buttons ── */
    .filter-group { width: 100%; }

    /* ── Mobile Cards ── */
    .mobile-view { display: none; }

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

    .avatar-circle-sm {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .app-card-name {
        font-weight: 600;
        font-size: 0.925rem;
        color: #1e293b;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .app-card-profession {
        font-size: 0.775rem;
        color: #94a3b8;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .app-card-body { padding: 0.65rem 1rem; }

    .app-card-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.25rem 0;
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
    .app-card-job-link {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .app-card-job-link {
        color: #3b82f6;
        font-weight: 500;
    }

    .app-card-job-link:hover { color: #2563eb; }

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

    .app-card-action:hover { background: #f8fafc; }
    .app-card-action i { font-size: 0.75rem; }

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
        .desktop-view { display: none; }
        .mobile-view { display: block; }
        .page-title { font-size: 1.3rem; }

        .filter-body { padding: 0.75rem; }
        .filter-group .btn {
            font-size: 0.8rem;
            padding: 0.5rem 0.25rem;
            min-height: 44px;
        }
    }
</style>
