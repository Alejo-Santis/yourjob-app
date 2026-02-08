<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    let { listings = { data: [] } } = $props();

    function handlePublish(listingId) {
        router.post(`/employer/jobs/${listingId}/publish`);
    }

    function handleClose(listingId) {
        if (confirm('Are you sure you want to close this job listing?')) {
            router.post(`/employer/jobs/${listingId}/close`);
        }
    }

    function handleDelete(listingId) {
        if (confirm('Are you sure you want to delete this job listing? This action cannot be undone.')) {
            router.delete(`/employer/jobs/${listingId}`);
        }
    }

    function getStatusColor(status) {
        const colors = { draft: 'secondary', active: 'success', closed: 'danger', paused: 'warning' };
        return colors[status] || 'secondary';
    }
</script>

<AppLayout>
    <div class="listings-container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="page-title">Job Listings</h1>
                <p class="text-muted mb-0">Manage your job postings</p>
            </div>
            <a href="/employer/jobs/create" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Post New Job
            </a>
        </div>

        {#if listings.data && listings.data.length > 0}
            <!-- Desktop: Table -->
            <div class="card shadow-sm desktop-view">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Job Title</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Applications</th>
                                    <th>Posted Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {#each listings.data as listing}
                                    <tr>
                                        <td>
                                            <a href="/jobs/{listing.id}" class="text-decoration-none fw-semibold">{listing.title}</a>
                                        </td>
                                        <td><small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{listing.city}, {listing.state}</small></td>
                                        <td><span class="badge bg-primary-subtle text-primary">{listing.contract_type}</span></td>
                                        <td><span class="badge bg-{getStatusColor(listing.status)}">{listing.status}</span></td>
                                        <td class="text-center">{listing.view_count || 0}</td>
                                        <td class="text-center">{listing.applications_count || 0}</td>
                                        <td><small class="text-muted">{listing.posted_at ? new Date(listing.posted_at).toLocaleDateString() : 'Not posted'}</small></td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="/jobs/{listing.id}" class="btn btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                                                <a href="/employer/jobs/{listing.id}/edit" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                                {#if listing.status === 'draft'}
                                                    <button class="btn btn-outline-success" onclick={() => handlePublish(listing.id)} title="Publish"><i class="bi bi-check-circle"></i></button>
                                                {:else if listing.status === 'active'}
                                                    <button class="btn btn-outline-warning" onclick={() => handleClose(listing.id)} title="Close"><i class="bi bi-x-circle"></i></button>
                                                {/if}
                                                <button class="btn btn-outline-danger" onclick={() => handleDelete(listing.id)} title="Delete"><i class="bi bi-trash"></i></button>
                                            </div>
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
                {#each listings.data as listing}
                    <div class="listing-card">
                        <div class="listing-card-header">
                            <a href="/jobs/{listing.id}" class="listing-card-title">{listing.title}</a>
                            <span class="badge bg-{getStatusColor(listing.status)}">{listing.status}</span>
                        </div>

                        <div class="listing-card-body">
                            <div class="listing-card-row">
                                <i class="bi bi-geo-alt"></i>
                                <span>{listing.city}, {listing.state}</span>
                            </div>
                            <div class="listing-card-row">
                                <i class="bi bi-briefcase"></i>
                                <span>{listing.contract_type}</span>
                            </div>
                            <div class="listing-card-row">
                                <i class="bi bi-calendar3"></i>
                                <span>{listing.posted_at ? new Date(listing.posted_at).toLocaleDateString() : 'Not posted'}</span>
                            </div>
                            <div class="listing-card-stats">
                                <div class="listing-stat">
                                    <i class="bi bi-eye"></i>
                                    <span>{listing.view_count || 0} views</span>
                                </div>
                                <div class="listing-stat">
                                    <i class="bi bi-file-earmark-text"></i>
                                    <span>{listing.applications_count || 0} apps</span>
                                </div>
                            </div>
                        </div>

                        <div class="listing-card-actions">
                            <a href="/jobs/{listing.id}" class="listing-action-btn">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="/employer/jobs/{listing.id}/edit" class="listing-action-btn action-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            {#if listing.status === 'draft'}
                                <button class="listing-action-btn action-success" onclick={() => handlePublish(listing.id)}>
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            {:else if listing.status === 'active'}
                                <button class="listing-action-btn action-warning" onclick={() => handleClose(listing.id)}>
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            {/if}
                            <button class="listing-action-btn action-danger" onclick={() => handleDelete(listing.id)}>
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                {/each}
            </div>

            {#if listings.links && listings.links.length > 3}
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {#each listings.links as link}
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
                    <i class="bi bi-briefcase text-muted" style="font-size: 3.5rem;"></i>
                    <h5 class="mt-3 mb-2">No Job Listings</h5>
                    <p class="text-muted mb-4">You haven't posted any jobs yet</p>
                    <a href="/employer/jobs/create" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Post Your First Job</a>
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .listings-container { max-width: 1400px; margin: 0 auto; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: #1a1d29; }
    .card { border: none; border-radius: 0.75rem; }
    .table th { font-weight: 600; font-size: 0.8rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.05em; }

    /* ── Mobile Cards ── */
    .mobile-view { display: none; }

    .listing-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        margin-bottom: 0.75rem;
        overflow: hidden;
    }

    .listing-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        gap: 0.75rem;
    }

    .listing-card-title {
        font-weight: 600;
        font-size: 0.925rem;
        color: #1e293b;
        text-decoration: none;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        min-width: 0;
    }

    .listing-card-title:hover { color: #3b82f6; }

    .listing-card-body { padding: 0.65rem 1rem; }

    .listing-card-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.25rem 0;
        font-size: 0.825rem;
        color: #64748b;
    }

    .listing-card-row i {
        font-size: 0.85rem;
        width: 16px;
        text-align: center;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .listing-card-stats {
        display: flex;
        gap: 1rem;
        padding-top: 0.5rem;
        margin-top: 0.35rem;
        border-top: 1px solid #f8fafc;
    }

    .listing-stat {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }

    .listing-stat i { color: #94a3b8; font-size: 0.85rem; }

    .listing-card-actions {
        display: flex;
        border-top: 1px solid #f1f5f9;
    }

    .listing-action-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.7rem;
        background: none;
        border: none;
        border-right: 1px solid #f1f5f9;
        color: #64748b;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        min-height: 48px;
        transition: background 0.15s;
    }

    .listing-action-btn:last-child { border-right: none; }
    .listing-action-btn:hover { background: #f8fafc; }
    .listing-action-btn.action-primary { color: #3b82f6; }
    .listing-action-btn.action-success { color: #22c55e; }
    .listing-action-btn.action-warning { color: #f59e0b; }
    .listing-action-btn.action-danger { color: #ef4444; }

    .page-link {
        min-width: 44px;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .desktop-view { display: none; }
        .mobile-view { display: block; }
        .page-title { font-size: 1.3rem; }
    }
</style>
