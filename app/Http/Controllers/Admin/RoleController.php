<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Role, Permission, AuditLog};
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('admins')->ordered()->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');
        return view('admin.roles.form', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'slug'          => 'required|string|max:60|unique:roles,slug',
            'description'   => 'nullable|string',
            'level'         => 'required|integer|min:1|max:10',
            'is_active'     => 'boolean',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name'        => $data['name'],
            'slug'        => $data['slug'],
            'description' => $data['description'] ?? null,
            'level'       => $data['level'],
            'is_active'   => $request->boolean('is_active', true),
        ]);

        if (!empty($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        AuditLog::record('created_role', 'Role', $role->id);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions        = Permission::orderBy('group')->orderBy('name')->get()->groupBy('group');
        $rolePermissionIds  = $role->permissions()->pluck('permissions.id')->toArray();
        return view('admin.roles.form', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'description'   => 'nullable|string',
            'level'         => 'required|integer|min:1|max:10',
            'is_active'     => 'boolean',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'level'       => $data['level'],
            'is_active'   => $request->boolean('is_active'),
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        AuditLog::record('updated_role', 'Role', $role->id);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated.');
    }

    public function destroy(Role $role)
    {
        if ($role->admins()->count() > 0) {
            return back()->with('error', 'Cannot delete a role that has assigned users.');
        }

        AuditLog::record('deleted_role', 'Role', $role->id);
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted.');
    }
}
