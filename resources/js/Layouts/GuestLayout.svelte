<script>
    import Navigation from './Navigation.svelte';
    import Footer from './Footer.svelte';
    import Toast from '../Components/Toast.svelte';
</script>

<div class="guest-layout">
    <Navigation />

    <main class="guest-content">
        <slot />
    </main>

    <Footer />
</div>

<Toast />

<style>
    .guest-layout {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .guest-content {
        flex: 1;
    }
</style>
