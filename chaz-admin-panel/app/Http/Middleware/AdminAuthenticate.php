<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please log in to continue.');
        }

        // Attach current admin to the request and share with views
        $admin = Admin::with(['roleModel', 'department'])->find(session('admin_id'));

        if (!$admin || !$admin->is_active) {
            session()->flush();
            return redirect()->route('admin.login')->with('error', 'Your account is inactive. Contact the administrator.');
        }

        view()->share('currentAdmin', $admin);

        return $next($request);
    }
}
