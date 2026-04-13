<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{LeaveRequest, LeaveType, Employee, AuditLog};
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['employee.department', 'leaveType'])->latest();

        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('employee_id')) $query->where('employee_id', $request->employee_id);

        $requests  = $query->paginate(20)->withQueryString();
        $leaveTypes = LeaveType::active()->get();

        return view('admin.leave.index', compact('requests', 'leaveTypes'));
    }

    public function create()
    {
        $employees  = Employee::active()->orderBy('first_name')->get();
        $leaveTypes = LeaveType::active()->get();
        return view('admin.leave.form', compact('employees', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'reason'        => 'nullable|string|max:500',
        ]);

        $data['days_requested'] = \Carbon\Carbon::parse($data['start_date'])->diffInWeekdays(\Carbon\Carbon::parse($data['end_date'])) + 1;
        $data['status']         = 'pending';

        $leave = LeaveRequest::create($data);
        AuditLog::record('created_leave_request', 'LeaveRequest', $leave->id);

        return redirect()->route('admin.leave.index')->with('success', 'Leave request submitted.');
    }

    public function approve(LeaveRequest $leave)
    {
        $leave->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);
        AuditLog::record('approved_leave', 'LeaveRequest', $leave->id);
        return back()->with('success', 'Leave approved.');
    }

    public function reject(Request $request, LeaveRequest $leave)
    {
        $request->validate(['rejection_reason' => 'required|string|max:300']);
        $leave->update(['status' => 'rejected', 'approved_by' => session('admin_id'), 'approved_at' => now(), 'rejection_reason' => $request->rejection_reason]);
        AuditLog::record('rejected_leave', 'LeaveRequest', $leave->id);
        return back()->with('success', 'Leave rejected.');
    }

    // Leave Types management
    public function types()
    {
        $types = LeaveType::withCount('leaveRequests')->get();
        return view('admin.leave.types', compact('types'));
    }

    public function storeType(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:80',
            'code'              => 'required|string|max:10|unique:leave_types,code',
            'days_allowed'      => 'required|integer|min:1',
            'is_paid'           => 'boolean',
            'requires_document' => 'boolean',
            'applicable_gender' => 'nullable|in:all,male,female',
            'description'       => 'nullable|string',
            'is_active'         => 'boolean',
        ]);

        $data['is_paid']           = $request->boolean('is_paid', true);
        $data['requires_document'] = $request->boolean('requires_document', false);
        $data['is_active']         = $request->boolean('is_active', true);

        LeaveType::create($data);

        return redirect()->route('admin.leave.types')->with('success', 'Leave type created.');
    }
}
