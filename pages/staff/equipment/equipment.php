<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Management | Magilas Gym</title>

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
    <link rel="stylesheet" href="equipment.css">
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
                    <a href="../activate/activate.php" class="nav-item">
                        <i class="fas fa-user-plus"></i> <span>New Membership</span>
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="../equipment/equipment.php" class="nav-item active">
                        <i class="fas fa-dumbbell"></i> <span>Equipment</span>
                        <span class="nav-badge" id="issuesBadge">2</span>
                    </a>
                    <a href="../expenses/expenses.php" class="nav-item">
                        <i class="fas fa-file-invoice-dollar"></i> <span>Expenses</span>
                    </a>
                </div>
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
            <header class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="menu-btn" id="menuBtn" style="display: none;">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Equipment <span class="text-accent">Management</span></h1>
                </div>
                <button class="btn btn-primary" onclick="openModal('addEquipModal')">
                    <i class="fas fa-plus"></i> Add Equipment
                </button>
            </header>

            <div class="full-page-content">
                <!-- Summary Stats -->
                <div class="summary-grid">
                    <div class="summary-card">
                        <h3 id="totalEquipment">9</h3>
                        <p>Total Equipment</p>
                    </div>
                    <div class="summary-card green">
                        <h3 id="operationalCount">7</h3>
                        <p>Operational</p>
                    </div>
                    <div class="summary-card red">
                        <h3 id="issuesCount">2</h3>
                        <p>Needs Repair</p>
                    </div>
                </div>

                <!-- Equipment List -->
                <div class="page-card">
                    <div class="page-card-header">
                        <h2><i class="fas fa-dumbbell"></i> All Equipment</h2>
                        <div style="display: flex; gap: 12px;">
                            <button class="btn btn-secondary btn-sm" onclick="filterEquipment('all')">All</button>
                            <button class="btn btn-secondary btn-sm"
                                onclick="filterEquipment('operational')">Operational</button>
                            <button class="btn btn-secondary btn-sm" onclick="filterEquipment('issues')">Has
                                Issues</button>
                        </div>
                    </div>
                    <div class="page-card-body">
                        <div class="equipment-list" id="equipmentList">
                            <!-- Equipment items will be rendered here -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Equipment Modal -->
    <div class="modal-backdrop" id="addEquipModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Add New Equipment</h3>
                <button class="modal-close" onclick="closeModal('addEquipModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <form id="addEquipForm">
                    <div class="form-group">
                        <label>Equipment Name</label>
                        <input type="text" id="equipName" class="form-input" placeholder="e.g., Treadmill #5" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select id="equipCategory" class="form-input" required>
                            <option value="">Select category</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Strength">Strength</option>
                            <option value="Free Weights">Free Weights</option>
                            <option value="Machines">Machines</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" id="equipLocation" class="form-input" placeholder="e.g., Main Floor">
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus"></i> Add Equipment
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Report Issue Modal -->
    <div class="modal-backdrop" id="reportModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Report Issue</h3>
                <button class="modal-close" onclick="closeModal('reportModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <form id="reportForm">
                    <input type="hidden" id="reportEquipId">
                    <div class="form-group">
                        <label>Equipment: <strong id="reportEquipName"></strong></label>
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <select id="reportPriority" class="form-input" required>
                            <option value="low">Low - Can wait</option>
                            <option value="medium" selected>Medium - Needs attention</option>
                            <option value="high">High - Urgent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="reportDesc" class="form-input" rows="3" placeholder="Describe the issue..."
                            required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-exclamation-triangle"></i> Submit Report
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="equipment.js"></script>
</body>

</html>
