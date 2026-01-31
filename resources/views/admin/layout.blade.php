<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dili Society')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logobg.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

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

        /* Hapus burger button dari sidebar */
        .burger-btn {
            display: none;
        }

        /* Hapus user profile section */
        .user-profile {
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

        .sidebar.collapsed + .main-content .topbar {
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

        /* Toggle button di topbar - satu toggle untuk semua */
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

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
            transition: var(--transition);
            background: var(--white-off);
        }

        .sidebar.collapsed + .main-content {
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

        .sidebar.collapsed + .main-content + .main-footer {
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

        /* ========== CARD STYLES ========== */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            background: var(--white-pure);
            border: 1px solid var(--border-light);
        }

        .card:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--white-pure);
            border-bottom: 1px solid var(--border-light);
            border-radius: 12px 12px 0 0 !important;
            padding: 18px;
            font-weight: 600;
            color: var(--navy-dark);
            font-family: 'Montserrat', sans-serif;
        }

        .card-body {
            padding: 20px;
        }

        /* ========== BUTTON STYLES ========== */
        .btn-primary {
            background: var(--blue-gradient);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: var(--white-pure);
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(29, 78, 216, 0.3);
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
            .sidebar.mobile-open .nav-section {
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

            .content-wrapper {
                padding: 20px;
            }

            .datetime-display,
            .user-name-small {
                display: none !important;
            }

            .footer-content {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.2rem;
            }
            
            .page-subtitle {
                font-size: 0.75rem;
            }
            
            .datetime-display {
                font-size: 0.75rem;
                padding: 6px 10px;
            }
            
            .unified-toggle {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
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
    </style>

    @yield('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ========== SIDEBAR ========== -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Dili Society Logo"
                 class="logo-image"
                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSI+PHBhdGggZD0iTTEwIDEwSDMwVjMwSDEwVjEwWiIgZmlsbD0iIzJENDlDOCIvPjwvc3ZnPg=='">
        </a>
    </div>

    <nav class="nav-menu">
        @auth
            <div class="nav-section">Main Navigation</div>

            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>

            <div class="nav-section">Store Management</div>

            <!-- Product Library -->
            <div class="nav-item">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-collection"></i>
                        <span class="nav-text">Product Library</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.items') ? 'active' : '' }}"
                               href="{{ route('admin.items') }}">
                                <i class="bi bi-box-seam me-2"></i> All Products
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.categories') ? 'active' : '' }}"
                               href="{{ route('admin.categories') }}">
                                <i class="bi bi-tags me-2"></i> Categories & Brands
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Inventory -->
            <div class="nav-item">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-boxes"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.inventory.purchase') ? 'active' : '' }}"
                               href="{{ route('admin.inventory.purchase.index') }}">
                                <i class="bi bi-cart-plus me-2"></i> Purchase Orders
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.inventory.summary') ? 'active' : '' }}"
                               href="{{ route('admin.inventory.summary') }}">
                                <i class="bi bi-file-earmark-text me-2"></i> Inventory Summary
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->routeIs('admin.inventory.supplier') ? 'active' : '' }}"
                               href="{{ route('admin.inventory.supplier.index') }}">
                                <i class="bi bi-truck me-2"></i> Supplier Management
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.cashdrawer') }}"
                   class="nav-link {{ request()->routeIs('admin.cashdrawer') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span class="nav-text">Sales & Cash Drawer</span>
                </a>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="nav-section">Administration</div>
                <div class="nav-item">
                    <a href="{{ route('admin.users') }}"
                       class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span class="nav-text">User Management</span>
                    </a>
                </div>
            @endif

            <div class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="nav-text">Logout</span>
                    </button>
                </form>
            </div>

        @endauth
    </nav>
</aside>

<!-- ========== MAIN CONTENT ========== -->
<div class="main-content">

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="topbar-content">
            <div class="page-header">
                <button class="unified-toggle" id="unifiedToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="title-section">
                    <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
                    <p class="page-subtitle">Dili Society</p>
                </div>
            </div>

            <div class="topbar-actions">
                <div class="datetime-display">
                    <i class="bi bi-calendar-week"></i>
                    <span id="current-date-time"></span>
                </div>

                <div class="dropdown user-dropdown">
                    <button class="dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="user-avatar-small">
                            {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                        </div>
                        <span class="user-name-small">{{ auth()->user()->username }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- FLASH -->
    <div class="flash-container">
        @foreach (['success','danger','warning','info'] as $type)
            @if(session()->has($type))
                <div class="alert alert-{{ $type }} alert-dismissible fade show">
                    {{ session($type) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach
    </div>

    <main class="content-wrapper">
        @yield('content')
    </main>
</div>

<footer class="main-footer">
    <div class="footer-content">
        <div class="footer-left">
            <p>&copy; 2025 Dili Society • Professional Clothing Store Management</p>
            <p class="text-muted">
                <small><i class="bi bi-tag"></i> Version 3.1.0 • <span id="server-time"></span></small>
            </p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const unifiedToggle = document.getElementById('unifiedToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Satu toggle untuk semua fungsi
            if (unifiedToggle) {
                unifiedToggle.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        // Mode mobile: toggle sidebar overlay
                        sidebar.classList.toggle('mobile-open');
                        sidebarOverlay.classList.toggle('active');
                        document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
                    } else {
                        // Mode desktop: toggle sidebar collapse
                        sidebar.classList.toggle('collapsed');
                        updateToggleIcon();
                    }
                });
            }
            
            // Close mobile sidebar dengan overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
            
            // Close sidebar on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
            
            function updateToggleIcon() {
                const icon = unifiedToggle.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'bi bi-chevron-right';
                } else {
                    icon.className = 'bi bi-list';
                }
            }
            
            // Responsive behavior
            function handleResponsive() {
                if (window.innerWidth < 992) {
                    // Mode mobile: hapus collapsed, show overlay toggle
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                    
                    // Update icon untuk mobile
                    if (unifiedToggle) {
                        unifiedToggle.querySelector('i').className = 'bi bi-list';
                    }
                } else {
                    // Mode desktop: hapus mobile state
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                    
                    // Auto collapse pada medium screens
                    if (window.innerWidth < 1200) {
                        sidebar.classList.add('collapsed');
                    } else {
                        sidebar.classList.remove('collapsed');
                    }
                    updateToggleIcon();
                }
            }
            
            // Initial check
            handleResponsive();
            window.addEventListener('resize', handleResponsive);
            
            // Date & Time updater - WIB ke TIMOR LESTE (UTC+7 ke UTC+9)
            function updateDateTime() {
                const now = new Date();
                
                // Konversi dari WIB (UTC+7) ke Timor Leste (UTC+9) - tambah 2 jam
                const wibToTimorLeste = 2 * 60 * 60 * 1000; // 2 jam dalam milidetik
                const timorLesteTime = new Date(now.getTime() + wibToTimorLeste);
                
                // Format tanggal untuk Timor Leste
                const dateStr = timorLesteTime.toLocaleDateString('id-ID', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                // Format waktu untuk Timor Leste
                const timeStr = timorLesteTime.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
                
                // Tampilkan di topbar
                const datetimeElement = document.getElementById('current-date-time');
                if (datetimeElement) {
                    datetimeElement.textContent = `${dateStr} • ${timeStr} WTL`;
                }
                
                // Tampilkan di footer
                const serverTimeElement = document.getElementById('server-time');
                if (serverTimeElement) {
                    const serverDateStr = timorLesteTime.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                    serverTimeElement.textContent = `${serverDateStr} ${timeStr} WTL`;
                }
            }
            
            // Update waktu setiap detik
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Auto-dismiss alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
        
        // Global utility functions
        window.formatCurrency = function(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        };
        
        window.formatDate = function(dateString) {
            const date = new Date(dateString);
            // Tambah 2 jam untuk konversi ke Timor Leste
            const timorLesteDate = new Date(date.getTime() + (2 * 60 * 60 * 1000));
            return timorLesteDate.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }) + ' WTL';
        };
    </script>

@yield('scripts')
</body>
</html>
