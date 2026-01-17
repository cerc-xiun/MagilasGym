<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login | Magilas Gym</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/auth.css">

    <link rel="icon" type="image/png" href="../../assets/images/logo.png">
</head>

<body>
    <!-- Preloader -->
    <div class="loading-overlay active" id="preloader" style="background: var(--color-bg);">
        <div class="loading-spinner"></div>
        <div class="loading-text">MAGILAS</div>
    </div>

    <!-- Background Overlay -->
    <div class="auth-page">
        <a href="../public/landing.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="auth-container animate-slide-up">
            <div class="auth-card">
                <header class="auth-header">
                    <img src="../../assets/images/logo.png" alt="Magilas Logo" class="auth-logo">
                    <h1 class="auth-title">Staff <span class="text-accent">Portal</span></h1>
                    <p class="auth-subtitle">Authorized personnel only</p>
                </header>

                <form class="auth-form" id="loginForm" novalidate>
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div style="position: relative;">
                            <input type="text" id="username" name="username" class="form-input"
                                placeholder="Enter your username" required autocomplete="username"
                                style="padding-left: 45px;">
                            <i class="fas fa-user"
                                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--color-text-muted);"></i>
                        </div>
                        <span class="form-error" id="usernameError"></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div style="position: relative;">
                            <input type="password" id="password" name="password" class="form-input"
                                placeholder="Enter your password" required autocomplete="current-password"
                                style="padding-left: 45px;">
                            <i class="fas fa-lock"
                                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--color-text-muted);"></i>
                            <button type="button" id="togglePassword"
                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--color-text-muted);">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <span class="form-error" id="passwordError"></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="submitBtn">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>

                    <p class="auth-footer">
                        Forgot password? <a href="#">Contact Admin</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">AUTHENTICATING...</div>
    </div>

    <!-- JavaScript -->
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const preloader = document.getElementById('preloader');
                preloader.style.opacity = '0';
                setTimeout(() => { preloader.style.display = 'none'; }, 500);
            }, 800);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('loginForm');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            // Toggle Password Visibility
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePassword.querySelector('i').classList.toggle('fa-eye');
                togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Form Submission
            form.addEventListener('submit', (e) => {
                e.preventDefault();
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

                    // Simulate Login
                    setTimeout(() => {
                        loadingOverlay.classList.remove('active');
                        // For demo purposes, just reload or alert
                        alert('Login Simulated!');
                    }, 1500);
                }
            });
        });
    </script>
</body>

</html>