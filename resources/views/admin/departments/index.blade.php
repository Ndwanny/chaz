@extends('admin.layouts.app')
@section('title', 'Departments')
@section('page-title', 'Departments')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Departments</div>
        <div class="page-subtitle">Organisational structure and units</div>
    </div>
    @if(admin_can('manage_system'))
    <a href="{{ route('admin.departments.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Department</a>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Parent</th>
                    <th>Head</th>
                    <th>Province</th>
                    <th>Employees</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($departments as $dept)
            @php
                $typeColors = [
                    'executive'   => 'badge-gold',
                    'operational' => 'badge-blue',
                    'support'     => 'badge-grey',
                    'provincial'  => 'badge-green',
                ];
            @endphp
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $dept->name }}</div>
                    @if($dept->description)
                    <div style="font-size:.72rem;color:var(--slate-mid);margin-top:1px;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $dept->description }}</div>
                    @endif
                </td>
                <td><code>{{ $dept->code }}</code></td>
                <td>
                    <span class="badge {{ $typeColors[$dept->type] ?? 'badge-grey' }}">{{ $dept->type_label }}</span>
                </td>
                <td style="font-size:.85rem;">{{ $dept->parent->name ?? '—' }}</td>
                <td style="font-size:.85rem;">{{ $dept->head->name ?? '—' }}</td>
                <td style="font-size:.85rem;">{{ $dept->province ?? '—' }}</td>
                <td>
                    <span class="badge {{ $dept->employees_count > 0 ? 'badge-green' : 'badge-grey' }}">
                        {{ $dept->employees_count }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $dept->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ $dept->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    @if(admin_can('manage_system'))
                    <div style="display:flex;gap:.4rem;">
                        <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                        @if($dept->employees_count === 0)
                        <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" onsubmit="return confirm('Delete {{ addslashes($dept->name) }}?')">
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
                <td colspan="9" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-sitemap" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No departments found.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $departments->links() }}</div>
</div>
@endsection
