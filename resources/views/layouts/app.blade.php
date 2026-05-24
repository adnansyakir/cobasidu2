<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - SIDU')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-width: 270px;
            --purple-50: #f5f3ff;
            --purple-100: #ede9fe;
            --purple-200: #ddd6fe;
            --purple-300: #c4b5fd;
            --purple-400: #a78bfa;
            --purple-500: #8b5cf6;
            --purple-600: #7c3aed;
            --purple-700: #6d28d9;
            --purple-800: #5b21b6;
            --purple-900: #4c1d95;
            --bg-body: #f8f6ff;
            --bg-card: #ffffff;
            --bg-card-hover: #faf8ff;
            --border-color: #e9e5f5;
            --text-primary: #1e1b4b;
            --text-secondary: #4b5563;
            --text-muted: #9ca3af;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ======== SIDEBAR ======== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            box-shadow: 2px 0 12px rgba(139, 92, 246, 0.04);
        }

        .sidebar-header {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .sidebar-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--purple-500), var(--purple-400));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.35);
            flex-shrink: 0;
        }

        .sidebar-brand-text h2 {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .sidebar-brand-text span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section-title {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            padding: 12px 14px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item:hover {
            background: var(--purple-50);
            color: var(--purple-700);
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--purple-50), #f0ebff);
            color: var(--purple-700);
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: var(--purple-500);
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* ======== DROPDOWN / COLLAPSIBLE NAV ======== */
        .nav-dropdown {
            margin-bottom: 2px;
        }

        .nav-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            width: 100%;
            border: none;
            background: none;
            font-family: 'Inter', sans-serif;
            position: relative;
        }

        .nav-dropdown-toggle:hover {
            background: var(--purple-50);
            color: var(--purple-700);
        }

        .nav-dropdown-toggle.active {
            background: linear-gradient(135deg, var(--purple-50), #f0ebff);
            color: var(--purple-700);
        }

        .nav-dropdown-arrow {
            margin-left: auto;
            font-size: 10px;
            transition: transform 0.3s ease;
            color: var(--text-muted);
        }

        .nav-dropdown.open .nav-dropdown-arrow {
            transform: rotate(90deg);
            color: var(--purple-500);
        }

        .nav-dropdown-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, opacity 0.25s ease;
            opacity: 0;
            padding-left: 18px;
        }

        .nav-dropdown.open .nav-dropdown-menu {
            max-height: 500px;
            opacity: 1;
        }

        .nav-dropdown-menu .nav-item {
            padding: 10px 14px 10px 20px;
            font-size: 13px;
            border-left: 2px solid var(--border-color);
            border-radius: 0 12px 12px 0;
            margin-bottom: 0;
        }

        .nav-dropdown-menu .nav-item:hover {
            border-left-color: var(--purple-400);
        }

        .nav-dropdown-menu .nav-item.active {
            border-left-color: var(--purple-500);
            background: linear-gradient(135deg, var(--purple-50), #f0ebff);
            border: none;
            border-left: 2px solid var(--purple-500);
        }

        .nav-dropdown-menu .nav-item.active::before {
            display: none;
        }

        .nav-dropdown-menu .nav-icon {
            font-size: 13px;
            width: 16px;
            height: 16px;
        }

        /* Sidebar footer / user info */
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            background: var(--purple-50);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--purple-600), var(--purple-400));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-details h4 {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-details span {
            font-size: 11px;
            color: var(--text-muted);
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            margin-top: 10px;
            width: 100%;
            justify-content: center;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            color: #dc2626;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #fee2e2;
            border-color: #f87171;
            color: #b91c1c;
        }

        /* ======== MAIN CONTENT ======== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            position: relative;
        }

        /* Top bar */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            padding: 20px 32px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-left h1 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .topbar-left p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .topbar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple-500), var(--purple-600));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            border: 2px solid var(--purple-200);
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.2);
            overflow: hidden;
            flex-shrink: 0;
        }

        .topbar-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .topbar-avatar:hover {
            border-color: var(--purple-400);
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.35);
            transform: scale(1.05);
        }

        .avatar-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 240px;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.25s ease;
            z-index: 200;
            overflow: hidden;
        }

        .avatar-dropdown.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .avatar-dropdown-header {
            padding: 16px;
            background: linear-gradient(135deg, var(--purple-50), #f0ebff);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-dropdown-header .dd-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple-500), var(--purple-600));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar-dropdown-header .dd-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-dropdown-header .dd-info h4 {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .avatar-dropdown-header .dd-info span {
            font-size: 11px;
            color: var(--purple-600);
            font-weight: 500;
        }

        .avatar-dropdown-body {
            padding: 8px;
        }

        .dd-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            font-family: 'Inter', sans-serif;
        }

        .dd-menu-item:hover {
            background: var(--purple-50);
            color: var(--purple-700);
        }

        .dd-menu-item.danger {
            color: #dc2626;
        }

        .dd-menu-item.danger:hover {
            background: #fef2f2;
            color: #b91c1c;
        }

        .dd-divider {
            height: 1px;
            background: var(--border-color);
            margin: 4px 8px;
        }

        /* ======== TOPBAR LIVE CLOCK ======== */
        .topbar-clock {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: var(--purple-50);
            border: 1px solid var(--purple-200);
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .topbar-clock .clock-day {
            font-weight: 600;
            color: var(--purple-600);
        }

        .topbar-clock .clock-separator {
            color: var(--purple-300);
            font-weight: 300;
        }

        .topbar-clock .clock-time {
            font-weight: 700;
            color: var(--text-primary);
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .topbar-clock {
                display: none;
            }
        }

        /* Page content */
        .page-content {
            padding: 28px 32px;
        }

        /* Background decoration for main */
        .main-content::before {
            content: '';
            position: fixed;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.06) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ======== STAT CARDS ======== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 24px;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .stat-card:hover {
            border-color: var(--purple-200);
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(139, 92, 246, 0.1);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.purple {
            background: var(--purple-50);
            color: var(--purple-500);
        }

        .stat-icon.blue {
            background: #eff6ff;
            color: #3b82f6;
        }

        .stat-icon.green {
            background: #f0fdf4;
            color: #22c55e;
        }

        .stat-icon.amber {
            background: #fffbeb;
            color: #f59e0b;
        }

        .stat-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .stat-badge.up {
            background: #f0fdf4;
            color: #16a34a;
        }

        .stat-badge.down {
            background: #fef2f2;
            color: #dc2626;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ======== CONTENT CARDS ======== */
        .content-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.4s;
            opacity: 0;
            position: relative;
            z-index: 1;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .content-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .content-card-header h3 {
            font-size: 16px;
            font-weight: 600;
        }

        /* ======== TABLE ======== */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            text-align: left;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table td {
            padding: 14px 16px;
            font-size: 14px;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        .data-table tr:hover td {
            background: var(--purple-50);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        /* Status badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background: #f0fdf4;
            color: #16a34a;
        }

        .badge-warning {
            background: #fffbeb;
            color: #d97706;
        }

        .badge-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .badge-info {
            background: #eff6ff;
            color: #2563eb;
        }

        /* ======== WELCOME BANNER ======== */
        .welcome-banner {
            background: linear-gradient(135deg, var(--purple-500), var(--purple-600));
            border: none;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
            z-index: 1;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            color: #fff;
            box-shadow: 0 8px 32px rgba(139, 92, 246, 0.25);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .welcome-banner h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 6px;
            position: relative;
            color: #fff;
        }

        .welcome-banner p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            position: relative;
        }

        .welcome-banner .welcome-emoji {
            font-size: 28px;
            margin-bottom: 12px;
            display: block;
        }

        /* ======== ANIMATIONS ======== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ======== MOBILE TOGGLE ======== */
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 200;
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--purple-500), var(--purple-600));
            border: none;
            color: #fff;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4);
            transition: transform 0.2s;
        }

        .mobile-toggle:active {
            transform: scale(0.95);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 90;
        }

        /* ======== RESPONSIVE ======== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                padding: 16px 20px;
            }

            .page-content {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Alert messages */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: fadeInUp 0.4s ease;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <div class="sidebar-logo">S</div>
                <div class="sidebar-brand-text">
                    <h2>SIDU</h2>
                    <span>Sistem Daftar Ulang</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            @yield('sidebar-menu')
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                </div>
                <div class="user-details">
                    <h4>{{ Auth::user()->username }}</h4>
                    <span>{{ ucfirst(Auth::user()->getRoleName()) }}</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', date('l, d F Y'))</p>
            </div>
            <div class="topbar-right">
                <div class="topbar-clock" id="topbarClock">
                    <span class="clock-day" id="clockDay">--</span>
                    <span class="clock-separator">|</span>
                    <span id="clockDate">--</span>
                    <span class="clock-separator">|</span>
                    <span class="clock-time" id="clockTime">--:--:--</span>
                </div>
                <div class="topbar-avatar" id="avatarToggle" onclick="toggleAvatarDropdown()">
                    @if(Auth::user()->foto_profil)
                        <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    @endif
                </div>
                <div class="avatar-dropdown" id="avatarDropdown">
                    <div class="avatar-dropdown-header">
                        <div class="dd-avatar">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Avatar">
                            @else
                                {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                            @endif
                        </div>
                        <div class="dd-info">
                            <h4>{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</h4>
                            <span>{{ ucfirst(Auth::user()->getRoleName()) }}</span>
                        </div>
                    </div>
                    <div class="avatar-dropdown-body">
                        <a href="{{ route(Auth::user()->getRoleName() . '.profile') }}" class="dd-menu-item">
                            <span>👤</span> Profile Saya
                        </a>
                        <div class="dd-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dd-menu-item danger">
                                <span>🚪</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        // Avatar dropdown toggle
        function toggleAvatarDropdown() {
            document.getElementById('avatarDropdown').classList.toggle('open');
        }

        // Close avatar dropdown when clicking outside
        document.addEventListener('click', function(e) {
            var dropdown = document.getElementById('avatarDropdown');
            var toggle = document.getElementById('avatarToggle');
            if (dropdown && toggle && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

        // Dropdown toggle for sidebar
        document.querySelectorAll('.nav-dropdown-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                var dropdown = this.closest('.nav-dropdown');
                dropdown.classList.toggle('open');
            });
        });

        // Auto-open dropdown if it contains an active item
        document.querySelectorAll('.nav-dropdown-menu .nav-item.active').forEach(function(item) {
            item.closest('.nav-dropdown').classList.add('open');
        });

        // Live Clock
        (function() {
            var hariNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            var bulanNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

            function pad(n) { return n < 10 ? '0' + n : n; }

            function updateClock() {
                var now = new Date();
                document.getElementById('clockDay').textContent = hariNames[now.getDay()];
                document.getElementById('clockDate').textContent = now.getDate() + ' ' + bulanNames[now.getMonth()] + ' ' + now.getFullYear();
                document.getElementById('clockTime').textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
            }

            updateClock();
            setInterval(updateClock, 1000);
        })();
    </script>
    @yield('scripts')
</body>
</html>
