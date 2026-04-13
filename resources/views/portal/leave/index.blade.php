@extends('portal.layouts.app')
@section('page_title', 'My Leave')
@section('breadcrumb', 'Leave')

@section('content')

{{-- Balances --}}
<div class="p-grid-3" style="margin-bottom:1.75rem;">
    @foreach($balances as $bal)
    <div class="p-card" style="padding:1.1rem 1.25rem;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:.75rem;">
            <div style="font-weight:700;font-size:.9rem;">{{ $bal['type']->name }}</div>
            <span style="font-size:1.3rem;font-weight:800;color:{{ $bal['remaining'] === 0 ? '#EF4444' : 'var(--portal-green)' }};">{{ $bal['remaining'] }}<span style="font-size:.7rem;font-weight:400;color:var(--portal-muted);">/{{ $bal['allowed'] }}</span></span>
        </div>
        <div class="p-progress">
            <div class="p-progress__bar" style="width:{{ $bal['allowed'] > 0 ? min(100, ($bal['used']/$bal['allowed'])*100) : 0 }}%;background:{{ $bal['remaining'] === 0 ? '#EF4444' : 'var(--portal-green)' }};"></div>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:.72rem;color:var(--portal-muted);margin-top:.35rem;">
            <span>{{ $bal['used'] }} used</span>
            <span>{{ $bal['remaining'] }} remaining</span>
        </div>
    </div>
    @endforeach
    @if($balances->isEmpty())
    <div class="p-card" style="grid-column:1/-1;text-align:center;color:var(--portal-muted);padding:1.5rem;">No leave types configured.</div>
    @endif
</div>

<div class="p-card">
    <div class="p-card__header">
        <span class="p-card__title">Leave Requests — {{ now()->year }}</span>
        <a href="{{ route('portal.leave.create') }}" class="p-btn primary sm"><i class="fas fa-plus"></i> Apply for Leave</a>
    </div>

    @if(session('success'))
    <div class="p-alert success" style="margin-bottom:1rem;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="p-alert error" style="margin-bottom:1rem;">{{ session('error') }}</div>
    @endif

    <div class="p-table-wrap"><table class="p-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Applied</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($leaveRequests as $req)
        @php $lc=['pending'=>'orange','approved'=>'green','rejected'=>'red','cancelled'=>'grey']; @endphp
        <tr>
            <td style="font-weight:600;">{{ $req->leaveType->name ?? '—' }}</td>
            <td>{{ $req->start_date?->format('d M Y') ?? '—' }}</td>
            <td>{{ $req->end_date?->format('d M Y') ?? '—' }}</td>
            <td style="text-align:center;font-weight:700;">{{ $req->days_requested }}</td>
            <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $req->reason ?? '—' }}</td>
            <td><span class="p-badge {{ $lc[$req->status] ?? 'grey' }}">{{ ucfirst($req->status) }}</span></td>
            <td style="color:var(--portal-muted);font-size:.8rem;">{{ $req->created_at?->format('d M Y') ?? '—' }}</td>
            <td>
                @if($req->status === 'pending')
                <form method="POST" action="{{ route('portal.leave.cancel', $req) }}" onsubmit="return confirm('Cancel this leave request?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="p-btn outline sm" style="color:#DC2626;border-color:#DC2626;">Cancel</button>
                </form>
                @elseif($req->status === 'approved' && $req->start_date > now())
                <span style="font-size:.75rem;color:var(--portal-green);">Approved</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:var(--portal-muted);padding:2rem;">No leave requests yet. <a href="{{ route('portal.leave.create') }}" style="color:var(--portal-green);">Apply now</a>.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    <div style="padding:1rem 0;">{{ $leaveRequests->links() }}</div>
</div>

@endsection
