<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    export let profile = {};
    export let summary = {};

    function handleUploadCV() {
        document.getElementById('cv-upload').click();
    }

    function uploadCV(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('cv', file);
            router.post('/job-seeker/profile/cv', formData);
        }
    }
</script>

<AppLayout>
    <div class="profile-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">My Profile</h1>
                <p class="text-muted">Manage your professional information</p>
            </div>
            <a href="/job-seeker/profile/edit" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Profile
            </a>
        </div>

        <!-- Profile Completion -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Profile Completion</h6>
                    <span class="badge bg-{profile.profile_completion_percentage >= 80 ? 'success' : 'warning'} fs-6">
                        {profile.profile_completion_percentage}%
                    </span>
                </div>
                <div class="progress" style="height: 10px;">
                    <div
                        class="progress-bar bg-{profile.profile_completion_percentage >= 80 ? 'success' : 'warning'}"
                        style="width: {profile.profile_completion_percentage}%"
                    ></div>
                </div>
                {#if profile.profile_completion_percentage < 80}
                    <small class="text-muted mt-2 d-block">
                        Complete your profile to increase visibility to employers
                    </small>
                {/if}
            </div>
        </div>

        <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Full Name</label>
                                <p class="mb-0 fw-semibold">{profile.full_name || 'Not provided'}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Birth Date</label>
                                <p class="mb-0 fw-semibold">
                                    {profile.birth_date ? new Date(profile.birth_date).toLocaleDateString() : 'Not provided'}
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Gender</label>
                                <p class="mb-0 fw-semibold">{profile.gender || 'Not provided'}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Phone</label>
                                <p class="mb-0 fw-semibold">{profile.phone || 'Not provided'}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="text-muted small">Address</label>
                                <p class="mb-0 fw-semibold">
                                    {#if profile.address}
                                        {profile.address}, {profile.city}, {profile.state} {profile.postal_code}
                                    {:else}
                                        Not provided
                                    {/if}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Professional Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Profession</label>
                                <p class="mb-0 fw-semibold">{profile.profession || 'Not provided'}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Education Level</label>
                                <p class="mb-0 fw-semibold">{profile.education_level || 'Not provided'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small">Years of Experience</label>
                                <p class="mb-0 fw-semibold">{profile.total_years_experience || 0} years</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Expected Salary</label>
                                <p class="mb-0 fw-semibold">
                                    {#if profile.expected_salary_min && profile.expected_salary_max}
                                        ${profile.expected_salary_min.toLocaleString()} - ${profile.expected_salary_max.toLocaleString()}
                                    {:else}
                                        Not provided
                                    {/if}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="text-muted small">Preferred Contract Type</label>
                                <p class="mb-0 fw-semibold">{profile.preferred_contract_type || 'Not provided'}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small">Preferred Work Mode</label>
                                <p class="mb-0 fw-semibold">{profile.preferred_work_mode || 'Not provided'}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Skills</h5>
                    </div>
                    <div class="card-body">
                        {#if profile.skills && profile.skills.length > 0}
                            <div class="d-flex flex-wrap gap-2">
                                {#each profile.skills as skill}
                                    <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2">
                                        {skill}
                                    </span>
                                {/each}
                            </div>
                        {:else}
                            <p class="text-muted mb-0">No skills added yet</p>
                        {/if}
                    </div>
                </div>

                <!-- Languages -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Languages</h5>
                    </div>
                    <div class="card-body">
                        {#if profile.languages && profile.languages.length > 0}
                            <div class="d-flex flex-wrap gap-2">
                                {#each profile.languages as language}
                                    <span class="badge bg-info-subtle text-info fs-6 px-3 py-2">
                                        {language}
                                    </span>
                                {/each}
                            </div>
                        {:else}
                            <p class="text-muted mb-0">No languages added yet</p>
                        {/if}
                    </div>
                </div>

                <!-- Work Experience -->
                {#if profile.work_experiences && profile.work_experiences.length > 0}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Work Experience</h5>
                        </div>
                        <div class="card-body">
                            {#each profile.work_experiences as experience}
                                <div class="mb-4 pb-3 border-bottom">
                                    <h6 class="mb-1">{experience.job_title}</h6>
                                    <p class="text-primary mb-2">{experience.company_name}</p>
                                    <p class="text-muted small mb-2">
                                        {new Date(experience.start_date).toLocaleDateString()} -
                                        {experience.end_date ? new Date(experience.end_date).toLocaleDateString() : 'Present'}
                                    </p>
                                    {#if experience.description}
                                        <p class="mb-0 small">{experience.description}</p>
                                    {/if}
                                </div>
                            {/each}
                        </div>
                    </div>
                {/if}
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- CV Upload -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Resume/CV</h5>
                    </div>
                    <div class="card-body text-center">
                        {#if profile.cv_url}
                            <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 3rem;"></i>
                            <p class="mb-3 mt-2">CV uploaded</p>
                            <a href="/storage/{profile.cv_url}" target="_blank" class="btn btn-outline-primary btn-sm mb-2 w-100">
                                <i class="bi bi-eye me-2"></i>View CV
                            </a>
                        {:else}
                            <i class="bi bi-cloud-upload text-muted" style="font-size: 3rem;"></i>
                            <p class="mb-3 mt-2 text-muted">No CV uploaded</p>
                        {/if}
                        <button class="btn btn-primary btn-sm w-100" on:click={handleUploadCV}>
                            <i class="bi bi-upload me-2"></i>Upload New CV
                        </button>
                        <input
                            id="cv-upload"
                            type="file"
                            accept=".pdf,.doc,.docx"
                            style="display: none;"
                            on:change={uploadCV}
                        />
                    </div>
                </div>

                <!-- Profile Summary -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Profile Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Total Applications</small>
                            <p class="h4 mb-0">{summary.applications || 0}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Favorite Jobs</small>
                            <p class="h4 mb-0">{summary.favorites || 0}</p>
                        </div>
                        <div>
                            <small class="text-muted">Skills</small>
                            <p class="h4 mb-0">{summary.skills_count || 0}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .profile-container {
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

    label {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
</style>
