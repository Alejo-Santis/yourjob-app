<script>
    import { page } from '@inertiajs/svelte';
    import Navigation from './Navigation.svelte';
    import Sidebar from './Sidebar.svelte';
    import Footer from './Footer.svelte';
    import Toast from '../Components/Toast.svelte';

    $: isAuthenticated = $page.props.auth?.user;
</script>

<div class="app-layout">
    <Navigation />

    <div class="layout-container">
        {#if isAuthenticated}
            <Sidebar userType={$page.props.auth.user.user_type} />
        {/if}

        <main class="main-content" class:with-sidebar={isAuthenticated}>
            <slot />
        </main>
    </div>

    <Footer />
</div>

<Toast />

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
        margin-left: 250px;
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }

        .main-content.with-sidebar {
            margin-left: 0;
        }
    }
</style>
