<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Maintenance | Magilas Gym</title>

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
    <link rel="stylesheet" href="equipment.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../../assets/images/logo.png">
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <!-- Staff Portal Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>

            <nav class="sidebar-nav">
                <a href="#" class="nav-item" onclick="alert('Dashboard - Coming Soon'); return false;">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <a href="../members/members.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Members</span>
                </a>
                <a href="../members/pending.php" class="nav-item">
                    <i class="fas fa-clock"></i>
                    <span>Pending Apps</span>
                </a>
                <a href="../inventory/inventory.php" class="nav-item">
                    <i class="fas fa-boxes"></i>
                    <span>Inventory</span>
                </a>
                <a href="equipment.php" class="nav-item active">
                    <i class="fas fa-dumbbell"></i>
                    <span>Maintenance</span>
                </a>
            </nav>

            <a href="../../auth/login.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="main-header">
                <h1 class="page-title">Equipment <span class="text-accent">Maintenance</span></h1>
            </header>

            <!-- Statistics Dashboard -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value" id="totalEquipment">0</div>
                    <div class="stat-label">Total Equipment</div>
                </div>
                <div class="stat-card success">
                    <div class="stat-value" id="excellentCount">0</div>
                    <div class="stat-label">Working Fine</div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-value" id="needsAttentionCount">0</div>
                    <div class="stat-label">Needs Attention</div>
                </div>
                <div class="stat-card danger">
                    <div class="stat-value" id="criticalCount">0</div>
                    <div class="stat-label">Critical Issues</div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="equipment-actions">
                <div class="search-filter-group">
                    <!-- Search -->
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search equipment...">
                    </div>

                    <!-- Status Filters -->
                    <div class="filter-group">
                        <button class="filter-btn active" onclick="filterByStatus('all')">All</button>
                        <button class="filter-btn" onclick="filterByStatus('excellent')">Excellent</button>
                        <button class="filter-btn" onclick="filterByStatus('issues')">Issues</button>
                        <button class="filter-btn" onclick="filterByStatus('critical')">Critical</button>
                    </div>
                </div>

                <!-- Add Button -->
                <button class="btn-add-equipment" onclick="openAddModal()">
                    <i class="fas fa-plus"></i>
                    Add Equipment
                </button>
            </div>

            <!-- Equipment Table -->
            <div class="equipment-table-container">
                <table class="equipment-table">
                    <thead>
                        <tr>
                            <th class="col-id">Equipment ID</th>
                            <th class="col-name">Name</th>
                            <th class="col-category">Category</th>
                            <th class="col-status">Status</th>
                            <th class="col-location">Location</th>
                            <th class="col-maintenance">Last Maintenance</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="equipmentTableBody">
                        <!-- Populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Add Equipment Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Equipment</h2>
                <button class="modal-close" onclick="closeModal('addModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEquipmentForm" onsubmit="addEquipment(event)">
                    <div class="form-group">
                        <label>Equipment ID <span class="required">*</span></label>
                        <input type="text" id="addEquipId" placeholder="e.g., TRDML-001" required>
                    </div>

                    <div class="form-group">
                        <label>Equipment Name <span class="required">*</span></label>
                        <input type="text" id="addEquipName" placeholder="e.g., Treadmill #1" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Category <span class="required">*</span></label>
                            <select id="addEquipCategory" required>
                                <option value="">Select category</option>
                                <option value="Cardio">Cardio</option>
                                <option value="Strength">Strength Machines</option>
                                <option value="Free Weights">Free Weights</option>
                                <option value="Machines">Other Machines</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status <span class="required">*</span></label>
                            <select id="addEquipStatus" required>
                                <option value="excellent">✅ Working Fine</option>
                                <option value="maintenance">⚠️ Needs Maintenance</option>
                                <option value="repair">🔧 Under Maintenance</option>
                                <option value="critical">❌ Critical/Broken</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" id="addEquipLocation" placeholder="e.g., Main Floor - Zone A">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Purchase Date</label>
                            <input type="date" id="addEquipPurchaseDate">
                        </div>

                        <div class="form-group">
                            <label>Last Maintenance</label>
                            <input type="date" id="addEquipLastMaintenance">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea id="addEquipNotes" placeholder="Additional notes about the equipment..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                <button class="btn-primary" onclick="document.getElementById('addEquipmentForm').requestSubmit()">
                    <i class="fas fa-plus"></i> Add Equipment
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Equipment Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Equipment</h2>
                <button class="modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEquipmentForm" onsubmit="saveEditEquipment(event)">
                    <input type="hidden" id="editEquipIndex">

                    <div class="form-group">
                        <label>Equipment ID <span class="required">*</span></label>
                        <input type="text" id="editEquipId" required>
                    </div>

                    <div class="form-group">
                        <label>Equipment Name <span class="required">*</span></label>
                        <input type="text" id="editEquipName" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Category <span class="required">*</span></label>
                            <select id="editEquipCategory" required>
                                <option value="">Select category</option>
                                <option value="Cardio">Cardio</option>
                                <option value="Strength">Strength Machines</option>
                                <option value="Free Weights">Free Weights</option>
                                <option value="Machines">Other Machines</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status <span class="required">*</span></label>
                            <select id="editEquipStatus" required>
                                <option value="excellent">✅ Working Fine</option>
                                <option value="maintenance">⚠️ Needs Maintenance</option>
                                <option value="repair">🔧 Under Maintenance</option>
                                <option value="critical">❌ Critical/Broken</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" id="editEquipLocation">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Purchase Date</label>
                            <input type="date" id="editEquipPurchaseDate">
                        </div>

                        <div class="form-group">
                            <label>Last Maintenance</label>
                            <input type="date" id="editEquipLastMaintenance">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea id="editEquipNotes"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button class="btn-primary" onclick="document.getElementById('editEquipmentForm').requestSubmit()">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal-overlay" id="statusModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Status</h2>
                <button class="modal-close" onclick="closeModal('statusModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm" onsubmit="saveStatusUpdate(event)">
                    <input type="hidden" id="statusEquipIndex">

                    <div class="form-group">
                        <label>Equipment: <strong id="statusEquipName"></strong></label>
                    </div>

                    <div class="form-group">
                        <label>New Status <span class="required">*</span></label>
                        <select id="statusNewStatus" required>
                            <option value="excellent">✅ Working Fine</option>
                            <option value="maintenance">⚠️ Needs Maintenance</option>
                            <option value="repair">🔧 Under Maintenance</option>
                            <option value="critical">❌ Critical/Broken</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea id="statusNotes" placeholder="Describe the status change..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal('statusModal')">Cancel</button>
                <button class="btn-primary" onclick="document.getElementById('updateStatusForm').requestSubmit()">
                    Update Status
                </button>
            </div>
        </div>
    </div>

    <!-- Maintenance Log Modal -->
    <div class="modal-overlay" id="maintenanceModal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2>Maintenance History</h2>
                <button class="modal-close" onclick="closeModal('maintenanceModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <h3 style="color: rgba(255,255,255,0.9); margin-bottom: 16px; font-size: 16px;">
                    <span id="maintenanceEquipName"></span>
                </h3>

                <!-- Add New Maintenance Record -->
                <form id="addMaintenanceForm" onsubmit="addMaintenanceRecord(event)"
                    style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <input type="hidden" id="maintenanceEquipIndex">

                    <h4 style="color: rgba(255,255,255,0.9); margin-bottom: 16px; font-size: 14px;">Add Maintenance
                        Record</h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Type</label>
                            <select id="maintenanceType">
                                <option value="routine">Routine Maintenance</option>
                                <option value="repair">Repair</option>
                                <option value="inspection">Inspection</option>
                                <option value="cleaning">Deep Cleaning</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" id="maintenanceDate" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="maintenanceDescription" placeholder="What was done..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Performed By</label>
                        <input type="text" id="maintenancePerformer" placeholder="e.g., Staff Member, Technician"
                            required>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%;">
                        <i class="fas fa-plus"></i> Add Record
                    </button>
                </form>

                <!-- Maintenance History List -->
                <h4 style="color: rgba(255,255,255,0.9); margin-bottom: 12px; font-size: 14px;">History</h4>
                <div class="maintenance-history" id="maintenanceHistory">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Delete</h2>
                <button class="modal-close" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="empty-state" style="padding: 20px;">
                    <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
                    <h3>Are you sure you want to delete this equipment?</h3>
                    <p><strong id="deleteEquipName"></strong></p>
                    <p style="margin-top: 12px; color: #ef4444;">This action cannot be undone.</p>
                </div>
                <input type="hidden" id="deleteEquipIndex">
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
                <button class="btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete Equipment
                </button>
            </div>
        </div>
    </div>

    <script src="equipment.js"></script>
</body>

</html>