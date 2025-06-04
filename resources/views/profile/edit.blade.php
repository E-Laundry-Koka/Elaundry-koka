<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #194376;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .profile-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .profile-card h2 {
            color: #194376;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .profile-card h3 {
            color: #194376;
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .profile-card p {
            color: #6c757d;
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background-color: #194376;
            border-color: #194376;
        }
        
        .btn-primary:hover {
            background-color: #163a68;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #194376;
            box-shadow: 0 0 0 0.2rem rgba(25, 67, 118, 0.25);
            outline: none;
        }
        
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn i {
            font-size: 14px;
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
        
        .container-custom {
            max-width: 800px;
            margin: 0 auto;
            padding: 100px 20px 50px;
        }
        
        .page-title {
            color: white;
            text-align: center;
            margin-bottom: 40px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <a href="/dashboard" class="position-absolute top-0 start-0 m-4 d-flex align-items-center text-white text-decoration-none">
        <div class="back-button me-2">
            <i class="bi bi-arrow-left" style="font-size: 1.2rem;"></i>
        </div>
        <span>Kembali</span>
    </a>

    <div class="container-custom">
        <h1 class="page-title">{{ __('Profile') }}</h1>

        <!-- Update Profile Information -->
        <div class="profile-card">
            <h3>
                <i class="bi bi-person-circle me-2"></i>
                {{ __('Update Profile Information') }}
            </h3>
            <p>{{ __("Perbarui informasi profil akun Anda.") }}</p>
            
            <form method="POST" action="{{ route('profile.update', ['id' => auth()->user()->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="foto_profile" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" id="foto_profile" name="foto_profile" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    <div class="mt-2">
                        @if(auth()->user()->foto_profile)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Current Profile" class="rounded-circle" width="100">
                        @else
                            <img src="{{ asset('img/user.jpg') }}" alt="Default Profile" class="rounded-circle" width="100">
                        @endif
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="profile-card">
            <h3>
                <i class="bi bi-shield-lock me-2"></i>
                {{ __('Update Password') }}
            </h3>
            <p>{{ __('Pastikan akun Anda menggunakan kata sandi yang aman.') }}</p>
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-check me-1"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="profile-card">
            <h3>
                <i class="bi bi-exclamation-triangle me-2 text-danger"></i>
                {{ __('Delete Account') }}
            </h3>
            <p>{{ __('Hapus akun Anda secara permanen.') }}</p>
            <p class="text-muted small">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
            
            <div class="d-flex justify-content-start">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash me-1"></i>
                    Delete Account
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                        @csrf
                        @method('delete')
                        
                        <div class="mb-3">
                            <label for="password_delete" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_delete" name="password" placeholder="Enter your password to confirm" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>