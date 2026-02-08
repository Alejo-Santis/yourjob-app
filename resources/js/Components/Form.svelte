<script>
    let { title = '', onSubmit = () => {}, isLoading = false, children } = $props();

    let formElement;

    function handleSubmit(e) {
        e.preventDefault();
        onSubmit(e);
    }
</script>

<div class="form-container card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h5 class="card-title mb-0">{title}</h5>
    </div>
    <div class="card-body">
        <form bind:this={formElement} onsubmit={handleSubmit}>
            {@render children()}
        </form>
    </div>
</div>

<style>
    .form-container {
        border: none;
        border-radius: 0.75rem;
    }

    .form-container :global(.form-group) {
        margin-bottom: 1.5rem;
    }

    .form-container :global(.form-label) {
        font-weight: 500;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .form-container :global(.form-control) {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.625rem 0.875rem;
    }

    .form-container :global(.form-control:focus) {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>
