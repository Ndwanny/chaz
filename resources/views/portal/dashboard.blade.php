@extends('portal.layouts.app')
@section('page_title', 'Dashboard')
@section('breadcrumb', 'Welcome back, ' . $employee->first_name)

@section('content')

{{-- Welcome banner --}}
<div style="background:linear-gradient(135deg,#1B4332,#2D6A4F);border-radius:14px;padding:1.75rem 2rem;margin-bottom:1.75rem;display:flex;justify-content:space-between;align-items:center;color:#fff;">
    <div>
        <div style="font-size:.8rem;color:rgba(255,255,255,.6);margin-bottom:.25rem;">{{ now()->format('l, d F Y') }}</div>
        <div style="font-size:1.5rem;font-weight:800;">Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ $employee->first_name }}!</div>
        <div style="font-size:.88rem;color:rgba(255,255,255,.7);margin-top:.4rem;">{{ $employee->designation ?? $employee->department->name ?? 'CHAZ Staff' }} &nbsp;·&nbsp; {{ $employee->staff_number }}</div>
    </div>
    <div style="text-align:right;">
        @if($pendingLeave > 0)
        <div style="background:rgba(201,168,76,.2);border:1px solid rgba(201,168,76,.4);border-radius:8px;padding:.5rem 1rem;font-size:.82rem;color:#C9A84C;">
            <i class="fas fa-clock"></i> {{ $pendingLeave }} pending leave {{ Str::plural('request', $pendingLeave) }}
        </div>
        @endif
    </div>
</div>

{{-- Quick stats --}}
<div class="p-stats">
    @php
        $latestPayslip = $recentPayslips->first();
        $totalLeaveUsed = $leaveBalances->sum('used');
        $totalLeaveAllowed = $leaveBalances->sum('allowed');
    @endphp
    <div class="p-stat">
        <div class="p-stat__icon green"><i class="fas fa-money-bill-wave"></i></div>
        <div>
            <div class="p-stat__value">{{ $latestPayslip ? 'ZMW ' . number_format($latestPayslip->net_pay, 0) : '—' }}</div>
            <div class="p-stat__label">Last Net Pay</div>
        </div>
    </div>
    <div class="p-stat">
        <div class="p-stat__icon blue"><i class="fas fa-calendar-check"></i></div>
        <div>
            <div class="p-stat__value">{{ $leaveBalances->sum('remaining') }}</div>
            <div class="p-stat__label">Leave Days Remaining</div>
        </div>
    </div>
    <div class="p-stat">
        <div class="p-stat__icon orange"><i class="fas fa-hourglass-half"></i></div>
        <div>
            <div class="p-stat__value">{{ $pendingLeave }}</div>
            <div class="p-stat__label">Pending Requests</div>
        </div>
    </div>
    <div class="p-stat">
        <div class="p-stat__icon teal"><i class="fas fa-star"></i></div>
        <div>
            <div class="p-stat__value">{{ $latestReview ? $latestReview->overall_rating . '/5' : 'N/A' }}</div>
            <div class="p-stat__label">Last Review Rating</div>
        </div>
    </div>
</div>

<div class="p-grid-2" style="margin-bottom:1.5rem;">
    {{-- Recent Payslips --}}
    <div class="p-card">
        <div class="p-card__header">
            <span class="p-card__title"><i class="fas fa-file-invoice-dollar" style="color:var(--portal-green);margin-right:.4rem;"></i> Recent Payslips</span>
            <a href="{{ route('portal.payslips.index') }}" class="p-btn outline sm">View All</a>
        </div>
        @forelse($recentPayslips as $slip)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem 0;border-bottom:1px solid #F1F5F9;">
            <div>
                <div style="font-weight:600;font-size:.88rem;">{{ $slip->payrollPeriod->name ?? 'Period #' . $slip->payroll_period_id }}</div>
                <div style="font-size:.75rem;color:var(--portal-muted);">{{ $slip->issued_at?->format('d M Y') ?? 'Pending' }}</div>
            </div>
            <div style="text-align:right;">
                <div style="font-weight:700;color:var(--portal-green);">ZMW {{ number_format($slip->net_pay, 2) }}</div>
                <a href="{{ route('portal.payslips.show', $slip) }}" style="font-size:.72rem;color:var(--portal-green);text-decoration:none;">View →</a>
            </div>
        </div>
        @empty
        <p style="color:var(--portal-muted);font-size:.85rem;text-align:center;padding:1rem 0;">No payslips yet.</p>
        @endforelse
    </div>

    {{-- Leave Balances --}}
    <div class="p-card">
        <div class="p-card__header">
            <span class="p-card__title"><i class="fas fa-calendar-minus" style="color:var(--portal-green);margin-right:.4rem;"></i> Leave Balances {{ now()->year }}</span>
            <a href="{{ route('portal.leave.create') }}" class="p-btn primary sm"><i class="fas fa-plus"></i> Apply</a>
        </div>
        @forelse($leaveBalances as $bal)
        <div style="margin-bottom:1rem;">
            <div style="display:flex;justify-content:space-between;font-size:.82rem;margin-bottom:.35rem;">
                <span style="font-weight:600;">{{ $bal['type']->name }}</span>
                <span style="color:var(--portal-muted);">{{ $bal['used'] }} / {{ $bal['allowed'] }} days used</span>
            </div>
            <div class="p-progress">
                <div class="p-progress__bar" style="width:{{ $bal['allowed'] > 0 ? min(100, ($bal['used']/$bal['allowed'])*100) : 0 }}%;background:{{ $bal['remaining'] === 0 ? '#EF4444' : 'var(--portal-green)' }};"></div>
            </div>
            <div style="font-size:.72rem;color:{{ $bal['remaining'] === 0 ? '#EF4444' : 'var(--portal-muted)' }};margin-top:.2rem;">{{ $bal['remaining'] }} days remaining</div>
        </div>
        @empty
        <p style="color:var(--portal-muted);font-size:.85rem;text-align:center;padding:1rem 0;">No leave types configured.</p>
        @endforelse
    </div>
