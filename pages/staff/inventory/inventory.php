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
                <div class="header-date"><i class="fas fa-calendar-alt"></i> <span id="dateDisplay"></span></div>
            </header>

            <!-- Action Bar -->
            <div class="inventory-actions">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" id="inventorySearch" placeholder="Search items..." oninput="filterInventory()">
                </div>

                <div class="action-buttons">
                    <button class="btn-action" onclick="openCategorySettings()" title="Manage Categories">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </button>

                    <button class="btn-action btn-filter" onclick="toggleFilterDropdown()" title="Filter by Category">
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

                    <button class="btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        <span>Add Item</span>
                    </button>
                </div>
            </div>

            <!-- Inventory Table -->
            <div class="table-container">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price (₱)</th>
                            <th>Total Value (₱)</th>
                            <th class="actions-col"></th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
                <div class="empty-state" id="emptyState">
                    <i class="fas fa-boxes"></i>
                    <h3>No Items Found</h3>
                    <p>Start by adding your first inventory item</p>
                </div>
            </div>
        </main>
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