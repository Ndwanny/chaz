@extends('admin.layouts.app')
@section('title', 'Inventory')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Inventory</div>
        <div class="page-subtitle">Item catalogue and stock levels</div>
    </div>
    <div style="display:flex;gap:.5rem;">
        @if(admin_can('manage_inventory') || admin_can('manage_procurement'))
        <a href="{{ route('admin.inventory.stock') }}" class="btn btn-outline"><i class="fas fa-boxes-stacked"></i> Stock Movement</a>
        <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Item</a>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;"><i class="fas fa-box"></i></div>
        <div><div class="stat-value">{{ $stats['total'] }}</div><div class="stat-label">Total Items</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF3C7;color:#D97706;"><i class="fas fa-triangle-exclamation"></i></div>
        <div><div class="stat-value">{{ $stats['low_stock'] }}</div><div class="stat-label">Low Stock</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEE2E2;color:#DC2626;"><i class="fas fa-circle-xmark"></i></div>
        <div><div class="stat-value">{{ $stats['out'] }}</div><div class="stat-label">Out of Stock</div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title" style="margin:0;">Items</h3>
    </div>
    {{-- Filters --}}
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.25rem;">Search</label>
                <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Name or code" style="min-width:200px;">
            </div>
            <div>
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.25rem;">Category</label>
                <select name="category_id" class="form-control form-control-sm" style="min-width:160px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;align-items:flex-end;gap:.5rem;">
                <label style="display:flex;align-items:center;gap:.4rem;font-size:.85rem;cursor:pointer;padding-bottom:.35rem;">
                    <input type="checkbox" name="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}> Low stock only
                </label>
            </div>
            <div style="display:flex;gap:.5rem;padding-bottom:.05rem;">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive" style="margin-top:1rem;">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Unit Cost (ZMW)</th>
                    <th>In Stock</th>
                    <th>Reorder At</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            @php $low = $item->isLowStock(); @endphp
            <tr class="{{ $low ? 'table-warning' : '' }}">
                <td><code>{{ $item->code }}</code></td>
                <td>
                    <div style="font-weight:600;">{{ $item->name }}</div>
                    @if($item->description)
                    <div style="font-size:.75rem;color:#6B7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ $item->description }}</div>
                    @endif
                </td>
                <td>{{ $item->category->name ?? '—' }}</td>
                <td>{{ $item->unit_of_measure }}</td>
                <td>{{ $item->unit_cost ? number_format($item->unit_cost, 2) : '—' }}</td>
                <td>
                    <span style="font-weight:700;color:{{ (float)$item->current_stock <= 0 ? '#DC2626' : ($low ? '#D97706' : '#16A34A') }};">
                        {{ number_format($item->current_stock, 2) }}
                    </span>
                    @if($low)
                    <span class="badge badge-warning" style="margin-left:.3rem;font-size:.68rem;">Low</span>
                    @endif
                </td>
                <td>{{ $item->reorder_level }}</td>
                <td>
                    @if($item->is_active)
                    <span class="badge badge-success">Active</span>
                    @else
                    <span class="badge badge-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    @if(admin_can('manage_inventory') || admin_can('manage_procurement'))
                    <a href="{{ route('admin.inventory.edit', $item) }}" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:2rem;color:#6B7280;">
                    <i class="fas fa-box-open" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:.5rem;"></i>
                    No items found.
                    @if(admin_can('manage_inventory') || admin_can('manage_procurement'))
                    <a href="{{ route('admin.inventory.create') }}" style="color:var(--primary);">Add the first item</a>.
                    @endif
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $items->links() }}</div>
</div>
@endsection
