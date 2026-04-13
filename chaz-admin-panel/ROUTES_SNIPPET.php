<?php

// ─────────────────────────────────────────────────────────────────────────────
// ADD THESE USE STATEMENTS to the top of routes/web.php
// ─────────────────────────────────────────────────────────────────────────────

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\RequisitionController;
use App\Http\Controllers\Admin\FleetController;
use App\Http\Controllers\Admin\FuelController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ReportController;

// ─────────────────────────────────────────────────────────────────────────────
// ADD THESE ROUTES inside the existing:
//   Route::middleware(\App\Http\Middleware\AdminAuthenticate::class)->group(function () {
//     ... existing routes ...
//     <<< PASTE HERE >>>
//   });
// ─────────────────────────────────────────────────────────────────────────────

// Organisation
Route::resource('users',       UserController::class)->except(['show']);
Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
Route::resource('roles',       RoleController::class)->except(['show']);
Route::resource('departments', DepartmentController::class)->except(['show']);

// Employees (HR)
Route::resource('employees', EmployeeController::class);

// Leave
Route::prefix('leave')->name('leave.')->group(function () {
    Route::get('/',                [LeaveController::class, 'index'])->name('index');
    Route::get('/create',          [LeaveController::class, 'create'])->name('create');
    Route::post('/',               [LeaveController::class, 'store'])->name('store');
    Route::get('/{leave}/edit',    [LeaveController::class, 'edit'])->name('edit');
    Route::put('/{leave}',         [LeaveController::class, 'update'])->name('update');
    Route::put('/{leave}/approve', [LeaveController::class, 'approve'])->name('approve');
    Route::put('/{leave}/reject',  [LeaveController::class, 'reject'])->name('reject');
    Route::delete('/{leave}',      [LeaveController::class, 'destroy'])->name('destroy');
    // Leave types
    Route::get('/types',           [LeaveController::class, 'types'])->name('types');
    Route::post('/types',          [LeaveController::class, 'storeType'])->name('types.store');
    Route::put('/types/{type}',    [LeaveController::class, 'updateType'])->name('types.update');
    Route::delete('/types/{type}', [LeaveController::class, 'destroyType'])->name('types.destroy');
});

// Payroll
Route::prefix('payroll')->name('payroll.')->group(function () {
    Route::get('/',                            [PayrollController::class, 'index'])->name('index');
    Route::get('/periods/create',              [PayrollController::class, 'createPeriod'])->name('periods.create');
    Route::post('/periods',                    [PayrollController::class, 'storePeriod'])->name('periods.store');
    Route::get('/periods/{period}/run',        [PayrollController::class, 'createRun'])->name('run.create');
    Route::post('/periods/{period}/run',       [PayrollController::class, 'storeRun'])->name('run.store');
    Route::get('/runs/{run}',                  [PayrollController::class, 'showRun'])->name('run.show');
    Route::put('/runs/{run}/approve',          [PayrollController::class, 'approveRun'])->name('run.approve');
    Route::put('/runs/{run}/pay',              [PayrollController::class, 'markPaid'])->name('run.pay');
    Route::get('/payslips/{payslip}',          [PayrollController::class, 'showPayslip'])->name('payslip.show');
    // Salary grades
    Route::get('/grades',                      [PayrollController::class, 'grades'])->name('grades');
    Route::post('/grades',                     [PayrollController::class, 'storeGrade'])->name('grades.store');
    Route::put('/grades/{grade}',              [PayrollController::class, 'updateGrade'])->name('grades.update');
    Route::delete('/grades/{grade}',           [PayrollController::class, 'destroyGrade'])->name('grades.destroy');
    // Salary components
    Route::post('/components',                 [PayrollController::class, 'storeComponent'])->name('components.store');
    Route::put('/components/{component}',      [PayrollController::class, 'updateComponent'])->name('components.update');
    Route::delete('/components/{component}',   [PayrollController::class, 'destroyComponent'])->name('components.destroy');
});

