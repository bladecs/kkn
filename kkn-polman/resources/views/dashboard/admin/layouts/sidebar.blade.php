<nav id="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-graduation-cap me-2"></i> SIKKN</h3>
        <p class="mb-0 text-light">Sistem Informasi KKN</p>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ request()->routeIs('dashboard_admin') ? 'active' : '' }}">
            <a href="{{ route('dashboard_admin') }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>

        <!-- Management User Dropdown -->
        <li class="dropdown-menu-container">
            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-file-medical"></i> <span>Management User</span>
                <i class="fas fa-chevron-right dropdown-arrow"></i>
            </a>
            <ul class="dropdown-menu-custom">
                <li>
                    <a href="{{ route('create_user') }}" class="dropdown-menu-item">
                        <i class="fas fa-project-diagram"></i>
                        <span>Create User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kelola_user') }}" class="dropdown-menu-item">
                        <i class="fas fa-tasks"></i>
                        <span>Kelola User</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Pengaturan">
                <i class="fas fa-cog"></i> <span>Pengaturan</span>
            </a>
        </li>
        <li>
            <a href="#" data-bs-toggle="tooltip" data-bs-placement="right" title="Bantuan">
                <i class="fas fa-question-circle"></i> <span>Bantuan</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="d-grid gap-2">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>
