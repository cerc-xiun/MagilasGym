<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Member | Magilas Gym</title>

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
    <link rel="stylesheet" href="activate.css">
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
                    <a href="../scan/scan.php" class="nav-item">
                        <i class="fas fa-qrcode"></i> <span>Scan Entry</span>
                    </a>
                    <a href="../activate/activate.php" class="nav-item active">
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
                    <h1 class="page-title">Activate <span class="text-accent">Membership</span></h1>
                </div>
            </header>

            <div class="activate-container">
                <div class="activate-grid">
                    <!-- Member Profile Card -->
                    <div class="profile-card">
                        <div class="profile-avatar">JD</div>
                        <h2 class="profile-name">John Doe</h2>
                        <p class="profile-email">john.doe@example.com</p>
                        <p class="profile-phone">0912 345 6789</p>

                        <div class="profile-status">
                            <h4>Current Status</h4>
                            <span class="status-badge pending">Pending Activation</span>
                        </div>
                    </div>

                    <!-- Plan Selection & Payment -->
                    <div class="plans-card">
                        <div class="plans-header">
                            <h2><i class="fas fa-crown"></i> Select Plan</h2>
                        </div>

                        <form id="activateForm">
                            <!-- Plan Options -->
                            <div class="plans-grid">
                                <label class="plan-option">
                                    <input type="radio" name="plan" value="day" data-price="100" checked>
                                    <div class="plan-card">
                                        <h4>Day Pass</h4>
                                        <div class="plan-price">₱100</div>
                                        <p class="plan-duration">Valid for 24 hours</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>

                                <label class="plan-option">
                                    <input type="radio" name="plan" value="week" data-price="400">
                                    <div class="plan-card">
                                        <h4>Weekly</h4>
                                        <div class="plan-price">₱400</div>
                                        <p class="plan-duration">Valid for 7 days</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>

                                <label class="plan-option">
                                    <input type="radio" name="plan" value="month" data-price="1500">
                                    <div class="plan-card">
                                        <h4>Monthly</h4>
                                        <div class="plan-price">₱1,500</div>
                                        <p class="plan-duration">Valid for 30 days</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>

                                <label class="plan-option">
                                    <input type="radio" name="plan" value="annual" data-price="12000">
                                    <div class="plan-card">
                                        <h4>Annual</h4>
                                        <div class="plan-price">₱12,000</div>
                                        <p class="plan-duration">Valid for 1 year</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>
                            </div>

                            <!-- Payment Section -->
                            <div class="payment-section">
                                <h3><i class="fas fa-peso-sign"></i> Payment Amount Received</h3>
                                <div class="payment-input-wrapper">
                                    <span>₱</span>
                                    <input type="number" class="payment-input" id="paymentAmount" value="100" min="0">
                                </div>

                                <button type="button" class="confirm-btn" onclick="confirmActivation()">
                                    <i class="fas fa-check-circle"></i> CONFIRM ACTIVATION
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="activate.js"></script>
</body>

</html>
