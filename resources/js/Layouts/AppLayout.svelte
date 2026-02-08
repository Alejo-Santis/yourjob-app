<script>
    import { page } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import Navigation from './Navigation.svelte';
    import Sidebar from './Sidebar.svelte';
    import Footer from './Footer.svelte';
    import Toast from '../Components/Toast.svelte';
    import CommandPalette from '../Components/CommandPalette.svelte';

    let { children } = $props();

    let isAuthenticated = $derived($page.props.auth?.user);
    let sidebarOpen = $state(false);

    function toggleSidebar() {
        sidebarOpen = !sidebarOpen;
    }

    function closeSidebar() {
        sidebarOpen = false;
    }

    onMount(() => {
        function handleToggle() {
            toggleSidebar();
        }
        window.addEventListener('toggle-sidebar', handleToggle);
        return () => window.removeEventListener('toggle-sidebar', handleToggle);
    });
</script>

<div class="app-layout">
    <Navigation />

    <div class="layout-container">
        {#if isAuthenticated}
            <Sidebar
                userType={$page.props.auth.user.user_type}
                open={sidebarOpen}
                onclose={closeSidebar}
            />
        {/if}

        <main class="main-content" class:with-sidebar={isAuthenticated}>
            {@render children()}
        </main>
    </div>

    <Footer />
</div>

<Toast />
<CommandPalette />

<style>
    .app-layout {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #f8f9fa;
    }

    .layout-container {
        display: flex;
        flex: 1;
    }

    .main-content {
        flex: 1;
        padding: 2rem 1.5rem;
        overflow-y: auto;
    }

    .main-content.with-sidebar {
        margin-left: 265px;
    }

    @media (max-width: 991px) {
        .main-content {
            padding: 1.25rem 1rem;
        }

        .main-content.with-sidebar {
            margin-left: 0;
        }
    }

    @media (max-width: 576px) {
        .main-content {
            padding: 1rem 0.75rem;
        }
    }
</style>
