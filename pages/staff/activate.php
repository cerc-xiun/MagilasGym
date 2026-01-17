<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Member | Magilas Gym</title>
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
                <a href="scan.php" class="nav-item">
                    <i class="fas fa-qrcode"></i> <span>Scan Entry</span>
                </a>
                <a href="activate.php" class="nav-item active">
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
                <h1 class="page-title">Activate <span class="text-accent">Membership</span></h1>
            </header>

            <div class="dash-grid" style="grid-template-columns: 1fr 2fr;">

                <!-- Member Profile Card -->
                <section class="dash-card" style="text-align: center;">
                    <div class="item-avatar"
                        style="width: 120px; height: 120px; margin: 0 auto var(--space-4); background: #444; font-size: 3rem; display: flex; align-items: center; justify-content: center;">
                        JD</div>
                    <h2 style="color: #fff; margin-bottom: var(--space-2);">John Doe</h2>
                    <p class="text-muted">john.doe@example.com</p>
                    <p class="text-muted">0912 345 6789</p>

                    <div
                        style="margin-top: var(--space-6); padding: var(--space-4); background: rgba(255,255,255,0.05); border-radius: var(--radius-md);">
                        <h4 style="color: var(--color-text-secondary); margin-bottom: var(--space-2);">Current Status
                        </h4>
                        <span class="status-badge"
                            style="background: rgba(255, 193, 7, 0.2); color: var(--color-accent);">Pending
                            Activation</span>
                    </div>
                </section>

                <!-- Plan Selection & Payment -->
                <section class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Select Plan</h3>
                    </div>

                    <form action="#" method="POST" style="display: flex; flex-direction: column; gap: var(--space-6);">

                        <!-- Plan Options -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-4);">
                            <label style="cursor: pointer;">
                                <input type="radio" name="plan" value="day" style="display: none;" checked>
                                <div class="plan-card active"
                                    style="border: 2px solid var(--color-accent); background: rgba(212, 175, 0, 0.1); padding: var(--space-4); border-radius: var(--radius-md); text-align: center;">
                                    <h4 style="color: #fff; margin-bottom: var(--space-2);">Day Pass</h4>
                                    <p class="text-accent" style="font-size: 1.5rem; font-weight: bold;">₱100</p>
                                    <small class="text-muted">Valid for 24 hours</small>
                                </div>
                            </label>

                            <label style="cursor: pointer;">
                                <input type="radio" name="plan" value="month" style="display: none;">
                                <div class="plan-card"
                                    style="border: 1px solid var(--color-border); padding: var(--space-4); border-radius: var(--radius-md); text-align: center; opacity: 0.7;">
                                    <h4 style="color: #fff; margin-bottom: var(--space-2);">Monthly</h4>
                                    <p class="text-accent" style="font-size: 1.5rem; font-weight: bold;">₱1,500</p>
                                    <small class="text-muted">Valid for 30 days</small>
                                </div>
                            </label>
                        </div>

                        <!-- Amount Input -->
                        <div class="form-group">
                            <label class="form-label">Payment Amount Received</label>
                            <div class="input-group">
                                <span class="input-icon">₱</span>
                                <input type="number" class="form-input" placeholder="0.00" value="100">
                            </div>
                        </div>

                        <!-- Submit -->
                        <div style="text-align: right;">
                            <button type="button" class="btn btn-primary btn-lg">
                                <i class="fas fa-check-circle"></i> CONFIRM ACTIVATION
                            </button>
                        </div>

                    </form>
                </section>
            </div>
        </main>
    </div>
</body>

</html>