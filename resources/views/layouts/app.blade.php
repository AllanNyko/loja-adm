<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JD Smart')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            overflow-x: hidden;
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 20%;
            min-width: 200px;
            max-width: 250px;
            background-color: #212529;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
        }
        
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }
        
        .main-content {
            
            width: 80%;
            margin-left: 15%;
            min-height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        /* Mobile styles */
        @media (max-width: 767.98px) {
            body {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .main-content {
                width: 100%;
                margin-left: 0;
            }
            
            .mobile-navbar {
                display: flex !important;
            }
        }
        
        /* Desktop styles */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0) !important;
            }
            
            .mobile-navbar {
                display: none !important;
            }
        }
        
        .mobile-navbar {
            display: none;
        }
        
        .btn-mobile {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* Cards responsivos */
        @media (max-width: 575.98px) {
            .card {
                margin-bottom: 1rem;
            }
        }
        
        /* Garantir que canvas dos gráficos seja responsivo */
        canvas {
            max-width: 100%;
            height: auto !important;
        }
        
        .card-body {
            overflow-x: auto;
        }
        
        .chart-container {
            position: relative;
            margin-bottom: 1rem;
        }
        
        /* Garantir que containers Bootstrap não extrapolem */
        .container-fluid {
            max-width: 100%;
        }
    </style>
</head>
<body>
    <!-- Overlay para fechar sidebar no mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3 d-flex justify-content-between align-items-center border-bottom">
            <h4 class="text-white mb-0"><i class="bi bi-phone"></i> JD Smart</h4>
            <button class="btn btn-link text-white d-md-none" id="closeSidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- User Info -->
        @auth
        <div class="p-3 border-bottom">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-person-circle fs-3 text-white me-2"></i>
                <div>
                    <div class="text-white fw-bold small">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </button>
            </form>
        </div>
        @endauth

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                <i class="bi bi-graph-up"></i> Relatórios
            </a>
            <a class="nav-link {{ request()->routeIs('service-orders.*') ? 'active' : '' }}" href="{{ route('service-orders.index') }}">
                <i class="bi bi-tools"></i> Ordens de Serviço
            </a>
            <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                <i class="bi bi-cart"></i> Vendas
            </a>
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <i class="bi bi-box"></i> Produtos
            </a>
            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <i class="bi bi-people"></i> Clientes
            </a>
            <a class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                <i class="bi bi-wallet2"></i> Despesas
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Mobile Navbar -->
        <nav class="navbar navbar-dark bg-dark mobile-navbar">
            <div class="container-fluid">
                <button class="btn btn-link text-white" id="openSidebar">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <span class="navbar-brand mb-0 h5">@yield('page-title', 'Dashboard')</span>
                <div style="width: 40px;"></div> <!-- Spacer para centralizar -->
            </div>
        </nav>
        
        <!-- Desktop Navbar -->
        <nav class="navbar navbar-light bg-light border-bottom d-none d-md-block">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('page-title', 'Dashboard')</span>
            </div>
        </nav>

        <div class="p-3 p-md-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Controle da sidebar no mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        
        if (openSidebar) {
            openSidebar.addEventListener('click', () => {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
            });
        }
        
        if (closeSidebar) {
            closeSidebar.addEventListener('click', () => {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }
        
        // Fechar sidebar ao clicar em um link no mobile
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
