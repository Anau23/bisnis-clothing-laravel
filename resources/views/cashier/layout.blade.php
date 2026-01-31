<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dili Society - Kasir')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="icon" type="image/png" href="{{ asset('images/logobg.png') }}">

    <style>
            :root {
                /* Neptune Command Color Palette */
                --navy-dark: #0F1A2F;
                --navy-deep: #0d1529;
                --royal-blue: #1D4ED8;
                --light-blue: #60A5FA;
                --blue-gradient: linear-gradient(135deg, #0F1A2F 0%, #1D4ED8 50%, #60A5FA 100%);
                --blue-gradient-reverse: linear-gradient(135deg, #60A5FA 0%, #1D4ED8 50%, #0F1A2F 100%);
                --gold-accent: #EAB308;
                --gold-light: #FEF08A;
                --white-pure: #FFFFFF;
                --white-off: #F8FAFC;
                --dark-text: #0F172A;
                --muted-text: #334155;
                --border-light: #CBD5E1;
                --border-deep: #1D4ED8;
                --shadow-soft: 0 4px 20px rgba(15, 26, 47, 0.08);
                --shadow-medium: 0 8px 30px rgba(15, 26, 47, 0.12);
                --shadow-deep: 0 15px 50px rgba(15, 26, 47, 0.2);
                
                /* Layout variables */
                --sidebar-width: 280px;
                --sidebar-collapsed: 80px;
                --topbar-height: 70px;
                --radius: 12px;
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                --gradient-topbar: linear-gradient(135deg, #0F1A2F 0%, #1D4ED8 100%);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--white-off);
                color: var(--dark-text);
                line-height: 1.6;
                overflow-x: hidden;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Montserrat', sans-serif;
                font-weight: 600;
            }

            /* ========== SIDEBAR STYLES ========== */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: var(--sidebar-width);
                background: var(--white-off);
                box-shadow: 5px 0 30px rgba(15, 26, 47, 0.08);
                z-index: 1100;
                transition: var(--transition);
                display: flex;
                flex-direction: column;
                overflow: hidden;
                border-right: 1px solid var(--border-light);
            }

            .sidebar.collapsed {
                width: var(--sidebar-collapsed);
            }

            .sidebar-header {
                padding: 20px 15px;
                background: var(--white-off) !important;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: var(--topbar-height);
                border-bottom: 1px solid var(--border-light);
            }

            .logo {
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                width: 100%;
            }

            .logo-image {
                max-width: 80px;
                max-height: 80px;
                width: auto;
                height: auto;
                object-fit: contain;
                transition: var(--transition);
            }

            .sidebar.collapsed .logo-image {
                max-width: 50px;
                max-height: 50px;
            }

            .logo-text {
                display: none;
            }

            .nav-menu {
                flex: 1;
                padding: 20px 0;
                overflow-y: auto;
                background: var(--white-off);
            }

            .nav-menu::-webkit-scrollbar {
                width: 4px;
            }

            .nav-menu::-webkit-scrollbar-track {
                background: transparent;
            }

            .nav-menu::-webkit-scrollbar-thumb {
                background: rgba(15, 26, 47, 0.1);
                border-radius: 10px;
            }

            .nav-section {
                padding: 0 20px 8px;
                color: var(--muted-text);
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin-top: 15px;
                border-bottom: 1px solid var(--border-light);
                font-family: 'Inter', sans-serif;
            }

            .sidebar.collapsed .nav-section {
                display: none;
            }

            .nav-item {
                padding: 4px 15px;
            }

            .nav-link {
                display: flex;
                align-items: center;
                gap: 12px;
                color: var(--dark-text);
                text-decoration: none;
                padding: 10px 15px;
                border-radius: 8px;
                transition: var(--transition);
                position: relative;
                overflow: hidden;
                font-weight: 500;
                font-size: 0.9rem;
                font-family: 'Inter', sans-serif;
            }

            .nav-link:hover {
                background: rgba(15, 26, 47, 0.05);
                color: var(--royal-blue);
                transform: translateX(3px);
            }

            .nav-link.active {
                background: rgba(29, 78, 216, 0.1);
                color: var(--royal-blue);
                box-shadow: 0 2px 8px rgba(29, 78, 216, 0.1);
            }

            .nav-link.active::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 3px;
                height: 50%;
                background: var(--royal-blue);
                border-radius: 0 4px 4px 0;
            }

            .nav-link i {
                font-size: 1.1rem;
                width: 20px;
                text-align: center;
                flex-shrink: 0;
                color: var(--muted-text);
            }

            .nav-link:hover i,
            .nav-link.active i {
                color: var(--royal-blue);
            }

            .nav-text {
                flex: 1;
                white-space: nowrap;
                transition: opacity 0.3s;
            }

            .sidebar.collapsed .nav-text {
                opacity: 0;
                width: 0;
                overflow: hidden;
            }

            /* Shift Status Badge */
            .shift-badge {
                background: linear-gradient(135deg, var(--royal-blue), var(--light-blue));
                color: white;
                padding: 3px 8px;
                border-radius: 12px;
                font-size: 0.7rem;
                font-weight: 600;
                margin-left: auto;
                display: flex;
                align-items: center;
                gap: 4px;
                transition: var(--transition);
            }

            .shift-badge.inactive {
                background: linear-gradient(135deg, #64748B, #94A3B8);
            }

            .shift-badge i {
                font-size: 0.6rem;
            }

            /* ========== TOPBAR STYLES ========== */
            .topbar {
                position: fixed;
                top: 0;
                left: var(--sidebar-width);
                right: 0;
                height: var(--topbar-height);
                background: var(--white-off);
                box-shadow: 0 2px 10px rgba(15, 26, 47, 0.05);
                z-index: 1099;
                transition: var(--transition);
                border-bottom: 1px solid var(--border-light);
            }

            .sidebar.collapsed ~ .main-content .topbar {
                left: var(--sidebar-collapsed);
            }

            .topbar-content {
                height: 100%;
                padding: 0 25px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .page-header {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .unified-toggle {
                background: var(--white-pure);
                border: 1px solid var(--border-light);
                color: var(--royal-blue);
                font-size: 1.3rem;
                cursor: pointer;
                padding: 8px;
                border-radius: 8px;
                transition: var(--transition);
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                box-shadow: var(--shadow-soft);
            }

            .unified-toggle:hover {
                background: var(--royal-blue);
                color: var(--white-pure);
                transform: scale(1.05);
                box-shadow: 0 4px 15px rgba(29, 78, 216, 0.2);
            }

            .title-section {
                display: flex;
                flex-direction: column;
            }

            .page-title {
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--navy-dark);
                margin: 0;
                letter-spacing: -0.3px;
                font-family: 'Montserrat', sans-serif;
            }

            .page-subtitle {
                font-size: 0.85rem;
                color: var(--muted-text);
                margin: 4px 0 0 0;
                font-weight: 500;
                font-family: 'Inter', sans-serif;
                letter-spacing: 0.5px;
            }

            .topbar-actions {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .datetime-display {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 15px;
                background: var(--white-pure);
                border-radius: 8px;
                font-size: 0.85rem;
                color: var(--navy-dark);
                font-weight: 600;
                border: 1px solid var(--border-light);
                font-family: 'Montserrat', sans-serif;
                box-shadow: var(--shadow-soft);
            }

            .datetime-display i {
                color: var(--gold-accent);
                font-size: 1rem;
            }

            /* Shift Duration Display */
            .shift-duration-display {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 15px;
                background: var(--white-pure);
                border-radius: 8px;
                font-size: 0.85rem;
                color: var(--navy-dark);
                font-weight: 600;
                border: 1px solid var(--border-light);
                font-family: 'Montserrat', sans-serif;
                box-shadow: var(--shadow-soft);
                min-width: 120px;
                justify-content: center;
            }

            .shift-duration-display i {
                color: var(--gold-accent);
                font-size: 1rem;
            }

            .shift-duration-display.active {
                background: linear-gradient(135deg, rgba(29, 78, 216, 0.1), rgba(96, 165, 250, 0.1));
                border-color: var(--royal-blue);
            }

            .shift-duration-display.inactive {
                background: linear-gradient(135deg, rgba(100, 116, 139, 0.1), rgba(148, 163, 184, 0.1));
                border-color: var(--border-light);
                color: var(--muted-text);
            }

            /* Topbar Shift Status */
            .shift-status-indicator {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 6px 12px;
                background: var(--white-pure);
                border-radius: 8px;
                border: 1px solid var(--border-light);
                font-size: 0.85rem;
                font-weight: 500;
                box-shadow: var(--shadow-soft);
            }

            .shift-indicator-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #DC2626;
            }

            .shift-indicator-dot.active {
                background: #16A34A;
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0.5; }
                100% { opacity: 1; }
            }

            .user-dropdown .dropdown-toggle {
                display: flex;
                align-items: center;
                gap: 10px;
                background: var(--white-pure);
                border: 1px solid var(--border-light);
                padding: 6px 12px;
                border-radius: 10px;
                cursor: pointer;
                transition: var(--transition);
                color: var(--navy-dark);
                box-shadow: var(--shadow-soft);
            }

            .user-dropdown .dropdown-toggle:hover {
                background: var(--royal-blue);
                color: var(--white-pure);
                transform: scale(1.05);
            }

            .user-dropdown .dropdown-toggle:hover .user-name-small {
                color: var(--white-pure);
            }

            .user-avatar-small {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                background: var(--royal-blue);
                color: var(--white-pure);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 0.85rem;
                flex-shrink: 0;
                font-family: 'Montserrat', sans-serif;
            }

            .user-name-small {
                font-weight: 600;
                color: var(--navy-dark);
                font-size: 0.85rem;
                white-space: nowrap;
                font-family: 'Inter', sans-serif;
            }

            /* Quick Actions Bar */
            .quick-actions-bar {
                background: var(--white-pure);
                border-top: 1px solid var(--border-light);
                padding: 10px 25px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .quick-actions-left, .quick-actions-right {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .quick-action-btn {
                display: flex;
                align-items: center;
                gap: 6px;
                color: var(--muted-text);
                text-decoration: none;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 0.85rem;
                font-weight: 500;
                transition: var(--transition);
                background: var(--white-off);
                border: 1px solid var(--border-light);
            }

            .quick-action-btn:hover {
                background: var(--royal-blue);
                color: var(--white-pure);
                border-color: var(--royal-blue);
            }

            .quick-action-btn i {
                font-size: 0.9rem;
            }

            /* ========== MAIN CONTENT ========== */
            .main-content {
                margin-left: var(--sidebar-width);
                padding-top: var(--topbar-height);
                min-height: 100vh;
                transition: var(--transition);
                background: var(--white-off);
            }

            .sidebar.collapsed ~ .main-content {
                margin-left: var(--sidebar-collapsed);
            }

            .content-wrapper {
                padding: 25px;
                min-height: calc(100vh - var(--topbar-height));
            }

            /* ========== FLASH MESSAGES ========== */
            .flash-container {
                padding: 20px 25px 0;
            }

            .alert {
                border-radius: 12px;
                border: none;
                padding: 15px 20px;
                box-shadow: var(--shadow-soft);
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                font-weight: 500;
                font-family: 'Inter', sans-serif;
            }

            .alert i {
                font-size: 1.2rem;
            }

            .alert-danger {
                background: linear-gradient(135deg, #FEE2E2, #FECACA);
                color: #7F1D1D;
                border-left: 4px solid #DC2626;
            }

            .alert-success {
                background: linear-gradient(135deg, #DCFCE7, #BBF7D0);
                color: #14532D;
                border-left: 4px solid #16A34A;
            }

            .alert-warning {
                background: linear-gradient(135deg, #FEF3C7, #FDE68A);
                color: #92400E;
                border-left: 4px solid #F59E0B;
            }

            .alert-info {
                background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
                color: var(--navy-dark);
                border-left: 4px solid var(--royal-blue);
            }

            /* ========== FOOTER ========== */
            .main-footer {
                background: var(--white-pure);
                border-top: 1px solid var(--border-light);
                padding: 15px 25px;
                margin-left: var(--sidebar-width);
                transition: var(--transition);
            }

            .sidebar.collapsed ~ .main-content + .main-footer {
                margin-left: var(--sidebar-collapsed);
            }

            .footer-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .footer-left p {
                margin: 0;
                color: var(--muted-text);
                font-size: 0.85rem;
                font-family: 'Inter', sans-serif;
            }

            .footer-right {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .footer-action {
                color: var(--muted-text);
                text-decoration: none;
                font-size: 0.85rem;
                transition: var(--transition);
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .footer-action:hover {
                color: var(--royal-blue);
            }

            /* ========== RESPONSIVE DESIGN ========== */
            @media (max-width: 1200px) {
                .sidebar {
                    width: var(--sidebar-collapsed);
                }

                .sidebar .nav-text,
                .sidebar .nav-section {
                    display: none !important;
                }

                .sidebar .shift-badge {
                    display: none !important;
                }

                .topbar {
                    left: var(--sidebar-collapsed);
                }

                .main-content {
                    margin-left: var(--sidebar-collapsed);
                }

                .main-footer {
                    margin-left: var(--sidebar-collapsed);
                }
            }

            /* iPad Pro specific styles */
            @media (min-width: 993px) and (max-width: 1366px) {
                .shift-status-indicator,
                .datetime-display {
                    display: none !important;
                }
            }

            @media (max-width: 992px) {
                .sidebar {
                    transform: translateX(-100%);
                    width: var(--sidebar-width);
                    box-shadow: 10px 0 40px rgba(15, 26, 47, 0.1);
                    transition: transform 0.3s;
                    z-index: 1100;
                    background: var(--white-off);
                    border-right: 1px solid var(--border-light);
                }

                .sidebar.mobile-open {
                    transform: translateX(0);
                }

                .sidebar.mobile-open .nav-text,
                .sidebar.mobile-open .nav-section,
                .sidebar.mobile-open .shift-badge {
                    display: block !important;
                    opacity: 1 !important;
                    width: auto !important;
                }

                .sidebar-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(15, 26, 47, 0.5);
                    z-index: 1099;
                    display: none;
                    opacity: 0;
                    transition: opacity 0.3s;
                }

                .sidebar-overlay.active {
                    display: block;
                    opacity: 1;
                }

                .topbar {
                    left: 0;
                    z-index: 1098;
                }

                .main-content {
                    margin-left: 0;
                }

                .main-footer {
                    margin-left: 0;
                }

                .topbar-content {
                    padding: 0 15px;
                }

                .topbar-actions {
                    flex-wrap: wrap;
                    gap: 10px;
                    justify-content: flex-end;
                }

                .content-wrapper {
                    padding: 20px;
                }

                .shift-status-indicator,
                .datetime-display {
                    display: none !important;
                }

                .footer-content {
                    flex-direction: column;
                    gap: 12px;
                    text-align: center;
                }

                .footer-right {
                    justify-content: center;
                }
            }

            @media (max-width: 768px) {
                .page-title {
                    font-size: 1.2rem;
                }
                
                .page-subtitle {
                    font-size: 0.75rem;
                }
                
                .quick-actions-bar {
                    padding: 10px 15px;
                }
                
                .quick-action-btn span {
                    display: none;
                }
                
                .unified-toggle {
                    width: 36px;
                    height: 36px;
                    font-size: 1.1rem;
                }
                
                .topbar-actions {
                    gap: 10px;
                }

                .shift-duration-display {
                    display: none !important;
                }
            }

            @media (max-width: 576px) {
                .content-wrapper {
                    padding: 15px;
                }

                .flash-container {
                    padding: 15px 15px 0;
                }

                .topbar-content {
                    padding: 0 10px;
                }

                .page-title {
                    font-size: 1.1rem;
                }

                .page-subtitle {
                    font-size: 0.7rem;
                }

                .footer-content {
                    text-align: left;
                }

                .footer-right {
                    flex-wrap: wrap;
                    justify-content: flex-start;
                }
            }

            /* Dropdown styles */
            .dropdown-menu {
                border: none;
                box-shadow: var(--shadow-medium);
                border-radius: 12px;
                padding: 8px 0;
                border: 1px solid var(--border-light);
                background: var(--white-pure);
            }

            .dropdown-item {
                padding: 10px 16px;
                color: var(--dark-text);
                font-family: 'Inter', sans-serif;
                font-weight: 500;
                transition: var(--transition);
            }

            .dropdown-item:hover {
                background: var(--white-off);
                color: var(--royal-blue);
            }

            .dropdown-item.active {
                background: var(--royal-blue);
                color: white;
            }

            /* Print styles */
            @media print {
                .no-print {
                    display: none !important;
                }
                
                .print-only {
                    display: block !important;
                }
                
                .main-content {
                    margin-left: 0 !important;
                    padding-top: 0 !important;
                }
            }
        </style>

    @yield('styles')
</head>
<body>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('cashier.dashboard') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" class="logo-image" alt="Logo">
        </a>
    </div>

    <nav class="nav-menu">
        @auth
            <div class="nav-section">Main Navigation</div>

            <div class="nav-item">
                <a href="{{ route('cashier.dashboard') }}"
                   class="nav-link {{ Route::currentRouteName() === 'cashier.dashboard' ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="#"
                   class="nav-link {{ Route::currentRouteName() === 'cashier.pos' ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span class="nav-text">Point of Sale</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('cashier.dashboard') }}"
                   class="nav-link {{ Route::currentRouteName() === 'cashier.activity' ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span class="nav-text">Aktivitas</span>
                </a>
            </div>

            <div class="nav-section">System</div>

            <div class="nav-item mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="nav-text">Logout</span>
                    </button>
                </form>
            </div>
        @else
            <div class="nav-section">Authentication</div>
            <div class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span class="nav-text">Login</span>
                </a>
            </div>
        @endauth
    </nav>
</aside>

<!-- Main Content -->
<div class="main-content">

    <!-- Topbar -->
    <header class="topbar no-print">
        <div class="topbar-content">
            <div class="page-header">
                <button class="unified-toggle" id="unifiedToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="title-section">
                    <h1 class="page-title">@yield('page_title', 'Kasir')</h1>
                    <p class="page-subtitle">Dili Society</p>
                </div>
            </div>

            <div class="topbar-actions">
                <div class="datetime-display">
                    <i class="bi bi-calendar-week"></i>
                    <span id="current-date-time"></span>
                </div>

                <div class="dropdown user-dropdown">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar-small">
                            {{ strtoupper(substr(Auth::user()->username ?? 'K', 0, 1)) }}
                        </div>
                        <span class="user-name-small">
                            {{ Auth::user()->username ?? 'Kasir' }}
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <div class="px-4 py-3 border-bottom">
                            <p class="fw-semibold mb-0">{{ Auth::user()->username ?? 'Kasir' }}</p>
                            <small class="text-muted">{{ Auth::user()->email ?? '-' }}</small>
                        </div>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="flash-container no-print">
        @foreach (['success','error','warning','info'] as $msg)
            @if(session($msg))
                <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show">
                    {{ session($msg) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Content -->
    <main class="content-wrapper">
        @yield('content')
    </main>
</div>

<!-- Footer -->
<footer class="main-footer no-print">
    <div class="footer-content">
        <div class="footer-left">
            <p>&copy; {{ date('Y') }} Dili Society</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
