<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Count | Magilas Gym</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/variables.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body class="dashboard-body">

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="stock.php" class="nav-item active">
                    <i class="fas fa-boxes"></i> <span>Stock Count</span>
                </a>
                <a href="audit.php" class="nav-item">
                    <i class="fas fa-file-invoice-dollar"></i> <span>Money Audit</span>
                </a>
                <a href="summary.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i> <span>Daily Report</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar"><i class="fas fa-user-cog"></i></div>
                    <div class="user-info">
                        <h4>Admin Staff</h4><span>Inventory/Audit</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Stock <span class="text-accent">Count</span></h1>
                <div class="header-actions">
                    <button id="add-drinks-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add Drinks</button>
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Submit Count</button>
                </div>
            </header>

            <div class="dash-card">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; color: #fff;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--color-border); text-align: left;">
                                <th style="padding: var(--space-4);">Product</th>
                                <th style="padding: var(--space-4);">System Count</th>
                                <th style="padding: var(--space-4);">Physical Count</th>
                                <th style="padding: var(--space-4);">Discrepancy</th>
                                <th style="padding: var(--space-4);">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td style="padding: var(--space-4);">
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:40px; height:40px; background:#333; border-radius:4px;"></div>
                                        <span>Sting</span>
                                    </div>
                                </td>
                                <td style="padding: var(--space-4);">24</td>
                                <td style="padding: var(--space-4);">
                                    <input type="number" class="form-input"
                                        style="width: 80px; padding: 5px 10px; color: white">
                                </td>
                                <td style="padding: var(--space-4);"><span class="text-success">0</span></td>
                                <td style="padding: var(--space-4);">
                                    <input type="text" class="form-input" placeholder="Optional"
                                        style="padding: 5px 10px; color: white" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <div id="add-drink-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2>Add New Drink</h2>
            <div class="form-group">
                <label>Drink Name</label>
                <input type="text" id="new-drink-name" class="form-input" placeholder="Enter drink name">
            </div>
            <div class="form-group">
                <label>System Count</label>
                <input type="number" id="new-system-count" class="form-input" value="0">
            </div>
            <div class="modal-actions">
                <button id="modal-back-btn" class="btn btn-secondary">Back</button>
                <button id="modal-add-btn" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>

    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--color-surface);
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            border: 1px solid var(--color-border);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: var(--color-text);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--color-text-secondary);
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid var(--color-border);
            background: var(--color-bg);
            color: var(--color-text);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-text);
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            background: rgba(255,255,255,0.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('add-drinks-btn');
            const modal = document.getElementById('add-drink-modal');
            const backBtn = document.getElementById('modal-back-btn');
            const modalAddBtn = document.getElementById('modal-add-btn');
            const tbody = document.querySelector('tbody');

            addBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
            });

            backBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                clearInputs();
            });

            modalAddBtn.addEventListener('click', function() {
                const name = document.getElementById('new-drink-name').value;
                const count = document.getElementById('new-system-count').value;

                if (name) {
                    addDrinkRow(name, count);
                    modal.style.display = 'none';
                    clearInputs();
                } else {
                    alert('Please enter a drink name');
                }
            });

            function clearInputs() {
                document.getElementById('new-drink-name').value = '';
                document.getElementById('new-system-count').value = '0';
            }

            function addDrinkRow(name, count) {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid rgba(255,255,255,0.05)';
                
                tr.innerHTML = `
                    <td style="padding: var(--space-4);">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:40px; height:40px; background:#333; border-radius:4px;"></div>
                            <span>${name}</span>
                        </div>
                    </td>
                    <td style="padding: var(--space-4);">${count}</td>
                    <td style="padding: var(--space-4);">
                        <input type="number" class="form-input" 
                            style="width: 80px; padding: 5px 10px; color: white">
                    </td>
                    <td style="padding: var(--space-4);"><span class="text-success">0</span></td>
                    <td style="padding: var(--space-4);">
                        <input type="text" class="form-input" placeholder="Optional"
                            style="padding: 5px 10px; color: white">
                    </td>
                `;
                
                tbody.appendChild(tr);
            }
        });
    </script>
</body>

</html>