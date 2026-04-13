<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['slug' => 'super_admin',           'name' => 'Super Administrator',     'level' => 10, 'description' => 'Full unrestricted access to all modules and settings'],
            ['slug' => 'admin',                 'name' => 'Administrator',            'level' => 9,  'description' => 'Full access except system configuration'],
            ['slug' => 'director',              'name' => 'Director',                 'level' => 8,  'description' => 'Executive-level oversight across departments'],
            ['slug' => 'board_member',          'name' => 'Board Member',             'level' => 7,  'description' => 'Governance-level access — dashboard and reports only'],
            ['slug' => 'hr_manager',            'name' => 'HR Manager',               'level' => 6,  'description' => 'Full HR module access including payroll view'],
            ['slug' => 'finance_manager',       'name' => 'Finance Manager',          'level' => 6,  'description' => 'Full finance and payroll access'],
            ['slug' => 'it_officer',            'name' => 'IT Officer',               'level' => 6,  'description' => 'User management and system administration'],
            ['slug' => 'accountant',            'name' => 'Accountant',               'level' => 5,  'description' => 'Payroll processing and expense management'],
            ['slug' => 'procurement_officer',   'name' => 'Procurement Officer',      'level' => 5,  'description' => 'Inventory, suppliers, and purchase order management'],
            ['slug' => 'fleet_manager',         'name' => 'Fleet Manager',            'level' => 5,  'description' => 'Full fleet management — vehicles, fuel, maintenance, trips'],
            ['slug' => 'programme_manager',     'name' => 'Programme Manager',        'level' => 5,  'description' => 'Programme-level reporting and announcements'],
            ['slug' => 'hr_officer',            'name' => 'HR Officer',               'level' => 4,  'description' => 'Employee records and leave management'],
            ['slug' => 'finance_officer',       'name' => 'Finance Officer',          'level' => 4,  'description' => 'Expense recording and payroll view'],
            ['slug' => 'communications_officer','name' => 'Communications Officer',   'level' => 4,  'description' => 'News, downloads, and announcements management'],
            ['slug' => 'driver',                'name' => 'Driver',                   'level' => 2,  'description' => 'Own trip logs only'],
            ['slug' => 'employee',              'name' => 'Employee',                 'level' => 1,  'description' => 'Own payslips and leave requests'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $role['slug']],
                array_merge($role, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }

        // Assign permissions to roles
        $allPermissions = DB::table('permissions')->pluck('id', 'slug');

        $rolePermissions = [
            'super_admin'          => $allPermissions->keys()->all(),
            'admin'                => $allPermissions->keys()->reject(fn($s) => in_array($s, ['manage_system']))->all(),
            'director'             => ['view_dashboard','view_employees','manage_leave','approve_leave','view_payroll','view_budgets','view_reports','manage_announcements'],
            'board_member'         => ['view_dashboard','view_reports'],
            'hr_manager'           => ['view_dashboard','manage_employees','view_employees','manage_leave','approve_leave','manage_leave_types','manage_performance','view_payroll','view_reports','manage_announcements','manage_departments'],
            'finance_manager'      => ['view_dashboard','manage_payroll','view_payroll','manage_budgets','view_budgets','manage_expenses','approve_expenses','view_reports','manage_salary_grades','manage_salary_components'],
            'it_officer'           => ['view_dashboard','manage_users','manage_roles','manage_system'],
            'accountant'           => ['view_dashboard','manage_payroll','view_payroll','manage_expenses','view_reports'],
            'procurement_officer'  => ['view_dashboard','manage_inventory','manage_suppliers','manage_purchase_orders','approve_purchase_orders','manage_requisitions'],
            'fleet_manager'        => ['view_dashboard','manage_fleet','manage_fuel','manage_maintenance','manage_trips','manage_assignments'],
            'programme_manager'    => ['view_dashboard','view_reports','manage_announcements'],
            'hr_officer'           => ['view_dashboard','manage_employees','view_employees','manage_leave'],
            'finance_officer'      => ['view_dashboard','view_payroll','manage_expenses'],
            'communications_officer'=> ['view_dashboard','manage_news','manage_announcements','manage_downloads'],
            'driver'               => ['view_dashboard','view_own_trips'],
            'employee'             => ['view_dashboard','view_own_payslip','manage_leave'],
        ];

        foreach ($rolePermissions as $roleSlug => $permSlugs) {
            $role = DB::table('roles')->where('slug', $roleSlug)->first();
            if (!$role) continue;

            // Clear existing
            DB::table('role_permissions')->where('role_id', $role->id)->delete();

            foreach ($permSlugs as $slug) {
                if (isset($allPermissions[$slug])) {
                    DB::table('role_permissions')->insertOrIgnore([
                        'role_id'       => $role->id,
                        'permission_id' => $allPermissions[$slug],
                    ]);
                }
            }
        }
    }
}
