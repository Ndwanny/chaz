@extends('admin.layouts.app')
@section('title', 'New Budget')
@section('breadcrumb', 'Finance / Budgets / New')

@section('content')
<div class="page-header">
    <div><div class="page-title">Create Budget</div></div>
    <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:800px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.finance.budgets.store') }}">
            @csrf
            @if($errors->any())
            <div style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label class="form-label">Budget Period <span style="color:red;">*</span></label>
                    <select name="budget_period_id" class="form-control" required>
                        <option value="">— Select Period —</option>
                        @foreach($periods as $p)
                        <option value="{{ $p->id }}" {{ old('budget_period_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Department <span style="color:red;">*</span></label>
                    <select name="department_id" class="form-control" required>
                        <option value="">— Select Department —</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Total Budget (ZMW) <span style="color:red;">*</span></label>
                    <input type="number" name="total_budget" class="form-control" value="{{ old('total_budget') }}" step="0.01" min="0" required>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <h4 style="margin-bottom:12px;">Budget Lines</h4>
            <div id="lines-container">
                <div class="budget-line" style="display:grid;grid-template-columns:120px 1fr 160px auto;gap:10px;margin-bottom:8px;align-items:end;">
                    <div><label class="form-label">Account Code</label><input type="text" name="lines[0][account_code]" class="form-control" maxlength="20"></div>
                    <div><label class="form-label">Description</label><input type="text" name="lines[0][description]" class="form-control" maxlength="150"></div>
                    <div><label class="form-label">Amount (ZMW)</label><input type="number" name="lines[0][budgeted_amount]" class="form-control" step="0.01" min="0"></div>
                    <div><button type="button" onclick="removeLine(this)" class="btn btn-sm btn-outline" style="color:#dc2626;margin-top:20px;">✕</button></div>
                </div>
            </div>
            <button type="button" onclick="addLine()" class="btn btn-outline btn-sm" style="margin-top:6px;"><i class="fas fa-plus"></i> Add Line</button>

            <div style="margin-top:24px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Create Budget</button>
                <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
let lineCount = 1;
function addLine() {
    const c = document.getElementById('lines-container');
    const i = lineCount++;
    c.insertAdjacentHTML('beforeend', `
        <div class="budget-line" style="display:grid;grid-template-columns:120px 1fr 160px auto;gap:10px;margin-bottom:8px;align-items:end;">
            <div><input type="text" name="lines[${i}][account_code]" class="form-control" maxlength="20" placeholder="Code"></div>
            <div><input type="text" name="lines[${i}][description]" class="form-control" maxlength="150" placeholder="Description"></div>
            <div><input type="number" name="lines[${i}][budgeted_amount]" class="form-control" step="0.01" min="0" placeholder="0.00"></div>
            <div><button type="button" onclick="removeLine(this)" class="btn btn-sm btn-outline" style="color:#dc2626;">✕</button></div>
        </div>`);
}
function removeLine(btn) { btn.closest('.budget-line').remove(); }
</script>
@endsection
