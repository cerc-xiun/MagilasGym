<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Entry | Magilas Gym</title>

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

        /* Camera specific styles */
        .camera-container {
            position: relative;
            background: linear-gradient(145deg, #0a0a0a 0%, #000 100%);
            border-radius: var(--radius-xl, 20px);
            overflow: hidden;
            aspect-ratio: 4/3;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .camera-placeholder {
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
        }

        .camera-placeholder i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .camera-placeholder p {
            font-size: 0.9rem;
        }

        /* Scanning corners animation */
        .scan-corners {
            position: absolute;
            inset: 20%;
            pointer-events: none;
        }

        .scan-corners::before,
        .scan-corners::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border: 3px solid #d4af37;
        }

        .scan-corners::before {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
            border-radius: 8px 0 0 0;
        }

        .scan-corners::after {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
            border-radius: 0 8px 0 0;
        }

        .scan-corners-bottom {
            position: absolute;
            inset: 20%;
            pointer-events: none;
        }

        .scan-corners-bottom::before,
        .scan-corners-bottom::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border: 3px solid #d4af37;
        }

        .scan-corners-bottom::before {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 8px;
        }

        .scan-corners-bottom::after {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
            border-radius: 0 0 8px 0;
        }

        /* Scanning line animation */
        .scan-line {
            position: absolute;
            left: 20%;
            right: 20%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #d4af37, transparent);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
            animation: scanLine 2s ease-in-out infinite;
        }

        @keyframes scanLine {

            0%,
            100% {
                top: 20%;
                opacity: 1;
            }

            50% {
                top: 80%;
                opacity: 0.5;
            }
        }

        .camera-status {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            padding: 10px 24px;
            border-radius: 30px;
            font-size: 0.85rem;
            color: #10b981;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .camera-status::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
        }

        /* Result card */
        .result-card {
            background: var(--gradient-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            height: 100%;
        }

        .result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .result-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 0.04em;
        }

        .waiting-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.4);
        }

        .waiting-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .scan-success {
            text-align: center;
            padding: 20px;
        }

        .member-avatar-large {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.05) 100%);
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #d4af37;
        }

        .member-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .member-plan {
            color: #d4af37;
            margin-bottom: 16px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 32px;
        }

        .btn-allow {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: #000;
            padding: 16px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-allow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4);
        }

        .btn-deny {
            background: transparent;
            color: #ef4444;
            padding: 16px 24px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-deny:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
        }

        .demo-controls {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .demo-controls p {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 12px;
        }

        .scan-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 32px;
            padding: 32px;
        }

        @media (max-width: 1024px) {
            .scan-grid {
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
                    <a href="scan.php" class="nav-item active">
                        <i class="fas fa-qrcode"></i> <span>Scan Entry</span>
                    </a>
                    <a href="activate.php" class="nav-item">
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
                    <h1 class="page-title">Scan <span class="text-accent">Member QR</span></h1>
                </div>
            </header>

            <!-- Scan Header & Action -->
            <div class="scan-header-action" style="margin-bottom: 24px;">
                <button class="btn-allow" style="width: 100%; padding: 20px; font-size: 18px;" onclick="openScanModal()">
                    <i class="fas fa-qrcode" style="font-size: 24px;"></i> SCAN MEMBER QR
                </button>
            </div>

            <!-- Main Content: Who's In List -->
            <div class="panel" style="flex: 1; display: flex; flex-direction: column; overflow: hidden;">
                <div class="panel-header">
                    <h2 class="panel-title"><i class="fas fa-users"></i> Who's In Gym</h2>
                    <span class="member-badge" id="activeLabel">0 Active</span>
                </div>
                <div class="panel-body" id="gymMembersList" style="flex: 1; overflow-y: auto;">
                    <!-- List -->
                </div>
            </div>

            <!-- Scan Modal -->
            <div id="scanModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center;">
                <div class="modal-content" style="background: var(--bg-secondary); border-radius: var(--radius-xl); border: 1px solid var(--border); width: 90%; max-width: 500px; padding: 24px; position: relative;">
                    <button onclick="closeScanModal()" style="position: absolute; top: 16px; right: 16px; color: var(--text-muted); font-size: 20px;"><i class="fas fa-times"></i></button>
                    
                    <h3 style="margin-bottom: 20px; color: var(--text-primary);">Scan QR Code</h3>

                    <!-- Camera View -->
                    <div class="camera-container" style="height: 300px; margin-bottom: 20px;">
                        <!-- Camera Placeholder / Start State -->
                        <div id="camera-placeholder" class="camera-placeholder">
                            <i class="fas fa-camera"></i>
                            <p>Camera is ready</p>
                            <button class="btn-allow" style="margin-top: 16px; padding: 12px 24px;" onclick="startCamera()">
                                <i class="fas fa-power-off"></i> Start Camera
                            </button>
                        </div>
                        
                        <!-- Active Camera State -->
                        <div id="camera-active" class="camera-active" style="display: none; width: 100%; height: 100%;">
                             <div class="scan-corners"></div>
                             <div class="scan-corners-bottom"></div>
                             <div class="scan-line"></div>
                             <div class="camera-status">Scanning...</div>
                        </div>
                    </div>

                    <!-- Scan Result Area -->
                    <div class="result-card" style="border: none; background: transparent; padding: 0;">
                        <div class="result-header" style="padding-bottom: 12px; margin-bottom: 12px;">
                            <h3 class="result-title" style="font-size: 18px;">Result</h3>
                            <span class="status-badge pending" id="scanStatus">Waiting...</span>
                        </div>

                        <!-- Waiting State -->
                        <div id="no-scan" class="waiting-state" style="padding: 20px;">
                            <p>Point camera at member's QR code</p>
                            <div class="demo-controls" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
                                <button class="btn btn-secondary btn-sm" onclick="simulateScan()">
                                    <i class="fas fa-play"></i> Simulate Scan
                                </button>
                            </div>
                        </div>

                        <!-- Scan Success -->
                        <div id="scan-data" class="scan-success" style="display: none;">
                            <div class="member-avatar-large" style="width: 80px; height: 80px; font-size: 32px; margin-bottom: 12px;">JD</div>
                            <h2 class="member-name" style="font-size: 20px;">John Doe</h2>
                            <p class="member-plan">Premium Member</p>
                            <span class="status-badge success">Active</span>

                            <div class="action-buttons" style="margin-top: 20px;">
                                <button class="btn-allow" onclick="allowEntry()">
                                    <i class="fas fa-check"></i> ALLOW
                                </button>
                                <button class="btn-deny" onclick="denyEntry()">
                                    <i class="fas fa-times"></i> DENY
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Demo Data for Who's In
        let gymMembers = [
            { id: 101, name: 'Sarah Connor', initials: 'SC', plan: 'Monthly', time: '2 hours ago' },
            { id: 102, name: 'Mike Johnson', initials: 'MJ', plan: 'Day Pass', time: '1 hour ago' }
        ];

        document.addEventListener('DOMContentLoaded', () => {
            renderGymMembers();
        });

        function renderGymMembers() {
            const list = document.getElementById('gymMembersList');
            const label = document.getElementById('activeLabel');
            
            if (gymMembers.length === 0) {
                list.innerHTML = '<div class="empty-state" style="padding:20px;text-align:center;color:var(--text-muted)"><i class="fas fa-user-slash" style="font-size:24px;margin-bottom:8px"></i><p>No active members</p></div>';
                label.textContent = '0 Active';
                return;
            }

            list.innerHTML = gymMembers.map(m => `
                <div class="member-row">
                    <div class="member-initials">${m.initials}</div>
                    <div class="member-details">
                        <h5>${m.name}</h5>
                        <small>${m.plan} • ${m.time}</small>
                    </div>
                    <button onclick="removeMember(${m.id})" class="btn-deny" style="padding: 6px 12px; font-size: 12px;">
                        <i class="fas fa-sign-out-alt"></i> Exit
                    </button>
                </div>
            `).join('');
            
            label.textContent = `${gymMembers.length} Active`;
        }

        function removeMember(id) {
            if(confirm('Mark member as exited?')) {
                gymMembers = gymMembers.filter(m => m.id !== id);
                renderGymMembers();
            }
        }

        function openScanModal() {
            document.getElementById('scanModal').style.display = 'flex';
        }

        function closeScanModal() {
            document.getElementById('scanModal').style.display = 'none';
            // Optional: reset camera state if desired when closing modal
             document.getElementById('camera-placeholder').style.display = 'flex';
             document.getElementById('camera-active').style.display = 'none';
             resetScan();
        }

        function startCamera() {
            document.getElementById('camera-placeholder').style.display = 'none';
            document.getElementById('camera-active').style.display = 'block';
            document.getElementById('scanStatus').textContent = 'Scanning...';
            // Here you would also initialize the actual QR scanner library
        }

        function simulateScan() {
            startCamera(); // Ensure camera UI is active first
            setTimeout(() => {
                document.getElementById('no-scan').style.display = 'none';
                document.getElementById('scan-data').style.display = 'block';
                document.getElementById('scanStatus').textContent = 'Member Found';
                document.getElementById('scanStatus').className = 'status-badge success';
            }, 800); // Small delay to simulate finding
        }

        function allowEntry() {
            // Add Demo User
            const newMember = {
                id: Date.now(),
                name: 'John Doe',
                initials: 'JD',
                plan: 'Premium',
                time: 'Just now'
            };
            gymMembers.unshift(newMember);
            renderGymMembers();
            
            alert('Entry Allowed! Member added to active list.');
            resetScan();
            closeScanModal(); // Close modal after success
        }

        function denyEntry() {
            alert('Entry Denied.');
            resetScan();
        }

        function resetScan() {
            document.getElementById('no-scan').style.display = 'block';
            document.getElementById('scan-data').style.display = 'none';
            document.getElementById('scanStatus').textContent = 'Waiting...';
            document.getElementById('scanStatus').className = 'status-badge pending';
        }

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>

</html>