// Inventory
Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/',                        [InventoryController::class, 'index'])->name('index');
    Route::get('/create',                  [InventoryController::class, 'create'])->name('create');
    Route::post('/',                       [InventoryController::class, 'store'])->name('store');
    Route::get('/{item}/edit',             [InventoryController::class, 'edit'])->name('edit');
    Route::put('/{item}',                  [InventoryController::class, 'update'])->name('update');
    Route::delete('/{item}',               [InventoryController::class, 'destroy'])->name('destroy');
    Route::get('/stock',                   [InventoryController::class, 'stock'])->name('stock');
    Route::post('/stock/in',               [InventoryController::class, 'stockIn'])->name('stock.in');
    Route::post('/stock/out',              [InventoryController::class, 'stockOut'])->name('stock.out');
    Route::post('/stock/adjust',           [InventoryController::class, 'stockAdjust'])->name('stock.adjust');
    Route::get('/categories',              [InventoryController::class, 'categories'])->name('categories');
    Route::post('/categories',             [InventoryController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{cat}',        [InventoryController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{cat}',     [InventoryController::class, 'destroyCategory'])->name('categories.destroy');
});

// Suppliers
Route::resource('suppliers', SupplierController::class)->except(['show']);

// Purchase Orders
Route::prefix('purchase-orders')->name('purchase-orders.')->group(function () {
    Route::get('/',               [PurchaseOrderController::class, 'index'])->name('index');
    Route::get('/create',         [PurchaseOrderController::class, 'create'])->name('create');
    Route::post('/',              [PurchaseOrderController::class, 'store'])->name('store');
    Route::get('/{po}',           [PurchaseOrderController::class, 'show'])->name('show');
    Route::get('/{po}/edit',      [PurchaseOrderController::class, 'edit'])->name('edit');
    Route::put('/{po}',           [PurchaseOrderController::class, 'update'])->name('update');
    Route::delete('/{po}',        [PurchaseOrderController::class, 'destroy'])->name('destroy');
    Route::put('/{po}/approve',   [PurchaseOrderController::class, 'approve'])->name('approve');
    Route::put('/{po}/receive',   [PurchaseOrderController::class, 'receive'])->name('receive');
    Route::put('/{po}/cancel',    [PurchaseOrderController::class, 'cancel'])->name('cancel');
});

// Requisitions
Route::prefix('requisitions')->name('requisitions.')->group(function () {
    Route::get('/',               [RequisitionController::class, 'index'])->name('index');
    Route::get('/create',         [RequisitionController::class, 'create'])->name('create');
    Route::post('/',              [RequisitionController::class, 'store'])->name('store');
    Route::get('/{req}',          [RequisitionController::class, 'show'])->name('show');
    Route::get('/{req}/edit',     [RequisitionController::class, 'edit'])->name('edit');
    Route::put('/{req}',          [RequisitionController::class, 'update'])->name('update');
    Route::delete('/{req}',       [RequisitionController::class, 'destroy'])->name('destroy');
    Route::put('/{req}/approve',  [RequisitionController::class, 'approve'])->name('approve');
    Route::put('/{req}/reject',   [RequisitionController::class, 'reject'])->name('reject');
    Route::put('/{req}/fulfill',  [RequisitionController::class, 'fulfill'])->name('fulfill');
});

