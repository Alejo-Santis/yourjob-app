<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { router } from '@inertiajs/svelte';

    let { profile = {}, summary = {} } = $props();

    function handleUploadLogo() {
        document.getElementById('logo-upload').click();
    }

    function uploadLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('logo', file);
            router.post('/employer/profile/logo', formData);
        }
    }
</script>

<AppLayout>
    <div class="profile-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Company Profile</h1>
                <p class="text-muted">Manage your company information</p>
            </div>
            <a href="/employer/profile/edit" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Profile
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white"><h5 class="mb-0">Company Information</h5></div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small" for="">Company Name</label>
                                <p class="mb-0 fw-semibold">{profile.company_name || 'Not provided'}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small" for="">Industry</label>
                                <p class="mb-0 fw-semibold">{profile.industry || 'Not provided'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small" for="">Company Size</label>
                                <p class="mb-0 fw-semibold">{profile.company_size || 'Not provided'}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small" for="">Employee Count</label>
                                <p class="mb-0 fw-semibold">{profile.employee_count ? `${profile.employee_count.toLocaleString()} employees` : 'Not provided'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="text-muted small" for="">Founding Year</label>
                                <p class="mb-0 fw-semibold">{profile.founding_year || 'Not provided'}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small" for="">Phone</label>
                                <p class="mb-0 fw-semibold">{profile.phone || 'Not provided'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="text-muted small" for="">Website</label>
                                <p class="mb-0 fw-semibold">
                                    {#if profile.company_website}
                                        <a href={profile.company_website} target="_blank" class="text-decoration-none">
                                            {profile.company_website}<i class="bi bi-box-arrow-up-right ms-1 small"></i>
                                        </a>
                                    {:else}Not provided{/if}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="text-muted small" for="">Address</label>
                                <p class="mb-0 fw-semibold">
                                    {#if profile.address}{profile.address}, {profile.city}, {profile.state} {profile.postal_code}{:else}Not provided{/if}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white"><h5 class="mb-0">About Company</h5></div>
                    <div class="card-body">
                        {#if profile.company_description}
                            <p class="mb-0">{profile.company_description}</p>
                        {:else}
                            <p class="text-muted mb-0">No company description provided</p>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white"><h5 class="mb-0">Company Logo</h5></div>
                    <div class="card-body text-center">
                        {#if profile.logo_url}
                            <img src="/storage/{profile.logo_url}" alt="{profile.company_name} logo" class="img-fluid mb-3" style="max-height: 200px; object-fit: contain;" />
                        {:else}
                            <div class="mb-3 p-5 bg-light rounded">
                                <i class="bi bi-building text-muted" style="font-size: 4rem;"></i>
                            </div>
                        {/if}
                        <button class="btn btn-primary btn-sm w-100" onclick={handleUploadLogo}>
                            <i class="bi bi-upload me-2"></i>{profile.logo_url ? 'Change Logo' : 'Upload Logo'}
                        </button>
                        <input id="logo-upload" type="file" accept="image/*" style="display: none;" onchange={uploadLogo} />
                        <small class="text-muted d-block mt-2">Max size: 2MB. Formats: JPG, PNG, SVG</small>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white"><h5 class="mb-0">Statistics</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Active Job Listings</small>
                            <p class="h4 mb-0">{summary.active_listings || 0}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Total Applications</small>
                            <p class="h4 mb-0">{summary.total_applications || 0}</p>
                        </div>
                        <div>
                            <small class="text-muted">Total Listings</small>
                            <p class="h4 mb-0">{summary.total_listings || 0}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AppLayout>

<style>
    .profile-container { max-width: 1400px; margin: 0 auto; }
    .card { border: none; border-radius: 0.5rem; }
    .card-header { border-bottom: 1px solid #e9ecef; padding: 1rem 1.25rem; }
    label { font-weight: 500; margin-bottom: 0.25rem; }
</style>
