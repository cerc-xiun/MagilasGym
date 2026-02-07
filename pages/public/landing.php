<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Magilas Gym - Transform your body, elevate your life. Premium fitness facility in San Luis, Pampanga with world-class equipment and expert trainers.">
    <title>Magilas Gym | Transform Your Body, Elevate Your Life</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/landing.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../assets/images/logo.png">
</head>

<body>
    <!-- ===== PRELOADER ===== -->
    <div class="preloader" id="preloader">
        <div class="preloader-content">
            <img src="../../assets/images/logo.png" alt="Magilas Gym" class="preloader-logo">
            <div class="preloader-text">MAGILAS</div>
            <div class="preloader-bar"></div>
        </div>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <img src="../../assets/images/logo.png" alt="Magilas Gym">
                <span class="nav-logo-text">MAGILAS <span>GYM</span></span>
            </a>

            <div class="nav-menu">
                <a href="#about" class="nav-link">About</a>
                <a href="#facilities" class="nav-link">Facilities</a>
                <a href="#pricing" class="nav-link">Pricing</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>

            <div class="nav-actions">
                <a href="../auth/login.php" class="btn btn-ghost btn-sm">Staff Portal</a>
                <a href="../public/register.php" class="btn btn-primary btn-sm">Join Now</a>
                <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-links">
            <a href="#about" class="mobile-menu-link">About</a>
            <a href="#facilities" class="mobile-menu-link">Facilities</a>
            <a href="#pricing" class="mobile-menu-link">Pricing</a>
            <a href="#contact" class="mobile-menu-link">Contact</a>
            <a href="../auth/login.php" class="mobile-menu-link">Staff Portal</a>
        </div>
    </div>

    <!-- ===== HERO ===== -->
    <section class="hero">
        <div class="hero-bg">
            <img src="../../assets/images/hero-bg.jpg" alt="Gym Interior">
        </div>
        <div class="hero-overlay"></div>

        <!-- Animated orbs -->
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-bolt"></i>
                Your Fitness Journey Starts Here
            </div>

            <h1 class="hero-title">
                <span class="line">TRANSFORM YOUR</span>
                <span class="line accent">BODY</span>
            </h1>

            <p class="hero-subtitle">
                Where dedication meets results. Join our community of fitness enthusiasts
                and unlock your true potential with world-class equipment and expert guidance.
            </p>

            <div class="hero-cta">
                <a href="../public/register.php" class="btn btn-primary btn-lg">
                    Start Your Journey
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#facilities" class="btn btn-secondary btn-lg">
                    <i class="fas fa-play"></i>
                    Explore Gym
                </a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-number">50+</div>
                    <div class="hero-stat-label">Equipment</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">12</div>
                    <div class="hero-stat-label">Pro Trainers</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">24/7</div>
                    <div class="hero-stat-label">Access</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">500+</div>
                    <div class="hero-stat-label">Members</div>
                </div>
            </div>
        </div>

        <div class="hero-scroll">
            <a href="#about" class="scroll-indicator">
                <div class="scroll-mouse"></div>
                <span>Scroll</span>
            </a>
        </div>
    </section>

    <!-- ===== ABOUT ===== -->
    <section class="section about" id="about">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Why Choose Us</span>
                <h2 class="section-title">Built for <span class="text-gradient">Champions</span></h2>
                <p class="section-subtitle">
                    More than just a gym — we're a sanctuary for transformation where every rep counts
                    and every goal is within reach.
                </p>
            </div>

            <div class="about-grid">
                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h3>Premium Equipment</h3>
                    <p>State-of-the-art machines and free weights from top global brands.</p>
                </div>

                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>24/7 Access</h3>
                    <p>Train on your schedule. Our doors never close for dedicated members.</p>
                </div>

                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3>Expert Trainers</h3>
                    <p>Certified professionals ready to guide and motivate your journey.</p>
                </div>

                <div class="about-card">
                    <div class="about-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3>Community</h3>
                    <p>Join a supportive family of fitness enthusiasts who push each other.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FACILITIES ===== -->
    <section class="section facilities" id="facilities">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Space</span>
                <h2 class="section-title">World-Class <span class="text-gradient">Facilities</span></h2>
                <p class="section-subtitle">
                    Step into a training environment designed for peak performance.
                </p>
            </div>

            <div class="facilities-grid">
                <div class="facility-card">
                    <img src="../../assets/images/gym-main.jpg" alt="Main Gym Floor" class="facility-img">
                    <div class="facility-overlay">
                        <div class="facility-content">
                            <h3>Main Gym Floor</h3>
                            <p>2,000 sq ft of premium training space with comprehensive equipment</p>
                        </div>
                    </div>
                    <span class="facility-badge badge badge-gold">Featured</span>
                </div>

                <div class="facility-card">
                    <img src="../../assets/images/cardio-zone.jpg" alt="Cardio Zone" class="facility-img">
                    <div class="facility-overlay">
                        <div class="facility-content">
                            <h3>Cardio Zone</h3>
                            <p>Treadmills, bikes, rowing machines & more</p>
                        </div>
                    </div>
                </div>

                <div class="facility-card">
                    <img src="../../assets/images/weights-area.jpg" alt="Free Weights" class="facility-img">
                    <div class="facility-overlay">
                        <div class="facility-content">
                            <h3>Free Weights</h3>
                            <p>Full range of dumbbells, barbells & racks</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRICING ===== -->
    <section class="section pricing" id="pricing">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Membership</span>
                <h2 class="section-title">Simple <span class="text-gradient">Pricing</span></h2>
                <p class="section-subtitle">
                    No hidden fees. No long-term contracts. Just pure fitness at your fingertips.
                </p>
            </div>

            <div class="pricing-grid" style="grid-template-columns: repeat(3, 1fr); max-width: 1200px;">
                <!-- Daily Pass -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <span class="pricing-tag">Flexible</span>
                        <h3 class="pricing-title">Daily Pass</h3>
                        <p class="pricing-desc">Perfect for visitors or trying us out</p>
                        <div class="pricing-price">
                            <span class="currency">₱</span>
                            <span class="amount">60</span>
                            <span class="period">/ day</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Full gym access</li>
                        <li><i class="fas fa-check"></i> All equipment available</li>
                        <li><i class="fas fa-check"></i> Free WiFi & drinking water</li>
                        <li><i class="fas fa-check"></i> No commitment</li>
                    </ul>
                    <a href="../public/register.php" class="btn btn-secondary btn-block">Get Started</a>
                </div>

                <!-- Monthly -->
                <div class="pricing-card featured">
                    <div class="pricing-ribbon">Most Popular</div>
                    <div class="pricing-header">
                        <span class="pricing-tag">Best Value</span>
                        <h3 class="pricing-title">Monthly</h3>
                        <p class="pricing-desc">Unlimited access all month long</p>
                        <div class="pricing-price">
                            <span class="currency">₱</span>
                            <span class="amount">800</span>
                            <span class="period">/ month</span>
                        </div>
                        <div class="pricing-promo">
                            <span class="original">₱1,000</span>
                            <span class="label">Promo Rate!</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Unlimited gym access</li>
                        <li><i class="fas fa-check"></i> Free WiFi & drinking water</li>
                        <li><i class="fas fa-check"></i> Free parking</li>
                        <li><i class="fas fa-check"></i> Students: ₱600 | Seniors: ₱500</li>
                    </ul>
                    <a href="../public/register.php" class="btn btn-primary btn-block">
                        Get Started <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Personal Instructor -->
                <div class="pricing-card">
                    <div class="pricing-header">
                        <span class="pricing-tag">Personal</span>
                        <h3 class="pricing-title">Instructor</h3>
                        <p class="pricing-desc">One-on-one personal training</p>
                        <div class="pricing-price">
                            <span class="currency">₱</span>
                            <span class="amount">1,250</span>
                            <span class="period">/ month</span>
                        </div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> Personal trainer guidance</li>
                        <li><i class="fas fa-check"></i> Customized workout plan</li>
                        <li><i class="fas fa-check"></i> Form correction</li>
                        <li><i class="fas fa-check"></i> Progress tracking</li>
                    </ul>
                    <a href="../public/register.php" class="btn btn-secondary btn-block">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta" id="contact">
        <div class="cta-bg">
            <img src="../../assets/images/cta-bg.jpg" alt="Gym Background">
        </div>
        <div class="cta-overlay"></div>
        <div class="cta-orb"></div>

        <div class="cta-content">
            <h2 class="cta-title">Ready to <span class="text-gradient">Transform</span>?</h2>
            <p class="cta-subtitle">
                Join the Magilas family today and take the first step towards the
                best version of yourself. Your journey starts here.
            </p>
            <a href="../public/register.php" class="btn btn-primary btn-lg">
                Get Started Today
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="../../assets/images/logo.png" alt="Magilas Gym">
                    <span class="footer-logo-text">MAGILAS <span>GYM</span></span>
                </div>
                <p class="footer-desc">
                    Premium fitness facility dedicated to helping you achieve your goals.
                    Located in San Luis, Pampanga.
                </p>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Quick Links</h4>
                <div class="footer-links">
                    <a href="#about">About Us</a>
                    <a href="#facilities">Facilities</a>
                    <a href="#pricing">Pricing</a>
                    <a href="../public/register.php">Register</a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Hours</h4>
                <div class="footer-links">
                    <a href="#">Open 24/7</a>
                    <a href="#">Staff: 6AM - 10PM</a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Contact</h4>
                <div class="footer-links">
                    <a href="#">San Luis, Pampanga</a>
                    <a href="#">+63 912 345 6789</a>
                    <a href="#">info@magilasgym.com</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; 2026 Magilas Gym. All rights reserved.
            </p>
            <div class="footer-socials">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script>
        // Preloader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('preloader').classList.add('hidden');
            }, 1200);
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 80) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const navToggle = document.getElementById('navToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        navToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close mobile menu on link click
        document.querySelectorAll('.mobile-menu-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe cards for animation
        document.querySelectorAll('.about-card, .facility-card, .pricing-card').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${index * 0.1}s`;
            observer.observe(el);
        });
    </script>
</body>

</html>