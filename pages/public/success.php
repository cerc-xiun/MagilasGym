<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Complete | Magilas Gym</title>
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
    <div class="success-page">
        <div class="success-card animate-slide-up">

            <!-- Confetti Icon -->
            <div style="font-size: 4rem; margin-bottom: var(--space-4);">🎉</div>

            <h1 class="auth-title">Welcome to <span class="text-accent">Magilas!</span></h1>
            <p class="result-text" style="margin-bottom: var(--space-6);">
                Your pre-registration is complete.
            </p>

            <div class="status-badge pending">
                <i class="fas fa-clock"></i> Pending Activation
            </div>

            <!-- QR Code Placeholder -->
            <div class="qr-wrapper animate-pulse">
                <i class="fas fa-qrcode" style="font-size: 150px; color: var(--color-text);"></i>
            </div>

            <div
                style="text-align: left; background: rgba(0,0,0,0.3); padding: var(--space-4); border-radius: var(--radius-md); margin: var(--space-6) 0;">
                <p style="margin-bottom: var(--space-2);"><strong class="text-accent">Name:</strong> <span
                        class="text-white">Juan Dela Cruz</span></p>
                <p style="margin: 0;"><strong class="text-accent">Member ID:</strong> <span
                        class="text-white">MG-2026-001</span></p>
            </div>

            <div class="tip-box">
                <i class="fas fa-info-circle tip-icon text-accent"></i>
                <span class="tip-text">
                    Present this QR code at the gym reception to activate your membership and pay the fee.
                </span>
            </div>

            <div style="margin-top: var(--space-8);">
                <button class="btn btn-primary btn-block" onclick="window.print()">
                    <i class="fas fa-download"></i> Save QR Code
                </button>
                <a href="landing.php" class="btn btn-secondary btn-block" style="margin-top: var(--space-3);">
                    Back to Home
                </a>
            </div>

        </div>
    </div>
</body>

</html>