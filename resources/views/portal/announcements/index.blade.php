@extends('portal.layouts.app')
@section('page_title', 'Announcements')
@section('breadcrumb', 'Announcements')

@section('content')
<div class="p-card">
    <div class="p-card__header" style="margin-bottom:1.25rem;">
        <span class="p-card__title">All Announcements</span>
        <div style="display:flex;gap:.5rem;align-items:center;">
            @foreach(['urgent','high','normal','low'] as $p)
            <span class="p-badge {{ ['urgent'=>'red','high'=>'orange','normal'=>'blue','low'=>'grey'][$p] }}">{{ ucfirst($p) }}</span>
            @endforeach
        </div>
    </div>

    @forelse($announcements as $ann)
    @php $pColors=['urgent'=>'red','high'=>'orange','normal'=>'blue','low'=>'grey']; @endphp
    <a href="{{ route('portal.announcements.show', $ann) }}" style="display:block;text-decoration:none;color:inherit;">
        <div style="padding:1rem 0;border-bottom:1px solid #F1F5F9;display:flex;gap:1rem;align-items:flex-start;transition:background .15s;border-radius:8px;" class="ann-row">
            <div style="flex-shrink:0;width:42px;height:42px;border-radius:10px;background:{{ $ann->priority==='urgent' ? '#FEE2E2' : ($ann->priority==='high' ? '#FEF3C7' : '#F0FDF4') }};display:flex;align-items:center;justify-content:center;font-size:1.1rem;">
                @if($ann->priority === 'urgent')<i class="fas fa-exclamation-circle" style="color:#DC2626;"></i>
                @elseif($ann->priority === 'high')<i class="fas fa-bell" style="color:#D97706;"></i>
                @else<i class="fas fa-bullhorn" style="color:var(--portal-green);"></i>@endif
            </div>
            <div style="flex:1;min-width:0;">
                <div style="display:flex;gap:.6rem;align-items:center;flex-wrap:wrap;margin-bottom:.3rem;">
                    <span class="p-badge {{ $pColors[$ann->priority] ?? 'grey' }}">{{ ucfirst($ann->priority) }}</span>
                    @if($ann->target_audience !== 'all')
                    <span class="p-badge grey" style="font-size:.7rem;">{{ ucfirst($ann->target_audience) }}</span>
                    @endif
                    <span style="font-size:.72rem;color:var(--portal-muted);">{{ $ann->published_at?->diffForHumans() }}</span>
                </div>
                <div style="font-weight:700;font-size:.9rem;margin-bottom:.2rem;">{{ $ann->title }}</div>
                <div style="font-size:.82rem;color:var(--portal-muted);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit(strip_tags($ann->content), 120) }}</div>
            </div>
            <div style="flex-shrink:0;font-size:.72rem;color:var(--portal-muted);text-align:right;white-space:nowrap;">
                <i class="fas fa-eye"></i> {{ $ann->view_count ?? 0 }}<br>
                {{ $ann->published_at?->format('d M') }}
            </div>
        </div>
    </a>
    @empty
    <div style="text-align:center;padding:3rem 0;color:var(--portal-muted);">
        <i class="fas fa-bullhorn" style="font-size:2rem;margin-bottom:.75rem;opacity:.3;display:block;"></i>
        No announcements at this time.
    </div>
    @endforelse
</div>

<div style="padding:.5rem 0;">{{ $announcements->links() }}</div>

@push('styles')
<style>.ann-row:hover { background:#F7FAFC; padding-left:.5rem; }</style>
@endpush
@endsection
