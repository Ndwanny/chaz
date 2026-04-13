@extends('admin.layouts.app')
@section('title', 'Purchase Orders')
@section('breadcrumb', 'Procurement / Purchase Orders')

@section('content')
<div class="page-header">
    <div><div class="page-title">Purchase Orders</div><div class="page-subtitle">{{ $orders->total() }} orders</div></div>
    @if(admin_can('manage_procurement'))
    <a href="{{ route('admin.purchase-orders.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New PO</a>
    @endif
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                @foreach(['draft','pending_approval','approved','ordered','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control">
                <option value="">All Suppliers</option>
                @foreach($suppliers as $sup)
                <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="{{ route('admin.purchase-orders.index') }}" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>PO Number</th><th>Supplier</th><th>Department</th><th>Order Date</th><th>Expected Delivery</th><th>Grand Total</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($orders as $po)
            @php $c=['draft'=>'grey','pending_approval'=>'orange','approved'=>'blue','ordered'=>'purple','delivered'=>'green','cancelled'=>'red']; @endphp
            <tr>
                <td><code>{{ $po->po_number }}</code></td>
                <td>{{ $po->supplier->name ?? '—' }}</td>
                <td>{{ $po->department->name ?? '—' }}</td>
                <td>{{ $po->order_date?->format('d M Y') }}</td>
                <td>{{ $po->expected_delivery?->format('d M Y') ?? '—' }}</td>
                <td>{{ format_zmw((float)$po->grand_total) }}</td>
                <td><span class="badge badge-{{ $c[$po->status] ?? 'grey' }}">{{ ucfirst(str_replace('_',' ',$po->status)) }}</span></td>
                <td>
                    <a href="{{ route('admin.purchase-orders.show', $po) }}" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    @if($po->status === 'pending_approval' && admin_can('manage_procurement'))
                    <form method="POST" action="{{ route('admin.purchase-orders.approve', $po) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No purchase orders.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $orders->links() }}</div>
</div>
@endsection
