<script>
    let { title = '', value = 0, icon = 'briefcase', color = 'primary', stats = null } = $props();
</script>

{#if stats}
    <!-- Grid mode: render all stats from object (used by Employer Dashboard) -->
    <div class="stats-grid">
        <div class="stat-card card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Active Listings</p>
                        <h4 class="mb-0">{stats.active_listings || 0}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success">
                        <i class="bi bi-file-earmark"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Total Applications</p>
                        <h4 class="mb-0">{stats.total_applications || 0}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Avg Applications</p>
                        <h4 class="mb-0">{stats.avg_applications || 0}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ms-3">
                        <p class="text-muted mb-0">Total Listings</p>
                        <h4 class="mb-0">{stats.total_listings || 0}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
{:else}
    <!-- Single card mode (used by Job Seeker Dashboard) -->
    <div class="stat-card card shadow-sm h-100">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-{color}">
                    <i class="bi bi-{icon}"></i>
                </div>
                <div class="ms-3">
                    <p class="text-muted mb-0">{title}</p>
                    <h4 class="mb-0">{value}</h4>
                </div>
            </div>
        </div>
    </div>
{/if}

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        border: none;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        color: white;
        flex-shrink: 0;
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            font-size: 1.1rem;
        }
    }

    .stat-icon.bg-primary { background-color: #0d6efd; }
    .stat-icon.bg-success { background-color: #198754; }
    .stat-icon.bg-info { background-color: #0dcaf0; }
    .stat-icon.bg-warning { background-color: #ffc107; color: #000; }
    .stat-icon.bg-danger { background-color: #dc3545; }

    h4 {
        color: #212529;
        font-weight: 700;
    }
</style>
