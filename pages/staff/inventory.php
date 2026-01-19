<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management | Magilas Gym</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="icon" type="image/png" href="../../assets/images/logo.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .tab-navigation {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            background: var(--bg-secondary);
            padding: 8px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
        }

        .tab-btn {
            flex: 1;
            padding: 16px 24px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 14px;
            color: var(--text-muted);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .tab-btn:hover {
            color: var(--text-primary);
            background: var(--bg-tertiary);
        }

        .tab-btn.active {
            background: var(--gradient-gold);
            color: #000;
            box-shadow: 0 4px 12px var(--gold-glow);
        }

        .tab-btn i {
            font-size: 16px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .controls-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 14px 20px 14px 48px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background: var(--bg-secondary);
            font-size: 14px;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--gold);
        }

        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .filter-select {
            padding: 14px 20px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background: var(--bg-secondary);
            min-width: 180px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 14px 16px;
            background: var(--bg-tertiary);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .data-table tr:hover {
            background: rgba(184, 150, 12, 0.03);
        }

        .data-table .actions {
            display: flex;
            gap: 8px;
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .pagination button {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            background: var(--bg-secondary);
            color: var(--text-muted);
        }

        .pagination button:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .pagination button.active {
            background: var(--gold);
            color: #000;
            border-color: var(--gold);
        }

        .pagination button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .status-pill {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pill.operational {
            background: rgba(5, 150, 105, 0.12);
            color: #059669;
        }

        .status-pill.maintenance {
            background: rgba(245, 158, 11, 0.12);
            color: #d97706;
        }

        .status-pill.missing {
            background: rgba(220, 38, 38, 0.12);
            color: #dc2626;
        }

        .inventory-worth {
            background: linear-gradient(135deg, rgba(184, 150, 12, 0.1) 0%, rgba(184, 150, 12, 0.05) 100%);
            border: 1px solid rgba(184, 150, 12, 0.3);
            border-radius: var(--radius-lg);
            padding: 24px 32px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .inventory-worth h3 {
            font-size: 14px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .inventory-worth .value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 42px;
            background: var(--gradient-gold-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .expense-type-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .expense-type-btn {
            padding: 10px 20px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            background: var(--bg-secondary);
            font-size: 13px;
            font-weight: 500;
        }

        .expense-type-btn.active {
            background: var(--gold-subtle);
            border-color: var(--gold);
            color: var(--gold-dark);
        }
    </style>
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-label">Overview</div>
                    <a href="dashboard.php" class="nav-item"><i class="fas fa-th-large"></i> <span>Dashboard</span></a>
                </div>

                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="members.php" class="nav-item">
                        <i class="fas fa-users"></i> <span>Members</span>
                    </a>
                    <a href="inventory.php" class="nav-item active"><i class="fas fa-boxes-stacked"></i>
                        <span>Inventory</span></a>
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

        <main class="main-content">
            <header class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="menu-btn" id="menuBtn" style="display: none;"><i class="fas fa-bars"></i></button>
                    <h1 class="page-title">Inventory <span class="text-accent">Management</span></h1>
                </div>
                <button class="btn btn-primary" id="addNewBtn"><i class="fas fa-plus"></i> <span id="addBtnText">Add
                        Equipment</span></button>
            </header>

            <div class="full-page-content">
                <div class="tab-navigation">
                    <button class="tab-btn active" data-tab="equipment"><i class="fas fa-dumbbell"></i>
                        Equipment</button>
                    <button class="tab-btn" data-tab="stock"><i class="fas fa-box"></i> Stock</button>
                    <button class="tab-btn" data-tab="expenses"><i class="fas fa-receipt"></i> Expenses</button>
                </div>

                <!-- EQUIPMENT TAB -->
                <div class="tab-content active" id="equipment-tab">
                    <div class="controls-row">
                        <div class="search-box"><i class="fas fa-search"></i><input type="text" id="equipSearch"
                                placeholder="Search equipment..."></div>
                        <select class="filter-select" id="equipCategoryFilter">
                            <option value="all">All Categories</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Strength">Strength</option>
                            <option value="Free Weights">Free Weights</option>
                            <option value="Machines">Machines</option>
                        </select>
                        <select class="filter-select" id="equipStatusFilter">
                            <option value="all">All Status</option>
                            <option value="operational">Operational</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="missing">Missing</option>
                        </select>
                    </div>
                    <div class="page-card">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="equipmentTableBody"></tbody>
                        </table>
                        <div class="pagination" id="equipPagination"></div>
                    </div>
                </div>

                <!-- STOCK TAB -->
                <div class="tab-content" id="stock-tab">
                    <div class="inventory-worth">
                        <div>
                            <h3>Total Inventory Worth</h3>
                            <p style="font-size:12px;color:var(--text-dim);">Based on retail prices × quantity</p>
                        </div>
                        <div class="value" id="totalInventoryWorth">₱0</div>
                    </div>
                    <div class="controls-row">
                        <div class="search-box"><i class="fas fa-search"></i><input type="text" id="stockSearch"
                                placeholder="Search products..."></div>
                        <select class="filter-select" id="stockTypeFilter">
                            <option value="all">All Types</option>
                            <option value="Supplements">Supplements</option>
                            <option value="Drinks">Drinks</option>
                            <option value="Snacks">Snacks</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Apparel">Apparel</option>
                        </select>
                    </div>
                    <div class="page-card">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Type</th>
                                    <th>Retail Price</th>
                                    <th>Quantity</th>
                                    <th>Total Value</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="stockTableBody"></tbody>
                        </table>
                    </div>
                </div>

                <!-- EXPENSES TAB -->
                <div class="tab-content" id="expenses-tab">
                    <div class="expense-type-tabs">
                        <button class="expense-type-btn active" data-type="products">Product Purchases</button>
                        <button class="expense-type-btn" data-type="bills">Bills & Utilities</button>
                    </div>
                    <div class="page-card">
                        <table class="data-table" id="expenseProductTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Last Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="expenseProductBody"></tbody>
                        </table>
                        <table class="data-table" id="expenseBillTable" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Bill Name</th>
                                    <th>Amount</th>
                                    <th>Date & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="expenseBillBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODALS -->
    <div class="modal-backdrop" id="equipmentModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3 id="equipModalTitle">Add Equipment</h3><button class="modal-close"
                    onclick="closeModal('equipmentModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-content">
                <form id="equipmentForm">
                    <input type="hidden" id="equipEditId">
                    <div class="form-group"><label>Name</label><input type="text" id="equipName" class="form-input"
                            required></div>
                    <div class="form-split">
                        <div class="form-group"><label>Category</label><select id="equipCategory" class="form-input"
                                required>
                                <option value="">Select</option>
                                <option>Cardio</option>
                                <option>Strength</option>
                                <option>Free Weights</option>
                                <option>Machines</option>
                            </select></div>
                        <div class="form-group"><label>Location</label><input type="text" id="equipLocation"
                                class="form-input" placeholder="e.g., Main Floor"></div>
                    </div>
                    <div class="form-group"><label>Status</label><select id="equipStatus" class="form-input">
                            <option value="operational">Operational</option>
                            <option value="maintenance">Needs Maintenance</option>
                            <option value="missing">Missing</option>
                        </select></div>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Equipment</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-backdrop" id="stockModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3 id="stockModalTitle">Add Product</h3><button class="modal-close"
                    onclick="closeModal('stockModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-content">
                <form id="stockForm">
                    <input type="hidden" id="stockEditId">
                    <div class="form-group"><label>Product Name</label><input type="text" id="stockName"
                            class="form-input" required></div>
                    <div class="form-split">
                        <div class="form-group"><label>Type</label><select id="stockType" class="form-input" required>
                                <option value="">Select</option>
                                <option>Supplements</option>
                                <option>Drinks</option>
                                <option>Snacks</option>
                                <option>Accessories</option>
                                <option>Apparel</option>
                            </select></div>
                        <div class="form-group"><label>Retail Price (₱)</label><input type="number" id="stockPrice"
                                class="form-input" min="0" step="0.01" required></div>
                    </div>
                    <div class="form-group"><label>Quantity</label><input type="number" id="stockQty" class="form-input"
                            min="0" required></div>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Product</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-backdrop" id="expenseModal">
        <div class="modal-box">
            <div class="modal-head">
                <h3 id="expenseModalTitle">Add Expense</h3><button class="modal-close"
                    onclick="closeModal('expenseModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-content">
                <form id="expenseForm">
                    <input type="hidden" id="expenseEditId">
                    <input type="hidden" id="expenseType" value="product">
                    <div id="productExpenseFields">
                        <div class="form-group"><label>Name</label><input type="text" id="expenseName"
                                class="form-input"></div>
                        <div class="form-split">
                            <div class="form-group"><label>Category</label><select id="expenseCategory"
                                    class="form-input">
                                    <option>Restock</option>
                                    <option>Supplies</option>
                                    <option>Repairs</option>
                                    <option>Other</option>
                                </select></div>
                            <div class="form-group"><label>Unit Price (₱)</label><input type="number" id="expensePrice"
                                    class="form-input" min="0" step="0.01"></div>
                        </div>
                        <div class="form-group"><label>Quantity</label><input type="number" id="expenseQty"
                                class="form-input" min="1" value="1"></div>
                    </div>
                    <div id="billExpenseFields" style="display:none;">
                        <div class="form-group"><label>Bill Name</label><input type="text" id="billName"
                                class="form-input"></div>
                        <div class="form-group"><label>Amount (₱)</label><input type="number" id="billAmount"
                                class="form-input" min="0" step="0.01"></div>
                    </div>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Expense</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../../js/inventory.js"></script>
</body>

</html>