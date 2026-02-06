<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import JobCard from '../../../Components/JobCard.svelte';
    import { router } from '@inertiajs/svelte';

    export let matches = { data: [] };

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
    <div class="matched-jobs-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Matched Jobs</h1>
            <p class="text-muted">Jobs with high compatibility based on your skills and experience</p>
        </div>

        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle me-2"></i>
            These jobs have a match score of 75% or higher based on your profile
        </div>

        {#if matches.data && matches.data.length > 0}
            <div class="row g-3">
                {#each matches.data as match}
                    {@const job = match.job_listing}
                    <div class="col-lg-4 col-md-6">
                        <JobCard
                            {job}
                            onApply={() => handleApply(job.id)}
                            onFavorite={() => handleFavoriteToggle(job.id)}
                            isFavorited={job.is_favorited || false}
                            isApplied={job.is_applied || false}
                            matchScore={match.match_score}
                        />
                    </div>
                {/each}
            </div>

            <!-- Pagination -->
            {#if matches.links && matches.links.length > 3}
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {#each matches.links as link}
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
                    <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">No Matched Jobs Yet</h5>
                    <p class="text-muted mb-4">
                        We're working on finding the best matches for you. Check back soon or browse all jobs.
                    </p>
                    <a href="/jobs" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Browse All Jobs
                    </a>
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .matched-jobs-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }
</style>
