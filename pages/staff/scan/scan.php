<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Entry | Magilas Gym</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/dashboard.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../../assets/images/logo.png">
    <link rel="stylesheet" href="scan.css">
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-label">Overview</div>
                    <a href="../dashboard/dashboard.php" class="nav-item">
                        <i class="fas fa-th-large"></i> <span>Dashboard</span>
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-label">Members</div>
                    <a href="../search/search.php" class="nav-item">
                        <i class="fas fa-search"></i> <span>Search Member</span>
                    </a>
                    <a href="../scan/scan.php" class="nav-item active">
                        <i class="fas fa-qrcode"></i> <span>Scan Entry</span>
                    </a>
                    <a href="../activate/activate.php" class="nav-item">
                        <i class="fas fa-user-plus"></i> <span>New Membership</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="../inventory/inventory.php" class="nav-item">
                        <i class="fas fa-boxes-stacked"></i> <span>Inventory</span>
                    </a>
                </div>
            </nav>

            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">SM</div>
                    <div class="user-text">
                        <h4>Staff Member</h4>
                        <span>Front Desk</span>
                    </div>
                    <a href="../auth/login.php" class="user-logout" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="menu-btn" id="menuBtn" style="display: none;">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Scan <span class="text-accent">Member QR</span></h1>
                </div>
            </header>

            <!-- Scan Header & Action -->
            <div class="scan-header-action" style="margin-bottom: 24px;">
                <button class="btn-allow" style="width: 100%; padding: 20px; font-size: 18px;" onclick="openScanModal()">
                    <i class="fas fa-qrcode" style="font-size: 24px;"></i> SCAN MEMBER QR
                </button>
            </div>

            <!-- Main Content: Who's In List -->
            <div class="panel" style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
                <div class="panel-header">
                    <h2 class="panel-title"><i class="fas fa-users"></i> Who's In Gym</h2>
                    <span class="member-badge" id="activeLabel">0 Active</span>
                </div>
                <div class="panel-body" id="gymMembersList" style="flex: 1; overflow-y: auto;">
                    <!-- List -->
                </div>
            </div>

            <!-- Scan Modal -->
            <div id="scanModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
                <div class="modal-content" style="background: var(--bg-secondary); border-radius: var(--radius-xl); border: 1px solid var(--border); width: 90%; max-width: 500px; padding: 24px; position: relative;">
                    <button onclick="closeScanModal()" style="position: absolute; top: 16px; right: 16px; color: var(--text-muted); font-size: 20px;"><i class="fas fa-times"></i></button>
                    
                    <h3 style="margin-bottom: 20px; color: var(--text-primary);">Scan QR Code</h3>

                    <!-- Camera View -->
                    <div class="camera-container" style="height: 300px; margin-bottom: 20px;">
                        <!-- Camera Placeholder / Start State -->
                        <div id="camera-placeholder" class="camera-placeholder">
                            <i class="fas fa-camera"></i>
                            <p>Camera is ready</p>
                            <button class="btn-allow" style="margin-top: 16px; padding: 12px 24px;" onclick="startCamera()">
                                <i class="fas fa-power-off"></i> Start Camera
                            </button>
                        </div>
                        
                        <!-- Active Camera State -->
                        <div id="camera-active" class="camera-active" style="display: none; width: 100%; height: 100%;">
                             <div class="scan-corners"></div>
                             <div class="scan-corners-bottom"></div>
                             <div class="scan-line"></div>
                             <div class="camera-status">Scanning...</div>
                        </div>
                    </div>

                    <!-- Scan Result Area -->
                    <div class="result-card" style="border: none; background: transparent; padding: 0;">
                        <div class="result-header" style="padding-bottom: 12px; margin-bottom: 12px;">
                            <h3 class="result-title" style="font-size: 18px;">Result</h3>
                            <span class="status-badge pending" id="scanStatus">Waiting...</span>
                        </div>

                        <!-- Waiting State -->
                        <div id="no-scan" class="waiting-state" style="padding: 20px;">
                            <p>Point camera at member's QR code</p>
                            <div class="demo-controls" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
                                <button class="btn btn-secondary btn-sm" onclick="simulateScan()">
                                    <i class="fas fa-play"></i> Simulate Scan
                                </button>
                            </div>
                        </div>

                        <!-- Scan Success -->
                        <div id="scan-data" class="scan-success" style="display: none;">
                            <div class="member-avatar-large" style="width: 80px; height: 80px; font-size: 32px; margin-bottom: 12px;">JD</div>
                            <h2 class="member-name" style="font-size: 20px;">John Doe</h2>
                            <p class="member-plan">Premium Member</p>
                            <span class="status-badge success">Active</span>

                            <div class="action-buttons" style="margin-top: 20px;">
                                <button class="btn-allow" onclick="allowEntry()">
                                    <i class="fas fa-check"></i> ALLOW
                                </button>
                                <button class="btn-deny" onclick="denyEntry()">
                                    <i class="fas fa-times"></i> DENY
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="scan.js"></script>
</body>

</html>
