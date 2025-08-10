<style>
/* Default sidebar style */
.sidebar {
    width: 250px;
    background: #343a40;
    color: white;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 60px; /* space for topnav if needed */
    transition: transform 0.3s ease-in-out;
    z-index: 999;
}

/* Links inside sidebar */
.sidebar .nav-link {
    color: white;
}
.sidebar .nav-link.active {
    background: #495057;
}

/* Sidebar hidden on mobile */
.sidebar-closed {
    transform: translateX(-100%);
}

/* Toggle button (hamburger) */
.sidebar-toggle {
    display: none;
    top: 15px;
    left: 15px;
    background: #343a40;
    color: white;
    border: none;
    padding: 8px 10px;
    cursor: pointer;
    font-size: 20px;
    z-index: 1000;
}

/* Show toggle only on small screens */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar-toggle {
        display: block;
    }
    .sidebar.open {
        transform: translateX(0);
    }
}
</style>

<!-- Toggle Button -->
<button class="sidebar-toggle" id="sidebarToggle">
    ☰
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebarMenu">
    @auth
        @if(Auth::user()->role === 'admin')
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.dormitories.*') ? 'active' : '' }}" href="{{ route('admin.dormitories.index') }}">
                    <i class="fas fa-building"></i> Dormitories
                </a>
                <a class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}">
                    <i class="fas fa-building"></i> Rooms
                </a>
                <a class="nav-link {{ request()->routeIs('admin.student_info.index') ? 'active' : '' }}" href="{{ route('admin.student_info.index') }}">
                    <i class="fas fa-users"></i> Occupant Info
                </a>
                <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                    <i class="fas fa-clipboard-list"></i> Requests
                </a>
                <a class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}" href="{{ route('admin.applications.index') }}">
                    <i class="fas fa-clipboard-list"></i> Applications
                </a>
                <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-coins"></i> Payments
                </a>
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-flag"></i> Student Reports
                </a>
                <a class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
            </nav>
        @elseif(Auth::user()->role === 'cashier')
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('cashier.dashboard') ? 'active' : '' }}" href="{{ route('cashier.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('cashier.payments.*') ? 'active' : '' }}" href="{{ route('cashier.payments.index') }}">
                    <i class="fas fa-credit-card"></i> Process Payments
                </a>
                <a class="nav-link {{ request()->routeIs('cashier.occupants.index') ? 'active' : '' }}" href="{{ route('cashier.occupants.index') }}">
                    <i class="fas fa-users"></i> Occupants
                </a>
            </nav>
        @elseif(Auth::user()->role === 'student')
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('student.reservations') ? 'active' : '' }}" href="{{ route('student.reservations') }}">
                    <i class="fas fa-calendar-alt"></i> Reservation
                </a>
                <a class="nav-link {{ request()->routeIs('student.payments') ? 'active' : '' }}" href="{{ route('student.payments.index') }}">
                    <i class="fas fa-receipt"></i> Payments
                </a>
                <a class="nav-link {{ request()->routeIs('student.report.*') ? 'active' : '' }}" href="{{ route('student.report.index') }}">
                    <i class="fas fa-flag"></i> Reports
                </a>
            </nav>
        @endif
    @endauth
</div>

<script>
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebarMenu').classList.toggle('open');
});
</script>
