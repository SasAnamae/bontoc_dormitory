<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bontoc Dormitory')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { padding-top: 56px; }
        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 56px;
            width: 220px;
            background-color: #f8f9fa;
            padding-top: 1rem;
            font-family: 'Poppins', sans-serif !important;
        }
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .content {
            margin-left: 220px;
            padding: 1.5rem;
        }
        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }
        .dropdown-header {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    @auth
        @include('layouts.partials.topnav')
        @include('layouts.partials.sidenav')
    @endauth

    <div class="content">
        {{-- Flash Messages --}}
        <div class="container mt-3">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        @yield('content')
        @stack('scripts')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cancel Reservation (Student)
        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Cancel Reservation?',
                    text: "This cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            });
        });

        // Approve
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Approve this reservation?',
                    text: "The student will be notified.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, approve',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            });
        });

        // Reject
        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Reject this reservation?',
                    text: "The student will be notified.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, reject',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            });
        });

        // Delete (Admin)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Delete this reservation?',
                    text: "This action is permanent!",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            });
        });

        // Notification Badge Updater
        function updateNotificationBadge() {
            fetch('{{ route('notifications.count') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    if (data.count > 0) {
                        badge.innerText = data.count;
                        badge.classList.remove('d-none');
                    } else {
                        badge.classList.add('d-none');
                    }
                });
        }
        updateNotificationBadge();
        setInterval(updateNotificationBadge, 10000); // every 10 seconds

        // Notification Fetch
        function fetchNotifications() {
            $.ajax({
                url: "{{ route('notifications.fetch') }}",
                method: 'GET',
                success: function (response) {
                    $('#notificationBadge').toggleClass('d-none', response.count === 0);
                    $('#notificationBadge').text(response.count);
                    $('#notificationList').html(response.html);
                },
                error: function (xhr) {
                    console.error("Notification fetch failed", xhr);
                }
            });
        }
        setInterval(fetchNotifications, 10000); // every 10 seconds
    });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif
</body>
</html>

