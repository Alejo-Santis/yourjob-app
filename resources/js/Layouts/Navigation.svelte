<script>
    import { page } from '@inertiajs/svelte';
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
        router.on('navigate', () => {
            isMenuOpen = false;
            isProfileOpen = false;
        });
    });

    $: isActive = (path) => {
        return $page.url === path || $page.url.startsWith(path + '/');
    };
</script>

<nav class="modern-navbar">
    <div class="container">
        <div class="navbar-content">
            <!-- Logo -->
            <a class="navbar-logo" href="/">
                <div class="logo-icon">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <span class="logo-text">YourJob</span>
            </a>

            <!-- Desktop Navigation -->
            <ul class="navbar-menu d-none d-lg-flex">
                <li class="menu-item">
                    <a href="/" class="menu-link" class:active={isActive('/')}>
                        Home
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/jobs" class="menu-link" class:active={isActive('/jobs')}>
                        All Jobs
                    </a>
                </li>
                {#if $page.props.auth?.user}
                    {#if $page.props.auth.user.user_type === 'job_seeker'}
                        <li class="menu-item">
                            <a href="/favorites" class="menu-link" class:active={isActive('/favorites')}>
                                Favorites
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="/applications" class="menu-link" class:active={isActive('/applications')}>
                                Applications
                            </a>
                        </li>
                    {:else if $page.props.auth.user.user_type === 'employer'}
                        <li class="menu-item">
                            <a href="/employer/listings" class="menu-link" class:active={isActive('/employer/listings')}>
                                My Listings
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="/employer/applications" class="menu-link" class:active={isActive('/employer/applications')}>
                                Applications
                            </a>
                        </li>
                    {/if}
                {/if}
            </ul>

            <!-- Right Side Actions -->
            <div class="navbar-actions d-none d-lg-flex">
                {#if !$page.props.auth?.user}
                    <a href="/login" class="action-link">Login</a>
                    <a href="/register" class="action-button">Sign up</a>
                {:else}
                    <div class="user-dropdown">
                        <button class="user-button" on:click={toggleProfile}>
                            <i class="bi bi-person-circle"></i>
                            <span class="user-name">{$page.props.auth.user.email.split('@')[0]}</span>
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        {#if isProfileOpen}
                            <div class="dropdown-panel">
                                <a
                                    class="dropdown-link"
                                    href={$page.props.auth.user.user_type === 'job_seeker'
                                        ? '/job-seeker/dashboard'
                                        : '/employer/dashboard'}
                                >
                                    <i class="bi bi-speedometer2"></i>
                                    Dashboard
                                </a>
                                <a
                                    class="dropdown-link"
                                    href={$page.props.auth.user.user_type === 'job_seeker'
                                        ? '/job-seeker/profile'
                                        : '/employer/profile'}
                                >
                                    <i class="bi bi-person"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-link" on:click={logout}>
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </button>
                            </div>
                        {/if}
                    </div>
                {/if}
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-button d-lg-none" on:click={toggleMenu} aria-label="Toggle menu">
                <i class="bi bi-{isMenuOpen ? 'x' : 'list'}"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        {#if isMenuOpen}
            <div class="mobile-menu d-lg-none">
                <a href="/" class="mobile-link">Home</a>
                <a href="/jobs" class="mobile-link">All Jobs</a>

                {#if $page.props.auth?.user}
                    {#if $page.props.auth.user.user_type === 'job_seeker'}
                        <a href="/favorites" class="mobile-link">Favorites</a>
                        <a href="/applications" class="mobile-link">Applications</a>
                        <a href="/job-seeker/dashboard" class="mobile-link">Dashboard</a>
                        <a href="/job-seeker/profile" class="mobile-link">Profile</a>
                    {:else if $page.props.auth.user.user_type === 'employer'}
                        <a href="/employer/listings" class="mobile-link">My Listings</a>
                        <a href="/employer/applications" class="mobile-link">Applications</a>
                        <a href="/employer/dashboard" class="mobile-link">Dashboard</a>
                        <a href="/employer/profile" class="mobile-link">Profile</a>
                    {/if}
                    <button class="mobile-link" on:click={logout}>Logout</button>
                {:else}
                    <a href="/login" class="mobile-link">Login</a>
                    <a href="/register" class="mobile-button">Sign up</a>
                {/if}
            </div>
        {/if}
    </div>
</nav>

<style>
    .modern-navbar {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 0;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .navbar-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    /* Logo */
    .navbar-logo {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: #1a1d29;
        font-weight: 700;
        font-size: 1.5rem;
        transition: opacity 0.3s ease;
    }

    .navbar-logo:hover {
        opacity: 0.8;
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.125rem;
    }

    .logo-text {
        letter-spacing: -0.5px;
    }

    /* Desktop Menu */
    .navbar-menu {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.5rem;
        flex: 1;
        justify-content: center;
    }

    .menu-item {
        margin: 0;
        padding: 0;
    }

    .menu-link {
        display: block;
        padding: 0.625rem 1.25rem;
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.938rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .menu-link:hover {
        color: #0d6efd;
        background: #f8f9fa;
    }

    .menu-link.active {
        color: #0d6efd;
        background: #e7f1ff;
    }

    /* Navbar Actions */
    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .action-link {
        padding: 0.625rem 1.25rem;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.938rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .action-link:hover {
        color: #0d6efd;
        background: #f8f9fa;
    }

    .action-button {
        padding: 0.625rem 1.5rem;
        background: white;
        color: #0d6efd;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.938rem;
        border: 2px solid #0d6efd;
        border-radius: 50px;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .action-button:hover {
        background: #0d6efd;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    /* User Dropdown */
    .user-dropdown {
        position: relative;
    }

    .user-button {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 50px;
        color: #495057;
        font-weight: 500;
        font-size: 0.938rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-button:hover {
        background: #e9ecef;
        border-color: #dee2e6;
    }

    .user-button i:first-child {
        font-size: 1.25rem;
        color: #0d6efd;
    }

    .user-button i:last-child {
        font-size: 0.75rem;
    }

    .user-name {
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dropdown-panel {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        min-width: 200px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        animation: slideDown 0.2s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.938rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-link:hover {
        background: #f8f9fa;
        color: #0d6efd;
    }

    .dropdown-link i {
        font-size: 1.125rem;
        width: 20px;
        text-align: center;
    }

    .dropdown-divider {
        height: 1px;
        background: #e9ecef;
        margin: 0.5rem 0;
        border: none;
    }

    /* Mobile Menu Button */
    .mobile-menu-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: transparent;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        color: #495057;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .mobile-menu-button:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Mobile Menu */
    .mobile-menu {
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
        margin-top: 1rem;
        animation: slideDown 0.2s ease;
    }

    .mobile-link {
        display: block;
        padding: 0.75rem 1rem;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        border-radius: 8px;
        transition: all 0.2s ease;
        margin-bottom: 0.25rem;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .mobile-link:hover {
        background: #f8f9fa;
        color: #0d6efd;
    }

    .mobile-button {
        display: block;
        padding: 0.75rem 1.5rem;
        background: #0d6efd;
        color: white;
        text-decoration: none;
        font-weight: 600;
        border-radius: 8px;
        text-align: center;
        margin-top: 1rem;
    }

    .mobile-button:hover {
        background: #0b5ed7;
        color: white;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .modern-navbar {
            padding: 0.75rem 0;
        }

        .navbar-content {
            gap: 1rem;
        }

        .logo-text {
            font-size: 1.25rem;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }
    }
</style>
