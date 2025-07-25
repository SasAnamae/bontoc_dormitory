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
                        @if(auth()->user()->unreadNotifications->count())
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger animate__animated animate__bounce">
                                {{ auth()->user()->unreadNotifications->count() }}
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 animate__animated animate__fadeIn" aria-labelledby="notificationsDropdown" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                        <li class="px-3 py-2 d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">Notifications</span>
                            @if(auth()->user()->notifications->count())
                                <form action="{{ route('notifications.destroyAll') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill">Clear All</button>
                                </form>
                            @endif
                        </li>
                        <li><hr class="dropdown-divider"></li>

                        @forelse(auth()->user()->notifications as $notification)
                            <li>
                                <a href="{{ route('notifications.read', $notification->id) }}" 
                                   class="dropdown-item small d-flex justify-content-between align-items-center {{ $notification->read_at ? 'text-muted' : 'fw-bold' }}">
                                    <span>{{ $notification->data['message'] }}</span>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @empty
                            <li>
                                <span class="dropdown-item text-muted small">No notifications yet</span>
                            </li>
                        @endforelse
                    </ul>
                </li>

                {{-- User Name --}}
                <li class="nav-item me-2">
                    <span class="nav-link">{{ Auth::user()->name }}</span>
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
