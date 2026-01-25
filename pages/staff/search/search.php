<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Search | Magilas Gym</title>

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
    <link rel="stylesheet" href="search.css">
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
                    <a href="../search/search.php" class="nav-item active">
                        <i class="fas fa-search"></i> <span>Search Member</span>
                    </a>
                    <a href="../scan/scan.php" class="nav-item">
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
                    <h1 class="page-title">Find <span class="text-accent">Member</span></h1>
                </div>
            </header>

            <div class="search-container">
                <div class="search-card">
                    <!-- Search Bar -->
                    <div class="search-bar">
                        <div class="search-input-wrapper">
                            <input type="text" class="search-input" placeholder="Search by name, email, or phone..."
                                id="searchInput">
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>

                    <!-- Results -->
                    <div class="results-header">
                        <h3 class="results-title">
                            <i class="fas fa-users"></i> Results
                        </h3>
                        <span class="results-count" id="resultsCount">2 members found</span>
                    </div>

                    <div class="results-list" id="resultsList">
                        <!-- Result 1 -->
                        <div class="result-item">
                            <div class="result-avatar">JD</div>
                            <div class="result-info">
                                <h4>John Doe</h4>
                                <p>john@example.com • 0912 345 6789</p>
                            </div>
                            <div class="result-actions">
                                <a href="../activate/activate.php" class="btn-view">View Profile</a>
                            </div>
                        </div>

                        <!-- Result 2 -->
                        <div class="result-item">
                            <div class="result-avatar">JS</div>
                            <div class="result-info">
                                <h4>Jane Smith</h4>
                                <p>jane.smith@email.com • 0998 765 4321</p>
                            </div>
                            <div class="result-actions">
                                <a href="../activate/activate.php" class="btn-activate">
                                    <i class="fas fa-bolt"></i> Activate Plan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="search.js"></script>
</body>

</html>
