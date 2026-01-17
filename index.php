<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Magilas Gym | Dev Hub</title>
  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="css/variables.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/dev.css">

  <link rel="icon" type="image/png" href="assets/images/logo.png">
</head>

<body>
  <main class="dev-page">
    <div class="dev-overlay">
      <header class="dev-header animate-slide-up">
        <img src="assets/images/logo.png" alt="Magilas Logo" class="dev-logo animate-pulse">
        <h1 class="dev-title">MAGILAS <span class="text-accent">GYM</span></h1>
        <p class="dev-subtitle">Development Navigation Hub</p>
      </header>

      <div class="dev-grid">
        <!-- Public Pages -->
        <div class="dev-card animate-fade-in delay-100">
          <div class="dev-card-header">
            <div class="dev-card-icon text-accent"><i class="fas fa-globe"></i></div>
            <h2 class="dev-card-title">PUBLIC</h2>
          </div>
          <div class="dev-links">
            <a href="pages/public/landing.php" class="dev-link">
              <span class="status-dot active"></span>
              Landing Page
            </a>
            <a href="pages/public/register.php" class="dev-link">
              <span class="status-dot active"></span>
              Register
            </a>
            <a href="pages/public/verify.php" class="dev-link">
              <span class="status-dot active"></span>
              Verify Email
            </a>
            <a href="pages/public/success.php" class="dev-link">
              <span class="status-dot active"></span>
              Success / QR
            </a>
            <a href="pages/public/recover.php" class="dev-link">
              <span class="status-dot active"></span>
              Recover QR
            </a>
          </div>
        </div>

        <!-- Authentication -->
        <div class="dev-card animate-fade-in delay-200">
          <div class="dev-card-header">
            <div class="dev-card-icon" style="color: #4CAF50;"><i class="fas fa-lock"></i></div>
            <h2 class="dev-card-title">AUTH</h2>
          </div>
          <div class="dev-links">
            <a href="pages/auth/login.php" class="dev-link">
              <span class="status-dot active"></span>
              Staff Login
            </a>
            <a href="#" class="dev-link coming-soon">
              <span class="status-dot"></span>
              Reset Password
            </a>
          </div>
        </div>

        <!-- Dashboards -->
        <div class="dev-card animate-fade-in delay-300">
          <div class="dev-card-header">
            <div class="dev-card-icon" style="color: #2196F3;"><i class="fas fa-columns"></i></div>
            <h2 class="dev-card-title">DASHBOARDS</h2>
          </div>
          <div class="dev-links">
            <a href="pages/staff/dashboard.php" class="dev-link">
              <span class="status-dot active"></span>
              Staff Portal
            </a>
            <a href="pages/admin/dashboard.php" class="dev-link">
              <span class="status-dot active"></span>
              Admin Console
            </a>
            <a href="pages/owner/dashboard.php" class="dev-link">
              <span class="status-dot active"></span>
              Owner View
            </a>
            <a href="pages/dev/tools.php" class="dev-link">
              <span class="status-dot active"></span>
              Dev Tools
            </a>
          </div>
        </div>
      </div>

      <footer
        style="text-align: center; margin-top: auto; padding-top: 40px; color: var(--color-text-muted); font-size: 0.9rem;">
        <p>Magilas Gym PWA &copy; 2026</p>
      </footer>
    </div>
  </main>
</body>

</html>