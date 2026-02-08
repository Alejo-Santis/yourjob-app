<script>
    import { router } from '@inertiajs/svelte';
    import { onMount } from 'svelte';

    let isOpen = $state(false);
    let query = $state('');
    let results = $state([]);
    let selectedIndex = $state(0);
    let loading = $state(false);
    let inputEl = $state(null);
    let debounceTimer = null;

    onMount(() => {
        function handleKeydown(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                toggle();
            }
            if (e.key === 'Escape' && isOpen) {
                close();
            }
        }
        window.addEventListener('keydown', handleKeydown);
        return () => window.removeEventListener('keydown', handleKeydown);
    });

    function toggle() {
        isOpen = !isOpen;
        if (isOpen) {
            query = '';
            results = [];
            selectedIndex = 0;
            setTimeout(() => inputEl?.focus(), 50);
        }
    }

    function close() {
        isOpen = false;
        query = '';
        results = [];
    }

    function handleInput() {
        clearTimeout(debounceTimer);
        if (query.length < 2) {
            results = [];
            return;
        }
        loading = true;
        debounceTimer = setTimeout(async () => {
            try {
                const res = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
                const data = await res.json();
                results = data.results || [];
                selectedIndex = 0;
            } catch {
                results = [];
            } finally {
                loading = false;
            }
        }, 250);
    }

    function handleKeydown(e) {
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, results.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, 0);
        } else if (e.key === 'Enter' && results[selectedIndex]) {
            e.preventDefault();
            navigateTo(results[selectedIndex]);
        }
    }

    function navigateTo(item) {
        close();
        router.visit(item.url);
    }

    function handleBackdropClick(e) {
        if (e.target === e.currentTarget) {
            close();
        }
    }

    function getTypeLabel(type) {
        return type === 'job' ? 'Job' : 'Page';
    }

    function getTypeColor(type) {
        return type === 'job' ? '#3b82f6' : '#8b5cf6';
    }

    export function open() {
        isOpen = true;
        query = '';
        results = [];
        selectedIndex = 0;
        setTimeout(() => inputEl?.focus(), 50);
    }
</script>

