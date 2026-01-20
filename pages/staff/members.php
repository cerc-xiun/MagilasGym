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
        :root {
            --active-ratio: 2.5fr;
            --inactive-ratio: 1fr;
        }

        /* ===== DYNAMIC GRID SYSTEM ===== */
        .members-grid-container {
            height: calc(100vh - 140px);
            /* Increased offset to prevent bottom cutoff */
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            /* Ensure strict containment */
            grid-template-rows: 1fr 1fr;
            gap: 12px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Header Date Pill */
        .header-date {
            padding: 8px 20px;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-date i {
            color: var(--gold);
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

        /* Full Content (Always Visible for Who's In, others toggled) */
        .cell-content {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: none;
            /* Default hidden for others */
        }

        /* Override for Who's In - Always show content */
        [data-pos="top-left"] .cell-content {
            display: flex;
            flex-direction: column;
            padding: 0 12px 12px;
            /* Adjusted padding */
        }

        /* Hide preview logic completely */
        }

        [data-pos="top-right"] .cell-preview {
            display: none !important;
        }

        [data-pos="top-right"] .cell-content,
        [data-pos="bottom-left"] .cell-content,
        [data-pos="bottom-right"] .cell-content {
            display: flex;
            /* Always show content (under overlay when inactive) */
            flex-direction: column;
            padding: 16px;
            height: 100%;
            /* Fill cell */
        }

        /* Inactive Overlay for Scan Entry */
        /* Inactive Overlay Shared Styles */
        [data-pos="top-right"]:not(.active)::after,
        [data-pos="bottom-left"]:not(.active)::after,
        [data-pos="bottom-right"]:not(.active)::after {
            position: absolute;
            top: 50px;
            /* Below header */
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.7));
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1px;
            z-index: 10;
            opacity: 1;
            transition: opacity 0.2s;
            pointer-events: none;
            /* Let click pass to grid-cell to activate */
        }

        /* Specific Content Strings */
        [data-pos="top-right"]:not(.active)::after {
            content: "Click to Scan";
        }

        [data-pos="bottom-left"]:not(.active)::after {
            content: "Click to Register";
        }

        [data-pos="bottom-right"]:not(.active)::after {
            content: "Click to Search";
        }

        /* Hide scan buttons when inactive to keep it clean */
        [data-pos="top-right"]:not(.active) .scan-buttons {
            display: none;
        }

        /* Disable interaction on bottom panels when inactive */
        [data-pos="bottom-left"]:not(.active) .cell-content,
        [data-pos="bottom-right"]:not(.active) .cell-content {
            pointer-events: none;
        }

        [data-pos="top-right"]:not(.active) .camera-status {
            display: none;
        }

        /* Show content when active for others */
        .grid-cell.active .cell-content {
            display: block;
        }

        /* Hide preview when active */
        .grid-cell.active .cell-preview {
            display: none;
        }

        /* Inactive State for Who's In */
        /* Inactive State Hiding (Search, Buttons, etc.) */
        [data-pos="top-left"]:not(.active) .whos-in-search,
        [data-pos="top-left"]:not(.active) .minimize-btn,
        [data-pos="bottom-left"]:not(.active) .minimize-btn,
        [data-pos="bottom-right"]:not(.active) .minimize-btn,
        [data-pos="top-left"]:not(.active) .member-list-header {
            /* Hide search and headers when inactive if desired, or keep headers? 
                User said "time in header should be aligned... same to the other header".
                User likely wants headers. I'll keep headers, hide search. */
            display: none;
        }

        [data-pos="top-left"]:not(.active) .member-list {
            padding: 0;
            /* Remove padding when small */
            gap: 4px;
        }

        [data-pos="top-left"]:not(.active) .member-item {
            padding: 8px 12px;
            grid-template-columns: 32px 1fr 0.8fr 60px 0px;
            /* Hide button column effectively or shift */
        }

        [data-pos="top-left"]:not(.active) .member-item .action-btn-left {
            display: none;
        }

        [data-pos="top-left"]:not(.active) .avatar {
            width: 32px;
            height: 32px;
            font-size: 11px;
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

        /* Plan Preview - Larger for New Member */
        [data-pos="bottom-left"] .plan-preview {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            flex: 1;
        }

        [data-pos="bottom-left"] .plan-mini {
            padding: 16px 12px;
            background: var(--bg-tertiary);
            border-radius: var(--radius-sm);
            text-align: center;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        [data-pos="bottom-left"] .plan-mini .pn {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        [data-pos="bottom-left"] .plan-mini .pp {
            font-size: 18px;
            font-weight: 700;
            color: var(--gold);
        }

        /* ===== EXPANDED LAYOUT STATES ===== */
        /* When top-left is active */
        /* When top-left is active */
        /* When top-left is active */
        .members-grid-container[data-active="top-left"] {
            grid-template-columns: var(--active-ratio) var(--inactive-ratio);
            grid-template-rows: var(--active-ratio) var(--inactive-ratio);
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
            grid-template-columns: var(--inactive-ratio) var(--active-ratio);
            grid-template-rows: var(--active-ratio) var(--inactive-ratio);
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
            grid-template-columns: var(--active-ratio) var(--inactive-ratio);
            grid-template-rows: var(--inactive-ratio) var(--active-ratio);
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
            grid-template-columns: var(--inactive-ratio) var(--active-ratio);
            grid-template-rows: var(--inactive-ratio) var(--active-ratio);
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

        /* Responsive "Who's In" List: Hide columns when squeezed */
        .members-grid-container[data-active="top-right"] [data-pos="top-left"] .member-list-header,
        .members-grid-container[data-active="bottom-right"] [data-pos="top-left"] .member-list-header,
        .members-grid-container[data-active="top-right"] [data-pos="top-left"] .member-item,
        .members-grid-container[data-active="bottom-right"] [data-pos="top-left"] .member-item {
            grid-template-columns: 48px 1fr !important;
        }

        .members-grid-container[data-active="top-right"] [data-pos="top-left"] .member-list-header>div:nth-child(n+3),
        .members-grid-container[data-active="bottom-right"] [data-pos="top-left"] .member-list-header>div:nth-child(n+3),
        .members-grid-container[data-active="top-right"] [data-pos="top-left"] .member-item>div:nth-child(n+3),
        .members-grid-container[data-active="bottom-right"] [data-pos="top-left"] .member-item>div:nth-child(n+3),
        .members-grid-container[data-active="top-right"] [data-pos="top-left"] .member-item>button,
        .members-grid-container[data-active="bottom-right"] [data-pos="top-left"] .member-item>button {
            display: none !important;
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

        /* Who's In List - Columnar Layout */
        #whosInContent .member-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding-right: 4px;
            /* Space for scrollbar */
        }

        #whosInContent .member-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 4px 12px;
            overflow-y: auto;
            max-height: calc(100vh - 300px);
            /* Limit height */
        }

        .whos-in-search {
            padding: 0 12px 12px;
        }

        .whos-in-search input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            /* Reduced vertical padding */
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 13px;
            box-sizing: border-box;
            /* Fix width overflow */
        }

        .whos-in-search input:focus {
            outline: none;
            border-color: var(--gold);
        }

        .whos-in-search .search-wrapper i {
            position: absolute;
            left: 14px;
            /* Closer to edge */
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
            pointer-events: none;
            margin: 0;
            /* Reset margins */
        }

        /* Relative wrapper for search icon */
        .whos-in-search .search-wrapper {
            position: relative;
        }

        /* Remove specific overrides if generic selector serves */

        .member-list-header {
            display: grid;
            grid-template-columns: 48px 2fr 1.2fr 1.2fr 120px;
            /* Balanced proportions */
            padding: 0 16px 8px 16px;
            gap: 12px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .member-list-header div:nth-child(4) {
            /* padding-left removal for alignment */
        }

        .member-list-header div:last-child {
            display: none;
        }

        #whosInContent .member-item {
            display: grid;
            grid-template-columns: 48px 2fr 1.2fr 1.2fr 120px;
            /* Match balanced */
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: right center;
        }

        /* Smooth transition for content appearance */
        .cell-content {
            transition: opacity 0.3s ease;
        }

        /* Hover Effect: Highlight entire row instead of button */
        /* Hover Effect: Highlight entire row */
        #whosInContent .member-item:hover {
            transform: scale(1.01);
            /* Reduced scale */
            border-color: var(--gold);
            background: var(--bg-secondary);
            z-index: 5;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            /* transform-origin handled in base class */
        }

        /* Inactive Overlay for Who's In */
        [data-pos="top-left"]:not(.active)::after {
            content: "Click to Manage";
            position: absolute;
            top: 60px;
            /* Below header */
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1px;
            z-index: 10;
            opacity: 0;
            /* Initially hidden or always visible? User said "semi-visible dark div that covers" */
            transition: opacity 0.2s;
        }

        [data-pos="top-left"]:not(.active):hover::after {
            opacity: 1;
            /* Show text on hover, always darken? */
        }

        /* Make dark overlay always visible but text on hover? 
           User: "semi-visible dark div that covers... not header"
           Let's make bg always visible, text on hover.
        */
        [data-pos="top-left"]:not(.active)::after {
            opacity: 1;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.7));
        }

        #whosInContent .member-item .avatar {
            width: 40px;
            height: 40px;
            font-size: 14px;
            background: rgba(184, 150, 12, 0.12);
            color: var(--gold);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        #whosInContent .member-item .col-info {
            display: flex;
            flex-direction: column;
        }

        #whosInContent .member-item .col-info .main-text {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #whosInContent .member-item .col-info .sub-text {
            color: var(--text-muted);
            font-size: 11px;
        }

        #whosInContent .action-btn-left {
            width: 100%;
            padding: 8px;
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
            border-radius: var(--radius-sm);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        #whosInContent .action-btn-left:hover {
            background: var(--danger);
            color: white;
            /* Disabled default scale/translate transform on hover as row handles it */
            transform: none;
        }

        /* Increase Header Font and Size only for Who's In Panel Content */
        .grid-cell[data-pos="top-left"] .cell-header .title {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .grid-cell[data-pos="top-left"] .cell-header {
            padding-bottom: 12px;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Updated Modal Styles */
        .custom-modal {
            background: #18191a;
            border: 1px solid #333;
            border-radius: 12px;
            width: 90%;
            max-width: 360px;
            padding: 32px 24px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8);
        }

        .modal-icon {
            width: 64px;
            height: 64px;
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
        }

        .modal-title {
            font-size: 20px;
            margin-bottom: 8px;
            color: var(--text-primary);
            letter-spacing: -0.5px;
        }

        .modal-text {
            color: var(--text-muted);
            margin-bottom: 28px;
            line-height: 1.5;
            font-size: 14px;
        }

        .modal-btn.confirm:hover {
            background: #000;
            color: #fff;
            border: 1px solid var(--gold);
        }

        /* Active Indicator */
        .active-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(184, 150, 12, 0.15);
            padding: 6px 14px;
            border-radius: 20px;
            color: var(--gold);
            font-weight: 700;
            font-size: 13px;
            margin-left: 20px;
            /* Added spacing from title */
        }

        .active-indicator i {
            font-size: 14px;
        }

        /* Minimize Button */
        .minimize-btn {
            position: absolute;
            top: 16px;
            /* Aligned with header padding */
            right: 16px;
            width: 32px;
            height: 32px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
            z-index: 10;
        }

        .minimize-btn:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .grid-cell.active .minimize-btn {
            opacity: 1;
            visibility: visible;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .modal-btn {
            flex: 1;
            padding: 12px;
            border-radius: 50px;
            /* More rounded */
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            /* Prevent layout shift */
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .modal-btn.cancel {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .modal-btn.cancel:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--text-muted);
        }

        .modal-btn.confirm {
            background: #fff;
            color: #000;
        }

        .modal-btn.confirm:hover {
            background: #fff;
            color: #000;
            border-color: #fff;
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .modal-btn.cancel {
            background: var(--bg-tertiary);
            color: var(--text-muted);
        }

        .modal-btn.cancel:hover {
            background: var(--border);
            color: var(--text-primary);
        }

        .modal-btn.confirm {
            background: var(--gold);
            color: black;
        }

        .modal-btn.confirm:hover {
            background: #000;
            /* Black background on hover */
            color: #fff;
            /* White text on hover */
            border: 1px solid var(--gold);
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

        /* Scan Card Styles */
        .scan-card {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 12px;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border: 2px solid var(--border);
            width: 100%;
        }

        .scan-card.inactive {
            border-color: var(--danger);
        }

        .sc-status {
            text-align: center;
            background: var(--bg-tertiary);
            padding: 6px 16px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            align-self: center;
            width: fit-content;
            margin-bottom: 4px;
        }

        .sc-status.active {
            background: rgba(5, 150, 105, 0.2);
            color: var(--success);
        }

        .sc-status.inactive {
            background: rgba(220, 38, 38, 0.2);
            color: var(--danger);
        }

        .sc-image {
            width: 250px;
            height: 250px;
            /* Fixed square */
            background: #000;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            flex-shrink: 0;
        }

        .sc-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Show whole photo */
        }

        .sc-details {
            display: flex;
            gap: 12px;
            margin-top: auto;
        }

        .sc-box {
            flex: 1;
            background: var(--bg-tertiary);
            border-radius: 6px;
            padding: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .sc-box .label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sc-box .val {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 4px;
        }

        .sc-box .expired-text {
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

        /* Action Buttons */
        .scan-actions {
            display: flex;
            gap: 12px;
            margin-top: 12px;
            width: 100%;
        }

        .allow-entry-btn {
            flex: 1;
            padding: 12px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            font-weight: 600;
            cursor: not-allowed;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            font-size: 13px;
            transition: all 0.2s;
        }

        .allow-entry-btn:not([disabled]).success {
            background: var(--success);
            color: #fff;
            border-color: var(--success);
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4);
        }

        .allow-entry-btn:not([disabled]).warning {
            background: #f59e0b;
            /* Orange */
            color: #fff;
            border-color: #f59e0b;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .allow-entry-btn.secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            cursor: pointer;
            border-color: var(--text-muted);
        }

        .allow-entry-btn.secondary:hover {
            background: var(--border);
        }

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

        /* ===== NEW MEMBER MULTI-STATE UI ===== */
        .new-member-container {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .nm-state {
            display: none;
            flex-direction: column;
            height: 100%;
        }

        .nm-state.active {
            display: flex;
        }

        /* Choice Cards */
        .choice-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            flex: 1;
        }

        .choice-card {
            background: var(--bg-tertiary);
            border: 2px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .choice-card:hover {
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .choice-card .choice-icon {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .choice-card .choice-icon.daily {
            background: rgba(217, 119, 6, 0.15);
            color: var(--warning);
        }

        .choice-card .choice-icon.membership {
            background: rgba(5, 150, 105, 0.15);
            color: var(--success);
        }

        .choice-card .choice-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .choice-card .choice-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--gold);
        }

        .choice-card .choice-desc {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Form Styles */
        .nm-form-split-layout {
            display: grid;
            grid-template-columns: 40% 1fr;
            gap: 16px;
            margin-bottom: 12px;
            align-items: stretch;
        }

        .nm-form-inputs {
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: space-between;
        }

        .nm-form-group {
            margin-bottom: 0;
            width: 100%;
        }

        .nm-form-group label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nm-form-group input {
            width: 100%;
            padding: 8px 10px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 12px;
            font-family: inherit;
            box-sizing: border-box;
        }

        .nm-form-group input:focus {
            outline: none;
            border-color: var(--gold);
        }

        .nm-back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 12px;
            cursor: pointer;
        }

        .nm-back-link:hover {
            color: var(--gold);
        }

        /* QR Display */
        .qr-display {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 12px;
        }

        .qr-box {
            width: 140px;
            height: 140px;
            background: #fff;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }

        .qr-box i {
            font-size: 80px;
            color: #222;
        }

        .qr-member-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .qr-member-type {
            font-size: 12px;
            color: var(--gold);
            font-weight: 600;
        }

        .qr-expires {
            font-size: 10px;
            color: var(--text-muted);
        }

        /* Modern Daily Pass UI */
        .nm-modern-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px 24px;
            width: 100%;
            max-width: 340px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        .nm-card-header {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .nm-card-header .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 4px;
        }

        .nm-card-header .icon-circle.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .nm-card-header .icon-circle.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .nm-card-header h4 {
            font-size: 18px;
            color: var(--text-primary);
            margin: 0;
        }

        .nm-card-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .nm-form-group .input-wrapper {
            position: relative;
        }

        .nm-form-group .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .nm-form-group .input-wrapper input {
            padding-left: 40px;
            /* Space for icon */
            height: 48px;
            /* Taller input */
            border-radius: 12px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            font-size: 14px;
        }

        .nm-form-group .input-wrapper input:focus {
            background: var(--bg-primary);
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(184, 150, 12, 0.15);
        }

        /* Photo Upload */
        .photo-upload-container {
            position: relative;
            height: 100%;
        }

        .photo-upload-mini {
            width: 100%;
            height: 180px;
            /* Increased height by ~15% */
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 11px;
            color: var(--text-muted);
            overflow: hidden;
            flex-direction: column;
            text-align: center;
        }

        .photo-upload-mini:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .photo-upload-mini i {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .photo-upload-mini.has-photo {
            border-style: solid;
            padding: 0;
            height: 180px;
            min-height: unset;
        }

        .remove-photo-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--danger);
            color: white;
            border: 2px solid var(--bg-primary);
            /* Border to separate from image */
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            font-size: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .remove-photo-btn:hover {
            transform: scale(1.1);
        }

        .photo-upload-mini .photo-preview {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #111;
            margin: 0;
        }

        .photo-upload-mini input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            top: 0;
            left: 0;
        }

        /* Status Dropdown */
        .status-dropdown {
            padding: 4px 8px;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            border-radius: 4px;
            color: var(--text-secondary);
            font-size: 10px;
            cursor: pointer;
        }

        .status-dropdown:focus {
            outline: none;
            border-color: var(--gold);
        }

        /* ===== PENDING MEMBERSHIPS ===== */
        .nav-badge {
            margin-left: auto;
            background: var(--danger);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .pending-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .pending-modal.active {
            display: flex;
        }

        .pending-modal-content {
            background: var(--bg-secondary);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            width: 100%;
            max-width: 500px;
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .pending-modal-header {
            padding: 16px 20px;
            background: var(--bg-tertiary);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pending-modal-header h3 {
            font-size: 14px;
            color: var(--text-primary);
            margin: 0;
        }

        .pending-modal-close {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 16px;
            cursor: pointer;
        }

        .pending-modal-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .pending-card {
            background: var(--bg-tertiary);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            padding: 16px;
            margin-bottom: 12px;
        }

        .pending-card:last-child {
            margin-bottom: 0;
        }

        .pending-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .pending-card-photo {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-sm);
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dim);
            font-size: 24px;
            overflow: hidden;
        }

        .pending-card-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pending-card-info h4 {
            font-size: 14px;
            color: var(--text-primary);
            margin: 0 0 4px 0;
        }

        .pending-card-info p {
            font-size: 11px;
            color: var(--text-muted);
            margin: 2px 0;
        }

        .pending-card-actions {
            display: flex;
            gap: 8px;
        }

        .pending-btn {
            flex: 1;
            padding: 10px;
            border-radius: var(--radius-sm);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .pending-btn.approve {
            background: rgba(5, 150, 105, 0.15);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .pending-btn.reject {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .pending-btn:hover {
            opacity: 0.8;
        }

        .pending-empty {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
        }

        .pending-empty i {
            font-size: 32px;
            opacity: 0.3;
            margin-bottom: 12px;
            display: block;
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
                    <a href="#" class="nav-item" onclick="openPendingModal(); return false;"><i
                            class="fas fa-user-clock"></i> <span>Pending</span><span class="nav-badge"
                            id="pendingCount">2</span></a>
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
                    <button class="minimize-btn" onclick="event.stopPropagation(); minimizeCell();"><i
                            class="fas fa-compress-alt"></i></button>
                    <div class="cell-header">
                        <span class="title" style="margin: 0 auto; font-size: 18px; letter-spacing: 1px;">Who's
                            In</span>
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
                    <!-- Preview removed, using content UI -->
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
                    <!-- Preview removed/Overlay logic used -->
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
                                        <div style="font-size: 12px; color: var(--text-dim); margin-top: 8px;">
                                            Added to Who's In List
                                        </div>
                                    </div>

                                    <button class="btn-primary" onclick="event.stopPropagation(); finishRegistration();"
                                        style="width: 100%; justify-content: center;">
                                        <i class="fas fa-arrow-left"></i> Back to Choices
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
                            <div class="nm-state" id="nmStateMembershipQR" style="justify-content: center; align-items: center;">
                                <div class="nm-modern-card" style="text-align: center; max-width: 340px;">
                                    <div class="nm-card-header">
                                        <div class="icon-circle success" style="width: 80px; height: 80px; font-size: 32px; margin-bottom: 8px;">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h4 style="font-size: 20px;">Membership Activated!</h4>
                                        <p>Welcome to the club</p>
                                    </div>

                                    <div class="sc-details" style="background: rgba(0,0,0,0.2); padding: 16px; border-radius: 12px; display: flex; flex-direction: column; gap: 12px; margin-top: 8px; text-align: left;">
                                        <div class="sc-box" style="display: flex; justify-content: space-between; align-items: center;">
                                            <span class="label" style="font-size: 11px; text-transform: uppercase; color: var(--text-muted);">Member</span>
                                            <span class="val" id="memberQRName" style="color: var(--text-primary); font-weight: 600;">Name</span>
                                        </div>
                                        <div class="sc-box" style="display: flex; justify-content: space-between; align-items: center;">
                                            <span class="label" style="font-size: 11px; text-transform: uppercase; color: var(--text-muted);">Plan</span>
                                            <span class="val" id="memberQRPlan" style="color: var(--gold); font-weight: 700;">Plan Details</span>
                                        </div>
                                    </div>
                                    
                                    <button class="btn-primary" onclick="event.stopPropagation(); finishRegistration();" style="width: 100%; justify-content: center; margin-top: 8px;">
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
                    <!-- Preview removed/Overlay logic used -->
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
            { id: 1, name: 'John Doe', initials: 'JD', type: 'membership', plan: 'Premium', time: '08:05 AM', status: 'in' },
            { id: 2, name: 'Alice Smith', initials: 'AS', type: 'daily', plan: 'Day Pass', time: '08:15 AM', status: 'in' },
            { id: 3, name: 'Michael Jordan', initials: 'MJ', type: 'membership', plan: 'Standard', time: '08:30 AM', status: 'in' },
            { id: 4, name: 'Sarah Connor', initials: 'SC', type: 'membership', plan: 'Standard', time: '08:45 AM', status: 'in' },
            { id: 5, name: 'Tony Stark', initials: 'TS', type: 'daily', plan: 'Day Pass', time: '09:00 AM', status: 'in' },
            { id: 6, name: 'Bruce Wayne', initials: 'BW', type: 'membership', plan: 'Premium', time: '09:10 AM', status: 'in' },
            { id: 7, name: 'Clark Kent', initials: 'CK', type: 'membership', plan: 'Standard', time: '09:20 AM', status: 'in' },
            { id: 8, name: 'Diana Prince', initials: 'DP', type: 'membership', plan: 'Standard', time: '09:30 AM', status: 'in' },
            { id: 9, name: 'Peter Parker', initials: 'PP', type: 'daily', plan: 'Day Pass', time: '09:45 AM', status: 'in' },
            { id: 10, name: 'Natasha Romanoff', initials: 'NR', type: 'membership', plan: 'Premium', time: '10:00 AM', status: 'in' },
            { id: 11, name: 'Steve Rogers', initials: 'SR', type: 'membership', plan: 'Standard', time: '10:15 AM', status: 'in' }
        ];

        function activateCell(position) {
            const grid = document.getElementById('membersGrid');
            const cells = document.querySelectorAll('.grid-cell');

            // If this cell is already active, DO NOT toggle it off when clicking inside
            // Only the minimize button should close it
            if (currentActive === position) {
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

        function minimizeCell() {
            const grid = document.getElementById('membersGrid');
            const cells = document.querySelectorAll('.grid-cell');

            grid.setAttribute('data-active', 'none');
            cells.forEach(cell => cell.classList.remove('active', 'shrunk'));
            currentActive = null;
        }

        // Exit Confirmation Logic
        let memberToExit = null;

        function openExitConfirmation(id) {
            memberToExit = id;
            document.getElementById('exitModal').classList.add('active');
        }

        function closeExitConfirmation() {
            document.getElementById('exitModal').classList.remove('active');
            memberToExit = null;
        }

        function confirmExit() {
            if (memberToExit) {
                gymMembers = gymMembers.filter(m => m.id !== memberToExit);
                renderWhosIn();
                closeExitConfirmation();
            }
        }

        // Filter Logic
        function filterWhosIn() {
            renderWhosIn();
        }

        function renderWhosIn() {
            const list = document.getElementById('whosInList');
            const count = document.getElementById('activeCount');
            const searchTerm = document.getElementById('whosInSearch') ? document.getElementById('whosInSearch').value.toLowerCase() : '';

            // Filter out members who have 'left' and match search
            const activeMembers = gymMembers.filter(m => {
                return m.status !== 'left' && m.name.toLowerCase().includes(searchTerm);
            });

            // Update Count (Always icon + number)
            count.innerHTML = `<i class="fas fa-user"></i> <span>${activeMembers.length}</span>`;

            if (activeMembers.length === 0) {
                list.innerHTML = '<div class="empty-state"><i class="fas fa-user-clock"></i><p>No members found</p></div>';
                return;
            }

            // Columns: Avatar | Name | Type | Time | Action
            list.innerHTML = activeMembers.map(m => `
                <div class="member-item">
                    <div class="avatar">${m.initials}</div>
                    
                    <div class="col-info">
                        <span class="main-text">${m.name}</span>
                    </div>

                    <div class="col-info">
                        <span class="main-text" style="font-size:12px;">${m.type === 'daily' ? 'Day Pass' : 'Membership'}</span>
                    </div>

                    <div class="col-info">
                        <span class="main-text" style="font-size:12px;">${m.time}</span>
                    </div>

                    <button class="action-btn-left" onclick="event.stopPropagation(); openExitConfirmation(${m.id})">
                        <i class="fas fa-sign-out-alt"></i> Left
                    </button>
                </div>
            `).join('');

            // Removed textContent update since innerHTML was used above
        }

        // Scan Result State
        let scannedMember = null;

        function resetScanResult() {
            const panel = document.getElementById('scanResultPanel');
            const actions = document.getElementById('scanActions');
            panel.className = 'result-panel waiting';
            panel.innerHTML = `
                <i class="fas fa-qrcode"></i>
                <p>Waiting for scan...</p>
                <p style="font-size:10px; margin-top:8px; opacity:0.6;">Point camera at member's QR code</p>
            `;

            if (actions) {
                actions.innerHTML = `
                <button class="allow-entry-btn" id="allowEntryBtn" disabled>
                    <i class="fas fa-door-open"></i> ALLOW ENTRY
                </button>
               `;
            }
            scannedMember = null;
        }

        function simulateScanSuccess() {
            const panel = document.getElementById('scanResultPanel');
            const actions = document.getElementById('scanActions');

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
            // Layout Textures
            panel.innerHTML = `
                <div class="scan-card">
                    <div class="sc-status active">ACTIVE</div>
                    <div class="sc-image">
                       <img src="../../assets/images/member_sample.png" alt="Member" />
                    </div>
                    <div class="sc-details">
                        <div class="sc-box">
                            <span class="label">Name</span>
                            <span class="val">${scannedMember.name}</span>
                        </div>
                        <div class="sc-box">
                            <span class="label">Member Type</span>
                            <span class="val">Member</span>
                        </div>
                    </div>
                </div>
            `;

            // Actions
            actions.innerHTML = `
                <button class="allow-entry-btn success" onclick="event.stopPropagation(); allowEntry();">
                    <i class="fas fa-check"></i> Allow Entry
                </button>
                <button class="allow-entry-btn secondary" onclick="event.stopPropagation(); resetScanResult();">
                    <i class="fas fa-redo"></i> Rescan
                </button>
            `;
        }

        function simulateScanExpired() {
            const panel = document.getElementById('scanResultPanel');
            const actions = document.getElementById('scanActions');

            scannedMember = null; // No entry allowed

            panel.className = 'result-panel expired';
            panel.innerHTML = `
                <div class="scan-card inactive">
                    <div class="sc-status inactive">INACTIVE</div>
                    <div class="sc-image">
                       <img src="../../assets/images/member_sample.png" alt="Member" style="filter: grayscale(1);" />
                    </div>
                    <div class="sc-details">
                        <div class="sc-box">
                            <span class="label">Name</span>
                            <span class="val">Maria Santos</span>
                        </div>
                        <div class="sc-box">
                            <span class="label">Status</span>
                            <span class="val expired-text">Expired</span>
                        </div>
                    </div>
                </div>
            `;

            // Actions: Renew and Rescan
            // Actions: Renew and Rescan separated
            actions.innerHTML = `
                <button class="allow-entry-btn warning" onclick="event.stopPropagation(); alert('Redirecting to Renewal UI...');">
                    <i class="fas fa-sync"></i> Renew
                </button>
                <button class="allow-entry-btn secondary" onclick="event.stopPropagation(); resetScanResult();">
                    <i class="fas fa-redo"></i> Rescan
                </button>
            `;
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

        // ===== NEW MEMBER STATE MANAGEMENT =====
        function setNmState(stateId) {
            document.querySelectorAll('.nm-state').forEach(s => s.classList.remove('active'));
            document.getElementById(stateId).classList.add('active');
        }

        function showNewMemberChoice() {
            setNmState('nmStateChoice');
            // Clear forms
            document.getElementById('dailyPassName').value = '';
            document.getElementById('memberName').value = '';
            document.getElementById('memberEmail').value = '';
            document.getElementById('memberPhone').value = '';
            selectedMemberPlan = null;
            document.querySelectorAll('#nmStateMembershipForm .plan-card').forEach(c => c.classList.remove('selected'));
        }

        function showDailyPassForm() {
            setNmState('nmStateDailyForm');
        }

        function showMembershipForm() {
            setNmState('nmStateMembershipForm');
        }

        function applyDailyPass() {
            const name = document.getElementById('dailyPassName').value.trim();
            if (!name) {
                alert('Please enter customer name');
                return;
            }

            // Generate initials
            const parts = name.split(' ');
            const initials = parts.length >= 2
                ? parts[0][0].toUpperCase() + parts[parts.length - 1][0].toUpperCase()
                : name.substring(0, 2).toUpperCase();

            // Add to gym members
            const newMember = {
                id: Date.now(),
                name: name,
                initials: initials,
                type: 'daily',
                plan: 'Day Pass',
                time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
                status: 'in'
            };
            gymMembers.unshift(newMember);
            renderWhosIn();

            // Update Success Display
            document.getElementById('dailySuccessName').textContent = name;

            // Show Success state (No QR)
            setNmState('nmStateDailySuccess');
        }

        let selectedMemberPlan = null;
        function selectMemberPlan(el, planName, price) {
            document.querySelectorAll('#nmStateMembershipForm .plan-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedMemberPlan = { name: planName, price: price };
        }

        function activateMembership() {
            const name = document.getElementById('memberName').value.trim();
            const email = document.getElementById('memberEmail').value.trim();
            const phone = document.getElementById('memberPhone').value.trim();

            if (!name) { alert('Please enter full name'); return; }
            if (!email) { alert('Please enter email'); return; }
            if (!phone) { alert('Please enter phone number'); return; }
            if (!selectedMemberPlan) { alert('Please select a plan'); return; }

            // Generate initials
            const parts = name.split(' ');
            const initials = parts.length >= 2
                ? parts[0][0].toUpperCase() + parts[parts.length - 1][0].toUpperCase()
                : name.substring(0, 2).toUpperCase();

            // Add to gym members
            const newMember = {
                id: Date.now(),
                name: name,
                initials: initials,
                type: 'membership',
                plan: selectedMemberPlan.name,
                time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
                status: 'in'
            };
            gymMembers.unshift(newMember);
            renderWhosIn();

            // Update QR display
            document.getElementById('memberQRName').textContent = name;
            document.getElementById('memberQRPlan').textContent = selectedMemberPlan.name + ' - ₱' + selectedMemberPlan.price.toLocaleString();

            // Show QR state
            setNmState('nmStateMembershipQR');
        }

        function finishRegistration() {
            showNewMemberChoice();
        }

        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });

        renderWhosIn();

        // ===== PHOTO UPLOAD =====
        function previewPhoto(input) {
            const box = document.getElementById('photoUploadBox');
            const removeBtn = document.getElementById('removePhotoBtn');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Create or update valid img preview
                    let img = box.querySelector('.photo-preview');
                    if (!img) {
                        img = document.createElement('img');
                        img.className = 'photo-preview';
                        box.appendChild(img);
                    }
                    img.src = e.target.result;

                    box.classList.add('has-photo');
                    // Hide icon and text by setting display to none on i and span direct children
                    const icon = box.querySelector('i');
                    const span = box.querySelector('span');
                    if (icon) icon.style.display = 'none';
                    if (span) span.style.display = 'none';

                    // Show remove button
                    if (removeBtn) {
                        removeBtn.style.display = 'flex';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePhoto(e) {
            e.stopPropagation();
            const input = document.getElementById('memberPhoto');
            const box = document.getElementById('photoUploadBox');
            const removeBtn = document.getElementById('removePhotoBtn');

            // Reset input
            input.value = '';

            // Reset box
            box.classList.remove('has-photo');
            const img = box.querySelector('.photo-preview');
            if (img) img.remove();

            // Show icon and text
            const icon = box.querySelector('i');
            const span = box.querySelector('span');
            if (icon) icon.style.display = '';
            if (span) span.style.display = '';

            // Hide remove button
            if (removeBtn) {
                removeBtn.style.display = 'none';
            }
        }

        // ===== PENDING MEMBERSHIPS =====
        let pendingMembers = [
            {
                id: 101,
                name: 'Carlos Martinez',
                email: 'carlos@email.com',
                phone: '0917-123-4567',
                photo: null,
                appliedAt: '2 hours ago'
            },
            {
                id: 102,
                name: 'Ana Reyes',
                email: 'ana.reyes@email.com',
                phone: '0918-987-6543',
                photo: null,
                appliedAt: '5 hours ago'
            }
        ];

        function openPendingModal() {
            document.getElementById('pendingModal').classList.add('active');
            renderPendingList();
        }

        function closePendingModal() {
            document.getElementById('pendingModal').classList.remove('active');
        }

        function renderPendingList() {
            const container = document.getElementById('pendingList');
            const badge = document.getElementById('pendingCount');

            badge.textContent = pendingMembers.length;
            if (pendingMembers.length === 0) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'inline';
            }

            if (pendingMembers.length === 0) {
                container.innerHTML = `
                    <div class="pending-empty">
                        <i class="fas fa-check-circle"></i>
                        <p>No pending applications</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = pendingMembers.map(m => `
                <div class="pending-card" id="pending-${m.id}">
                    <div class="pending-card-header">
                        <div class="pending-card-photo">
                            ${m.photo ? `<img src="${m.photo}" alt="${m.name}">` : `<i class="fas fa-user"></i>`}
                        </div>
                        <div class="pending-card-info">
                            <h4>${m.name}</h4>
                            <p><i class="fas fa-envelope"></i> ${m.email}</p>
                            <p><i class="fas fa-phone"></i> ${m.phone}</p>
                            <p style="color: var(--text-dim);"><i class="fas fa-clock"></i> Applied ${m.appliedAt}</p>
                        </div>
                    </div>
                    <div class="pending-card-actions">
                        <button class="pending-btn approve" onclick="approvePending(${m.id})"><i class="fas fa-check"></i> Approve</button>
                        <button class="pending-btn reject" onclick="rejectPending(${m.id})"><i class="fas fa-times"></i> Reject</button>
                    </div>
                </div>
            `).join('');
        }

        function approvePending(id) {
            const member = pendingMembers.find(m => m.id === id);
            if (member && confirm(`Approve ${member.name}'s membership application?`)) {
                // Generate initials
                const parts = member.name.split(' ');
                const initials = parts.length >= 2
                    ? parts[0][0].toUpperCase() + parts[parts.length - 1][0].toUpperCase()
                    : member.name.substring(0, 2).toUpperCase();

                // Add to gym as active member
                gymMembers.unshift({
                    id: Date.now(),
                    name: member.name,
                    initials: initials,
                    type: 'membership',
                    plan: 'Monthly',
                    time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }),
                    status: 'in'
                });
                renderWhosIn();

                // Remove from pending
                pendingMembers = pendingMembers.filter(m => m.id !== id);
                renderPendingList();

                alert(`${member.name} has been approved and activated!`);
            }
        }

        function rejectPending(id) {
            const member = pendingMembers.find(m => m.id === id);
            if (member && confirm(`Reject ${member.name}'s application?`)) {
                pendingMembers = pendingMembers.filter(m => m.id !== id);
                renderPendingList();
            }
        }

        // Close modal on backdrop click
        document.getElementById('pendingModal').addEventListener('click', function (e) {
            if (e.target === this) closePendingModal();
        });

        // Date Display
        function updateDate() {
            const now = new Date();
            const isDesktop = window.matchMedia("(min-width: 768px)").matches;

            const options = isDesktop
                ? { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' }
                : { weekday: 'short', month: 'short', day: 'numeric' };

            const dateStr = now.toLocaleDateString('en-US', options);
            document.getElementById('dateDisplay').textContent = dateStr;
        }
        window.addEventListener('resize', updateDate);
        updateDate();
        setInterval(updateDate, 60000);

        renderPendingList();
    </script>

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

</body>

</html>