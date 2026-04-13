<?php

use Illuminate\Support\Facades\Route;

// ── Public controllers ───────────────────────────────────────────────────────
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\DownloadsController;
use App\Http\Controllers\TendersController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployeePortalController;
use App\Http\Controllers\DonateController;

// ── Admin controllers ────────────────────────────────────────────────────────
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PortalAccountController;
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
use App\Http\Controllers\Admin\NewsController       as AdminNewsController;
use App\Http\Controllers\Admin\JobsController       as AdminJobsController;
use App\Http\Controllers\Admin\TendersController    as AdminTendersController;
use App\Http\Controllers\Admin\MembersController    as AdminMembersController;
use App\Http\Controllers\Admin\DownloadsController  as AdminDownloadsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\KpiController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/about/board-of-trustees', [AboutController::class, 'board'])->name('about.board');
Route::get('/members', [MembersController::class, 'index'])->name('members');
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/gallery', fn() => view('gallery'))->name('gallery');
Route::get('/downloads', [DownloadsController::class, 'index'])->name('downloads');
Route::get('/downloads/publications', [DownloadsController::class, 'publications'])->name('downloads.publications');
Route::get('/downloads/annual-reports', [DownloadsController::class, 'annualReports'])->name('downloads.annual-reports');
Route::get('/downloads/newsletters', [DownloadsController::class, 'newsletters'])->name('downloads.newsletters');
Route::get('/tenders', [TendersController::class, 'index'])->name('tenders');
Route::get('/tenders/sub-recipient-adverts', [TendersController::class, 'subRecipientAdverts'])->name('tenders.sub-recipient-adverts');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/{id}', [JobsController::class, 'show'])->name('jobs.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/employee-portal', [EmployeePortalController::class, 'index'])->name('employee-portal');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Donate
Route::get('/donate',           [DonateController::class, 'index'])->name('donate');
Route::post('/donate/initiate', [DonateController::class, 'initiate'])->name('donate.initiate');
Route::post('/donate/callback', [DonateController::class, 'callback'])->name('donate.callback')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/donate/success',   [DonateController::class, 'success'])->name('donate.success');
Route::get('/donate/cancel',    [DonateController::class, 'cancel'])->name('donate.cancel');

// ── Employee Portal Routes ───────────────────────────────────────────────────
use App\Http\Controllers\Portal\PortalAuthController;
use App\Http\Controllers\Portal\PortalDashboardController;
use App\Http\Controllers\Portal\PortalPayslipController;
use App\Http\Controllers\Portal\PortalLeaveController;
use App\Http\Controllers\Portal\PortalProfileController;
use App\Http\Controllers\Portal\PortalAnnouncementController;

