<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Tracking | Magilas Gym</title>

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
    <link rel="stylesheet" href="expenses.css">
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
                    <a href="../equipment/equipment.php" class="nav-item">
                        <i class="fas fa-dumbbell"></i> <span>Equipment</span>
                    </a>
                    <a href="../expenses/expenses.php" class="nav-item active">
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
                    <h1 class="page-title">Expense <span class="text-accent">Tracking</span></h1>
                </div>
                <button class="btn btn-primary" onclick="openModal('addExpenseModal')">
                    <i class="fas fa-plus"></i> Log Expense
                </button>
            </header>

            <div class="full-page-content">
                <!-- Summary Stats -->
                <div class="summary-grid">
                    <div class="summary-card gold">
                        <h3 id="todayTotal">₱1,200</h3>
                        <p>Today's Total</p>
                    </div>
                    <div class="summary-card">
                        <h3 id="weekTotal">₱8,500</h3>
                        <p>This Week</p>
                    </div>
                    <div class="summary-card">
                        <h3 id="monthTotal">₱32,400</h3>
                        <p>This Month</p>
                    </div>
                </div>

                <!-- Expense List -->
                <div class="page-card">
                    <div class="page-card-header">
                        <h2><i class="fas fa-receipt"></i> Expense Log</h2>
                        <div class="date-filter">
                            <span style="color: var(--text-muted); font-size: 14px;">Filter:</span>
                            <select id="categoryFilter" class="form-input" style="width: auto; padding: 10px 16px;"
                                onchange="filterExpenses()">
                                <option value="all">All Categories</option>
                                <option value="Electric Bill">Electric Bill</option>
                                <option value="Water Bill">Water Bill</option>
                                <option value="Product Restock">Product Restock</option>
                                <option value="Equipment Repair">Equipment Repair</option>
                                <option value="Miscellaneous">Miscellaneous</option>
                            </select>
                        </div>
                    </div>
                    <div class="page-card-body">
                        <div class="expense-list" id="expenseList">
                            <!-- Expense items will be rendered here -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal-backdrop" id="addExpenseModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3>Log New Expense</h3>
                <button class="modal-close" onclick="closeModal('addExpenseModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <form id="addExpenseForm">
                    <div class="form-split">
                        <div class="form-group">
                            <label>Category</label>
                            <select id="expenseCategory" class="form-input" required>
                                <option value="">Select category</option>
                                <option value="Electric Bill">Electric Bill</option>
                                <option value="Water Bill">Water Bill</option>
                                <option value="Product Restock">Product Restock</option>
                                <option value="Equipment Repair">Equipment Repair</option>
                                <option value="Miscellaneous">Miscellaneous</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount (₱)</label>
                            <input type="number" id="expenseAmount" class="form-input" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" id="expenseDesc" class="form-input" placeholder="Brief description">
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" id="expenseDate" class="form-input" required>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus"></i> Log Expense
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="expenses.js"></script>
</body>

</html>
