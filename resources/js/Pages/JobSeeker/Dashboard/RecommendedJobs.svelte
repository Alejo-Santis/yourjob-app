<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import JobCard from '../../../Components/JobCard.svelte';
    import { router } from '@inertiajs/svelte';

    export let jobs = { data: [] };

    function handleApply(jobId) {
        router.post('/applications', { job_listing_id: jobId });
    }

    function handleFavoriteToggle(jobId) {
        router.post(`/favorites/jobs/${jobId}/toggle`, {}, {
            preserveScroll: true
        });
    }
</script>

<AppLayout>
    <div class="recommended-jobs-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Recommended Jobs</h1>
            <p class="text-muted">Jobs matching your profile and preferences</p>
        </div>

        {#if jobs.data && jobs.data.length > 0}
            <div class="row g-3">
                {#each jobs.data as job}
                    <div class="col-lg-4 col-md-6">
                        <JobCard
                            {job}
                            onApply={() => handleApply(job.id)}
                            onFavorite={() => handleFavoriteToggle(job.id)}
                            isFavorited={job.is_favorited || false}
                            isApplied={job.is_applied || false}
                            matchScore={job.match_score}
                        />
                    </div>
                {/each}
            </div>

            <!-- Pagination -->
            {#if jobs.links && jobs.links.length > 3}
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {#each jobs.links as link}
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
                    <h5 class="mt-3 mb-2">No Recommended Jobs</h5>
                    <p class="text-muted mb-4">
                        Complete your profile to get personalized job recommendations
                    </p>
                    <a href="/job-seeker/profile/edit" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Complete Profile
                    </a>
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .recommended-jobs-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }
</style>
