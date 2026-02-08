<script>
    import AppLayout from '../../../Layouts/AppLayout.svelte';
    import { useForm } from '@inertiajs/svelte';

    let { profile = {} } = $props();

    const form = useForm({
        full_name: profile.full_name || '',
        birth_date: profile.birth_date || '',
        gender: profile.gender || '',
        phone: profile.phone || '',
        address: profile.address || '',
        city: profile.city || '',
        state: profile.state || '',
        country: profile.country || '',
        postal_code: profile.postal_code || '',
        education_level: profile.education_level || '',
        profession: profile.profession || '',
        total_years_experience: profile.total_years_experience || 0,
        expected_salary_min: profile.expected_salary_min || '',
        expected_salary_max: profile.expected_salary_max || '',
        preferred_contract_type: profile.preferred_contract_type || '',
        preferred_work_mode: profile.preferred_work_mode || '',
        skills: profile.skills || [],
        languages: profile.languages || [],
        about_me: profile.about_me || '',
    });

    let newSkill = $state('');
    let newLanguage = $state('');

    function submit(e) {
        e.preventDefault();
        $form.put('/job-seeker/profile');
    }

    function addSkill() {
        const skill = newSkill.trim();
        if (skill && !$form.skills.includes(skill)) {
            $form.skills = [...$form.skills, skill];
            newSkill = '';
        }
    }

    function removeSkill(skill) {
        $form.skills = $form.skills.filter(s => s !== skill);
    }

    function handleSkillKeydown(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill();
        }
    }

    function addLanguage() {
        const lang = newLanguage.trim();
        if (lang && !$form.languages.includes(lang)) {
            $form.languages = [...$form.languages, lang];
            newLanguage = '';
        }
    }

    function removeLanguage(lang) {
        $form.languages = $form.languages.filter(l => l !== lang);
    }

    function handleLanguageKeydown(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addLanguage();
        }
    }

    let completionFields = $derived({
        'Full Name': !!$form.full_name,
        'Birth Date': !!$form.birth_date,
        'Phone': !!$form.phone,
        'Address': !!$form.address,
        'Education Level': !!$form.education_level,
        'Profession': !!$form.profession,
        'Skills': $form.skills.length > 0,
        'CV': !!profile.cv_url,
    });
    let completedCount = $derived(Object.values(completionFields).filter(Boolean).length);
    let completionPercentage = $derived(Math.round((completedCount / 8) * 100));
</script>

