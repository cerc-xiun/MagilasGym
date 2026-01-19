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
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
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

        ul {
            list-style: none;
        }
    </style>
</head>

<body>
    <div class="portal-layout">
        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../assets/images/logo.png" alt="Magilas Gym" class="sidebar-logo">
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
                    <a href="inventory.php" class="nav-item">
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
                    <a href="../auth/login.php" class="user-logout" title="Logout">
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
                    <a href="scan.php" class="action-btn animate-scale-in">
                        <i class="fas fa-expand"></i>
                        <span>Scan QR</span>
                    </a>
                    <a href="search.php" class="action-btn animate-scale-in">
                        <i class="fas fa-search"></i>
                        <span>Lookup</span>
                    </a>
                    <a href="activate.php" class="action-btn animate-scale-in">
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
    <script>
        // Demo Data
        let members = [
            { name: 'John Doe', initials: 'JD', time: '10 mins ago', plan: 'Monthly' },
            { name: 'Jane Smith', initials: 'JS', time: '45 mins ago', plan: 'Monthly' },
            { name: 'Mike Johnson', initials: 'MJ', time: '1 hour ago', plan: 'Day Pass' },
            { name: 'Sarah Connor', initials: 'SC', time: '2 hours ago', plan: 'Monthly' }
        ];

        let activities = [
            { type: 'gold', icon: 'fa-crown', title: 'Membership Activated', desc: 'Sarah Connor - Monthly Plan', time: 'Just now' },
            { type: 'green', icon: 'fa-sign-in-alt', title: 'Member Check-in', desc: 'John Doe scanned QR', time: '10 mins ago' },
            { type: 'orange', icon: 'fa-exclamation-circle', title: 'Issue Reported', desc: 'Treadmill #2 belt slipping', time: '1 hour ago' },
            { type: 'red', icon: 'fa-ban', title: 'Payment Failed', desc: 'Guest entry declined', time: '2 hours ago' }
        ];

        let equipment = [
            { id: 1, name: 'Treadmill #1' }, { id: 2, name: 'Treadmill #2' }, { id: 3, name: 'Treadmill #3' },
            { id: 4, name: 'Bench Press' }, { id: 5, name: 'Incline Bench' }, { id: 6, name: 'Cable Machine' },
            { id: 7, name: 'Leg Press' }, { id: 8, name: 'Rowing Machine' }, { id: 9, name: 'Squat Rack' }
        ];

        let issues = [
            { id: 1, equip: 'Treadmill #2', priority: 'medium', desc: 'Belt slipping during high-speed runs.', time: '1 hour ago' },
            { id: 2, equip: 'Cable Machine', priority: 'high', desc: 'Frayed cable - safety concern!', time: '3 hours ago' }
        ];

        let expenses = [
            { id: 1, cat: 'Product Restock', amount: 850, desc: 'Protein bars & drinks' },
            { id: 2, cat: 'Miscellaneous', amount: 350, desc: 'Cleaning supplies' }
        ];

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('dateDisplay').textContent = new Date().toLocaleDateString('en-US', {
                weekday: 'long', month: 'short', day: 'numeric', year: 'numeric'
            });
            renderAll();
        });

        function renderAll() {
            renderMembers();
            renderActivities();
            renderMaintenance();
            renderExpenses();
            renderEquipment();
            updateStats();
        }

        function renderMembers() {
            const el = document.getElementById('membersPanel');
            el.innerHTML = members.length ? members.map(m => `
                <div class="member-row">
                    <div class="member-initials">${m.initials}</div>
                    <div class="member-details">
                        <h5>${m.name}</h5>
                        <small>${m.plan} • ${m.time}</small>
                    </div>
                    <span class="member-badge">Active</span>
                </div>
            `).join('') : '<div class="empty-state"><i class="fas fa-users"></i><p>No one in the gym</p></div>';
            document.getElementById('activeLabel').textContent = `${members.length} Active`;
        }

        function renderActivities() {
            document.getElementById('activityPanel').innerHTML = activities.map(a => `
                <div class="activity-row">
                    <div class="activity-dot ${a.type}"><i class="fas ${a.icon}"></i></div>
                    <div class="activity-text">
                        <h5>${a.title}</h5>
                        <p>${a.desc}</p>
                    </div>
                    <span class="activity-time">${a.time}</span>
                </div>
            `).join('');
        }

        function renderMaintenance() {
            const el = document.getElementById('maintenancePanel');
            el.innerHTML = issues.length ? issues.map(i => `
                <div class="maintenance-row ${i.priority === 'high' ? 'urgent' : ''}">
                    <div class="maintenance-top">
                        <h5>${i.equip}</h5>
                        <button onclick="resolveIssue(${i.id})" title="Resolve"><i class="fas fa-check"></i></button>
                    </div>
                    <p class="maintenance-desc">${i.desc}</p>
                    <span class="maintenance-time"><i class="fas fa-clock"></i> ${i.time}</span>
                </div>
            `).join('') : '<div class="empty-state"><i class="fas fa-check-circle"></i><p>All equipment operational</p></div>';
        }

        function renderExpenses() {
            const el = document.getElementById('expensePanel');
            el.innerHTML = expenses.length ? expenses.map(e => `
                <div class="expense-row">
                    <div class="expense-label">
                        <h5>${e.cat}</h5>
                        <small>${e.desc}</small>
                    </div>
                    <span class="expense-value">₱${e.amount.toLocaleString()}</span>
                </div>
            `).join('') : '<div class="empty-state"><i class="fas fa-receipt"></i><p>No expenses today</p></div>';
        }

        function renderEquipment() {
            document.getElementById('equipList').innerHTML = equipment.map(eq => `
                <span class="equipment-chip">
                    <i class="fas fa-dumbbell"></i> ${eq.name}
                    <button onclick="removeEquip(${eq.id})"><i class="fas fa-times"></i></button>
                </span>
            `).join('');

            document.getElementById('reportEquip').innerHTML = '<option value="">Select equipment</option>' +
                equipment.map(eq => `<option value="${eq.name}">${eq.name}</option>`).join('');
        }

        function updateStats() {
            document.getElementById('inGymCount').textContent = members.length;
            document.getElementById('issuesCount').textContent = issues.length;
            document.getElementById('issuesBadge').textContent = issues.length;
            const total = expenses.reduce((s, e) => s + e.amount, 0);
            document.getElementById('expenseVal').textContent = '₱' + total.toLocaleString();
        }

        // Modals
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

        // Forms
        document.getElementById('addEquipForm').addEventListener('submit', e => {
            e.preventDefault();
            const name = document.getElementById('newEquipName').value.trim();
            if (name) {
                equipment.push({ id: Date.now(), name });
                renderEquipment();
                document.getElementById('newEquipName').value = '';
            }
        });

        document.getElementById('reportForm').addEventListener('submit', e => {
            e.preventDefault();
            const equip = document.getElementById('reportEquip').value;
            const priority = document.getElementById('reportPriority').value;
            const desc = document.getElementById('reportDesc').value.trim();
            if (equip && desc) {
                issues.unshift({ id: Date.now(), equip, priority, desc, time: 'Just now' });
                renderMaintenance();
                updateStats();
                closeModal('reportModal');
                e.target.reset();
            }
        });

        document.getElementById('expenseForm').addEventListener('submit', e => {
            e.preventDefault();
            const cat = document.getElementById('expenseCat').value;
            const amount = parseFloat(document.getElementById('expenseAmt').value);
            const desc = document.getElementById('expenseDesc').value.trim() || cat;
            if (cat && amount > 0) {
                expenses.unshift({ id: Date.now(), cat, amount, desc });
                renderExpenses();
                updateStats();
                closeModal('expenseModal');
                e.target.reset();
            }
        });

        function removeEquip(id) {
            equipment = equipment.filter(eq => eq.id !== id);
            renderEquipment();
        }

        function resolveIssue(id) {
            issues = issues.filter(i => i.id !== id);
            renderMaintenance();
            updateStats();
        }

        // Mobile
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.getElementById('menuBtn');
            if (window.innerWidth <= 1024 &&
                sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) &&
                !menuBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>

</html>