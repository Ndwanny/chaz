<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="section-label">Website &amp; Content</div>
<div class="stats-grid" style="margin-bottom:1.75rem;">
    <div class="stat-box">
        <div class="stat-box__icon stat-box__icon--green"><i class="fa fa-newspaper"></i></div>
        <div>
            <div class="stat-box__num"><?php echo e(number_format($stats['news'])); ?></div>
            <div class="stat-box__label">News Articles</div>
            <div class="stat-box__sub"><?php echo e($stats['news_published']); ?> published</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon stat-box__icon--gold"><i class="fa fa-briefcase"></i></div>
        <div>
            <div class="stat-box__num"><?php echo e(number_format($stats['jobs'])); ?></div>
            <div class="stat-box__label">Job Postings</div>
            <div class="stat-box__sub"><?php echo e($stats['jobs_open']); ?> open</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon stat-box__icon--blue"><i class="fa fa-file-contract"></i></div>
        <div>
            <div class="stat-box__num"><?php echo e(number_format($stats['tenders'])); ?></div>
            <div class="stat-box__label">Tenders</div>
            <div class="stat-box__sub"><?php echo e($stats['tenders_open']); ?> open</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon stat-box__icon--red"><i class="fa fa-envelope"></i></div>
        <div>
            <div class="stat-box__num"><?php echo e(number_format($stats['messages'])); ?></div>
            <div class="stat-box__label">Messages</div>
            <div class="stat-box__sub <?php echo e($stats['unread_messages'] > 0 ? 'text-warning' : ''); ?>"><?php echo e($stats['unread_messages']); ?> unread</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon stat-box__icon--green"><i class="fa fa-hospital"></i></div>
        <div>
            <div class="stat-box__num"><?php echo e(number_format($stats['members'])); ?></div>
            <div class="stat-box__label">Member Institutions</div>
            <div class="stat-box__sub">Across 10 provinces</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon stat-box__icon--teal"><i class="fa fa-download"></i></div>
        <div>
            <div class="stat-box__num"><?php echo e(number_format($stats['downloads'])); ?></div>
            <div class="stat-box__label">Downloads</div>
            <div class="stat-box__sub">Publications &amp; reports</div>
        </div>
    </div>
</div>


<div class="card" style="margin-bottom:1.75rem;">
    <div class="card-header"><h3><i class="fa fa-bolt" style="color:var(--gold);margin-right:0.4rem;"></i>Quick Actions</h3></div>
    <div class="card-body" style="display:flex;flex-wrap:wrap;gap:0.75rem;">
        <a href="<?php echo e(route('admin.news.create')); ?>"    class="btn btn-forest"><i class="fa fa-plus"></i> New Article</a>
        <a href="<?php echo e(route('admin.jobs.create')); ?>"    class="btn btn-forest"><i class="fa fa-plus"></i> Post a Job</a>
        <a href="<?php echo e(route('admin.tenders.create')); ?>" class="btn btn-forest"><i class="fa fa-plus"></i> Add Tender</a>
        <a href="<?php echo e(route('admin.announcements.create')); ?>" class="btn btn-outline"><i class="fa fa-bullhorn"></i> Announcement</a>
        <a href="<?php echo e(route('admin.leave.index')); ?>" class="btn btn-outline"><i class="fa fa-calendar"></i>
            Leave Requests <?php if($stats['pending_leave'] > 0): ?><span class="badge badge-red" style="margin-left:4px;"><?php echo e($stats['pending_leave']); ?></span><?php endif; ?>
        </a>
        <?php if($stats['unread_messages'] > 0): ?>
        <a href="<?php echo e(route('admin.messages.index')); ?>" class="btn btn-gold">
            <i class="fa fa-envelope"></i> <?php echo e($stats['unread_messages']); ?> Unread
        </a>
        <?php endif; ?>
    </div>
</div>


<div class="section-label" style="display:flex;align-items:center;justify-content:space-between;">
    <span>Operations Overview</span>
    <span id="kpi-refresh-status" style="font-size:.72rem;color:var(--slate-mid);font-weight:400;">
        <i class="fa fa-circle-notch fa-spin" id="kpi-spinner"></i>
        <span id="kpi-timestamp"></span>
    </span>