</div>

<div class="p-grid-2" style="margin-bottom:1.5rem;">
    {{-- Latest Announcements --}}
    <div class="p-card">
        <div class="p-card__header">
            <span class="p-card__title"><i class="fas fa-bullhorn" style="color:var(--portal-green);margin-right:.4rem;"></i> Announcements</span>
            <a href="{{ route('portal.announcements.index') }}" class="p-btn outline sm">All</a>
        </div>
        @forelse($announcements as $ann)
        @php $pColors=['urgent'=>'red','high'=>'orange','normal'=>'blue','low'=>'grey']; @endphp
        <div style="padding:.75rem 0;border-bottom:1px solid #F1F5F9;">
            <div style="display:flex;gap:.5rem;align-items:flex-start;">
                <span class="p-badge {{ $pColors[$ann->priority] ?? 'grey' }}" style="white-space:nowrap;margin-top:.1rem;">{{ ucfirst($ann->priority) }}</span>
                <div>
                    <a href="{{ route('portal.announcements.show', $ann) }}" style="font-weight:600;font-size:.85rem;color:var(--portal-text);text-decoration:none;">{{ $ann->title }}</a>
                    <div style="font-size:.72rem;color:var(--portal-muted);margin-top:.1rem;">{{ $ann->published_at?->diffForHumans() }}</div>
                </div>
            </div>
        </div>
        @empty
        <p style="color:var(--portal-muted);font-size:.85rem;text-align:center;padding:1rem 0;">No announcements.</p>
        @endforelse
    </div>

    {{-- Recent Leave Requests --}}
    <div class="p-card">
        <div class="p-card__header">
            <span class="p-card__title"><i class="fas fa-list-check" style="color:var(--portal-green);margin-right:.4rem;"></i> My Leave History</span>
            <a href="{{ route('portal.leave.index') }}" class="p-btn outline sm">View All</a>
        </div>
        @forelse($leaveRequests as $req)
        @php $lc=['pending'=>'orange','approved'=>'green','rejected'=>'red','cancelled'=>'grey']; @endphp
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.65rem 0;border-bottom:1px solid #F1F5F9;">
            <div>
                <div style="font-weight:600;font-size:.85rem;">{{ $req->leaveType->name ?? '—' }}</div>
                <div style="font-size:.72rem;color:var(--portal-muted);">{{ $req->start_date?->format('d M') }} – {{ $req->end_date?->format('d M Y') }} · {{ $req->days_requested }}d</div>
            </div>
            <span class="p-badge {{ $lc[$req->status] ?? 'grey' }}">{{ ucfirst($req->status) }}</span>
        </div>
        @empty
        <p style="color:var(--portal-muted);font-size:.85rem;text-align:center;padding:1rem 0;">No leave requests.</p>
        @endforelse
    </div>
</div>

{{-- Colleagues --}}
@if($colleagues->count())
<div class="p-card">
    <div class="p-card__header">
        <span class="p-card__title"><i class="fas fa-users" style="color:var(--portal-green);margin-right:.4rem;"></i> Your Team — {{ $employee->department->name ?? 'Department' }}</span>
    </div>
    <div style="display:flex;gap:1rem;flex-wrap:wrap;">
        @foreach($colleagues as $col)
        <div style="display:flex;align-items:center;gap:.6rem;background:#F7FAFC;border-radius:8px;padding:.6rem .9rem;min-width:180px;">
            <div class="p-sidebar__avatar" style="width:36px;height:36px;font-size:.75rem;background:#1B4332;color:#C9A84C;">
                @if($col->photo)<img src="{{ Storage::url($col->photo) }}" alt="">@else{{ $col->initials }}@endif
            </div>
            <div>
                <div style="font-weight:600;font-size:.82rem;">{{ $col->full_name }}</div>
                <div style="font-size:.7rem;color:var(--portal-muted);">{{ $col->designation ?? 'Staff' }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection
