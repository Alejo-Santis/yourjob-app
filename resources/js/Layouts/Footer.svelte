<script>
    const currentYear = new Date().getFullYear();
</script>

<footer class="modern-footer">
    <div class="container">
        <!-- Main Footer Content -->
        <div class="footer-content">
            <div class="row g-4">
                <!-- Brand Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <div class="brand-logo">
                            <div class="logo-icon">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <span class="logo-text">YourJob</span>
                        </div>
                        <p class="brand-description">
                            Connect talent with opportunity. Find your next job or hire the best candidates.
                        </p>
                        <div class="social-links">
                            <a href="/" class="social-link" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="/" class="social-link" aria-label="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="/" class="social-link" aria-label="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="/" class="social-link" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- For Job Seekers -->
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="footer-column">
                        <h6 class="column-title">For Job Seekers</h6>
                        <ul class="footer-links">
                            <li><a href="/jobs" class="footer-link">Browse Jobs</a></li>
                            <li><a href="/favorites" class="footer-link">Saved Jobs</a></li>
                            <li><a href="/applications" class="footer-link">Applications</a></li>
                            <li><a href="/register" class="footer-link">Sign Up</a></li>
                        </ul>
                    </div>
                </div>

                <!-- For Employers -->
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="footer-column">
                        <h6 class="column-title">For Employers</h6>
                        <ul class="footer-links">
                            <li><a href="/jobs/create" class="footer-link">Post a Job</a></li>
                            <li><a href="/employer/listings" class="footer-link">My Jobs</a></li>
                            <li><a href="/employer/analytics" class="footer-link">Analytics</a></li>
                            <li><a href="/register" class="footer-link">Sign Up</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Company -->
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="footer-column">
                        <h6 class="column-title">Company</h6>
                        <ul class="footer-links">
                            <li><a href="/" class="footer-link">About Us</a></li>
                            <li><a href="/" class="footer-link">Contact</a></li>
                            <li><a href="/" class="footer-link">Careers</a></li>
                            <li><a href="/" class="footer-link">Blog</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Support -->
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="footer-column">
                        <h6 class="column-title">Support</h6>
                        <ul class="footer-links">
                            <li><a href="/" class="footer-link">Help Center</a></li>
                            <li><a href="/" class="footer-link">Safety</a></li>
                            <li><a href="/" class="footer-link">Terms</a></li>
                            <li><a href="/" class="footer-link">Privacy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="copyright">
                        &copy; {currentYear} YourJob. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="footer-bottom-links">
                        <a href="/" class="bottom-link">Privacy Policy</a>
                        <span class="separator">•</span>
                        <a href="/" class="bottom-link">Terms of Service</a>
                        <span class="separator">•</span>
                        <a href="/" class="bottom-link">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .modern-footer {
        margin-top: auto;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .footer-content {
        padding: 80px 0 40px;
    }

    /* Brand Section */
    .footer-brand {
        padding-right: 20px;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .logo-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .logo-text {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1d29;
        letter-spacing: -0.5px;
    }

    .brand-description {
        color: #6c757d;
        font-size: 0.938rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    /* Social Links */
    .social-links {
        display: flex;
        gap: 0.75rem;
    }

    .social-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        color: #6c757d;
        text-decoration: none;
        font-size: 1.125rem;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #0d6efd;
        border-color: #0d6efd;
        color: white;
        transform: translateY(-2px);
    }

    /* Footer Columns */
    .footer-column {
        height: 100%;
    }

    .column-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1a1d29;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.25rem;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-link {
        color: #6c757d;
        text-decoration: none;
        font-size: 0.938rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-link:hover {
        color: #0d6efd;
        transform: translateX(4px);
    }

    /* Footer Bottom */
    .footer-bottom {
        padding: 24px 0;
        border-top: 1px solid #e9ecef;
    }

    .copyright {
        color: #6c757d;
        font-size: 0.875rem;
        margin: 0;
    }

    .footer-bottom-links {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .bottom-link {
        color: #6c757d;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .bottom-link:hover {
        color: #0d6efd;
    }

    .separator {
        color: #dee2e6;
        font-size: 0.75rem;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .footer-content {
            padding: 60px 0 30px;
        }

        .footer-brand {
            padding-right: 0;
            margin-bottom: 2rem;
        }
    }

    @media (max-width: 767px) {
        .footer-content {
            padding: 40px 0 20px;
        }

        .footer-bottom-links {
            justify-content: flex-start;
        }

        .brand-logo {
            margin-bottom: 1rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            font-size: 1.125rem;
        }

        .logo-text {
            font-size: 1.25rem;
        }

        .column-title {
            font-size: 0.813rem;
        }
    }
</style>
