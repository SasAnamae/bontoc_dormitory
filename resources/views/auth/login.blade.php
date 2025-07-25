<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dormitory System - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .welcome-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .welcome-left {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            padding: 40px;
        }

        .welcome-left .card {
            width: 100%;
            max-width: 400px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .welcome-right {
            flex: 2;
            position: relative;
        }

        .carousel-item img {
            height: 100vh;
            object-fit: cover;
        }

        .welcome-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .welcome-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            text-align: center;
            z-index: 2;
        }

        .welcome-text h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .welcome-text p {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .welcome-text h1 {
                font-size: 2.5rem;
            }

            .welcome-text p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-left">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Bontoc Dormitory</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" id="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye" id="toggleIconLogin"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <p class="text-center mt-3">
                            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div class="welcome-right">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/room1.jpg') }}" class="d-block w-100" alt="Room 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/room2.jpg') }}" class="d-block w-100" alt="Room 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/room3.jpg') }}" class="d-block w-100" alt="Room 3">
                    </div>
                </div>
            </div>
            <div class="welcome-overlay"></div>
            <div class="welcome-text">
                <h1>SLSU - Bontoc Dormitory</h1>
                <p>Modern. Secure. Comfortable.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            @elseif(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                });
            @endif
        });
    </script>
</body>
</html>
