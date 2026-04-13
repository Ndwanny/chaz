<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Supplier, AuditLog};
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();
        if ($request->filled('search')) $query->where('name', 'like', '%'.$request->search.'%');
        if ($request->filled('status')) $query->where('is_active', $request->status === 'active');

        $suppliers = $query->orderBy('name')->paginate(20)->withQueryString();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'code'           => 'required|string|max:20|unique:suppliers,code',
            'contact_person' => 'nullable|string|max:100',
            'email'          => 'nullable|email|max:100',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string',
            'city'           => 'nullable|string|max:80',
            'country'        => 'nullable|string|max:80',
            'tax_number'     => 'nullable|string|max:30',
            'bank_name'      => 'nullable|string|max:100',
            'bank_account'   => 'nullable|string|max:30',
            'payment_terms'  => 'nullable|integer|min:0',
            'category'       => 'nullable|string|max:60',
        ]);

        $data['is_active'] = true;
        $supplier = Supplier::create($data);
        AuditLog::record('created_supplier', 'Supplier', $supplier->id);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.form', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'contact_person' => 'nullable|string|max:100',
            'email'          => 'nullable|email|max:100',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string',
            'city'           => 'nullable|string|max:80',
            'country'        => 'nullable|string|max:80',
            'tax_number'     => 'nullable|string|max:30',
            'bank_name'      => 'nullable|string|max:100',
            'bank_account'   => 'nullable|string|max:30',
            'payment_terms'  => 'nullable|integer|min:0',
            'category'       => 'nullable|string|max:60',
            'rating'         => 'nullable|numeric|min:0|max:5',
            'is_active'      => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $supplier->update($data);
        AuditLog::record('updated_supplier', 'Supplier', $supplier->id);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->purchaseOrders()->count() > 0) {
            return back()->with('error', 'Cannot delete supplier with existing purchase orders.');
        }
        AuditLog::record('deleted_supplier', 'Supplier', $supplier->id);
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted.');
    }
}
