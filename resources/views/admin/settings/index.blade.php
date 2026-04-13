@extends('admin.layouts.app')
@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">System Settings</div>
        <div class="page-subtitle">Configure organisation details, HR policies, payroll and portal options</div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

{{-- Tab nav --}}
<div style="display:flex;gap:.25rem;flex-wrap:wrap;margin-bottom:1.25rem;border-bottom:2px solid var(--border);padding-bottom:0;">
    @foreach($schema as $groupKey => $groupDef)
    <button type="button"
            class="settings-tab {{ $loop->first ? 'active' : '' }}"
            data-tab="{{ $groupKey }}"
            onclick="switchTab('{{ $groupKey }}')">
        <i class="fas {{ $groupDef['icon'] }}"></i>
        {{ $groupDef['label'] }}
    </button>
    @endforeach
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf @method('PUT')

    @foreach($schema as $groupKey => $groupDef)
    <div class="settings-panel {{ $loop->first ? '' : 'hidden' }}" id="tab-{{ $groupKey }}">
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <i class="fas {{ $groupDef['icon'] }}" style="color:var(--forest);margin-right:.4rem;"></i>
                    {{ $groupDef['label'] }} Settings
                </span>
            </div>
            <div class="card-body">
                <div class="form-grid form-grid--2">
                @foreach($groupDef['fields'] as $field)
                @php
                    $key     = $field['key'];
                    $current = old('settings.'.$key, $stored[$key] ?? $field['default']);
                    $type    = $field['type'];
                @endphp

                @if($type === 'boolean')
                {{-- Full-width toggle row --}}
                <div class="form-group" style="grid-column:1/-1;display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;background:var(--bg-alt);border-radius:8px;border:1px solid var(--border);">
                    <div>
                        <div style="font-weight:500;font-size:.875rem;">{{ $field['label'] }}</div>
                        @if(!empty($field['help']))
                        <div style="font-size:.76rem;color:var(--slate-mid);margin-top:2px;">{{ $field['help'] }}</div>
                        @endif
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden"   name="settings[{{ $key }}]" value="0">
                        <input type="checkbox" name="settings[{{ $key }}]" value="1" {{ $current ? 'checked' : '' }} onchange="this.previousElementSibling.disabled = this.checked">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                @elseif($type === 'textarea')
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">{{ $field['label'] }}</label>
                    @if(!empty($field['help']))
                    <div style="font-size:.76rem;color:var(--slate-mid);margin-bottom:.3rem;">{{ $field['help'] }}</div>
                    @endif
                    <textarea name="settings[{{ $key }}]" class="form-control" rows="3">{{ $current }}</textarea>
                </div>

                @elseif($type === 'select')
                <div class="form-group">
                    <label class="form-label">{{ $field['label'] }}</label>
                    @if(!empty($field['help']))
                    <div style="font-size:.76rem;color:var(--slate-mid);margin-bottom:.3rem;">{{ $field['help'] }}</div>
                    @endif
                    <select name="settings[{{ $key }}]" class="form-control">
                        @foreach($field['options'] as $optVal => $optLabel)
                        <option value="{{ $optVal }}" {{ $current == $optVal ? 'selected' : '' }}>{{ $optLabel }}</option>
                        @endforeach
                    </select>
                </div>

                @else
                <div class="form-group">
                    <label class="form-label">{{ $field['label'] }}</label>
                    @if(!empty($field['help']))
                    <div style="font-size:.76rem;color:var(--slate-mid);margin-bottom:.3rem;">{{ $field['help'] }}</div>
                    @endif
                    <input type="{{ $type }}"
                           name="settings[{{ $key }}]"
                           class="form-control"
                           value="{{ $current }}"
                           @if($type === 'number') step="any" @endif>
                </div>
                @endif

                @endforeach
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
        </div>
    </div>
    @endforeach

</form>

@push('styles')
<style>
.settings-tab {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .55rem 1rem;
    font-size: .875rem;
    font-weight: 500;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    color: var(--slate-mid);
    cursor: pointer;
    transition: color .15s, border-color .15s;
    margin-bottom: -2px;
}
.settings-tab:hover { color: var(--forest); }
.settings-tab.active { color: var(--forest); border-bottom-color: var(--forest); }
.settings-panel.hidden { display: none; }

/* Toggle switch */
.toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; }
.toggle-switch input[type="checkbox"] { opacity: 0; width: 0; height: 0; position: absolute; }
.toggle-switch input[type="hidden"]   { display: none; }
.toggle-slider {
    position: absolute; inset: 0;
    background: #cbd5e0; border-radius: 24px; cursor: pointer;
    transition: background .2s;
}
.toggle-slider::before {
    content: '';
    position: absolute; width: 18px; height: 18px; left: 3px; top: 3px;
    background: #fff; border-radius: 50%;
    transition: transform .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input[type="checkbox"]:checked + .toggle-slider { background: var(--forest); }
.toggle-switch input[type="checkbox"]:checked + .toggle-slider::before { transform: translateX(20px); }

@media (max-width: 640px) {
    .settings-tab { padding: .45rem .65rem; font-size: .8rem; }
    .settings-tab i { display: none; }
}
</style>
@endpush

@push('scripts')
<script>
function switchTab(key) {
    document.querySelectorAll('.settings-panel').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + key).classList.remove('hidden');
    document.querySelector('[data-tab="' + key + '"]').classList.add('active');
}

// Fix boolean hidden inputs: when checkbox is checked, hidden sibling should be disabled
// so only the checkbox value ("1") is submitted, not the hidden "0".
document.querySelectorAll('.toggle-switch input[type="checkbox"]').forEach(cb => {
    function sync() {
        cb.previousElementSibling.disabled = cb.checked;
    }
    sync();
    cb.addEventListener('change', sync);
});
</script>
@endpush
@endsection
