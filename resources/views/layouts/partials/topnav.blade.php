<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">🏠 Bontoc Dormitory</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTop">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                @auth
              {{-- Notification Bell --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell fa-lg"></i>
                            
                            {{-- Notification Badge --}}
                            <span id="notificationBadge"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger animate__animated animate__bounce {{ auth()->user()->unreadNotifications->count() ? '' : 'd-none' }}"
                                style="font-size: 0.65rem; z-index: 1;">
                                {{ auth()->user()->unreadNotifications->count() }}
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        </a>

                       <ul id="notificationList"
                            class="dropdown-menu dropdown-menu-end shadow-lg border-0 animate__animated animate__fadeIn"
                            aria-labelledby="notificationsDropdown"
                            style="min-width: 360px; max-height: 420px; overflow-y: auto;">
                            
                            @include('layouts.partials.notification-items', ['notifications' => auth()->user()->notifications])
                        </ul>
                    </li>
                {{-- User Name --}}
                <li class="nav-item d-flex align-items-center ms-2">
                    <span class="nav-link p-0 text-white" style="line-height: 1;">{{ Auth::user()->name }}</span>
                </li>
                {{-- Logout --}}
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-pill">Logout</button>
                    </form>
                </li>
                @else
                {{-- Guest Links --}}
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
                </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
