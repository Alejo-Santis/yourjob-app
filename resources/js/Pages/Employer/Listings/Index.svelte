<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    export let listings = { data: [] };

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
        const colors = {
            draft: 'secondary',
            active: 'success',
            closed: 'danger',
            paused: 'warning',
        };
        return colors[status] || 'secondary';
    }
</script>

<AppLayout>
    <div class="listings-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Job Listings</h1>
                <p class="text-muted">Manage your job postings</p>
            </div>
            <a href="/employer/jobs/create" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Post New Job
            </a>
        </div>

        {#if listings.data && listings.data.length > 0}
            <div class="card shadow-sm">
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
                                            <a href="/jobs/{listing.id}" class="text-decoration-none fw-semibold">
                                                {listing.title}
                                            </a>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {listing.city}, {listing.state}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary">
                                                {listing.contract_type}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{getStatusColor(listing.status)}">
                                                {listing.status}
                                            </span>
                                        </td>
                                        <td class="text-center">{listing.view_count || 0}</td>
                                        <td class="text-center">{listing.applications_count || 0}</td>
                                        <td>
                                            <small class="text-muted">
                                                {listing.posted_at ? new Date(listing.posted_at).toLocaleDateString() : 'Not posted'}
                                            </small>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a
                                                    href="/jobs/{listing.id}"
                                                    class="btn btn-outline-secondary"
                                                    title="View"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a
                                                    href="/employer/jobs/{listing.id}/edit"
                                                    class="btn btn-outline-primary"
                                                    title="Edit"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                {#if listing.status === 'draft'}
                                                    <button
                                                        class="btn btn-outline-success"
                                                        on:click={() => handlePublish(listing.id)}
                                                        title="Publish"
                                                    >
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                {:else if listing.status === 'active'}
                                                    <button
                                                        class="btn btn-outline-warning"
                                                        on:click={() => handleClose(listing.id)}
                                                        title="Close"
                                                    >
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                {/if}
                                                <button
                                                    class="btn btn-outline-danger"
                                                    on:click={() => handleDelete(listing.id)}
                                                    title="Delete"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                {/each}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            {#if listings.links && listings.links.length > 3}
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {#each listings.links as link}
                            <li class="page-item {link.active ? 'active' : ''} {!link.url ? 'disabled' : ''}">
                                {#if link.url}
                                    <button
                                        class="page-link"
                                        on:click={() => router.visit(link.url)}
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
                    <i class="bi bi-briefcase text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">No Job Listings</h5>
                    <p class="text-muted mb-4">You haven't posted any jobs yet</p>
                    <a href="/employer/jobs/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Post Your First Job
                    </a>
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .listings-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>
