<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Expense, ExpenseCategory, Department, BudgetLine, Employee, AuditLog};
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['category', 'department', 'createdBy'])->latest('expense_date');

        if ($request->filled('status'))             $query->where('status', $request->status);
        if ($request->filled('department_id'))      $query->where('department_id', $request->department_id);
        if ($request->filled('expense_category_id')) $query->where('expense_category_id', $request->expense_category_id);

        if (!admin_can('manage_finance') && admin_department_id()) {
            $query->where('department_id', admin_department_id());
        }

        $expenses    = $query->paginate(25)->withQueryString();
        $categories  = ExpenseCategory::where('is_active', true)->get();
        $departments = Department::active()->orderBy('name')->get();

        $totals = [
            'pending'  => Expense::pending()->sum('amount'),
            'approved' => Expense::approved()->sum('amount'),
            'paid'     => Expense::paid()->sum('amount'),
        ];

        return view('admin.finance.expenses.index', compact('expenses', 'categories', 'departments', 'totals'));
    }

    public function create()
    {
        $categories  = ExpenseCategory::where('is_active', true)->get();
        $departments = Department::active()->orderBy('name')->get();
        $budgetLines = BudgetLine::with('budget.department')->get();
        $employees   = Employee::active()->orderBy('first_name')->get();
        return view('admin.finance.expenses.form', compact('categories', 'departments', 'budgetLines', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'department_id'       => 'required|exists:departments,id',
            'budget_line_id'      => 'nullable|exists:budget_lines,id',
            'employee_id'         => 'nullable|exists:employees,id',
            'description'         => 'required|string|max:500',
            'amount'              => 'required|numeric|min:0.01',
            'expense_date'        => 'required|date',
            'receipt_number'      => 'nullable|string|max:50',
            'payment_method'      => 'nullable|in:cash,bank_transfer,cheque,mobile_money',
            'notes'               => 'nullable|string',
            'receipt_document'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data['expense_number'] = Expense::generateExpNumber();
        $data['created_by']     = session('admin_id');
        $data['status']         = 'pending';

        if ($request->hasFile('receipt_document')) {
            $data['receipt_document'] = $request->file('receipt_document')->store('expenses/receipts', 'public');
        }

        $expense = Expense::create($data);
        AuditLog::record('submitted_expense', 'Expense', $expense->id);

        return redirect()->route('admin.finance.expenses.index')->with('success', 'Expense ' . $expense->expense_number . ' submitted.');
    }

    public function show(Expense $expense)
    {
        $expense->load(['category', 'department', 'budgetLine', 'employee', 'createdBy', 'approvedBy']);
        return view('admin.finance.expenses.show', compact('expense'));
    }

    public function approve(Expense $expense)
    {
        $expense->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);

        if ($expense->budget_line_id) {
            BudgetLine::where('id', $expense->budget_line_id)->increment('spent_amount', $expense->amount);
            // Also update parent budget total_spent
            $line = BudgetLine::find($expense->budget_line_id);
            if ($line) {
                \App\Models\Budget::where('id', $line->budget_id)->increment('total_spent', $expense->amount);
            }
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
        $expense->update(['status' => 'paid', 'paid_by' => session('admin_id'), 'paid_at' => now()]);
        AuditLog::record('paid_expense', 'Expense', $expense->id);
        return back()->with('success', 'Expense marked as paid.');
    }
}