<AppLayout>
    <div class="profile-edit-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Edit Profile</h1>
            <p class="text-muted">Update your professional information</p>
        </div>

        <form onsubmit={submit}>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Personal Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-person me-2"></i>Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label">Full Name *</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="full_name"
                                        bind:value={$form.full_name}
                                        required
                                    />
                                    {#if $form.errors.full_name}
                                        <div class="text-danger small mt-1">{$form.errors.full_name}</div>
                                    {/if}
                                </div>
                                <div class="col-md-6">
                                    <label for="birth_date" class="form-label">Birth Date</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="birth_date"
                                        bind:value={$form.birth_date}
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" bind:value={$form.gender}>
                                        <option value="">Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                        <option value="prefer_not_to_say">Prefer not to say</option>
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
                                <div class="col-md-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" bind:value={$form.city} />
                                </div>
                                <div class="col-md-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" bind:value={$form.state} />
                                </div>
                                <div class="col-md-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" bind:value={$form.country} />
                                </div>
                                <div class="col-md-3">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="postal_code" bind:value={$form.postal_code} />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-briefcase me-2"></i>Professional Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="profession" class="form-label">Profession</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="profession"
                                        bind:value={$form.profession}
                                        placeholder="e.g., Software Engineer"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label for="education_level" class="form-label">Education Level</label>
                                    <select class="form-select" id="education_level" bind:value={$form.education_level}>
                                        <option value="">Select education level</option>
                                        <option value="high_school">High School</option>
                                        <option value="associate">Associate Degree</option>
                                        <option value="bachelor">Bachelor's Degree</option>
                                        <option value="master">Master's Degree</option>
                                        <option value="doctorate">Doctorate</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="total_years_experience" class="form-label">Years of Experience</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="total_years_experience"
                                    bind:value={$form.total_years_experience}
                                    min="0"
                                />
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="expected_salary_min" class="form-label">Expected Salary (Min)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="expected_salary_min"
                                            bind:value={$form.expected_salary_min}
                                            min="0"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="expected_salary_max" class="form-label">Expected Salary (Max)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="expected_salary_max"
                                            bind:value={$form.expected_salary_max}
                                            min="0"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="preferred_contract_type" class="form-label">Preferred Contract Type</label>
                                    <select class="form-select" id="preferred_contract_type" bind:value={$form.preferred_contract_type}>
                                        <option value="">Select contract type</option>
                                        <option value="full_time">Full Time</option>
                                        <option value="part_time">Part Time</option>
                                        <option value="freelance">Freelance</option>
                                        <option value="internship">Internship</option>
                                        <option value="temporary">Temporary</option>
                                        <option value="contract">Contract</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="preferred_work_mode" class="form-label">Preferred Work Mode</label>
                                    <select class="form-select" id="preferred_work_mode" bind:value={$form.preferred_work_mode}>
                                        <option value="">Select work mode</option>
                                        <option value="on_site">On Site</option>
                                        <option value="remote">Remote</option>
                                        <option value="hybrid">Hybrid</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Skills</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Add your technical and professional skills</p>

                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g., JavaScript, Project Management, Excel..."
                                    bind:value={newSkill}
                                    onkeydown={handleSkillKeydown}
                                />
                                <button class="btn btn-primary" type="button" onclick={addSkill}>
                                    <i class="bi bi-plus-lg"></i> Add
                                </button>
                            </div>

                            {#if $form.skills.length > 0}
                                <div class="d-flex flex-wrap gap-2">
                                    {#each $form.skills as skill}
                                        <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2 d-flex align-items-center gap-2">
                                            {skill}
                                            <button
                                                type="button"
                                                class="btn-close btn-close-sm"
                                                style="font-size: 0.6rem;"
                                                onclick={() => removeSkill(skill)}
                                                aria-label="Remove {skill}"
                                            ></button>
                                        </span>
                                    {/each}
                                </div>
                            {:else}
                                <p class="text-muted small mb-0">No skills added yet. Start typing and press Enter or click Add.</p>
                            {/if}

                            {#if $form.errors.skills}
                                <div class="text-danger small mt-2">{$form.errors.skills}</div>
                            {/if}
                        </div>
                    </div>

                    <!-- Languages -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-translate me-2"></i>Languages</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Add the languages you speak</p>

                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="e.g., Spanish, English, Portuguese..."
                                    bind:value={newLanguage}
                                    onkeydown={handleLanguageKeydown}
                                />
                                <button class="btn btn-primary" type="button" onclick={addLanguage}>
                                    <i class="bi bi-plus-lg"></i> Add
                                </button>
                            </div>

                            {#if $form.languages.length > 0}
                                <div class="d-flex flex-wrap gap-2">
                                    {#each $form.languages as lang}
                                        <span class="badge bg-info-subtle text-info fs-6 px-3 py-2 d-flex align-items-center gap-2">
                                            {lang}
                                            <button
                                                type="button"
                                                class="btn-close btn-close-sm"
                                                style="font-size: 0.6rem;"
                                                onclick={() => removeLanguage(lang)}
                                                aria-label="Remove {lang}"
                                            ></button>
                                        </span>
                                    {/each}
                                </div>
                            {:else}
                                <p class="text-muted small mb-0">No languages added yet.</p>
                            {/if}

                            {#if $form.errors.languages}
                                <div class="text-danger small mt-2">{$form.errors.languages}</div>
                            {/if}
                        </div>
                    </div>

                    <!-- About Me -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="bi bi-chat-text me-2"></i>About Me</h5>
                        </div>
                        <div class="card-body">
                            <textarea
                                class="form-control"
                                rows="4"
                                bind:value={$form.about_me}
                                placeholder="Tell employers about yourself, your experience, and what you're looking for..."
                                maxlength="2000"
                            ></textarea>
                            <small class="text-muted">{($form.about_me || '').length}/2000 characters</small>
                            {#if $form.errors.about_me}
                                <div class="text-danger small mt-1">{$form.errors.about_me}</div>
                            {/if}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
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
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Saving...
                                    {:else}
                                        <i class="bi bi-check-circle me-2"></i>
                                        Save Changes
                                    {/if}
                                </button>
                                <a href="/job-seeker/profile" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Cancel
                                </a>
                            </div>

                            <hr class="my-3" />

                            <!-- Profile Completion Preview -->
                            <h6 class="mb-2">Profile Completion</h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Progress</small>
                                <span class="badge {completionPercentage >= 80 ? 'bg-success' : completionPercentage >= 50 ? 'bg-warning' : 'bg-danger'}">
                                    {completionPercentage}%
                                </span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div
                                    class="progress-bar {completionPercentage >= 80 ? 'bg-success' : completionPercentage >= 50 ? 'bg-warning' : 'bg-danger'}"
                                    style="width: {completionPercentage}%"
                                ></div>
                            </div>

                            <ul class="list-unstyled small mb-0">
                                {#each Object.entries(completionFields) as [field, completed]}
                                    <li class="d-flex align-items-center mb-1">
                                        {#if completed}
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        {:else}
                                            <i class="bi bi-circle text-muted me-2"></i>
                                        {/if}
                                        <span class={completed ? 'text-muted' : 'fw-semibold'}>{field}</span>
                                    </li>
                                {/each}
                            </ul>
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

    .btn-close-sm {
        padding: 0;
        background-size: 0.5rem;
    }
</style>
