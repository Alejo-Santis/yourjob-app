<script>
    import { useForm, page } from '@inertiajs/svelte';

    let { status = '' } = $props();

    const form = useForm({
        email: '',
        password: '',
        remember: false
    });

    function submit(e) {
        e.preventDefault();
        $form.post('/login', {
            onFinish: () => {
                if ($form.errors.password) {
                    $form.password = '';
                }
            }
        });
    }
</script>

<svelte:head>
    <title>Login - YourJob</title>
</svelte:head>

<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <!-- Logo/Header -->
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold text-primary">YourJob</h1>
                            <p class="text-muted">Sign in to your account</p>
                        </div>

                        <!-- Status Message -->
                        {#if status}
                            <div class="alert alert-success mb-4">
                                {status}
                            </div>
                        {/if}

                        <!-- Login Form -->
                        <form onsubmit={submit}>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control {$form.errors.email ? 'is-invalid' : ''}"
                                    id="email"
                                    bind:value={$form.email}
                                    required
                                    autofocus
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
                                    autocomplete="current-password"
                                />
                                {#if $form.errors.password}
                                    <div class="invalid-feedback">{$form.errors.password}</div>
                                {/if}
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="remember"
                                    bind:checked={$form.remember}
                                />
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
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
                                        Signing in...
                                    {:else}
                                        Sign in
                                    {/if}
                                </button>
                            </div>

                            <!-- Links -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/forgot-password" class="text-decoration-none small">
                                    Forgot password?
                                </a>
                                <a href="/register" class="text-decoration-none small">
                                    Don't have an account?
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
</style>
