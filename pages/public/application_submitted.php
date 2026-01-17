<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted | Magilas Gym</title>
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

            <!-- Success Icon -->
            <div style="font-size: 4rem; color: var(--color-success); margin-bottom: var(--space-4);">
                <i class="fas fa-check-circle animate-pulse"></i>
            </div>

            <h1 class="result-title">Application <span class="text-success">Submitted!</span></h1>

            <p class="result-text" style="font-size: var(--text-lg); margin-bottom: var(--space-6);">
                Thank you for applying to Magilas Gym.
            </p>

            <div class="status-badge pending">
                <i class="fas fa-hourglass-half"></i> PENDING STAFF APPROVAL
            </div>

            <div class="tip-box" style="margin-bottom: var(--space-8);">
                <i class="fas fa-info-circle tip-icon text-accent"></i>
                <div class="tip-text">
                    <p style="margin-bottom: var(--space-2); font-weight: 600; color: var(--color-text);">Next Steps:
                    </p>
                    <ol style="padding-left: var(--space-4); list-style: decimal; color: var(--color-text-secondary);">
                        <li>Visit the Magilas Gym front desk.</li>
                        <li>Present your name to the staff.</li>
                        <li>Complete your payment and validation.</li>
                    </ol>
                </div>
            </div>

            <a href="landing.php" class="btn btn-primary btn-block">
                Back to Home
            </a>

        </div>
    </div>
</body>

</html>