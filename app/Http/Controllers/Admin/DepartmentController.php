<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Department, Admin, AuditLog};
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['parent', 'head'])->withCount('employees')->orderBy('name')->paginate(20);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $parents = Department::whereNull('parent_id')->orderBy('name')->get();
        $heads   = Admin::active()->orderBy('name')->get();
        return view('admin.departments.form', compact('parents', 'heads'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|max:20|unique:departments,code',
            'type'        => 'required|in:executive,operational,support,provincial',
            'parent_id'   => 'nullable|exists:departments,id',
            'head_id'     => 'nullable|exists:admins,id',
            'province'    => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $dept = Department::create($data);

        AuditLog::record('created_department', 'Department', $dept->id);

        return redirect()->route('admin.departments.index')->with('success', 'Department created.');
    }

    public function edit(Department $department)
    {
        $parents = Department::whereNull('parent_id')->where('id', '!=', $department->id)->orderBy('name')->get();
        $heads   = Admin::active()->orderBy('name')->get();
        return view('admin.departments.form', compact('department', 'parents', 'heads'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|max:20|unique:departments,code,' . $department->id,
            'type'        => 'required|in:executive,operational,support,provincial',
            'parent_id'   => 'nullable|exists:departments,id',
            'head_id'     => 'nullable|exists:admins,id',
            'province'    => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $department->update($data);

        AuditLog::record('updated_department', 'Department', $department->id);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->count() > 0) {
            return back()->with('error', 'Cannot delete a department with active employees.');
        }

        AuditLog::record('deleted_department', 'Department', $department->id);
        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted.');
    }
}
