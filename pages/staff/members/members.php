<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members | Magilas Gym</title>

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
                    <a href="../members/members.php" class="nav-item active"><i class="fas fa-users"></i>
                        <span>Members</span></a>
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
                    <h1 class="page-title">Member <span class="text-accent">Hub</span></h1>
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
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Who's
                            In</span>
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
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Scan
                            Entry</span>
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
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">New
                            Member</span>
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
                            <!-- STATE: Choice -->
                            <div class="nm-state active" id="nmStateChoice">
                                <div class="choice-cards">
                                    <div class="choice-card" onclick="event.stopPropagation(); showDailyPassForm();">
                                        <div class="choice-icon daily"><i class="fas fa-clock"></i></div>
                                        <div class="choice-title">Daily Pass</div>
                                        <div class="choice-price">₱60</div>
                                        <div class="choice-desc">Quick entry for walk-ins<br>Expires at midnight</div>
                                    </div>
                                    <div class="choice-card" onclick="event.stopPropagation(); showMembershipForm();">
                                        <div class="choice-icon membership"><i class="fas fa-id-card"></i></div>
                                        <div class="choice-title">Membership</div>
                                        <div class="choice-price">₱800+</div>
                                        <div class="choice-desc">Full registration<br>Monthly/Annual plans</div>
                                    </div>
                                </div>
                            </div>

                            <!-- STATE: Daily Pass Form -->
                            <!-- STATE: Daily Pass Form -->
                            <div class="nm-state" id="nmStateDailyForm"
                                style="justify-content: center; align-items: center; position: relative;">
                                <div class="nm-back-link" onclick="event.stopPropagation(); showNewMemberChoice();"
                                    style="position: absolute; top: 0; left: 0;">
                                    <i class="fas fa-arrow-left"></i> Back
                                </div>

                                <div class="nm-modern-card">
                                    <div class="nm-card-header">
                                        <div class="icon-circle warning">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h4>Daily Pass</h4>
                                        <p>Single day access for walk-ins</p>
                                    </div>

                                    <div class="nm-form-group">
                                        <label>Full Name</label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-user"></i>
                                            <input type="text" id="dailyPassName" placeholder="Enter customer name..."
                                                onclick="event.stopPropagation();">
                                        </div>
                                    </div>

                                    <button class="btn-primary" onclick="event.stopPropagation(); applyDailyPass();">
                                        Apply Pass <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STATE: Daily Pass Success (No QR) -->
                            <div class="nm-state" id="nmStateDailySuccess"
                                style="justify-content: center; align-items: center;">
                                <div class="nm-modern-card" style="text-align: center; max-width: 320px;">
                                    <div class="nm-card-header">
                                        <div class="icon-circle success"
                                            style="width: 80px; height: 80px; font-size: 32px; margin-bottom: 8px;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <h4 style="font-size: 20px;">Daily Pass Availed!</h4>
                                        <div style="font-size: 14px; color: var(--text-secondary); margin-top: 4px;">
                                            Successfully availed for <span id="dailySuccessName"
                                                style="color: var(--gold); font-weight: 700;">Client</span>
                                        </div>
                                    </div>

                                    <button class="btn-primary" onclick="event.stopPropagation(); finishRegistration();"
                                        style="width: 100%; justify-content: center;">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </button>
                                </div>
                            </div>

                            <!-- STATE: Membership Form -->
                            <div class="nm-state" id="nmStateMembershipForm"
                                style="justify-content: center; align-items: center; position: relative;">
                                <div class="nm-back-link" onclick="event.stopPropagation(); showNewMemberChoice();"
                                    style="position: absolute; top: 0; left: 0;">
                                    <i class="fas fa-arrow-left"></i> Back
                                </div>

                                <div class="nm-modern-card" style="max-width: 500px; padding: 24px;">
                                    <div class="nm-card-header" style="margin-bottom: 8px;">
                                        <div class="icon-circle success">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <h4>Full Membership</h4>
                                        <p>Create a new member profile</p>
                                    </div>

                                    <div class="nm-form-split-layout"
                                        style="display: grid; grid-template-columns: 140px 1fr; gap: 20px; align-items: start;">
                                        <!-- Left Col: Photo -->
                                        <div class="photo-upload-container">
                                            <div class="photo-upload-mini" id="photoUploadBox"
                                                onclick="event.stopPropagation();"
                                                style="height: 140px; border-radius: 16px; background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.1);">
                                                <i class="fas fa-camera"
                                                    style="font-size: 24px; margin-bottom: 8px; color: var(--text-muted);"></i>
                                                <span style="font-size: 11px; color: var(--text-muted);">Upload
                                                    Photo</span>
                                                <input type="file" id="memberPhoto" accept="image/*"
                                                    onchange="previewPhoto(this)" onclick="event.stopPropagation();">
                                            </div>
                                            <button class="remove-photo-btn" id="removePhotoBtn"
                                                onclick="removePhoto(event)" title="Remove Photo"><i
                                                    class="fas fa-times"></i></button>
                                        </div>

                                        <!-- Right Col: Inputs -->
                                        <div class="nm-form-inputs"
                                            style="display: flex; flex-direction: column; gap: 12px;">
                                            <div class="nm-form-group">
                                                <div class="input-wrapper">
                                                    <i class="fas fa-user"></i>
                                                    <input type="text" id="memberName" placeholder="Full Name"
                                                        onclick="event.stopPropagation();">
                                                </div>
                                            </div>
                                            <div class="nm-form-group">
                                                <div class="input-wrapper">
                                                    <i class="fas fa-envelope"></i>
                                                    <input type="email" id="memberEmail" placeholder="Email Address"
                                                        onclick="event.stopPropagation();">
                                                </div>
                                            </div>
                                            <div class="nm-form-group">
                                                <div class="input-wrapper">
                                                    <i class="fas fa-phone"></i>
                                                    <input type="tel" id="memberPhone" placeholder="Phone Number"
                                                        onclick="event.stopPropagation();">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="nm-form-group">
                                        <label style="margin-left: 4px; margin-bottom: 8px;">Select Plan</label>
                                        <div class="plan-grid"
                                            style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                            <div class="plan-card"
                                                onclick="event.stopPropagation(); selectMemberPlan(this, 'Monthly', 800);"
                                                style="background: var(--bg-tertiary); border: 1px solid var(--border); border-radius: 12px; padding: 12px; text-align: center; cursor: pointer; transition: all 0.2s;">
                                                <div class="plan-name"
                                                    style="font-size: 13px; font-weight: 600; color: var(--text-primary);">
                                                    Monthly</div>
                                                <div class="plan-price"
                                                    style="font-size: 16px; font-weight: 700; color: var(--gold); margin-top: 4px;">
                                                    ₱800</div>
                                            </div>
                                            <div class="plan-card"
                                                onclick="event.stopPropagation(); selectMemberPlan(this, 'Instructor', 1250);"
                                                style="background: var(--bg-tertiary); border: 1px solid var(--border); border-radius: 12px; padding: 12px; text-align: center; cursor: pointer; transition: all 0.2s;">
                                                <div class="plan-name"
                                                    style="font-size: 13px; font-weight: 600; color: var(--text-primary);">
                                                    +Instructor</div>
                                                <div class="plan-price"
                                                    style="font-size: 16px; font-weight: 700; color: var(--gold); margin-top: 4px;">
                                                    ₱1,250</div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn-primary" onclick="event.stopPropagation(); activateMembership();"
                                        style="margin-top: 8px;">
                                        Activate Membership <i class="fas fa-bolt"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STATE: Membership Success (No QR) -->
                            <div class="nm-state" id="nmStateMembershipQR"
                                style="justify-content: center; align-items: center;">
                                <div class="nm-modern-card" style="text-align: center; max-width: 340px;">
                                    <div class="nm-card-header">
                                        <div class="icon-circle success"
                                            style="width: 80px; height: 80px; font-size: 32px; margin-bottom: 8px;">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h4 style="font-size: 20px;">Membership Activated!</h4>
                                        <p>Welcome to the club</p>
                                    </div>

                                    <div class="sc-details"
                                        style="background: rgba(0,0,0,0.2); padding: 16px; border-radius: 12px; display: flex; flex-direction: column; gap: 12px; margin-top: 8px; text-align: left;">
                                        <div class="sc-box"
                                            style="display: flex; justify-content: space-between; align-items: center;">
                                            <span class="label"
                                                style="font-size: 11px; text-transform: uppercase; color: var(--text-muted);">Member</span>
                                            <span class="val" id="memberQRName"
                                                style="color: var(--text-primary); font-weight: 600;">Name</span>
                                        </div>
                                        <div class="sc-box"
                                            style="display: flex; justify-content: space-between; align-items: center;">
                                            <span class="label"
                                                style="font-size: 11px; text-transform: uppercase; color: var(--text-muted);">Plan</span>
                                            <span class="val" id="memberQRPlan"
                                                style="color: var(--gold); font-weight: 700;">Plan Details</span>
                                        </div>
                                    </div>

                                    <button class="btn-primary" onclick="event.stopPropagation(); finishRegistration();"
                                        style="width: 100%; justify-content: center; margin-top: 8px;">
                                        <i class="fas fa-check"></i> Done
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cell 4: Directory (Bottom-Right) -->
                <div class="grid-cell" data-pos="bottom-right" onclick="activateCell('bottom-right')">
                    <button class="minimize-btn" onclick="event.stopPropagation(); minimizeCell();"><i
                            class="fas fa-compress-alt"></i></button>
                    <div class="cell-header">
                        <span class="title"
                            style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Directory</span>
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
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search members..." onclick="event.stopPropagation();">
                        </div>
                        <div class="member-list">
                            <div class="member-item">
                                <div class="avatar">JD</div>
                                <div class="info">
                                    <div class="name">John Doe</div>
                                    <div class="meta">Monthly • Active</div>
                                </div><button class="action-btn" onclick="event.stopPropagation();"><i
                                        class="fas fa-eye"></i></button>
                            </div>
                            <div class="member-item">
                                <div class="avatar">AS</div>
                                <div class="info">
                                    <div class="name">Alice Smith</div>
                                    <div class="meta">Weekly • Expiring</div>
                                </div><button class="action-btn" onclick="event.stopPropagation();"><i
                                        class="fas fa-eye"></i></button>
                            </div>
                            <div class="member-item">
                                <div class="avatar">MJ</div>
                                <div class="info">
                                    <div class="name">Mike Johnson</div>
                                    <div class="meta">Annual • Active</div>
                                </div><button class="action-btn" onclick="event.stopPropagation();"><i
                                        class="fas fa-eye"></i></button>
                            </div>
                        </div>
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

    <script src="members.js"></script>
</body>

</html>