<script>
    import { page, router } from "@inertiajs/svelte";
    import { onMount } from "svelte";

    let { userType = "job_seeker", open = false, onclose = () => {} } = $props();

    const jobSeekerItems = [
        { label: "Browse Jobs", href: "/jobs", icon: "search" },
        { label: "My Favorites", href: "/job-seeker/favorites", icon: "heart-fill" },
        { label: "Applications", href: "/applications", icon: "file-earmark-text" },
        { label: "Profile", href: "/job-seeker/profile", icon: "person-badge" },
    ];

    const employerItems = [
        { label: "Post Job", href: "/employer/jobs/create", icon: "plus-circle-fill" },
        { label: "My Listings", href: "/employer/listings", icon: "list-columns-reverse" },
        { label: "Applications", href: "/employer/applications", icon: "inbox-fill" },
        { label: "Analytics", href: "/employer/analytics", icon: "bar-chart-line-fill" },
        { label: "Profile", href: "/employer/profile", icon: "building" },
    ];

    const adminItems = [
        { label: "Users", href: "/admin/users", icon: "people-fill" },
        { label: "Job Listings", href: "/admin/jobs", icon: "briefcase-fill" },
        { label: "Applications", href: "/admin/applications", icon: "file-earmark-text-fill" },
    ];

    const itemsMap = {
        job_seeker: jobSeekerItems,
        employer: employerItems,
        admin: adminItems,
    };

    let items = $derived(itemsMap[userType] || jobSeekerItems);

    const dashboardHref = `/${userType.replace("_", "-")}/dashboard`;

    const userLabel = $derived(() => {
        const labels = { job_seeker: "Job Seeker", employer: "Employer", admin: "Admin" };
        return labels[userType] || "User";
    });

    function logout() {
        router.post('/logout');
    }

    function handleNavClick() {
        onclose();
    }

    onMount(() => {
        return router.on('navigate', () => {
            onclose();
        });
    });
</script>

