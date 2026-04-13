@extends('admin.layouts.app')
@section('title', 'Audit Log')
@section('page-title', 'Reports')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Audit Log</div>
        <div class="page-subtitle">System activity trail</div>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Reports</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>When</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Record</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
            @forelse($logs as $log)
            <tr>
                <td style="font-size:.8rem;white-space:nowrap;color:var(--slate-mid);">
                    {{ $log->created_at?->format('d M Y H:i') }}
                </td>
                <td style="font-size:.875rem;">{{ $log->admin->name ?? '—' }}</td>
                <td>
                    <code style="font-size:.78rem;background:var(--bg-alt);padding:2px 6px;border-radius:4px;">
                        {{ str_replace('_', ' ', $log->action) }}
                    </code>
                </td>
                <td style="font-size:.82rem;color:var(--slate-mid);">
                    @if($log->model_type)
                    {{ class_basename($log->model_type) }}
                    @if($log->model_id) <span style="opacity:.6;">#{{ $log->model_id }}</span> @endif
                    @else
                    —
                    @endif
                </td>
                <td style="font-size:.78rem;color:var(--slate-mid);">{{ $log->ip_address ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-scroll" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No audit log entries.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $logs->links() }}</div>
</div>
@endsection
