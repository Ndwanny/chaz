<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — CHAZ</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        body.admin-body { display: flex; align-items: center; justify-content: center; background: var(--primary); min-height: 100vh; }
        .login-wrap { width: 100%; max-width: 400px; padding: 16px; }
        .login-card { background: var(--white); border-radius: 12px; padding: 40px 36px; box-shadow: 0 20px 60px rgba(0,0,0,.25); }
        .login-logo { text-align: center; margin-bottom: 28px; }
        .login-logo .logo-icon { width: 60px; height: 60px; background: var(--primary); border-radius: 14px; display: inline-grid; place-items: center; margin-bottom: 12px; }
        .login-logo .logo-icon i { font-size: 1.6rem; color: #fff; }
        .login-logo h1 { font-size: 1.2rem; font-weight: 800; color: var(--primary); }
        .login-logo p  { font-size: .8rem; color: var(--text-muted); margin-top: 2px; }
        .login-card .form-group { margin-bottom: 16px; }
        .login-btn { width: 100%; justify-content: center; padding: 11px; font-size: .95rem; margin-top: 8px; }
        .login-footer { text-align: center; margin-top: 20px; font-size: .78rem; color: rgba(255,255,255,.7); }
    </style>
</head>
<body class="admin-body">
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <div class="logo-icon"><i class="fas fa-shield-halved"></i></div>
            <h1>CHAZ Admin</h1>
            <p>Churches Health Association of Zambia</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error" style="margin-bottom:16px;">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:16px;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@chaz.org.zm">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-primary login-btn">
                <i class="fas fa-right-to-bracket"></i> Sign In
            </button>
        </form>
    </div>
    <p class="login-footer">&copy; {{ date('Y') }} CHAZ — Secure Admin Portal</p>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</body>
</html>
