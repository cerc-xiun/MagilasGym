<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Magilas Gym</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body class="dashboard-body">

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item active">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="stock.php" class="nav-item">
                    <i class="fas fa-boxes"></i> <span>Stock Count</span>
                </a>
                <a href="equipment.php" class="nav-item">
                    <i class="fas fa-dumbbell"></i> <span>Equipment</span>
                </a>
                <a href="audit.php" class="nav-item">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Money Audit</span>
                </a>
                <a href="summary.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i> <span>Daily Report</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar"><i class="fas fa-user-cog"></i></div>
                    <div class="user-info">
                        <h4>Admin Staff</h4><span>Inventory/Audit</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Admin <span class="text-accent">Hub</span></h1>
            </header>

            <div class="dash-grid" style="grid-template-columns: repeat(2, 1fr);">

                <!-- Stock -->
                <a href="stock.php" class="dash-card action-card-hover"
                    style="text-decoration: none; transition: transform 0.3s; display: block;">
                    <div style="text-align: center; padding: var(--space-8) 0;">
                        <i class="fas fa-boxes"
                            style="font-size: 4rem; color: var(--color-accent); margin-bottom: var(--space-4);"></i>
                        <h2 style="color: #fff;">Stock Count</h2>
                        <p class="text-muted">Manage inventory and product levels</p>
                    </div>
                </a>

                <!-- Equipment -->
                <a href="equipment.php" class="dash-card action-card-hover"
                    style="text-decoration: none; transition: transform 0.3s; display: block;">
                    <div style="text-align: center; padding: var(--space-8) 0;">
                        <i class="fas fa-dumbbell"
                            style="font-size: 4rem; color: #3498db; margin-bottom: var(--space-4);"></i>
                        <h2 style="color: #fff;">Equipment Check</h2>
                        <p class="text-muted">Report broken machines & maintenance</p>
                    </div>
                </a>

                <!-- Audit -->
                <a href="audit.php" class="dash-card action-card-hover"
                    style="text-decoration: none; transition: transform 0.3s; display: block;">
                    <div style="text-align: center; padding: var(--space-8) 0;">
                        <i class="fas fa-file-invoice-dollar"
                            style="font-size: 4rem; color: #2ecc71; margin-bottom: var(--space-4);"></i>
                        <h2 style="color: #fff;">Money Audit</h2>
                        <p class="text-muted">Verify cash drawer daily totals</p>
                    </div>
                </a>

                <!-- Summary -->
                <a href="summary.php" class="dash-card action-card-hover"
                    style="text-decoration: none; transition: transform 0.3s; display: block;">
                    <div style="text-align: center; padding: var(--space-8) 0;">
                        <i class="fas fa-clipboard-list"
                            style="font-size: 4rem; color: #e74c3c; margin-bottom: var(--space-4);"></i>
                        <h2 style="color: #fff;">Daily Summary</h2>
                        <p class="text-muted">View end-of-day reports</p>
                    </div>
                </a>

            </div>
        </main>
    </div>
</body>

</html>