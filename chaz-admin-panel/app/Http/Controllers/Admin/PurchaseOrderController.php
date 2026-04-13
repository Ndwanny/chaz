<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{PurchaseOrder, PurchaseOrderItem, Supplier, Department, Item, Requisition, AuditLog};
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'department', 'requestedBy'])->latest();

        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('supplier_id')) $query->where('supplier_id', $request->supplier_id);

        $orders    = $query->paginate(20)->withQueryString();
        $suppliers = Supplier::active()->orderBy('name')->get();

        return view('admin.purchase-orders.index', compact('orders', 'suppliers'));
    }

    public function create()
    {
        $suppliers    = Supplier::active()->orderBy('name')->get();
        $departments  = Department::active()->orderBy('name')->get();
        $items        = Item::active()->orderBy('name')->get();
        $requisitions = Requisition::approved()->whereNull('id')->orWhereDoesntHave('purchaseOrder')->get();

        return view('admin.purchase-orders.form', compact('suppliers', 'departments', 'items', 'requisitions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id'       => 'required|exists:suppliers,id',
            'department_id'     => 'required|exists:departments,id',
            'requisition_id'    => 'nullable|exists:requisitions,id',
            'order_date'        => 'required|date',
            'expected_delivery' => 'nullable|date|after_or_equal:order_date',
            'delivery_address'  => 'nullable|string',
            'payment_terms'     => 'nullable|integer|min:0',
            'notes'             => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.item_id'   => 'required|exists:items,id',
            'items.*.quantity'  => 'required|numeric|min:0.01',
            'items.*.unit_price'=> 'required|numeric|min:0',
        ]);

        $po = PurchaseOrder::create([
            'po_number'         => PurchaseOrder::generatePoNumber(),
            'supplier_id'       => $data['supplier_id'],
            'department_id'     => $data['department_id'],
            'requisition_id'    => $data['requisition_id'] ?? null,
            'requested_by'      => session('admin_id'),
            'status'            => 'pending_approval',
            'order_date'        => $data['order_date'],
            'expected_delivery' => $data['expected_delivery'] ?? null,
            'delivery_address'  => $data['delivery_address'] ?? null,
            'payment_terms'     => $data['payment_terms'] ?? null,
            'notes'             => $data['notes'] ?? null,
            'currency'          => 'ZMW',
            'exchange_rate'     => 1,
        ]);

        $total = 0;
        foreach ($data['items'] as $lineItem) {
            $item     = Item::find($lineItem['item_id']);
            $lineTotal = $lineItem['quantity'] * $lineItem['unit_price'];
            $po->items()->create([
                'item_id'    => $lineItem['item_id'],
                'description' => $item->name,
                'quantity'   => $lineItem['quantity'],
                'unit'       => $item->unit,
                'unit_price' => $lineItem['unit_price'],
                'total_price' => $lineTotal,
            ]);
            $total += $lineTotal;
        }

        $po->update(['total_amount' => $total, 'grand_total' => $total]);

        AuditLog::record('created_purchase_order', 'PurchaseOrder', $po->id);

        return redirect()->route('admin.purchase-orders.show', $po)->with('success', 'Purchase order ' . $po->po_number . ' created.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'department', 'requestedBy', 'approvedBy', 'items.item', 'requisition']);
        return view('admin.purchase-orders.show', compact('purchaseOrder'));
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);
        AuditLog::record('approved_purchase_order', 'PurchaseOrder', $purchaseOrder->id);
        return back()->with('success', 'Purchase order approved.');
    }

    public function markDelivered(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update(['status' => 'delivered', 'delivery_date' => today()]);
        AuditLog::record('po_delivered', 'PurchaseOrder', $purchaseOrder->id);
        return back()->with('success', 'Purchase order marked as delivered.');
    }
}
