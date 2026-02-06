<script>
    import AppLayout from '../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    export let applications = { data: [] };
    export let userType = 'job_seeker';
    export let status = null;

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
            <h1 class="h2 mb-1">My Applications</h1>
            <p class="text-muted">
                {#if userType === 'job_seeker'}
                    Track your job applications and their status
                {:else}
                    Review applications received for your job listings
                {/if}
            </p>
        </div>

        {#if applications.data && applications.data.length > 0}
            <div class="card shadow-sm">
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
