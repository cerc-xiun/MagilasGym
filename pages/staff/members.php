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
    <link rel="stylesheet" href="../../css/dashboard.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../../assets/images/logo.png">

    <style>
        /* ===== DYNAMIC GRID SYSTEM ===== */
        .members-grid-container {
            height: calc(100vh - 100px);
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 12px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Grid Cell Base */
        .grid-cell {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            cursor: pointer;
            overflow: hidden;
            position: relative;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .grid-cell:hover {
            border-color: rgba(184, 150, 12, 0.5);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* Cell Header */
        .cell-header {
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-tertiary);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .cell-header .icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .cell-header .icon.gold {
            background: rgba(184, 150, 12, 0.15);
            color: var(--gold);
        }

        .cell-header .icon.green {
            background: rgba(5, 150, 105, 0.15);
            color: var(--success);
        }

        .cell-header .icon.blue {
            background: rgba(59, 130, 246, 0.15);
            color: var(--info);
        }

        .cell-header .icon.orange {
            background: rgba(217, 119, 6, 0.15);
            color: var(--warning);
        }

        .cell-header .title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .cell-header .badge {
            margin-left: auto;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            background: rgba(5, 150, 105, 0.15);
            color: var(--success);
        }

        /* Preview Content (Visible in default state) */
        .cell-preview {
            flex: 1;
            padding: 12px 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow: hidden;
        }

        /* Full Content (Hidden until expanded) */
        .cell-content {
            display: none;
            flex: 1;
            padding: 16px;
            overflow-y: auto;
        }

        /* ===== PREVIEW WIDGETS ===== */
        .preview-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            background: var(--bg-tertiary);
            border-radius: var(--radius-sm);
            font-size: 11px;
        }

        .preview-item .av {
            width: 24px;
            height: 24px;
            background: rgba(184, 150, 12, 0.12);
            color: var(--gold);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
        }

        .preview-item .nm {
            color: var(--text-primary);
            font-weight: 500;
        }

        .preview-item .mt {
            color: var(--text-muted);
            margin-left: auto;
            font-size: 10px;
        }

        .preview-hint {
            margin-top: auto;
            text-align: center;
            font-size: 10px;
            color: var(--text-dim);
            padding: 8px;
        }

        .preview-hint i {
            margin-right: 4px;
        }

        /* QR Preview */
        .qr-preview {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-tertiary);
            border-radius: var(--radius-sm);
            min-height: 80px;
        }

        .qr-preview i {
            font-size: 32px;
            color: var(--gold);
            opacity: 0.6;
        }

        /* Plan Preview */
        .plan-preview {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }

        .plan-mini {
            padding: 8px;
            background: var(--bg-tertiary);
            border-radius: var(--radius-sm);
            text-align: center;
        }

        .plan-mini .pn {
            font-size: 10px;
            color: var(--text-muted);
        }

        .plan-mini .pp {
            font-size: 12px;
            font-weight: 700;
            color: var(--gold);
        }

        /* ===== EXPANDED LAYOUT STATES ===== */
        /* When top-left is active */
        .members-grid-container[data-active="top-left"] {
            grid-template-columns: 2.5fr 1fr;
            grid-template-rows: 2.5fr 1fr;
        }

        .members-grid-container[data-active="top-left"] [data-pos="top-left"] {
            grid-area: 1 / 1 / 2 / 2;
        }

        .members-grid-container[data-active="top-left"] [data-pos="top-right"] {
            grid-area: 1 / 2 / 2 / 3;
        }

        .members-grid-container[data-active="top-left"] [data-pos="bottom-left"] {
            grid-area: 2 / 1 / 3 / 2;
        }

        .members-grid-container[data-active="top-left"] [data-pos="bottom-right"] {
            grid-area: 2 / 2 / 3 / 3;
        }

        /* When top-right is active */
        .members-grid-container[data-active="top-right"] {
            grid-template-columns: 1fr 2.5fr;
            grid-template-rows: 2.5fr 1fr;
        }

        .members-grid-container[data-active="top-right"] [data-pos="top-left"] {
            grid-area: 1 / 1 / 2 / 2;
        }

        .members-grid-container[data-active="top-right"] [data-pos="top-right"] {
            grid-area: 1 / 2 / 2 / 3;
        }

        .members-grid-container[data-active="top-right"] [data-pos="bottom-left"] {
            grid-area: 2 / 1 / 3 / 2;
        }

        .members-grid-container[data-active="top-right"] [data-pos="bottom-right"] {
            grid-area: 2 / 2 / 3 / 3;
        }

        /* When bottom-left is active */
        .members-grid-container[data-active="bottom-left"] {
            grid-template-columns: 2.5fr 1fr;
            grid-template-rows: 1fr 2.5fr;
        }

        .members-grid-container[data-active="bottom-left"] [data-pos="top-left"] {
            grid-area: 1 / 1 / 2 / 2;
        }

        .members-grid-container[data-active="bottom-left"] [data-pos="top-right"] {
            grid-area: 1 / 2 / 2 / 3;
        }

        .members-grid-container[data-active="bottom-left"] [data-pos="bottom-left"] {
            grid-area: 2 / 1 / 3 / 2;
        }

        .members-grid-container[data-active="bottom-left"] [data-pos="bottom-right"] {
            grid-area: 2 / 2 / 3 / 3;
        }

        /* When bottom-right is active */
        .members-grid-container[data-active="bottom-right"] {
            grid-template-columns: 1fr 2.5fr;
            grid-template-rows: 1fr 2.5fr;
        }

        .members-grid-container[data-active="bottom-right"] [data-pos="top-left"] {
            grid-area: 1 / 1 / 2 / 2;
        }

        .members-grid-container[data-active="bottom-right"] [data-pos="top-right"] {
            grid-area: 1 / 2 / 2 / 3;
        }

        .members-grid-container[data-active="bottom-right"] [data-pos="bottom-left"] {
            grid-area: 2 / 1 / 3 / 2;
        }

        .members-grid-container[data-active="bottom-right"] [data-pos="bottom-right"] {
            grid-area: 2 / 2 / 3 / 3;
        }

        /* Active cell shows full content */
        .grid-cell.active .cell-preview {
            display: none;
        }

        .grid-cell.active .cell-content {
            display: flex;
            flex-direction: column;
        }

        .grid-cell.active {
            border-color: var(--gold);
        }

        /* Shrunk cells hide preview detail */
        .grid-cell.shrunk .cell-preview {
            opacity: 0.5;
        }

        .grid-cell.shrunk .preview-hint {
            display: none;
        }

        /* ===== FULL CONTENT STYLES ===== */
        .search-box {
            position: relative;
            margin-bottom: 12px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 12px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 12px 10px 34px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 12px;
            font-family: inherit;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--gold);
        }

        .member-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
            overflow-y: auto;
        }

        .member-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: var(--bg-tertiary);
            border-radius: var(--radius-sm);
        }

        .member-item .avatar {
            width: 32px;
            height: 32px;
            background: rgba(184, 150, 12, 0.12);
            color: var(--gold);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
        }

        .member-item .info {
            flex: 1;
        }

        .member-item .name {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .member-item .meta {
            font-size: 10px;
            color: var(--text-muted);
        }

        .member-item .action-btn {
            padding: 5px 8px;
            font-size: 10px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 4px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .member-item .action-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .member-item .action-btn.danger:hover {
            border-color: var(--danger);
            color: var(--danger);
        }

        .plan-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }

        .plan-card {
            padding: 14px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
        }

        .plan-card:hover,
        .plan-card.selected {
            border-color: var(--gold);
            background: rgba(184, 150, 12, 0.08);
        }

        .plan-card .plan-name {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .plan-card .plan-price {
            font-size: 16px;
            font-weight: 700;
            color: var(--gold);
            margin-top: 4px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: var(--gradient-gold);
            border: none;
            border-radius: var(--radius-sm);
            color: #000;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            margin-top: auto;
        }

        .camera-view {
            height: 180px;
            background: #0a0a0a;
            border-radius: var(--radius-sm);
            position: relative;
            overflow: hidden;
            margin-bottom: 12px;
            border: 1px solid var(--border);
        }

        .camera-view .scan-line {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gold);
            animation: scanMove 2s linear infinite;
        }

        @keyframes scanMove {
            0% {
                top: 0;
            }

            50% {
                top: calc(100% - 2px);
            }

            100% {
                top: 0;
            }
        }

        .camera-view .hint {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
            font-size: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 20px;
            margin-bottom: 6px;
            opacity: 0.4;
            display: block;
        }

        .empty-state p {
            font-size: 11px;
        }

        /* ===== SCAN ENTRY MODERN LAYOUT ===== */
        .scan-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            height: 100%;
        }

        .scan-camera-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .camera-container {
            flex: 1;
            background: #0a0a0a;
            border-radius: var(--radius-md);
            position: relative;
            overflow: hidden;
            border: 2px solid var(--border);
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .camera-container .scan-overlay {
            position: absolute;
            inset: 20px;
            border: 2px solid var(--gold);
            border-radius: var(--radius-sm);
            opacity: 0.6;
        }

        .camera-container .scan-overlay::before,
        .camera-container .scan-overlay::after {
            content: '';
            position: absolute;
            background: var(--gold);
        }

        .camera-container .scan-overlay::before {
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 4px;
        }

        .camera-container .scan-overlay::after {
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 4px;
        }

        .camera-container .scan-beam {
            position: absolute;
            left: 20px;
            right: 20px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            animation: beamScan 2s ease-in-out infinite;
            box-shadow: 0 0 10px var(--gold);
        }

        @keyframes beamScan {

            0%,
            100% {
                top: 25px;
                opacity: 0.8;
            }

            50% {
                top: calc(100% - 25px);
                opacity: 1;
            }
        }

        .camera-container .camera-status {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 20px;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.7);
        }

        .camera-container .camera-status .dot {
            width: 6px;
            height: 6px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        .scan-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .scan-btn {
            padding: 10px;
            border-radius: var(--radius-sm);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .scan-btn.success {
            background: rgba(5, 150, 105, 0.15);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .scan-btn.success:hover {
            background: rgba(5, 150, 105, 0.25);
        }

        .scan-btn.fail {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .scan-btn.fail:hover {
            background: rgba(220, 38, 38, 0.25);
        }

        /* Result Panel */
        .scan-result-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .result-panel {
            flex: 1;
            background: var(--bg-tertiary);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: 200px;
        }

        .result-panel.waiting {
            color: var(--text-muted);
        }

        .result-panel.waiting i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.3;
        }

        .result-panel.waiting p {
            font-size: 12px;
        }

        .result-panel.success {
            border-color: var(--success);
            background: rgba(5, 150, 105, 0.08);
        }

        .result-panel.error {
            border-color: var(--danger);
            background: rgba(220, 38, 38, 0.08);
        }

        .result-member {
            width: 100%;
        }

        .result-member .avatar-large {
            width: 60px;
            height: 60px;
            background: rgba(184, 150, 12, 0.15);
            color: var(--gold);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            margin: 0 auto 12px;
        }

        .result-member .member-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .result-member .member-plan {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .result-member .status-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .result-member .status-tag.active {
            background: rgba(5, 150, 105, 0.15);
            color: var(--success);
        }

        .result-member .status-tag.expired {
            background: rgba(220, 38, 38, 0.15);
            color: var(--danger);
        }

        .result-error {
            width: 100%;
        }

        .result-error i {
            font-size: 40px;
            color: var(--danger);
            margin-bottom: 12px;
        }

        .result-error .error-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--danger);
            margin-bottom: 4px;
        }

        .result-error .error-msg {
            font-size: 11px;
            color: var(--text-muted);
        }

        .allow-entry-btn {
            width: 100%;
            padding: 12px;
            background: var(--gradient-gold);
            border: none;
            border-radius: var(--radius-sm);
            color: #000;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .allow-entry-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
                    <a href="dashboard.php" class="nav-item"><i class="fas fa-th-large"></i> <span>Dashboard</span></a>
                </div>
                <div class="nav-section">
                    <div class="nav-label">Management</div>
                    <a href="members.php" class="nav-item active"><i class="fas fa-users"></i> <span>Members</span></a>
                    <a href="inventory.php" class="nav-item"><i class="fas fa-boxes-stacked"></i>
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
                    <div class="cell-header">
                        <div class="icon orange"><i class="fas fa-users"></i></div>
                        <span class="title">Who's In</span>
                        <span class="badge" id="activeCount">0 Active</span>
                    </div>
                    <div class="cell-preview">
                        <div class="preview-item">
                            <div class="av">JD</div><span class="nm">John Doe</span><span class="mt">2h ago</span>
                        </div>
                        <div class="preview-item">
                            <div class="av">AS</div><span class="nm">Alice Smith</span><span class="mt">1h ago</span>
                        </div>
                        <div class="preview-hint"><i class="fas fa-expand"></i> Click to manage</div>
                    </div>
                    <div class="cell-content" id="whosInContent">
                        <div id="whosInList" class="member-list"></div>
                    </div>
                </div>

                <!-- Cell 2: Scan Entry (Top-Right) -->
                <div class="grid-cell" data-pos="top-right" onclick="activateCell('top-right')">
                    <div class="cell-header">
                        <div class="icon gold"><i class="fas fa-qrcode"></i></div>
                        <span class="title">Scan Entry</span>
                    </div>
                    <div class="cell-preview">
                        <div class="qr-preview"><i class="fas fa-qrcode"></i></div>
                        <div class="preview-hint"><i class="fas fa-camera"></i> Click to scan</div>
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
                                        <i class="fas fa-times"></i> Simulate Fail
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
                                <button class="allow-entry-btn" id="allowEntryBtn" disabled
                                    onclick="event.stopPropagation(); allowEntry();">
                                    <i class="fas fa-door-open"></i> ALLOW ENTRY
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cell 3: New Member (Bottom-Left) -->
                <div class="grid-cell" data-pos="bottom-left" onclick="activateCell('bottom-left')">
                    <div class="cell-header">
                        <div class="icon green"><i class="fas fa-user-plus"></i></div>
                        <span class="title">New Member</span>
                    </div>
                    <div class="cell-preview">
                        <div class="plan-preview">
                            <div class="plan-mini">
                                <div class="pn">Day</div>
                                <div class="pp">₱100</div>
                            </div>
                            <div class="plan-mini">
                                <div class="pn">Week</div>
                                <div class="pp">₱400</div>
                            </div>
                            <div class="plan-mini">
                                <div class="pn">Month</div>
                                <div class="pp">₱1.5K</div>
                            </div>
                            <div class="plan-mini">
                                <div class="pn">Year</div>
                                <div class="pp">₱12K</div>
                            </div>
                        </div>
                        <div class="preview-hint"><i class="fas fa-id-card"></i> Click to activate</div>
                    </div>
                    <div class="cell-content">
                        <div class="plan-grid">
                            <div class="plan-card" onclick="event.stopPropagation(); selectPlan(this, 100);">
                                <div class="plan-name">Day Pass</div>
                                <div class="plan-price">₱100</div>
                            </div>
                            <div class="plan-card" onclick="event.stopPropagation(); selectPlan(this, 400);">
                                <div class="plan-name">Weekly</div>
                                <div class="plan-price">₱400</div>
                            </div>
                            <div class="plan-card" onclick="event.stopPropagation(); selectPlan(this, 1500);">
                                <div class="plan-name">Monthly</div>
                                <div class="plan-price">₱1,500</div>
                            </div>
                            <div class="plan-card" onclick="event.stopPropagation(); selectPlan(this, 12000);">
                                <div class="plan-name">Annual</div>
                                <div class="plan-price">₱12,000</div>
                            </div>
                        </div>
                        <button class="btn-primary" onclick="event.stopPropagation(); confirmActivation();"><i
                                class="fas fa-check-circle"></i> ACTIVATE</button>
                    </div>
                </div>

                <!-- Cell 4: Directory (Bottom-Right) -->
                <div class="grid-cell" data-pos="bottom-right" onclick="activateCell('bottom-right')">
                    <div class="cell-header">
                        <div class="icon blue"><i class="fas fa-address-book"></i></div>
                        <span class="title">Directory</span>
                    </div>
                    <div class="cell-preview">
                        <div class="preview-item">
                            <div class="av">MJ</div><span class="nm">Mike Johnson</span><span class="mt">Active</span>
                        </div>
                        <div class="preview-item">
                            <div class="av">SC</div><span class="nm">Sarah Connor</span><span class="mt">Active</span>
                        </div>
                        <div class="preview-hint"><i class="fas fa-search"></i> Click to search</div>
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

    <script>
        document.getElementById('dateDisplay').textContent = new Date().toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });

        let currentActive = null;
        let gymMembers = [
            { id: 1, name: 'John Doe', initials: 'JD', plan: 'Premium', time: '2h ago' },
            { id: 2, name: 'Alice Smith', initials: 'AS', plan: 'Monthly', time: '1h ago' }
        ];

        function activateCell(position) {
            const grid = document.getElementById('membersGrid');
            const cells = document.querySelectorAll('.grid-cell');

            if (currentActive === position) {
                grid.setAttribute('data-active', 'none');
                cells.forEach(cell => cell.classList.remove('active', 'shrunk'));
                currentActive = null;
                return;
            }

            currentActive = position;
            grid.setAttribute('data-active', position);

            const diagonal = {
                'top-left': 'bottom-right',
                'top-right': 'bottom-left',
                'bottom-left': 'top-right',
                'bottom-right': 'top-left'
            };

            cells.forEach(cell => {
                const pos = cell.getAttribute('data-pos');
                cell.classList.remove('active', 'shrunk');

                if (pos === position) {
                    cell.classList.add('active');
                } else {
                    cell.classList.add('shrunk');
                }
            });
        }

        function renderWhosIn() {
            const list = document.getElementById('whosInList');
            const count = document.getElementById('activeCount');

            if (gymMembers.length === 0) {
                list.innerHTML = '<div class="empty-state"><i class="fas fa-user-clock"></i><p>No members checked in</p></div>';
                count.textContent = '0 Active';
                return;
            }

            list.innerHTML = gymMembers.map(m => `
                <div class="member-item">
                    <div class="avatar">${m.initials}</div>
                    <div class="info"><div class="name">${m.name}</div><div class="meta">${m.plan} • ${m.time}</div></div>
                    <button class="action-btn danger" onclick="event.stopPropagation(); removeMember(${m.id});"><i class="fas fa-sign-out-alt"></i></button>
                </div>
            `).join('');

            count.textContent = gymMembers.length + ' Active';
        }

        function removeMember(id) {
            if (confirm('Mark member as exited?')) {
                gymMembers = gymMembers.filter(m => m.id !== id);
                renderWhosIn();
            }
        }

        // Scan Result State
        let scannedMember = null;

        function resetScanResult() {
            const panel = document.getElementById('scanResultPanel');
            const btn = document.getElementById('allowEntryBtn');
            panel.className = 'result-panel waiting';
            panel.innerHTML = `
                <i class="fas fa-qrcode"></i>
                <p>Waiting for scan...</p>
                <p style="font-size:10px; margin-top:8px; opacity:0.6;">Point camera at member's QR code</p>
            `;
            btn.disabled = true;
            scannedMember = null;
        }

        function simulateScanSuccess() {
            const panel = document.getElementById('scanResultPanel');
            const btn = document.getElementById('allowEntryBtn');
            
            // Simulate finding a valid member
            scannedMember = {
                id: Date.now(),
                name: 'Maria Santos',
                initials: 'MS',
                plan: 'Monthly Premium',
                status: 'active',
                time: 'Just now'
            };

            panel.className = 'result-panel success';
            panel.innerHTML = `
                <div class="result-member">
                    <div class="avatar-large">${scannedMember.initials}</div>
                    <div class="member-name">${scannedMember.name}</div>
                    <div class="member-plan">${scannedMember.plan}</div>
                    <span class="status-tag active"><i class="fas fa-check-circle"></i> Active Member</span>
                </div>
            `;
            btn.disabled = false;
        }

        function simulateScanFail() {
            const panel = document.getElementById('scanResultPanel');
            const btn = document.getElementById('allowEntryBtn');
            
            scannedMember = null;

            panel.className = 'result-panel error';
            panel.innerHTML = `
                <div class="result-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="error-title">Member Not Found</div>
                    <div class="error-msg">This QR code is not registered in the system.<br>Please verify and try again.</div>
                </div>
            `;
            btn.disabled = true;

            // Auto-reset after 3 seconds
            setTimeout(resetScanResult, 3000);
        }

        function allowEntry() {
            if (!scannedMember) return;
            
            gymMembers.unshift(scannedMember);
            renderWhosIn();
            resetScanResult();
            
            // Switch to Who's In to show the new entry
            activateCell('top-left');
        }

        let selectedPlan = null;
        function selectPlan(el, price) {
            document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedPlan = price;
        }

        function confirmActivation() {
            if (!selectedPlan) { alert('Please select a plan first'); return; }
            alert('Membership activated for ₱' + selectedPlan.toLocaleString());
            selectedPlan = null;
            document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
        }

        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });

        renderWhosIn();
    </script>
</body>

</html>