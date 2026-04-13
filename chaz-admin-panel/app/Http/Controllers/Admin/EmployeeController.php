<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Department, SalaryGrade, Admin, AuditLog};
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'salaryGrade'])->orderBy('first_name');

        if ($request->filled('department_id')) $query->where('department_id', $request->department_id);
        if ($request->filled('status'))        $query->where('employment_status', $request->status);
        if ($request->filled('search'))        $query->where(fn($q) => $q->where('first_name', 'like', '%'.$request->search.'%')->orWhere('last_name', 'like', '%'.$request->search.'%')->orWhere('staff_number', 'like', '%'.$request->search.'%'));

        $employees   = $query->paginate(20)->withQueryString();
        $departments = Department::active()->orderBy('name')->get();

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments  = Department::active()->orderBy('name')->get();
        $salaryGrades = SalaryGrade::active()->orderBy('code')->get();
        $managers     = Admin::active()->orderBy('name')->get();
        return view('admin.employees.form', compact('departments', 'salaryGrades', 'managers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'        => 'required|string|max:60',
            'last_name'         => 'required|string|max:60',
            'other_names'       => 'nullable|string|max:60',
            'gender'            => 'required|in:male,female',
            'date_of_birth'     => 'required|date|before:today',
            'national_id'       => 'nullable|string|max:20',
            'email'             => 'nullable|email|unique:employees,email',
            'phone'             => 'nullable|string|max:20',
            'department_id'     => 'required|exists:departments,id',
            'job_title'         => 'required|string|max:100',
            'employment_type'   => 'required|in:permanent,contract,casual,intern',
            'employment_status' => 'required|in:active,on_leave,suspended,terminated,resigned',
            'hire_date'         => 'required|date',
            'salary_grade_id'   => 'nullable|exists:salary_grades,id',
            'basic_salary'      => 'nullable|numeric|min:0',
        ]);

        $data['staff_number'] = Employee::generateStaffNumber();
        $employee = Employee::create($data);

        if ($request->filled('basic_salary') && $request->filled('salary_grade_id')) {
            $employee->employeeSalaries()->create([
                'salary_grade_id' => $data['salary_grade_id'],
                'basic_salary'    => $data['basic_salary'],
                'effective_date'  => $data['hire_date'],
                'is_current'      => true,
                'approved_by'     => session('admin_id'),
            ]);
        }

        AuditLog::record('created_employee', 'Employee', $employee->id);

        return redirect()->route('admin.employees.show', $employee)->with('success', 'Employee created. Staff number: ' . $employee->staff_number);
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'salaryGrade', 'currentSalary', 'leaveRequests.leaveType', 'performanceReviews.reviewer', 'payslips.payrollRun.payrollPeriod']);
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments  = Department::active()->orderBy('name')->get();
        $salaryGrades = SalaryGrade::active()->orderBy('code')->get();
        return view('admin.employees.form', compact('employee', 'departments', 'salaryGrades'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name'        => 'required|string|max:60',
            'last_name'         => 'required|string|max:60',
            'other_names'       => 'nullable|string|max:60',
            'gender'            => 'required|in:male,female',
            'date_of_birth'     => 'required|date|before:today',
            'national_id'       => 'nullable|string|max:20',
            'email'             => 'nullable|email|unique:employees,email,' . $employee->id,
            'phone'             => 'nullable|string|max:20',
            'department_id'     => 'required|exists:departments,id',
            'job_title'         => 'required|string|max:100',
            'employment_type'   => 'required|in:permanent,contract,casual,intern',
            'employment_status' => 'required|in:active,on_leave,suspended,terminated,resigned',
            'hire_date'         => 'required|date',
            'salary_grade_id'   => 'nullable|exists:salary_grades,id',
        ]);

        $old = $employee->toArray();
        $employee->update($data);

        AuditLog::record('updated_employee', 'Employee', $employee->id, $old, $employee->fresh()->toArray());

        return redirect()->route('admin.employees.show', $employee)->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        AuditLog::record('deleted_employee', 'Employee', $employee->id, $employee->toArray(), []);
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee record removed.');
    }
}
