<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Requisition, RequisitionItem, Department, Item, AuditLog};
use Illuminate\Http\Request;

class RequisitionController extends Controller
{
    public function index(Request $request)
    {
        $query = Requisition::with(['department', 'requestedBy'])->latest();

        if ($request->filled('status'))        $query->where('status', $request->status);
        if ($request->filled('department_id')) $query->where('department_id', $request->department_id);

        // Scope non-super admins to their own department
        if (!admin_can('manage_procurement') && admin_department_id()) {
            $query->where('department_id', admin_department_id());
        }

        $requisitions = $query->paginate(20)->withQueryString();
        $departments  = Department::active()->orderBy('name')->get();

        return view('admin.requisitions.index', compact('requisitions', 'departments'));
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        $items       = Item::active()->orderBy('name')->get();
        return view('admin.requisitions.form', compact('departments', 'items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id'             => 'required|exists:departments,id',
            'priority'                  => 'required|in:low,normal,high,urgent',
            'required_by'               => 'required|date|after:today',
            'purpose'                   => 'required|string|max:500',
            'notes'                     => 'nullable|string',
            'items'                     => 'required|array|min:1',
            'items.*.item_id'           => 'nullable|exists:items,id',
            'items.*.description'       => 'required|string|max:200',
            'items.*.quantity'          => 'required|numeric|min:0.01',
            'items.*.unit'              => 'required|string|max:20',
            'items.*.estimated_unit_price' => 'nullable|numeric|min:0',
        ]);

        $req = Requisition::create([
            'req_number'    => Requisition::generateReqNumber(),
            'department_id' => $data['department_id'],
            'requested_by'  => session('admin_id'),
            'status'        => 'pending',
            'priority'      => $data['priority'],
            'required_by'   => $data['required_by'],
            'purpose'       => $data['purpose'],
            'notes'         => $data['notes'] ?? null,
        ]);

        foreach ($data['items'] as $lineItem) {
            $qty   = $lineItem['quantity'];
            $price = $lineItem['estimated_unit_price'] ?? 0;
            $req->items()->create([
                'item_id'               => $lineItem['item_id'] ?? null,
                'description'           => $lineItem['description'],
                'quantity'              => $qty,
                'unit'                  => $lineItem['unit'],
                'estimated_unit_price'  => $price,
                'estimated_total'       => $qty * $price,
            ]);
        }

        AuditLog::record('created_requisition', 'Requisition', $req->id);

        return redirect()->route('admin.requisitions.index')->with('success', 'Requisition ' . $req->req_number . ' submitted.');
    }

    public function show(Requisition $requisition)
    {
        $requisition->load(['department', 'requestedBy', 'approvedBy', 'items.item', 'purchaseOrder']);
        return view('admin.requisitions.show', compact('requisition'));
    }

    public function approve(Requisition $requisition)
    {
        $requisition->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);
        AuditLog::record('approved_requisition', 'Requisition', $requisition->id);
        return back()->with('success', 'Requisition approved.');
    }

    public function reject(Request $request, Requisition $requisition)
    {
        $request->validate(['rejected_reason' => 'required|string|max:300']);
        $requisition->update(['status' => 'rejected', 'approved_by' => session('admin_id'), 'approved_at' => now(), 'rejected_reason' => $request->rejected_reason]);
        AuditLog::record('rejected_requisition', 'Requisition', $requisition->id);
        return back()->with('success', 'Requisition rejected.');
    }
}
