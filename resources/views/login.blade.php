<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #194376;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-card h2 {
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
            background-color: rgba(255, 255, 255, 0.1); /* transparan */
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
    <a href="/" class="position-absolute top-0 start-0 m-4 d-flex align-items-center text-white text-decoration-none">
        <div class="back-button me-2">
            <i class="bi bi-arrow-left" style="font-size: 1.2rem;"></i>
        </div>
        <span>Kembali</span>
    </a>

    <div class="login-card">
        <h2>Login</h2>
        <form action="/login" method="POST">
            <!-- Tambahkan CSRF jika di Laravel -->
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="mt-3 d-flex justify-content-between">
            <a href="#" class="text-decoration-none" style="color: #194376;">Forgot password?</a>
            <a href="/signup" class="text-decoration-none" style="color: #194376; ">Don't have an account?</a>
        </div>
    </div>

</body>
</html>