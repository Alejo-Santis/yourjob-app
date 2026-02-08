<script>
    import { page } from "@inertiajs/svelte";

    let { userType = "job_seeker" } = $props();

    const jobSeekerItems = [
        { label: "Browse Jobs", href: "/jobs", icon: "search" },
        { label: "My Favorites", href: "/favorites", icon: "heart" },
        { label: "Applications", href: "/applications", icon: "file-earmark" },
        { label: "Profile", href: "/job-seeker/profile", icon: "person" },
    ];

    const employerItems = [
        {
            label: "Post Job",
            href: "/employer/jobs/create",
            icon: "plus-circle",
        },
        {
            label: "My Listings",
            href: "/employer/listings",
            icon: "list-check",
        },
        {
            label: "Applications",
            href: "/employer/applications",
            icon: "inbox",
        },
        { label: "Analytics", href: "/employer/analytics", icon: "graph-up" },
        { label: "Profile", href: "/employer/profile", icon: "person" },
    ];

    const adminItems = [
        { label: "Users", href: "/admin/users", icon: "people" },
        { label: "Job Listings", href: "/admin/jobs", icon: "briefcase" },
        {
            label: "Applications",
            href: "/admin/applications",
            icon: "file-earmark-text",
        },
    ];

    const itemsMap = {
        job_seeker: jobSeekerItems,
        employer: employerItems,
        admin: adminItems,
    };

    let items = $derived(itemsMap[userType] || jobSeekerItems);

    // El dashboard se maneja aparte para la separación visual
    const dashboardHref = `/${userType.replace("_", "-")}/dashboard`;
</script>

<aside class="sidebar bg-white border-end d-flex flex-column">
    <div class="sidebar-content flex-grow-1">
        <nav class="nav flex-column px-3 mb-4">
            <a
                href={dashboardHref}
                class="nav-link"
                class:active={$page.url === dashboardHref}
            >
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </nav>

        <p class="sidebar-label">GESTIÓN Y EXPLORACIÓN</p>

        <nav class="nav flex-column px-3">
            {#each items as item (item.label)}
                <a
                    href={item.href}
                    class="nav-link mb-1"
                    class:active={$page.url === item.href ||
                        $page.url.startsWith(item.href)}
                >
                    <i class="bi bi-{item.icon}"></i>
                    <span>{item.label}</span>
                </a>
            {/each}
        </nav>
    </div>

    <div class="sidebar-footer p-3">
        <div class="version-card">
            <div class="d-flex align-items-center mb-2">
                <div class="version-badge">v1.0.4</div>
                <span class="ms-2 status-dot"></span>
                <span class="status-text">Online</span>
            </div>
            <p class="mb-0 small text-muted">YourJob Pro Platform</p>
        </div>

        <button
            class="btn btn-logout w-100 mt-3 d-flex align-items-center justify-content-center gap-2" aria-label="Sidebar Toggle"
        >
            <i class="bi bi-layout-text-sidebar-reverse"></i>
        </button>
    </div>
</aside>

<style>
    .sidebar {
        width: 265px;
        height: calc(100vh - 56px);
        position: fixed;
        left: 0;
        top: 56px;
        z-index: 100;
    }

    .sidebar-content {
        padding-top: 1.5rem;
        overflow-y: auto;
    }

    /* Labels de separación */
    .sidebar-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #94a3b8;
        padding: 0 1.5rem 0.75rem 1.8rem;
        margin: 0;
        letter-spacing: 0.05rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.7rem 1rem;
        color: #475569;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        gap: 12px;
    }

    .nav-link i {
        font-size: 1.15rem;
    }

    .nav-link:hover {
        background-color: #f8fafc;
        color: #0d6efd;
    }

    .nav-link.active {
        background-color: #eff6ff;
        color: #2563eb;
        font-weight: 600;
    }

    /* Estilos de la Footer Card */
    .sidebar-footer {
        border-top: 1px solid #f1f5f9;
        background-color: #fff;
    }

    .version-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
    }

    .version-badge {
        background: #e2e8f0;
        color: #475569;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 700;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        background-color: #22c55e;
        border-radius: 50%;
        display: inline-block;
    }

    .status-text {
        font-size: 0.7rem;
        color: #64748b;
        margin-left: 4px;
    }

    .version-link {
        font-size: 0.7rem;
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }

    .version-link:hover {
        text-decoration: underline;
    }

    /* Botón de Logout */
    .btn-logout {
        background-color: #fff;
        border: 1px solid #fee2e2;
        color: #dc2626;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.6rem;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .btn-logout:hover {
        background-color: #fef2f2;
        border-color: #fecaca;
    }

    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }
    }
</style>
