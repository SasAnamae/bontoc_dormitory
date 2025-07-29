<div class="sidebar">
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
               <a class="nav-link {{ request()->routeIs('admin.student_info.index') ? 'active' : '' }}" 
                href="{{ route('admin.student_info.index') }}">
                    <i class="fas fa-users"></i> Occupant Info
                </a>
                <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" 
                    href="{{ route('admin.reservations.index') }}">
                    <i class="fas fa-clipboard-list"></i> Reservations
                </a>
               <a class="nav-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}" 
                    href="{{ route('admin.applications.index') }}">
                    <i class="fas fa-clipboard-list"></i> Applications
                </a>
                <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
                    href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-coins"></i> Payments
                </a>
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                    href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-flag"></i> Student Reports
                </a>
                <a class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" 
                    href="{{ route('admin.announcements.index') }}">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
            </nav>

        @elseif(Auth::user()->role === 'cashier')
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('cashier.dashboard') ? 'active' : '' }}" href="{{ route('cashier.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('cashier.payments.*') ? 'active' : '' }}" 
                    href="{{ route('cashier.payments.index') }}">
                    <i class="fas fa-credit-card"></i> Process Payments
                </a>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cashier.occupants.index') ? 'active' : '' }}" 
                        href="{{ route('cashier.occupants.index') }}">
                        <i class="fas fa-users"></i> Occupants
                    </a>
                </li>
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
