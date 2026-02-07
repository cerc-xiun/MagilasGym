<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | Magilas Gym</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/dashboard.css">
    <link rel="stylesheet" href="../members/sidebar_premium.css">
    <link rel="stylesheet" href="inventory.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../../assets/images/logo.png">
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <!-- Staff Portal Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../../assets/images/logo.png" alt="Magilas Gym Logo" class="sidebar-logo">
                <div class="sidebar-brand">
                    <span class="brand-main">STAFF'S</span>
                    <span class="brand-sub">PORTAL</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="#" class="nav-item" onclick="alert('Dashboard - Coming Soon'); return false;">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>

                <a href="../members/members.php" class="nav-item">
                    <i class="fas fa-desktop"></i>
                    <span>Front Desk Operations</span>
                </a>

                <a href="../members/pending.php" class="nav-item">
                    <i class="fas fa-user-clock"></i>
                    <span>Pending Applications</span>
                </a>

                <a href="inventory.php" class="nav-item active">
                    <i class="fas fa-boxes"></i>
                    <span>Inventory</span>
                </a>

                <a href="../equipment/equipment.php" class="nav-item">
                    <i class="fas fa-wrench"></i>
                    <span>Maintenance</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="../../auth/login.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <h1 class="page-title">Inventory <span class="text-accent">Management</span></h1>
                </div>
                <div class="header-right">
                    <div class="header-date"><i class="fas fa-calendar-alt"></i> <span id="dateDisplay"></span></div>
                </div>
            </header>

            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="shop-products" onclick="switchTab('shop-products')">
                    <i class="fas fa-shopping-bag"></i> Shop Products
                </button>
                <button class="tab-btn" data-tab="gym-inventory" onclick="switchTab('gym-inventory')">
                    <i class="fas fa-warehouse"></i> Gym Inventory
                </button>
                <button class="tab-btn" data-tab="restocking" onclick="switchTab('restocking')">
                    <i class="fas fa-dolly"></i> Restocking Log
                </button>
                <button class="tab-btn" data-tab="expenses" onclick="switchTab('expenses')">
                    <i class="fas fa-receipt"></i> Expenses
                </button>
                <button class="tab-btn" data-tab="sales" onclick="switchTab('sales')">
                    <i class="fas fa-chart-line"></i> Sales History
                </button>
            </div>

            <!-- SHOP PRODUCTS TAB -->
            <div class="tab-content active" id="shop-products-tab">
                <!-- Action Bar -->
                <div class="inventory-actions">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="shopProductsSearch" placeholder="Search shop products..."
                            oninput="filterShopProducts()">
                    </div>

                    <div class="action-buttons">
                        <button class="btn-action" onclick="openCategorySettings()" title="Manage Categories">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </button>

                        <button class="btn-action btn-filter" onclick="toggleFilterDropdown()"
                            title="Filter by Category">
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </button>
                        <div class="filter-dropdown" id="filterDropdown">
                            <div class="filter-option active" onclick="selectFilter('all')">
                                <i class="fas fa-th"></i> All Items
                            </div>
                            <!-- Categories populated by JS -->
                        </div>

                        <button class="btn-primary" onclick="openUnifiedAddModal()">
                            <i class="fas fa-plus"></i>
                            <span>Add</span>
                        </button>
                    </div>
                </div>

                <!-- Shop Products Table -->
                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Price (₱)</th>
                                <th>Total Value (₱)</th>
                                <th style="width: 100px;">Visible</th>
                                <th class="actions-col"></th>
                            </tr>
                        </thead>
                        <tbody id="shopProductsTableBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                    <div class="empty-state" id="shopProductsEmptyState">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No Shop Products</h3>
                        <p>Add products to sell in the gym shop</p>
                    </div>
                </div>
            </div>

            <!-- GYM INVENTORY TAB -->
            <div class="tab-content" id="gym-inventory-tab">
                <!-- Action Bar -->
                <div class="inventory-actions">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="gymInventorySearch" placeholder="Search gym supplies..."
                            oninput="filterGymInventory()">
                    </div>

                    <div class="action-buttons">
                        <button class="btn-primary" onclick="openUnifiedAddModal()">
                            <i class="fas fa-plus"></i>
                            <span>Add Supply</span>
                        </button>
                    </div>
                </div>

                <!-- Gym Inventory Table -->
                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Unit Cost (₱)</th>
                                <th>Total Value (₱)</th>
                                <th class="actions-col"></th>
                            </tr>
                        </thead>
                        <tbody id="gymInventoryTableBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                    <div class="empty-state" id="gymInventoryEmptyState">
                        <i class="fas fa-warehouse"></i>
                        <h3>No Gym Supplies</h3>
                        <p>Track cleaning supplies, office items, equipment parts</p>
                    </div>
                </div>
            </div>

            <!-- RESTOCKING LOG TAB -->
            <div class="tab-content" id="restocking-tab">
                <div class="tab-info-banner">
                    <i class="fas fa-info-circle"></i>
                    <span><strong>Audit Trail:</strong> This log tracks all restocking activities for accounting
                        purposes. Adding a restock record updates shop/gym product quantities automatically.</span>
                </div>

                <div class="inventory-actions">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="restockingSearch" placeholder="Search restocking logs..."
                            oninput="filterRestocking()">
                    </div>
                    <button class="btn-primary" onclick="openUnifiedAddModal()">
                        <i class="fas fa-plus"></i>
                        <span>Add Restock</span>
                    </button>
                </div>

                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Quantity Added</th>
                                <th>Cost (₱)</th>
                                <th>Supplier</th>
                                <th class="actions-col"></th>
                            </tr>
                        </thead>
                        <tbody id="restockingTableBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                    <div class="empty-state" id="restockingEmptyState">
                        <i class="fas fa-dolly"></i>
                        <h3>No Restocking Logs</h3>
                        <p>Record product restocking activities for audit trail</p>
                    </div>
                </div>
            </div>

            <!-- EXPENSES TAB -->
            <div class="tab-content" id="expenses-tab">
                <div class="inventory-actions">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="expensesSearch" placeholder="Search expenses..."
                            oninput="filterExpenses()">
                    </div>
                    <button class="btn-primary" onclick="openUnifiedAddModal()">
                        <i class="fas fa-plus"></i>
                        <span>Add Expense</span>
                    </button>
                </div>

                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Vendor</th>
                                <th>Amount (₱)</th>
                                <th class="actions-col"></th>
                            </tr>
                        </thead>
                        <tbody id="expensesTableBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                    <div class="empty-state" id="expensesEmptyState">
                        <i class="fas fa-receipt"></i>
                        <h3>No Expenses Recorded</h3>
                        <p>Start tracking gym expenses</p>
                    </div>
                </div>
            </div>

            <!-- SALES HISTORY TAB -->
            <div class="tab-content" id="sales-tab">
                <div class="inventory-actions">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="salesSearch" placeholder="Search sales..." oninput="filterSales()">
                    </div>
                    <div class="action-buttons">
                        <button class="btn-action" onclick="exportSales()">
                            <i class="fas fa-download"></i>
                            <span>Export</span>
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Date & Time</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total (₱)</th>
                                <th>Payment</th>
                                <th class="actions-col"></th>
                            </tr>
                        </thead>
                        <tbody id="salesTableBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                    <div class="empty-state" id="salesEmptyState">
                        <i class="fas fa-chart-line"></i>
                        <h3>No Sales Recorded</h3>
                        <p>Sales from the shop will appear here</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Toast Notification -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- ============================= -->
    <!-- SHOP POS MODAL -->
    <!-- ============================= -->
    <div class="modal-overlay shop-modal" id="shopModal">
        <div class="shop-container">
            <!-- Header -->
            <div class="shop-header">
                <div class="shop-header-left">
                    <i class="fas fa-shopping-cart"></i>
                    <h2>Shop POS</h2>
                </div>
                <button class="modal-close" onclick="closeShopInterface()" title="Close Shop">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Main POS Layout -->
            <div class="shop-layout">
                <!-- Left Panel: Products Grid -->
                <div class="products-panel">
                    <div class="products-header">
                        <div class="search-wrapper">
                            <i class="fas fa-search"></i>
                            <input type="text" id="posProductSearch" placeholder="Search products..."
                                oninput="filterShopPOS()">
                        </div>
                        <div class="products-count" id="posProductCount">
                            <i class="fas fa-box"></i>
                            <span>0 products</span>
                        </div>
                    </div>

                    <div class="products-grid" id="posProductsGrid">
                        <!-- Populated by JS -->
                    </div>

                    <div class="empty-state" id="posEmptyState">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No Products Available</h3>
                        <p>Add shop products with visibility enabled</p>
                    </div>
                </div>

                <!-- Right Panel: Cart & Checkout -->
                <div class="cart-panel">
                    <!-- Cart Header -->
                    <div class="cart-header">
                        <h3><i class="fas fa-shopping-basket"></i> Current Order</h3>
                        <button class="btn-clear-cart" onclick="clearCart()" title="Clear Cart">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <!-- Cart Items -->
                    <div class="cart-items" id="cartItems">
                        <div class="empty-cart">
                            <i class="fas fa-cart-plus"></i>
                            <p>Add products to start</p>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span class="summary-value" id="cartSubtotal">₱0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (0%):</span>
                            <span class="summary-value" id="cartTax">₱0.00</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span class="summary-value" id="cartTotal">₱0.00</span>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="customer-section">
                        <label for="customerName">
                            <i class="fas fa-user"></i> Customer Name (Optional)
                        </label>
                        <input type="text" id="customerName" placeholder="Enter customer name">
                    </div>

                    <!-- Payment Method -->
                    <div class="payment-section">
                        <label><i class="fas fa-credit-card"></i> Payment Method</label>
                        <div class="payment-methods">
                            <button class="payment-btn active" data-method="cash" onclick="selectPaymentMethod('cash')">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Cash</span>
                            </button>
                            <button class="payment-btn" data-method="gcash" onclick="selectPaymentMethod('gcash')">
                                <i class="fas fa-mobile-alt"></i>
                                <span>GCash</span>
                            </button>
                            <button class="payment-btn" data-method="card" onclick="selectPaymentMethod('card')">
                                <i class="fas fa-credit-card"></i>
                                <span>Card</span>
                            </button>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <button class="btn-checkout" onclick="processCheckout()" id="checkoutBtn" disabled>
                        <i class="fas fa-check-circle"></i>
                        <span>Complete Sale</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- RECEIPT MODAL -->
    <!-- ============================= -->
    <div class="modal-overlay receipt-modal" id="receiptModal">
        <div class="receipt-container">
            <div class="receipt-header">
                <h2>Receipt</h2>
                <button class="modal-close" onclick="closeReceiptModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="receipt-content" id="receiptContent">
                <!-- Populated by JS -->
            </div>

            <div class="receipt-actions">
                <button class="btn-secondary" onclick="closeReceiptModal()">
                    <i class="fas fa-times"></i> Close
                </button>
                <button class="btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>

    <!-- Unified Add Selection Modal -->
    <div class="modal-overlay" id="unifiedAddModal">
        <div class="modal-content modal-small">
            <div class="modal-header">
                <h2>What would you like to add?</h2>
                <button class="modal-close" onclick="closeUnifiedAddModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="add-type-grid">
                    <div class="add-type-card" onclick="selectAddType('shop-product')">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>Shop Product</h3>
                        <p>Sellable items (supplements, merch)</p>
                    </div>
                    <div class="add-type-card" onclick="selectAddType('gym-supply')">
                        <i class="fas fa-warehouse"></i>
                        <h3>Gym Supply</h3>
                        <p>Cleaning, office, equipment parts</p>
                    </div>
                    <div class="add-type-card" onclick="selectAddType('expense')">
                        <i class="fas fa-receipt"></i>
                        <h3>Expense</h3>
                        <p>Log gym expense</p>
                    </div>
                    <div class="add-type-card" onclick="selectAddType('restock')">
                        <i class="fas fa-dolly"></i>
                        <h3>Restock</h3>
                        <p>Record restock activity</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expense Modal -->
    <div class="modal-overlay" id="expenseModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="expenseModalTitle">Add Expense</h2>
                <button class="modal-close" onclick="closeExpenseModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="expenseForm" onsubmit="saveExpense(event)">
                    <div class="form-group">
                        <label for="expenseCategory">Category <span class="required">*</span></label>
                        <div class="custom-select">
                            <select id="expenseCategory" required>
                                <option value="">Select category</option>
                                <option value="Utilities">Utilities</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Supplies">Supplies</option>
                                <option value="Payroll">Payroll</option>
                                <option value="Rent">Rent</option>
                                <option value="Other">Other</option>
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="expenseDescription">Description <span class="required">*</span></label>
                        <textarea id="expenseDescription" required placeholder="Enter expense description"
                            rows="3"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="expenseAmount">Amount (₱) <span class="required">*</span></label>
                            <input type="number" id="expenseAmount" required min="0" step="0.01" placeholder="0.00">
                        </div>

                        <div class="form-group">
                            <label for="expenseVendor">Vendor</label>
                            <input type="text" id="expenseVendor" placeholder="Enter vendor name">
                        </div>
                    </div>

                    <input type="hidden" id="editExpenseId">

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="closeExpenseModal()">Cancel</button>
                        <button type="submit" class="btn-primary">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Restock Modal -->
    <div class="modal-overlay" id="restockModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="restockModalTitle">Add Restock</h2>
                <button class="modal-close" onclick="closeRestockModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="restockForm" onsubmit="saveRestock(event)">
                    <div class="form-group">
                        <label for="restockProduct">Product <span class="required">*</span></label>
                        <div class="custom-select">
                            <select id="restockProduct" required onchange="updateRestockProductInfo()">
                                <option value="">Select product from inventory</option>
                                <!-- Populated by JS -->
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="restockQuantity">Quantity Added <span class="required">*</span></label>
                            <input type="number" id="restockQuantity" required min="1" step="1" placeholder="0">
                        </div>

                        <div class="form-group">
                            <label for="restockCost">Total Cost (₱) <span class="required">*</span></label>
                            <input type="number" id="restockCost" required min="0" step="0.01" placeholder="0.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="restockSupplier">Supplier</label>
                        <input type="text" id="restockSupplier" placeholder="Enter supplier name">
                    </div>

                    <input type="hidden" id="editRestockId">

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="closeRestockModal()">Cancel</button>
                        <button type="submit" class="btn-primary">Save Restock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Add/Edit Item Modal -->
    <div class="modal-overlay" id="itemModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Item</h2>
                <button class="modal-close" onclick="closeItemModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="itemForm" onsubmit="saveItem(event)">
                    <div class="form-group">
                        <label for="itemName">Item Name <span class="required">*</span></label>
                        <input type="text" id="itemName" required placeholder="Enter item name">
                        <span class="error-msg" id="nameError"></span>
                    </div>

                    <div class="form-group">
                        <label for="itemType">Item Type <span class="required">*</span></label>
                        <div class="custom-select">
                            <select id="itemType" required>
                                <option value="">Select type</option>
                                <option value="shop">Shop Product (Sellable)</option>
                                <option value="supply">Gym Supply (Non-sellable)</option>
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="itemCategory">Category <span class="required">*</span></label>
                        <div class="custom-select">
                            <select id="itemCategory" required>
                                <option value="">Select category</option>
                                <!-- Populated by JS -->
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="itemQuantity">Quantity <span class="required">*</span></label>
                            <input type="number" id="itemQuantity" required min="0" step="1" placeholder="0"
                                oninput="calculateTotal()">
                        </div>

                        <div class="form-group">
                            <label for="itemPrice">Price (₱) <span class="required">*</span></label>
                            <input type="number" id="itemPrice" required min="0" step="0.01" placeholder="0.00"
                                oninput="calculateTotal()">
                        </div>
                    </div>

                    <div class="form-group total-display">
                        <label>Total Value</label>
                        <div class="total-value">₱ <span id="totalValue">0.00</span></div>
                    </div>

                    <input type="hidden" id="editItemId">

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" onclick="closeItemModal()">Cancel</button>
                        <button type="submit" class="btn-primary">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Settings Modal -->
    <div class="modal-overlay" id="categoryModal">
        <div class="modal-content modal-medium">
            <div class="modal-header">
                <h2>Category Settings</h2>
                <button class="modal-close" onclick="closeCategoryModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="category-add">
                    <input type="text" id="newCategory" placeholder="New category name">
                    <button class="btn-primary" onclick="addCategory()">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>

                <div class="category-list" id="categoryList">
                    <!-- Populated by JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-content modal-small">
            <div class="modal-header">
                <h2>Confirm Delete</h2>
                <button class="modal-close" onclick="closeDeleteModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="delete-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Are you sure you want to delete <strong id="deleteItemName"></strong>?</p>
                    <p class="warning-text">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    <button class="btn-danger" onclick="confirmDelete()">Delete Item</button>
                </div>
            </div>
        </div>
    </div>

    <script src="inventory.js"></script>
</body>

</html>