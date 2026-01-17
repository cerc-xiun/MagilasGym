<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Audit | Magilas Gym</title>
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
                <a href="equipment.php" class="nav-item">
                    <i class="fas fa-dumbbell"></i> <span>Equipment</span>
                </a>
                <a href="audit.php" class="nav-item active">
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
                <h1 class="page-title">Money <span class="text-accent">Audit</span></h1>
            </header>

            <div class="dash-card" style="max-width: 600px; margin: 0 auto;">
                <div class="card-header">
                    <h3 class="card-title">Cash Drawer Reconciliation</h3>
                    <div style="font-size: 0.9rem; color: var(--color-text-muted);">Today: Jan 17, 2026</div>
                </div>

                <form action="#" method="POST" style="display: flex; flex-direction: column; gap: var(--space-6);">

                    <!-- System Total (Read Only) -->
                    <div
                        style="background: rgba(255,255,255,0.05); padding: var(--space-6); border-radius: var(--radius-md); text-align: center;">
                        <small class="text-muted">SYSTEM TOTAL (EXPECTED)</small>
                        <div style="font-size: 2.5rem; font-weight: bold; color: #fff;">₱ 12,500.00</div>
                    </div>

                    <!-- Cash Input -->
                    <div class="form-group">
                        <label class="form-label">Physical Cash Counted</label>
                        <div class="input-group">
                            <span class="input-icon">₱</span>
                            <input type="number" class="form-input" placeholder="0.00" value="12500">
                        </div>
                    </div>

                    <!-- Discrepancy Display -->
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-4); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-sm);">
                        <span class="text-muted">Discrepancy:</span>
                        <span class="text-success" style="font-weight: bold; font-size: 1.1rem;">₱ 0.00
                            (Balanced)</span>
                    </div>

                    <!-- Notes -->
                    <div class="form-group">
                        <label class="form-label">Audit Notes</label>
                        <textarea class="form-input" rows="3"
                            placeholder="Any variance explanation or notes..."></textarea>
                    </div>

                    <button class="btn btn-primary btn-lg" style="width: 100%;">
                        <i class="fas fa-check-double"></i> Submit Audit Report
                    </button>

                </form>
            </div>
        </main>
    </div>
</body>

</html>