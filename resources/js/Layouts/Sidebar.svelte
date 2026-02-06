<script>
    import { page } from '@inertiajs/svelte';

    export let userType = 'job_seeker';

    const jobSeekerItems = [
        { label: 'Dashboard', href: '/job-seeker/dashboard', icon: 'speedometer2' },
        { label: 'Browse Jobs', href: '/jobs', icon: 'search' },
        { label: 'My Favorites', href: '/favorites', icon: 'heart' },
        { label: 'Applications', href: '/applications', icon: 'file-earmark' },
        { label: 'Profile', href: '/job-seeker/profile', icon: 'person' },
    ];

    const employerItems = [
        { label: 'Dashboard', href: '/employer/dashboard', icon: 'speedometer2' },
        { label: 'Post Job', href: '/employer/jobs/create', icon: 'plus-circle' },
        { label: 'My Listings', href: '/employer/listings', icon: 'list-check' },
        { label: 'Applications', href: '/employer/applications', icon: 'inbox' },
        { label: 'Analytics', href: '/employer/analytics', icon: 'graph-up' },
        { label: 'Profile', href: '/employer/profile', icon: 'person' },
    ];

    const adminItems = [
        { label: 'Dashboard', href: '/admin/dashboard', icon: 'speedometer2' },
        { label: 'Users', href: '/admin/users', icon: 'people' },
        { label: 'Job Listings', href: '/admin/jobs', icon: 'briefcase' },
        { label: 'Applications', href: '/admin/applications', icon: 'file-earmark-text' },
    ];

    const itemsMap = {
        job_seeker: jobSeekerItems,
        employer: employerItems,
        admin: adminItems,
    };

    const items = itemsMap[userType] || jobSeekerItems;
</script>

<aside class="sidebar bg-white border-end">
    <div class="sidebar-content">
        <nav class="nav flex-column">
            {#each items as item (item.label)}
                <a
                    href={item.href}
                    class="nav-link"
                    class:active={$page.url === item.href || $page.url.startsWith(item.href)}
                >
                    <i class="bi bi-{item.icon} me-2"></i>
                    <span>{item.label}</span>
                </a>
            {/each}
        </nav>
    </div>
</aside>

<style>
    .sidebar {
        width: 250px;
        max-height: calc(100vh - 56px);
        position: fixed;
        left: 0;
        top: 56px;
        overflow-y: auto;
        z-index: 100;
    }

    .sidebar-content {
        padding: 1.5rem 0;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .nav-link:hover {
        color: #0d6efd;
        background-color: #f8f9fa;
        border-left-color: #0d6efd;
    }

    .nav-link.active {
        color: #0d6efd;
        background-color: #e7f1ff;
        border-left-color: #0d6efd;
        font-weight: 600;
    }

    .nav-link i {
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            max-height: none;
            position: relative;
            top: 0;
            left: 0;
            display: none;
        }

        .sidebar.show {
            display: block;
        }
    }
</style>
