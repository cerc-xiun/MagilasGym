<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev Tools | Magilas Gym</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body class="dashboard-body">

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" style="border-right-color: #9b59b6;">
            <div class="sidebar-header">
                <img src="../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>

            <nav class="sidebar-nav">
                <a href="../../index.php" class="nav-item">
                    <i class="fas fa-arrow-left"></i> <span>Back to Index</span>
                </a>
                <a href="tools.php" class="nav-item active">
                    <i class="fas fa-terminal"></i> <span>System Tools</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar" style="color: #9b59b6;"><i class="fas fa-code"></i></div>
                    <div class="user-info">
                        <h4>Developer</h4><span>System Admin</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">System <span class="text-accent">Health</span></h1>
            </header>

            <div class="dash-grid">

                <!-- Health Check -->
                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Database Status</h3>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div
                            style="width: 15px; height: 15px; background: #2ecc71; border-radius: 50%; box-shadow: 0 0 10px #2ecc71;">
                        </div>
                        <h2 style="margin: 0; color: #fff;">CONNECTED</h2>
                    </div>
                    <p class="text-muted" style="margin-top: 10px;">Latency: 12ms</p>
                </div>

                <div class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Error Log</h3>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <h2 style="margin: 0; color: #fff;">0 <span
                                style="font-size: 1rem; color: #2ecc71;">Errors</span></h2>
                    </div>
                    <p class="text-muted" style="margin-top: 10px;">Last check: Just now</p>
                </div>

                <!-- Audit Log Table -->
                <div class="dash-card" style="grid-column: 1 / -1;">
                    <div class="card-header">
                        <h3 class="card-title">System Audit Log</h3>
                        <button class="btn btn-secondary btn-sm"><i class="fas fa-sync"></i> Refresh</button>
                    </div>
                    <div class="table-responsive">
                        <table style="width: 100%; border-collapse: collapse; color: #fff;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--color-border); text-align: left;">
                                    <th style="padding: var(--space-3);">Timestamp</th>
                                    <th style="padding: var(--space-3);">Level</th>
                                    <th style="padding: var(--space-3);">Action</th>
                                    <th style="padding: var(--space-3);">User / IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); font-family: monospace;">
                                    <td style="padding: var(--space-3); color: var(--color-text-muted);">2026-01-17
                                        08:32:11</td>
                                    <td style="padding: var(--space-3);"><span class="text-success">[INFO]</span></td>
                                    <td style="padding: var(--space-3);">Admin Login Success</td>
                                    <td style="padding: var(--space-3);">admin@magilas.com (192.168.1.5)</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); font-family: monospace;">
                                    <td style="padding: var(--space-3); color: var(--color-text-muted);">2026-01-17
                                        08:30:45</td>
                                    <td style="padding: var(--space-3);"><span class="text-accent">[WARN]</span></td>
                                    <td style="padding: var(--space-3);">Stock Count Discrepancy (-2)</td>
                                    <td style="padding: var(--space-3);">System Audit</td>
                                </tr>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); font-family: monospace;">
                                    <td style="padding: var(--space-3); color: var(--color-text-muted);">2026-01-17
                                        08:15:22</td>
                                    <td style="padding: var(--space-3);"><span class="text-success">[INFO]</span></td>
                                    <td style="padding: var(--space-3);">New Member Registered (ID: 9942)</td>
                                    <td style="padding: var(--space-3);">Public Form (192.168.1.102)</td>
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