<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | Magilas Gym</title>
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
    <div class="result-page">
        <div class="result-card animate-slide-up">

            <!-- Pending State -->
            <div id="pendingState">
                <div class="auth-logo" style="font-size: 4rem; margin-bottom: var(--space-6);">📧</div>
                <h1 class="result-title">Check Your <span class="text-accent">Email</span></h1>
                <p class="result-text" style="line-height: 1.6; margin-bottom: var(--space-6);">
                    We've sent a verification link to your email address. <br>
                    Please click the link to verify your account.
                </p>

                <div class="tip-box">
                    <i class="fas fa-info-circle tip-icon text-accent"></i>
                    <span class="tip-text">
                        Tip: Check your spam or junk folder if you don't see the email within a few minutes.
                    </span>
                </div>

                <!-- Simulation Button -->
                <button class="btn btn-secondary btn-block" onclick="simulateVerification()"
                    style="margin-top: var(--space-8);">
                    (Simulate Click Link)
                </button>
            </div>

            <!-- Success State -->
            <div id="successState" class="hidden">
                <div class="auth-logo"
                    style="font-size: 4rem; color: var(--color-success); margin-bottom: var(--space-6);">
                    <i class="fas fa-check-circle animate-bounce"></i>
                </div>
                <h1 class="result-title">Email <span class="text-success">Verified!</span></h1>
                <p class="result-text" style="margin-bottom: var(--space-6);">
                    Redirecting to your QR code...
                </p>
                <div class="loading-spinner" style="margin: 0 auto;"></div>
            </div>

            <!-- Error State -->
            <div id="errorState" class="hidden">
                <div class="auth-logo"
                    style="font-size: 4rem; color: var(--color-error); margin-bottom: var(--space-6);">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h1 class="result-title text-error">Link Expired</h1>
                <p class="result-text" style="margin-bottom: var(--space-6);">
                    This verification link is invalid or has expired.
                </p>
                <a href="register.php" class="btn btn-primary btn-block">Register Again</a>
            </div>

        </div>
    </div>

    <script>
        function simulateVerification() {
            const pending = document.getElementById('pendingState');
            const success = document.getElementById('successState');

            pending.classList.add('animate-fade-out'); // You might need to define this or just hide it
            pending.style.display = 'none';

            success.classList.remove('hidden');
            success.classList.add('animate-fade-in');

            setTimeout(() => {
                window.location.href = 'success.php';
            }, 2000);
        }
    </script>
</body>

</html>