<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Search | Magilas Gym</title>

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
            background: #050505;
            color: #fff;
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

        /* Search specific styles */
        .search-container {
            padding: 32px;
        }

        .search-card {
            background: linear-gradient(145deg, rgba(25, 25, 25, 0.95) 0%, rgba(12, 12, 12, 0.98) 100%);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 24px;
            padding: 36px;
        }

        .search-bar {
            display: flex;
            gap: 16px;
            max-width: 700px;
            margin-bottom: 40px;
        }

        .search-input-wrapper {
            flex: 1;
            position: relative;
        }

        .search-input-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .search-input {
            width: 100%;
            padding: 18px 20px 18px 56px;
            font-size: 1rem;
            color: #fff;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .search-input:focus {
            outline: none;
            border-color: #d4af37;
            background: rgba(212, 175, 55, 0.03);
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.08), 0 0 30px rgba(212, 175, 55, 0.1);
        }

        .search-input:focus+i,
        .search-input-wrapper:hover i {
            color: #d4af37;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .search-btn {
            padding: 18px 32px;
            background: linear-gradient(135deg, #d4af37 0%, #f0d875 50%, #d4af37 100%);
            color: #000;
            border: none;
            border-radius: 14px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.4);
        }

        .results-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .results-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 0.04em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .results-title i {
            color: #d4af37;
        }

        .results-count {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .results-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .result-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .result-item:hover {
            border-color: rgba(212, 175, 55, 0.3);
            background: rgba(212, 175, 55, 0.03);
            transform: translateX(8px);
        }

        .result-avatar {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(212, 175, 55, 0.05) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #d4af37;
            flex-shrink: 0;
        }

        .result-info {
            flex: 1;
        }

        .result-info h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .result-info p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .result-actions {
            display: flex;
            gap: 12px;
        }

        .btn-view {
            padding: 12px 24px;
            background: transparent;
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            border-color: #d4af37;
            color: #d4af37;
            background: rgba(212, 175, 55, 0.08);
        }

        .btn-activate {
            padding: 12px 24px;
            background: linear-gradient(135deg, #d4af37, #f0d875);
            color: #000;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.3);
        }

        .btn-activate:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(212, 175, 55, 0.4);
        }

        @media (max-width: 768px) {
            .search-bar {
                flex-direction: column;
            }

            .result-item {
                flex-direction: column;
                text-align: center;
            }

            .result-actions {
                width: 100%;
                justify-content: center;
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
                    <a href="search.php" class="nav-item active">
                        <i class="fas fa-search"></i> <span>Search Member</span>
                    </a>
                    <a href="scan.php" class="nav-item">
                        <i class="fas fa-qrcode"></i> <span>Scan Entry</span>
                    </a>
                    <a href="activate.php" class="nav-item">
                        <i class="fas fa-user-plus"></i> <span>New Membership</span>
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
                    <h1 class="page-title">Find <span class="text-accent">Member</span></h1>
                </div>
            </header>

            <div class="search-container">
                <div class="search-card">
                    <!-- Search Bar -->
                    <div class="search-bar">
                        <div class="search-input-wrapper">
                            <input type="text" class="search-input" placeholder="Search by name, email, or phone..."
                                id="searchInput">
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>

                    <!-- Results -->
                    <div class="results-header">
                        <h3 class="results-title">
                            <i class="fas fa-users"></i> Results
                        </h3>
                        <span class="results-count" id="resultsCount">2 members found</span>
                    </div>

                    <div class="results-list" id="resultsList">
                        <!-- Result 1 -->
                        <div class="result-item">
                            <div class="result-avatar">JD</div>
                            <div class="result-info">
                                <h4>John Doe</h4>
                                <p>john@example.com • 0912 345 6789</p>
                            </div>
                            <div class="result-actions">
                                <a href="activate.php" class="btn-view">View Profile</a>
                            </div>
                        </div>

                        <!-- Result 2 -->
                        <div class="result-item">
                            <div class="result-avatar">JS</div>
                            <div class="result-info">
                                <h4>Jane Smith</h4>
                                <p>jane.smith@email.com • 0998 765 4321</p>
                            </div>
                            <div class="result-actions">
                                <a href="activate.php" class="btn-activate">
                                    <i class="fas fa-bolt"></i> Activate Plan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();
            if (!query) {
                alert('Please enter a search term');
                return;
            }
            // Demo search - would connect to API
            console.log('Searching for:', query);
        }

        // Enter key search
        document.getElementById('searchInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') performSearch();
        });

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>

</html>