</div>


<div class="kpi-section-title"><i class="fa fa-users"></i> Human Resources</div>
<div class="stats-grid" style="margin-bottom:1.25rem;">
    <div class="stat-box" onclick="location.href='<?php echo e(route('admin.employees.index')); ?>'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--blue"><i class="fa fa-id-badge"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="hr.active_employees"><?php echo e(number_format($stats['total_employees'])); ?></div>
            <div class="stat-box__label">Active Employees</div>
            <div class="stat-box__sub" data-kpi-sub="hr.on_leave_today"><?php echo e($stats['on_leave_today']); ?> on leave today</div>
        </div>
    </div>
    <div class="stat-box <?php echo e($stats['pending_leave'] > 0 ? 'stat-box--alert' : ''); ?>" onclick="location.href='<?php echo e(route('admin.leave.index')); ?>?status=pending'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--gold"><i class="fa fa-calendar-minus"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="hr.pending_leave"><?php echo e(number_format($stats['pending_leave'])); ?></div>
            <div class="stat-box__label">Pending Leave</div>
            <div class="stat-box__sub">Awaiting approval</div>
        </div>
    </div>
    <div class="stat-box" onclick="location.href='<?php echo e(route('admin.payroll.index')); ?>'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--green"><i class="fa fa-money-bill-wave"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="payroll.last_run_net" data-kpi-format="zmw-k">ZMW <?php echo e(number_format($stats['last_payroll_net']/1000,0)); ?>K</div>
            <div class="stat-box__label">Last Payroll</div>
            <div class="stat-box__sub" data-kpi-sub="payroll.last_run_month"><?php echo e($stats['last_payroll_month']); ?></div>
        </div>
    </div>
    <div class="stat-box" onclick="location.href='<?php echo e(route('admin.portal-accounts.index')); ?>'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--teal"><i class="fa fa-door-open"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="portal.portal_active"><?php echo e(number_format($stats['total_employees'])); ?></div>
            <div class="stat-box__label">Portal Accounts</div>
            <div class="stat-box__sub" data-kpi-sub="portal.never_logged_in-never-logged-in">Active</div>
        </div>
    </div>
</div>


<div class="kpi-section-title"><i class="fa fa-boxes-stacked"></i> Procurement &amp; Inventory</div>
<div class="stats-grid" style="margin-bottom:1.25rem;">
    <div class="stat-box <?php echo e($stats['pending_pos'] > 0 ? 'stat-box--alert' : ''); ?>" onclick="location.href='<?php echo e(route('admin.purchase-orders.index')); ?>'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--gold"><i class="fa fa-file-invoice"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="procurement.pending_pos"><?php echo e(number_format($stats['pending_pos'])); ?></div>
            <div class="stat-box__label">Pending POs</div>
            <div class="stat-box__sub">Awaiting approval</div>
        </div>
    </div>
    <div class="stat-box" onclick="location.href='<?php echo e(route('admin.inventory.index')); ?>'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--blue"><i class="fa fa-warehouse"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="procurement.total_items"><?php echo e(number_format($stats['low_stock'] + $stats['out_of_stock'])); ?></div>
            <div class="stat-box__label">Stock Alerts</div>
            <div class="stat-box__sub" data-kpi-sub="procurement.low_stock-low-stock"><?php echo e($stats['low_stock']); ?> low · <?php echo e($stats['out_of_stock']); ?> out</div>
        </div>
    </div>
    <div class="stat-box" onclick="location.href='<?php echo e(route('admin.suppliers.index')); ?>'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--green"><i class="fa fa-truck"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="procurement.total_suppliers">—</div>
            <div class="stat-box__label">Active Suppliers</div>
            <div class="stat-box__sub">Registered vendors</div>
        </div>
    </div>
    <div class="stat-box" onclick="location.href='<?php echo e(route('admin.inventory.index')); ?>'" style="cursor:pointer;">
        <div class="stat-box__icon stat-box__icon--teal"><i class="fa fa-cubes"></i></div>
        <div>
            <div class="stat-box__num" data-kpi="procurement.inventory_value" data-kpi-format="zmw-k">—</div>
            <div class="stat-box__label">Inventory Value</div>
            <div class="stat-box__sub">Current stock × cost</div>
        </div>
    </div>
