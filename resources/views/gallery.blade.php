@extends('layouts.app')
@section('title', 'Gallery — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Media</div>
        <h1 class="page-hero__title">Photo Gallery</h1>
        <p class="page-hero__sub">Images from CHAZ member institutions, programme activities, community outreach, and key events across Zambia.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / Gallery</div>
    </div>
</div>
<section class="section">
    <div class="container">
        @php
        $categories = ['All','HIV & AIDS','Malaria','Immunisation','Maternal Health','TB','Community'];
        $items = [
            ['cat'=>'Immunisation','label'=>'Vaccination Campaign — Eastern Province','span'=>'wide'],
            ['cat'=>'HIV & AIDS','label'=>'ART Clinic — Macha Mission Hospital','span'=>'tall'],
            ['cat'=>'Malaria','label'=>'Bed Net Distribution — Western Province','span'=>''],
            ['cat'=>'Maternal Health','label'=>'Antenatal Care — Mwandi Mission','span'=>''],
            ['cat'=>'TB','label'=>'TB Screening — Ndola','span'=>''],
            ['cat'=>'Community','label'=>'Community Health Workers Training','span'=>'wide'],
            ['cat'=>'Immunisation','label'=>'Child Health Week — Lusaka','span'=>''],
            ['cat'=>'HIV & AIDS','label'=>'PMTCT Counselling Session','span'=>'tall'],
            ['cat'=>'Malaria','label'=>'Rapid Diagnostic Testing','span'=>''],
        ];
        $gradients = [
            'background:linear-gradient(135deg,#1B4332,#40916C)',
            'background:linear-gradient(135deg,#2D6A4F,#52B788)',
            'background:linear-gradient(135deg,#40916C,#74C69D)',
            'background:linear-gradient(135deg,#1B4332,#2D6A4F)',
            'background:linear-gradient(135deg,#C9A84C,#E9C46A)',
            'background:linear-gradient(135deg,#0F2A1E,#1B4332)',
            'background:linear-gradient(135deg,#2D6A4F,#C9A84C)',
            'background:linear-gradient(135deg,#40916C,#1B4332)',
            'background:linear-gradient(135deg,#C9A84C,#40916C)',
        ];
        @endphp

        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:2rem;">
            @foreach($categories as $cat)
            <button class="filter-btn {{ $loop->first ? 'active' : '' }}">{{ $cat }}</button>
            @endforeach
        </div>

        <div class="gallery-grid">
            @foreach($items as $i => $item)
            <div class="gallery-item {{ $item['span'] === 'wide' ? 'gallery-item--wide' : ($item['span'] === 'tall' ? 'gallery-item--tall' : '') }}" style="{{ $gradients[$i] }}">
                <div class="gallery-item__placeholder">
                    <i class="fa fa-image"></i>
                    <span style="font-size:0.75rem;padding:0 1rem;text-align:center;">{{ $item['label'] }}</span>
                </div>
                <div class="gallery-item__overlay">
                    <i class="fa fa-magnifying-glass-plus"></i>
                </div>
            </div>
            @endforeach
        </div>

        <p style="text-align:center;margin-top:2.5rem;color:var(--color-slate-mid);font-size:0.875rem;">
            Photos shown are representative. To share images from your CHAZ member institution, contact <a href="mailto:communications@chaz.org.zm" style="color:var(--color-forest);">communications@chaz.org.zm</a>
        </p>
    </div>
</section>
@endsection
