<script>
    import Navigation from './Navigation.svelte';
    import Footer from './Footer.svelte';
    import Toast from '../Components/Toast.svelte';
    import CommandPalette from '../Components/CommandPalette.svelte';

    let { children } = $props();
</script>

<div class="guest-layout">
    <Navigation />

    <main class="guest-content">
        {@render children()}
    </main>

    <Footer />
</div>

<Toast />
<CommandPalette />

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