</div>


<div class="stats-grid" style="margin-bottom:1.75rem;">
    <div class="kpi-group">
        <div class="kpi-section-title"><i class="fa fa-car"></i> Fleet</div>
        <div class="stats-grid stats-grid--tight">
            <div class="stat-box" onclick="location.href='<?php echo e(route('admin.fleet.vehicles.index')); ?>'" style="cursor:pointer;">
                <div class="stat-box__icon stat-box__icon--teal"><i class="fa fa-car"></i></div>
                <div>
                    <div class="stat-box__num" data-kpi="fleet.active_vehicles"><?php echo e(number_format($stats['active_vehicles'])); ?></div>
                    <div class="stat-box__label">Active Vehicles</div>
                    <div class="stat-box__sub" data-kpi-sub="fleet.total_vehicles-total"><?php echo e($stats['total_vehicles']); ?> total fleet</div>
                </div>
            </div>
            <div class="stat-box <?php echo e($stats['maintenance_due'] > 0 ? 'stat-box--alert' : ''); ?>">
                <div class="stat-box__icon stat-box__icon--red"><i class="fa fa-wrench"></i></div>
                <div>
                    <div class="stat-box__num" data-kpi="fleet.maintenance_due"><?php echo e(number_format($stats['maintenance_due'])); ?></div>
                    <div class="stat-box__label">Maintenance Due</div>
                    <div class="stat-box__sub">Within 14 days</div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-box__icon stat-box__icon--orange"><i class="fa fa-gas-pump"></i></div>
                <div>
                    <div class="stat-box__num" data-kpi="fleet.mtd_fuel_cost" data-kpi-format="zmw-k">—</div>
                    <div class="stat-box__label">MTD Fuel Cost</div>
                    <div class="stat-box__sub" data-kpi-sub="fleet.mtd_fuel_litres-litres">This month</div>
                </div>
            </div>
        </div>
    </div>
    <div class="kpi-group">
        <div class="kpi-section-title"><i class="fa fa-receipt"></i> Finance</div>
        <div class="stats-grid stats-grid--tight">
            <div class="stat-box <?php echo e($stats['pending_expenses'] > 0 ? 'stat-box--alert' : ''); ?>" onclick="location.href='<?php echo e(route('admin.finance.expenses.index')); ?>'" style="cursor:pointer;">
                <div class="stat-box__icon stat-box__icon--red"><i class="fa fa-receipt"></i></div>
                <div>
                    <div class="stat-box__num" data-kpi="finance.pending_count"><?php echo e(number_format($stats['pending_expenses'])); ?></div>
                    <div class="stat-box__label">Pending Expenses</div>
                    <div class="stat-box__sub" data-kpi-sub="finance.pending_amount-zmw">ZMW <?php echo e(number_format($stats['pending_expenses_amount'], 0)); ?></div>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-box__icon stat-box__icon--blue"><i class="fa fa-chart-line"></i></div>
                <div>
                    <div class="stat-box__num" data-kpi="finance.ytd_expenses" data-kpi-format="zmw-k">ZMW <?php echo e(number_format($stats['ytd_expenses']/1000,0)); ?>K</div>
                    <div class="stat-box__label">YTD Expenses</div>
                    <div class="stat-box__sub"><?php echo e(now()->year); ?></div>
                </div>
            </div>
            <div class="stat-box" onclick="location.href='<?php echo e(route('admin.finance.budgets.index')); ?>'" style="cursor:pointer;">
                <div class="stat-box__icon stat-box__icon--green"><i class="fa fa-piggy-bank"></i></div>
                <div>
                    <div class="stat-box__num" data-kpi="finance.total_budget" data-kpi-format="zmw-k">—</div>
                    <div class="stat-box__label">Total Budget</div>
                    <div class="stat-box__sub" data-kpi-sub="finance.total_spent-spent">FY 2025/2026</div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="form-grid form-grid--2" style="gap:1.5rem;margin-bottom:1.5rem;">

    
    <div class="card">
        <div class="card-header">
            <h3><i class="fa fa-newspaper" style="color:var(--forest);margin-right:0.4rem;"></i>Recent Articles</h3>
            <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            <?php if($recentNews->count()): ?>
            <table>
                <thead><tr><th>Title</th><th>Status</th><th>Date</th><th></th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $recentNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="max-width:220px;">
                        <div style="font-weight:600;font-size:0.83rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo e($article->title); ?></div>
                        <div style="font-size:0.75rem;color:var(--slate-mid);"><?php echo e($article->tag); ?></div>
                    </td>
                    <td><span class="badge <?php echo e($article->status === 'published' ? 'badge-green' : 'badge-grey'); ?>"><?php echo e($article->status); ?></span></td>
                    <td style="font-size:0.78rem;color:var(--slate-mid);white-space:nowrap;"><?php echo e($article->created_at->format('d M Y')); ?></td>
                    <td><a href="<?php echo e(route('admin.news.edit', $article)); ?>" class="btn btn-outline btn-sm btn-icon"><i class="fa fa-pen"></i></a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state"><i class="fa fa-newspaper"></i><p>No articles yet.</p></div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h3><i class="fa fa-calendar-minus" style="color:var(--forest);margin-right:0.4rem;"></i>
                Pending Leave
                <?php if($stats['pending_leave'] > 0): ?><span class="badge badge-red" style="margin-left:6px;"><?php echo e($stats['pending_leave']); ?></span><?php endif; ?>
            </h3>
            <a href="<?php echo e(route('admin.leave.index')); ?>" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            <?php if($recentLeave->count()): ?>
            <table>
                <thead><tr><th>Employee</th><th>Type</th><th>Dates</th><th></th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $recentLeave; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:.83rem;"><?php echo e($lr->employee->full_name ?? '—'); ?></div>
                        <div style="font-size:.72rem;color:var(--slate-mid);"><?php echo e($lr->employee->department->name ?? ''); ?></div>
                    </td>
                    <td style="font-size:.82rem;"><?php echo e($lr->leaveType->name ?? '—'); ?></td>
                    <td style="font-size:.78rem;color:var(--slate-mid);">
                        <?php echo e($lr->start_date?->format('d M')); ?> – <?php echo e($lr->end_date?->format('d M')); ?>

                        <div style="font-size:.7rem;">(<?php echo e($lr->days_requested); ?> days)</div>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.leave.index')); ?>" class="btn btn-outline btn-xs"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state"><i class="fa fa-calendar-check"></i><p>No pending leave requests.</p></div>
            <?php endif; ?>
        </div>
    </div>

