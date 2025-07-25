<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Dormitory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .register-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .register-left {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            padding: 40px;
        }

        .register-left .card {
            width: 100%;
            max-width: 400px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .register-right {
            flex: 2;
            position: relative;
        }

        .carousel-item img {
            height: 100vh;
            object-fit: cover;
        }

        .register-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .register-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            text-align: center;
            z-index: 2;
        }

        .register-text h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .register-text p {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .register-right { display: none; }
            .register-left { flex: 1 1 100%; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left side (Sign Up Form) -->
        <div class="register-left">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Create Your Account</h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye" id="toggleIconReg1"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="bi bi-eye" id="toggleIconReg2"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Sign Up</button>
                        <p class="text-center mt-3">
                            Already have an account? <a href="{{ url('/') }}">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right side (Slideshow) -->
        <div class="register-right">
            <div id="registerCarousel" class="carousel slide" data-bs-ride="carousel">
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
            <div class="register-overlay"></div>
            <div class="register-text">
                <h1>Join DormTrack Today</h1>
                <p>Experience modern dormitory living.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            @elseif(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                });
            @endif
        });

        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>
</body>
</html>
