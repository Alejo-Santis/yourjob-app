<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { useForm } from '@inertiajs/svelte';

    export let profile = {};

    const form = useForm({
        company_name: profile.company_name || '',
        company_website: profile.company_website || '',
        company_description: profile.company_description || '',
        industry: profile.industry || '',
        phone: profile.phone || '',
        address: profile.address || '',
        city: profile.city || '',
        state: profile.state || '',
        country: profile.country || '',
        postal_code: profile.postal_code || '',
        employee_count: profile.employee_count || '',
        company_size: profile.company_size || '',
        founding_year: profile.founding_year || '',
    });

    function submit(e) {
        e.preventDefault();
        $form.put('/employer/profile');
    }
</script>

<AppLayout>
    <div class="profile-edit-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Edit Company Profile</h1>
            <p class="text-muted">Update your company information</p>
        </div>

        <form on:submit={submit}>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Company Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Company Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name *</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="company_name"
                                    bind:value={$form.company_name}
                                    required
                                />
                                {#if $form.errors.company_name}
                                    <div class="text-danger small mt-1">{$form.errors.company_name}</div>
                                {/if}
                            </div>

                            <div class="mb-3">
                                <label for="company_website" class="form-label">Company Website</label>
                                <input
                                    type="url"
                                    class="form-control"
                                    id="company_website"
                                    bind:value={$form.company_website}
                                    placeholder="https://example.com"
                                />
                            </div>

                            <div class="mb-3">
                                <label for="company_description" class="form-label">Company Description</label>
                                <textarea
                                    class="form-control"
                                    id="company_description"
                                    rows="5"
                                    bind:value={$form.company_description}
                                    placeholder="Tell us about your company..."
                                ></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="industry" class="form-label">Industry</label>
                                    <select class="form-select" id="industry" bind:value={$form.industry}>
                                        <option value="">Select industry</option>
                                        <option value="technology">Technology</option>
                                        <option value="finance">Finance</option>
                                        <option value="healthcare">Healthcare</option>
                                        <option value="education">Education</option>
                                        <option value="retail">Retail</option>
                                        <option value="manufacturing">Manufacturing</option>
                                        <option value="construction">Construction</option>
                                        <option value="hospitality">Hospitality</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        id="phone"
                                        bind:value={$form.phone}
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_size" class="form-label">Company Size</label>
                                    <select class="form-select" id="company_size" bind:value={$form.company_size}>
                                        <option value="">Select company size</option>
                                        <option value="1-10">1-10 employees</option>
                                        <option value="11-50">11-50 employees</option>
                                        <option value="51-200">51-200 employees</option>
                                        <option value="201-500">201-500 employees</option>
                                        <option value="501-1000">501-1000 employees</option>
                                        <option value="1001+">1001+ employees</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="employee_count" class="form-label">Employee Count</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="employee_count"
                                        bind:value={$form.employee_count}
                                        min="0"
                                    />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="founding_year" class="form-label">Founding Year</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="founding_year"
                                    bind:value={$form.founding_year}
                                    min="1900"
                                    max="2099"
                                    placeholder="e.g., 2010"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Address Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address"
                                    bind:value={$form.address}
                                />
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="city"
                                        bind:value={$form.city}
                                    />
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label">State</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="state"
                                        bind:value={$form.state}
                                    />
                                </div>
                                <div class="col-md-4">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="postal_code"
                                        bind:value={$form.postal_code}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Actions</h5>
                            <div class="d-grid gap-2">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    disabled={$form.processing}
                                >
                                    {#if $form.processing}
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Saving...
                                    {:else}
                                        <i class="bi bi-check-circle me-2"></i>
                                        Save Changes
                                    {/if}
                                </button>
                                <a href="/employer/profile" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Cancel
                                </a>
                            </div>

                            <hr class="my-3" />

                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="bi bi-info-circle me-2"></i>
                                    A complete profile helps attract more qualified candidates.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</AppLayout>

<style>
    .profile-edit-container {
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

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .sticky-top {
        position: sticky;
    }
</style>
