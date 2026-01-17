<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Entry | Magilas Gym</title>
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
                <a href="search.php" class="nav-item">
                    <i class="fas fa-search"></i> <span>Search Member</span>
                </a>
                <a href="scan.php" class="nav-item active">
                    <i class="fas fa-qrcode"></i> <span>Scan Entry</span>
                </a>
                <a href="activate.php" class="nav-item">
                    <i class="fas fa-user-plus"></i> <span>New Membership</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar"><i class="fas fa-user-shield"></i></div>
                    <div class="user-info">
                        <h4>Staff Member</h4><span>Front Desk</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Scan <span class="text-accent">Member QR</span></h1>
            </header>

            <div class="dash-grid" style="grid-template-columns: 1fr 1fr;">

                <!-- Camera View Placeholder -->
                <section class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-camera"></i> Live Camera</h3>
                    </div>
                    <div
                        style="background: #000; height: 300px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; position: relative;">
                        <i class="fas fa-expand-arrows-alt" style="color: rgba(255,255,255,0.5); font-size: 3rem;"></i>
                        <div
                            style="position: absolute; bottom: 20px; color: #fff; background: rgba(0,0,0,0.5); padding: 5px 10px; border-radius: 4px;">
                            Camera Feed Active</div>
                    </div>
                    <div style="margin-top: var(--space-4); text-align: center;">
                        <p class="text-muted">Point camera at member's QR code</p>
                    </div>
                </section>

                <!-- Scan Result Area -->
                <section class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Scan Result</h3>
                        <span class="status-badge pending">Waiting for scan...</span>
                    </div>

                    <!-- Placeholder for no scan -->
                    <div id="no-scan"
                        style="height: 200px; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0.5;">
                        <i class="fas fa-qrcode" style="font-size: 3rem; margin-bottom: var(--space-3);"></i>
                        <p>No member scanned yet</p>
                    </div>

                    <!-- Simulated Active Scan (Hidden by default in real logic, shown here for simulated layout) -->
                    <div id="scan-data" class="" style="display: none;">
                        <div style="text-align: center; margin-bottom: var(--space-6);">
                            <div class="item-avatar"
                                style="width: 80px; height: 80px; margin: 0 auto; background: #444; font-size: 2rem; display: flex; align-items: center; justify-content: center;">
                                JD</div>
                            <h2 style="color: #fff; margin-top: var(--space-3);">John Doe</h2>
                            <p class="text-accent">Premium Member</p>
                            <span class="status-badge"
                                style="background: rgba(40, 167, 69, 0.2); color: #2ecc71;">Active Membership</span>
                        </div>

                        <div class="actions-grid">
                            <button class="btn btn-primary" style="width: 100%;"><i class="fas fa-check"></i> ALLOW
                                ENTRY</button>
                            <button class="btn btn-secondary"
                                style="width: 100%; border-color: #e74c3c; color: #e74c3c;"><i class="fas fa-times"></i>
                                DENY ENTRY</button>
                        </div>
                    </div>

                    <!-- Simulation Buttons (For Demo) -->
                    <div
                        style="margin-top: var(--space-6); padding-top: var(--space-4); border-top: 1px solid var(--color-border);">
                        <p class="text-muted" style="font-size: 0.8rem; margin-bottom: var(--space-2);">Demo Controls:
                        </p>
                        <button class="btn btn-secondary btn-sm"
                            onclick="document.getElementById('no-scan').style.display='none'; document.getElementById('scan-data').style.display='block';">Simulate
                            Success</button>
                    </div>

                </section>
            </div>
        </main>
    </div>
</body>

</html>