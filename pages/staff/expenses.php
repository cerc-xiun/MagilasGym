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

        .date-filter {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .date-filter input {
            padding: 10px 16px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background: var(--bg-tertiary);
            color: var(--text-primary);
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
                    <a href="equipment.php" class="nav-item">
                        <i class="fas fa-dumbbell"></i> <span>Equipment</span>
                    </a>
                    <a href="expenses.php" class="nav-item active">
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

    <script>
        // Demo Data
        let expenses = [
            { id: 1, category: 'Product Restock', amount: 850, desc: 'Protein bars & energy drinks', date: '2026-01-19', time: '2 hours ago' },
            { id: 2, category: 'Miscellaneous', amount: 350, desc: 'Cleaning supplies', date: '2026-01-19', time: '4 hours ago' },
            { id: 3, category: 'Electric Bill', amount: 4500, desc: 'January electricity bill', date: '2026-01-18', time: 'Yesterday' },
            { id: 4, category: 'Water Bill', amount: 1200, desc: 'January water bill', date: '2026-01-18', time: 'Yesterday' },
            { id: 5, category: 'Equipment Repair', amount: 2500, desc: 'Treadmill motor replacement', date: '2026-01-17', time: '2 days ago' },
            { id: 6, category: 'Product Restock', amount: 1800, desc: 'Towels and toiletries', date: '2026-01-16', time: '3 days ago' }
        ];

        let currentCategory = 'all';

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            // Set default date to today
            document.getElementById('expenseDate').valueAsDate = new Date();
            renderExpenses();
            updateStats();
        });

        function getCategoryIcon(category) {
            const icons = {
                'Electric Bill': 'fa-bolt',
                'Water Bill': 'fa-droplet',
                'Product Restock': 'fa-box',
                'Equipment Repair': 'fa-wrench',
                'Miscellaneous': 'fa-tag'
            };
            return icons[category] || 'fa-receipt';
        }

        function getCategoryColor(category) {
            const colors = {
                'Electric Bill': '#f59e0b',
                'Water Bill': '#3b82f6',
                'Product Restock': '#10b981',
                'Equipment Repair': '#ef4444',
                'Miscellaneous': '#8b5cf6'
            };
            return colors[category] || '#6b7280';
        }

        function renderExpenses() {
            const list = document.getElementById('expenseList');
            let filtered = expenses;

            if (currentCategory !== 'all') {
                filtered = expenses.filter(e => e.category === currentCategory);
            }

            list.innerHTML = filtered.map(exp => `
                <div class="expense-item">
                    <div class="expense-icon" style="background: ${getCategoryColor(exp.category)}20; color: ${getCategoryColor(exp.category)};">
                        <i class="fas ${getCategoryIcon(exp.category)}"></i>
                    </div>
                    <div class="expense-details">
                        <h4>${exp.category}</h4>
                        <p>${exp.desc}</p>
                        <p style="font-size: 11px; color: var(--text-dim); margin-top: 4px;">
                            <i class="fas fa-calendar"></i> ${new Date(exp.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} • ${exp.time}
                        </p>
                    </div>
                    <div class="expense-amount">₱${exp.amount.toLocaleString()}</div>
                    <div class="expense-actions">
                        <button class="btn-icon danger" onclick="deleteExpense(${exp.id})" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');

            if (filtered.length === 0) {
                list.innerHTML = '<div class="empty-state"><i class="fas fa-receipt"></i><p>No expenses found</p></div>';
            }
        }

        function updateStats() {
            const today = new Date().toISOString().split('T')[0];
            const todayExpenses = expenses.filter(e => e.date === today);
            const todayTotal = todayExpenses.reduce((sum, e) => sum + e.amount, 0);

            // Week calculation (last 7 days)
            const weekAgo = new Date();
            weekAgo.setDate(weekAgo.getDate() - 7);
            const weekExpenses = expenses.filter(e => new Date(e.date) >= weekAgo);
            const weekTotal = weekExpenses.reduce((sum, e) => sum + e.amount, 0);

            // Month calculation
            const monthTotal = expenses.reduce((sum, e) => sum + e.amount, 0);

            document.getElementById('todayTotal').textContent = '₱' + todayTotal.toLocaleString();
            document.getElementById('weekTotal').textContent = '₱' + weekTotal.toLocaleString();
            document.getElementById('monthTotal').textContent = '₱' + monthTotal.toLocaleString();
        }

        function filterExpenses() {
            currentCategory = document.getElementById('categoryFilter').value;
            renderExpenses();
        }

        function deleteExpense(id) {
            if (confirm('Are you sure you want to delete this expense?')) {
                expenses = expenses.filter(e => e.id !== id);
                renderExpenses();
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

        // Form handler
        document.getElementById('addExpenseForm').addEventListener('submit', e => {
            e.preventDefault();
            const category = document.getElementById('expenseCategory').value;
            const amount = parseFloat(document.getElementById('expenseAmount').value);
            const desc = document.getElementById('expenseDesc').value.trim() || category;
            const date = document.getElementById('expenseDate').value;

            if (category && amount > 0 && date) {
                expenses.unshift({
                    id: Date.now(),
                    category,
                    amount,
                    desc,
                    date,
                    time: 'Just now'
                });
                renderExpenses();
                updateStats();
                closeModal('addExpenseModal');
                e.target.reset();
                document.getElementById('expenseDate').valueAsDate = new Date();
            }
        });

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>

</html>