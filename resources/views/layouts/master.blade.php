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
        body {
            padding-top: 56px;
            font-family: 'Poppins', sans-serif !important;
        }

        /* Sidebar - Desktop */
        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 56px;
            width: 220px;
            background-color: #f8f9fa;
            padding-top: 1rem;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar .nav-link.active {
            background-color: #e9ecef;
            font-weight: bold;
        }

        /* Content - Desktop */
        .content {
            margin-left: 220px;
            padding: 1.5rem;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Mobile View */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1050;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .sidebar-overlay {
                position: fixed;
                top: 56px;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.3);
                display: none;
                z-index: 1049;
            }
            .sidebar-overlay.show {
                display: block;
            }
            /* Show toggle button only on mobile */
            .sidebar-toggle {
                display: inline-block !important;
            }
            /* Sidebar links */
            .sidebar .nav-link {
                color: #fff;
                padding: 10px;
            }
            .sidebar .nav-link.active {
                background: #495057;
                border-radius: 4px;
            }
        }

        /* Hide toggle button on desktop */
        .sidebar-toggle {
            display: none;
            border: none;
            background: none;
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    @auth
        @include('layouts.partials.topnav')
            @include('layouts.partials.sidenav')
    @endauth

        <div class="content">
        <div class="container mt-3">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
        @yield('content')
        @stack('scripts')
    </div>

      {{-- Toggle Sidebar Script --}}
    <script>
        const sidebar = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Close sidebar when clicking overlay
        overlay.addEventListener('click', toggleSidebar);
    </script>


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
    <script>
    function showTab(tabId) {
        const tabs = document.querySelectorAll('.tab-pane');
        tabs.forEach(tab => {
            tab.classList.remove('show', 'active');
        });

        const target = document.getElementById(tabId);
        if (target) {
            target.classList.add('show', 'active');
        }
    }
</script>

</body>
</html>

