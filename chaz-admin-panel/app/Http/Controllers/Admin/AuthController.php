<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !password_verify($request->password, $admin->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        if (!$admin->is_active) {
            return back()->withErrors(['email' => 'Your account has been deactivated.']);
        }

        // Load RBAC permissions from new role system
        $permissions = [];
        if ($admin->role_id && $admin->roleModel) {
            $permissions = $admin->loadPermissions();
            // Super admin gets wildcard
            if ($admin->roleModel->slug === 'super_admin') {
                $permissions[] = 'super_admin';
            }
        } elseif ($admin->role === 'superadmin') {
            // Legacy fallback
            $permissions = ['super_admin'];
        }

        session([
            'admin_id'          => $admin->id,
            'admin_name'        => $admin->name,
            'admin_email'       => $admin->email,
            'admin_role'        => $admin->role_id ? ($admin->roleModel->slug ?? $admin->role) : $admin->role,
            'admin_role_label'  => $admin->role_id ? ($admin->roleModel->display_name ?? $admin->role) : $admin->role,
            'admin_department'  => $admin->department_id,
            'admin_permissions' => $permissions,
        ]);

        AuditLog::record('login');

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        AuditLog::record('logout');
        session()->flush();
        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }
}
