@extends('admin.layouts.app')
@section('title', 'Payroll')
@section('breadcrumb', 'Payroll / Periods')

@section('content')
<div class="page-header">
    <div><div class="page-title">Payroll Periods</div></div>
    @if(admin_can('manage_payroll'))
    <a href="{{ route('admin.payroll.periods.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Period</a>
    @endif
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Period</th><th>Dates</th><th>Runs</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($periods as $period)
            <tr>
                <td style="font-weight:600;">{{ $period->name }}</td>
                <td style="font-size:.82rem;color:var(--text-muted);">{{ $period->start_date?->format('d M') }} — {{ $period->end_date?->format('d M Y') }}</td>
                <td>{{ $period->payroll_runs_count }}</td>
                <td><span class="badge badge-{{ $period->isOpen() ? 'green' : 'grey' }}">{{ ucfirst($period->status) }}</span></td>
                <td>
                    @if(admin_can('manage_payroll'))
                    @if($period->isOpen())
                    <form method="POST" action="{{ route('admin.payroll.run.store', $period) }}" style="display:inline;" onsubmit="return confirm('Run payroll for {{ $period->name }}? This will generate payslips for all active employees.')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-play"></i> Run Payroll</button>
                    </form>
                    @endif
                    @endif
                    @if($period->payroll_runs_count > 0)
                    <a href="{{ route('admin.payroll.index') }}?period={{ $period->id }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i> View Runs</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">No payroll periods created yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $periods->links() }}</div>
</div>
@endsection
