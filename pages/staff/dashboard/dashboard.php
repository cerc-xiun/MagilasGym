<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal | Magilas Gym</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/dashboard.css">
    <link rel="stylesheet" href="dashboard.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../../assets/images/logo.png">
</head>

<body>
    <div class="portal-layout">
        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../../assets/images/logo.png" alt="Magilas Gym" class="sidebar-logo">
                <span class="sidebar-title">MAGILAS <span>GYM</span></span>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-label">Overview</div>
                    <a href="dashboard.php" class="nav-item active">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                </div>



                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="../inventory/inventory.php" class="nav-item">
                        <i class="fas fa-boxes-stacked"></i> Inventory
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
                    <a href="../../auth/login.php" class="user-logout" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN ===== -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <button class="menu-btn" id="menuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Dashboard</h1>
                </div>
                <div class="header-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="dateDisplay"></span>
                </div>
            </header>

            <div class="content-area">
                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card gold animate-fade-in">
                        <div class="stat-icon gold"><i class="fas fa-users"></i></div>
                        <div class="stat-value" id="inGymCount">4</div>
                        <div class="stat-label">In Gym Now</div>
                    </div>
                    <div class="stat-card green animate-fade-in">
                        <div class="stat-icon green"><i class="fas fa-peso-sign"></i></div>
                        <div class="stat-value" id="revenueVal">₱4,500</div>
                        <div class="stat-label">Today's Revenue</div>
                    </div>
                    <div class="stat-card orange animate-fade-in">
                        <div class="stat-icon orange"><i class="fas fa-wrench"></i></div>
                        <div class="stat-value" id="issuesCount">2</div>
                        <div class="stat-label">Needs Attention</div>
                    </div>
                    <div class="stat-card red animate-fade-in">
                        <div class="stat-icon red"><i class="fas fa-receipt"></i></div>
                        <div class="stat-value" id="expenseVal">₱1,200</div>
                        <div class="stat-label">Today's Expenses</div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="actions-row">
                    <a href="../scan/scan.php" class="action-btn animate-scale-in">
                        <i class="fas fa-expand"></i>
                        <span>Scan QR</span>
                    </a>
                    <a href="../search/search.php" class="action-btn animate-scale-in">
                        <i class="fas fa-search"></i>
                        <span>Lookup</span>
                    </a>
                    <a href="../activate/activate.php" class="action-btn animate-scale-in">
                        <i class="fas fa-id-card"></i>
                        <span>Activate</span>
                    </a>
                    <button class="action-btn animate-scale-in" onclick="openModal('reportModal')">
                        <i class="fas fa-tools"></i>
                        <span>Report Issue</span>
                    </button>
                </div>

                <!-- Panels -->
                <div class="panels-row">
                    <!-- Who's In -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title"><i class="fas fa-user-check"></i> Who's In Gym</h2>
                            <span class="member-badge" id="activeLabel">4 Active</span>
                        </div>
                        <div class="panel-body" id="membersPanel"></div>
                    </div>

                    <!-- Activity -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title"><i class="fas fa-clock-rotate-left"></i> Recent Activity</h2>
                        </div>
                        <div class="panel-body" id="activityPanel"></div>
                    </div>

                    <!-- Maintenance -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title"><i class="fas fa-triangle-exclamation"></i> Maintenance Alerts</h2>
                            <button class="panel-btn" onclick="openModal('reportModal')">
                                <i class="fas fa-plus"></i> Report
                            </button>
                        </div>
                        <div class="panel-body" id="maintenancePanel"></div>
                    </div>

                    <!-- Expenses -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title"><i class="fas fa-wallet"></i> Today's Expenses</h2>
                            <button class="panel-btn" onclick="openModal('expenseModal')">
                                <i class="fas fa-plus"></i> Log
                            </button>
                        </div>
                        <div class="panel-body" id="expensePanel"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ===== EQUIPMENT MODAL ===== -->
    <div class="modal-backdrop" id="equipmentModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Equipment Management</h3>
                <button class="modal-close" onclick="closeModal('equipmentModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <form id="addEquipForm">
                    <div class="form-group">
                        <label>Add New Equipment</label>
                        <div style="display: flex; gap: 12px;">
                            <input type="text" id="newEquipName" class="form-input" placeholder="e.g., Treadmill #5"
                                style="flex: 1;">
                            <button type="submit" class="btn-submit"
                                style="width: auto; padding: 12px 20px; margin-top: 0;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="equipment-grid">
                    <div class="equipment-grid-title">Current Equipment</div>
                    <div id="equipList"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== REPORT MODAL ===== -->
    <div class="modal-backdrop" id="reportModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Report Equipment Issue</h3>
                <button class="modal-close" onclick="closeModal('reportModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <form id="reportForm">
                    <div class="form-group">
                        <label>Equipment</label>
                        <select id="reportEquip" class="form-input" required>
                            <option value="">Select equipment</option>
                        </select>
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
                        Submit Report <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== EXPENSE MODAL ===== -->
    <div class="modal-backdrop" id="expenseModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Log Expense</h3>
                <button class="modal-close" onclick="closeModal('expenseModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <form id="expenseForm">
                    <div class="form-split">
                        <div class="form-group">
                            <label>Category</label>
                            <select id="expenseCat" class="form-input" required>
                                <option value="">Select</option>
                                <option value="Electric Bill">Electric Bill</option>
                                <option value="Water Bill">Water Bill</option>
                                <option value="Product Restock">Product Restock</option>
                                <option value="Equipment Repair">Equipment Repair</option>
                                <option value="Miscellaneous">Miscellaneous</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount (₱)</label>
                            <input type="number" id="expenseAmt" class="form-input" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description (optional)</label>
                        <input type="text" id="expenseDesc" class="form-input" placeholder="Brief note">
                    </div>
                    <button type="submit" class="btn-submit">
                        Log Expense <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ===== JAVASCRIPT ===== -->
    <script src="dashboard.js"></script>
</body>

</html>