</div>

<div class="form-grid form-grid--2" style="gap:1.5rem;margin-bottom:1.5rem;">

    
    <div class="card">
        <div class="card-header">
            <h3><i class="fa fa-receipt" style="color:var(--forest);margin-right:0.4rem;"></i>Recent Expenses</h3>
            <a href="<?php echo e(route('admin.finance.expenses.index')); ?>" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            <?php if($recentExpenses->count()): ?>
            <table>
                <thead><tr><th>Description</th><th>Dept</th><th>Amount</th><th>Status</th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $recentExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $sc = ['submitted'=>'badge-gold','approved'=>'badge-blue','paid'=>'badge-success','rejected'=>'badge-red','draft'=>'badge-grey'][$exp->status] ?? 'badge-grey'; ?>
                <tr>
                    <td style="font-size:.83rem;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo e($exp->description); ?></td>
                    <td style="font-size:.75rem;color:var(--slate-mid);"><?php echo e($exp->department->name ?? '—'); ?></td>
                    <td style="font-weight:600;font-size:.83rem;white-space:nowrap;">ZMW <?php echo e(number_format($exp->amount, 0)); ?></td>
                    <td><span class="badge <?php echo e($sc); ?>"><?php echo e(ucfirst($exp->status)); ?></span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state"><i class="fa fa-receipt"></i><p>No expenses yet.</p></div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h3><i class="fa fa-envelope" style="color:var(--forest);margin-right:0.4rem;"></i>Recent Messages</h3>
            <a href="<?php echo e(route('admin.messages.index')); ?>" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            <?php if($recentMessages->count()): ?>
            <table>
                <thead><tr><th>From</th><th>Subject</th><th>Date</th><th></th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $recentMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="<?php echo e(!$msg->read ? 'background:#FFFDF5;' : ''); ?>">
                    <td>
                        <div style="font-weight:<?php echo e($msg->read ? '400' : '700'); ?>;font-size:.83rem;"><?php echo e($msg->name); ?></div>
                        <div style="font-size:.75rem;color:var(--slate-mid);"><?php echo e($msg->email); ?></div>
                    </td>
                    <td style="font-size:.83rem;max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        <?php if(!$msg->read): ?><span style="display:inline-block;width:7px;height:7px;background:var(--gold);border-radius:50%;margin-right:5px;vertical-align:middle;"></span><?php endif; ?>
                        <?php echo e($msg->subject); ?>

                    </td>
                    <td style="font-size:.78rem;color:var(--slate-mid);white-space:nowrap;"><?php echo e($msg->created_at->format('d M')); ?></td>
                    <td><a href="<?php echo e(route('admin.messages.show', $msg)); ?>" class="btn btn-outline btn-sm btn-icon"><i class="fa fa-eye"></i></a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state"><i class="fa fa-envelope"></i><p>No messages yet.</p></div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php $__env->startPush('styles'); ?>
