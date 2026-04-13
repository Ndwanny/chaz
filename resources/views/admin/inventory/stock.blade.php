@extends('admin.layouts.app')
@section('title', 'Stock Movement')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Stock Movement</div>
        <div class="page-subtitle">Record stock in, out, and adjustments</div>
    </div>
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Inventory</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start;">

    {{-- Record form --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Record Movement</span></div>
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom:1rem;">
                <ul style="margin:0;padding-left:1.2rem;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('admin.inventory.stock.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Item <span class="text-danger">*</span></label>
                    <select name="item_id" class="form-control" required>
                        <option value="">— Select Item —</option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} ({{ number_format($item->current_stock,2) }} {{ $item->unit_of_measure }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Transaction Type <span class="text-danger">*</span></label>
                    <select name="transaction_type" class="form-control" required>
                        <option value="">— Select Type —</option>
                        <option value="in"         {{ old('transaction_type') === 'in'         ? 'selected' : '' }}>Stock In (Receive)</option>
                        <option value="out"        {{ old('transaction_type') === 'out'        ? 'selected' : '' }}>Stock Out (Issue)</option>
                        <option value="adjustment" {{ old('transaction_type') === 'adjustment' ? 'selected' : '' }}>Adjustment (Set level)</option>
                    </select>
                    <small class="text-muted">Adjustment sets the stock to the quantity entered</small>
                </div>
                <div class="form-group">
                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" step="0.01" min="0.01" value="{{ old('quantity') }}" required>
                </div>
                @if($warehouses->count())
                <div class="form-group">
                    <label class="form-label">Warehouse / Store</label>
                    <select name="warehouse_id" class="form-control">
                        <option value="">— Default Store —</option>
                        @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}" {{ old('warehouse_id') == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label class="form-label">Unit Cost (ZMW)</label>
                    <input type="number" name="unit_cost" class="form-control" step="0.01" min="0" value="{{ old('unit_cost') }}" placeholder="Optional">
                </div>
                <div class="form-group">
                    <label class="form-label">Notes / Reference</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="PO number, reason, etc.">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">
                    <i class="fas fa-boxes-stacked"></i> Record Movement
                </button>
            </form>
        </div>
    </div>

    {{-- History --}}
    <div class="card">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <span class="card-title">Transaction History</span>
            <form method="GET" style="display:flex;gap:.5rem;">
                <select name="item_id" class="form-control form-control-sm" style="min-width:160px;" onchange="this.form.submit()">
                    <option value="">All Items</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
                <select name="type" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="in"         {{ request('type') === 'in'         ? 'selected' : '' }}>In</option>
                    <option value="out"        {{ request('type') === 'out'        ? 'selected' : '' }}>Out</option>
                    <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                </select>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Balance</th>
                        <th>Notes</th>
                        <th>By</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($entries as $entry)
                @php
                    $typeColor = ['in' => 'badge-success', 'out' => 'badge-danger', 'adjustment' => 'badge-info'];
                    $typeLabel = ['in' => 'In', 'out' => 'Out', 'adjustment' => 'Adj'];
                @endphp
                <tr>
                    <td style="white-space:nowrap;font-size:.8rem;">{{ $entry->created_at->format('d M Y H:i') }}</td>
                    <td style="font-weight:600;font-size:.85rem;">{{ $entry->item->name ?? '—' }}</td>
                    <td><span class="badge {{ $typeColor[$entry->transaction_type] ?? 'badge-secondary' }}">{{ $typeLabel[$entry->transaction_type] ?? $entry->transaction_type }}</span></td>
                    <td style="font-weight:700;">
                        <span style="color:{{ $entry->transaction_type === 'out' ? '#DC2626' : '#16A34A' }};">
                            {{ $entry->transaction_type === 'out' ? '-' : '+' }}{{ number_format($entry->quantity, 2) }}
                        </span>
                    </td>
                    <td style="color:#6B7280;font-size:.82rem;">{{ $entry->balance_after !== null ? number_format($entry->balance_after, 2) : '—' }}</td>
                    <td style="font-size:.8rem;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $entry->notes }}">{{ $entry->notes ?? '—' }}</td>
                    <td style="font-size:.8rem;">{{ $entry->createdBy->name ?? 'System' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:1.5rem;color:#6B7280;">No transactions recorded.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">{{ $entries->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
