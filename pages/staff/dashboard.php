<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard | Magilas Gym</title>
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
                <a href="search.php" class="nav-item">
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
                    <div class="user-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="user-info">
                        <h4>Staff Member</h4>
                        <span>Front Desk</span>
                    </div>
                    <a href="../auth/login.php" style="margin-left: auto; color: var(--color-text-muted);">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <div>
                    <h1 class="page-title">Morning, <span class="text-accent">Staff</span></h1>
                    <p class="text-muted">Here's what's happening in the gym today.</p>
                </div>
                <!-- Mobile Menu Toggle (Visible only on small screens via CSS) -->
                <!-- <button class="btn-icon mobile-toggle"><i class="fas fa-bars"></i></button> -->
            </header>

            <!-- Quick Actions Grid -->
            <div class="dash-grid">
                <section class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Quick Actions</h3>
                    </div>
                    <div class="actions-grid">
                        <a href="scan.php" class="action-btn">
                            <i class="fas fa-expand"></i>
                            <span>Scan QR</span>
                        </a>
                        <a href="search.php" class="action-btn">
                            <i class="fas fa-search"></i>
                            <span>Lookup</span>
                        </a>
                        <a href="activate.php" class="action-btn">
                            <i class="fas fa-id-card"></i>
                            <span>Activate</span>
                        </a>
                        <a href="#" class="action-btn">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Report</span>
                        </a>
                    </div>
                </section>

                <!-- Currently Inside Widget -->
                <section class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Who's In Gym <span class="text-accent">(4)</span></h3>
                        <a href="#" class="text-accent" style="font-size: 0.8rem;">View All</a>
                    </div>
                    <div class="list-wrapper">
                        <!-- Simulated Data -->
                        <div class="list-item">
                            <div class="item-avatar"
                                style="background: #333; display:flex; align-items:center; justify-content:center;">JD
                            </div>
                            <div class="item-info">
                                <h5>John Doe</h5>
                                <small>Checked in 10 mins ago</small>
                            </div>
                            <div class="item-status status-in">Active</div>
                        </div>
                        <div class="list-item">
                            <div class="item-avatar"
                                style="background: #333; display:flex; align-items:center; justify-content:center;">JS
                            </div>
                            <div class="item-info">
                                <h5>Jane Smith</h5>
                                <small>Checked in 45 mins ago</small>
                            </div>
                            <div class="item-status status-in">Active</div>
                        </div>
                        <div class="list-item">
                            <div class="item-avatar"
                                style="background: #333; display:flex; align-items:center; justify-content:center;">MJ
                            </div>
                            <div class="item-info">
                                <h5>Mike Johnson</h5>
                                <small>Checked in 1 hr ago</small>
                            </div>
                            <div class="item-status status-in">Active</div>
                        </div>
                    </div>
                </section>

                <!-- Recent Activity Widget -->
                <section class="dash-card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activity</h3>
                    </div>
                    <div class="list-wrapper">
                        <div class="list-item">
                            <div class="item-info">
                                <h5><i class="fas fa-check-circle text-success" style="margin-right: 8px;"></i>
                                    Membership Activated</h5>
                                <small>Sarah Connor - Monthly Plan</small>
                            </div>
                            <div class="item-status">Just now</div>
                        </div>
                        <div class="list-item">
                            <div class="item-info">
                                <h5><i class="fas fa-ban text-danger" style="margin-right: 8px;"></i> Payment Failed
                                </h5>
                                <small>Guest Access - Declined</small>
                            </div>
                            <div class="item-status">2h ago</div>
                        </div>
                    </div>
                </section>
            </div>

        </main>
    </div>

</body>

</html>