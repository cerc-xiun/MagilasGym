<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Member | Magilas Gym</title>

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

        /* Activate specific styles */
        .activate-container {
            padding: 32px;
        }

        .activate-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 32px;
        }

        /* Member Profile Card */
        .profile-card {
            background: var(--gradient-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px 32px;
            text-align: center;
            height: fit-content;
            position: sticky;
            top: 120px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            margin: 0 auto 28px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.05) 100%);
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: 700;
            color: #d4af37;
            box-shadow: 0 8px 40px rgba(212, 175, 55, 0.15);
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .profile-email,
        .profile-phone {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .profile-status {
            margin-top: 32px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
        }

        .profile-status h4 {
            font-size: 0.85rem;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 12px;
        }

        /* Plan Selection Card */
        .plans-card {
            background: var(--gradient-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px;
        }

        .plans-header {
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .plans-header h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 0.04em;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .plans-header h2 i {
            color: #d4af37;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .plan-option {
            position: relative;
            cursor: pointer;
        }

        .plan-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .plan-card {
            padding: 32px 24px;
            background: rgba(255, 255, 255, 0.02);
            border: 2px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .plan-option:hover .plan-card {
            border-color: rgba(212, 175, 55, 0.3);
            background: rgba(212, 175, 55, 0.03);
        }

        .plan-option input:checked+.plan-card {
            border-color: #d4af37;
            background: linear-gradient(145deg, rgba(212, 175, 55, 0.12) 0%, rgba(212, 175, 55, 0.05) 100%);
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.15);
        }

        .plan-card h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .plan-price {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #f0d875, #d4af37, #b8960c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .plan-duration {
            font-size: 0.85rem;
            color: var(--text-dim);
        }

        .plan-check {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 28px;
            height: 28px;
            background: #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 0.8rem;
            opacity: 0;
            transform: scale(0);
            transition: all 0.3s ease;
        }

        .plan-option input:checked~.plan-check {
            opacity: 1;
            transform: scale(1);
        }

        /* Payment Section */
        .payment-section {
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .payment-section h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-section h3 i {
            color: #d4af37;
        }

        .payment-input-wrapper {
            position: relative;
            max-width: 300px;
            margin-bottom: 32px;
        }

        .payment-input-wrapper span {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.25rem;
            font-weight: 600;
            color: #d4af37;
        }

        .payment-input {
            width: 100%;
            padding: 20px 20px 20px 50px;
            font-size: 1.5rem;
            font-weight: 600;
            color: #fff;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .payment-input:focus {
            outline: none;
            border-color: #d4af37;
            background: rgba(212, 175, 55, 0.03);
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.08);
        }

        .confirm-btn {
            padding: 20px 48px;
            background: linear-gradient(135deg, #d4af37 0%, #f0d875 50%, #d4af37 100%);
            color: #000;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(212, 175, 55, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .confirm-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.4);
        }

        .confirm-btn i {
            transition: transform 0.3s ease;
        }

        .confirm-btn:hover i {
            transform: translateX(4px);
        }

        @media (max-width: 1024px) {
            .activate-grid {
                grid-template-columns: 1fr;
            }

            .profile-card {
                position: static;
            }
        }

        @media (max-width: 640px) {
            .plans-grid {
                grid-template-columns: 1fr;
            }
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
                    <a href="activate.php" class="nav-item active">
                        <i class="fas fa-user-plus"></i> <span>New Membership</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="inventory.php" class="nav-item">
                        <i class="fas fa-boxes-stacked"></i> <span>Inventory</span>
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

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="menu-btn" id="menuBtn" style="display: none;">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Activate <span class="text-accent">Membership</span></h1>
                </div>
            </header>

            <div class="activate-container">
                <div class="activate-grid">
                    <!-- Member Profile Card -->
                    <div class="profile-card">
                        <div class="profile-avatar">JD</div>
                        <h2 class="profile-name">John Doe</h2>
                        <p class="profile-email">john.doe@example.com</p>
                        <p class="profile-phone">0912 345 6789</p>

                        <div class="profile-status">
                            <h4>Current Status</h4>
                            <span class="status-badge pending">Pending Activation</span>
                        </div>
                    </div>

                    <!-- Plan Selection & Payment -->
                    <div class="plans-card">
                        <div class="plans-header">
                            <h2><i class="fas fa-crown"></i> Select Plan</h2>
                        </div>

                        <form id="activateForm">
                            <!-- Plan Options -->
                            <div class="plans-grid">
                                <label class="plan-option">
                                    <input type="radio" name="plan" value="day" data-price="100" checked>
                                    <div class="plan-card">
                                        <h4>Day Pass</h4>
                                        <div class="plan-price">₱100</div>
                                        <p class="plan-duration">Valid for 24 hours</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>

                                <label class="plan-option">
                                    <input type="radio" name="plan" value="week" data-price="400">
                                    <div class="plan-card">
                                        <h4>Weekly</h4>
                                        <div class="plan-price">₱400</div>
                                        <p class="plan-duration">Valid for 7 days</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>

                                <label class="plan-option">
                                    <input type="radio" name="plan" value="month" data-price="1500">
                                    <div class="plan-card">
                                        <h4>Monthly</h4>
                                        <div class="plan-price">₱1,500</div>
                                        <p class="plan-duration">Valid for 30 days</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>

                                <label class="plan-option">
                                    <input type="radio" name="plan" value="annual" data-price="12000">
                                    <div class="plan-card">
                                        <h4>Annual</h4>
                                        <div class="plan-price">₱12,000</div>
                                        <p class="plan-duration">Valid for 1 year</p>
                                    </div>
                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                </label>
                            </div>

                            <!-- Payment Section -->
                            <div class="payment-section">
                                <h3><i class="fas fa-peso-sign"></i> Payment Amount Received</h3>
                                <div class="payment-input-wrapper">
                                    <span>₱</span>
                                    <input type="number" class="payment-input" id="paymentAmount" value="100" min="0">
                                </div>

                                <button type="button" class="confirm-btn" onclick="confirmActivation()">
                                    <i class="fas fa-check-circle"></i> CONFIRM ACTIVATION
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Update payment amount when plan changes
        document.querySelectorAll('input[name="plan"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const price = this.dataset.price;
                document.getElementById('paymentAmount').value = price;
            });
        });

        function confirmActivation() {
            const selectedPlan = document.querySelector('input[name="plan"]:checked');
            const paymentAmount = document.getElementById('paymentAmount').value;

            if (!selectedPlan) {
                alert('Please select a plan');
                return;
            }

            const planPrice = parseInt(selectedPlan.dataset.price);
            if (parseInt(paymentAmount) < planPrice) {
                alert('Payment amount is less than plan price');
                return;
            }

            // Demo confirmation
            alert(`Membership activated!\nPlan: ${selectedPlan.value}\nPayment: ₱${paymentAmount}`);
        }

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>

</html>