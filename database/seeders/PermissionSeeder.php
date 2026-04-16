<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('permissions')->exists()) {
            return;
        }

        $permissions = [
            // Dashboard
            ['group' => 'dashboard',     'name' => 'View Dashboard',              'slug' => 'view_dashboard'],
            // Users & System
            ['group' => 'system',        'name' => 'Manage Users',                'slug' => 'manage_users'],
            ['group' => 'system',        'name' => 'Manage Roles',                'slug' => 'manage_roles'],
            ['group' => 'system',        'name' => 'Manage System Settings',      'slug' => 'manage_system'],
            ['group' => 'system',        'name' => 'Manage Site Settings',        'slug' => 'manage_settings'],
            // Employees
            ['group' => 'employees',     'name' => 'Manage Employees',            'slug' => 'manage_employees'],
            ['group' => 'employees',     'name' => 'View Employees',              'slug' => 'view_employees'],
            ['group' => 'employees',     'name' => 'Manage Departments',          'slug' => 'manage_departments'],
            // HR
            ['group' => 'hr',            'name' => 'Manage Leave Requests',       'slug' => 'manage_leave'],
            ['group' => 'hr',            'name' => 'Approve Leave Requests',      'slug' => 'approve_leave'],
            ['group' => 'hr',            'name' => 'Manage Leave Types',          'slug' => 'manage_leave_types'],
            ['group' => 'hr',            'name' => 'Manage Performance Reviews',  'slug' => 'manage_performance'],
            // Payroll
            ['group' => 'payroll',       'name' => 'Manage Payroll',              'slug' => 'manage_payroll'],
            ['group' => 'payroll',       'name' => 'View Payroll',                'slug' => 'view_payroll'],
            ['group' => 'payroll',       'name' => 'View Own Payslip',            'slug' => 'view_own_payslip'],
            ['group' => 'payroll',       'name' => 'Manage Salary Grades',        'slug' => 'manage_salary_grades'],
            ['group' => 'payroll',       'name' => 'Manage Salary Components',    'slug' => 'manage_salary_components'],
            // Procurement
            ['group' => 'procurement',   'name' => 'Manage Inventory',            'slug' => 'manage_inventory'],
            ['group' => 'procurement',   'name' => 'Manage Suppliers',            'slug' => 'manage_suppliers'],
            ['group' => 'procurement',   'name' => 'Manage Purchase Orders',      'slug' => 'manage_purchase_orders'],
            ['group' => 'procurement',   'name' => 'Approve Purchase Orders',     'slug' => 'approve_purchase_orders'],
            ['group' => 'procurement',   'name' => 'Manage Requisitions',         'slug' => 'manage_requisitions'],
            // Fleet
            ['group' => 'fleet',         'name' => 'Manage Fleet/Vehicles',       'slug' => 'manage_fleet'],
            ['group' => 'fleet',         'name' => 'Manage Fuel Logs',            'slug' => 'manage_fuel'],
            ['group' => 'fleet',         'name' => 'Manage Maintenance Records',  'slug' => 'manage_maintenance'],
            ['group' => 'fleet',         'name' => 'Manage Trip Logs',            'slug' => 'manage_trips'],
            ['group' => 'fleet',         'name' => 'View Own Trip Logs',          'slug' => 'view_own_trips'],
            ['group' => 'fleet',         'name' => 'Manage Driver Assignments',   'slug' => 'manage_assignments'],
            // Finance
            ['group' => 'finance',       'name' => 'Manage Budgets',              'slug' => 'manage_budgets'],
            ['group' => 'finance',       'name' => 'View Budgets',                'slug' => 'view_budgets'],
            ['group' => 'finance',       'name' => 'Manage Expenses',             'slug' => 'manage_expenses'],
            ['group' => 'finance',       'name' => 'Approve Expenses',            'slug' => 'approve_expenses'],
            // Content (existing modules)
            ['group' => 'content',       'name' => 'Manage News Articles',        'slug' => 'manage_news'],
            ['group' => 'content',       'name' => 'Manage Job Postings',         'slug' => 'manage_jobs'],
            ['group' => 'content',       'name' => 'Manage Tenders',              'slug' => 'manage_tenders'],
            ['group' => 'content',       'name' => 'Manage Members',              'slug' => 'manage_members'],
            ['group' => 'content',       'name' => 'Manage Downloads',            'slug' => 'manage_downloads'],
            // Communications
            ['group' => 'comms',         'name' => 'Manage Announcements',        'slug' => 'manage_announcements'],
            ['group' => 'comms',         'name' => 'View Contact Messages',       'slug' => 'view_messages'],
            // Reports
            ['group' => 'reports',       'name' => 'View Reports',                'slug' => 'view_reports'],
        ];

        foreach ($permissions as $p) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => $p['slug']],
                array_merge($p, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
