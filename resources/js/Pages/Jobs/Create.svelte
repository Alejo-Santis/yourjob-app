<script>
    import AppLayout from '../../Layouts/AppLayout.svelte';
    import { useForm } from '@inertiajs/svelte';

    const form = useForm({
        title: '',
        description: '',
        requirements: '',
        benefits: '',
        position_level: '',
        years_experience_required: '',
        industry_sector: '',
        salary_min: '',
        salary_max: '',
        currency: 'USD',
        salary_period: 'month',
        contract_type: '',
        work_mode: '',
        city: '',
        state: '',
        country: '',
        required_skills: [],
        nice_to_have_skills: [],
        tags: [],
        vacancy_count: 1,
        deadline_at: '',
    });

    let skillInput = '';
    let niceSkillInput = '';
    let tagInput = '';

    function addSkill() {
        if (skillInput.trim()) {
            $form.required_skills = [...$form.required_skills, skillInput.trim()];
            skillInput = '';
        }
    }

    function removeSkill(index) {
        $form.required_skills = $form.required_skills.filter((_, i) => i !== index);
    }

    function addNiceSkill() {
        if (niceSkillInput.trim()) {
            $form.nice_to_have_skills = [...$form.nice_to_have_skills, niceSkillInput.trim()];
            niceSkillInput = '';
        }
    }

    function removeNiceSkill(index) {
        $form.nice_to_have_skills = $form.nice_to_have_skills.filter((_, i) => i !== index);
    }

    function addTag() {
        if (tagInput.trim()) {
            $form.tags = [...$form.tags, tagInput.trim()];
            tagInput = '';
        }
    }

    function removeTag(index) {
        $form.tags = $form.tags.filter((_, i) => i !== index);
    }

    function submit(e) {
        e.preventDefault();
        $form.post('/employer/jobs');
    }
</script>

<AppLayout>
    <div class="job-create-container">
        <div class="mb-4">
            <h1 class="h2 mb-1">Post New Job</h1>
            <p class="text-muted">Create a new job listing to attract qualified candidates</p>
        </div>

        <form on:submit={submit}>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Basic Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Job Title *</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="title"
                                    bind:value={$form.title}
                                    required
                                    placeholder="e.g., Senior Software Engineer"
                                />
                                {#if $form.errors.title}
                                    <div class="text-danger small mt-1">{$form.errors.title}</div>
                                {/if}
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Job Description *</label>
                                <textarea
                                    class="form-control"
                                    id="description"
                                    rows="8"
                                    bind:value={$form.description}
                                    required
                                    placeholder="Describe the role, responsibilities, and what makes this position exciting..."
                                ></textarea>
                                {#if $form.errors.description}
                                    <div class="text-danger small mt-1">{$form.errors.description}</div>
                                {/if}
                            </div>

                            <div class="mb-3">
                                <label for="requirements" class="form-label">Requirements</label>
                                <textarea
                                    class="form-control"
                                    id="requirements"
                                    rows="6"
                                    bind:value={$form.requirements}
                                    placeholder="List the qualifications and requirements..."
                                ></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="benefits" class="form-label">Benefits</label>
                                <textarea
                                    class="form-control"
                                    id="benefits"
                                    rows="5"
                                    bind:value={$form.benefits}
                                    placeholder="List the benefits and perks..."
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Job Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="contract_type" class="form-label">Contract Type *</label>
                                    <select class="form-select" id="contract_type" bind:value={$form.contract_type} required>
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
                                    <label for="work_mode" class="form-label">Work Mode *</label>
                                    <select class="form-select" id="work_mode" bind:value={$form.work_mode} required>
                                        <option value="">Select work mode</option>
                                        <option value="on_site">On Site</option>
                                        <option value="remote">Remote</option>
                                        <option value="hybrid">Hybrid</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="position_level" class="form-label">Position Level</label>
                                    <select class="form-select" id="position_level" bind:value={$form.position_level}>
                                        <option value="">Select level</option>
                                        <option value="entry">Entry Level</option>
                                        <option value="mid">Mid Level</option>
                                        <option value="senior">Senior Level</option>
                                        <option value="lead">Lead/Principal</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="years_experience_required" class="form-label">Years of Experience</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="years_experience_required"
                                        bind:value={$form.years_experience_required}
                                        min="0"
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="vacancy_count" class="form-label">Number of Vacancies</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="vacancy_count"
                                        bind:value={$form.vacancy_count}
                                        min="1"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label for="deadline_at" class="form-label">Application Deadline</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="deadline_at"
                                        bind:value={$form.deadline_at}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Location</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City *</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="city"
                                        bind:value={$form.city}
                                        required
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label for="state" class="form-label">State</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="state"
                                        bind:value={$form.state}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Salary -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Salary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="salary_min" class="form-label">Minimum Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="salary_min"
                                            bind:value={$form.salary_min}
                                            min="0"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="salary_max" class="form-label">Maximum Salary</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="salary_max"
                                            bind:value={$form.salary_max}
                                            min="0"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="salary_period" class="form-label">Period</label>
                                    <select class="form-select" id="salary_period" bind:value={$form.salary_period}>
                                        <option value="hour">Per Hour</option>
                                        <option value="day">Per Day</option>
                                        <option value="month">Per Month</option>
                                        <option value="year">Per Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Required Skills</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        bind:value={skillInput}
                                        placeholder="Add a required skill..."
                                        on:keypress={(e) => e.key === 'Enter' && (e.preventDefault(), addSkill())}
                                    />
                                    <button type="button" class="btn btn-primary" on:click={addSkill}>
                                        <i class="bi bi-plus-circle"></i> Add
                                    </button>
                                </div>
                            </div>
                            {#if $form.required_skills.length > 0}
                                <div class="d-flex flex-wrap gap-2">
                                    {#each $form.required_skills as skill, index}
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            {skill}
                                            <button
                                                type="button"
                                                class="btn-close btn-close-white ms-2"
                                                style="font-size: 0.7rem;"
                                                on:click={() => removeSkill(index)}
                                            ></button>
                                        </span>
                                    {/each}
                                </div>
                            {/if}
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Nice to Have Skills</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control"
                                        bind:value={niceSkillInput}
                                        placeholder="Add a nice to have skill..."
                                        on:keypress={(e) => e.key === 'Enter' && (e.preventDefault(), addNiceSkill())}
                                    />
                                    <button type="button" class="btn btn-secondary" on:click={addNiceSkill}>
                                        <i class="bi bi-plus-circle"></i> Add
                                    </button>
                                </div>
                            </div>
                            {#if $form.nice_to_have_skills.length > 0}
                                <div class="d-flex flex-wrap gap-2">
                                    {#each $form.nice_to_have_skills as skill, index}
                                        <span class="badge bg-secondary fs-6 px-3 py-2">
                                            {skill}
                                            <button
                                                type="button"
                                                class="btn-close btn-close-white ms-2"
                                                style="font-size: 0.7rem;"
                                                on:click={() => removeNiceSkill(index)}
                                            ></button>
                                        </span>
                                    {/each}
                                </div>
                            {/if}
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
                                        Creating...
                                    {:else}
                                        <i class="bi bi-check-circle me-2"></i>
                                        Create Job
                                    {/if}
                                </button>
                                <a href="/employer/dashboard" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Cancel
                                </a>
                            </div>

                            <hr class="my-3" />

                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="bi bi-info-circle me-2"></i>
                                    Your job will be saved as a draft. You can publish it later from your dashboard.
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
    .job-create-container {
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
