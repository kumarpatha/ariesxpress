<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Aries Xpress Logistics Pvt. Ltd</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        body { background: linear-gradient(135deg, #0062cc 0%, #003d80 100%); }
        .login-logo a { color: #fff; font-size: 1.8rem; font-weight: 700; }
        .login-logo small { display: block; font-size: 0.9rem; font-weight: 300; color: rgba(255,255,255,0.8); }
        .card { border: none; border-radius: 12px; }
        .login-page { background: transparent; }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo mb-3">
        <a href="#">
            <img src="{{ asset('logo.jpg') }}" alt="Aries Logo" class="mr-2" style="height: 45px; width: auto; vertical-align: middle;">Aries Admin
            <small>Aries Xpress Logistics Pvt. Ltd</small>
        </a>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header text-center border-0 pt-4">
            <h5 class="mb-0 font-weight-bold text-muted">Sign in to your account</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email address"
                           value="{{ old('email') }}"
                           autofocus required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password"
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-1"></i> Sign In
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('tracking.index') }}" class="text-muted small">
                    <i class="fas fa-search mr-1"></i>Track a Shipment
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
