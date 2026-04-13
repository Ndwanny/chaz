@extends('admin.layouts.app')
@section('title', 'Suppliers')
@section('page-title', 'Suppliers')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Suppliers</div>
        <div class="page-subtitle">Vendor and supplier directory</div>
    </div>
    @if(admin_can('manage_procurement'))
    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Supplier</a>
    @endif
</div>

@if(session('success'))
<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

{{-- Filters --}}
<div class="card" style="margin-bottom:1rem;">
    <div class="card-body" style="padding:.75rem 1rem;">
        <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;">
            <div class="form-group" style="margin:0;flex:1;min-width:200px;">
                <input type="text" name="search" class="form-control" placeholder="Search by name…" value="{{ request('search') }}">
            </div>
            <div class="form-group" style="margin:0;">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Code</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Payment Terms</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($suppliers as $supplier)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $supplier->name }}</div>
                    @if($supplier->registration_number)
                    <div style="font-size:.72rem;color:var(--slate-mid);">Reg: {{ $supplier->registration_number }}</div>
                    @endif
                </td>
                <td><code>{{ $supplier->code }}</code></td>
                <td>
                    @if($supplier->contact_person)
                    <div style="font-size:.85rem;">{{ $supplier->contact_person }}</div>
                    @endif
                    @if($supplier->email)
                    <div style="font-size:.75rem;color:var(--slate-mid);">{{ $supplier->email }}</div>
                    @endif
                    @if($supplier->phone)
                    <div style="font-size:.75rem;color:var(--slate-mid);">{{ $supplier->phone }}</div>
                    @endif
                </td>
                <td style="font-size:.85rem;">
                    {{ collect([$supplier->city, $supplier->country])->filter()->implode(', ') ?: '—' }}
                </td>
                <td style="font-size:.85rem;">
                    {{ $supplier->payment_terms ? $supplier->payment_terms . ' days' : '—' }}
                </td>
                <td>
                    @if($supplier->rating)
                    <span style="font-weight:600;color:var(--forest);">{{ number_format($supplier->rating, 1) }}</span>
                    <span style="font-size:.75rem;color:var(--slate-mid);"> / 5</span>
                    @else
                    <span style="color:var(--slate-mid);font-size:.82rem;">—</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $supplier->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    @if(admin_can('manage_procurement'))
                    <div style="display:flex;gap:.4rem;">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                        @if($supplier->purchaseOrders()->count() === 0)
                        <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" onsubmit="return confirm('Delete {{ addslashes($supplier->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-truck" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No suppliers found.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $suppliers->links() }}</div>
</div>
@endsection
