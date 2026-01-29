<?php
session_start();
require_once '../../config/db.php';

// MOCK SESSION FOR TESTING (Remove in production if login is implemented)
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'admin'; // Change to 'admin' to test admin view
    $_SESSION['user_id'] = 1;
}

// Access Control
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'owner'])) {
    header("Location: ../auth/login.php");
    exit();
}

$role = $_SESSION['role'];
$error_msg = isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : '';
$success_msg = isset($_SESSION['success_msg']) ? $_SESSION['success_msg'] : '';

// Clear messages after fetching
unset($_SESSION['error_msg']);
unset($_SESSION['success_msg']);

// Handle Form Submissions
// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // ADD NEW PRODUCT (Owner Only)
    if (isset($_POST['action']) && $_POST['action'] === 'add_product') {
        if ($role !== 'owner') {
             $_SESSION['error_msg'] = "Unauthorized action.";
        } else {
            $product_name = trim($_POST['product_name']);
            $category = $_POST['category'];
            $stock_quantity = (int)$_POST['stock_quantity'];
            $unit_price = (float)$_POST['unit_price']; 

            if (empty($product_name)) {
                $_SESSION['error_msg'] = "Product name is required.";
            } else {
                // Check for duplicates
                $stmt = $conn->prepare("SELECT COUNT(*) FROM product WHERE product_name = ?");
                $stmt->execute([$product_name]);
                if ($stmt->fetchColumn() > 0) {
                    $_SESSION['error_msg'] = "Product with this name already exists.";
                } else {
                    try {
                        $stmt = $conn->prepare("INSERT INTO product (product_name, category, stock_quantity, unit_price) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$product_name, $category, $stock_quantity, $unit_price]);
                        $_SESSION['success_msg'] = "Product added successfully!";
                    } catch (PDOException $e) {
                        $_SESSION['error_msg'] = "Database Error: " . $e->getMessage();
                    }
                }
            }
        }
    }

    // UPDATE STOCK (Admin & Owner)
    if (isset($_POST['action']) && $_POST['action'] === 'update_stock') {
        $product_id = $_POST['product_id'];
        $physical_count = (int)$_POST['physical_count'];
        $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';

        try {
            $stmt = $conn->prepare("UPDATE product SET stock_quantity = ? WHERE product_id = ?");
            $stmt->execute([$physical_count, $product_id]);
            $_SESSION['success_msg'] = "Stock updated successfully.";
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Error updating stock: " . $e->getMessage();
        }
    }
    
    // Post-Redirect-Get to prevent form resubmission
    header("Location: stock.php");
    exit();
}

// Fetch All Products
$products = [];
try {
    $stmt = $conn->query("SELECT * FROM product ORDER BY category, product_name");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_msg = "Error fetching products: " . $e->getMessage();
}

?>
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
                        <h4><?php echo ucfirst($role); ?></h4><span>Inventory/Audit</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Stock <span class="text-accent">Count</span></h1>
                <div class="header-actions">
                    <?php if ($role === 'owner'): ?>
                    <button id="add-drinks-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Product</button>
                    <?php endif; ?>
                </div>
            </header>

            <?php if ($error_msg): ?>
                <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid #e74c3c; color: #e74c3c; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                    <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>

            <?php if ($success_msg): ?>
                <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid #2ecc71; color: #2ecc71; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                    <?php echo htmlspecialchars($success_msg); ?>
                </div>
            <?php endif; ?>

            <div class="dash-card">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; color: #fff;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--color-border); text-align: left;">
                                <th style="padding: var(--space-4);">Product</th>
                                <th style="padding: var(--space-4);">Category</th>
                                <th style="padding: var(--space-4);">System Count</th>
                                <th style="padding: var(--space-4);">Physical Count</th>
                                <th style="padding: var(--space-4);">Notes</th>
                                <th style="padding: var(--space-4);">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $product): ?>
                                <?php $form_id = 'form_' . $product['product_id']; ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: var(--space-4);">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="width:40px; height:40px; background:#333; border-radius:4px; display:flex; align-items:center; justify-content:center; color: #777;">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <span><?php echo htmlspecialchars($product['product_name']); ?></span>
                                        </div>
                                    </td>
                                    <td style="padding: var(--space-4); color: var(--color-text-secondary);"><?php echo htmlspecialchars($product['category']); ?></td>
                                    <td style="padding: var(--space-4);"><?php echo $product['stock_quantity']; ?></td>
                                    <td style="padding: var(--space-4);">
                                        <input type="number" name="physical_count" form="<?php echo $form_id; ?>" class="form-input"
                                            value="<?php echo $product['stock_quantity']; ?>"
                                            style="width: 80px; padding: 5px 10px; color: white">
                                    </td>
                                    <td style="padding: var(--space-4);">
                                        <input type="text" name="notes" form="<?php echo $form_id; ?>" class="form-input" 
                                            placeholder="Optional" style="padding: 5px 10px; color: white; width: 100%; min-width: 120px;">
                                    </td>
                                    <td style="padding: var(--space-4);">
                                        <form id="<?php echo $form_id; ?>" method="POST" action="stock.php">
                                            <input type="hidden" name="action" value="update_stock">
                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                            <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.8rem;">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="padding: var(--space-8); text-align: center; color: var(--color-text-secondary);">
                                        No products found. <?php echo ($role === 'owner') ? 'Add one above!' : ''; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- ADD PRODUCT MODAL (Owner Only) -->
    <?php if ($role === 'owner'): ?>
    <div id="add-drink-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2>Add New Product</h2>
            <form method="POST" action="stock.php">
                <input type="hidden" name="action" value="add_product">
                
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-input" style="color: var(--color-text);">
                        <option value="Energy Drink">Energy Drink</option>
                        <option value="Health Drink">Health Drink</option>
                        <option value="Water & Hydration">Water & Hydration</option>
                        <option value="Dairy">Dairy</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="product_name" class="form-input" placeholder="Enter product name" required>
                </div>
                
                <div class="form-group">
                    <label>Initial Stock</label>
                    <input type="number" name="stock_quantity" class="form-input" value="0" min="0">
                </div>

                <div class="form-group">
                    <label>Unit Price (Optional)</label>
                    <input type="number" name="unit_price" class="form-input" value="0" step="0.01" min="0">
                </div>

                <div class="modal-actions">
                    <button type="button" id="modal-back-btn" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

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

        /* Ensure select inputs have good contrast */
        select.form-input option {
            background-color: var(--color-surface);
            color: var(--color-text);
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
            <?php if ($role === 'owner'): ?>
            const addBtn = document.getElementById('add-drinks-btn');
            const modal = document.getElementById('add-drink-modal');
            const backBtn = document.getElementById('modal-back-btn');

            if (addBtn && modal) {
                addBtn.addEventListener('click', function() {
                    modal.style.display = 'flex';
                });

                backBtn.addEventListener('click', function() {
                    modal.style.display = 'none';
                });
                
                // Close on click outside
                window.addEventListener('click', function(e) {
                    if (e.target == modal) {
                        modal.style.display = 'none';
                    }
                });
            }
            <?php endif; ?>
        });
    </script>
</body>

</html>
