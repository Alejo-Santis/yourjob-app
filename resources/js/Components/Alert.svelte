<script>
    let { alert = null } = $props();

    function getIcon(type) {
        const icons = {
            success: 'check-circle-fill',
            danger: 'exclamation-circle-fill',
            warning: 'exclamation-triangle-fill',
            info: 'info-circle-fill',
        };
        return icons[type] || 'info-circle-fill';
    }
</script>

{#if alert}
    <div
        class="alert alert-{alert.type} alert-dismissible fade show"
        role="alert"
    >
        <i class="bi bi-{getIcon(alert.type)} me-2"></i>
        {alert.message}
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
{/if}

<style>
    .alert {
        border-radius: 0.5rem;
        border: none;
    }

    .alert-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #842029;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #664d03;
    }

    .alert-info {
        background-color: #cfe2ff;
        color: #084298;
    }
</style>
