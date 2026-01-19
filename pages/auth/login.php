<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login | Magilas Gym</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../assets/images/logo.png">
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Authenticating</div>
    </div>

    <!-- Background Orbs -->
    <div class="auth-orb auth-orb-1"></div>
    <div class="auth-orb auth-orb-2"></div>

    <div class="auth-page">
        <!-- Branding Panel -->
        <div class="auth-branding">
            <div class="auth-branding-bg">
                <img src="../../assets/images/hero-bg.jpg" alt="Gym Background">
            </div>
            <div class="auth-branding-overlay"></div>

            <div class="auth-branding-content">
                <img src="../../assets/images/logo.png" alt="Magilas Gym" class="auth-branding-logo">
                <h1 class="auth-branding-title">
                    MAGILAS <span>GYM</span>
                </h1>
                <p class="auth-branding-subtitle">
                    Access the staff portal to manage memberships, track attendance,
                    and keep the gym running at peak performance.
                </p>

                <div class="auth-branding-features">
                    <div class="auth-branding-feature">
                        <i class="fas fa-qrcode"></i>
                        <span>Scan member QR codes for instant check-in</span>
                    </div>
                    <div class="auth-branding-feature">
                        <i class="fas fa-users"></i>
                        <span>Real-time gym occupancy monitoring</span>
                    </div>
                    <div class="auth-branding-feature">
                        <i class="fas fa-chart-line"></i>
                        <span>Track daily revenue and expenses</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="auth-form-panel">
            <div class="auth-container">
                <div class="auth-card">
                    <header class="auth-header">
                        <img src="../../assets/images/logo.png" alt="Magilas Gym" class="auth-logo-mobile">
                        <h2 class="auth-title">Staff <span>Portal</span></h2>
                        <p class="auth-subtitle">Authorized personnel only</p>
                    </header>

                    <form class="auth-form" id="loginForm" novalidate>
                        <!-- Username -->
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-wrapper">
                                <input type="text" id="username" name="username" class="form-input"
                                    placeholder="Enter your username" required autocomplete="username">
                                <i class="fas fa-user input-icon"></i>
                            </div>
                            <span class="form-error" id="usernameError"></span>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-wrapper">
                                <input type="password" id="password" name="password" class="form-input"
                                    placeholder="Enter your password" required autocomplete="current-password">
                                <i class="fas fa-lock input-icon"></i>
                                <button type="button" class="input-toggle" id="togglePassword"
                                    aria-label="Toggle password visibility">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <span class="form-error" id="passwordError"></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Sign In
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>

                    <div class="auth-footer">
                        <p>Forgot password? <a href="#">Contact Admin</a></p>
                        <a href="../public/landing.php" class="auth-back-link">
                            <i class="fas fa-arrow-left"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('loginForm');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            // Toggle password visibility
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                togglePassword.querySelector('i').classList.toggle('fa-eye');
                togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Form submission
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                // Clear previous errors
                document.querySelectorAll('.form-error').forEach(el => el.textContent = '');

                const username = form.username.value.trim();
                const password = form.password.value.trim();
                let isValid = true;

                if (!username) {
                    document.getElementById('usernameError').textContent = 'Username is required';
                    isValid = false;
                }

                if (!password) {
                    document.getElementById('passwordError').textContent = 'Password is required';
                    isValid = false;
                }

                if (isValid) {
                    loadingOverlay.classList.add('active');

                    // Simulated login - redirect to dashboard
                    setTimeout(() => {
                        window.location.href = '../staff/dashboard.php';
                    }, 1500);
                }
            });

            // Add focus effects
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('focused');
                });
                input.addEventListener('blur', () => {
                    input.parentElement.classList.remove('focused');
                });
            });
        });
    </script>
</body>

</html>