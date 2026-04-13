<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\{Employee, LeaveRequest, LeaveType};
use Illuminate\Http\Request;

class PortalLeaveController extends Controller
{
    public function index()
    {
        $employee = Employee::find(session('portal_employee_id'));

        $requests = LeaveRequest::where('employee_id', $employee->id)
            ->with('leaveType')->latest()->paginate(15);

        $leaveTypes = LeaveType::where('is_active', true)->get();

        $balances = $leaveTypes->map(function($type) use ($employee) {
            $used = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $type->id)
                ->where('status', 'approved')
                ->whereYear('start_date', now()->year)
                ->sum('days_requested');
            return [
                'type'      => $type,
                'allowed'   => $type->days_allowed,
                'used'      => (int) $used,
                'remaining' => max(0, $type->days_allowed - $used),
            ];
        })->filter(fn($b) => $b['allowed'] > 0);

        $leaveRequests = $requests;
        return view('portal.leave.index', compact('leaveRequests', 'balances', 'leaveTypes'));
    }

    public function create()
    {
        $employee   = Employee::find(session('portal_employee_id'));
        $leaveTypes = LeaveType::where('is_active', true)->get();

        $balances = $leaveTypes->map(function($type) use ($employee) {
            $used = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $type->id)
                ->where('status', 'approved')
                ->whereYear('start_date', now()->year)
                ->sum('days_requested');
            return [
                'type'      => $type,
                'allowed'   => $type->days_allowed,
                'used'      => (int) $used,
                'remaining' => max(0, $type->days_allowed - $used),
            ];
        })->filter(fn($b) => $b['allowed'] > 0);

        return view('portal.leave.create', compact('leaveTypes', 'balances'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'leave_type_id'      => 'required|exists:leave_types,id',
            'start_date'         => 'required|date|after_or_equal:tomorrow',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'reason'              => 'nullable|string|max:500',
            'supporting_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Calculate working days
        $start = \Carbon\Carbon::parse($data['start_date']);
        $end   = \Carbon\Carbon::parse($data['end_date']);
        $days  = 0;
        $current = $start->copy();
        while ($current->lte($end)) {
            if (!$current->isWeekend()) $days++;
            $current->addDay();
        }

        $data['employee_id']    = session('portal_employee_id');
        $data['days_requested'] = $days;
        $data['status']         = 'pending';

        if ($request->hasFile('supporting_document')) {
            $data['supporting_document'] = $request->file('supporting_document')->store('leave/documents', 'public');
        }

        LeaveRequest::create($data);

        return redirect()->route('portal.leave.index')->with('success', 'Leave request submitted successfully. HR will review it shortly.');
    }

    public function cancel(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->employee_id !== session('portal_employee_id')) abort(403);
        if ($leaveRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be cancelled.');
        }
        $leaveRequest->update(['status' => 'cancelled']);
        return back()->with('success', 'Leave request cancelled.');
    }
}