<style>
.section-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--slate-mid);
    margin-bottom: .75rem;
}
.kpi-section-title {
    font-size: .78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--forest);
    margin-bottom: .5rem;
    display: flex;
    align-items: center;
    gap: .4rem;
}
.kpi-group { display: flex; flex-direction: column; }
.stats-grid--tight { gap: .75rem; }
.stat-box--alert { border-left: 3px solid var(--gold) !important; }
.stat-box { cursor: default; transition: box-shadow .15s, transform .1s; }
.stat-box:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); transform: translateY(-1px); }
.text-warning { color: var(--gold) !important; font-weight: 600; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const KPI_URL = '<?php echo e(route('admin.api.kpis')); ?>';
let kpiTimer;

function fmt(val, format) {
    const n = parseFloat(val) || 0;
    if (format === 'zmw-k') return 'ZMW ' + (n / 1000).toFixed(0) + 'K';
    return n.toLocaleString();
}

function getNestedVal(obj, path) {
    return path.split('.').reduce((o, k) => (o && o[k] !== undefined ? o[k] : null), obj);
}

function refreshKpis() {
    const spinner = document.getElementById('kpi-spinner');
    if (spinner) spinner.style.display = 'inline-block';

    fetch(KPI_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            // Update all [data-kpi] elements
            document.querySelectorAll('[data-kpi]').forEach(el => {
                const key    = el.dataset.kpi;
                const format = el.dataset.kpiFormat || '';
                const val    = getNestedVal(data, key);
                if (val !== null) el.textContent = format ? fmt(val, format) : Number(val).toLocaleString();
            });

            // Update alert highlights
            const pendingLeave = getNestedVal(data, 'hr.pending_leave') || 0;
            document.querySelectorAll('[data-kpi="hr.pending_leave"]').forEach(el => {
                el.closest('.stat-box')?.classList.toggle('stat-box--alert', pendingLeave > 0);
            });
            const pendingPos = getNestedVal(data, 'procurement.pending_pos') || 0;
            document.querySelectorAll('[data-kpi="procurement.pending_pos"]').forEach(el => {
                el.closest('.stat-box')?.classList.toggle('stat-box--alert', pendingPos > 0);
            });
            const pendingExp = getNestedVal(data, 'finance.pending_count') || 0;
            document.querySelectorAll('[data-kpi="finance.pending_count"]').forEach(el => {
                el.closest('.stat-box')?.classList.toggle('stat-box--alert', pendingExp > 0);
            });

            // Timestamp
            const ts = document.getElementById('kpi-timestamp');
            if (ts) ts.textContent = 'Updated ' + new Date().toLocaleTimeString();
            if (spinner) spinner.style.display = 'none';
        })
        .catch(() => {
            if (spinner) spinner.style.display = 'none';
        });
}

// Initial load + refresh every 90 seconds
document.addEventListener('DOMContentLoaded', function () {
    refreshKpis();
    kpiTimer = setInterval(refreshKpis, 90000);
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>