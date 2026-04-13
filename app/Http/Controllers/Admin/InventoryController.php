<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Item, ItemCategory, Warehouse, StockEntry, AuditLog};
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category')->active();

        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        if ($request->filled('low_stock'))   $query->whereColumn('current_stock', '<=', 'reorder_level');
        if ($request->filled('search'))      $query->where(fn($q) => $q->where('name', 'like', '%'.$request->search.'%')->orWhere('code', 'like', '%'.$request->search.'%'));

        $items      = $query->paginate(20)->withQueryString();
        $categories = ItemCategory::active()->roots()->get();

        $stats = [
            'total'     => Item::active()->count(),
            'low_stock' => Item::active()->whereColumn('current_stock', '<=', 'reorder_level')->count(),
            'out'       => Item::active()->where('current_stock', '<=', 0)->count(),
        ];

        return view('admin.inventory.index', compact('items', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = ItemCategory::active()->orderBy('name')->get();
        return view('admin.inventory.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'code'           => 'required|string|max:30|unique:items,code',
            'category_id'    => 'required|exists:item_categories,id',
            'unit_of_measure'=> 'required|string|max:30',
            'unit_cost'      => 'nullable|numeric|min:0',
            'reorder_level'  => 'required|integer|min:0',
            'current_stock'  => 'nullable|numeric|min:0',
            'description'    => 'nullable|string',
            'specifications' => 'nullable|string',
        ]);

        $data['is_active']     = true;
        $data['current_stock'] = $data['current_stock'] ?? 0;

        $item = Item::create($data);
        AuditLog::record('created_item', 'Item', $item->id);

        return redirect()->route('admin.inventory.index')->with('success', 'Item created: ' . $item->name);
    }

    public function edit(Item $item)
    {
        $categories = ItemCategory::active()->orderBy('name')->get();
        return view('admin.inventory.form', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'code'           => 'required|string|max:30|unique:items,code,'.$item->id,
            'category_id'    => 'required|exists:item_categories,id',
            'unit_of_measure'=> 'required|string|max:30',
            'unit_cost'      => 'nullable|numeric|min:0',
            'reorder_level'  => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'specifications' => 'nullable|string',
            'is_active'      => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $item->update($data);
        AuditLog::record('updated_item', 'Item', $item->id);

        return redirect()->route('admin.inventory.index')->with('success', 'Item updated.');
    }

    public function stockMovement(Request $request)
    {
        $query = StockEntry::with(['item', 'warehouse', 'createdBy'])->latest();

        if ($request->filled('item_id'))  $query->where('item_id', $request->item_id);
        if ($request->filled('type'))     $query->where('transaction_type', $request->type);

        $entries    = $query->paginate(25)->withQueryString();
        $items      = Item::active()->orderBy('name')->get();
        $warehouses = Warehouse::where('is_active', true)->get();

        return view('admin.inventory.stock', compact('entries', 'items', 'warehouses'));
    }

    public function recordStock(Request $request)
    {
        $data = $request->validate([
            'item_id'          => 'required|exists:items,id',
            'warehouse_id'     => 'nullable|exists:warehouses,id',
            'transaction_type' => 'required|in:in,out,adjustment',
            'quantity'         => 'required|numeric|min:0.01',
            'unit_cost'        => 'nullable|numeric|min:0',
            'notes'            => 'nullable|string|max:300',
        ]);

        $item = Item::findOrFail($data['item_id']);

        // Update current_stock on the item
        if ($data['transaction_type'] === 'in') {
            $newStock = (float)$item->current_stock + (float)$data['quantity'];
        } elseif ($data['transaction_type'] === 'out') {
            $newStock = max(0, (float)$item->current_stock - (float)$data['quantity']);
        } else {
            // adjustment: quantity IS the new stock level
            $newStock = (float)$data['quantity'];
        }

        $data['total_cost']    = ($data['unit_cost'] ?? 0) * $data['quantity'];
        $data['balance_after'] = $newStock;
        $data['created_by']    = session('admin_id');

        StockEntry::create($data);
        $item->update(['current_stock' => $newStock]);

        AuditLog::record('stock_entry', 'Item', $item->id);

        return back()->with('success', 'Stock movement recorded. New balance: ' . number_format($newStock, 2) . ' ' . $item->unit_of_measure);
    }
}
