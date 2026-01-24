<script>
    import { page } from '$app/stores';
    import Navigation from './Navigation.svelte';
    import Sidebar from './Sidebar.svelte';
    import Footer from './Footer.svelte';
    import Toast from '../Components/Toast.svelte';
</script>

<div class="app-layout">
    <Navigation />

    <div class="layout-container">
        {#if $page.props.auth?.user}
            <Sidebar userType={$page.props.auth.user.user_type} />
        {/if}

        <main class="main-content">
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
        gap: 1px;
    }

    .main-content {
        flex: 1;
        padding: 2rem 1.5rem;
        overflow-y: auto;
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }
    }
</style>
