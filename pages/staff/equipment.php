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
    <link rel="stylesheet" href="../../css/dashboard.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../assets/images/logo.png">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f7;
            color: #1a1a1a;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
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
    </style>
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-label">Overview</div>
                    <a href="dashboard.php" class="nav-item">
                        <i class="fas fa-th-large"></i> <span>Dashboard</span>
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-label">Members</div>
                    <a href="search.php" class="nav-item">
                        <i class="fas fa-search"></i> <span>Search Member</span>
                    </a>
                    <a href="scan.php" class="nav-item">
                        <i class="fas fa-qrcode"></i> <span>Scan Entry</span>
                    </a>
                    <a href="activate.php" class="nav-item">
                        <i class="fas fa-user-plus"></i> <span>New Membership</span>
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="equipment.php" class="nav-item active">
                        <i class="fas fa-dumbbell"></i> <span>Equipment</span>
                        <span class="nav-badge" id="issuesBadge">2</span>
                    </a>
                    <a href="expenses.php" class="nav-item">
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

    <script>
        // Demo Data
        let equipment = [
            { id: 1, name: 'Treadmill #1', category: 'Cardio', location: 'Cardio Zone', status: 'operational', issue: null },
            { id: 2, name: 'Treadmill #2', category: 'Cardio', location: 'Cardio Zone', status: 'issue', issue: { priority: 'medium', desc: 'Belt slipping during high-speed runs', time: '1 hour ago' } },
            { id: 3, name: 'Treadmill #3', category: 'Cardio', location: 'Cardio Zone', status: 'operational', issue: null },
            { id: 4, name: 'Bench Press', category: 'Strength', location: 'Free Weights', status: 'operational', issue: null },
            { id: 5, name: 'Incline Bench', category: 'Strength', location: 'Free Weights', status: 'operational', issue: null },
            { id: 6, name: 'Cable Machine', category: 'Machines', location: 'Machine Area', status: 'issue', issue: { priority: 'high', desc: 'Frayed cable - safety concern!', time: '3 hours ago' } },
            { id: 7, name: 'Leg Press', category: 'Machines', location: 'Machine Area', status: 'operational', issue: null },
            { id: 8, name: 'Rowing Machine', category: 'Cardio', location: 'Cardio Zone', status: 'operational', issue: null },
            { id: 9, name: 'Squat Rack', category: 'Strength', location: 'Free Weights', status: 'operational', issue: null }
        ];

        let currentFilter = 'all';

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            renderEquipment();
            updateStats();
        });

        function renderEquipment() {
            const list = document.getElementById('equipmentList');
            let filtered = equipment;

            if (currentFilter === 'operational') {
                filtered = equipment.filter(e => e.status === 'operational');
            } else if (currentFilter === 'issues') {
                filtered = equipment.filter(e => e.status === 'issue');
            }

            list.innerHTML = filtered.map(eq => `
                <div class="equipment-item">
                    <div class="equipment-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div class="equipment-details">
                        <h4>${eq.name}</h4>
                        <p>${eq.category} • ${eq.location}</p>
                        ${eq.issue ? `<p style="color: var(--danger); margin-top: 6px;"><i class="fas fa-exclamation-triangle"></i> ${eq.issue.desc}</p>` : ''}
                    </div>
                    <div class="equipment-status">
                        <span class="status-badge ${eq.status === 'operational' ? 'success' : 'danger'}">
                            ${eq.status === 'operational' ? 'Operational' : 'Has Issue'}
                        </span>
                    </div>
                    <div class="equipment-actions">
                        ${eq.status === 'operational' ? `
                            <button class="btn-icon" onclick="openReportModal(${eq.id})" title="Report Issue">
                                <i class="fas fa-exclamation-triangle"></i>
                            </button>
                        ` : `
                            <button class="btn-icon" onclick="resolveIssue(${eq.id})" title="Mark Resolved" style="color: var(--success);">
                                <i class="fas fa-check"></i>
                            </button>
                        `}
                        <button class="btn-icon danger" onclick="deleteEquipment(${eq.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function updateStats() {
            const total = equipment.length;
            const operational = equipment.filter(e => e.status === 'operational').length;
            const issues = equipment.filter(e => e.status === 'issue').length;

            document.getElementById('totalEquipment').textContent = total;
            document.getElementById('operationalCount').textContent = operational;
            document.getElementById('issuesCount').textContent = issues;
            document.getElementById('issuesBadge').textContent = issues;
        }

        function filterEquipment(filter) {
            currentFilter = filter;
            renderEquipment();
        }

        function openReportModal(id) {
            const eq = equipment.find(e => e.id === id);
            if (eq) {
                document.getElementById('reportEquipId').value = id;
                document.getElementById('reportEquipName').textContent = eq.name;
                openModal('reportModal');
            }
        }

        function resolveIssue(id) {
            const eq = equipment.find(e => e.id === id);
            if (eq) {
                eq.status = 'operational';
                eq.issue = null;
                renderEquipment();
                updateStats();
            }
        }

        function deleteEquipment(id) {
            if (confirm('Are you sure you want to delete this equipment?')) {
                equipment = equipment.filter(e => e.id !== id);
                renderEquipment();
                updateStats();
            }
        }

        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
            document.body.style.overflow = '';
        }

        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', e => { if (e.target === modal) closeModal(modal.id); });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.querySelectorAll('.modal-backdrop.show').forEach(m => closeModal(m.id));
        });

        // Form handlers
        document.getElementById('addEquipForm').addEventListener('submit', e => {
            e.preventDefault();
            const name = document.getElementById('equipName').value.trim();
            const category = document.getElementById('equipCategory').value;
            const location = document.getElementById('equipLocation').value.trim() || 'Main Floor';

            if (name && category) {
                equipment.push({
                    id: Date.now(),
                    name,
                    category,
                    location,
                    status: 'operational',
                    issue: null
                });
                renderEquipment();
                updateStats();
                closeModal('addEquipModal');
                e.target.reset();
            }
        });

        document.getElementById('reportForm').addEventListener('submit', e => {
            e.preventDefault();
            const id = parseInt(document.getElementById('reportEquipId').value);
            const priority = document.getElementById('reportPriority').value;
            const desc = document.getElementById('reportDesc').value.trim();

            const eq = equipment.find(e => e.id === id);
            if (eq && desc) {
                eq.status = 'issue';
                eq.issue = { priority, desc, time: 'Just now' };
                renderEquipment();
                updateStats();
                closeModal('reportModal');
                e.target.reset();
            }
        });

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>

</html>