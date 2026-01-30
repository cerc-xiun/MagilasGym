<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Applications | Magilas Gym</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/dashboard.css">
    <link rel="icon" type="image/png" href="../../../assets/images/logo.png">
    <link rel="stylesheet" href="sidebar_premium.css">
    <link rel="stylesheet" href="pending.css">
    <link rel="stylesheet" href="receipt_styles.css">
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

                <a href="members.php" class="nav-item">
                    <i class="fas fa-desktop"></i>
                    <span>Front Desk Operations</span>
                </a>

                <a href="pending.php" class="nav-item active">
                    <i class="fas fa-clock"></i>
                    <span>Pending List</span>
                </a>

                <a href="#" class="nav-item" onclick="alert('Inventory - Coming Soon'); return false;">
                    <i class="fas fa-boxes-stacked"></i>
                    <span>Inventory</span>
                </a>

                <a href="#" class="nav-item" onclick="alert('Maintenance - Coming Soon'); return false;">
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
                    <h1 class="page-title">Pending <span class="text-accent">Applications</span></h1>
                </div>
                <div class="header-date"><i class="fas fa-calendar-alt"></i> <span id="dateDisplay"></span></div>
            </header>

            <!-- Tab Navigation -->
            <div class="pending-tabs">
                <button class="tab-btn active" data-tab="pending" onclick="switchTab('pending')">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Pending</span>
                    <span class="tab-badge" id="pendingCount">0</span>
                </button>
                <button class="tab-btn" data-tab="accepted" onclick="switchTab('accepted')">
                    <i class="fas fa-check-circle"></i>
                    <span>Accepted</span>
                    <span class="tab-badge success" id="acceptedCount">0</span>
                </button>
                <button class="tab-btn" data-tab="rejected" onclick="switchTab('rejected')">
                    <i class="fas fa-times-circle"></i>
                    <span>Rejected</span>
                    <span class="tab-badge danger" id="rejectedCount">0</span>
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="pending-controls">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" id="pendingSearch" placeholder="Search by name, email, plan..."
                        oninput="filterApplications()">
                </div>
                <div class="filter-info">
                    <span id="resultCount">0</span> applications
                </div>
            </div>

            <!-- Applications Container -->
            <div class="applications-container" id="applicationsContainer">
                <!-- Populated by JS -->
            </div>
        </main>
    </div>

    <!-- Detail Modal -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-large">
            <div class="modal-header">
                <h2>Application Details</h2>
                <button class="modal-close" onclick="closeDetailModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Populated by JS -->
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal-overlay" id="paymentModal">
        <div class="modal-medium">
            <div class="modal-header">
                <h2>Payment Details</h2>
                <button class="modal-close" onclick="closePaymentModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="payment-summary">
                    <p><strong>Applicant:</strong> <span id="paymentApplicantName"></span></p>
                    <p><strong>Plan:</strong> <span id="paymentPlanName"></span></p>
                    <p class="payment-amount"><strong>Amount:</strong> ₱<span id="paymentAmount"></span></p>
                </div>
                <div class="payment-options">
                    <h3>Select Payment Method:</h3>
                    <label class="payment-option">
                        <input type="radio" name="paymentMethod" value="cash" checked>
                        <div class="option-content">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash</span>
                        </div>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="paymentMethod" value="gcash">
                        <div class="option-content">
                            <i class="fas fa-mobile-alt"></i>
                            <span>GCash</span>
                        </div>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="paymentMethod" value="bank">
                        <div class="option-content">
                            <i class="fas fa-university"></i>
                            <span>Bank Transfer</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closePaymentModal()">Cancel</button>
                <button class="btn-primary" onclick="confirmPayment()">Continue to Receipt</button>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div class="modal-overlay" id="rejectionModal">
        <div class="modal-medium">
            <div class="modal-header">
                <h2>Rejection Feedback</h2>
                <button class="modal-close" onclick="closeRejectionModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p><strong>Applicant:</strong> <span id="rejectionApplicantName"></span></p>
                <div class="rejection-reasons">
                    <h3>Reason for Rejection:</h3>
                    <label class="reason-option">
                        <input type="radio" name="rejectionReason" value="incomplete" checked>
                        <span>Incomplete Information</span>
                    </label>
                    <label class="reason-option">
                        <input type="radio" name="rejectionReason" value="invalid">
                        <span>Invalid Contact Details</span>
                    </label>
                    <label class="reason-option">
                        <input type="radio" name="rejectionReason" value="duplicate">
                        <span>Duplicate Application</span>
                    </label>
                    <label class="reason-option">
                        <input type="radio" name="rejectionReason" value="other">
                        <span>Other (specify below)</span>
                    </label>
                </div>
                <div class="rejection-message">
                    <label>Additional Message:</label>
                    <textarea id="rejectionMessage" rows="4"
                        placeholder="Optional message to the applicant..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeRejectionModal()">Cancel</button>
                <button class="btn-danger" onclick="confirmRejection()">Reject Application</button>
            </div>
        </div>
    </div>

    <!-- Receipt Modal (Reused from registration) -->
    <div class="modal-overlay" id="receiptModal">
        <div class="receipt-container" id="receiptContent">
            <!-- Populated by JS -->
        </div>
    </div>

    <!-- Check-In Prompt Modal -->
    <div class="modal-overlay" id="checkinModal">
        <div class="modal-small">
            <div class="prompt-icon">
                <i class="fas fa-door-open"></i>
            </div>
            <h3>Check Member into Gym?</h3>
            <p>Would you like to add <strong id="checkinMemberName">Member Name</strong> to the active visits panel?</p>
            <div class="prompt-buttons">
                <button class="btn-skip" onclick="skipCheckin()">No, Skip</button>
                <button class="btn-checkin" onclick="proceedCheckin()">
                    <i class="fas fa-check"></i> Yes, Check In
                </button>
            </div>
        </div>
    </div>

    <script src="pending.js"></script>
    <script>
        // Initialize date display
        const dateDisplay = document.getElementById('dateDisplay');
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateDisplay.textContent = now.toLocaleDateString('en-US', options);
    </script>
</body>

</html>