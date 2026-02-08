<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import JobCard from '../../../Components/JobCard.svelte';
    import { router } from '@inertiajs/svelte';

    let { favorites = { data: [] } } = $props();

    function handleApply(jobId) {
        router.post('/applications', { job_listing_id: jobId });
    }

    function handleFavoriteToggle(jobId) {
        router.post(`/favorites/jobs/${jobId}/toggle`, {}, {
            preserveScroll: true,
            onSuccess: () => {
                // Page will reload to show updated favorites
            }
        });
    }
</script>

<AppLayout>
    <div class="favorites-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Favorite Jobs</h1>
            <p class="text-muted">Jobs you've saved for later</p>
        </div>

        {#if favorites.data && favorites.data.length > 0}
            <div class="row g-3">
                {#each favorites.data as favorite}
                    {@const job = favorite.job_listing}
                    <div class="col-lg-4 col-md-6">
                        <JobCard
                            {job}
                            onApply={() => handleApply(job.id)}
                            onFavorite={() => handleFavoriteToggle(job.id)}
                            isFavorited={true}
                            isApplied={job.is_applied || false}
                            matchScore={job.match_score}
                        />
                    </div>
                {/each}
            </div>

            <!-- Pagination -->
            {#if favorites.links && favorites.links.length > 3}
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {#each favorites.links as link}
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
                    <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">No Favorite Jobs</h5>
                    <p class="text-muted mb-4">
                        Start adding jobs to your favorites to keep track of opportunities you're interested in
                    </p>
                    <a href="/jobs" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Browse Jobs
                    </a>
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .favorites-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }
</style>
