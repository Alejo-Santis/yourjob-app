<script>
    import { writable } from 'svelte/store';

    let toasts = writable([]);

    export function addToast(message, type = 'info', duration = 3000) {
        const id = Math.random().toString(36).substr(2, 9);
        const toast = { id, message, type };

        toasts.update((t) => [...t, toast]);

        if (duration > 0) {
            setTimeout(() => removeToast(id), duration);
        }

        return id;
    }

    export function removeToast(id) {
        toasts.update((t) => t.filter((toast) => toast.id !== id));
    }
</script>

<div class="toast-container position-fixed top-0 end-0 p-3">
    {#each $toasts as toast (toast.id)}
        <div class="toast show" role="alert">
            <div class="toast-header bg-{toast.type}">
                <strong class="me-auto text-white">Notification</strong>
                <button
                    type="button"
                    class="btn-close"
                    on:click={() => removeToast(toast.id)}
                ></button>
            </div>
            <div class="toast-body">
                {toast.message}
            </div>
        </div>
    {/each}
</div>

<style>
    .toast-container {
        z-index: 9999;
    }

    .toast {
        min-width: 300px;
        margin-bottom: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .toast-header {
        background-color: var(--bs-info, #0dcaf0);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>
