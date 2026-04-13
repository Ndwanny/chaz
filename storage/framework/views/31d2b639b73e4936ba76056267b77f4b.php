<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — CHAZ</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --forest: #1B4332; --forest-mid: #2D6A4F;
            --gold: #C9A84C; --gold-lite: #E9C46A;
            --border: #E2E8F0; --slate: #2C3E50; --red: #E53E3E;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--forest) 0%, #0F2A1E 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
        }
        .login-wrap {
            width: 100%; max-width: 420px;
        }
        .login-brand {
            text-align: center; margin-bottom: 2rem;
        }
        .login-logo {
            width: 56px; height: 56px;
            background: var(--gold);
            border-radius: 12px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.5rem; font-weight: 700; color: var(--forest);
            margin-bottom: 1rem;
        }
        .login-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; color: white; font-weight: 700;
        }
        .login-brand p { font-size: 0.82rem; color: rgba(255,255,255,0.5); margin-top: 0.3rem; }

        .login-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 24px 64px rgba(0,0,0,0.3);
        }
        .login-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem; color: var(--forest);
            margin-bottom: 0.4rem;
        }
        .login-card p { font-size: 0.85rem; color: #718096; margin-bottom: 2rem; }

        .alert { padding: 0.85rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem; }
        .alert-error   { background: rgba(229,62,62,0.08); border: 1px solid rgba(229,62,62,0.2); color: #C53030; }
        .alert-success { background: rgba(56,161,105,0.1); border: 1px solid rgba(56,161,105,0.25); color: #276749; }

        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--slate); margin-bottom: 0.45rem; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%); color: #A0AEC0; font-size: 0.9rem; }
        .form-control {
            width: 100%; padding: 0.75rem 0.9rem 0.75rem 2.5rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem; font-family: inherit;
            color: var(--slate); outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus { border-color: var(--forest); box-shadow: 0 0 0 3px rgba(27,67,50,0.08); }
        .form-error { font-size: 0.75rem; color: var(--red); margin-top: 0.3rem; }

        .btn-submit {
            width: 100%; padding: 0.85rem;
            background: var(--forest); color: white;
            border: none; border-radius: 8px;
            font-family: inherit; font-size: 0.9rem; font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-submit:hover { background: var(--forest-mid); }
        .btn-submit:active { transform: scale(0.99); }

        .login-footer { text-align: center; margin-top: 1.5rem; }
        .login-footer a { font-size: 0.82rem; color: rgba(255,255,255,0.5); transition: color 0.2s; }
        .login-footer a:hover { color: var(--gold-lite); }

        .demo-creds {
            background: rgba(201,168,76,0.08);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 8px; padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
        }
        .demo-creds p { font-size: 0.78rem; color: #8B6914; font-weight: 500; line-height: 1.8; }
        .demo-creds strong { color: var(--forest); }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-brand">
        <div class="login-logo">✛</div>
        <h1>CHAZ</h1>
        <p>Churches Health Association of Zambia</p>
    </div>

    <div class="login-card">
        <h2>Admin Sign In</h2>
        <p>Enter your credentials to access the management panel.</p>

        <?php if(session('error')): ?>
        <div class="alert alert-error"><i class="fa fa-circle-xmark"></i> <?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="demo-creds">
            <p><strong>Default credentials:</strong><br>
            Email: <strong>admin@chaz.org.zm</strong><br>
            Password: <strong>Chaz@2024!</strong></p>
        </div>

        <form action="<?php echo e(route('admin.login.post')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrap">
                    <i class="fa fa-envelope input-icon"></i>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?php echo e(old('email')); ?>" placeholder="admin@chaz.org.zm" required autofocus>
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <i class="fa fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="••••••••" required>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa fa-right-to-bracket"></i> Sign In to Admin Panel
            </button>
        </form>
    </div>

    <div class="login-footer">
        <a href="<?php echo e(route('home')); ?>"><i class="fa fa-arrow-left"></i> Back to main website</a>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>