<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — CHAZ</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="admin-body">

{{-- Sidebar --}}
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <span class="brand-icon"><i class="fas fa-shield-halved"></i></span>
            <span class="brand-text">CHAZ Admin</span>
        </a>
        <button class="sidebar-close" id="sidebarClose"><i class="fas fa-times"></i></button>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">{{ $currentAdmin->initials }}</div>
        <div class="user-info">
            <span class="user-name">{{ $currentAdmin->name }}</span>
            <span class="user-role">{{ session('admin_role_label', 'Admin') }}</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-gauge-high"></i><span>Dashboard</span>
        </a>

        {{-- System Management --}}
        @if(admin_can('manage_system'))
        <div class="nav-section">System</div>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i><span>Users</span>
        </a>
        <a href="{{ route('admin.roles.index') }}" class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i><span>Roles & Permissions</span>
        </a>
        <a href="{{ route('admin.departments.index') }}" class="nav-item {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
            <i class="fas fa-sitemap"></i><span>Departments</span>
        </a>
        @endif

        {{-- HR --}}
        @if(admin_can('view_employees') || admin_can('manage_employees'))
        <div class="nav-section">Human Resources</div>
        <a href="{{ route('admin.employees.index') }}" class="nav-item {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
            <i class="fas fa-id-badge"></i><span>Employees</span>
        </a>
        @endif
        @if(admin_can('view_leave') || admin_can('manage_hr'))
        <a href="{{ route('admin.leave.index') }}" class="nav-item {{ request()->routeIs('admin.leave.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-minus"></i><span>Leave Management</span>
        </a>
        @endif

        {{-- Payroll --}}
        @if(admin_can('view_payroll') || admin_can('manage_payroll'))
        <div class="nav-section">Payroll</div>
        <a href="{{ route('admin.payroll.index') }}" class="nav-item {{ request()->routeIs('admin.payroll.*') ? 'active' : '' }}">
            <i class="fas fa-money-bill-wave"></i><span>Payroll Runs</span>
        </a>
        <a href="{{ route('admin.payroll.grades') }}" class="nav-item {{ request()->routeIs('admin.payroll.grades') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i><span>Salary Grades</span>
        </a>
        @endif

        {{-- Procurement --}}
        @if(admin_can('view_procurement') || admin_can('manage_procurement'))
        <div class="nav-section">Procurement</div>
        <a href="{{ route('admin.requisitions.index') }}" class="nav-item {{ request()->routeIs('admin.requisitions.*') ? 'active' : '' }}">
            <i class="fas fa-file-lines"></i><span>Requisitions</span>
        </a>
        <a href="{{ route('admin.purchase-orders.index') }}" class="nav-item {{ request()->routeIs('admin.purchase-orders.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i><span>Purchase Orders</span>
        </a>
        <a href="{{ route('admin.suppliers.index') }}" class="nav-item {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
            <i class="fas fa-truck"></i><span>Suppliers</span>
        </a>
        @endif

        {{-- Inventory --}}
        @if(admin_can('view_inventory') || admin_can('manage_inventory'))
        <div class="nav-section">Inventory</div>
        <a href="{{ route('admin.inventory.index') }}" class="nav-item {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">
            <i class="fas fa-boxes-stacked"></i><span>Items & Stock</span>
        </a>
        <a href="{{ route('admin.inventory.stock') }}" class="nav-item {{ request()->routeIs('admin.inventory.stock') ? 'active' : '' }}">
            <i class="fas fa-arrow-right-arrow-left"></i><span>Stock Movements</span>
        </a>
        @endif

        {{-- Fleet --}}
        @if(admin_can('view_fleet') || admin_can('manage_fleet'))
        <div class="nav-section">Fleet</div>
        <a href="{{ route('admin.fleet.vehicles.index') }}" class="nav-item {{ request()->routeIs('admin.fleet.vehicles.*') ? 'active' : '' }}">
            <i class="fas fa-car"></i><span>Vehicles</span>
        </a>
        <a href="{{ route('admin.fleet.trips.index') }}" class="nav-item {{ request()->routeIs('admin.fleet.trips.*') ? 'active' : '' }}">
            <i class="fas fa-route"></i><span>Trip Logs</span>
        </a>
        <a href="{{ route('admin.fleet.fuel.index') }}" class="nav-item {{ request()->routeIs('admin.fleet.fuel.*') ? 'active' : '' }}">
            <i class="fas fa-gas-pump"></i><span>Fuel Logs</span>
        </a>
        <a href="{{ route('admin.fleet.maintenance.index') }}" class="nav-item {{ request()->routeIs('admin.fleet.maintenance.*') ? 'active' : '' }}">
            <i class="fas fa-wrench"></i><span>Maintenance</span>
        </a>
        @endif

        {{-- Finance --}}
        @if(admin_can('view_finance') || admin_can('manage_finance'))
        <div class="nav-section">Finance</div>
        <a href="{{ route('admin.finance.budgets.index') }}" class="nav-item {{ request()->routeIs('admin.finance.budgets.*') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i><span>Budgets</span>
        </a>
        <a href="{{ route('admin.finance.expenses.index') }}" class="nav-item {{ request()->routeIs('admin.finance.expenses.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i><span>Expenses</span>
        </a>
        @endif

        {{-- Communications --}}
        @if(admin_can('manage_content') || admin_can('manage_comms'))
        <div class="nav-section">Communications</div>
        <a href="{{ route('admin.announcements.index') }}" class="nav-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i><span>Announcements</span>
        </a>
        @endif

        {{-- Reports --}}
        @if(admin_can('view_reports') || admin_can('manage_system'))
        <div class="nav-section">Reports</div>
        <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i><span>Reports</span>
        </a>
        @endif

        {{-- Audit (super admin only) --}}
        @if(admin_can('manage_system'))
        <a href="{{ route('admin.reports.audit') }}" class="nav-item {{ request()->routeIs('admin.reports.audit') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i><span>Audit Log</span>
        </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('admin.logout') }}" class="nav-item nav-logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-right-from-bracket"></i><span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>
</aside>

{{-- Main content --}}
<div class="admin-main" id="adminMain">
    <header class="admin-topbar">
        <button class="topbar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <div class="topbar-breadcrumb">@yield('breadcrumb', 'Dashboard')</div>
        <div class="topbar-actions">
            <a href="{{ route('admin.announcements.index') }}" class="topbar-icon" title="Announcements"><i class="fas fa-bell"></i></a>
            <span class="topbar-admin">{{ $currentAdmin->name }}</span>
        </div>
    </header>

    <main class="admin-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    const sidebar  = document.getElementById('adminSidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn  = document.getElementById('sidebarClose');

    function openSidebar()  { sidebar.classList.add('open'); overlay.classList.add('visible'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('visible'); }

    toggleBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>
</body>
</html>
