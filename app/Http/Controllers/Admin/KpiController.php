<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class KpiController extends Controller
{
    /**
     * Return all KPI stats as JSON — cached for 60 seconds.
     */
    public function stats(): \Illuminate\Http\JsonResponse
    {
        $data = Cache::remember('admin_kpis', 60, function () {
            return [
                'hr'         => $this->hrStats(),
                'payroll'    => $this->payrollStats(),
                'procurement'=> $this->procurementStats(),
                'fleet'      => $this->fleetStats(),
                'finance'    => $this->financeStats(),
                'portal'     => $this->portalStats(),
                'content'    => $this->contentStats(),
                'generated_at' => now()->toIso8601String(),
            ];
        });

        return response()->json($data);
    }

    // ── HR ────────────────────────────────────────────────────────────────────
    private function hrStats(): array
    {
        $today = now()->toDateString();

        $activeEmployees = DB::table('employees')
            ->where('status', 'active')->whereNull('deleted_at')->count();

        $onLeaveToday = DB::table('leave_requests')
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)->count();

        $pendingLeave = DB::table('leave_requests')
            ->where('status', 'pending')->count();

        $newThisMonth = DB::table('employees')
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->whereYear('hired_at', now()->year)
            ->whereMonth('hired_at', now()->month)->count();

        $byGender = DB::table('employees')
            ->where('status', 'active')->whereNull('deleted_at')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')->pluck('total', 'gender');

        $byType = DB::table('employees')
            ->where('status', 'active')->whereNull('deleted_at')
            ->select('employment_type', DB::raw('count(*) as total'))
            ->groupBy('employment_type')->pluck('total', 'employment_type');

        return [
            'active_employees'  => $activeEmployees,
            'on_leave_today'    => $onLeaveToday,
            'pending_leave'     => $pendingLeave,
            'new_this_month'    => $newThisMonth,
            'male'              => (int)($byGender['male'] ?? 0),
            'female'            => (int)($byGender['female'] ?? 0),
            'permanent'         => (int)($byType['permanent'] ?? 0),
            'contract'          => (int)($byType['contract'] ?? 0),
        ];
    }

    // ── PAYROLL ───────────────────────────────────────────────────────────────
    private function payrollStats(): array
    {
        $lastRun = DB::table('payroll_runs')
            ->join('payroll_periods', 'payroll_runs.payroll_period_id', '=', 'payroll_periods.id')
            ->orderByDesc('payroll_runs.id')
            ->select('payroll_runs.*', 'payroll_periods.name as period_name', 'payroll_periods.status as period_status')
            ->first();

        $openPeriods = DB::table('payroll_periods')->where('status', 'open')->count();

        $ytdNet = DB::table('payroll_runs')
            ->join('payroll_periods', 'payroll_runs.payroll_period_id', '=', 'payroll_periods.id')
            ->where('payroll_periods.year', now()->year)
            ->where('payroll_runs.status', 'approved')
            ->sum('payroll_runs.total_net');

        $ytdTax = DB::table('payroll_runs')
            ->join('payroll_periods', 'payroll_runs.payroll_period_id', '=', 'payroll_periods.id')
            ->where('payroll_periods.year', now()->year)
            ->where('payroll_runs.status', 'approved')
            ->sum('payroll_runs.total_tax');

        return [
            'last_run_net'    => (float)($lastRun->total_net ?? 0),
            'last_run_basic'  => (float)($lastRun->total_basic ?? 0),
            'last_run_month'  => $lastRun->period_name ?? '—',
            'last_run_status' => $lastRun->status ?? '—',
            'last_run_count'  => (int)($lastRun->employee_count ?? 0),
            'open_periods'    => $openPeriods,
            'ytd_net'         => (float)$ytdNet,
            'ytd_tax'         => (float)$ytdTax,
        ];
    }

    // ── PROCUREMENT ───────────────────────────────────────────────────────────
    private function procurementStats(): array
    {
        $pos = DB::table('purchase_orders')
            ->select('status', DB::raw('count(*) as total'), DB::raw('sum(grand_total) as value'))
            ->groupBy('status')->get()->keyBy('status');

        $lowStock = DB::table('items')
            ->where('is_active', true)
            ->where('current_stock', '>', 0)
            ->whereColumn('current_stock', '<=', 'reorder_level')->count();

        $outOfStock = DB::table('items')
            ->where('is_active', true)
            ->where('current_stock', 0)->count();

        $totalInventoryValue = DB::table('items')
            ->where('is_active', true)
            ->sum(DB::raw('current_stock * unit_cost'));

        return [
            'pending_pos'         => (int)($pos['submitted']->total ?? 0),
            'approved_pos'        => (int)($pos['approved']->total ?? 0),
            'received_pos'        => (int)($pos['received']->total ?? 0),
            'total_suppliers'     => DB::table('suppliers')->where('is_active', true)->count(),
            'total_items'         => DB::table('items')->where('is_active', true)->count(),
            'low_stock'           => $lowStock,
            'out_of_stock'        => $outOfStock,
            'inventory_value'     => (float)$totalInventoryValue,
        ];
    }

    // ── FLEET ─────────────────────────────────────────────────────────────────
    private function fleetStats(): array
    {
        $vehicles = DB::table('vehicles')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->get()->keyBy('status');

        $totalVehicles  = DB::table('vehicles')->count();
        $activeVehicles = DB::table('vehicles')->whereIn('status', ['active', 'available'])->count();

        $maintenanceDue = DB::table('maintenance_records')
            ->where('next_service_date', '<=', now()->addDays(14)->toDateString())
            ->where('status', '!=', 'completed')->count();

        $mtdFuelCost = DB::table('fuel_logs')
            ->whereYear('log_date', now()->year)
            ->whereMonth('log_date', now()->month)
            ->sum('total_cost');

        $mtdFuelLitres = DB::table('fuel_logs')
            ->whereYear('log_date', now()->year)
            ->whereMonth('log_date', now()->month)
            ->sum('litres');

        $tripsThisMonth = DB::table('trip_logs')
            ->whereYear('departure_date', now()->year)
            ->whereMonth('departure_date', now()->month)->count();

        return [
            'total_vehicles'    => $totalVehicles,
            'active_vehicles'   => $activeVehicles,
            'on_maintenance'    => (int)($vehicles['maintenance']->total ?? 0),
            'maintenance_due'   => $maintenanceDue,
            'mtd_fuel_cost'     => (float)$mtdFuelCost,
            'mtd_fuel_litres'   => (float)$mtdFuelLitres,
            'trips_this_month'  => $tripsThisMonth,
        ];
    }

    // ── FINANCE ───────────────────────────────────────────────────────────────
    private function financeStats(): array
    {
        $expenses = DB::table('expenses')
            ->select('status', DB::raw('count(*) as total'), DB::raw('sum(amount) as value'))
            ->whereYear('expense_date', now()->year)
            ->groupBy('status')->get()->keyBy('status');

        $ytdExpenses = DB::table('expenses')
            ->whereYear('expense_date', now()->year)->sum('amount');

        $mtdExpenses = DB::table('expenses')
            ->whereYear('expense_date', now()->year)
            ->whereMonth('expense_date', now()->month)->sum('amount');

        $budgetUtilisation = DB::table('budgets')
            ->where('status', 'approved')
            ->selectRaw('sum(total_budget) as budget, sum(total_spent) as spent')
            ->first();

        return [
            'pending_count'     => (int)($expenses['submitted']->total ?? 0),
            'pending_amount'    => (float)($expenses['submitted']->value ?? 0),
            'approved_amount'   => (float)($expenses['approved']->value ?? 0),
            'paid_amount'       => (float)($expenses['paid']->value ?? 0),
            'ytd_expenses'      => (float)$ytdExpenses,
            'mtd_expenses'      => (float)$mtdExpenses,
            'total_budget'      => (float)($budgetUtilisation->budget ?? 0),
            'total_spent'       => (float)($budgetUtilisation->spent ?? 0),
        ];
    }

    // ── PORTAL ────────────────────────────────────────────────────────────────
    private function portalStats(): array
    {
        $total   = DB::table('employees')->where('status', 'active')->whereNull('deleted_at')->count();
        $active  = DB::table('employees')->where('status', 'active')->whereNull('deleted_at')->where('portal_active', true)->count();
        $noLogin = DB::table('employees')->where('status', 'active')->whereNull('deleted_at')
            ->where('portal_active', true)->whereNull('portal_last_login')->count();

        return [
            'total_employees'   => $total,
            'portal_active'     => $active,
            'portal_inactive'   => $total - $active,
            'never_logged_in'   => $noLogin,
        ];
    }

    // ── CONTENT ───────────────────────────────────────────────────────────────
    private function contentStats(): array
    {
        return [
            'announcements_live' => DB::table('announcements')
                ->where('is_published', true)
                ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                ->count(),
            'announcements_draft'=> DB::table('announcements')->where('is_published', false)->count(),
        ];
    }
}
