@extends('admin.layouts.app')
@section('title', 'Salary Grades')
@section('page-title', 'Salary Grades & Components')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Salary Grades & Components</div>
        <div class="page-subtitle">Pay scales and salary component configuration</div>
    </div>
    <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Payroll</a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;">

    {{-- Salary Grades --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-layer-group" style="color:var(--forest);margin-right:.4rem;"></i> Salary Grades</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Grade Name</th>
                        <th>Basic Salary</th>
                        <th>Min – Max</th>
                        <th>Employees</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($grades as $grade)
                <tr>
                    <td><code>{{ $grade->code }}</code></td>
                    <td style="font-weight:600;">{{ $grade->name }}</td>
                    <td style="font-weight:700;color:var(--forest);">ZMW {{ number_format($grade->basic_salary, 2) }}</td>
                    <td style="font-size:.8rem;color:var(--slate-mid);">
                        {{ number_format($grade->min_salary, 0) }} – {{ number_format($grade->max_salary, 0) }}
                    </td>
                    <td>
                        <span class="badge {{ $grade->employees_count > 0 ? 'badge-blue' : 'badge-grey' }}">
                            {{ $grade->employees_count }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $grade->is_active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $grade->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:var(--slate-mid);">
                        No salary grades configured.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($grades->isEmpty())
        <div class="card-body" style="text-align:center;">
            <p style="font-size:.85rem;color:var(--slate-mid);">
                Salary grades define the pay bands for each employee category.
                Add grades via database seeder or migration.
            </p>
        </div>
        @endif
    </div>

    {{-- Salary Components --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-sliders" style="color:var(--forest);margin-right:.4rem;"></i> Salary Components</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Component</th>
                        <th>Type</th>
                        <th>Calculation</th>
                        <th>Value</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($components as $comp)
                @php
                    $typeColor = ['allowance'=>'badge-green','deduction'=>'badge-red','tax'=>'badge-gold'];
                @endphp
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:.875rem;">{{ $comp->name }}</div>
                        @if($comp->description)
                        <div style="font-size:.72rem;color:var(--slate-mid);">{{ $comp->description }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $typeColor[$comp->type] ?? 'badge-grey' }}">{{ ucfirst($comp->type) }}</span>
                    </td>
                    <td style="font-size:.82rem;text-transform:capitalize;">{{ str_replace('_',' ',$comp->calculation_type) }}</td>
                    <td style="font-weight:700;">
                        @if($comp->calculation_type === 'percentage')
                            {{ $comp->value }}%
                        @else
                            ZMW {{ number_format($comp->value, 2) }}
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $comp->is_active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $comp->is_active ? 'Active' : 'Off' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:2rem;color:var(--slate-mid);">
                        No salary components configured.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('styles')
<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
</style>
@endpush
@endsection
