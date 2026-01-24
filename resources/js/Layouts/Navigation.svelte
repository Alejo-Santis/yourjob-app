<script>
    import { page } from '$app/stores';
    import { onMount } from 'svelte';
    import { router } from '@inertiajs/svelte';

    let isMenuOpen = false;
    let isProfileOpen = false;

    const toggleMenu = () => {
        isMenuOpen = !isMenuOpen;
    };

    const toggleProfile = () => {
        isProfileOpen = !isProfileOpen;
    };

    const logout = () => {
        router.post('/logout');
    };

    onMount(() => {
        // Close menu on navigation
        router.on('navigate', () => {
            isMenuOpen = false;
            isProfileOpen = false;
        });
    });
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">
            <i class="bi bi-briefcase-fill me-2"></i>
            YourJob
        </a>

        <button class="navbar-toggler" on:click={toggleMenu}>
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" class:show={isMenuOpen}>
            {#if !$page.props.auth?.user}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/jobs">
                            <i class="bi bi-search me-1"></i>
                            Browse Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm text-white ms-2" href="/register">
                            Sign Up
                        </a>
                    </li>
                </ul>
            {:else}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/jobs">
                            <i class="bi bi-briefcase me-1"></i>
                            Jobs
                        </a>
                    </li>

                    {#if $page.props.auth.user.user_type === 'job_seeker'}
                        <li class="nav-item">
                            <a class="nav-link" href="/favorites">
                                <i class="bi bi-heart me-1"></i>
                                Favorites
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/applications">
                                <i class="bi bi-file-earmark me-1"></i>
                                Applications
                            </a>
                        </li>
                    {:else if $page.props.auth.user.user_type === 'employer'}
                        <li class="nav-item">
                            <a class="nav-link" href="/employer/listings">
                                <i class="bi bi-list-check me-1"></i>
                                Listings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/employer/applications">
                                <i class="bi bi-inbox me-1"></i>
                                Applications
                            </a>
                        </li>
                    {/if}

                    <li class="nav-item dropdown">
                        <button
                            class="nav-link btn btn-link dropdown-toggle"
                            on:click={toggleProfile}
                        >
                            <i class="bi bi-person-circle me-1"></i>
                            {$page.props.auth.user.email}
                        </button>

                        {#if isProfileOpen}
                            <div class="dropdown-menu show">
                                <a
                                    class="dropdown-item"
                                    href={$page.props.auth.user.user_type === 'job_seeker'
                                        ? '/job-seeker/profile'
                                        : '/employer/profile'}
                                >
                                    <i class="bi bi-person me-2"></i>
                                    Profile
                                </a>
                                <a
                                    class="dropdown-item"
                                    href={$page.props.auth.user.user_type === 'job_seeker'
                                        ? '/job-seeker/dashboard'
                                        : '/employer/dashboard'}
                                >
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    Dashboard
                                </a>
                                <hr class="dropdown-divider" />
                                <button class="dropdown-item" on:click={logout}>
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </div>
                        {/if}
                    </li>
                </ul>
            {/if}
        </div>
    </div>
</nav>

<style>
    .navbar-brand {
        font-size: 1.5rem;
        letter-spacing: 0.5px;
    }

    .dropdown-menu.show {
        display: block;
        position: absolute;
        top: 100%;
        right: 0;
        z-index: 1000;
    }

    .nav-link {
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: #0d6efd !important;
    }

    .btn-primary.btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
