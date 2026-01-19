<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard | Magilas Gym</title>
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
                    <i class="fas fa-chart-line"></i> <span>Financials</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-users"></i> <span>Staff Mgmt</span>
                </a>
                <a href="summary.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i> <span>Daily Report</span>
                </a>
            </nav>



            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar"><i class="fas fa-user-tie"></i></div>
                    <div class="user-info">
                        <h4>The Boss</h4><span>Owner</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Business <span class="text-accent">Overview</span></h1>

                <div class="header-actions">
                    <select class="form-input"
                        style="background: rgba(255,255,255,0.05); color: #fff; padding: 10px 20px;">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month" selected>This Month</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
            </header>

            <div class="dash-grid">

                <!-- Net Income (Hero Card) -->
                <div class="dash-card"
                    style="grid-column: 1 / -1; background: linear-gradient(135deg, rgba(212, 175, 0, 0.2), rgba(0,0,0,0.8)); border-color: var(--color-accent);">
                    <div class="card-header">
                        <h3 class="card-title" style="color: #fff;">NET INCOME (This Month)</h3>
                    </div>
                    <div style="display: flex; align-items: baseline; gap: 20px;">
                        <h1 style="font-size: 4rem; margin: 0; color: #fff;">₱ 85,420<span
                                style="font-size: 1.5rem; color: var(--color-text-muted);">.00</span></h1>
                        <span class="status-badge" style="background: #2ecc71; color: #fff;"><i
                                class="fas fa-arrow-up"></i> 12% vs last month</span>
                    </div>
                </div>

                <!-- Breakdown Cards -->
                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Revenue</h3>
                    </div>
                    <div style="font-size: 2rem; color: #2ecc71;">₱ 120,500</div>
                    <small class="text-muted">Direct Sales & Memberships</small>
                </div>

                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Expenses</h3>
                    </div>
                    <div style="font-size: 2rem; color: #e74c3c;">₱ 35,080</div>
                    <small class="text-muted">Utilities, Maintenance, Wages</small>
                </div>

                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">New Members</h3>
                    </div>
                    <div style="font-size: 2rem; color: #fff;">+45</div>
                    <small class="text-muted">32 Renewals</small>
                </div>

                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Pending Collection</h3>
                    </div>
                    <div style="font-size: 2rem; color: #fff;">PHP 5000</div>
                    <button
                        style="background: #ffd700; color: black; border: none; padding: 5px 15px; border-radius: 4px; cursor: pointer; margin-top: 10px; font-size: 0.9rem;">Claim</button>
                </div>

                <!-- Graphic Placeholder -->
                <div class="dash-card"
                    style="grid-column: 1 / -1; min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <i class="fas fa-chart-area"
                        style="font-size: 5rem; color: rgba(255,255,255,0.1); margin-bottom: var(--space-4);"></i>
                    <p class="text-muted">Revenue Chart Placeholder</p>
                </div>

            </div>
        </main>
    </div>
</body>

</html>