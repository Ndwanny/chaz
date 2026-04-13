# CHAZ Admin Panel — Drop-in Package

Full-featured role-based admin panel for the CHAZ (Churches Health Association of Zambia) Laravel application.

---

## What's Included

| Module | Features |
|--------|----------|
| **System** | Users, Roles & Permissions (RBAC), Departments |
| **HR** | Employees (full profile), Leave management, Performance reviews |
| **Payroll** | Salary grades, components, payroll runs, payslips (ZRA PAYE, NAPSA, NHIMA) |
| **Procurement** | Requisitions, Purchase Orders, Suppliers |
| **Inventory** | Items, Categories, Warehouses, Stock movements |
| **Fleet** | Vehicles, Insurance, Trip logs, Fuel logs, Maintenance, Driver assignments |
| **Finance** | Budget periods, Budgets, Budget lines, Expenses |
| **Communications** | Announcements (priority, audience targeting) |
| **Reports** | HR, Payroll, Fleet, Finance reports + Audit log |

---

## File Map

```
chaz-admin-panel/
├── app/Helpers/admin_helpers.php           → app/Helpers/admin_helpers.php
├── app/Http/Controllers/Admin/             → app/Http/Controllers/Admin/  (19 controllers)
├── app/Http/Middleware/AdminAuthenticate.php → app/Http/Middleware/AdminAuthenticate.php (REPLACE)
├── app/Models/Admin.php                    → app/Models/Admin.php (REPLACE)
├── app/Models/[35 new model files]         → app/Models/
├── database/migrations/[39 files]         → database/migrations/
├── database/seeders/[4 files]             → database/seeders/
├── database/chaz_full_schema.sql          (optional: run directly in MySQL)
├── public/css/admin.css                   → public/css/admin.css
├── resources/views/admin/layouts/app.blade.php  → (REPLACE)
├── resources/views/admin/auth/login.blade.php   → (REPLACE)
├── resources/views/admin/dashboard.blade.php    → (REPLACE)
└── resources/views/admin/[all modules]    → resources/views/admin/
```

---

## Installation Steps

### 1. Copy all files (mirror the paths above)

### 2. Register the helper in `composer.json`

```json
"autoload": {
    "files": [
        "app/Helpers/admin_helpers.php"
    ]
}
```

```bash
composer dump-autoload
```

### 3. Register middleware in `app/Http/Kernel.php`

```php
protected $routeMiddleware = [
    'admin.auth' => \App\Http\Middleware\AdminAuthenticate::class,
];
```

### 4. Add routes

Copy all routes from `ROUTES_SNIPPET.php` into your `routes/web.php`, inside the existing admin middleware group.

### 5. Run migrations and seeders

```bash
php artisan migrate
php artisan db:seed --class=AdminPanelSeeder
```

**Seeder creates:**
- 41 permissions in 11 groups
- 19 departments (HQ + 10 provincial offices)
- 16 roles with permission assignments
- `super_admin` role assigned to first admin account
- Salary grades SG-A1 through SG-E2, salary components (HA 30%, TA 10%, MA 5%, LA fixed, NAPSA 5%, NHIMA 1%, PAYE)
- Leave types: Annual (24d), Sick (14d), Maternity (84d), Paternity (5d), Compassionate (5d), Study (10d), Unpaid
- Vehicle categories, expense categories, item categories
- HQ warehouse, active 2025/2026 budget period

### 6. Storage link

```bash
php artisan storage:link
```

---

## Default Roles & Access Levels

| Role | Level | Key Permissions |
|------|-------|-----------------|
| super_admin | 1 | All permissions |
| admin | 2 | System + all modules |
| director | 3 | View all, approve finance/procurement |
| board_member | 3 | View reports, approve budgets |
| hr_manager | 4 | Manage employees, leave, payroll |
| hr_officer | 5 | Manage employees, leave |
| finance_manager | 4 | Manage finance, view procurement |
| finance_officer | 5 | Manage expenses |
| accountant | 5 | View payroll, manage expenses |
| procurement_officer | 5 | Manage procurement, inventory |
| fleet_manager | 5 | Manage fleet |
| driver | 8 | View trips only |
| it_officer | 5 | System view, manage content |
| communications_officer | 6 | Manage content/comms |
| programme_manager | 6 | View employees, finance |
| employee | 10 | View announcements, own payslips |

---

## Architecture

- **Auth**: Session-based — `admin_id`, `admin_name`, `admin_role`, `admin_permissions` (array of permission slugs)
- **RBAC**: Custom (no Spatie) — permissions loaded once at login from DB, stored in session
- **Permission check in Blade**: `@if(admin_can('manage_employees'))` via global helper
- **Permission check in PHP**: `admin_can('slug')` or `in_array('slug', session('admin_permissions', []))`
- **Currency**: ZMW — use `format_zmw($amount)` helper
- **Auto-numbering**: `PO-YYYY-0001`, `REQ-YYYY-0001`, `EXP-YYYY-0001`, `TRIP-YYYY-0001`
- **Payroll**: NAPSA 5% employee + 5% employer, NHIMA 1% + 1%, PAYE via configurable tax component
- **Soft deletes**: Employee model (deleted employees preserved in DB)
- **Audit log**: All create/update/delete/approve actions recorded in `audit_logs` table
