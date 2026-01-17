<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Search | Magilas Gym</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body class="dashboard-body">

    <div class="dashboard-container">
        <!-- Sidebar (Shared navigation) -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="search.php" class="nav-item active">
                    <i class="fas fa-search"></i> <span>Search Member</span>
                </a>
                <a href="scan.php" class="nav-item">
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
                <h1 class="page-title">Find <span class="text-accent">Member</span></h1>
            </header>

            <div class="dash-card">
                <!-- Search Bar -->
                <div class="input-group" style="max-width: 600px; margin-bottom: var(--space-6);">
                    <i class="fas fa-search input-icon" style="top: 50%; transform: translateY(-50%);"></i>
                    <input type="text" placeholder="Search by name, email, or phone..."
                        style="padding-left: 45px; width: 100%; padding: 1rem 1rem 1rem 3rem;">
                    <button class="btn btn-primary" style="margin-left: var(--space-2);">Search</button>
                </div>

                <!-- Results Grid (Static Example) -->
                <div class="card-header">
                    <h3 class="card-title">Results (2 Found)</h3>
                </div>

                <div class="list-wrapper">
                    <!-- Result 1 -->
                    <div class="list-item"
                        style="padding: var(--space-4); background: rgba(255,255,255,0.02); border-radius: var(--radius-md);">
                        <div class="item-avatar"
                            style="width: 60px; height: 60px; font-size: 1.5rem; display:flex; align-items:center; justify-content:center; background:#444;">
                            JD</div>
                        <div class="item-info" style="flex: 1;">
                            <h4 style="color: #fff; margin-bottom: 4px;">John Doe</h4>
                            <p style="color: var(--color-text-muted); font-size: 0.9rem;">john@example.com • 0912 345
                                6789</p>
                        </div>
                        <div class="item-actions">
                            <a href="activate.php" class="btn btn-secondary btn-sm"
                                style="padding: 0.5rem 1rem; font-size: 0.8rem;">View Profile</a>
                        </div>
                    </div>

                    <!-- Result 2 -->
                    <div class="list-item"
                        style="padding: var(--space-4); background: rgba(255,255,255,0.02); border-radius: var(--radius-md); margin-top: var(--space-3);">
                        <div class="item-avatar"
                            style="width: 60px; height: 60px; font-size: 1.5rem; display:flex; align-items:center; justify-content:center; background:#444;">
                            JS</div>
                        <div class="item-info" style="flex: 1;">
                            <h4 style="color: #fff; margin-bottom: 4px;">Jane Smith</h4>
                            <p style="color: var(--color-text-muted); font-size: 0.9rem;">jane.smith@email.com • 0998
                                765 4321</p>
                        </div>
                        <div class="item-actions">
                            <a href="activate.php" class="btn btn-primary btn-sm"
                                style="padding: 0.5rem 1rem; font-size: 0.8rem;">Activate Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>