@extends('admin.layouts.app')
@section('title', 'Submit Expense')
@section('breadcrumb', 'Finance / Expenses / Submit')

@section('content')
<div class="page-header">
    <div><div class="page-title">Submit Expense Claim</div></div>
    <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.finance.expenses.store') }}" enctype="multipart/form-data">
            @csrf
            @if($errors->any())
            <div style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label class="form-label">Category <span style="color:red;">*</span></label>
                    <select name="expense_category_id" class="form-control" required>
                        <option value="">— Select —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('expense_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Department <span style="color:red;">*</span></label>
                    <select name="department_id" class="form-control" required>
                        <option value="">— Select —</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Employee</label>
                    <select name="employee_id" class="form-control">
                        <option value="">— None —</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Budget Line</label>
                    <select name="budget_line_id" class="form-control">
                        <option value="">— None —</option>
                        @foreach($budgetLines as $line)
                        <option value="{{ $line->id }}" {{ old('budget_line_id') == $line->id ? 'selected' : '' }}>{{ $line->account_code }} — {{ $line->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Description <span style="color:red;">*</span></label>
                    <textarea name="description" class="form-control" rows="2" required>{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Amount (ZMW) <span style="color:red;">*</span></label>
                    <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" step="0.01" min="0.01" required>
                </div>
                <div>
                    <label class="form-label">Expense Date <span style="color:red;">*</span></label>
                    <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-control">
                        <option value="">— Select —</option>
                        @foreach(['cash'=>'Cash','bank_transfer'=>'Bank Transfer','cheque'=>'Cheque','mobile_money'=>'Mobile Money'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('payment_method') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Receipt Number</label>
                    <input type="text" name="receipt_number" class="form-control" value="{{ old('receipt_number') }}" maxlength="50">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Receipt Document (PDF/Image, max 5MB)</label>
                    <input type="file" name="receipt_document" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Submit Expense</button>
                <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
