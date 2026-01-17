<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Magilas Gym - Transform Your Body, Elevate Your Life. Premium fitness facility in San Luis, Pampanga with affordable rates and professional equipment.">
    <meta name="keywords" content="gym, fitness, workout, Magilas Gym, San Luis, Pampanga, membership">
    <title>Magilas Gym | Transform Your Body, Elevate Your Life</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/components.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../assets/images/logo.png">

    <style>
        /* ===== PRELOADER ===== */
        #preloader {
            position: fixed;
            inset: 0;
            background: var(--color-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        #preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader {
            text-align: center;
        }

        .loader-logo {
            width: 120px;
            height: auto;
            margin-bottom: var(--space-6);
            animation: pulse-glow 1.5s ease-in-out infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                filter: drop-shadow(0 0 10px var(--color-accent-glow));
            }

            50% {
                filter: drop-shadow(0 0 30px var(--color-accent-glow));
            }
        }

        .loader-text {
            font-family: var(--font-display);
            font-size: var(--text-3xl);
            color: var(--color-accent);
            letter-spacing: 0.3em;
            margin-bottom: var(--space-4);
        }

        .loader-bar {
            width: 200px;
            height: 3px;
            background: var(--color-surface);
            border-radius: 2px;
            overflow: hidden;
            margin: 0 auto;
        }

        .loader-bar::after {
            content: '';
            display: block;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, var(--color-accent), var(--color-accent-hover));
            animation: loading 1s ease-in-out infinite;
        }

        @keyframes loading {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(300%);
            }
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: var(--space-4) 0;
            transition: all var(--transition-base);
        }

        .navbar.scrolled {
            background: rgba(13, 13, 13, 0.95);
            backdrop-filter: blur(20px);
            padding: var(--space-3) 0;
            box-shadow: var(--shadow-lg);
        }

        .nav-container {
            max-width: var(--container-xl);
            margin: 0 auto;
            padding: 0 var(--space-4);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            text-decoration: none;
        }

        .nav-logo img {
            height: 40px;
            width: auto;
        }

        .nav-logo-text {
            font-family: var(--font-display);
            font-size: var(--text-2xl);
            color: var(--color-text);
            letter-spacing: 0.1em;
        }

        .nav-menu {
            display: none;
            gap: var(--space-6);
        }

        .nav-link {
            font-size: var(--text-sm);
            font-weight: var(--font-medium);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-text-muted);
            text-decoration: none;
            position: relative;
            padding: var(--space-2) 0;
            transition: color var(--transition-fast);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--color-accent);
            transition: width var(--transition-base);
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--color-text);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .nav-toggle {
            display: flex;
            width: 32px;
            height: 24px;
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
        }

        .hamburger {
            position: absolute;
            width: 100%;
            height: 2px;
            background: var(--color-text);
            top: 50%;
            transform: translateY(-50%);
            transition: all var(--transition-fast);
        }

        .hamburger::before,
        .hamburger::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: var(--color-text);
            transition: all var(--transition-fast);
        }

        .hamburger::before {
            top: -8px;
        }

        .hamburger::after {
            top: 8px;
        }

        .nav-toggle.active .hamburger {
            background: transparent;
        }

        .nav-toggle.active .hamburger::before {
            top: 0;
            transform: rotate(45deg);
        }

        .nav-toggle.active .hamburger::after {
            top: 0;
            transform: rotate(-45deg);
        }

        @media (min-width: 768px) {
            .nav-menu {
                display: flex;
            }

            .nav-toggle {
                display: none;
            }
        }

        /* ===== MOBILE MENU ===== */
        .mobile-menu {
            position: fixed;
            inset: 0;
            background: var(--color-bg);
            z-index: 999;
            padding: var(--space-20) var(--space-6);
            transform: translateX(100%);
            transition: transform var(--transition-base);
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        .mobile-menu-links {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .mobile-menu-link {
            font-family: var(--font-display);
            font-size: var(--text-3xl);
            color: var(--color-text);
            text-decoration: none;
            padding: var(--space-3) 0;
            border-bottom: 1px solid var(--color-border);
            transition: color var(--transition-fast);
        }

        .mobile-menu-link:hover {
            color: var(--color-accent);
        }

        /* ===== HERO SECTION ===== */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('../../assets/images/hero-bg.jpg') center/cover no-repeat;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(10, 10, 10, 0.7) 0%,
                    rgba(10, 10, 10, 0.85) 50%,
                    rgba(10, 10, 10, 0.95) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: var(--space-20) var(--space-4);
            max-width: 900px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            background: rgba(212, 175, 0, 0.15);
            border: 1px solid var(--color-accent);
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-full);
            font-size: var(--text-sm);
            color: var(--color-accent);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: var(--space-6);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(3rem, 10vw, 6rem);
            line-height: 1;
            margin-bottom: var(--space-6);
        }

        .title-line {
            display: block;
            color: var(--color-text);
        }

        .title-accent {
            color: var(--color-accent);
            text-shadow: 0 0 40px var(--color-accent-glow);
        }

        .hero-subtitle {
            font-size: var(--text-lg);
            color: var(--color-text-muted);
            max-width: 600px;
            margin: 0 auto var(--space-8);
            line-height: 1.7;
        }

        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-4);
            justify-content: center;
            margin-bottom: var(--space-12);
        }

        .btn i {
            transition: transform var(--transition-fast);
        }

        .btn:hover i {
            transform: translateX(4px);
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: var(--space-8);
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-family: var(--font-display);
            font-size: var(--text-5xl);
            color: var(--color-accent);
            line-height: 1;
        }

        .stat-label {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .stat-divider {
            width: 1px;
            height: 40px;
            background: var(--color-border);
        }

        .hero-scroll {
            position: absolute;
            bottom: var(--space-8);
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .scroll-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-2);
            color: var(--color-text-muted);
            font-size: var(--text-xs);
            text-transform: uppercase;
            letter-spacing: 0.2em;
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .scroll-indicator:hover {
            color: var(--color-accent);
        }

        .scroll-icon {
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(8px);
            }
        }

        /* ===== SECTION STYLES ===== */
        .section {
            padding: var(--space-20) var(--space-4);
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto var(--space-12);
        }

        .section-tag {
            display: inline-block;
            font-size: var(--text-sm);
            font-weight: var(--font-semibold);
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--color-accent);
            margin-bottom: var(--space-3);
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: var(--color-text);
            margin-bottom: var(--space-4);
        }

        .section-subtitle {
            font-size: var(--text-base);
            color: var(--color-text-muted);
            line-height: 1.7;
        }

        /* ===== ABOUT SECTION ===== */
        .about {
            background: linear-gradient(180deg, var(--color-bg) 0%, var(--color-surface) 100%);
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-6);
            max-width: var(--container-xl);
            margin: 0 auto;
        }

        .about-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: var(--space-8);
            text-align: center;
            transition: all var(--transition-base);
        }

        .about-card:hover {
            transform: translateY(-8px);
            border-color: var(--color-accent);
            box-shadow: 0 4px 20px var(--color-accent-glow);
        }

        .about-icon {
            width: 70px;
            height: 70px;
            background: rgba(212, 175, 0, 0.1);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-4);
            font-size: var(--text-2xl);
            color: var(--color-accent);
            transition: all var(--transition-base);
        }

        .about-card:hover .about-icon {
            background: var(--color-accent);
            color: var(--color-bg);
            transform: scale(1.1);
        }

        .about-card h3 {
            font-size: var(--text-xl);
            font-weight: var(--font-semibold);
            margin-bottom: var(--space-2);
        }

        .about-card p {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            margin: 0;
        }

        /* ===== FACILITIES SECTION ===== */
        .facilities {
            background: var(--color-bg);
        }

        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 250px);
            gap: var(--space-4);
            max-width: var(--container-xl);
            margin: 0 auto;
        }

        .facility-card {
            position: relative;
            border-radius: var(--radius-xl);
            overflow: hidden;
        }

        .facility-large {
            grid-row: span 2;
        }

        .facility-image {
            width: 100%;
            height: 100%;
        }

        .facility-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-slow);
        }

        .facility-card:hover .facility-image img {
            transform: scale(1.1);
        }

        .facility-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(10, 10, 10, 0.95) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: var(--space-6);
            transition: all var(--transition-base);
        }

        .facility-card:hover .facility-overlay {
            background: linear-gradient(180deg, transparent 20%, rgba(212, 175, 0, 0.2) 100%);
        }

        .facility-overlay h3 {
            font-size: var(--text-xl);
            color: var(--color-text);
            margin-bottom: var(--space-1);
        }

        .facility-overlay p {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            margin: 0;
        }

        @media (max-width: 768px) {
            .facilities-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .facility-large {
                grid-row: auto;
            }

            .facility-card {
                height: 250px;
            }
        }

        /* ===== PRICING SECTION ===== */
        .pricing {
            background: linear-gradient(180deg, var(--color-bg) 0%, var(--color-surface) 100%);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-6);
            max-width: 1000px;
            margin: 0 auto;
            align-items: start;
        }

        .pricing-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: var(--space-8);
            text-align: center;
            transition: all var(--transition-base);
            position: relative;
            overflow: hidden;
        }

        .pricing-card:hover {
            transform: translateY(-8px);
            border-color: var(--color-accent);
            box-shadow: 0 8px 30px var(--color-accent-glow);
        }

        .pricing-featured {
            border-color: var(--color-accent);
            transform: scale(1.02);
            box-shadow: 0 4px 20px var(--color-accent-glow);
        }

        .pricing-ribbon {
            position: absolute;
            top: 20px;
            right: -35px;
            background: var(--color-accent);
            color: var(--color-bg);
            font-size: var(--text-xs);
            font-weight: var(--font-bold);
            text-transform: uppercase;
            padding: var(--space-1) var(--space-10);
            transform: rotate(45deg);
        }

        .pricing-badge {
            display: inline-block;
            font-size: var(--text-xs);
            font-weight: var(--font-semibold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--color-accent);
            margin-bottom: var(--space-3);
        }

        .pricing-title {
            font-family: var(--font-display);
            font-size: var(--text-3xl);
            margin-bottom: var(--space-2);
        }

        .pricing-desc {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            margin-bottom: var(--space-6);
        }

        .pricing-price {
            margin-bottom: var(--space-6);
        }

        .pricing-price .currency {
            font-size: var(--text-xl);
            color: var(--color-text-muted);
            vertical-align: top;
        }

        .pricing-price .amount {
            font-family: var(--font-display);
            font-size: var(--text-5xl);
            color: var(--color-accent);
        }

        .pricing-price .period {
            font-size: var(--text-base);
            color: var(--color-text-muted);
        }

        .pricing-discount {
            font-size: var(--text-sm);
            color: var(--color-success);
            margin-bottom: var(--space-4);
        }

        .pricing-discount s {
            color: var(--color-text-muted);
            margin-right: var(--space-2);
        }

        .pricing-features {
            text-align: left;
            margin-bottom: var(--space-6);
        }

        .pricing-features li {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-2) 0;
            font-size: var(--text-sm);
            color: var(--color-text-secondary);
        }

        .pricing-features li i {
            color: var(--color-success);
        }

        /* ===== CTA SECTION ===== */
        .cta {
            position: relative;
            padding: var(--space-20) var(--space-4);
            overflow: hidden;
        }

        .cta-bg {
            position: absolute;
            inset: 0;
            background: url('../../assets/images/cta-bg.jpg') center/cover no-repeat;
        }

        .cta-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.9) 0%, rgba(212, 175, 0, 0.2) 100%);
        }

        .cta-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: var(--space-4);
        }

        .cta-subtitle {
            font-size: var(--text-lg);
            color: var(--color-text-secondary);
            margin-bottom: var(--space-8);
        }

        .cta-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-4);
            justify-content: center;
        }

        /* ===== CONTACT SECTION ===== */
        .contact {
            background: var(--color-surface);
        }

        .contact-grid {
            display: grid;
            gap: var(--space-10);
            max-width: var(--container-lg);
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-6);
        }

        .contact-card {
            display: flex;
            gap: var(--space-4);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(212, 175, 0, 0.1);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-xl);
            color: var(--color-accent);
            flex-shrink: 0;
        }

        .contact-details h4 {
            font-size: var(--text-base);
            font-weight: var(--font-semibold);
            margin-bottom: var(--space-1);
        }

        .contact-details p {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            margin: 0;
        }

        .contact-social h4 {
            font-size: var(--text-base);
            font-weight: var(--font-semibold);
            margin-bottom: var(--space-4);
        }

        .social-links {
            display: flex;
            gap: var(--space-3);
        }

        .social-link {
            width: 44px;
            height: 44px;
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-lg);
            color: var(--color-text);
            text-decoration: none;
            transition: all var(--transition-fast);
        }

        .social-link:hover {
            background: var(--color-accent);
            border-color: var(--color-accent);
            color: var(--color-bg);
        }

        .contact-form {
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: var(--space-8);
        }

        .contact-form .form-group {
            margin-bottom: var(--space-4);
        }

        .contact-form label {
            display: block;
            font-size: var(--text-sm);
            font-weight: var(--font-medium);
            margin-bottom: var(--space-2);
            color: var(--color-text-secondary);
        }

        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            color: var(--color-text);
            font-size: var(--text-base);
            transition: border-color var(--transition-fast);
        }

        .contact-form input:focus,
        .contact-form select:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--color-accent);
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--color-bg);
            border-top: 1px solid var(--color-border);
            padding: var(--space-12) var(--space-4);
        }

        .footer-content {
            max-width: var(--container-xl);
            margin: 0 auto;
            display: grid;
            gap: var(--space-8);
        }

        @media (min-width: 768px) {
            .footer-content {
                grid-template-columns: 2fr 1fr 1fr;
            }
        }

        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }

        .footer-brand-logo img {
            height: 50px;
            width: auto;
        }

        .footer-brand-logo span {
            font-family: var(--font-display);
            font-size: var(--text-2xl);
            color: var(--color-text);
            letter-spacing: 0.1em;
        }

        .footer-tagline {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            font-style: italic;
        }

        .footer-section h4 {
            font-size: var(--text-sm);
            font-weight: var(--font-semibold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--color-text);
            margin-bottom: var(--space-4);
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .footer-link {
            font-size: var(--text-sm);
            color: var(--color-text-muted);
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .footer-link:hover {
            color: var(--color-accent);
        }

        .footer-bottom {
            max-width: var(--container-xl);
            margin: var(--space-8) auto 0;
            padding-top: var(--space-8);
            border-top: 1px solid var(--color-border);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: var(--space-4);
            font-size: var(--text-sm);
            color: var(--color-text-muted);
        }

        .payment-methods {
            display: flex;
            gap: var(--space-3);
            align-items: center;
        }

        .payment-methods span {
            padding: var(--space-1) var(--space-3);
            background: var(--color-surface);
            border-radius: var(--radius-sm);
            font-size: var(--text-xs);
        }

        /* ===== BACK TO TOP ===== */
        .back-to-top {
            position: fixed;
            bottom: var(--space-6);
            right: var(--space-6);
            width: 48px;
            height: 48px;
            background: var(--color-accent);
            color: var(--color-bg);
            border: none;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-xl);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-base);
            z-index: 100;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 20px var(--color-accent-glow);
        }

        /* ===== ANIMATIONS ===== */
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
        }

        .animate-slide-up {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.8s ease forwards;
        }

        .animate-delay-1 {
            animation-delay: 0.2s;
        }

        .animate-delay-2 {
            animation-delay: 0.4s;
        }

        .animate-delay-3 {
            animation-delay: 0.6s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <img src="../../assets/images/logo.png" alt="Magilas Gym" class="loader-logo">
            <span class="loader-text">MAGILAS GYM</span>
            <div class="loader-bar"></div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <img src="../../assets/images/logo.png" alt="Magilas Gym">
                <span class="nav-logo-text">MAGILAS</span>
            </a>

            <ul class="nav-menu" id="nav-menu">
                <li><a href="#home" class="nav-link active">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#facilities" class="nav-link">Facilities</a></li>
                <li><a href="#pricing" class="nav-link">Pricing</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>

            <div class="nav-actions">
                <a href="register.php" class="btn btn-primary">Join Now</a>
                <button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation">
                    <span class="hamburger"></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-links">
            <a href="#home" class="mobile-menu-link">Home</a>
            <a href="#about" class="mobile-menu-link">About</a>
            <a href="#facilities" class="mobile-menu-link">Facilities</a>
            <a href="#pricing" class="mobile-menu-link">Pricing</a>
            <a href="#contact" class="mobile-menu-link">Contact</a>
            <a href="register.php" class="btn btn-primary btn-block" style="margin-top: var(--space-6);">Join Now</a>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <div class="hero-badge animate-fade-in">
                <i class="fas fa-fire"></i>
                <span>Promo Rates Still Available!</span>
            </div>

            <h1 class="hero-title animate-slide-up">
                <span class="title-line">TRANSFORM</span>
                <span class="title-line title-accent">YOUR BODY</span>
                <span class="title-line">ELEVATE YOUR <span class="title-accent">LIFE</span></span>
            </h1>

            <p class="hero-subtitle animate-fade-in animate-delay-1">
                Start your year right and get back on track! Take the first step toward your transformation today at
                Magilas Gym, San Luis, Pampanga.
            </p>

            <div class="hero-cta animate-fade-in animate-delay-2">
                <a href="register.php" class="btn btn-primary btn-lg">
                    <span>Start Your Journey</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#pricing" class="btn btn-secondary btn-lg">
                    <span>View Plans</span>
                </a>
            </div>

            <div class="hero-stats animate-fade-in animate-delay-3">
                <div class="stat-item">
                    <span class="stat-number" data-count="500">0</span>+
                    <span class="stat-label">Active Members</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number" data-count="50">0</span>+
                    <span class="stat-label">Equipment</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number">17.5</span>hrs
                    <span class="stat-label">Daily Open</span>
                </div>
            </div>
        </div>

        <div class="hero-scroll">
            <a href="#about" class="scroll-indicator">
                <span>Scroll Down</span>
                <div class="scroll-icon">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about" id="about">
        <div class="section-header">
            <span class="section-tag">About Us</span>
            <h2 class="section-title">Why Choose <span class="title-accent">Magilas Gym</span>?</h2>
            <p class="section-subtitle">More than just a gym — we're a community dedicated to helping you achieve your
                fitness goals.</p>
        </div>

        <div class="about-grid">
            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h3>Heavy Equipment</h3>
                <p>High-grade heavy equipment for serious lifters and beginners alike.</p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Free Coaching</h3>
                <p>Free assessment and coaching with our Fitness Instructor (2 sessions included).</p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h3>Instagrammable</h3>
                <p>Clean, modern environment perfect for your transformation photos.</p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>17.5 Hours Open</h3>
                <p>Open 6:00 AM to 11:30 PM daily, Monday to Sunday.</p>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="section facilities" id="facilities">
        <div class="section-header">
            <span class="section-tag">Our Space</span>
            <h2 class="section-title">Premium <span class="title-accent">Facilities</span></h2>
            <p class="section-subtitle">Experience top-tier equipment in a clean, motivating environment.</p>
        </div>

        <div class="facilities-grid">
            <div class="facility-card facility-large">
                <div class="facility-image">
                    <img src="../../assets/images/gym-main.jpg" alt="Main Gym Floor" loading="lazy">
                </div>
                <div class="facility-overlay">
                    <h3>Main Training Floor</h3>
                    <p>Spacious area with complete free weights and machines</p>
                </div>
            </div>

            <div class="facility-card">
                <div class="facility-image">
                    <img src="../../assets/images/cardio-zone.jpg" alt="Cardio Zone" loading="lazy">
                </div>
                <div class="facility-overlay">
                    <h3>Cardio Zone</h3>
                    <p>Treadmills, bikes, and more</p>
                </div>
            </div>

            <div class="facility-card">
                <div class="facility-image">
                    <img src="../../assets/images/weights-area.jpg" alt="Free Weights Area" loading="lazy">
                </div>
                <div class="facility-overlay">
                    <h3>Free Weights</h3>
                    <p>Dumbbells, barbells, racks</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="section pricing" id="pricing">
        <div class="section-header">
            <span class="section-tag">Membership Plans</span>
            <h2 class="section-title">Affordable <span class="title-accent">Pricing</span></h2>
            <p class="section-subtitle">Choose the plan that fits your lifestyle. Special discounts for students and
                seniors!</p>
        </div>

        <div class="pricing-grid">
            <!-- Daily Pass -->
            <div class="pricing-card">
                <span class="pricing-badge">Flexible</span>
                <h3 class="pricing-title">Daily Pass</h3>
                <p class="pricing-desc">Perfect for visitors or trying us out</p>
                <div class="pricing-price">
                    <span class="currency">₱</span>
                    <span class="amount">60</span>
                    <span class="period">/day</span>
                </div>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Full gym access</li>
                    <li><i class="fas fa-check"></i> All equipment available</li>
                    <li><i class="fas fa-check"></i> Free WiFi & drinking water</li>
                    <li><i class="fas fa-check"></i> No commitment</li>
                </ul>
                <a href="register.php" class="btn btn-secondary btn-block">Get Started</a>
            </div>

            <!-- Monthly - Featured -->
            <div class="pricing-card pricing-featured">
                <div class="pricing-ribbon">Most Popular</div>
                <span class="pricing-badge">Best Value</span>
                <h3 class="pricing-title">Monthly</h3>
                <p class="pricing-desc">Unlimited access all month long</p>
                <div class="pricing-price">
                    <span class="currency">₱</span>
                    <span class="amount">800</span>
                    <span class="period">/month</span>
                </div>
                <div class="pricing-discount">
                    <s>₱1,000</s> Promo Rate!
                </div>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Unlimited gym access</li>
                    <li><i class="fas fa-check"></i> 2 free coaching sessions</li>
                    <li><i class="fas fa-check"></i> Free WiFi & drinking water</li>
                    <li><i class="fas fa-check"></i> Free parking</li>
                    <li><i class="fas fa-check"></i> Students: ₱600 | Seniors: ₱500</li>
                </ul>
                <a href="register.php" class="btn btn-primary btn-block">Get Started</a>
            </div>

            <!-- Personal Training -->
            <div class="pricing-card">
                <span class="pricing-badge">Personal</span>
                <h3 class="pricing-title">Instructor</h3>
                <p class="pricing-desc">One-on-one personal training</p>
                <div class="pricing-price">
                    <span class="currency">₱</span>
                    <span class="amount">1,250</span>
                    <span class="period">/month</span>
                </div>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Personal trainer guidance</li>
                    <li><i class="fas fa-check"></i> Customized workout plan</li>
                    <li><i class="fas fa-check"></i> Form correction</li>
                    <li><i class="fas fa-check"></i> Progress tracking</li>
                </ul>
                <a href="register.php" class="btn btn-secondary btn-block">Get Started</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-bg"></div>
        <div class="cta-overlay"></div>
        <div class="cta-content">
            <h2 class="cta-title">Ready to Start Your <span class="title-accent">Transformation</span>?</h2>
            <p class="cta-subtitle">Don't miss this chance — promo rates are still available! Join Magilas Gym today.
            </p>
            <div class="cta-buttons">
                <a href="register.php" class="btn btn-primary btn-lg">
                    <span>Join Now</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#contact" class="btn btn-secondary btn-lg">
                    <span>Contact Us</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact" id="contact">
        <div class="section-header">
            <span class="section-tag">Get In Touch</span>
            <h2 class="section-title">Visit <span class="title-accent">Us</span></h2>
            <p class="section-subtitle">Have questions? We're here to help you start your fitness journey.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Location</h4>
                        <p>Hzon Travellers Building<br>Sto. Tomas, San Luis, Pampanga</p>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Hours</h4>
                        <p>Monday - Sunday<br>6:00 AM - 11:30 PM</p>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Payment Options</h4>
                        <p>Cash, GCash, Bank Transfer</p>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Find Us</h4>
                        <p>Search "Magilas GYM" on<br>Waze or Google Maps</p>
                    </div>
                </div>

                <div class="contact-social">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="https://facebook.com/magilasgym" target="_blank" class="social-link"
                            aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://instagram.com/magilasgym" target="_blank" class="social-link"
                            aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>

            <form class="contact-form" id="contact-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Juan Dela Cruz" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="juan@email.com" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="09XX XXX XXXX">
                </div>
                <div class="form-group">
                    <label for="interest">I'm interested in</label>
                    <select id="interest" name="interest">
                        <option value="">Select an option</option>
                        <option value="daily">Daily Pass</option>
                        <option value="monthly">Monthly Membership</option>
                        <option value="student">Student Discount</option>
                        <option value="senior">Senior Citizen Discount</option>
                        <option value="instructor">Personal Training</option>
                        <option value="inquiry">General Inquiry</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="4"
                        placeholder="Tell us about your fitness goals..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <span>Send Message</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-brand-logo">
                    <img src="../../assets/images/logo.png" alt="Magilas Gym">
                    <span>MAGILAS GYM</span>
                </div>
                <p class="footer-tagline">Transform Your Body, Elevate Your Life</p>
            </div>

            <div class="footer-section">
                <h4>Quick Links</h4>
                <div class="footer-links">
                    <a href="#home" class="footer-link">Home</a>
                    <a href="#about" class="footer-link">About</a>
                    <a href="#facilities" class="footer-link">Facilities</a>
                    <a href="#pricing" class="footer-link">Pricing</a>
                    <a href="#contact" class="footer-link">Contact</a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Membership</h4>
                <div class="footer-links">
                    <a href="register.php" class="footer-link">Pre-Register</a>
                    <a href="recover.php" class="footer-link">Recover QR</a>
                    <a href="../auth/login.php" class="footer-link">Staff Login</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 Magilas Gym. All rights reserved.</p>
            <div class="payment-methods">
                <span>Cash</span>
                <span>GCash</span>
                <span>Bank Transfer</span>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="back-to-top" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript -->
    <script>
        // Preloader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('preloader').classList.add('hidden');
            }, 1500);
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const navToggle = document.getElementById('nav-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        navToggle.addEventListener('click', () => {
            navToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close mobile menu on link click
        document.querySelectorAll('.mobile-menu-link').forEach(link => {
            link.addEventListener('click', () => {
                navToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // Active nav link on scroll
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // Animated counter for stats
        const animateCounters = () => {
            const counters = document.querySelectorAll('.stat-number[data-count]');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-count');
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                updateCounter();
            });
        };

        // Trigger counter animation when hero is in view
        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(animateCounters, 1000);
                    heroObserver.disconnect();
                }
            });
        }, { threshold: 0.5 });

        heroObserver.observe(document.querySelector('.hero'));

        // Back to top button
        const backToTop = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
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

        // Form submission
        document.getElementById('contact-form').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Thank you for your message! We will get back to you soon.');
            this.reset();
        });
    </script>
</body>

</html>