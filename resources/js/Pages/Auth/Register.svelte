<script>
    import { useForm } from '@inertiajs/svelte';

    const form = useForm({
        email: '',
        password: '',
        password_confirmation: '',
        user_type: 'job_seeker'
    });

    function submit(e) {
        e.preventDefault();
        $form.post('/register', {
            onFinish: () => {
                if ($form.errors.password) {
                    $form.password = '';
                    $form.password_confirmation = '';
                }
            }
        });
    }
</script>

<svelte:head>
    <title>Register - YourJob</title>
</svelte:head>

<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <!-- Logo/Header -->
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold text-primary">YourJob</h1>
                            <p class="text-muted">Create your account</p>
                        </div>

                        <!-- Register Form -->
                        <form on:submit={submit}>
                            <!-- User Type Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">I am a:</label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="user-type-card {$form.user_type === 'job_seeker' ? 'active' : ''}">
                                            <input
                                                type="radio"
                                                name="user_type"
                                                value="job_seeker"
                                                bind:group={$form.user_type}
                                                hidden
                                            />
                                            <div class="text-center p-3">
                                                <i class="bi bi-person-workspace fs-1 text-primary"></i>
                                                <h6 class="mt-2 mb-0">Job Seeker</h6>
                                                <small class="text-muted">Looking for jobs</small>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="user-type-card {$form.user_type === 'employer' ? 'active' : ''}">
                                            <input
                                                type="radio"
                                                name="user_type"
                                                value="employer"
                                                bind:group={$form.user_type}
                                                hidden
                                            />
                                            <div class="text-center p-3">
                                                <i class="bi bi-building fs-1 text-success"></i>
                                                <h6 class="mt-2 mb-0">Employer</h6>
                                                <small class="text-muted">Hiring talent</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                {#if $form.errors.user_type}
                                    <div class="text-danger small mt-1">{$form.errors.user_type}</div>
                                {/if}
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control {$form.errors.email ? 'is-invalid' : ''}"
                                    id="email"
                                    bind:value={$form.email}
                                    required
                                    autocomplete="username"
                                />
                                {#if $form.errors.email}
                                    <div class="invalid-feedback">{$form.errors.email}</div>
                                {/if}
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="password"
                                    class="form-control {$form.errors.password ? 'is-invalid' : ''}"
                                    id="password"
                                    bind:value={$form.password}
                                    required
                                    autocomplete="new-password"
                                />
                                {#if $form.errors.password}
                                    <div class="invalid-feedback">{$form.errors.password}</div>
                                {/if}
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input
                                    type="password"
                                    class="form-control {$form.errors.password_confirmation ? 'is-invalid' : ''}"
                                    id="password_confirmation"
                                    bind:value={$form.password_confirmation}
                                    required
                                    autocomplete="new-password"
                                />
                                {#if $form.errors.password_confirmation}
                                    <div class="invalid-feedback">{$form.errors.password_confirmation}</div>
                                {/if}
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    disabled={$form.processing}
                                >
                                    {#if $form.processing}
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Creating account...
                                    {:else}
                                        Create account
                                    {/if}
                                </button>
                            </div>

                            <!-- Links -->
                            <div class="text-center">
                                <span class="text-muted small">Already have an account?</span>
                                <a href="/login" class="text-decoration-none small ms-1">
                                    Sign in
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-3">
                    <a href="/" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-2"></i>Back to home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 1rem;
    }

    .form-label {
        font-weight: 500;
    }

    .user-type-card {
        display: block;
        border: 2px solid #dee2e6;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-type-card:hover {
        border-color: #0d6efd;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .user-type-card.active {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }
</style>
