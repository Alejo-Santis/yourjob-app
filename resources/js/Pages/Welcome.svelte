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
                                <button type="submit" class="search-btn">
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
                            <p class="featured-label">Featured by:</p>
                            <div class="company-logos">
                                <span class="company-logo">Microsoft</span>
                                <span class="company-logo">Google</span>
                                <span class="company-logo">Amazon</span>
                                <span class="company-logo">Apple</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="hero-image-wrapper">
                            <!-- Professional Icon Instead of Image -->
                            <div class="professional-circle">
                                <i class="bi bi-person-circle professional-icon"></i>
                            </div>

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
                        <div class="illustration-wrapper">
                            <i class="bi bi-person-workspace illustration-icon"></i>
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
                        <div class="content-badge mb-3">For Employers</div>
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
                        <div class="illustration-wrapper">
                            <i class="bi bi-building illustration-icon"></i>
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
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    }

    /* Hero Section */
    .hero-section {
        padding: 80px 0 120px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        padding: 40px 0;
    }

    .hero-label {
        color: #0d6efd;
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 16px;
        animation: fadeInDown 0.6s ease;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: #1a1d29;
        line-height: 1.2;
        margin-bottom: 24px;
        animation: fadeInUp 0.6s ease 0.1s backwards;
    }

    .hero-title .text-primary {
        color: #0d6efd;
    }

    .hero-description {
        font-size: 1.125rem;
        color: #6c757d;
        line-height: 1.7;
        margin-bottom: 32px;
        animation: fadeInUp 0.6s ease 0.2s backwards;
    }

    /* Search Bar */
    .search-wrapper {
        max-width: 500px;
        animation: fadeInUp 0.6s ease 0.3s backwards;
    }

    .search-form {
        position: relative;
        display: flex;
        align-items: center;
        background: white;
        border-radius: 50px;
        padding: 8px 8px 8px 60px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .search-form:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
    }

    .search-btn {
        position: absolute;
        left: 8px;
        width: 44px;
        height: 44px;
        background: #0d6efd;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.125rem;
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
        font-size: 1rem;
        color: #495057;
        background: transparent;
    }

    .search-input::placeholder {
        color: #adb5bd;
    }

    /* Featured Companies */
    .featured-companies {
        animation: fadeInUp 0.6s ease 0.4s backwards;
    }

    .featured-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 16px;
        font-weight: 500;
    }

    .company-logos {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        align-items: center;
    }

    .company-logo {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 600;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .company-logo:hover {
        opacity: 1;
    }

    /* Hero Image Section */
    .hero-image-wrapper {
        position: relative;
        height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .professional-circle {
        width: 450px;
        height: 450px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
        animation: float 6s ease-in-out infinite;
    }

    .professional-icon {
        font-size: 20rem;
        color: rgba(255, 255, 255, 0.9);
    }

    /* Floating Badges */
    .floating-badge {
        position: absolute;
        background: white;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        animation: floatBadge 3s ease-in-out infinite;
    }

    .badge-1 {
        top: 100px;
        left: -20px;
        animation-delay: 0s;
    }

    .badge-2 {
        bottom: 120px;
        right: -20px;
        animation-delay: 1.5s;
    }

    .badge-icon {
        width: 48px;
        height: 48px;
        background: #e7f1ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        font-size: 1.25rem;
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
        font-size: 1.25rem;
        color: #1a1d29;
        font-weight: 700;
    }

    .badge-text-content small {
        font-size: 0.813rem;
        color: #6c757d;
        font-weight: 500;
    }

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

    .btn-outline-dark {
        border: 2px solid #212529;
        color: #212529;
        border-radius: 12px;
        font-weight: 600;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-dark:hover {
        background: #212529;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Features Section */
    .features-section {
        padding: 120px 0;
        background: #ffffff;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: 1.125rem;
        color: #6c757d;
    }

    .feature-card {
        padding: 48px 32px;
        text-align: center;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        background: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        border-color: transparent;
    }

    .feature-icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon-wrapper {
        background: #0d6efd;
    }

    .feature-icon {
        font-size: 2.5rem;
        color: #0d6efd;
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        color: white;
        transform: scale(1.1);
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 16px;
    }

    .feature-text {
        font-size: 1rem;
        color: #6c757d;
        line-height: 1.7;
        margin: 0;
    }

    /* Content Sections (Job Seekers & Employers) */
    .job-seekers-section,
    .employers-section {
        padding: 120px 0;
        background: #ffffff;
    }

    .employers-section {
        background: #f8f9fa;
    }

    .content-badge {
        display: inline-block;
        padding: 6px 16px;
        background: #0d6efd;
        color: white;
        border-radius: 50px;
        font-size: 0.813rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .content-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #212529;
        line-height: 1.2;
    }

    .content-description {
        font-size: 1.125rem;
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
        padding: 12px 0;
        font-size: 1.063rem;
        color: #495057;
    }

    .feature-list-item i {
        color: #0d6efd;
        font-size: 1.25rem;
        margin-right: 16px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .feature-list-item span {
        flex: 1;
    }

    .illustration-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 24px;
    }

    .illustration-icon {
        font-size: 12rem;
        color: #0d6efd;
        opacity: 0.15;
    }

    /* CTA Section */
    .cta-section {
        padding: 120px 0;
        background: #ffffff;
    }

    .cta-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 2px solid #e9ecef;
        border-radius: 24px;
        padding: 80px 40px;
        text-align: center;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 1rem;
    }

    .cta-description {
        font-size: 1.25rem;
        color: #6c757d;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes floatBadge {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.75rem;
        }

        .hero-content {
            padding: 20px 0;
        }

        .section-title,
        .content-title,
        .cta-title {
            font-size: 2rem;
        }

        .illustration-wrapper {
            margin-top: 40px;
            padding: 40px;
        }

        .illustration-icon {
            font-size: 8rem;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 60px 0 80px;
        }

        .hero-title {
            font-size: 2.25rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .search-wrapper {
            max-width: 100%;
        }

        .featured-companies {
            margin-top: 40px !important;
        }

        .features-section,
        .job-seekers-section,
        .employers-section,
        .cta-section {
            padding: 80px 0;
        }

        .section-title,
        .content-title,
        .cta-title {
            font-size: 1.75rem;
        }

        .feature-card {
            padding: 32px 24px;
        }

        .cta-card {
            padding: 60px 24px;
        }

        .btn-lg {
            padding: 12px 24px !important;
            font-size: 1rem;
        }
    }
</style>
