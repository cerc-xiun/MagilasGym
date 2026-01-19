<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Summary | Magilas Gym</title>
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
                    <i class="fas fa-chart-line"></i> <span>Financials</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-users"></i> <span>Staff Mgmt</span>
                </a>
                <a href="summary.php" class="nav-item active">
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
                <h1 class="page-title">Daily <span class="text-accent">Summary</span></h1>
                <button class="btn btn-secondary"><i class="fas fa-print"></i> Print Report</button>
            </header>

            <div class="dash-grid">

                <!-- Quick Stats -->
                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Today's Overview</h3>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-4);">
                        <div
                            style="text-align: center; padding: var(--space-4); background: rgba(255,255,255,0.05); border-radius: var(--radius-md);">
                            <h2 class="text-accent">24</h2>
                            <small class="text-muted">Total Check-ins</small>
                        </div>
                        <div
                            style="text-align: center; padding: var(--space-4); background: rgba(255,255,255,0.05); border-radius: var(--radius-md);">
                            <h2 class="text-success">₱12.5k</h2>
                            <small class="text-muted">Total Sales</small>
                        </div>
                    </div>
                </div>

                <!-- Issues -->
                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Issues Reported</h3>
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li class="list-item">
                            <i class="fas fa-exclamation-triangle text-warning" style="margin-right: 10px;"></i>
                            <span>Bench Press #2 - Wobbly</span>
                        </li>
                        <li class="list-item">
                            <i class="fas fa-times-circle text-danger" style="margin-right: 10px;"></i>
                            <span>Stock Discrepancy (-2 Water)</span>
                        </li>
                    </ul>
                </div>

                <!-- Full Report Table -->
                <div class="dash-card" style="grid-column: 1 / -1;">
                    <div class="card-header">
                        <h3 class="card-title">Recent Transactions</h3>
                    </div>
                    <div class="table-responsive">
                        <table style="width: 100%; border-collapse: collapse; color: #fff;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--color-border); text-align: left;">
                                    <th style="padding: var(--space-3);">Time</th>
                                    <th style="padding: var(--space-3);">Description</th>
                                    <th style="padding: var(--space-3);">Staff</th>
                                    <th style="padding: var(--space-3); text-align: right;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: var(--space-3); color: var(--color-text-muted);">08:45 AM</td>
                                    <td style="padding: var(--space-3);">Membership Activation (Month) - J. Doe</td>
                                    <td style="padding: var(--space-3);">Staff 1</td>
                                    <td style="padding: var(--space-3); text-align: right;">₱1,500.00</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: var(--space-3); color: var(--color-text-muted);">09:12 AM</td>
                                    <td style="padding: var(--space-3);">Day Pass - Guest</td>
                                    <td style="padding: var(--space-3);">Staff 1</td>
                                    <td style="padding: var(--space-3); text-align: right;">₱100.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>