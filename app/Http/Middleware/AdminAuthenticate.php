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
            return redirect()->route('admin.login')
                ->with('error', 'Please log in to access the admin panel.');
        }

        // Load current admin and share with all views (for new panel modules)
        try {
            $admin = Admin::with(['roleModel', 'department'])->find(session('admin_id'));

            if ($admin && isset($admin->is_active) && !$admin->is_active) {
                session()->flush();
                return redirect()->route('admin.login')
                    ->with('error', 'Your account is inactive. Contact the administrator.');
            }

            if ($admin) {
                view()->share('currentAdmin', $admin);
            }
        } catch (\Exception $e) {
            // Gracefully skip if new columns/tables not yet migrated
        }

        return $next($request);
    }
}
