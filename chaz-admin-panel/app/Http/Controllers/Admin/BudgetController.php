<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Budget, BudgetPeriod, BudgetLine, Department, AuditLog};
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $activePeriod = BudgetPeriod::active()->latest()->first();
        $periodId     = $request->get('period_id', $activePeriod?->id);

        $query = Budget::with(['department', 'budgetPeriod'])->where('budget_period_id', $periodId);

        // Non-super admins see only their department
        if (!admin_can('manage_finance') && admin_department_id()) {
            $query->where('department_id', admin_department_id());
        }

        $budgets = $query->orderBy('id')->paginate(20)->withQueryString();
        $periods = BudgetPeriod::orderByDesc('fiscal_year')->get();

        return view('admin.finance.budgets.index', compact('budgets', 'periods', 'activePeriod', 'periodId'));
    }

    public function create()
    {
        $periods     = BudgetPeriod::active()->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.finance.budgets.form', compact('periods', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'budget_period_id' => 'required|exists:budget_periods,id',
            'department_id'    => 'required|exists:departments,id',
            'title'            => 'required|string|max:150',
            'total_allocated'  => 'required|numeric|min:0',
            'notes'            => 'nullable|string',
            'lines'            => 'nullable|array',
            'lines.*.account_code'   => 'required|string|max:20',
            'lines.*.description'    => 'required|string|max:150',
            'lines.*.allocated_amount' => 'required|numeric|min:0',
        ]);

        $budget = Budget::create([
            'budget_period_id' => $data['budget_period_id'],
            'department_id'    => $data['department_id'],
            'title'            => $data['title'],
            'total_allocated'  => $data['total_allocated'],
            'total_spent'      => 0,
            'total_committed'  => 0,
            'status'           => 'draft',
            'notes'            => $data['notes'] ?? null,
        ]);

        if (!empty($data['lines'])) {
            foreach ($data['lines'] as $line) {
                $budget->lines()->create([
                    'account_code'     => $line['account_code'],
                    'description'      => $line['description'],
                    'allocated_amount' => $line['allocated_amount'],
                    'spent_amount'     => 0,
                    'committed_amount' => 0,
                ]);
            }
        }

        AuditLog::record('created_budget', 'Budget', $budget->id);

        return redirect()->route('admin.finance.budgets.index')->with('success', 'Budget created.');
    }

    public function show(Budget $budget)
    {
        $budget->load(['department', 'budgetPeriod', 'lines', 'expenses.category']);
        return view('admin.finance.budgets.show', compact('budget'));
    }

    public function approve(Budget $budget)
    {
        $budget->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);
        AuditLog::record('approved_budget', 'Budget', $budget->id);
        return back()->with('success', 'Budget approved.');
    }

    // Budget Periods
    public function periods()
    {
        $periods = BudgetPeriod::withCount('budgets')->orderByDesc('fiscal_year')->get();
        return view('admin.finance.budgets.periods', compact('periods'));
    }

    public function storePeriod(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:80',
            'fiscal_year' => 'required|string|max:9',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
        ]);

        $data['status'] = 'active';
        BudgetPeriod::create($data);

        return redirect()->route('admin.finance.budgets.periods')->with('success', 'Budget period created.');
    }
}
