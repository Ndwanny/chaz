<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Admin, Role, Department, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = Admin::with(['roleModel', 'department'])->orderBy('name')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles       = Role::active()->ordered()->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.users.form', compact('roles', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:admins,email',
            'password'      => 'required|string|min:8|confirmed',
            'role'          => 'required|in:superadmin,editor',
            'role_id'       => 'nullable|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
            'staff_id'      => 'nullable|string|max:20|unique:admins,staff_id',
            'phone'         => 'nullable|string|max:20',
            'is_active'     => 'boolean',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        $user = Admin::create($data);
        AuditLog::record('created_user', 'Admin', $user->id, [], $user->toArray());

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(Admin $user)
    {
        $roles       = Role::active()->ordered()->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.users.form', compact('user', 'roles', 'departments'));
    }

    public function update(Request $request, Admin $user)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:admins,email,' . $user->id,
            'role'          => 'required|in:superadmin,editor',
            'role_id'       => 'nullable|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
            'staff_id'      => 'nullable|string|max:20|unique:admins,staff_id,' . $user->id,
            'phone'         => 'nullable|string|max:20',
            'is_active'     => 'boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $data['is_active'] = $request->boolean('is_active');
        $old = $user->toArray();
        $user->update($data);

        AuditLog::record('updated_user', 'Admin', $user->id, $old, $user->fresh()->toArray());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Admin $user)
    {
        if ($user->id === session('admin_id')) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        AuditLog::record('deleted_user', 'Admin', $user->id, $user->toArray(), []);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
