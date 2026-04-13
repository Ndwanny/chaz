@extends('portal.layouts.app')
@section('page_title', 'Apply for Leave')
@section('breadcrumb', 'Leave / Apply')

@section('content')
<div style="max-width:640px;margin:0 auto;">
    <div style="margin-bottom:1.25rem;">
        <a href="{{ route('portal.leave.index') }}" class="p-btn outline"><i class="fas fa-arrow-left"></i> Back to Leave</a>
    </div>

    {{-- Balances summary --}}
    <div class="p-card" style="margin-bottom:1.5rem;">
        <div class="p-card__header" style="margin-bottom:.75rem;">
            <span class="p-card__title">Your Leave Balances</span>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:.75rem;">
            @foreach($balances as $bal)
            <div style="background:#F7FAFC;border-radius:8px;padding:.6rem 1rem;min-width:130px;">
                <div style="font-size:.72rem;color:var(--portal-muted);margin-bottom:.2rem;">{{ $bal['type']->name }}</div>
                <div style="font-weight:700;color:{{ $bal['remaining'] === 0 ? '#EF4444' : 'var(--portal-green)' }};">{{ $bal['remaining'] }} <span style="font-weight:400;font-size:.78rem;color:var(--portal-muted);">/ {{ $bal['allowed'] }} days</span></div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="p-card">
        <div class="p-card__header" style="margin-bottom:1.25rem;">
            <span class="p-card__title"><i class="fas fa-calendar-plus" style="color:var(--portal-green);margin-right:.4rem;"></i> New Leave Application</span>
        </div>

        @if($errors->any())
        <div class="p-alert error" style="margin-bottom:1.25rem;">
            <ul style="margin:0;padding-left:1.2rem;">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('portal.leave.store') }}">
            @csrf

            <div class="p-form-group">
                <label class="p-label">Leave Type <span style="color:#EF4444;">*</span></label>
                <select name="leave_type_id" class="p-input" required onchange="updateBalance(this)">
                    <option value="">— Select leave type —</option>
                    @foreach($leaveTypes as $type)
                    <option value="{{ $type->id }}"
                        data-remaining="{{ collect($balances)->firstWhere(fn($b) => $b['type']->id === $type->id)['remaining'] ?? 0 }}"
                        {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                        @php $bal = collect($balances)->firstWhere(fn($b) => $b['type']->id === $type->id); @endphp
                        ({{ $bal['remaining'] ?? 0 }} days remaining)
                    </option>
                    @endforeach
                </select>
                <div id="balance-hint" style="font-size:.78rem;color:var(--portal-green);margin-top:.35rem;display:none;"></div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="p-form-group">
                    <label class="p-label">Start Date <span style="color:#EF4444;">*</span></label>
                    <input type="date" name="start_date" class="p-input" required value="{{ old('start_date') }}" min="{{ now()->addDay()->format('Y-m-d') }}" onchange="calcDays()">
                </div>
                <div class="p-form-group">
                    <label class="p-label">End Date <span style="color:#EF4444;">*</span></label>
                    <input type="date" name="end_date" class="p-input" required value="{{ old('end_date') }}" min="{{ now()->addDay()->format('Y-m-d') }}" onchange="calcDays()">
                </div>
            </div>

            <div id="days-preview" style="display:none;background:#F0FDF4;border:1px solid #A7F3D0;border-radius:8px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.85rem;">
                <i class="fas fa-info-circle" style="color:var(--portal-green);margin-right:.4rem;"></i>
                <strong id="days-count">0</strong> working day(s) (excluding weekends)
            </div>

            <div class="p-form-group">
                <label class="p-label">Reason / Notes</label>
                <textarea name="reason" class="p-input" rows="3" placeholder="Brief reason for leave (optional)">{{ old('reason') }}</textarea>
            </div>

            <div class="p-form-group">
                <label class="p-label">Handover Notes</label>
                <textarea name="handover_notes" class="p-input" rows="2" placeholder="Who will cover your duties? (optional)">{{ old('handover_notes') }}</textarea>
            </div>

            <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
                <button type="submit" class="p-btn primary" style="flex:1;justify-content:center;">
                    <i class="fas fa-paper-plane"></i> Submit Application
                </button>
                <a href="{{ route('portal.leave.index') }}" class="p-btn outline" style="flex:0 0 auto;">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updateBalance(sel) {
    const opt = sel.options[sel.selectedIndex];
    const hint = document.getElementById('balance-hint');
    if (opt.value) {
        const rem = opt.dataset.remaining;
        hint.style.display = 'block';
        hint.innerHTML = `<i class="fas fa-calendar-check"></i> You have <strong>${rem}</strong> day(s) available for this leave type.`;
        hint.style.color = rem > 0 ? 'var(--portal-green)' : '#EF4444';
    } else {
        hint.style.display = 'none';
    }
    calcDays();
}

function calcDays() {
    const start = document.querySelector('[name=start_date]').value;
    const end = document.querySelector('[name=end_date]').value;
    if (!start || !end) { document.getElementById('days-preview').style.display='none'; return; }
    const s = new Date(start), e = new Date(end);
    if (e < s) { document.getElementById('days-preview').style.display='none'; return; }
    let count = 0, cur = new Date(s);
    while (cur <= e) {
        const d = cur.getDay();
        if (d !== 0 && d !== 6) count++;
        cur.setDate(cur.getDate() + 1);
    }
    document.getElementById('days-count').textContent = count;
    document.getElementById('days-preview').style.display = 'block';
}
</script>
@endpush
@endsection