Route::prefix('portal')->name('portal.')->group(function () {
    Route::post('login',  [PortalAuthController::class, 'login'])->name('login');
    Route::post('logout', [PortalAuthController::class, 'logout'])->name('logout');

    Route::middleware(\App\Http\Middleware\PortalAuthenticate::class)->group(function () {
        Route::get('dashboard', [PortalDashboardController::class, 'index'])->name('dashboard');

        // Payslips
        Route::get('payslips',       [PortalPayslipController::class, 'index'])->name('payslips.index');
        Route::get('payslips/{payslip}', [PortalPayslipController::class, 'show'])->name('payslips.show');

        // Leave
        Route::get('leave',              [PortalLeaveController::class, 'index'])->name('leave.index');
        Route::get('leave/apply',        [PortalLeaveController::class, 'create'])->name('leave.create');
        Route::post('leave',             [PortalLeaveController::class, 'store'])->name('leave.store');
        Route::patch('leave/{leaveRequest}/cancel', [PortalLeaveController::class, 'cancel'])->name('leave.cancel');

        // Profile
        Route::get('profile',                   [PortalProfileController::class, 'show'])->name('profile');
        Route::post('profile/password',         [PortalProfileController::class, 'changePassword'])->name('profile.password');
        Route::post('profile/contact',          [PortalProfileController::class, 'updateContact'])->name('profile.contact');

        // Announcements
        Route::get('announcements',             [PortalAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('announcements/{announcement}', [PortalAnnouncementController::class, 'show'])->name('announcements.show');
    });
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');

    Route::middleware(\App\Http\Middleware\AdminAuthenticate::class)->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('news',      AdminNewsController::class)->except(['show']);
        Route::resource('jobs',      AdminJobsController::class)->except(['show']);
        Route::resource('tenders',   AdminTendersController::class)->except(['show']);
        Route::resource('members',   AdminMembersController::class)->except(['show']);
        Route::resource('downloads', AdminDownloadsController::class)->except(['show']);
        Route::get('messages',              [MessagesController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}',    [MessagesController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [MessagesController::class, 'destroy'])->name('messages.destroy');
        Route::get('settings',  [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings',  [SettingsController::class, 'update'])->name('settings.update');

        // ── KPI API ───────────────────────────────────────────────────────────
        Route::get('api/kpis', [KpiController::class, 'stats'])->name('api.kpis');

        // ── System / RBAC ─────────────────────────────────────────────────────
        Route::resource('users',       UserController::class)->except(['show']);
        Route::resource('roles',       RoleController::class)->except(['show']);
        Route::resource('departments', DepartmentController::class)->except(['show']);

        // ── Employees ─────────────────────────────────────────────────────────
        Route::resource('employees', EmployeeController::class);

        // ── Portal Account Management (HR only) ───────────────────────────────
        Route::prefix('portal-accounts')->name('portal-accounts.')->group(function () {
            Route::get('/',                                    [PortalAccountController::class, 'index'])->name('index');
            Route::post('{employee}/activate',                 [PortalAccountController::class, 'activate'])->name('activate');
            Route::post('{employee}/deactivate',               [PortalAccountController::class, 'deactivate'])->name('deactivate');
            Route::post('{employee}/reset-password',           [PortalAccountController::class, 'resetPassword'])->name('reset-password');
            Route::post('{employee}/set-password',             [PortalAccountController::class, 'setPassword'])->name('set-password');
            Route::post('bulk-activate',                       [PortalAccountController::class, 'bulkActivate'])->name('bulk-activate');
        });

        // ── Leave ─────────────────────────────────────────────────────────────
        Route::prefix('leave')->name('leave.')->group(function () {
            Route::get('/',               [LeaveController::class, 'index'])->name('index');
            Route::get('/create',         [LeaveController::class, 'create'])->name('create');
            Route::post('/',              [LeaveController::class, 'store'])->name('store');
            Route::patch('/{leave}/approve', [LeaveController::class, 'approve'])->name('approve');
            Route::patch('/{leave}/reject',  [LeaveController::class, 'reject'])->name('reject');
            Route::get('/types',          [LeaveController::class, 'types'])->name('types');
            Route::post('/types',         [LeaveController::class, 'storeType'])->name('types.store');
        });

        // ── Payroll ───────────────────────────────────────────────────────────
        Route::prefix('payroll')->name('payroll.')->group(function () {
            Route::get('/',                          [PayrollController::class, 'index'])->name('index');
            Route::get('/periods/create',            [PayrollController::class, 'createPeriod'])->name('periods.create');
            Route::post('/periods',                  [PayrollController::class, 'storePeriod'])->name('periods.store');
            Route::post('/periods/{period}/run',     [PayrollController::class, 'runPayroll'])->name('run.store');
            Route::get('/runs/{run}',                [PayrollController::class, 'showRun'])->name('run.show');
            Route::patch('/runs/{run}/approve',      [PayrollController::class, 'approveRun'])->name('run.approve');
            Route::get('/payslips/{payslip}',        [PayrollController::class, 'showPayslip'])->name('payslip');
            Route::get('/grades',                    [PayrollController::class, 'grades'])->name('grades');
        });

        // ── Inventory ─────────────────────────────────────────────────────────
        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/',          [InventoryController::class, 'index'])->name('index');
            Route::get('/create',    [InventoryController::class, 'create'])->name('create');
            Route::post('/',         [InventoryController::class, 'store'])->name('store');
            Route::get('/{item}/edit', [InventoryController::class, 'edit'])->name('edit');
            Route::put('/{item}',    [InventoryController::class, 'update'])->name('update');
            Route::get('/stock',     [InventoryController::class, 'stockMovement'])->name('stock');
            Route::post('/stock',    [InventoryController::class, 'recordStock'])->name('stock.store');
        });

        // ── Suppliers ─────────────────────────────────────────────────────────
        Route::resource('suppliers', SupplierController::class)->except(['show']);

        // ── Purchase Orders ───────────────────────────────────────────────────
        Route::prefix('purchase-orders')->name('purchase-orders.')->group(function () {
            Route::get('/',             [PurchaseOrderController::class, 'index'])->name('index');
            Route::get('/create',       [PurchaseOrderController::class, 'create'])->name('create');
            Route::post('/',            [PurchaseOrderController::class, 'store'])->name('store');
            Route::get('/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('show');
            Route::patch('/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('approve');
            Route::patch('/{purchaseOrder}/deliver', [PurchaseOrderController::class, 'markDelivered'])->name('deliver');
        });

        // ── Requisitions ──────────────────────────────────────────────────────
        Route::prefix('requisitions')->name('requisitions.')->group(function () {
            Route::get('/',           [RequisitionController::class, 'index'])->name('index');
            Route::get('/create',     [RequisitionController::class, 'create'])->name('create');
            Route::post('/',          [RequisitionController::class, 'store'])->name('store');
            Route::get('/{requisition}',    [RequisitionController::class, 'show'])->name('show');
            Route::patch('/{requisition}/approve', [RequisitionController::class, 'approve'])->name('approve');
            Route::patch('/{requisition}/reject',  [RequisitionController::class, 'reject'])->name('reject');
        });

        // ── Fleet ─────────────────────────────────────────────────────────────
        Route::prefix('fleet')->name('fleet.')->group(function () {
            // Vehicles
            Route::resource('vehicles', FleetController::class);
            Route::post('/vehicles/{vehicle}/insurance', [FleetController::class, 'storeInsurance'])->name('vehicles.insurance.store');
            // Fuel
            Route::get('/fuel',        [FuelController::class, 'index'])->name('fuel.index');
            Route::get('/fuel/create', [FuelController::class, 'create'])->name('fuel.create');
            Route::post('/fuel',       [FuelController::class, 'store'])->name('fuel.store');
            // Maintenance
            Route::get('/maintenance',          [MaintenanceController::class, 'index'])->name('maintenance.index');
            Route::get('/maintenance/create',   [MaintenanceController::class, 'create'])->name('maintenance.create');
            Route::post('/maintenance',         [MaintenanceController::class, 'store'])->name('maintenance.store');
            Route::patch('/maintenance/{record}/complete', [MaintenanceController::class, 'complete'])->name('maintenance.complete');
            // Trips
            Route::get('/trips',         [TripController::class, 'index'])->name('trips.index');
            Route::get('/trips/create',  [TripController::class, 'create'])->name('trips.create');
            Route::post('/trips',        [TripController::class, 'store'])->name('trips.store');
            Route::patch('/trips/{trip}/approve',  [TripController::class, 'approve'])->name('trips.approve');
            Route::patch('/trips/{trip}/depart',   [TripController::class, 'depart'])->name('trips.depart');
            Route::patch('/trips/{trip}/complete', [TripController::class, 'complete'])->name('trips.complete');
        });

        // ── Finance ───────────────────────────────────────────────────────────
        Route::prefix('finance')->name('finance.')->group(function () {
            // Budgets
            Route::get('/budgets',                [BudgetController::class, 'index'])->name('budgets.index');
            Route::get('/budgets/periods',        [BudgetController::class, 'periods'])->name('budgets.periods');
            Route::post('/budgets/periods',       [BudgetController::class, 'storePeriod'])->name('budgets.periods.store');
            Route::get('/budgets/create',         [BudgetController::class, 'create'])->name('budgets.create');
            Route::post('/budgets',               [BudgetController::class, 'store'])->name('budgets.store');
            Route::get('/budgets/{budget}',       [BudgetController::class, 'show'])->name('budgets.show');
            Route::patch('/budgets/{budget}/approve', [BudgetController::class, 'approve'])->name('budgets.approve');
            // Expenses
            Route::get('/expenses',               [ExpenseController::class, 'index'])->name('expenses.index');
            Route::get('/expenses/create',        [ExpenseController::class, 'create'])->name('expenses.create');
            Route::post('/expenses',              [ExpenseController::class, 'store'])->name('expenses.store');
            Route::get('/expenses/{expense}',     [ExpenseController::class, 'show'])->name('expenses.show');
            Route::patch('/expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
            Route::patch('/expenses/{expense}/reject',  [ExpenseController::class, 'reject'])->name('expenses.reject');
            Route::patch('/expenses/{expense}/pay',     [ExpenseController::class, 'markPaid'])->name('expenses.pay');
        });

        // ── Announcements ─────────────────────────────────────────────────────
        Route::resource('announcements', AnnouncementController::class)->except(['show']);

        // ── Reports ───────────────────────────────────────────────────────────
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',        [ReportController::class, 'index'])->name('index');
            Route::get('/hr',      [ReportController::class, 'hrReport'])->name('hr');
            Route::get('/payroll', [ReportController::class, 'payrollReport'])->name('payroll');
            Route::get('/fleet',   [ReportController::class, 'fleetReport'])->name('fleet');
            Route::get('/finance', [ReportController::class, 'financeReport'])->name('finance');
            Route::get('/audit',   [ReportController::class, 'auditLog'])->name('audit');
        });
    });
});
