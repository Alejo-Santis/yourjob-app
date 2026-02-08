<script>
    let { job = {}, onApply = () => {}, onFavorite = () => {}, isFavorited = false, isApplied = false, matchScore = null } = $props();

    function getContractBadgeColor(type) {
        const colors = {
            full_time: 'primary',
            part_time: 'info',
            freelance: 'warning',
            internship: 'secondary',
            temporary: 'danger',
            contract: 'success',
        };
        return colors[type] || 'secondary';
    }

    function getWorkModeBadgeColor(mode) {
        const colors = {
            on_site: 'secondary',
            remote: 'success',
            hybrid: 'info',
        };
        return colors[mode] || 'secondary';
    }

    function getMatchBadgeColor(score) {
        if (score >= 80) return 'success';
        if (score >= 60) return 'info';
        if (score >= 40) return 'warning';
        return 'danger';
    }
</script>

<div class="job-card card h-100 shadow-sm hover-shadow transition-all">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="card-title mb-1">{job.title}</h5>
                <p class="text-muted small mb-0">{job.employer?.company_name}</p>
            </div>
            <button
                class="btn btn-sm btn-link"
                onclick={onFavorite}
                title={isFavorited ? 'Remove from favorites' : 'Add to favorites'}
            >
                <i class="bi bi-heart{isFavorited ? '-fill' : ''} text-danger"></i>
            </button>
        </div>

        <div class="mb-3">
            <p class="text-muted small mb-2">
                <i class="bi bi-geo-alt me-1"></i>
                {job.city}, {job.state}
            </p>
            <p class="text-muted small mb-2">
                <i class="bi bi-briefcase me-1"></i>
                <span class="badge bg-{getContractBadgeColor(job.contract_type)}">
                    {job.contract_type}
                </span>
            </p>
            <p class="text-muted small mb-0">
                <i class="bi bi-laptop me-1"></i>
                <span class="badge bg-{getWorkModeBadgeColor(job.work_mode)}">
                    {job.work_mode}
                </span>
            </p>
        </div>

        {#if job.salary_min && job.salary_max}
            <p class="h6 mb-3">
                ${job.salary_min.toLocaleString()} - ${job.salary_max.toLocaleString()}
                <small class="text-muted">/{job.salary_period}</small>
            </p>
        {/if}

        {#if matchScore !== null}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted">Match Score</small>
                    <small class="fw-bold">{matchScore}%</small>
                </div>
                <div class="progress" style="height: 6px;">
                    <div
                        class="progress-bar bg-{getMatchBadgeColor(matchScore)}"
                        style="width: {matchScore}%"
                    ></div>
                </div>
            </div>
        {/if}

        <div class="d-grid gap-2 mt-4">
            <a href={`/jobs/${job.id}`} class="btn btn-outline-primary btn-sm">
                View Details
            </a>
            {#if !isApplied}
                <button class="btn btn-primary btn-sm" onclick={onApply}>
                    <i class="bi bi-send me-1"></i>
                    Apply Now
                </button>
            {:else}
                <button class="btn btn-secondary btn-sm" disabled>
                    <i class="bi bi-check-circle me-1"></i>
                    Already Applied
                </button>
            {/if}
        </div>
    </div>
</div>

<style>
    .job-card {
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
    }

    .job-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    h5 {
        font-weight: 600;
        color: #212529;
    }

    .btn-link {
        text-decoration: none;
        padding: 0.25rem;
        min-width: 44px;
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-link:hover {
        transform: scale(1.2);
    }

    .card-title {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    @media (max-width: 576px) {
        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            min-height: 44px;
        }
    }
</style>
