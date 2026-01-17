<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover QR | Magilas Gym</title>
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
    <div class="auth-page">
        <a href="landing.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="auth-container animate-slide-up">
            <div class="auth-card">
                <header class="auth-header">
                    <div class="auth-logo" style="font-size: 3rem; color: var(--color-accent);">🔑</div>
                    <h1 class="auth-title">Recover <span class="text-accent">QR Code</span></h1>
                    <p class="auth-subtitle">Lost your code? We'll send it to your email.</p>
                </header>

                <form class="auth-form" id="recoverForm" novalidate>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="Enter your registered email" required autocomplete="email">
                        <span class="form-error" id="emailError"></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="submitBtn">
                        <span>📧</span> Send Recovery Link
                    </button>
                </form>

                <!-- Success State (Hidden by default) -->
                <div id="recoverSuccess" class="hidden">
                    <div style="color: var(--color-success); font-size: 3rem; margin: var(--space-4) 0;"><i
                            class="fas fa-check-circle"></i></div>
                    <h3>Check your inbox!</h3>
                    <p class="text-muted">We've sent the recovery link to your email.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">SENDING...</div>
    </div>

    <script>
        document.getElementById('recoverForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const error = document.getElementById('emailError');
            const overlay = document.getElementById('loadingOverlay');

            if (!email.includes('@')) {
                error.textContent = 'Please enter a valid email address';
                return;
            }

            error.textContent = '';
            overlay.classList.add('active');

            setTimeout(() => {
                overlay.classList.remove('active');
                this.classList.add('hidden');
                document.getElementById('recoverSuccess').classList.remove('hidden');
                document.getElementById('recoverSuccess').classList.add('animate-fade-in');
            }, 1000);
        });
    </script>
</body>

</html>