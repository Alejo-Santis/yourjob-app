<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';
    import { page } from '@inertiajs/svelte';

    export let applications = { data: [] };
    export let status = null;

    function filterByStatus(newStatus) {
        const url = newStatus ? `/employer/applications?status=${newStatus}` : '/employer/applications';
        router.visit(url);
    }

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
            <h1 class="h2 mb-1">Applications</h1>
            <p class="text-muted">Review and manage job applications</p>
        </div>

        <!-- Filter Tabs -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="btn-group w-100" role="group">
                    <button
                        class="btn {!status ? 'btn-primary' : 'btn-outline-primary'}"
                        on:click={() => filterByStatus(null)}
                    >
                        All
                    </button>
                    <button
                        class="btn {status === 'pending' ? 'btn-warning' : 'btn-outline-warning'}"
                        on:click={() => filterByStatus('pending')}
                    >
                        Pending
                    </button>
                    <button
                        class="btn {status === 'accepted' ? 'btn-success' : 'btn-outline-success'}"
                        on:click={() => filterByStatus('accepted')}
                    >
                        Accepted
                    </button>
                    <button
                        class="btn {status === 'rejected' ? 'btn-danger' : 'btn-outline-danger'}"
                        on:click={() => filterByStatus('rejected')}
                    >
                        Rejected
                    </button>
                </div>
            </div>
        </div>

        {#if applications.data && applications.data.length > 0}
            <div class="card shadow-sm">
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
                                            <br />
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {application.job_listing?.city}
                                            </small>
                                        </td>
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
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                {/each}
                            </tbody>
                        </table>
                    </div>
                </div>
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
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">No Applications</h5>
                    <p class="text-muted mb-0">
                        {#if status}
                            No applications with status: {status}
                        {:else}
                            No applications received yet
                        {/if}
                    </p>
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
    }
</style>
