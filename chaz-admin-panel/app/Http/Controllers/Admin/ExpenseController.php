<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Expense, ExpenseCategory, Department, Budget, Employee, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['category', 'department', 'submittedBy'])->latest('expense_date');

        if ($request->filled('status'))        $query->where('status', $request->status);
        if ($request->filled('department_id')) $query->where('department_id', $request->department_id);
        if ($request->filled('category_id'))   $query->where('category_id', $request->category_id);

        if (!admin_can('manage_finance') && admin_department_id()) {
            $query->where('department_id', admin_department_id());
        }

        $expenses    = $query->paginate(25)->withQueryString();
        $categories  = ExpenseCategory::active()->get();
        $departments = Department::active()->orderBy('name')->get();

        $totals = [
            'pending'  => Expense::pending()->sum('amount_zmw'),
            'approved' => Expense::approved()->sum('amount_zmw'),
            'paid'     => Expense::paid()->sum('amount_zmw'),
        ];

        return view('admin.finance.expenses.index', compact('expenses', 'categories', 'departments', 'totals'));
    }

    public function create()
    {
        $categories  = ExpenseCategory::active()->get();
        $departments = Department::active()->orderBy('name')->get();
        $budgets     = Budget::approved()->with('department')->get();
        $employees   = Employee::active()->orderBy('first_name')->get();
        return view('admin.finance.expenses.form', compact('categories', 'departments', 'budgets', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:expense_categories,id',
            'department_id'  => 'required|exists:departments,id',
            'budget_id'      => 'nullable|exists:budgets,id',
            'employee_id'    => 'nullable|exists:employees,id',
            'title'          => 'required|string|max:200',
            'description'    => 'nullable|string',
            'amount'         => 'required|numeric|min:0.01',
            'currency'       => 'required|string|max:3',
            'exchange_rate'  => 'nullable|numeric|min:0.001',
            'expense_date'   => 'required|date',
            'payment_method' => 'nullable|in:cash,bank_transfer,cheque,mobile_money',
            'receipt'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data['exp_number']  = Expense::generateExpNumber();
        $data['submitted_by'] = session('admin_id');
        $data['status']      = 'pending';
        $data['exchange_rate'] = $data['exchange_rate'] ?? 1;
        $data['amount_zmw']  = $data['amount'] * $data['exchange_rate'];

        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')->store('expenses/receipts', 'public');
        }

        $expense = Expense::create($data);
        AuditLog::record('submitted_expense', 'Expense', $expense->id);

        return redirect()->route('admin.finance.expenses.index')->with('success', 'Expense ' . $expense->exp_number . ' submitted.');
    }

    public function show(Expense $expense)
    {
        $expense->load(['category', 'department', 'budget', 'employee', 'submittedBy', 'approvedBy']);
        return view('admin.finance.expenses.show', compact('expense'));
    }

    public function approve(Expense $expense)
    {
        $expense->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);

        // Update budget spent
        if ($expense->budget_id) {
            Budget::where('id', $expense->budget_id)->increment('total_spent', $expense->amount_zmw);
        }

        AuditLog::record('approved_expense', 'Expense', $expense->id);
        return back()->with('success', 'Expense approved.');
    }

    public function reject(Request $request, Expense $expense)
    {
        $request->validate(['rejection_reason' => 'required|string|max:300']);
        $expense->update(['status' => 'rejected', 'approved_by' => session('admin_id'), 'approved_at' => now(), 'rejection_reason' => $request->rejection_reason]);
        AuditLog::record('rejected_expense', 'Expense', $expense->id);
        return back()->with('success', 'Expense rejected.');
    }

    public function markPaid(Expense $expense)
    {
        $expense->update(['status' => 'paid', 'paid_at' => now()]);
        AuditLog::record('paid_expense', 'Expense', $expense->id);
        return back()->with('success', 'Expense marked as paid.');
    }
}
