<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Front Desk | Magilas Gym</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../../../css/dashboard.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../../assets/images/logo.png">
    <link rel="stylesheet" href="members.css">
    <link rel="stylesheet" href="step_design.css">
</head>

<body class="dashboard-body">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="../../../assets/images/logo.png" alt="Magilas Logo" class="sidebar-logo">
                <div class="sidebar-brand">MAGILAS <span class="text-accent">GYM</span></div>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-label">Overview</div>
                    <a href="../dashboard/dashboard.php" class="nav-item"><i class="fas fa-th-large"></i>
                        <span>Dashboard</span></a>
                </div>
                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="../members/members.php" class="nav-item active"><i class="fas fa-desktop"></i>
                        <span>Front Desk</span></a>
                    <a href="#" class="nav-item" onclick="openPendingModal(); return false;"><i
                            class="fas fa-user-clock"></i> <span>Pending</span><span class="nav-badge"
                            id="pendingCount">2</span></a>
                    <a href="../inventory/inventory.php" class="nav-item"><i class="fas fa-boxes-stacked"></i>
                        <span>Inventory</span></a>
                </div>
            </nav>
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">SM</div>
                    <div class="user-text">
                        <h4>Staff Member</h4><span>Front Desk</span>
                    </div>
                    <a href="../auth/login.php" class="user-logout" title="Logout"><i
                            class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-left">
                    <button class="menu-btn" id="menuBtn"><i class="fas fa-bars"></i></button>
                    <h1 class="page-title">Front Desk <span class="text-accent">Operations</span></h1>
                </div>
                <div class="header-date"><i class="fas fa-calendar-alt"></i> <span id="dateDisplay"></span></div>
            </header>

            <!-- Dynamic Grid -->
            <div class="members-grid-container" id="membersGrid" data-active="none">

                <!-- Cell 1: Who's In (Top-Left) -->
                <div class="grid-cell" data-pos="top-left" onclick="activateCell('top-left')">
                    <button class="minimize-btn" onclick="event.stopPropagation(); minimizeCell();"><i
                            class="fas fa-compress-alt"></i></button>
                    <div class="cell-header">
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Active
                            Visits</span>
                    </div>

                    <!-- Preview when inactive -->
                    <div class="cell-preview">
                        <div class="preview-content">
                            <div class="preview-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="preview-stats">
                                <div class="stat-number" id="previewMemberCount">11</div>
                                <div class="stat-label">Members Inside</div>
                            </div>
                        </div>
                    </div>

                    <div class="cell-content" id="whosInContent" onclick="event.stopPropagation();">
                        <div class="whos-in-search"
                            style="display: flex; gap: 12px; margin-top: 12px; justify-content: center; align-items: center;">
                            <div class="search-wrapper" style="width: 50%; position: relative; flex: none;">
                                <i class="fas fa-search"></i>
                                <input type="text" id="whosInSearch" placeholder="Search..." oninput="filterWhosIn()">
                            </div>
                            <div class="active-indicator" id="activeCount"
                                style="margin: 0; background: rgba(184, 150, 12, 0.1); border: 1px solid rgba(184, 150, 12, 0.2); white-space: nowrap;">
                                <i class="fas fa-user"></i> <span style="margin-right: 4px;">0</span> <span
                                    style="font-size: 11px; opacity: 0.8; font-weight: 500;">Inside</span>
                            </div>
                        </div>
                        <div class="member-list-header">
                            <div></div> <!-- Avatar -->
                            <div>Member Name</div>
                            <div>Pass Type</div>
                            <div>Time In</div>
                            <div>Action</div>
                        </div>
                        <div id="whosInList" class="member-list"></div>
                    </div>
                </div>

                <!-- Cell 2: Scan Entry (Top-Right) -->
                <div class="grid-cell" data-pos="top-right" onclick="activateCell('top-right')">
                    <button class="minimize-btn" onclick="event.stopPropagation(); minimizeCell();"><i
                            class="fas fa-compress-alt"></i></button>
                    <div class="cell-header">
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Access
                            Scanner</span>
                    </div>

                    <!-- Preview when inactive -->
                    <div class="cell-preview">
                        <div class="preview-content">
                            <div class="preview-icon scan">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <div class="preview-stats">
                                <div class="stat-label">QR Scan Entry</div>
                                <div class="stat-hint">Click to scan member QR</div>
                            </div>
                        </div>
                    </div>

                    <div class="cell-content">
                        <div class="scan-layout">
                            <!-- Camera Section -->
                            <div class="scan-camera-section">
                                <div class="camera-container">
                                    <div class="scan-overlay"></div>
                                    <div class="scan-beam"></div>
                                    <div class="camera-status">
                                        <span class="dot"></span>
                                        Camera Active
                                    </div>
                                </div>
                                <div class="scan-buttons">
                                    <button class="scan-btn success"
                                        onclick="event.stopPropagation(); simulateScanSuccess();">
                                        <i class="fas fa-check"></i> Simulate Success
                                    </button>
                                    <button class="scan-btn fail"
                                        onclick="event.stopPropagation(); simulateScanFail();">
                                        <i class="fas fa-times"></i> Fail
                                    </button>
                                    <button class="scan-btn"
                                        style="background: rgba(255, 152, 0, 0.2); color: orange; border: 1px solid orange;"
                                        onclick="event.stopPropagation(); simulateScanExpired();">
                                        <i class="fas fa-clock"></i> Expired
                                    </button>
                                </div>
                            </div>
                            <!-- Result Section -->
                            <div class="scan-result-section">
                                <div class="result-panel waiting" id="scanResultPanel">
                                    <i class="fas fa-qrcode"></i>
                                    <p>Waiting for scan...</p>
                                    <p style="font-size:10px; margin-top:8px; opacity:0.6;">Point camera at member's QR
                                        code</p>
                                </div>
                                <div class="scan-actions" id="scanActions">
                                    <button class="allow-entry-btn" id="allowEntryBtn" disabled>
                                        <i class="fas fa-door-open"></i> ALLOW ENTRY
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cell 3: New Member (Bottom-Left) -->
                <div class="grid-cell" data-pos="bottom-left" onclick="activateCell('bottom-left')">
                    <button class="minimize-btn" onclick="event.stopPropagation(); minimizeCell();"><i
                            class="fas fa-compress-alt"></i></button>
                    <div class="cell-header">
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Registration
                            Desk</span>
                    </div>

                    <!-- Preview when inactive -->
                    <div class="cell-preview">
                        <div class="preview-content">
                            <div class="preview-icon member">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="preview-stats">
                                <div class="stat-label">New Member</div>
                                <div class="stat-hint">Daily Pass or Membership</div>
                            </div>
                        </div>
                    </div>

                    <div class="cell-content">
                        <div class="new-member-container" id="newMemberContainer">

                            <!-- STATE: Flip Card Selection -->
                            <div class="reg-state active" id="regCardSelection">
                                <div class="flip-cards-container">
                                    <!-- Flip Card 1: Access Plans -->
                                    <div class="flip-card" onclick="event.stopPropagation(); showRegistrationForm();">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front">
                                                <div class="flip-icon">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                                <div class="flip-title">Access Plans</div>
                                                <div class="flip-subtitle">Day Pass & Membership</div>
                                            </div>
                                            <div class="flip-card-back">
                                                <div class="flip-back-header">Available Plans</div>
                                                <div class="flip-price-list">
                                                    <div class="flip-price-item">
                                                        <span>Day Pass</span>
                                                        <strong>₱60</strong>
                                                    </div>
                                                    <div class="flip-price-item">
                                                        <span>Student Monthly</span>
                                                        <strong>₱600</strong>
                                                    </div>
                                                    <div class="flip-price-item">
                                                        <span>Regular Monthly</span>
                                                        <strong>₱800</strong>
                                                    </div>
                                                    <div class="flip-price-item">
                                                        <span>Senior Monthly</span>
                                                        <strong>₱650</strong>
                                                    </div>
                                                </div>
                                                <div class="flip-cta">Click to Start →</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Flip Card 2: Renewal & Additions -->
                                    <div class="flip-card" onclick="event.stopPropagation(); showRenewalForm();">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front">
                                                <div class="flip-icon">
                                                    <i class="fas fa-sync-alt"></i>
                                                </div>
                                                <div class="flip-title">Renewal & Additions</div>
                                                <div class="flip-subtitle">Extend or Upgrade</div>
                                            </div>
                                            <div class="flip-card-back">
                                                <div class="flip-back-header">Member Services</div>
                                                <div class="flip-price-list">
                                                    <div class="flip-price-item">
                                                        <span>Membership Renewal</span>
                                                        <strong><i class="fas fa-arrow-right"></i></strong>
                                                    </div>
                                                    <div class="flip-price-item">
                                                        <span>Add Instructor</span>
                                                        <strong>₱1,250</strong>
                                                    </div>
                                                    <div class="flip-price-item">
                                                        <span>Reactivate Account</span>
                                                        <strong><i class="fas fa-check"></i></strong>
                                                    </div>
                                                    <div class="flip-price-item">
                                                        <span>Check Status</span>
                                                        <strong><i class="fas fa-search"></i></strong>
                                                    </div>
                                                </div>
                                                <div class="flip-cta">Click to Proceed →</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STATE: Renewal Flow -->
                            <div class="reg-state" id="regRenewalFlow">
                                <div class="step-flow-container">
                                    <button class="step-back-btn"
                                        onclick="event.stopPropagation(); navigateBackToCards();">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>

                                    <!-- Renewal Step 1: Search -->
                                    <div class="renewal-search-container" id="renewalStep1">
                                        <div class="glass-card centered-card"
                                            style="max-width: 400px; padding: 40px 30px;">
                                            <div class="icon-circle gold"
                                                style="margin: 0 auto 20px auto; width: 70px; height: 70px; font-size: 28px;">
                                                <i class="fas fa-search"></i>
                                            </div>
                                            <h3 style="text-align: center; margin-bottom: 8px;">Find Member</h3>
                                            <p
                                                style="text-align: center; color: var(--text-secondary); margin-bottom: 24px; font-size: 14px;">
                                                Enter name or ID to check status</p>

                                            <div class="form-group-modern">
                                                <div class="input-glass">
                                                    <i class="fas fa-user-tag"></i>
                                                    <input type="text" id="renewalSearchInput"
                                                        placeholder="Member Name or ID"
                                                        onclick="event.stopPropagation();"
                                                        onkeypress="handleRenewalSearchEnter(event)">
                                                </div>
                                            </div>

                                            <button class="btn-primary"
                                                onclick="event.stopPropagation(); searchMemberForRenewal();"
                                                style="margin-top: 16px; width: 100%; justify-content: center;">
                                                Search Record <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Renewal Step 2: Member Dashboard -->
                                    <div class="renewal-dashboard-container" id="renewalStep2" style="display: none;">
                                        <div class="glass-card">
                                            <!-- Member Profile Header -->
                                            <div class="renewal-profile-header">
                                                <div class="profile-photo-ring">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="profile-info">
                                                    <h3 id="renewMemberName">John Doe</h3>
                                                    <div class="profile-meta">
                                                        <span class="meta-badge" id="renewMemberPlan">Regular
                                                            Monthly</span>
                                                        <span class="status-badge" id="renewMemberStatus">Active</span>
                                                    </div>
                                                </div>
                                                <div class="profile-expiry">
                                                    <span class="label">Current Expiry</span>
                                                    <strong id="renewMemberExpiry">Feb 25, 2026</strong>
                                                </div>
                                            </div>

                                            <div class="divider-glass"></div>

                                            <h4 class="section-title">Available Actions</h4>

                                            <div class="renewal-options-grid">
                                                <!-- Extend Membership -->
                                                <div class="renewal-option-card active" id="optExtend"
                                                    onclick="selectRenewalOption('extend')">
                                                    <div class="opt-icon"><i class="fas fa-calendar-plus"></i></div>
                                                    <div class="opt-details">
                                                        <h5>Extend Membership</h5>
                                                        <p>Add more months</p>
                                                    </div>
                                                    <div class="opt-arrow"><i class="fas fa-chevron-right"></i></div>
                                                </div>

                                                <!-- Add Instructor -->
                                                <div class="renewal-option-card" id="optInstructor"
                                                    onclick="selectRenewalOption('instructor')">
                                                    <div class="opt-icon"><i class="fas fa-user-tie"></i></div>
                                                    <div class="opt-details">
                                                        <h5>Add Instructor</h5>
                                                        <p>Sessions & Training</p>
                                                    </div>
                                                    <div class="opt-arrow"><i class="fas fa-chevron-right"></i></div>
                                                </div>
                                            </div>

                                            <!-- Extension Form (Hidden by default) -->
                                            <div class="renewal-action-form" id="formExtend"
                                                style="display: block; margin-top: 24px;">
                                                <label class="duration-label">Select Duration to Add</label>
                                                <div class="duration-stepper">
                                                    <button class="stepper-btn"
                                                        onclick="event.stopPropagation(); adjustRenewalDuration(-1);">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <div class="duration-display">
                                                        <span class="duration-value" id="renewDurationVal">1</span>
                                                        <span class="duration-unit">Month</span>
                                                    </div>
                                                    <button class="stepper-btn"
                                                        onclick="event.stopPropagation(); adjustRenewalDuration(1);">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="new-expiry-preview">
                                                    <span>New Expiry:</span>
                                                    <strong id="renewNewExpiry" class="gold">March 25, 2026</strong>
                                                </div>
                                            </div>

                                            <!-- Payment & Confirm -->
                                            <div class="renewal-payment-section" style="margin-top: 24px;">
                                                <label class="payment-label">Payment Method</label>
                                                <div class="payment-options-glass compact">
                                                    <div class="payment-option-glass active" data- rpay="gcash"
                                                        onclick="selectRenewalPayment('gcash')">GCash</div>
                                                    <div class="payment-option-glass" data-rpay="cash"
                                                        onclick="selectRenewalPayment('cash')">Cash</div>
                                                </div>

                                                <div class="renewal-total-row">
                                                    <span>Total Amount</span>
                                                    <strong id="renewTotalAmount">₱800</strong>
                                                </div>

                                                <button class="btn-primary" onclick="processRenewalComplete()"
                                                    style="width: 100%; justify-content: center; margin-top: 16px;">
                                                    Confirm & Pay <i class="fas fa-check-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- STATE: Step-Based Registration Flow -->
                            <div class="reg-state" id="regStepFlow">
                                <div class="step-flow-container">

                                    <!-- Step Header with Back Button -->
                                    <div class="step-header">
                                        <button class="step-back-btn"
                                            onclick="event.stopPropagation(); navigateBackToCards();">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>

                                        <div class="step-progress">
                                            <div class="step-item active">
                                                <div class="step-circle"
                                                    onclick="event.stopPropagation(); goToStep(1);">1</div>
                                                <span class="step-label">Plan</span>
                                            </div>
                                            <div class="step-line"></div>
                                            <div class="step-item">
                                                <div class="step-circle"
                                                    onclick="event.stopPropagation(); goToStep(2);">2</div>
                                                <span class="step-label">Info</span>
                                            </div>
                                            <div class="step-line"></div>
                                            <div class="step-item">
                                                <div class="step-circle"
                                                    onclick="event.stopPropagation(); goToStep(3);">3</div>
                                                <span class="step-label">Payment</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STEP 1: Plan Selection -->
                                    <div class="step-content active" id="step1">
                                        <div class="glass-card">
                                            <h3 class="step-title">Select Your Plan</h3>

                                            <!-- Plan Selection Grid -->
                                            <div class="plan-selection-grid">
                                                <!-- Day Pass -->
                                                <div class="plan-card-modern" data-plan="day-pass"
                                                    onclick="event.stopPropagation(); selectPlanModern('day-pass', 60);">
                                                    <div class="plan-icon"><i class="fas fa-clock"></i></div>
                                                    <div class="plan-info">
                                                        <h4>Day Pass</h4>
                                                        <p class="plan-desc">Single day access</p>
                                                    </div>
                                                    <div class="plan-pricing">
                                                        <span class="plan-price">₱60</span>
                                                        <span class="plan-period">/day</span>
                                                    </div>
                                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                                </div>

                                                <!-- Student Monthly -->
                                                <div class="plan-card-modern" data-plan="student"
                                                    onclick="event.stopPropagation(); selectPlanModern('student', 600);">
                                                    <div class="plan-icon"><i class="fas fa-graduation-cap"></i></div>
                                                    <div class="plan-info">
                                                        <h4>Student Monthly</h4>
                                                        <p class="plan-desc">For students with ID</p>
                                                    </div>
                                                    <div class="plan-pricing">
                                                        <span class="plan-price">₱600</span>
                                                        <span class="plan-period">/mo</span>
                                                    </div>
                                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                                </div>

                                                <!-- Regular Monthly -->
                                                <div class="plan-card-modern" data-plan="regular"
                                                    onclick="event.stopPropagation(); selectPlanModern('regular', 800);">
                                                    <div class="plan-icon"><i class="fas fa-dumbbell"></i></div>
                                                    <div class="plan-info">
                                                        <h4>Regular Monthly</h4>
                                                        <p class="plan-desc">Standard membership</p>
                                                    </div>
                                                    <div class="plan-pricing">
                                                        <span class="plan-price">₱800</span>
                                                        <span class="plan-period">/mo</span>
                                                    </div>
                                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                                </div>

                                                <!-- Senior Monthly -->
                                                <div class="plan-card-modern" data-plan="senior"
                                                    onclick="event.stopPropagation(); selectPlanModern('senior', 650);">
                                                    <div class="plan-icon"><i class="fas fa-heart"></i></div>
                                                    <div class="plan-info">
                                                        <h4>Senior Monthly</h4>
                                                        <p class="plan-desc">60+ with valid ID</p>
                                                    </div>
                                                    <div class="plan-pricing">
                                                        <span class="plan-price">₱650</span>
                                                        <span class="plan-period">/mo</span>
                                                    </div>
                                                    <div class="plan-check"><i class="fas fa-check"></i></div>
                                                </div>
                                            </div>

                                            <!-- Duration Selector (Hidden for day pass) -->
                                            <div class="duration-section" id="durationSection" style="display: none;">
                                                <label class="duration-label">Membership Duration</label>
                                                <div class="duration-stepper">
                                                    <button class="stepper-btn"
                                                        onclick="event.stopPropagation(); decrementDuration();">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <div class="duration-display">
                                                        <span class="duration-value" id="durationValue">1</span>
                                                        <span class="duration-unit">Month<span
                                                                id="monthPlural"></span></span>
                                                    </div>
                                                    <button class="stepper-btn"
                                                        onclick="event.stopPropagation(); incrementDuration();">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="expiration-info">
                                                    <i class="fas fa-calendar-check"></i>
                                                    <span>Expires: <strong id="expirationDate">Feb 25,
                                                            2026</strong></span>
                                                </div>
                                            </div>

                                            <!-- Instructor Add-on (Hidden for day pass) -->
                                            <div class="instructor-section" id="instructorSection"
                                                style="display: none;">
                                                <div class="addon-card">
                                                    <div class="addon-info">
                                                        <i class="fas fa-user-tie"></i>
                                                        <div>
                                                            <h5>Add Fitness Instructor</h5>
                                                            <p>Personal training sessions</p>
                                                        </div>
                                                    </div>
                                                    <div class="addon-price">₱1,250</div>
                                                    <label class="addon-toggle">
                                                        <input type="checkbox" id="instructorCheckbox"
                                                            onchange="toggleInstructor()">
                                                        <span class="toggle-slider"></span>
                                                    </label>
                                                </div>
                                                <div class="instructor-quantity" id="instructorQuantity"
                                                    style="display: none;">
                                                    <label>Number of Sessions</label>
                                                    <div class="quantity-stepper">
                                                        <button
                                                            onclick="event.stopPropagation(); decrementInstructor();"><i
                                                                class="fas fa-minus"></i></button>
                                                        <span id="instructorQty">1</span>
                                                        <button
                                                            onclick="event.stopPropagation(); incrementInstructor();"><i
                                                                class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step Navigation -->
                                            <div class="step-nav-buttons">
                                                <button class="btn-step-next"
                                                    onclick="event.stopPropagation(); goToStep(2);">
                                                    Continue <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STEP 2: Customer Information -->
                                    <div class="step-content" id="step2">
                                        <div class="glass-card">
                                            <h3 class="step-title">Customer Information</h3>

                                            <!-- Day Pass Form (Simple) -->
                                            <div id="dayPassInfoForm" style="display: none;">
                                                <div class="form-group-modern">
                                                    <label>Full Name</label>
                                                    <div class="input-glass">
                                                        <i class="fas fa-user"></i>
                                                        <input type="text" id="dayPassCustomerName"
                                                            placeholder="Enter customer name"
                                                            onclick="event.stopPropagation();">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Membership Form (Full) -->
                                            <!-- Membership Form (Horizontal Layout) -->
                                            <div id="membershipInfoForm" style="display: none;">
                                                <div class="form-horizontal-container">
                                                    <!-- Col 1: Photo -->
                                                    <div class="form-column">
                                                        <div class="photo-upload-modern">
                                                            <div class="photo-preview-glass" id="photoPreviewGlass"
                                                                onclick="document.getElementById('memberPhotoModern').click();">
                                                                <i class="fas fa-camera"></i>
                                                                <span>Upload Photo</span>
                                                                <input type="file" id="memberPhotoModern"
                                                                    accept="image/*" onchange="previewPhotoModern(this)"
                                                                    onclick="event.stopPropagation();">
                                                            </div>
                                                            <button class="remove-photo-modern" id="removePhotoModern"
                                                                onclick="event.stopPropagation(); removePhotoModern();">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Col 2: Info Fields -->
                                                    <div class="form-column" style="flex: 2;">
                                                        <div class="form-group-modern">
                                                            <label>Full Name</label>
                                                            <div class="input-glass">
                                                                <i class="fas fa-user"></i>
                                                                <input type="text" id="memberNameModern"
                                                                    placeholder="Enter full name"
                                                                    onclick="event.stopPropagation();">
                                                            </div>
                                                        </div>
                                                        <div class="form-group-modern">
                                                            <label>Email Address</label>
                                                            <div class="input-glass">
                                                                <i class="fas fa-envelope"></i>
                                                                <input type="email" id="memberEmailModern"
                                                                    placeholder="email@example.com"
                                                                    onclick="event.stopPropagation();">
                                                            </div>
                                                        </div>
                                                        <div class="form-group-modern">
                                                            <label>Phone Number</label>
                                                            <div class="input-glass">
                                                                <i class="fas fa-phone"></i>
                                                                <input type="tel" id="memberPhoneModern"
                                                                    placeholder="09XX XXX XXXX"
                                                                    onclick="event.stopPropagation();">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step Navigation -->
                                            <div class="step-nav-buttons">
                                                <button class="btn-step-back"
                                                    onclick="event.stopPropagation(); goToStep(1);">
                                                    <i class="fas fa-arrow-left"></i> Back
                                                </button>
                                                <button class="btn-step-next"
                                                    onclick="event.stopPropagation(); goToStep(3);">
                                                    Continue <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- STEP 3: Payment & Confirmation -->
                                    <div class="step-content" id="step3">
                                        <div class="glass-card">
                                            <h3 class="step-title">Payment & Confirmation</h3>

                                            <!-- Order Summary -->
                                            <div class="order-summary-glass">
                                                <h4>Order Summary</h4>
                                                <div class="summary-row">
                                                    <span>Plan</span>
                                                    <strong id="summaryPlan">Regular Monthly</strong>
                                                </div>
                                                <div class="summary-row" id="summaryDurationRow">
                                                    <span>Duration</span>
                                                    <strong id="summaryDuration">1 Month</strong>
                                                </div>
                                                <div class="summary-row" id="summaryInstructorRow"
                                                    style="display: none;">
                                                    <span>Instructor Sessions</span>
                                                    <strong id="summaryInstructor">1 Session (₱1,250)</strong>
                                                </div>
                                                <div class="summary-divider"></div>
                                                <div class="summary-row total">
                                                    <span>Total Amount</span>
                                                    <strong id="summaryTotal">₱800</strong>
                                                </div>
                                            </div>

                                            <!-- Payment Method Selection -->
                                            <div class="payment-method-section">
                                                <label class="payment-label">Select Payment Method</label>
                                                <div class="payment-options-glass">
                                                    <div class="payment-option-glass active" data-payment="gcash"
                                                        onclick="event.stopPropagation(); selectPaymentModern('gcash');">
                                                        <i class="fab fa-google-wallet"></i>
                                                        <span>GCash</span>
                                                        <div class="payment-check"><i class="fas fa-check"></i></div>
                                                    </div>
                                                    <div class="payment-option-glass" data-payment="cash"
                                                        onclick="event.stopPropagation(); selectPaymentModern('cash');">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                        <span>Cash</span>
                                                        <div class="payment-check"><i class="fas fa-check"></i></div>
                                                    </div>
                                                    <div class="payment-option-glass" data-payment="bank"
                                                        onclick="event.stopPropagation(); selectPaymentModern('bank');">
                                                        <i class="fas fa-university"></i>
                                                        <span>Bank</span>
                                                        <div class="payment-check"><i class="fas fa-check"></i></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step Navigation -->
                                            <div class="step-nav-buttons">
                                                <button class="btn-step-back"
                                                    onclick="event.stopPropagation(); goToStep(2);">
                                                    <i class="fas fa-arrow-left"></i> Back
                                                </button>
                                                <button class="btn-step-complete"
                                                    onclick="event.stopPropagation(); completeRegistration();">
                                                    <i class="fas fa-check"></i> Complete Registration
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SUCCESS: Day Pass (Horizontal Receipt) -->
                            <div class="reg-state" id="regSuccessDayPass">
                                <div class="success-screen-modern">
                                    <div class="success-header-glass">
                                        <div class="success-icon-modern">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <h2>Day Pass Activated!</h2>
                                        <p>Valid for today's access</p>
                                    </div>

                                    <div class="receipt-grid-horizontal">
                                        <div class="receipt-col">
                                            <span class="receipt-label">Customer</span>
                                            <span class="receipt-value" id="successNameDay">John Doe</span>
                                        </div>
                                        <div class="receipt-col">
                                            <span class="receipt-label">Amount</span>
                                            <span class="receipt-value gold">₱60</span>
                                        </div>
                                        <div class="receipt-col">
                                            <span class="receipt-label">Payment</span>
                                            <span class="receipt-value" id="successPaymentDay">GCash</span>
                                        </div>
                                        <div class="receipt-col">
                                            <span class="receipt-label">Valid Until</span>
                                            <span class="receipt-value" id="successValidityDay">Jan 26, 12:00 AM</span>
                                        </div>
                                    </div>

                                    <button class="btn-done-modern" onclick="event.stopPropagation(); resetToCards();">
                                        <i class="fas fa-check-circle"></i> Done
                                    </button>
                                </div>
                            </div>

                            <!-- SUCCESS: Membership (Two-Column with QR) -->
                            <div class="reg-state" id="regSuccessMembership">
                                <div class="success-screen-modern">
                                    <div class="success-header-glass">
                                        <div class="success-icon-modern">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h2>Membership Activated!</h2>
                                        <p>Welcome to the club</p>
                                    </div>

                                    <div class="membership-success-layout">
                                        <!-- Left: Receipt Details -->
                                        <div class="receipt-details-side">
                                            <div class="receipt-grid-compact">
                                                <div class="receipt-row-compact">
                                                    <span class="receipt-label">Member</span>
                                                    <strong id="successNameMember">John Doe</strong>
                                                </div>
                                                <div class="receipt-row-compact">
                                                    <span class="receipt-label">Plan</span>
                                                    <strong id="successPlan">Regular Monthly</strong>
                                                </div>
                                                <div class="receipt-row-compact">
                                                    <span class="receipt-label">Duration</span>
                                                    <strong id="successDuration">1 Month</strong>
                                                </div>
                                                <div class="receipt-row-compact">
                                                    <span class="receipt-label">Expiration</span>
                                                    <strong id="successExpiration">February 25, 2026</strong>
                                                </div>
                                                <div class="receipt-row-compact">
                                                    <span class="receipt-label">Payment</span>
                                                    <strong id="successPaymentMember">GCash</strong>
                                                </div>
                                                <div class="receipt-row-compact" id="instructorRow"
                                                    style="display: none;">
                                                    <span class="receipt-label">Instructor</span>
                                                    <strong id="successInstructor">1 Session (₱1,250)</strong>
                                                </div>
                                                <div class="receipt-divider-compact"></div>
                                                <div class="receipt-row-compact total">
                                                    <span class="receipt-label">Total</span>
                                                    <strong class="gold" id="successAmount">₱800</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right: QR Code -->
                                        <div class="qr-side-glass">
                                            <div class="qr-placeholder-modern">
                                                <i class="fas fa-qrcode"></i>
                                            </div>
                                            <p class="qr-hint">Scan to verify membership</p>
                                        </div>
                                    </div>

                                    <button class="btn-done-modern" onclick="event.stopPropagation(); resetToCards();">
                                        <i class="fas fa-check-circle"></i> Done
                                    </button>
                                </div>
                            </div>
                        </div><!-- End new-member-container -->
                    </div><!-- End cell-content -->
                </div><!-- End Cell 3: Registration Desk -->

                <!-- Cell 4: Directory (Bottom-Right) -->
                <div class="grid-cell" data-pos="bottom-right" onclick="activateCell('bottom-right')">
                    <button class="minimize-btn" onclick="event.stopPropagation(); minimizeCell();"><i
                            class="fas fa-compress-alt"></i></button>
                    <div class="cell-header">
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Member
                            Lookup</span>
                    </div>

                    <!-- Preview when inactive -->
                    <div class="cell-preview">
                        <div class="preview-content">
                            <div class="preview-icon directory">
                                <i class="fas fa-address-book"></i>
                            </div>
                            <div class="preview-stats">
                                <div class="stat-label">Member Directory</div>
                                <div class="stat-hint">Search and manage</div>
                            </div>
                        </div>
                    </div>

                    <div class="cell-content">
                        <!-- STATE 1: Search Form -->
                        <div class="dir-search-container" id="dirSearchState">
                            <div class="dir-search-card">
                                <h3 class="dir-title">Find a Member</h3>
                                <div class="dir-form-group">
                                    <div class="input-wrapper">
                                        <i class="fas fa-user"></i>
                                        <input type="text" id="dirSearchInput" placeholder="Enter member name..."
                                            onclick="event.stopPropagation();">
                                    </div>
                                </div>
                                <button class="btn-primary" onclick="event.stopPropagation(); searchDirectoryMember();">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>

                        <!-- STATE 2: Member Found Result -->
                        <div class="dir-result-container" id="dirResultState" style="display: none;">
                            <div class="dir-result-card">
                                <!-- Replaced header with profile-centric layout -->
                                <div class="dir-member-layout">
                                    <div class="dir-member-photo" id="dirMemberPhoto">
                                        <i class="fas fa-user"></i>
                                    </div>

                                    <div class="dir-member-details">
                                        <div class="dir-info-main">
                                            <div class="dir-value name" id="dirMemberName">John Doe</div>
                                            <span class="dir-status-badge" id="dirMemberStatus">Active</span>
                                        </div>

                                        <div class="dir-meta-grid">
                                            <div class="dir-info-item">
                                                <span class="dir-label">Plan</span>
                                                <span class="dir-value" id="dirMemberPlan">Premium</span>
                                            </div>
                                            <div class="dir-info-item">
                                                <span class="dir-label" id="dirExpiryLabel">Expires</span>
                                                <span class="dir-value" id="dirMemberExpiry">Feb 15, 2026</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="dir-actions">
                                    <button class="dir-btn secondary"
                                        onclick="event.stopPropagation(); closeDirectoryResult();">
                                        <i class="fas fa-arrow-left"></i> Close
                                    </button>
                                    <button class="dir-btn primary" id="dirActionBtn"
                                        onclick="event.stopPropagation(); handleDirectoryAction();">
                                        <i class="fas fa-qrcode"></i> Show QR
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- STATE 3: Not Found -->
                        <div class="dir-not-found-container" id="dirNotFoundState" style="display: none;">
                            <div class="dir-not-found-card">
                                <h3 class="dir-title error">Not Found</h3>
                                <p class="dir-not-found-message" id="dirNotFoundMessage">
                                    "<span id="dirSearchedName">Name</span>" was not applied for any kind of
                                    membership or day pass in the gym
                                </p>
                                <button class="dir-btn secondary"
                                    onclick="event.stopPropagation(); closeDirectoryResult();">
                                    <i class="fas fa-arrow-left"></i> Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code Modal for Directory -->
                <div class="qr-modal" id="dirQRModal" onclick="closeDirQRModal()">
                    <div class="qr-modal-content" onclick="event.stopPropagation();">
                        <button class="qr-close-btn" onclick="closeDirQRModal()">
                            <i class="fas fa-times"></i>
                        </button>
                        <h3>Member QR Code</h3>
                        <div class="qr-code-display">
                            <div id="dirQRCodeCanvas"></div>
                        </div>
                        <p class="qr-member-name" id="dirQRMemberName">Member Name</p>
                    </div>
                </div>

            </div>
        </main>
    </div>
    <!-- Pending Memberships Modal -->
    <div class="pending-modal" id="pendingModal">
        <div class="pending-modal-content">
            <div class="pending-modal-header">
                <h3><i class="fas fa-user-clock" style="color: var(--warning); margin-right: 8px;"></i> Pending
                    Memberships</h3>
                <button class="pending-modal-close" onclick="closePendingModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="pending-modal-body" id="pendingList">
                <!-- Populated by JS -->
            </div>
        </div>
    </div>
    <!-- Exit Confirmation Modal -->
    <div class="modal-overlay" id="exitModal">
        <div class="custom-modal">
            <div class="modal-icon"><i class="fas fa-sign-out-alt"></i></div>
            <div class="modal-title">Confirm Exit</div>
            <div class="modal-text">Are you sure this member has left the gym premises?</div>
            <div class="modal-actions">
                <button class="modal-btn cancel" onclick="closeExitConfirmation()">Cancel</button>
                <button class="modal-btn confirm" onclick="confirmExit()">Confirm Exit</button>
            </div>
        </div>
    </div>


    <script src="registration_forms.js"></script>
    <script src="members.js"></script>
</body>

</html>