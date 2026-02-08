<script>
    import AppLayout from '../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';
    import { page } from '@inertiajs/svelte';

    let { job = {}, isApplied = false, isFavorited = false, matchScore = null } = $props();

    function parseSkills(value) {
        if (Array.isArray(value)) return value;
        if (typeof value === 'string') {
            try { const parsed = JSON.parse(value); return Array.isArray(parsed) ? parsed : []; }
            catch { return []; }
        }
        return [];
    }

    let requiredSkills = $derived(parseSkills(job.required_skills));
    let niceToHaveSkills = $derived(parseSkills(job.nice_to_have_skills));

    function handleApply() {
        if ($page.props.auth?.user) {
            router.visit(`/applications?job_id=${job.id}`);
        } else {
            alert('Please login to apply for this job');
        }
    }

    function handleFavoriteToggle() {
        if ($page.props.auth?.user) {
            router.post(`/favorites/jobs/${job.id}/toggle`);
        } else {
            alert('Please login to save favorite jobs');
        }
    }
</script>

<AppLayout>
    <div class="job-show-container">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="/jobs" class="btn btn-link text-decoration-none p-0">
                <i class="bi bi-arrow-left me-2"></i>Back to Jobs
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Job Header -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h1 class="h3 mb-2">{job.title}</h1>
                                <p class="text-primary h5 mb-3">
                                    {job.employer?.company_name || 'Company Name'}
                                </p>
                                <div class="d-flex flex-wrap gap-3 text-muted">
                                    <span>
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {job.city}, {job.state}
                                    </span>
                                    <span>
                                        <i class="bi bi-briefcase me-1"></i>
                                        {job.contract_type}
                                    </span>
                                    <span>
                                        <i class="bi bi-laptop me-1"></i>
                                        {job.work_mode}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock me-1"></i>
                                        Posted {new Date(job.posted_at || job.created_at).toLocaleDateString()}
                                    </span>
                                </div>
                            </div>
                            <button
                                class="btn btn-link text-danger fs-4"
                                onclick={handleFavoriteToggle}
                                title={isFavorited ? 'Remove from favorites' : 'Add to favorites'}
                            >
                                <i class="bi bi-heart{isFavorited ? '-fill' : ''}"></i>
                            </button>
                        </div>

                        {#if matchScore !== null}
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Your Match Score</strong>
                                    <strong class="fs-5">{matchScore}%</strong>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div
                                        class="progress-bar"
                                        style="width: {matchScore}%"
                                    ></div>
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>

                <!-- Job Description -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Job Description</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 white-space-pre-wrap">{job.description || 'No description provided'}</p>
                    </div>
                </div>

                <!-- Requirements -->
                {#if job.requirements}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Requirements</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 white-space-pre-wrap">{job.requirements}</p>
                        </div>
                    </div>
                {/if}

                <!-- Benefits -->
                {#if job.benefits}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Benefits</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 white-space-pre-wrap">{job.benefits}</p>
                        </div>
                    </div>
                {/if}

                <!-- Skills -->
                {#if requiredSkills.length > 0}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Required Skills</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                {#each requiredSkills as skill}
                                    <span class="badge bg-primary fs-6 px-3 py-2">{skill}</span>
                                {/each}
                            </div>
                        </div>
                    </div>
                {/if}

                {#if niceToHaveSkills.length > 0}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Nice to Have Skills</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                {#each niceToHaveSkills as skill}
                                    <span class="badge bg-secondary-subtle text-secondary fs-6 px-3 py-2">{skill}</span>
                                {/each}
                            </div>
                        </div>
                    </div>
                {/if}
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Apply Card -->
                <div class="card shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body">
                        {#if job.salary_min && job.salary_max}
                            <div class="mb-3">
                                <small class="text-muted">Salary Range</small>
                                <p class="h4 mb-0">
                                    ${job.salary_min.toLocaleString()} - ${job.salary_max.toLocaleString()}
                                    <small class="text-muted">/{job.salary_period || 'month'}</small>
                                </p>
                            </div>
                            <hr />
                        {/if}

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Position Level</small>
                            <span class="badge bg-info-subtle text-info">
                                {job.position_level || 'Not specified'}
                            </span>
                        </div>

                        {#if job.years_experience_required}
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Experience Required</small>
                                <strong>{job.years_experience_required} years</strong>
                            </div>
                        {/if}

                        {#if job.vacancy_count}
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Vacancies</small>
                                <strong>{job.vacancy_count} positions</strong>
                            </div>
                        {/if}

                        {#if job.deadline_at}
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Application Deadline</small>
                                <strong>{new Date(job.deadline_at).toLocaleDateString()}</strong>
                            </div>
                        {/if}

                        <hr />

                        <div class="d-grid gap-2">
                            {#if isApplied}
                                <button class="btn btn-secondary" disabled>
                                    <i class="bi bi-check-circle me-2"></i>
                                    Already Applied
                                </button>
                            {:else}
                                <button class="btn btn-primary btn-lg" onclick={handleApply}>
                                    <i class="bi bi-send me-2"></i>
                                    Apply Now
                                </button>
                            {/if}
                            <button class="btn btn-outline-danger" onclick={handleFavoriteToggle}>
                                <i class="bi bi-heart{isFavorited ? '-fill' : ''} me-2"></i>
                                {isFavorited ? 'Remove from Favorites' : 'Save Job'}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Company Info -->
                {#if job.employer}
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">About Company</h5>
                        </div>
                        <div class="card-body">
                            {#if job.employer.logo_url}
                                <img
                                    src="/storage/{job.employer.logo_url}"
                                    alt="{job.employer.company_name} logo"
                                    class="img-fluid mb-3"
                                    style="max-height: 100px; object-fit: contain;"
                                />
                            {/if}
                            <h6>{job.employer.company_name}</h6>
                            {#if job.employer.company_description}
                                <p class="small text-muted mb-2">{job.employer.company_description}</p>
                            {/if}
                            {#if job.employer.company_website}
                                <a href={job.employer.company_website} target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                    <i class="bi bi-globe me-2"></i>Visit Website
                                </a>
                            {/if}
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .job-show-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.25rem;
    }

    .white-space-pre-wrap {
        white-space: pre-wrap;
    }

    .sticky-top {
        position: sticky;
    }
</style>