{#if isOpen}
    <!-- svelte-ignore a11y_no_static_element_interactions -->
    <div class="palette-backdrop" onclick={handleBackdropClick} onkeydown={handleKeydown}>
        <div class="palette-container">
            <!-- Search Input -->
            <div class="palette-header">
                <i class="bi bi-search palette-search-icon"></i>
                <input
                    bind:this={inputEl}
                    bind:value={query}
                    oninput={handleInput}
                    type="text"
                    class="palette-input"
                    placeholder="Search jobs, pages, actions..."
                    autocomplete="off"
                    spellcheck="false"
                />
                <kbd class="palette-kbd">ESC</kbd>
            </div>

            <!-- Results -->
            <div class="palette-body">
                {#if loading && query.length >= 2}
                    <div class="palette-loading">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        <span>Searching...</span>
                    </div>
                {:else if results.length > 0}
                    <div class="palette-results">
                        {#each results as item, i}
                            <button
                                class="palette-item"
                                class:selected={i === selectedIndex}
                                onclick={() => navigateTo(item)}
                                onmouseenter={() => selectedIndex = i}
                            >
                                <div class="palette-item-icon" style="background: {getTypeColor(item.type)}15; color: {getTypeColor(item.type)}">
                                    <i class="bi bi-{item.icon}"></i>
                                </div>
                                <div class="palette-item-content">
                                    <span class="palette-item-title">{item.title}</span>
                                    <span class="palette-item-subtitle">{item.subtitle}</span>
                                </div>
                                <span class="palette-item-type" style="background: {getTypeColor(item.type)}15; color: {getTypeColor(item.type)}">
                                    {getTypeLabel(item.type)}
                                </span>
                            </button>
                        {/each}
                    </div>
                {:else if query.length >= 2 && !loading}
                    <div class="palette-empty">
                        <i class="bi bi-inbox"></i>
                        <p>No results for "{query}"</p>
                    </div>
                {:else}
                    <div class="palette-hints">
                        <p class="palette-hints-title">Quick Actions</p>
                        <div class="palette-hints-grid">
                            <button class="palette-hint" onclick={() => { close(); router.visit('/jobs'); }}>
                                <i class="bi bi-search"></i>
                                <span>Browse Jobs</span>
                            </button>
                            <button class="palette-hint" onclick={() => { query = 'dashboard'; handleInput(); }}>
                                <i class="bi bi-grid-1x2"></i>
                                <span>Dashboard</span>
                            </button>
                            <button class="palette-hint" onclick={() => { query = 'profile'; handleInput(); }}>
                                <i class="bi bi-person"></i>
                                <span>Profile</span>
                            </button>
                            <button class="palette-hint" onclick={() => { query = 'applications'; handleInput(); }}>
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Applications</span>
                            </button>
                        </div>
                    </div>
                {/if}
            </div>

            <!-- Footer -->
            <div class="palette-footer">
                <div class="palette-footer-hint">
                    <kbd>&uarr;</kbd><kbd>&darr;</kbd> navigate
                </div>
                <div class="palette-footer-hint">
                    <kbd>&crarr;</kbd> select
                </div>
                <div class="palette-footer-hint">
                    <kbd>esc</kbd> close
                </div>
            </div>
        </div>
    </div>
{/if}

<style>
    .palette-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 12vh;
        animation: fadeIn 0.15s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: scale(0.98) translateY(-8px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .palette-container {
        width: 100%;
        max-width: 640px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: slideIn 0.2s ease;
    }

    /* ── Header ── */
    .palette-header {
        display: flex;
        align-items: center;
        padding: 0 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        gap: 0.75rem;
    }

    .palette-search-icon {
        font-size: 1.1rem;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .palette-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 1rem 0;
        font-size: 1rem;
        color: #1e293b;
        background: transparent;
    }

    .palette-input::placeholder {
        color: #94a3b8;
    }

    .palette-kbd {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 0.7rem;
        color: #64748b;
        font-family: inherit;
        flex-shrink: 0;
    }

    /* ── Body ── */
    .palette-body {
        max-height: 400px;
        overflow-y: auto;
    }

    .palette-body::-webkit-scrollbar {
        width: 4px;
    }

    .palette-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    /* ── Loading ── */
    .palette-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 2rem;
        color: #64748b;
        font-size: 0.875rem;
    }

    /* ── Results ── */
    .palette-results {
        padding: 0.5rem;
    }

    .palette-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
        padding: 0.65rem 0.75rem;
        border: none;
        background: transparent;
        border-radius: 10px;
        cursor: pointer;
        text-align: left;
        transition: background 0.1s;
    }

    .palette-item:hover,
    .palette-item.selected {
        background: #f1f5f9;
    }

    .palette-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .palette-item-content {
        flex: 1;
        min-width: 0;
    }

    .palette-item-title {
        display: block;
        font-weight: 600;
        font-size: 0.875rem;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .palette-item-subtitle {
        display: block;
        font-size: 0.75rem;
        color: #94a3b8;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .palette-item-type {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        flex-shrink: 0;
    }

    /* ── Empty State ── */
    .palette-empty {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #94a3b8;
    }

    .palette-empty i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .palette-empty p {
        margin: 0;
        font-size: 0.875rem;
    }

    /* ── Hints (default state) ── */
    .palette-hints {
        padding: 1rem 1.25rem;
    }

    .palette-hints-title {
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }

    .palette-hints-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }

    .palette-hint {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        color: #475569;
        font-size: 0.825rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
    }

    .palette-hint:hover {
        background: #f8fafc;
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .palette-hint i {
        font-size: 1rem;
        color: #94a3b8;
    }

    .palette-hint:hover i {
        color: #3b82f6;
    }

    /* ── Footer ── */
    .palette-footer {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 0.6rem 1.25rem;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .palette-footer-hint {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.7rem;
        color: #94a3b8;
    }

    .palette-footer kbd {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 1px 5px;
        font-size: 0.65rem;
        font-family: inherit;
        color: #64748b;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .palette-backdrop {
            padding-top: 1rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .palette-hints-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
