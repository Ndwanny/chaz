@extends('admin.layouts.app')
@section('title', 'Reports')
@section('breadcrumb', 'Reports')

@section('content')
<div class="page-header">
    <div><div class="page-title">Reports</div><div class="page-subtitle">Organizational reporting and analytics</div></div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px;">

    @if(admin_can('view_employees') || admin_can('manage_hr'))
    <a href="{{ route('admin.reports.hr') }}" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--primary);margin-bottom:12px;"><i class="fas fa-users"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">HR Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Employees, leave, headcount by department</div>
        </div>
    </a>
    @endif

    @if(admin_can('view_payroll') || admin_can('manage_payroll'))
    <a href="{{ route('admin.reports.payroll') }}" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--success);margin-bottom:12px;"><i class="fas fa-money-bill-wave"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Payroll Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Monthly payroll summary, PAYE, NAPSA, NHIMA</div>
        </div>
    </a>
    @endif

    @if(admin_can('view_fleet') || admin_can('manage_fleet'))
    <a href="{{ route('admin.reports.fleet') }}" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--warning);margin-bottom:12px;"><i class="fas fa-car"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Fleet Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Fuel consumption, trips, maintenance costs</div>
        </div>
    </a>
    @endif

    @if(admin_can('view_finance') || admin_can('manage_finance'))
    <a href="{{ route('admin.reports.finance') }}" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--info);margin-bottom:12px;"><i class="fas fa-chart-pie"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Finance Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Budget utilization, expenses by department</div>
        </div>
    </a>
    @endif

    @if(admin_can('manage_system'))
    <a href="{{ route('admin.reports.audit') }}" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--danger);margin-bottom:12px;"><i class="fas fa-clipboard-list"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Audit Log</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">All system actions and changes</div>
        </div>
    </a>
    @endif

</div>
@endsection
