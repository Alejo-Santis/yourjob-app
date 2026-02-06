<script>
    import AppLayout from '../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';
    import { page } from '@inertiajs/svelte';

    export let application = {};

    $: userType = $page.props.auth?.user?.user_type;
    $: isEmployer = userType === 'employer';
    $: isJobSeeker = userType === 'job_seeker';

    function handleAccept() {
        if (confirm('Are you sure you want to accept this application?')) {
            router.post(`/applications/${application.id}/accept`);
        }
    }

    function handleReject() {
        const message = prompt('Optional: Add a rejection message for the candidate');
        router.post(`/applications/${application.id}/reject`, { message });
    }

    function handleWithdraw() {
        if (confirm('Are you sure you want to withdraw this application?')) {
            router.post(`/applications/${application.id}/withdraw`);
        }
    }

    function getStatusColor(status) {
        const colors = {
            pending: 'warning',
            accepted: 'success',
            rejected: 'danger',
            withdrawn: 'secondary',
        };
        return colors[status] || 'secondary';
    }
</script>

<AppLayout>
    <div class="application-show-container">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="/applications" class="btn btn-link text-decoration-none p-0">
                <i class="bi bi-arrow-left me-2"></i>Back to Applications
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Application Header -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="h4 mb-2">Application Details</h1>
                                <span class="badge bg-{getStatusColor(application.status)} fs-6">
                                    {application.status}
                                </span>
                            </div>
                            <small class="text-muted">
                                Applied: {new Date(application.applied_at).toLocaleDateString()}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Job Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Job Information</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-2">
                            <a href="/jobs/{application.job_listing?.id}" class="text-decoration-none">
                                {application.job_listing?.title}
                            </a>
                        </h5>
                        <p class="text-primary mb-3">
                            {application.job_listing?.employer?.company_name}
                        </p>
                        <div class="d-flex flex-wrap gap-3 text-muted">
                            <span>
                                <i class="bi bi-geo-alt me-1"></i>
                                {application.job_listing?.city}, {application.job_listing?.state}
                            </span>
                            <span>
                                <i class="bi bi-briefcase me-1"></i>
                                {application.job_listing?.contract_type}
                            </span>
                            <span>
                                <i class="bi bi-laptop me-1"></i>
                                {application.job_listing?.work_mode}
                            </span>
                        </div>
                    </div>
                </div>

                {#if isEmployer}
                    <!-- Candidate Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Candidate Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Full Name</label>
                                    <p class="mb-0 fw-semibold">{application.job_seeker?.full_name || 'N/A'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Email</label>
                                    <p class="mb-0 fw-semibold">{application.job_seeker?.user?.email || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Profession</label>
                                    <p class="mb-0 fw-semibold">{application.job_seeker?.profession || 'N/A'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Years of Experience</label>
                                    <p class="mb-0 fw-semibold">
                                        {application.job_seeker?.total_years_experience || 0} years
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-muted small">Phone</label>
                                    <p class="mb-0 fw-semibold">{application.job_seeker?.phone || 'N/A'}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Location</label>
                                    <p class="mb-0 fw-semibold">
                                        {application.job_seeker?.city ? `${application.job_seeker.city}, ${application.job_seeker.state}` : 'N/A'}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Candidate Skills -->
                    {#if application.job_seeker?.skills && application.job_seeker.skills.length > 0}
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Skills</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    {#each application.job_seeker.skills as skill}
                                        <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2">
                                            {skill}
                                        </span>
                                    {/each}
                                </div>
                            </div>
                        </div>
                    {/if}
                {/if}

                <!-- Cover Letter -->
                {#if application.cover_letter}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Cover Letter</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 white-space-pre-wrap">{application.cover_letter}</p>
                        </div>
                    </div>
                {/if}

                <!-- Additional Answers -->
                {#if application.additional_answers}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Additional Answers</h5>
                        </div>
                        <div class="card-body">
                            <pre class="mb-0">{JSON.stringify(application.additional_answers, null, 2)}</pre>
                        </div>
                    </div>
                {/if}

                <!-- Rejection Message -->
                {#if application.status === 'rejected' && application.rejection_message}
                    <div class="card shadow-sm border-danger mb-4">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Rejection Message</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{application.rejection_message}</p>
                        </div>
                    </div>
                {/if}
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Actions -->
                <div class="card shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Actions</h5>

                        {#if isEmployer && application.status === 'pending'}
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" on:click={handleAccept}>
                                    <i class="bi bi-check-circle me-2"></i>
                                    Accept Application
                                </button>
                                <button class="btn btn-danger" on:click={handleReject}>
                                    <i class="bi bi-x-circle me-2"></i>
                                    Reject Application
                                </button>
                            </div>
                        {:else if isJobSeeker && application.status === 'pending'}
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-danger" on:click={handleWithdraw}>
                                    <i class="bi bi-x-circle me-2"></i>
                                    Withdraw Application
                                </button>
                            </div>
                        {:else}
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                This application is {application.status}
                            </div>
                        {/if}

                        <hr class="my-3" />

                        <div class="d-grid gap-2">
                            <a href="/jobs/{application.job_listing?.id}" class="btn btn-outline-primary">
                                <i class="bi bi-briefcase me-2"></i>
                                View Job
                            </a>
                            {#if isEmployer && application.job_seeker?.cv_url}
                                <a
                                    href="/storage/{application.job_seeker.cv_url}"
                                    target="_blank"
                                    class="btn btn-outline-secondary"
                                >
                                    <i class="bi bi-file-earmark-pdf me-2"></i>
                                    Download CV
                                </a>
                            {/if}
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <i class="bi bi-send-fill text-primary"></i>
                                <div>
                                    <strong>Applied</strong>
                                    <br />
                                    <small class="text-muted">
                                        {new Date(application.applied_at).toLocaleString()}
                                    </small>
                                </div>
                            </div>

                            {#if application.viewed_at}
                                <div class="timeline-item">
                                    <i class="bi bi-eye-fill text-info"></i>
                                    <div>
                                        <strong>Viewed</strong>
                                        <br />
                                        <small class="text-muted">
                                            {new Date(application.viewed_at).toLocaleString()}
                                        </small>
                                    </div>
                                </div>
                            {/if}

                            {#if application.status === 'accepted' && application.accepted_at}
                                <div class="timeline-item">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <div>
                                        <strong>Accepted</strong>
                                        <br />
                                        <small class="text-muted">
                                            {new Date(application.accepted_at).toLocaleString()}
                                        </small>
                                    </div>
                                </div>
                            {:else if application.status === 'rejected' && application.rejected_at}
                                <div class="timeline-item">
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                    <div>
                                        <strong>Rejected</strong>
                                        <br />
                                        <small class="text-muted">
                                            {new Date(application.rejected_at).toLocaleString()}
                                        </small>
                                    </div>
                                </div>
                            {:else if application.status === 'withdrawn' && application.withdrawn_at}
                                <div class="timeline-item">
                                    <i class="bi bi-x-circle-fill text-secondary"></i>
                                    <div>
                                        <strong>Withdrawn</strong>
                                        <br />
                                        <small class="text-muted">
                                            {new Date(application.withdrawn_at).toLocaleString()}
                                        </small>
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .application-show-container {
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

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0.5rem;
        bottom: 0.5rem;
        width: 2px;
        background-color: #dee2e6;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item i {
        position: absolute;
        left: -1.5rem;
        background-color: white;
        font-size: 1.2rem;
        z-index: 1;
    }

    label {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
</style>
