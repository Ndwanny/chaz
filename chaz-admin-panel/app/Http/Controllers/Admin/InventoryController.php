<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Item, ItemCategory, Supplier, Warehouse, StockEntry, AuditLog};
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'supplier'])->active();

        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        if ($request->filled('search'))      $query->where(fn($q) => $q->where('name', 'like', '%'.$request->search.'%')->orWhere('code', 'like', '%'.$request->search.'%'));

        $items      = $query->paginate(20)->withQueryString();
        $categories = ItemCategory::active()->roots()->get();

        return view('admin.inventory.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = ItemCategory::active()->orderBy('name')->get();
        $suppliers  = Supplier::active()->orderBy('name')->get();
        return view('admin.inventory.form', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:150',
            'code'            => 'required|string|max:30|unique:items,code',
            'sku'             => 'nullable|string|max:50',
            'category_id'     => 'required|exists:item_categories,id',
            'supplier_id'     => 'nullable|exists:suppliers,id',
            'unit'            => 'required|string|max:20',
            'unit_price'      => 'required|numeric|min:0',
            'reorder_level'   => 'required|integer|min:0',
            'reorder_quantity' => 'required|integer|min:1',
            'description'     => 'nullable|string',
        ]);

        $data['is_active'] = true;
        $item = Item::create($data);
        AuditLog::record('created_item', 'Item', $item->id);

        return redirect()->route('admin.inventory.index')->with('success', 'Item created: ' . $item->name);
    }

    public function edit(Item $item)
    {
        $categories = ItemCategory::active()->orderBy('name')->get();
        $suppliers  = Supplier::active()->orderBy('name')->get();
        return view('admin.inventory.form', compact('item', 'categories', 'suppliers'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:150',
            'code'             => 'required|string|max:30|unique:items,code,' . $item->id,
            'sku'              => 'nullable|string|max:50',
            'category_id'      => 'required|exists:item_categories,id',
            'supplier_id'      => 'nullable|exists:suppliers,id',
            'unit'             => 'required|string|max:20',
            'unit_price'       => 'required|numeric|min:0',
            'reorder_level'    => 'required|integer|min:0',
            'reorder_quantity'  => 'required|integer|min:1',
            'description'      => 'nullable|string',
            'is_active'        => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $item->update($data);
        AuditLog::record('updated_item', 'Item', $item->id);

        return redirect()->route('admin.inventory.index')->with('success', 'Item updated.');
    }

    // Stock movement
    public function stockMovement(Request $request)
    {
        $entries = StockEntry::with(['item', 'warehouse'])->latest()->paginate(25);
        $items      = Item::active()->orderBy('name')->get();
        $warehouses = Warehouse::active()->get();
        return view('admin.inventory.stock', compact('entries', 'items', 'warehouses'));
    }

    public function recordStock(Request $request)
    {
        $data = $request->validate([
            'item_id'      => 'required|exists:items,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'entry_type'   => 'required|in:in,out,adjustment',
            'quantity'     => 'required|numeric|min:0.01',
            'unit_cost'    => 'nullable|numeric|min:0',
            'notes'        => 'nullable|string|max:300',
        ]);

        $data['total_cost'] = ($data['unit_cost'] ?? 0) * $data['quantity'];
        $data['created_by'] = session('admin_id');

        $entry = StockEntry::create($data);
        AuditLog::record('stock_entry', 'StockEntry', $entry->id);

        return back()->with('success', 'Stock movement recorded.');
    }
}
