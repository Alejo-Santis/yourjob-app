<script>
    import GuestLayout from '../Layouts/GuestLayout.svelte';
    import { page, router } from '@inertiajs/svelte';

    $: isAuthenticated = $page.props.auth?.user;
    $: userType = $page.props.auth?.user?.user_type;

    let searchQuery = '';

    function handleSearch(e) {
        e.preventDefault();
        router.get('/jobs', { title: searchQuery });
    }
</script>

<GuestLayout>
    <div class="welcome-container">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Content -->
                    <div class="col-lg-6 hero-content">
                        <p class="hero-label">You need a job?</p>
                        <h1 class="hero-title">
                            Let's find<br>
                            your <span class="text-primary">Dream Job</span>
                        </h1>
                        <p class="hero-description">
                            We post new jobs update here everyday. We guide<br class="d-none d-xl-block">
                            you to find a new job for you.
                        </p>

                        <!-- Search Bar -->
                        <div class="search-wrapper">
                            <form on:submit={handleSearch} class="search-form">
                                <button type="submit" class="search-btn" aria-label="search">
                                    <i class="bi bi-search"></i>
                                </button>
                                <input
                                    type="text"
                                    bind:value={searchQuery}
                                    class="search-input"
                                    placeholder="Search jobs here"
                                />
                            </form>
                        </div>

                        <!-- Quick Actions (if authenticated) -->
                        {#if isAuthenticated}
                            <div class="quick-actions mt-4">
                                {#if userType === 'job_seeker'}
                                    <a href="/job-seeker/dashboard" class="btn btn-link text-decoration-none">
                                        <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                                    </a>
                                {:else if userType === 'employer'}
                                    <a href="/employer/dashboard" class="btn btn-link text-decoration-none">
                                        <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                                    </a>
                                {:else if userType === 'admin'}
                                    <a href="/admin/dashboard" class="btn btn-link text-decoration-none">
                                        <i class="bi bi-speedometer2 me-2"></i>Go to Admin Panel
                                    </a>
                                {/if}
                            </div>
                        {/if}

                        <!-- Featured Companies -->
                        <div class="featured-companies mt-5">
                            <p class="featured-label">
                                <i class="bi bi-star-fill text-warning"></i>
                                Featured by:
                            </p>
                            <div class="company-logos">
                                <span class="company-logo">
                                    <i class="bi bi-receipt"></i>
                                    Nextpyme Colombia SAS
                                </span>
                                <span class="company-logo">
                                    <i class="bi bi-envelope-check"></i>
                                    RelayNx</span>
                                <span class="company-logo">
                                    <i class="bi bi-filetype-php"></i>
                                    SantiNet SAS</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="hero-image-wrapper">
                            <!-- Background Circle -->
                            <div class="hero-bg-circle"></div>
                            <div class="hero-bg-circle-outline"></div>

                            <!-- Person Image -->
                            <img
                                src="/assets/images/businessman-working-2.png"
                                alt="Professional businessman"
                                class="hero-person-img"
                            />

                            <!-- Floating Badges -->
                            <div class="floating-badge badge-1">
                                <div class="badge-icon">
                                    <i class="bi bi-briefcase-fill"></i>
                                </div>
                                <div class="badge-text-content">
                                    <small>Daily Jobs Updates</small>
                                </div>
                            </div>

                            <div class="floating-badge badge-2">
                                <div class="badge-icon bg-primary">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="badge-text-content">
                                    <strong>24,300+</strong>
                                    <small>Candidates got jobs</small>
                                </div>
                            </div>

                            <!-- Decorative dots -->
                            <div class="hero-dots"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Why Choose YourJob?</h2>
                    <p class="section-subtitle">Everything you need to find or hire great talent</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon-wrapper">
                                <i class="bi bi-bullseye feature-icon"></i>
                            </div>
                            <h5 class="feature-title">Smart Matching</h5>
                            <p class="feature-text">
                                Our intelligent algorithm matches you with jobs that fit your skills, experience, and preferences
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon-wrapper">
                                <i class="bi bi-shield-check feature-icon"></i>
                            </div>
                            <h5 class="feature-title">Verified Companies</h5>
                            <p class="feature-text">
                                All employers are verified to ensure you're applying to legitimate opportunities
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon-wrapper">
                                <i class="bi bi-lightning-charge feature-icon"></i>
                            </div>
                            <h5 class="feature-title">Quick Apply</h5>
                            <p class="feature-text">
                                Apply to multiple jobs with just one click using your saved profile
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- For Job Seekers -->
        <section class="job-seekers-section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <div class="content-badge mb-3">For Job Seekers</div>
                        <h2 class="content-title mb-4">Find Your Perfect Match</h2>
                        <p class="content-description mb-4">
                            Everything you need to discover opportunities and land your dream job
                        </p>
                        <ul class="feature-list">
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Create a professional profile in minutes</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Get personalized job recommendations</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Track your applications in one place</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Save favorite jobs and apply later</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>See your match score with each job</span>
                            </li>
                        </ul>
                        {#if !isAuthenticated}
                            <a href="/register?type=job_seeker" class="btn btn-dark btn-lg px-4 py-3 mt-4">
                                Sign Up as Job Seeker
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        {/if}
                    </div>
                    <div class="col-lg-6">
                        <div class="section-image-wrapper">
                            <div class="section-image-bg seekers-bg"></div>
                            <img
                                src="/assets/images/meeting.jpg"
                                alt="Team meeting"
                                class="section-image"
                            />
                            <div class="section-image-badge seekers-badge">
                                <div class="badge-icon">
                                    <i class="bi bi-rocket-takeoff-fill"></i>
                                </div>
                                <div class="badge-text-content">
                                    <strong>10K+</strong>
                                    <small>Jobs available</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- For Employers -->
        <section class="employers-section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 order-lg-2">
                        <div class="content-badge employer-badge mb-3">For Employers</div>
                        <h2 class="content-title mb-4">Hire Top Talent Faster</h2>
                        <p class="content-description mb-4">
                            Powerful tools to help you find and connect with the right candidates
                        </p>
                        <ul class="feature-list">
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Post unlimited job listings</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Reach qualified candidates instantly</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Manage applications efficiently</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Access analytics and insights</span>
                            </li>
                            <li class="feature-list-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Build your employer brand</span>
                            </li>
                        </ul>
                        {#if !isAuthenticated}
                            <a href="/register?type=employer" class="btn btn-dark btn-lg px-4 py-3 mt-4">
                                Sign Up as Employer
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        {/if}
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="section-image-wrapper">
                            <div class="section-image-bg employers-bg"></div>
                            <img
                                src="/assets/images/business-people-teamwork.jpg"
                                alt="Business teamwork"
                                class="section-image"
                            />
                            <div class="section-image-badge employers-badge-float">
                                <div class="badge-icon bg-primary">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div class="badge-text-content">
                                    <strong>95%</strong>
                                    <small>Hiring success</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-card">
                    <h2 class="cta-title">Ready to Get Started?</h2>
                    <p class="cta-description">
                        Join thousands of job seekers and employers finding success on YourJob
                    </p>
                    {#if !isAuthenticated}
                        <a href="/register" class="btn btn-primary btn-lg px-5 py-3">
                            <i class="bi bi-person-plus me-2"></i>Create Your Account
                        </a>
                    {:else}
                        <a href="/jobs" class="btn btn-primary btn-lg px-5 py-3">
                            <i class="bi bi-search me-2"></i>Browse Jobs Now
                        </a>
                    {/if}
                </div>
            </div>
        </section>
    </div>
</GuestLayout>

<style>
    .welcome-container {
        background: #f8fafe;
    }

    /* ============ HERO SECTION ============ */
    .hero-section {
        padding: 60px 0 100px;
        background: linear-gradient(160deg, #f8fafe 0%, #eef2f9 50%, #e8edf6 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        padding: 40px 0;
    }

    .hero-label {
        color: #0d6efd;
        font-size: 0.938rem;
        font-weight: 600;
        margin-bottom: 16px;
        padding: 6px 16px;
        background: rgba(13, 110, 253, 0.08);
        border-radius: 50px;
        display: inline-block;
        animation: fadeInDown 0.6s ease;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: #1a1d29;
        line-height: 1.15;
        margin-bottom: 24px;
        animation: fadeInUp 0.6s ease 0.1s backwards;
    }

    .hero-title .text-primary { color: #0d6efd; }

    .hero-description {
        font-size: 1.063rem;
        color: #6c757d;
        line-height: 1.8;
        margin-bottom: 32px;
        animation: fadeInUp 0.6s ease 0.2s backwards;
    }

    /* Search Bar */
    .search-wrapper {
        max-width: 480px;
        animation: fadeInUp 0.6s ease 0.3s backwards;
    }

    .search-form {
        position: relative;
        display: flex;
        align-items: center;
        background: white;
        border-radius: 50px;
        padding: 6px 6px 6px 56px;
        box-shadow: 0 8px 32px rgba(13, 110, 253, 0.08), 0 2px 8px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        border: 1px solid rgba(13, 110, 253, 0.08);
    }

    .search-form:hover,
    .search-form:focus-within {
        box-shadow: 0 12px 40px rgba(13, 110, 253, 0.12), 0 4px 12px rgba(0,0,0,0.06);
        border-color: rgba(13, 110, 253, 0.15);
    }

    .search-btn {
        position: absolute;
        left: 6px;
        width: 42px;
        height: 42px;
        background: #0d6efd;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #0b5ed7;
        transform: scale(1.05);
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 12px 16px;
        font-size: 0.938rem;
        color: #495057;
        background: transparent;
    }

    .search-input::placeholder { color: #adb5bd; }

    /* Featured Companies */
    .featured-companies { animation: fadeInUp 0.6s ease 0.4s backwards; }

    .featured-label {
        font-size: 0.813rem;
        color: #9ca3af;
        margin-bottom: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .company-logos {
        display: flex;
        gap: 28px;
        flex-wrap: wrap;
        align-items: center;
    }

    .company-logo {
        font-size: 0.938rem;
        color: #9ca3af;
        font-weight: 700;
        opacity: 0.6;
        transition: opacity 0.3s ease;
    }

    .company-logo:hover { opacity: 1; }

    /* ============ HERO IMAGE ============ */
    .hero-image-wrapper {
        position: relative;
        height: 560px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-bg-circle {
        position: absolute;
        width: 420px;
        height: 420px;
        background: linear-gradient(135deg, #dbeafe 0%, #c7d7f7 100%);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    .hero-bg-circle-outline {
        position: absolute;
        width: 500px;
        height: 500px;
        border: 1px solid rgba(13, 110, 253, 0.08);
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 0;
    }

    .hero-person-img {
        position: relative;
        z-index: 2;
        width: 380px;
        height: 480px;
        object-fit: cover;
        object-position: top center;
        border-radius: 200px 200px 40px 40px;
        filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.15));
    }

    .hero-dots {
        position: absolute;
        top: 60px;
        right: 30px;
        width: 60px;
        height: 60px;
        background-image: radial-gradient(circle, #0d6efd 1.5px, transparent 1.5px);
        background-size: 12px 12px;
        opacity: 0.25;
        z-index: 0;
    }

    /* Floating Badges */
    .floating-badge {
        position: absolute;
        background: white;
        border-radius: 16px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        z-index: 10;
        animation: floatBadge 3s ease-in-out infinite;
    }

    .badge-1 {
        top: 90px;
        left: -10px;
        animation-delay: 0s;
    }

    .badge-2 {
        bottom: 100px;
        right: -10px;
        animation-delay: 1.5s;
    }

    .badge-icon {
        width: 44px;
        height: 44px;
        background: #e7f1ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .badge-icon.bg-primary {
        background: #0d6efd;
        color: white;
    }

    .badge-text-content {
        display: flex;
        flex-direction: column;
    }

    .badge-text-content strong {
        font-size: 1.125rem;
        color: #1a1d29;
        font-weight: 700;
        line-height: 1.2;
    }

    .badge-text-content small {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* ============ BUTTONS ============ */
    .btn-primary {
        background: #0d6efd;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    }

    .btn-primary:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.25);
    }

    /* ============ FEATURES SECTION ============ */
    .features-section {
        padding: 100px 0;
        background: #ffffff;
    }

    .section-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.75rem;
    }

    .section-subtitle {
        font-size: 1.063rem;
        color: #6c757d;
    }

    .feature-card {
        padding: 40px 28px;
        text-align: center;
        border-radius: 20px;
        border: 1px solid #eef0f4;
        background: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(13, 110, 253, 0.08);
        border-color: rgba(13, 110, 253, 0.1);
    }

    .feature-icon-wrapper {
        width: 72px;
        height: 72px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef4ff;
        border-radius: 18px;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon-wrapper { background: #0d6efd; }

    .feature-icon {
        font-size: 2rem;
        color: #0d6efd;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        color: white;
        transform: scale(1.1);
    }

    .feature-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 12px;
    }

    .feature-text {
        font-size: 0.938rem;
        color: #6c757d;
        line-height: 1.7;
        margin: 0;
    }

    /* ============ CONTENT SECTIONS ============ */
    .job-seekers-section,
    .employers-section {
        padding: 100px 0;
        background: #ffffff;
    }

    .employers-section {
        background: #f8fafe;
    }

    .content-badge {
        display: inline-block;
        padding: 6px 16px;
        background: #0d6efd;
        color: white;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .employer-badge {
        background: #1a1d29;
    }

    .content-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #212529;
        line-height: 1.2;
    }

    .content-description {
        font-size: 1.063rem;
        color: #6c757d;
        line-height: 1.7;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .feature-list-item {
        display: flex;
        align-items: flex-start;
        padding: 10px 0;
        font-size: 1rem;
        color: #495057;
    }

    .feature-list-item i {
        color: #0d6efd;
        font-size: 1.125rem;
        margin-right: 14px;
        margin-top: 3px;
        flex-shrink: 0;
    }

    .feature-list-item span { flex: 1; }

    /* ============ SECTION IMAGES ============ */
    .section-image-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .section-image-bg {
        position: absolute;
        width: 85%;
        height: 85%;
        border-radius: 24px;
        z-index: 0;
    }

    .seekers-bg {
        background: linear-gradient(135deg, #dbeafe 0%, #c7d7f7 100%);
        top: 10%;
        right: 0;
    }

    .employers-bg {
        background: linear-gradient(135deg, #e0e7ff 0%, #d5dff7 100%);
        top: 10%;
        left: 0;
    }

    .section-image {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 480px;
        height: 360px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }

    .section-image-badge {
        position: absolute;
        z-index: 5;
        background: white;
        border-radius: 14px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        animation: floatBadge 3s ease-in-out infinite;
    }

    .seekers-badge {
        bottom: 20px;
        right: 0;
        animation-delay: 0.5s;
    }

    .employers-badge-float {
        bottom: 20px;
        left: 0;
        animation-delay: 1s;
    }

    /* ============ CTA SECTION ============ */
    .cta-section {
        padding: 100px 0;
        background: #ffffff;
    }

    .cta-card {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border: none;
        border-radius: 24px;
        padding: 80px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .cta-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }

    .cta-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .cta-description {
        font-size: 1.125rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 2rem;
        max-width: 550px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        z-index: 1;
    }

    .cta-section .btn-primary {
        background: white;
        color: #0d6efd;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }

    .cta-section .btn-primary:hover {
        background: #f8f9fa;
        color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    /* ============ ANIMATIONS ============ */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes floatBadge {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 1200px) {
        .hero-person-img {
            width: 320px;
            height: 400px;
        }

        .hero-bg-circle { width: 360px; height: 360px; }
        .hero-bg-circle-outline { width: 430px; height: 430px; }
    }

    @media (max-width: 992px) {
        .hero-title { font-size: 2.75rem; }
        .hero-content { padding: 20px 0; }

        .section-title,
        .content-title,
        .cta-title { font-size: 2rem; }

        .section-image-wrapper { margin-top: 40px; }
        .section-image { height: 280px; }
    }

    @media (max-width: 768px) {
        .hero-section { padding: 40px 0 60px; }
        .hero-content { padding: 20px 0; }
        .hero-label { margin-bottom: 20px; font-size: 0.875rem; }
        .hero-title { font-size: 2.25rem; margin-bottom: 20px; }
        .hero-description { font-size: 1rem; margin-bottom: 28px; line-height: 1.7; }
        .search-wrapper { max-width: 100%; }
        .featured-companies { margin-top: 32px !important; }

        .features-section,
        .job-seekers-section,
        .employers-section,
        .cta-section { padding: 70px 0; }

        .section-title,
        .content-title,
        .cta-title { font-size: 1.75rem; }

        .feature-card { padding: 32px 24px; }
        .cta-card { padding: 60px 24px; }

        .section-image-wrapper { padding: 10px; }
        .section-image { height: 240px; max-width: 100%; }
        .section-image-badge { display: none; }

        .btn-lg {
            padding: 12px 24px !important;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .hero-section { padding: 24px 0 40px; }
        .hero-content { padding: 16px 8px; }
        .hero-label {
            margin-bottom: 24px;
            font-size: 0.813rem;
            padding: 5px 14px;
        }
        .hero-title {
            font-size: 1.75rem;
            margin-bottom: 24px;
            line-height: 1.25;
        }
        .hero-description {
            font-size: 0.938rem;
            margin-bottom: 32px;
            line-height: 1.75;
        }
        .search-wrapper { margin-bottom: 8px; }
        .search-form {
            padding: 4px 4px 4px 48px;
        }
        .search-btn {
            width: 36px;
            height: 36px;
            font-size: 0.875rem;
        }
        .search-input {
            padding: 10px 12px;
            font-size: 0.875rem;
        }
        .featured-companies { margin-top: 36px !important; }
        .featured-label { font-size: 0.75rem; margin-bottom: 10px; }
        .company-logos { gap: 16px; }
        .company-logo { font-size: 0.813rem; }

        .features-section,
        .job-seekers-section,
        .employers-section,
        .cta-section { padding: 50px 0; }

        .section-title,
        .content-title,
        .cta-title { font-size: 1.5rem; }

        .content-description { font-size: 0.938rem; }
        .feature-list-item { font-size: 0.938rem; padding: 8px 0; }
        .cta-card { padding: 48px 20px; }
        .cta-description { font-size: 1rem; }
    }
</style>
