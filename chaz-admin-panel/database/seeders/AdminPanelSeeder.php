<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminPanelSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions first (no dependencies)
        $this->call(PermissionSeeder::class);
        $this->command->info('✓ Permissions seeded');

        // 2. Departments (no dependencies)
        $this->call(DepartmentSeeder::class);
        $this->command->info('✓ Departments seeded');

        // 3. Roles + assign permissions
        $this->call(RoleSeeder::class);
        $this->command->info('✓ Roles seeded');

        // 4. Assign super_admin role to existing admin
        $superAdminRole = DB::table('roles')->where('slug', 'super_admin')->first();
        $execDept       = DB::table('departments')->where('code', 'EXEC')->first();
        if ($superAdminRole && $execDept) {
            DB::table('admins')->where('role', 'superadmin')->update([
                'role_id'       => $superAdminRole->id,
                'department_id' => $execDept->id,
                'staff_id'      => 'CHAZ-0001',
                'is_active'     => true,
            ]);
        }
        $this->command->info('✓ Existing superadmin assigned super_admin role');

        // 5. Salary grades
        $grades = [
            ['code' => 'SG-A1', 'name' => 'Grade A1 — Executive Director',      'min_salary' => 35000, 'max_salary' => 55000, 'basic_salary' => 45000],
            ['code' => 'SG-A2', 'name' => 'Grade A2 — Director',                'min_salary' => 28000, 'max_salary' => 42000, 'basic_salary' => 35000],
            ['code' => 'SG-B1', 'name' => 'Grade B1 — Senior Manager',          'min_salary' => 20000, 'max_salary' => 30000, 'basic_salary' => 25000],
            ['code' => 'SG-B2', 'name' => 'Grade B2 — Manager',                 'min_salary' => 15000, 'max_salary' => 22000, 'basic_salary' => 18000],
            ['code' => 'SG-C1', 'name' => 'Grade C1 — Senior Officer',          'min_salary' => 10000, 'max_salary' => 16000, 'basic_salary' => 13000],
            ['code' => 'SG-C2', 'name' => 'Grade C2 — Officer',                 'min_salary' =>  7000, 'max_salary' => 12000, 'basic_salary' =>  9500],
            ['code' => 'SG-D1', 'name' => 'Grade D1 — Senior Assistant',        'min_salary' =>  5000, 'max_salary' =>  8000, 'basic_salary' =>  6500],
            ['code' => 'SG-D2', 'name' => 'Grade D2 — Assistant',               'min_salary' =>  3500, 'max_salary' =>  6000, 'basic_salary' =>  4500],
            ['code' => 'SG-E1', 'name' => 'Grade E1 — Support Staff',           'min_salary' =>  2500, 'max_salary' =>  4500, 'basic_salary' =>  3500],
            ['code' => 'SG-E2', 'name' => 'Grade E2 — General / Casual',        'min_salary' =>  1800, 'max_salary' =>  3000, 'basic_salary' =>  2200],
        ];
        foreach ($grades as $g) {
            DB::table('salary_grades')->updateOrInsert(['code' => $g['code']], array_merge($g, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }
        $this->command->info('✓ Salary grades seeded');

        // 6. Salary components (ZRA PAYE bands approximated, NAPSA statutory)
        $components = [
            // Allowances
            ['code' => 'HA',    'name' => 'Housing Allowance',     'type' => 'allowance',  'calculation_type' => 'percentage', 'value' => 30.00, 'is_taxable' => true,  'is_mandatory' => true,  'sort_order' => 1],
            ['code' => 'TA',    'name' => 'Transport Allowance',   'type' => 'allowance',  'calculation_type' => 'percentage', 'value' => 10.00, 'is_taxable' => false, 'is_mandatory' => true,  'sort_order' => 2],
            ['code' => 'MA',    'name' => 'Medical Allowance',     'type' => 'allowance',  'calculation_type' => 'percentage', 'value' =>  5.00, 'is_taxable' => false, 'is_mandatory' => false, 'sort_order' => 3],
            ['code' => 'LA',    'name' => 'Lunch Allowance',       'type' => 'allowance',  'calculation_type' => 'fixed',      'value' => 800,   'is_taxable' => false, 'is_mandatory' => false, 'sort_order' => 4],
            // Deductions
            ['code' => 'NAPSA', 'name' => 'NAPSA Contribution',    'type' => 'deduction',  'calculation_type' => 'percentage', 'value' =>  5.00, 'is_taxable' => false, 'is_mandatory' => true,  'sort_order' => 10],
            ['code' => 'NHIMA', 'name' => 'NHIMA Contribution',    'type' => 'deduction',  'calculation_type' => 'percentage', 'value' =>  1.00, 'is_taxable' => false, 'is_mandatory' => true,  'sort_order' => 11],
            // Tax (computed separately in payroll run)
            ['code' => 'PAYE',  'name' => 'PAYE (Income Tax)',     'type' => 'tax',        'calculation_type' => 'percentage', 'value' =>  0.00, 'is_taxable' => false, 'is_mandatory' => true,  'sort_order' => 20],
        ];
        foreach ($components as $c) {
            DB::table('salary_components')->updateOrInsert(['code' => $c['code']], array_merge($c, ['is_active' => true, 'applies_to' => 'all', 'description' => null, 'created_at' => now(), 'updated_at' => now()]));
        }
        $this->command->info('✓ Salary components seeded');

        // 7. Leave types
        $leaveTypes = [
            ['code' => 'AL',  'name' => 'Annual Leave',        'days_allowed' => 24, 'is_paid' => true,  'gender_specific' => 'all',    'requires_document' => false],
            ['code' => 'SL',  'name' => 'Sick Leave',          'days_allowed' => 14, 'is_paid' => true,  'gender_specific' => 'all',    'requires_document' => true],
            ['code' => 'ML',  'name' => 'Maternity Leave',     'days_allowed' => 84, 'is_paid' => true,  'gender_specific' => 'female', 'requires_document' => true],
            ['code' => 'PTL', 'name' => 'Paternity Leave',     'days_allowed' =>  5, 'is_paid' => true,  'gender_specific' => 'male',   'requires_document' => false],
            ['code' => 'CL',  'name' => 'Compassionate Leave', 'days_allowed' =>  5, 'is_paid' => true,  'gender_specific' => 'all',    'requires_document' => true],
            ['code' => 'STL', 'name' => 'Study Leave',         'days_allowed' => 10, 'is_paid' => false, 'gender_specific' => 'all',    'requires_document' => true],
            ['code' => 'UL',  'name' => 'Unpaid Leave',        'days_allowed' =>  0, 'is_paid' => false, 'gender_specific' => 'all',    'requires_document' => false],
        ];
        foreach ($leaveTypes as $lt) {
            DB::table('leave_types')->updateOrInsert(['code' => $lt['code']], array_merge($lt, ['is_active' => true, 'accrues_monthly' => false, 'description' => null, 'created_at' => now(), 'updated_at' => now()]));
        }
        $this->command->info('✓ Leave types seeded');

        // 8. Vehicle categories
        $vehicleCats = [
            ['name' => 'Land Cruiser / 4x4'],
            ['name' => 'Pickup Truck'],
            ['name' => 'Station Wagon'],
            ['name' => 'Sedan / Saloon'],
            ['name' => 'Minibus'],
            ['name' => 'Motorcycle'],
            ['name' => 'Ambulance'],
            ['name' => 'Generator / Equipment'],
        ];
        foreach ($vehicleCats as $vc) {
            DB::table('vehicle_categories')->updateOrInsert(['name' => $vc['name']], array_merge($vc, ['is_active' => true, 'description' => null, 'created_at' => now(), 'updated_at' => now()]));
        }
        $this->command->info('✓ Vehicle categories seeded');

        // 9. Expense categories
        $expenseCats = [
            ['code' => 'TRAVEL',  'name' => 'Travel & Transport'],
            ['code' => 'ACCOM',   'name' => 'Accommodation'],
            ['code' => 'MEALS',   'name' => 'Meals & Entertainment'],
            ['code' => 'OFFICE',  'name' => 'Office Supplies'],
            ['code' => 'IT',      'name' => 'IT & Technology'],
            ['code' => 'MEDICAL', 'name' => 'Medical Expenses'],
            ['code' => 'TRAINING','name' => 'Training & Development'],
            ['code' => 'UTILITY', 'name' => 'Utilities'],
            ['code' => 'MAINT',   'name' => 'Maintenance & Repairs'],
            ['code' => 'MISC',    'name' => 'Miscellaneous'],
        ];
        foreach ($expenseCats as $ec) {
            DB::table('expense_categories')->updateOrInsert(['code' => $ec['code']], array_merge($ec, ['is_active' => true, 'description' => null, 'created_at' => now(), 'updated_at' => now()]));
        }
        $this->command->info('✓ Expense categories seeded');

        // 10. Item categories
        $itemCats = [
            ['code' => 'MED',    'name' => 'Medical Supplies'],
            ['code' => 'OFF',    'name' => 'Office Stationery & Supplies'],
            ['code' => 'IT',     'name' => 'IT Equipment & Consumables'],
            ['code' => 'FUEL',   'name' => 'Fuel & Lubricants'],
            ['code' => 'CLEAN',  'name' => 'Cleaning & Hygiene'],
            ['code' => 'PRINT',  'name' => 'Printing & Photocopying'],
            ['code' => 'FURN',   'name' => 'Furniture & Fixtures'],
            ['code' => 'FOOD',   'name' => 'Food & Beverages'],
            ['code' => 'SPARE',  'name' => 'Vehicle Spare Parts'],
            ['code' => 'OTHER',  'name' => 'Other'],
        ];
        foreach ($itemCats as $ic) {
            DB::table('item_categories')->updateOrInsert(['code' => $ic['code']], array_merge($ic, ['is_active' => true, 'description' => null, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()]));
        }
        $this->command->info('✓ Item categories seeded');

        // 11. Warehouses
        DB::table('warehouses')->updateOrInsert(['code' => 'WH-HQ'], [
            'name' => 'Headquarters Store — Lusaka', 'code' => 'WH-HQ',
            'location' => 'Plot 4669, Mosi-o-Tunya Road, Lusaka',
            'is_active' => true, 'description' => null, 'department_id' => null,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $this->command->info('✓ Warehouses seeded');

        // 12. Active budget period
        DB::table('budget_periods')->updateOrInsert(['financial_year' => '2025/2026'], [
            'name' => 'Financial Year 2025/2026', 'financial_year' => '2025/2026',
            'start_date' => '2025-01-01', 'end_date' => '2025-12-31',
            'is_active' => true, 'is_locked' => false, 'description' => 'Current financial year',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $this->command->info('✓ Budget period seeded');

        $this->command->info('');
        $this->command->info('✅ CHAZ Admin Panel seeding complete!');
        $this->command->info('   Login: admin@chaz.org.zm / Chaz@2024!');
    }
}
