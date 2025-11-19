<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Sistem Informasi KKN')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1e4fbe;
            --secondary-color: #2c6de9;
            --light-color: #e8f0fe;
            --dark-color: #0a2a75;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: var(--dark-color);
            text-align: center;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.collapsed .sidebar-header {
            padding: 20px 10px;
        }

        #sidebar.collapsed .sidebar-header h3 {
            display: none;
        }

        #sidebar.collapsed .sidebar-header p {
            display: none;
        }

        #sidebar ul.components {
            transition: all 0.3s ease;
            flex-grow: 1;
        }

        #sidebar ul li a {
            padding: 15px 25px;
            display: block;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.collapsed ul li a {
            padding: 15px;
            text-align: center;
        }

        #sidebar.collapsed ul li a span {
            display: none;
        }

        #sidebar ul li a:hover {
            background: var(--secondary-color);
            color: white;
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        #sidebar.collapsed ul li a i {
            margin-right: 0;
            font-size: 1.3rem;
        }

        #sidebar ul li.active>a {
            background: var(--secondary-color);
            color: white;
        }

        /* Sidebar footer */
        #sidebar .sidebar-footer {
            padding: 15px;
            margin-top: auto;
        }

        #sidebar.collapsed .sidebar-footer {
            padding: 15px 5px;
        }

        #sidebar.collapsed .sidebar-footer .btn span {
            display: none;
        }

        #sidebar.collapsed .sidebar-footer .btn i {
            margin-right: 0;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 999;
            transition: all 0.3s ease;
        }

        #content.collapsed .navbar {
            left: var(--sidebar-collapsed-width);
        }

        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
            padding-top: 80px;
        }

        #content.collapsed {
            width: calc(100% - var(--sidebar-collapsed-width));
            margin-left: var(--sidebar-collapsed-width);
        }

        .dropdown-menu-container {
            position: relative;
        }

        .dropdown-menu-custom {
            display: none;
            position: static;
            float: none;
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 0;
            box-shadow: none;
        }

        .dropdown-menu-custom.show {
            display: block;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .dropdown-toggle[aria-expanded="true"] .dropdown-arrow {
            transform: rotate(90deg);
        }

        .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .dropdown-menu-item {
            padding-left: 50px !important;
            background-color: rgba(0, 0, 0, 0.1);
            margin-bottom: 0;
            border-left: 3px solid transparent;
        }

        .dropdown-menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-left-color: var(--secondary-color);
        }

        #sidebar.collapsed ul li a[data-bs-toggle="tooltip"] {
            position: relative;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
            cursor: default;
        }
    </style>

    @yield('style')
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('dashboard.dosen.layouts.sidebar')
        <div id="content">
            @include('dashboard.dosen.layouts.navbar')

            <main class="container-fluid p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Base JavaScript functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const navbar = document.querySelector('.navbar');
            const sidebarCollapse = document.getElementById('sidebarCollapse');

            sidebarCollapse.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');

                // Adjust navbar position
                if (sidebar.classList.contains('collapsed')) {
                    navbar.style.left = getComputedStyle(document.documentElement).getPropertyValue(
                        '--sidebar-collapsed-width');
                } else {
                    navbar.style.left = getComputedStyle(document.documentElement).getPropertyValue(
                        '--sidebar-width');
                }

                // Toggle icon
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-chevron-right');
                } else {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-bars');
                }

                // Initialize tooltips when sidebar is collapsed
                if (sidebar.classList.contains('collapsed')) {
                    initTooltips();
                } else {
                    destroyTooltips();
                }
            });

            // Initialize tooltips
            function initTooltips() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            function destroyTooltips() {
                const tooltipList = document.querySelectorAll('.tooltip');
                tooltipList.forEach(tooltip => {
                    tooltip.remove();
                });
            }
            // Handle dropdown menu toggles
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const dropdown = this.nextElementSibling;
                    const isShowing = dropdown.classList.contains('show');

                    // Close all dropdowns first
                    document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                        menu.classList.remove('show');
                    });

                    document.querySelectorAll('.dropdown-toggle').forEach(t => {
                        t.setAttribute('aria-expanded', 'false');
                        const chevron = t.querySelector('.fa-chevron-right');
                        if (chevron) {
                            chevron.classList.remove('fa-rotate-90');
                        }
                    });

                    // Toggle current dropdown if it wasn't already showing
                    if (!isShowing) {
                        dropdown.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                        const chevron = this.querySelector('.fa-chevron-right');
                        if (chevron) {
                            chevron.classList.add('fa-rotate-90');
                        }
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.matches('.dropdown-toggle') && !e.target.closest('.dropdown-toggle')) {
                    document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                        menu.classList.remove('show');
                    });

                    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                        toggle.setAttribute('aria-expanded', 'false');
                        const chevron = toggle.querySelector('.fa-chevron-right');
                        if (chevron) {
                            chevron.classList.remove('fa-rotate-90');
                        }
                    });
                }
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
