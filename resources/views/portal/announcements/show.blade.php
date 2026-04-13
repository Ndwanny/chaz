@extends('portal.layouts.app')
@section('page_title', $announcement->title)
@section('breadcrumb', 'Announcements / ' . Str::limit($announcement->title, 40))

@section('content')
<div style="max-width:760px;margin:0 auto;">
    <div style="margin-bottom:1.25rem;">
        <a href="{{ route('portal.announcements.index') }}" class="p-btn outline"><i class="fas fa-arrow-left"></i> All Announcements</a>
    </div>

    <div class="p-card">
        @php $pColors=['urgent'=>'red','high'=>'orange','normal'=>'blue','low'=>'grey']; @endphp

        {{-- Priority + meta --}}
        <div style="display:flex;flex-wrap:wrap;gap:.6rem;align-items:center;margin-bottom:1.25rem;">
            <span class="p-badge {{ $pColors[$announcement->priority] ?? 'grey' }}" style="font-size:.8rem;padding:.3rem .85rem;">{{ ucfirst($announcement->priority) }}</span>
            @if($announcement->target_audience !== 'all')
            <span class="p-badge grey">{{ ucfirst($announcement->target_audience) }}</span>
            @endif
            <span style="font-size:.78rem;color:var(--portal-muted);"><i class="fas fa-calendar" style="margin-right:.3rem;"></i>{{ $announcement->published_at?->format('d F Y, H:i') ?? '—' }}</span>
            <span style="font-size:.78rem;color:var(--portal-muted);margin-left:auto;"><i class="fas fa-eye" style="margin-right:.3rem;"></i>{{ $announcement->view_count ?? 0 }} views</span>
        </div>

        {{-- Title --}}
        <h1 style="font-size:1.3rem;font-weight:800;color:var(--portal-text);margin:0 0 1.25rem;line-height:1.3;">{{ $announcement->title }}</h1>

        {{-- Divider --}}
        <div style="border-top:3px solid var(--portal-green);margin-bottom:1.5rem;width:48px;"></div>

        {{-- Body --}}
        <div style="font-size:.9rem;line-height:1.8;color:var(--portal-text);">
            {!! nl2br(e($announcement->content)) !!}
        </div>

        {{-- Attachments --}}
        @if($announcement->attachment)
        <div style="margin-top:1.75rem;padding-top:1.25rem;border-top:1px solid #F1F5F9;">
            <div style="font-size:.78rem;font-weight:700;color:var(--portal-muted);margin-bottom:.6rem;">ATTACHMENT</div>
            <a href="{{ Storage::url($announcement->attachment) }}" target="_blank" class="p-btn outline">
                <i class="fas fa-paperclip"></i> Download Attachment
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
