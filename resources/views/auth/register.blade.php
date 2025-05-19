<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #194376;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        .register-card h2 {
            color: #194376;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        .btn-primary {
            background-color: #194376;
            border-color: #194376;
        }

        .btn-primary:hover {
            background-color: #163a68;
        }

        .form-control:focus {
            border-color: #194376;
            box-shadow: 0 0 0 0.2rem rgba(25, 67, 118, 0.25);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Tombol Kembali -->
    <a href="{{ route('login') }}" class="position-absolute top-0 start-0 m-4 back-button">
        <i class="bi bi-arrow-left" style="font-size: 1.2rem;"></i>
    </a>

    <div class="register-card">
        <h2>Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create password" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" required>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="mt-3 d-flex justify-content-between">
            <span class="text-muted">Already have an account?</span>
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #194376;">Login</a>
        </div>
    </div>

</body>
</html>