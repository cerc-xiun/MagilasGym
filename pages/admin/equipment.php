<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Check | Magilas Gym</title>
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
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="stock.php" class="nav-item">
                    <i class="fas fa-boxes"></i> <span>Stock Count</span>
                </a>
                <a href="equipment.php" class="nav-item active">
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
                <h1 class="page-title">Equipment <span class="text-accent">Maint.</span></h1>
                <button class="btn btn-primary"><i class="fas fa-plus"></i> Add Report</button>
            </header>

            <div class="dash-card">
                <div class="list-wrapper">

                    <!-- Item 1 -->
                    <div class="list-item">
                        <div class="item-info">
                            <h4 style="color: #fff; margin-bottom: 4px;">Treadmill #1</h4>
                            <p class="text-muted">Cardio Section</p>
                        </div>
                        <div class="item-status" style="margin-right: var(--space-4);">
                            <select class="form-input" style="padding: 5px; color: #fff; background: #222;">
                                <option value="ok" selected>✅ Functional</option>
                                <option value="warn">⚠️ Needs Oil</option>
                                <option value="bad">❌ Broken</option>
                            </select>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">Last checked: Today</div>
                    </div>

                    <!-- Item 2 -->
                    <div class="list-item">
                        <div class="item-info">
                            <h4 style="color: #fff; margin-bottom: 4px;">Bench Press #2</h4>
                            <p class="text-muted">Weight Room</p>
                        </div>
                        <div class="item-status" style="margin-right: var(--space-4);">
                            <select class="form-input" style="padding: 5px; color: #fab1a0; background: #222;">
                                <option value="ok">✅ Functional</option>
                                <option value="warn" selected>⚠️ Wobbly</option>
                                <option value="bad">❌ Broken</option>
                            </select>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">Last checked: Yesterday</div>
                    </div>

                    <!-- Item 3 -->
                    <div class="list-item">
                        <div class="item-info">
                            <h4 style="color: #fff; margin-bottom: 4px;">Cable Machine</h4>
                            <p class="text-muted">Main Floor</p>
                        </div>
                        <div class="item-status" style="margin-right: var(--space-4);">
                            <select class="form-input" style="padding: 5px; color: #ff7675; background: #222;">
                                <option value="ok">✅ Functional</option>
                                <option value="warn">⚠️ Maintenance</option>
                                <option value="bad" selected>❌ Broken Cable</option>
                            </select>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">Last checked: 3 days ago</div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>

</html>