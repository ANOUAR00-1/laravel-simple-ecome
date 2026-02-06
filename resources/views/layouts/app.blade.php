<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            padding: 0;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h4 {
            color: white;
            margin: 0;
            font-size: 1.3rem;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 25px;
        }

        .sidebar-menu a.active {
            background: rgba(74, 144, 226, 0.2);
            color: #4a90e2;
            border-left: 3px solid #4a90e2;
        }

        .sidebar-menu a i {
            margin-right: 10px;
            font-size: 1.2rem;
            width: 25px;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px 40px;
            min-height: 100vh;
            background: #f8f9fa;
        }

        /* ============ CLEAN MINIMAL STYLE ============ */

        /* Stat Cards - Minimal */
        .stat-card-minimal {
            background: white;
            border-radius: 12px;
            padding: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .stat-card-minimal:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
            display: block;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            line-height: 1.2;
        }

        .stat-icon-minimal {
            font-size: 2.2rem;
            opacity: 0.9;
        }

        /* Icon Colors */
        .text-teal {
            color: #20c997;
        }

        .text-blue {
            color: #0d6efd;
        }

        .text-purple {
            color: #6f42c1;
        }

        .text-coral {
            color: #fd7e14;
        }

        .text-orange {
            color: #fd7e14;
        }

        .text-yellow {
            color: #ffc107;
        }

        .text-green {
            color: #198754;
        }

        .text-pink {
            color: #d63384;
        }

        /* Card Minimal */
        .card-minimal {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border: 1px solid #eee;
            overflow: hidden;
        }

        .card-minimal-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-minimal-header h5 {
            font-weight: 600;
            color: #1a1a2e;
        }

        .card-minimal-body {
            padding: 0;
        }

        /* Table Minimal */
        .table-minimal {
            margin: 0;
        }

        .table-minimal tbody tr {
            border-bottom: 1px solid #f5f5f5;
            transition: background 0.2s;
        }

        .table-minimal tbody tr:last-child {
            border-bottom: none;
        }

        .table-minimal tbody tr:hover {
            background: #fafafa;
        }

        .table-minimal td {
            padding: 16px 24px;
            vertical-align: middle;
            border: none;
        }

        /* Avatar Circle */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Minimal Badge */
        .badge-minimal {
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .badge-en_attente {
            background: #fff8e6;
            color: #cc8800;
        }

        .badge-en_cours {
            background: #e8f4fd;
            color: #0066cc;
        }

        .badge-livree {
            background: #e6f7ed;
            color: #00875a;
        }

        .badge-annulee {
            background: #ffebe6;
            color: #de350b;
        }

        /* Product Card Minimal */
        .product-card-minimal {
            background: white;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        .product-card-minimal:hover {
            border-color: #ddd;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        .product-img-minimal {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 20px;
            overflow: hidden;
        }

        .product-img-minimal img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info-minimal {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .product-info-minimal strong {
            font-size: 0.85rem;
            color: #1a1a2e;
        }

        .product-price-minimal {
            font-weight: 600;
            color: #0d6efd;
            font-size: 0.9rem;
        }

        /* Buttons */
        .btn-dark {
            background: #1a1a2e;
            border: none;
        }

        .btn-dark:hover {
            background: #2d2d44;
        }

        .btn-outline-secondary {
            border-color: #dee2e6;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #495057;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            color: #adb5bd;
        }

        /* Barba.js Transitions */
        .barba-leave-active,
        .barba-enter-active {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .barba-leave {
            opacity: 1;
            transform: translateY(0);
        }

        .barba-leave-to {
            opacity: 0;
            transform: translateY(-20px);
        }

        .barba-enter {
            opacity: 0;
            transform: translateY(20px);
        }

        .barba-enter-to {
            opacity: 1;
            transform: translateY(0);
        }

        [data-barba="container"] {
            will-change: opacity, transform;
        }

        /* Pagination Minimal */
        .pagination {
            display: flex;
            gap: 6px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .page-item .page-link {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #4b5563;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            background: white;
            min-width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-item .page-link svg,
        .page-item .page-link i {
            font-size: 0.875rem !important;
            width: 14px !important;
            height: 14px !important;
        }

        .page-item .page-link:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            color: #1f2937;
        }

        .page-item.active .page-link {
            background: #1a1a2e;
            border-color: #1a1a2e;
            color: white;
        }

        .page-item.disabled .page-link {
            background: #f9fafb;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-menu a span {
                display: none;
            }

            .sidebar-header h4 {
                font-size: 1rem;
                text-align: center;
            }

            .main-content {
                margin-left: 70px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shop"></i> E-Commerce</h4>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Clients</span>
            </a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>Catégories</span>
            </a>
            <a href="{{ route('produits.index') }}" class="{{ request()->routeIs('produits.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Produits</span>
            </a>
            <a href="{{ route('commandes.index') }}" class="{{ request()->routeIs('commandes.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>
                <span>Commandes</span>
            </a>
        </div>
    </div>

    <!-- Main Content with Barba.js wrapper -->
    <div class="main-content" data-barba="wrapper">
        <div data-barba="container" data-barba-namespace="@yield('title')">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@barba/core@2.9.7/dist/barba.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        // Initialize Barba.js
        barba.init({
            transitions: [{
                name: 'fade-transition',
                leave(data) {
                    return gsap.to(data.current.container, {
                        opacity: 0,
                        y: -20,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                },
                enter(data) {
                    return gsap.from(data.next.container, {
                        opacity: 0,
                        y: 20,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                }
            }],
            preventRunning: true,
            prevent: ({ el }) => {
                // Prevent Barba on forms and specific elements
                if (el.closest('form') || el.hasAttribute('data-barba-prevent')) {
                    return true;
                }
                return false;
            }
        });

        // Reinitialize Bootstrap tooltips after page transition
        barba.hooks.after(() => {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Update active sidebar links
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath ||
                    currentPath.startsWith(link.getAttribute('href').split('?')[0])) {
                    link.classList.add('active');
                }
            });
        });

        // Initialize tooltips on first load
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>