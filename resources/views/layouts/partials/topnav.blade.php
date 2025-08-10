<!-- Include Font Awesome (before closing </head> in your layout) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">🏠 Bontoc Dormitory</a>

        {{-- PC SCREEN CONTENT --}}
        <div class="d-none d-lg-flex ms-auto align-items-center gap-2">
            @auth
                {{-- Notification Bell --}}
                <div class="nav-item dropdown">
                    <a class="nav-link position-relative text-warning" {{-- force visible color --}}
                       href="#" id="notificationsDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell fa-lg"></i>
                        <span id="notificationBadge"
                              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ auth()->user()->unreadNotifications->count() ? '' : 'd-none' }}"
                              style="font-size: 0.65rem; z-index: 1;">
                              {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </a>
                    <ul id="notificationList" class="dropdown-menu dropdown-menu-end shadow-lg border-0"
                        style="min-width: 360px; max-height: 420px; overflow-y: auto;">
                        @include('layouts.partials.notification-items', ['notifications' => auth()->user()->notifications])
                    </ul>
                </div>

                {{-- User Name --}}
                <span class="nav-link p-0 text-white">{{ Auth::user()->name }}</span>

                {{-- Logout --}}
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-pill">Logout</button>
                </form>
            @endauth
        </div>

        {{-- MOBILE SCREEN CONTENT --}}
        <div class="d-flex d-lg-none ms-auto align-items-center gap-3">
            @auth
                {{-- Notification Bell --}}
                <a class="nav-link position-relative text-warning"
                   href="#" id="mobileNotificationsDropdown" role="button" 
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell fa-lg"></i>
                    <span id="notificationBadgeMobile"
                          class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ auth()->user()->unreadNotifications->count() ? '' : 'd-none' }}"
                          style="font-size: 0.65rem; z-index: 1;">
                          {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                </a>
                <ul id="notificationListMobile" class="dropdown-menu dropdown-menu-end shadow-lg border-0"
                    style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                    @include('layouts.partials.notification-items', ['notifications' => auth()->user()->notifications])
                </ul>

                {{-- Logout Icon --}}
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-pill">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

