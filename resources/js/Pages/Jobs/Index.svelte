<script>
    import AppLayout from '../../Layouts/AppLayout.svelte';
    import JobCard from '../../Components/JobCard.svelte';
    import { router } from '@inertiajs/svelte';
    import { page } from '@inertiajs/svelte';

    export let jobs = { data: [] };
    export let filters = {};

    let searchForm = {
        title: filters.title || '',
        work_mode: filters.work_mode || '',
        contract_type: filters.contract_type || '',
        city: filters.city || '',
        state: filters.state || '',
        industry: filters.industry || '',
        salary_min: filters.salary_min || '',
        salary_max: filters.salary_max || '',
    };

    function search() {
        const params = Object.fromEntries(
            Object.entries(searchForm).filter(([_, value]) => value !== '')
        );
        router.get('/jobs', params, { preserveState: true });
    }

    function clearFilters() {
        searchForm = {
            title: '',
            work_mode: '',
            contract_type: '',
            city: '',
            state: '',
            industry: '',
            salary_min: '',
            salary_max: '',
        };
        router.get('/jobs');
    }

    function handleApply(jobId) {
        if ($page.props.auth?.user) {
            router.post('/applications', { job_listing_id: jobId });
        } else {
            alert('Please login to apply for jobs');
        }
    }

    function handleFavoriteToggle(jobId) {
        if ($page.props.auth?.user) {
            router.post(`/favorites/jobs/${jobId}/toggle`, {}, { preserveScroll: true });
        } else {
            alert('Please login to save favorite jobs');
        }
    }
</script>

<AppLayout>
    <div class="jobs-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Browse Jobs</h1>
            <p class="text-muted">Find your next career opportunity</p>
        </div>

        <!-- Search & Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form on:submit|preventDefault={search}>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search job titles..."
                                bind:value={searchForm.title}
                            />
                        </div>
                        <div class="col-md-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="City"
                                bind:value={searchForm.city}
                            />
                        </div>
                        <div class="col-md-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="State"
                                bind:value={searchForm.state}
                            />
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <select class="form-select" bind:value={searchForm.work_mode}>
                                <option value="">Work Mode</option>
                                <option value="on_site">On Site</option>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" bind:value={searchForm.contract_type}>
                                <option value="">Contract Type</option>
                                <option value="full_time">Full Time</option>
                                <option value="part_time">Part Time</option>
                                <option value="freelance">Freelance</option>
                                <option value="internship">Internship</option>
                                <option value="temporary">Temporary</option>
                                <option value="contract">Contract</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input
                                type="number"
                                class="form-control"
                                placeholder="Min Salary"
                                bind:value={searchForm.salary_min}
                            />
                        </div>
                        <div class="col-md-3">
                            <input
                                type="number"
                                class="form-control"
                                placeholder="Max Salary"
                                bind:value={searchForm.salary_max}
                            />
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                        <button type="button" class="btn btn-outline-secondary" on:click={clearFilters}>
                            <i class="bi bi-x-circle me-2"></i>Clear Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results -->
        {#if jobs.data && jobs.data.length > 0}
            <div class="mb-3">
                <p class="text-muted">
                    Showing {jobs.from || 0} - {jobs.to || 0} of {jobs.total || 0} jobs
                </p>
            </div>

            <div class="row g-3 mb-4">
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
                <nav aria-label="Page navigation">
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
                    <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">No Jobs Found</h5>
                    <p class="text-muted mb-4">
                        Try adjusting your search filters to find more opportunities
                    </p>
                    <button class="btn btn-primary" on:click={clearFilters}>
                        <i class="bi bi-x-circle me-2"></i>Clear Filters
                    </button>
                </div>
            </div>
        {/if}
    </div>
</AppLayout>

<style>
    .jobs-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }
</style>