<!-- Mobile Backdrop -->
{#if open}
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <div class="sidebar-backdrop" onclick={onclose} onkeydown={() => {}}></div>
{/if}

<aside class="sidebar d-flex flex-column" class:open>
    <!-- Close button (mobile only) -->
    <button class="sidebar-close" onclick={onclose} aria-label="Close sidebar">
        <i class="bi bi-x-lg"></i>
    </button>

    <!-- User Profile Section -->
    <div class="sidebar-profile">
        <div class="profile-avatar">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="profile-info">
            <p class="profile-name">{$page.props.auth?.user?.email?.split('@')[0] || 'User'}</p>
            <span class="profile-role">{userLabel()}</span>
        </div>
    </div>

    <!-- Navigation Content -->
    <div class="sidebar-content flex-grow-1">
        <!-- Dashboard Link -->
        <div class="nav-section">
            <p class="section-label">MAIN</p>
            <nav class="nav flex-column">
                <a
                    href={dashboardHref}
                    class="nav-link"
                    class:active={$page.url === dashboardHref}
                    onclick={handleNavClick}
                >
                    <div class="nav-icon">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                    <span>Dashboard</span>
                </a>
            </nav>
        </div>

        <!-- Menu Items -->
        <div class="nav-section">
            <p class="section-label">MANAGEMENT</p>
            <nav class="nav flex-column">
                {#each items as item (item.label)}
                    <a
                        href={item.href}
                        class="nav-link"
                        class:active={$page.url === item.href || $page.url.startsWith(item.href)}
                        onclick={handleNavClick}
                    >
                        <div class="nav-icon">
                            <i class="bi bi-{item.icon}"></i>
                        </div>
                        <span>{item.label}</span>
                    </a>
                {/each}
            </nav>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="version-card">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="status-indicator"></span>
                    <span class="version-text">YourJob Pro</span>
                </div>
                <span class="version-badge">v1.0.4</span>
            </div>
        </div>

        <button class="btn-logout" onclick={logout}>
            <i class="bi bi-box-arrow-left"></i>
            <span>Log Out</span>
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
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border-right: 1px solid #e2e8f0;
    }

    .sidebar-close {
        display: none;
    }

    .sidebar-backdrop {
        display: none;
    }

    /* ──── Profile Section ──── */
    .sidebar-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 1.25rem 1.25rem 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .profile-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .profile-info {
        overflow: hidden;
    }

    .profile-name {
        margin: 0;
        font-weight: 700;
        font-size: 0.9rem;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }

    .profile-role {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    /* ──── Content ──── */
    .sidebar-content {
        padding-top: 0.5rem;
        overflow-y: auto;
    }

    .sidebar-content::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    /* ──── Sections ──── */
    .nav-section {
        padding: 0.5rem 0;
    }

    .section-label {
        font-size: 0.625rem;
        font-weight: 700;
        color: #94a3b8;
        padding: 0.5rem 1.5rem 0.4rem;
        margin: 0;
        letter-spacing: 0.08em;
    }

    /* ──── Nav Links ──── */
    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.55rem 1.25rem;
        margin: 1px 0.75rem;
        color: #64748b;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        gap: 12px;
        font-size: 0.875rem;
        font-weight: 500;
        position: relative;
        min-height: 44px;
    }

    .nav-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .nav-icon i {
        font-size: 1rem;
        color: #64748b;
        transition: color 0.2s ease;
    }

    .nav-link:hover {
        color: #3b82f6;
        background: #eff6ff;
    }

    .nav-link:hover .nav-icon {
        background: #dbeafe;
    }

    .nav-link:hover .nav-icon i {
        color: #3b82f6;
    }

    .nav-link.active {
        color: #1d4ed8;
        background: #eff6ff;
        font-weight: 600;
    }

    .nav-link.active .nav-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
    }

    .nav-link.active .nav-icon i {
        color: white;
    }

    .nav-link.active::before {
        content: '';
        position: absolute;
        left: -0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: linear-gradient(180deg, #3b82f6, #1d4ed8);
        border-radius: 0 3px 3px 0;
    }

    /* ──── Footer ──── */
    .sidebar-footer {
        padding: 0.75rem 1rem;
        border-top: 1px solid #f1f5f9;
    }

    .version-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        margin-bottom: 0.6rem;
    }

    .status-indicator {
        width: 7px;
        height: 7px;
        background: #22c55e;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 6px rgba(34, 197, 94, 0.4);
        animation: pulse-green 2s infinite;
    }

    @keyframes pulse-green {
        0%, 100% { box-shadow: 0 0 4px rgba(34, 197, 94, 0.3); }
        50% { box-shadow: 0 0 8px rgba(34, 197, 94, 0.6); }
    }

    .version-text {
        font-size: 0.72rem;
        color: #475569;
        font-weight: 600;
    }

    .version-badge {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        color: #2563eb;
        font-size: 0.65rem;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    /* ──── Logout Button ──── */
    .btn-logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 0.6rem;
        background: #fff;
        border: 1px solid #fecaca;
        color: #dc2626;
        font-size: 0.825rem;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 44px;
    }

    .btn-logout:hover {
        background: #fef2f2;
        border-color: #f87171;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.1);
    }

    .btn-logout i {
        font-size: 1rem;
    }

    /* ──── Mobile: Drawer Overlay ──── */
    @media (max-width: 991px) {
        .sidebar-backdrop {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(2px);
            z-index: 1040;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .sidebar {
            top: 0;
            height: 100vh;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: none;
            border-right: none;
        }

        .sidebar.open {
            transform: translateX(0);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
        }

        .sidebar-close {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            width: 32px;
            height: 32px;
            border: none;
            background: #f1f5f9;
            border-radius: 8px;
            color: #64748b;
            font-size: 0.85rem;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s;
        }

        .sidebar-close:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .sidebar-profile {
            padding-top: 1rem;
        }

        .nav-link {
            padding: 0.65rem 1.25rem;
            font-size: 0.925rem;
            min-height: 48px;
        }

        .nav-icon {
            width: 38px;
            height: 38px;
        }

        .btn-logout {
            min-height: 48px;
            font-size: 0.9rem;
        }
    }
</style>