// Fleet — Vehicles
Route::prefix('fleet')->name('fleet.')->group(function () {
    Route::resource('vehicles', FleetController::class);
    Route::get('/vehicles/{vehicle}/insurance',       [FleetController::class, 'insurance'])->name('vehicles.insurance');
    Route::post('/vehicles/{vehicle}/insurance',      [FleetController::class, 'storeInsurance'])->name('vehicles.insurance.store');
    Route::get('/vehicles/{vehicle}/assign',          [FleetController::class, 'assign'])->name('vehicles.assign');
    Route::post('/vehicles/{vehicle}/assign',         [FleetController::class, 'storeAssign'])->name('vehicles.assign.store');
    // Fuel
    Route::get('/fuel',              [FuelController::class, 'index'])->name('fuel.index');
    Route::get('/fuel/create',       [FuelController::class, 'create'])->name('fuel.create');
    Route::post('/fuel',             [FuelController::class, 'store'])->name('fuel.store');
    Route::delete('/fuel/{log}',     [FuelController::class, 'destroy'])->name('fuel.destroy');
    // Maintenance
    Route::get('/maintenance',             [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create',      [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance',            [MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{rec}/edit',  [MaintenanceController::class, 'edit'])->name('maintenance.edit');
    Route::put('/maintenance/{rec}',       [MaintenanceController::class, 'update'])->name('maintenance.update');
    Route::put('/maintenance/{rec}/complete', [MaintenanceController::class, 'complete'])->name('maintenance.complete');
    // Trips
    Route::get('/trips',             [TripController::class, 'index'])->name('trips.index');
    Route::get('/trips/create',      [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips',            [TripController::class, 'store'])->name('trips.store');
    Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
    Route::put('/trips/{trip}',      [TripController::class, 'update'])->name('trips.update');
    Route::put('/trips/{trip}/start',    [TripController::class, 'start'])->name('trips.start');
    Route::put('/trips/{trip}/complete', [TripController::class, 'complete'])->name('trips.complete');
    Route::put('/trips/{trip}/cancel',   [TripController::class, 'cancel'])->name('trips.cancel');
});

// Finance — Budgets
Route::prefix('finance')->name('finance.')->group(function () {
    // Budget periods
    Route::get('/budgets',                         [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/budgets/periods/create',          [BudgetController::class, 'createPeriod'])->name('budgets.periods.create');
    Route::post('/budgets/periods',                [BudgetController::class, 'storePeriod'])->name('budgets.periods.store');
    Route::put('/budgets/periods/{period}/lock',   [BudgetController::class, 'lockPeriod'])->name('budgets.periods.lock');
    Route::put('/budgets/periods/{period}/unlock', [BudgetController::class, 'unlockPeriod'])->name('budgets.periods.unlock');
    // Budgets per dept
    Route::get('/budgets/create',          [BudgetController::class, 'create'])->name('budgets.create');
    Route::post('/budgets',                [BudgetController::class, 'store'])->name('budgets.store');
    Route::get('/budgets/{budget}/edit',   [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::put('/budgets/{budget}',        [BudgetController::class, 'update'])->name('budgets.update');
    Route::put('/budgets/{budget}/approve',[BudgetController::class, 'approve'])->name('budgets.approve');
    // Expenses
    Route::get('/expenses',                [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create',         [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses',               [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}',      [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}',   [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::put('/expenses/{expense}/submit',  [ExpenseController::class, 'submit'])->name('expenses.submit');
    Route::put('/expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
    Route::put('/expenses/{expense}/reject',  [ExpenseController::class, 'reject'])->name('expenses.reject');
    Route::put('/expenses/{expense}/pay',     [ExpenseController::class, 'markPaid'])->name('expenses.pay');
});

// Announcements
Route::resource('announcements', AnnouncementController::class)->except(['show']);
Route::put('announcements/{announcement}/publish',   [AnnouncementController::class, 'publish'])->name('announcements.publish');
Route::put('announcements/{announcement}/unpublish', [AnnouncementController::class, 'unpublish'])->name('announcements.unpublish');

// Reports
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/',          [ReportController::class, 'index'])->name('index');
    Route::get('/hr',        [ReportController::class, 'hr'])->name('hr');
    Route::get('/payroll',   [ReportController::class, 'payroll'])->name('payroll');
    Route::get('/fleet',     [ReportController::class, 'fleet'])->name('fleet');
    Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
    Route::get('/finance',   [ReportController::class, 'finance'])->name('finance');
});
