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
    <link rel="stylesheet" href="../../../css/dashboard.css">
    <link rel="icon" type="image/png" href="../../../assets/images/logo.png">
    <link rel="stylesheet" href="inventory.css">
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-label">Overview</div>
                    <a href="../dashboard/dashboard.php" class="nav-item"><i class="fas fa-th-large"></i> <span>Dashboard</span></a>
                </div>

                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="../members/members.php" class="nav-item">
                        <i class="fas fa-users"></i> <span>Members</span>
                    </a>
                    <a href="../inventory/inventory.php" class="nav-item active"><i class="fas fa-boxes-stacked"></i>
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

    <script src="../../../js/inventory.js"></script>
    <script src="inventory.js"></script>
</body>

</html>
