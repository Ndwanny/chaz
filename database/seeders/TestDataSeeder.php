<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── 1. EMPLOYEES ─────────────────────────────────────────────────────────
        $employeeData = [
            // Executive
            ['first_name'=>'Mwila',      'last_name'=>'Banda',      'gender'=>'male',   'dept'=>1,  'grade'=>1,  'desig'=>'Executive Director',           'type'=>'permanent'],
            ['first_name'=>'Chilufya',   'last_name'=>'Mutale',     'gender'=>'female', 'dept'=>1,  'grade'=>2,  'desig'=>'Deputy Executive Director',    'type'=>'permanent'],
            ['first_name'=>'Precious',   'last_name'=>'Nkonde',     'gender'=>'female', 'dept'=>1,  'grade'=>3,  'desig'=>'Executive Assistant',          'type'=>'permanent'],
            // HR
            ['first_name'=>'Bupe',       'last_name'=>'Ngosa',      'gender'=>'female', 'dept'=>2,  'grade'=>2,  'desig'=>'HR Manager',                   'type'=>'permanent'],
            ['first_name'=>'Kasonde',    'last_name'=>'Mwamba',     'gender'=>'male',   'dept'=>2,  'grade'=>3,  'desig'=>'HR Officer',                   'type'=>'permanent'],
            ['first_name'=>'Naomi',      'last_name'=>'Phiri',      'gender'=>'female', 'dept'=>2,  'grade'=>4,  'desig'=>'HR Assistant',                 'type'=>'contract'],
            // Finance
            ['first_name'=>'Chanda',     'last_name'=>'Tembo',      'gender'=>'male',   'dept'=>3,  'grade'=>2,  'desig'=>'Finance Manager',              'type'=>'permanent'],
            ['first_name'=>'Mutinta',    'last_name'=>'Sikazwe',    'gender'=>'female', 'dept'=>3,  'grade'=>3,  'desig'=>'Senior Accountant',            'type'=>'permanent'],
            ['first_name'=>'Kelvin',     'last_name'=>'Lungu',      'gender'=>'male',   'dept'=>3,  'grade'=>4,  'desig'=>'Accounts Officer',             'type'=>'permanent'],
            ['first_name'=>'Grace',      'last_name'=>'Mulenga',    'gender'=>'female', 'dept'=>3,  'grade'=>5,  'desig'=>'Accounts Assistant',           'type'=>'contract'],
            // IT
            ['first_name'=>'Brian',      'last_name'=>'Mwanza',     'gender'=>'male',   'dept'=>4,  'grade'=>3,  'desig'=>'ICT Manager',                  'type'=>'permanent'],
            ['first_name'=>'Thandiwe',   'last_name'=>'Zulu',       'gender'=>'female', 'dept'=>4,  'grade'=>4,  'desig'=>'Systems Administrator',        'type'=>'permanent'],
            ['first_name'=>'Musonda',    'last_name'=>'Kapasa',     'gender'=>'male',   'dept'=>4,  'grade'=>5,  'desig'=>'ICT Support Officer',          'type'=>'contract'],
            // Comms
            ['first_name'=>'Lweendo',    'last_name'=>'Nawa',       'gender'=>'female', 'dept'=>5,  'grade'=>3,  'desig'=>'Communications Manager',       'type'=>'permanent'],
            ['first_name'=>'Mubanga',    'last_name'=>'Miti',       'gender'=>'male',   'dept'=>5,  'grade'=>4,  'desig'=>'Communications Officer',       'type'=>'permanent'],
            // Programmes
            ['first_name'=>'Winnie',     'last_name'=>'Kabwe',      'gender'=>'female', 'dept'=>6,  'grade'=>2,  'desig'=>'Programmes Director',          'type'=>'permanent'],
            ['first_name'=>'Emmanuel',   'last_name'=>'Mwape',      'gender'=>'male',   'dept'=>6,  'grade'=>3,  'desig'=>'Senior Programme Officer',     'type'=>'permanent'],
            ['first_name'=>'Charity',    'last_name'=>'Chipasha',   'gender'=>'female', 'dept'=>6,  'grade'=>4,  'desig'=>'Programme Officer',            'type'=>'permanent'],
            ['first_name'=>'Joseph',     'last_name'=>'Kaunda',     'gender'=>'male',   'dept'=>6,  'grade'=>4,  'desig'=>'Programme Officer',            'type'=>'contract'],
            ['first_name'=>'Felicia',    'last_name'=>'Chisanga',   'gender'=>'female', 'dept'=>6,  'grade'=>5,  'desig'=>'Programme Assistant',          'type'=>'contract'],
            // Procurement
            ['first_name'=>'Patrick',    'last_name'=>'Mumba',      'gender'=>'male',   'dept'=>7,  'grade'=>3,  'desig'=>'Procurement Manager',          'type'=>'permanent'],
            ['first_name'=>'Doris',      'last_name'=>'Katongo',    'gender'=>'female', 'dept'=>7,  'grade'=>4,  'desig'=>'Procurement Officer',          'type'=>'permanent'],
            ['first_name'=>'Moses',      'last_name'=>'Chipimo',    'gender'=>'male',   'dept'=>7,  'grade'=>5,  'desig'=>'Stores Officer',               'type'=>'permanent'],
            ['first_name'=>'Agness',     'last_name'=>'Mulenga',    'gender'=>'female', 'dept'=>7,  'grade'=>6,  'desig'=>'Stores Assistant',             'type'=>'contract'],
            // Fleet
            ['first_name'=>'Samuel',     'last_name'=>'Sichone',    'gender'=>'male',   'dept'=>8,  'grade'=>4,  'desig'=>'Transport Officer',            'type'=>'permanent'],
            ['first_name'=>'Davison',    'last_name'=>'Phiri',      'gender'=>'male',   'dept'=>8,  'grade'=>6,  'desig'=>'Senior Driver',                'type'=>'permanent'],
            ['first_name'=>'Richard',    'last_name'=>'Banda',      'gender'=>'male',   'dept'=>8,  'grade'=>7,  'desig'=>'Driver',                       'type'=>'permanent'],
            ['first_name'=>'Peter',      'last_name'=>'Mutale',     'gender'=>'male',   'dept'=>8,  'grade'=>7,  'desig'=>'Driver',                       'type'=>'permanent'],
            // Admin
            ['first_name'=>'Susan',      'last_name'=>'Mwila',      'gender'=>'female', 'dept'=>9,  'grade'=>4,  'desig'=>'Administration Officer',       'type'=>'permanent'],
            ['first_name'=>'Caroline',   'last_name'=>'Bwalya',     'gender'=>'female', 'dept'=>9,  'grade'=>5,  'desig'=>'Receptionist',                 'type'=>'permanent'],
            // Provincial
            ['first_name'=>'Ngosa',      'last_name'=>'Kabanda',    'gender'=>'male',   'dept'=>10, 'grade'=>4,  'desig'=>'Provincial Officer – Lusaka',  'type'=>'permanent'],
            ['first_name'=>'Natasha',    'last_name'=>'Chanda',     'gender'=>'female', 'dept'=>11, 'grade'=>4,  'desig'=>'Provincial Officer – CB',      'type'=>'permanent'],
            ['first_name'=>'Andrew',     'last_name'=>'Mwansa',     'gender'=>'male',   'dept'=>12, 'grade'=>4,  'desig'=>'Provincial Officer – Eastern', 'type'=>'permanent'],
            ['first_name'=>'Judy',       'last_name'=>'Zimba',      'gender'=>'female', 'dept'=>13, 'grade'=>5,  'desig'=>'Field Officer – Southern',     'type'=>'contract'],
            ['first_name'=>'Daniel',     'last_name'=>'Musonda',    'gender'=>'male',   'dept'=>14, 'grade'=>5,  'desig'=>'Field Officer – Northern',     'type'=>'contract'],
        ];

        $grades = DB::table('salary_grades')->pluck('basic_salary', 'id');
        $banks  = ['Zanaco', 'Standard Chartered', 'Stanbic', 'Atlas Mara', 'First National Bank', 'Indo Zambia Bank'];
        $provinces = ['Lusaka', 'Copperbelt', 'Eastern', 'Southern', 'Northern', 'Western'];

        $employeeIds = [];
        foreach ($employeeData as $i => $emp) {
            $staffNum   = 'CHAZ-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $hiredAt    = Carbon::now()->subMonths(rand(6, 84))->subDays(rand(0, 30));
            $salary     = $grades[$emp['grade']];
            $dob        = Carbon::now()->subYears(rand(26, 55))->subMonths(rand(0, 11));

            $id = DB::table('employees')->insertGetId([
                'staff_number'                  => $staffNum,
                'first_name'                    => $emp['first_name'],
                'last_name'                     => $emp['last_name'],
                'gender'                        => $emp['gender'],
                'date_of_birth'                 => $dob->toDateString(),
                'national_id'                   => '1' . rand(1000000, 9999999) . '/' . rand(10, 99) . '/' . rand(1, 3),
                'department_id'                 => $emp['dept'],
                'designation'                   => $emp['desig'],
                'employment_type'               => $emp['type'],
                'salary_grade_id'               => $emp['grade'],
                'basic_salary'                  => $salary,
                'bank_name'                     => $banks[array_rand($banks)],
                'bank_account'                  => rand(1000000000, 9999999999),
                'medical_aid_provider'          => rand(0,1) ? 'Madison Life' : 'NHIMA Direct',
                'emergency_contact_name'        => 'Next of Kin',
                'emergency_contact_phone'       => '+2609' . rand(61000000, 79999999),
                'emergency_contact_relationship'=> ['Spouse','Parent','Sibling'][rand(0,2)],
                'address'                       => 'Plot ' . rand(100, 9999) . ', ' . $provinces[array_rand($provinces)],
                'province'                      => $provinces[array_rand($provinces)],
                'district'                      => 'Lusaka District',
                'portal_password'               => Hash::make(strtolower($staffNum)),
                'portal_active'                 => true,
                'status'                        => 'active',
                'hired_at'                      => $hiredAt->toDateString(),
                'contract_start_date'           => $hiredAt->toDateString(),
                'created_at'                    => $now,
                'updated_at'                    => $now,
            ]);

            // Employee salary record
            DB::table('employee_salaries')->insert([
                'employee_id'    => $id,
                'salary_grade_id'=> $emp['grade'],
                'basic_salary'   => $salary,
                'effective_from' => $hiredAt->toDateString(),
                'is_current'     => true,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);

            $employeeIds[] = ['id' => $id, 'dept' => $emp['dept'], 'salary' => $salary, 'staff' => $staffNum];
        }

        // ── 2. LEAVE REQUESTS ─────────────────────────────────────────────────
        $leaveTypes = DB::table('leave_types')->pluck('id')->all();
        $leaveStatuses = ['pending', 'approved', 'approved', 'approved', 'rejected'];

        foreach ($employeeIds as $emp) {
            $numLeaves = rand(1, 3);
            for ($j = 0; $j < $numLeaves; $j++) {
                $start  = Carbon::now()->subDays(rand(10, 180));
                $days   = rand(1, 10);
                $end    = $start->copy()->addDays($days);
                $status = $leaveStatuses[array_rand($leaveStatuses)];
                DB::table('leave_requests')->insert([
                    'employee_id'   => $emp['id'],
                    'leave_type_id' => $leaveTypes[array_rand($leaveTypes)],
                    'start_date'    => $start->toDateString(),
                    'end_date'      => $end->toDateString(),
                    'days_requested'=> $days,
                    'reason'        => ['Family commitment', 'Medical appointment', 'Personal', 'Vacation', 'Annual leave'][rand(0,4)],
                    'status'        => $status,
                    'approved_by'   => $status !== 'pending' ? 1 : null,
                    'approved_at'   => $status !== 'pending' ? $start->copy()->subDays(3)->toDateTimeString() : null,
                    'created_at'    => $start->copy()->subDays(5)->toDateTimeString(),
                    'updated_at'    => $now,
                ]);
            }
        }

        // ── 3. SUPPLIERS ──────────────────────────────────────────────────────
        $suppliersData = [
            ['name'=>'MedPharm Zambia Ltd',           'code'=>'SUP-001', 'category'=>'Medical',    'city'=>'Lusaka',      'terms'=>30, 'rating'=>4.5],
            ['name'=>'Zambia Medical Supplies Ltd',   'code'=>'SUP-002', 'category'=>'Medical',    'city'=>'Lusaka',      'terms'=>30, 'rating'=>4.2],
            ['name'=>'Office World Zambia',           'code'=>'SUP-003', 'category'=>'Stationery', 'city'=>'Lusaka',      'terms'=>14, 'rating'=>3.8],
            ['name'=>'ICT Solutions Zambia',          'code'=>'SUP-004', 'category'=>'IT',         'city'=>'Lusaka',      'terms'=>30, 'rating'=>4.0],
            ['name'=>'Copperbelt Stationery',         'code'=>'SUP-005', 'category'=>'Stationery', 'city'=>'Kitwe',       'terms'=>14, 'rating'=>3.5],
            ['name'=>'Agro & General Supplies',       'code'=>'SUP-006', 'category'=>'General',    'city'=>'Lusaka',      'terms'=>30, 'rating'=>3.2],
            ['name'=>'Toyota Zambia Ltd',             'code'=>'SUP-007', 'category'=>'Vehicles',   'city'=>'Lusaka',      'terms'=>60, 'rating'=>4.8],
            ['name'=>'Total Energies Zambia',         'code'=>'SUP-008', 'category'=>'Fuel',       'city'=>'Lusaka',      'terms'=>14, 'rating'=>4.6],
            ['name'=>'Printrite Zambia',              'code'=>'SUP-009', 'category'=>'Printing',   'city'=>'Ndola',       'terms'=>14, 'rating'=>3.9],
            ['name'=>'Zambeef Products PLC',          'code'=>'SUP-010', 'category'=>'Food',       'city'=>'Lusaka',      'terms'=>7,  'rating'=>4.1],
            ['name'=>'Airtel Zambia Ltd',             'code'=>'SUP-011', 'category'=>'Telecoms',   'city'=>'Lusaka',      'terms'=>30, 'rating'=>3.7],
            ['name'=>'Lafarge Zambia PLC',            'code'=>'SUP-012', 'category'=>'Construction','city'=>'Ndola',      'terms'=>30, 'rating'=>3.6],
        ];

        $supplierIds = [];
        foreach ($suppliersData as $sup) {
            $supplierIds[] = DB::table('suppliers')->insertGetId([
                'name'            => $sup['name'],
                'code'            => $sup['code'],
                'contact_person'  => ['John Mwale', 'Mary Phiri', 'George Banda', 'Anna Tembo', 'Peter Mulenga'][rand(0,4)],
                'email'           => strtolower(str_replace([' ', '&'], ['', ''], $sup['name'])) . '@example.zm',
                'phone'           => '+2609' . rand(61000000, 79999999),
                'address'         => 'Plot ' . rand(100, 9999) . ', ' . $sup['city'],
                'city'            => $sup['city'],
                'country'         => 'Zambia',
                'payment_terms'   => $sup['terms'],
                'rating'          => $sup['rating'],
                'is_active'       => true,
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);
        }

        // ── 4. INVENTORY ITEMS ────────────────────────────────────────────────
        $itemsData = [
            // Medical Supplies (cat 1)
            ['code'=>'ITM-001','name'=>'Paracetamol 500mg (Box/100)',   'cat'=>1,'unit'=>'Box',   'cost'=>45.00, 'stock'=>200,'reorder'=>50],
            ['code'=>'ITM-002','name'=>'Surgical Gloves (Box/100)',     'cat'=>1,'unit'=>'Box',   'cost'=>85.00, 'stock'=>150,'reorder'=>40],
            ['code'=>'ITM-003','name'=>'Hand Sanitiser 5L',             'cat'=>1,'unit'=>'Can',   'cost'=>120.00,'stock'=>80, 'reorder'=>20],
            ['code'=>'ITM-004','name'=>'Face Masks (Box/50)',           'cat'=>1,'unit'=>'Box',   'cost'=>55.00, 'stock'=>100,'reorder'=>30],
            ['code'=>'ITM-005','name'=>'Blood Pressure Monitor',        'cat'=>1,'unit'=>'Unit',  'cost'=>650.00,'stock'=>5,  'reorder'=>2],
            // Stationery (cat 2)
            ['code'=>'ITM-006','name'=>'A4 Paper 80gsm (Ream)',         'cat'=>2,'unit'=>'Ream',  'cost'=>28.00, 'stock'=>300,'reorder'=>100],
            ['code'=>'ITM-007','name'=>'Ball Point Pens (Box/12)',      'cat'=>2,'unit'=>'Box',   'cost'=>18.00, 'stock'=>50, 'reorder'=>20],
            ['code'=>'ITM-008','name'=>'Stapler (Heavy Duty)',          'cat'=>2,'unit'=>'Unit',  'cost'=>75.00, 'stock'=>10, 'reorder'=>3],
            ['code'=>'ITM-009','name'=>'Correction Fluid (Tipp-Ex)',    'cat'=>2,'unit'=>'Piece', 'cost'=>12.00, 'stock'=>30, 'reorder'=>10],
            ['code'=>'ITM-010','name'=>'Lever Arch File',               'cat'=>2,'unit'=>'Piece', 'cost'=>22.00, 'stock'=>80, 'reorder'=>30],
            ['code'=>'ITM-011','name'=>'Manila Envelope (A4, Pk/25)',   'cat'=>2,'unit'=>'Pack',  'cost'=>35.00, 'stock'=>25, 'reorder'=>10],
            // IT (cat 3)
            ['code'=>'ITM-012','name'=>'Laptop Computer (HP EliteBook)','cat'=>3,'unit'=>'Unit',  'cost'=>9500.00,'stock'=>3, 'reorder'=>1],
            ['code'=>'ITM-013','name'=>'Toner Cartridge (HP 85A)',      'cat'=>3,'unit'=>'Unit',  'cost'=>450.00,'stock'=>8,  'reorder'=>3],
            ['code'=>'ITM-014','name'=>'USB Flash Drive 32GB',          'cat'=>3,'unit'=>'Unit',  'cost'=>65.00, 'stock'=>20, 'reorder'=>5],
            ['code'=>'ITM-015','name'=>'Network Cable Cat6 (Roll/50m)', 'cat'=>3,'unit'=>'Roll',  'cost'=>180.00,'stock'=>4,  'reorder'=>2],
            ['code'=>'ITM-016','name'=>'Mouse (Wireless)',               'cat'=>3,'unit'=>'Unit',  'cost'=>95.00, 'stock'=>10, 'reorder'=>3],
            // Fuel (cat 4)
            ['code'=>'ITM-017','name'=>'Diesel (Litre)',                'cat'=>4,'unit'=>'Litre', 'cost'=>27.50, 'stock'=>500,'reorder'=>200],
            ['code'=>'ITM-018','name'=>'Engine Oil 5L',                 'cat'=>4,'unit'=>'Can',   'cost'=>220.00,'stock'=>20, 'reorder'=>5],
            ['code'=>'ITM-019','name'=>'Tyre 235/65R17',                'cat'=>4,'unit'=>'Piece', 'cost'=>1200.00,'stock'=>8, 'reorder'=>4],
            // Cleaning (cat 5)
            ['code'=>'ITM-020','name'=>'Liquid Soap 5L',               'cat'=>5,'unit'=>'Can',   'cost'=>95.00, 'stock'=>30, 'reorder'=>10],
            ['code'=>'ITM-021','name'=>'Toilet Tissue (Roll/48)',       'cat'=>5,'unit'=>'Pack',  'cost'=>120.00,'stock'=>20, 'reorder'=>8],
            ['code'=>'ITM-022','name'=>'Disinfectant 5L (Dettol)',      'cat'=>5,'unit'=>'Can',   'cost'=>110.00,'stock'=>15, 'reorder'=>5],
            // Printing (cat 6)
            ['code'=>'ITM-023','name'=>'Letterhead Paper A4 (500)',     'cat'=>6,'unit'=>'Ream',  'cost'=>85.00, 'stock'=>20, 'reorder'=>5],
            ['code'=>'ITM-024','name'=>'Printed Envelopes (Box/500)',   'cat'=>6,'unit'=>'Box',   'cost'=>180.00,'stock'=>5,  'reorder'=>2],
            // Furniture (cat 7)
            ['code'=>'ITM-025','name'=>'Office Chair (High-Back)',      'cat'=>7,'unit'=>'Unit',  'cost'=>1800.00,'stock'=>2, 'reorder'=>1],
            ['code'=>'ITM-026','name'=>'Office Desk (1.2m)',            'cat'=>7,'unit'=>'Unit',  'cost'=>2200.00,'stock'=>1, 'reorder'=>1],
            // Vehicle Spares (cat 9)
            ['code'=>'ITM-027','name'=>'Air Filter (Toyota LC)',        'cat'=>9,'unit'=>'Unit',  'cost'=>280.00,'stock'=>6,  'reorder'=>2],
            ['code'=>'ITM-028','name'=>'Brake Pads (Set)',              'cat'=>9,'unit'=>'Set',   'cost'=>450.00,'stock'=>4,  'reorder'=>2],
            ['code'=>'ITM-029','name'=>'Wiper Blades (Pair)',           'cat'=>9,'unit'=>'Pair',  'cost'=>95.00, 'stock'=>8,  'reorder'=>3],
            ['code'=>'ITM-030','name'=>'Jump Start Cables',             'cat'=>9,'unit'=>'Set',   'cost'=>180.00,'stock'=>3,  'reorder'=>1],
        ];

        $itemIds = [];
        $warehouseId = 1;
        foreach ($itemsData as $item) {
            $itemId = DB::table('items')->insertGetId([
                'code'          => $item['code'],
                'name'          => $item['name'],
                'category_id'   => $item['cat'],
                'unit_of_measure'=> $item['unit'],
                'unit_cost'     => $item['cost'],
                'current_stock' => $item['stock'],
                'reorder_level' => $item['reorder'],
                'is_active'     => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
            $itemIds[] = ['id' => $itemId, 'cost' => $item['cost'], 'unit' => $item['unit']];

            // Opening stock entry
            DB::table('stock_entries')->insert([
                'item_id'          => $itemId,
                'warehouse_id'     => $warehouseId,
                'transaction_type' => 'in',
                'quantity'         => $item['stock'],
                'unit_cost'        => $item['cost'],
                'total_cost'       => $item['stock'] * $item['cost'],
                'balance_after'    => $item['stock'],
                'reference_type'   => 'opening',
                'notes'            => 'Opening stock balance',
                'created_by'       => 1,
                'created_at'       => Carbon::now()->subMonths(6)->toDateTimeString(),
                'updated_at'       => $now,
            ]);
        }

        // ── 5. PURCHASE ORDERS ────────────────────────────────────────────────
        $poStatuses = [
            ['status'=>'received',  'payment'=>'paid'],
            ['status'=>'received',  'payment'=>'paid'],
            ['status'=>'approved',  'payment'=>'unpaid'],
            ['status'=>'submitted', 'payment'=>'unpaid'],
            ['status'=>'received',  'payment'=>'partial'],
        ];

        for ($p = 1; $p <= 15; $p++) {
            $supId      = $supplierIds[array_rand($supplierIds)];
            $deptId     = $employeeIds[array_rand($employeeIds)]['dept'];
            $reqBy      = 1; // admin user
            $st         = $poStatuses[array_rand($poStatuses)];
            $createdAt  = Carbon::now()->subDays(rand(10, 120));
            $poItems    = array_rand($itemIds, rand(2, 4));
            if (!is_array($poItems)) $poItems = [$poItems];

            $totalAmt = 0;
            $poItemsData = [];
            foreach ($poItems as $idx) {
                $itm = $itemIds[$idx];
                $qty = rand(5, 30);
                $up  = $itm['cost'];
                $tp  = round($qty * $up, 2);
                $totalAmt += $tp;
                $poItemsData[] = ['idx' => $idx, 'qty' => $qty, 'up' => $up, 'tp' => $tp];
            }

            $vat   = round($totalAmt * 0.16, 2);
            $grand = round($totalAmt + $vat, 2);
            $poNum = 'PO-2025-' . str_pad($p, 4, '0', STR_PAD_LEFT);

            $poId = DB::table('purchase_orders')->insertGetId([
                'po_number'             => $poNum,
                'supplier_id'           => $supId,
                'department_id'         => $deptId,
                'requested_by'          => $reqBy,
                'approved_by'           => $st['status'] !== 'pending' ? 1 : null,
                'required_delivery_date'=> $createdAt->copy()->addDays(14)->toDateString(),
                'total_amount'          => $totalAmt,
                'vat_amount'            => $vat,
                'grand_total'           => $grand,
                'status'                => $st['status'],
                'payment_status'        => $st['payment'],
                'delivery_address'      => 'CHAZ House, Plot 1285 Nationalist Road, Lusaka',
                'approved_at'           => in_array($st['status'], ['approved','received','partially_received']) ? $createdAt->copy()->addDays(2)->toDateTimeString() : null,
                'received_at'           => $st['status'] === 'received' ? $createdAt->copy()->addDays(10)->toDateTimeString() : null,
                'created_at'            => $createdAt->toDateTimeString(),
                'updated_at'            => $now,
            ]);

            foreach ($poItemsData as $poi) {
                $itm = $itemIds[$poi['idx']];
                $itemName = DB::table('items')->where('id', $itm['id'])->value('name') ?? 'Item';
                DB::table('purchase_order_items')->insert([
                    'purchase_order_id' => $poId,
                    'item_id'           => $itm['id'],
                    'description'       => $itemName,
                    'unit_of_measure'   => $itm['unit'],
                    'quantity_ordered'  => $poi['qty'],
                    'quantity_received' => $st['status'] === 'received' ? $poi['qty'] : 0,
                    'unit_price'        => $poi['up'],
                    'total_price'       => $poi['tp'],
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]);
            }
        }

        // ── 6. VEHICLES ───────────────────────────────────────────────────────
        $vehiclesData = [
            ['reg'=>'ABZ 1234','make'=>'Toyota','model'=>'Land Cruiser V8','year'=>2021,'cat'=>1,'fuel'=>'diesel','seats'=>8, 'mileage'=>42000,'dept'=>1, 'color'=>'White'],
            ['reg'=>'ABZ 5678','make'=>'Toyota','model'=>'Land Cruiser V8','year'=>2020,'cat'=>1,'fuel'=>'diesel','seats'=>8, 'mileage'=>68000,'dept'=>6, 'color'=>'White'],
            ['reg'=>'ACX 2233','make'=>'Toyota','model'=>'Hilux Double Cab','year'=>2022,'cat'=>2,'fuel'=>'diesel','seats'=>5, 'mileage'=>31000,'dept'=>7, 'color'=>'White'],
            ['reg'=>'ADM 4455','make'=>'Toyota','model'=>'Hilux Double Cab','year'=>2021,'cat'=>2,'fuel'=>'diesel','seats'=>5, 'mileage'=>54000,'dept'=>8, 'color'=>'White'],
            ['reg'=>'AEF 9988','make'=>'Toyota','model'=>'Prado','year'=>2022,'cat'=>1,'fuel'=>'diesel','seats'=>7, 'mileage'=>28000,'dept'=>1, 'color'=>'Silver'],
            ['reg'=>'AFG 1122','make'=>'Nissan', 'model'=>'Navara','year'=>2020,'cat'=>2,'fuel'=>'diesel','seats'=>5, 'mileage'=>77000,'dept'=>6, 'color'=>'White'],
            ['reg'=>'AHJ 3344','make'=>'Toyota','model'=>'Corolla','year'=>2019,'cat'=>4,'fuel'=>'petrol','seats'=>5, 'mileage'=>91000,'dept'=>3, 'color'=>'Silver'],
            ['reg'=>'AKL 5566','make'=>'Toyota','model'=>'Corolla','year'=>2020,'cat'=>4,'fuel'=>'petrol','seats'=>5, 'mileage'=>63000,'dept'=>5, 'color'=>'White'],
            ['reg'=>'AML 7788','make'=>'Toyota','model'=>'HiAce Minibus','year'=>2021,'cat'=>5,'fuel'=>'diesel','seats'=>15,'mileage'=>55000,'dept'=>8, 'color'=>'White'],
            ['reg'=>'ANP 9900','make'=>'Toyota','model'=>'HiAce Minibus','year'=>2019,'cat'=>5,'fuel'=>'diesel','seats'=>15,'mileage'=>110000,'dept'=>8,'color'=>'White'],
            ['reg'=>'APQ 1357','make'=>'Honda', 'model'=>'CG125',          'year'=>2022,'cat'=>6,'fuel'=>'petrol','seats'=>2, 'mileage'=>18000,'dept'=>10,'color'=>'Red'],
            ['reg'=>'ARS 2468','make'=>'Honda', 'model'=>'CG125',          'year'=>2022,'cat'=>6,'fuel'=>'petrol','seats'=>2, 'mileage'=>21000,'dept'=>11,'color'=>'Red'],
            ['reg'=>'ATU 3579','make'=>'Toyota','model'=>'Land Cruiser 70','year'=>2018,'cat'=>1,'fuel'=>'diesel','seats'=>5, 'mileage'=>145000,'dept'=>6,'color'=>'White'],
            ['reg'=>'AVW 4680','make'=>'Isuzu', 'model'=>'NPR Truck',      'year'=>2020,'cat'=>8,'fuel'=>'diesel','seats'=>3, 'mileage'=>48000,'dept'=>7,'color'=>'White'],
            ['reg'=>'AXY 5791','make'=>'Toyota','model'=>'Land Cruiser V8','year'=>2023,'cat'=>1,'fuel'=>'diesel','seats'=>8, 'mileage'=>12000,'dept'=>1,'color'=>'Black'],
        ];

        $driverIds = [1]; // fuel_logs.driver_id references admins table

        $vehicleIds = [];
        foreach ($vehiclesData as $veh) {
            $purchaseDate = Carbon::now()->subYears(2025 - $veh['year'])->subMonths(rand(0,6));
            $vidId = DB::table('vehicles')->insertGetId([
                'registration_number' => $veh['reg'],
                'make'               => $veh['make'],
                'model'              => $veh['model'],
                'year'               => $veh['year'],
                'color'              => $veh['color'],
                'category_id'        => $veh['cat'],
                'fuel_type'          => $veh['fuel'],
                'engine_capacity'    => $veh['fuel'] === 'petrol' ? '1.6L' : '3.0L',
                'seating_capacity'   => $veh['seats'],
                'current_mileage'    => $veh['mileage'],
                'purchase_price'     => rand(180000, 850000),
                'department_id'      => $veh['dept'],
                'status'             => rand(0, 9) > 1 ? 'active' : 'maintenance',
                'is_active'          => true,
                'purchase_date'      => $purchaseDate->toDateString(),
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);

            $vehicleIds[] = $vidId;

            // Insurance
            $insStart = Carbon::now()->subMonths(rand(1, 10));
            DB::table('vehicle_insurance')->insert([
                'vehicle_id'    => $vidId,
                'policy_number' => 'POL-' . strtoupper(substr($veh['make'],0,2)) . rand(100000, 999999),
                'insurer'       => ['Madison Life', 'ZSIC', 'Hollard Zambia', 'Professional Insurance'][rand(0,3)],
                'type'          => rand(0,1) ? 'comprehensive' : 'third_party',
                'start_date'    => $insStart->toDateString(),
                'expiry_date'   => $insStart->copy()->addYear()->toDateString(),
                'premium'       => rand(8000, 35000),
                'is_current'    => true,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);

            // Fuel logs (6 months of monthly fills)
            $odometer = $veh['mileage'] - rand(8000, 20000);
            for ($m = 6; $m >= 1; $m--) {
                $fillDate  = Carbon::now()->subMonths($m)->startOfMonth()->addDays(rand(0, 25));
                $fills     = rand(2, 4);
                for ($f = 0; $f < $fills; $f++) {
                    $litres    = rand(40, 120);
                    $unitCost  = round(rand(2580, 2800) / 100, 2);
                    $odometer += rand(800, 2500);
                    DB::table('fuel_logs')->insert([
                        'vehicle_id'       => $vidId,
                        'driver_id'        => $driverIds[array_rand($driverIds)],
                        'log_date'         => $fillDate->addDays($f * 7)->toDateString(),
                        'odometer_reading' => $odometer,
                        'litres'           => $litres,
                        'unit_cost'        => $unitCost,
                        'total_cost'       => round($litres * $unitCost, 2),
                        'fuel_station'     => ['Total Manda Hill', 'Puma Kafue Road', 'BP Great East Road', 'Engen Lusaka West'][rand(0,3)],
                        'receipt_number'   => 'RCP-' . rand(100000, 999999),
                        'created_by'       => 1,
                        'created_at'       => $now,
                        'updated_at'       => $now,
                    ]);
                }
            }
        }

        // ── 7. EXPENSES ───────────────────────────────────────────────────────
        $expStatuses = ['submitted', 'approved', 'approved', 'paid', 'paid', 'paid'];
        $expNum = 1;
        foreach ($employeeIds as $emp) {
            $numExp = rand(1, 4);
            for ($e = 0; $e < $numExp; $e++) {
                $catId     = rand(1, 10);
                $expDate   = Carbon::now()->subDays(rand(1, 180));
                $amount    = round(rand(500, 15000) + (rand(0, 99) / 100), 2);
                $status    = $expStatuses[array_rand($expStatuses)];
                $appAt     = in_array($status, ['approved','paid']) ? $expDate->copy()->addDays(2)->toDateTimeString() : null;
                DB::table('expenses')->insert([
                    'expense_number'    => 'EXP-' . str_pad($expNum++, 5, '0', STR_PAD_LEFT),
                    'expense_category_id'=> $catId,
                    'employee_id'       => $emp['id'],
                    'department_id'     => $emp['dept'],
                    'description'       => ['Field visit expenses', 'Training workshop', 'Fuel reimbursement', 'Accommodation', 'Office supplies purchase', 'Medical expenses', 'Internet & communication'][rand(0,6)],
                    'amount'            => $amount,
                    'expense_date'      => $expDate->toDateString(),
                    'receipt_number'    => 'RCT-' . rand(10000, 99999),
                    'payment_method'    => ['cash','bank_transfer','mobile_money'][rand(0,2)],
                    'status'            => $status,
                    'approved_by'       => $appAt ? 1 : null,
                    'approved_at'       => $appAt,
                    'paid_at'           => $status === 'paid' ? $expDate->copy()->addDays(5)->toDateTimeString() : null,
                    'created_by'        => 1,
                    'created_at'        => $expDate->toDateTimeString(),
                    'updated_at'        => $now,
                ]);
            }
        }

        // ── 8. ANNOUNCEMENTS ─────────────────────────────────────────────────
        $announcements = [
            ['title'=>'Welcome to the New CHAZ HR Portal',         'cat'=>'hr',        'pri'=>'high',  'pub'=>true,  'days'=>30],
            ['title'=>'Staff Annual Leave Scheduling – 2026',       'cat'=>'hr',        'pri'=>'normal','pub'=>true,  'days'=>20],
            ['title'=>'Q2 Financial Report Submission Deadline',    'cat'=>'finance',   'pri'=>'urgent','pub'=>true,  'days'=>5],
            ['title'=>'Mandatory Security Awareness Training',      'cat'=>'operations','pri'=>'high',  'pub'=>true,  'days'=>15],
            ['title'=>'CHAZ Annual General Meeting – April 2026',   'cat'=>'general',   'pri'=>'high',  'pub'=>true,  'days'=>10],
            ['title'=>'Vehicle Booking Procedure Update',           'cat'=>'operations','pri'=>'normal','pub'=>true,  'days'=>25],
            ['title'=>'Updated Procurement Policy Effective May 1', 'cat'=>'general',   'pri'=>'normal','pub'=>true,  'days'=>18],
            ['title'=>'Health & Wellness Week – 28 Apr to 2 May',  'cat'=>'hr',        'pri'=>'normal','pub'=>true,  'days'=>8],
            ['title'=>'Planned System Downtime – This Weekend',     'cat'=>'operations','pri'=>'urgent','pub'=>true,  'days'=>3],
            ['title'=>'Draft: New Travel Policy (Under Review)',    'cat'=>'general',   'pri'=>'low',   'pub'=>false, 'days'=>1],
        ];

        foreach ($announcements as $ann) {
            $pubDate = Carbon::now()->subDays($ann['days']);
            DB::table('announcements')->insert([
                'title'          => $ann['title'],
                'content'        => "This is an official communication from CHAZ management regarding: {$ann['title']}.\n\nPlease read carefully and ensure compliance. For queries, contact the relevant department head or Human Resources.\n\nThank you for your cooperation.",
                'category'       => $ann['cat'],
                'priority'       => $ann['pri'],
                'target_audience'=> 'all',
                'is_published'   => $ann['pub'],
                'published_at'   => $ann['pub'] ? $pubDate->toDateTimeString() : null,
                'expires_at'     => null,
                'view_count'     => rand(10, 180),
                'created_by'     => 1,
                'created_at'     => $pubDate->toDateTimeString(),
                'updated_at'     => $now,
            ]);
        }

        // ── 9. PAYROLL ────────────────────────────────────────────────────────
        $components = DB::table('salary_components')->where('is_active', true)->orderBy('sort_order')->get();

        $months = [
            ['year'=>2026,'month'=>1,'status'=>'closed'],
            ['year'=>2026,'month'=>2,'status'=>'closed'],
            ['year'=>2026,'month'=>3,'status'=>'open'],
        ];

        foreach ($months as $mo) {
            $date      = Carbon::create($mo['year'], $mo['month'], 1);
            $periodId  = DB::table('payroll_periods')->insertGetId([
                'name'       => $date->format('F Y'),
                'year'       => $mo['year'],
                'month'      => $mo['month'],
                'start_date' => $date->startOfMonth()->toDateString(),
                'end_date'   => $date->copy()->endOfMonth()->toDateString(),
                'status'     => $mo['status'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $runDate    = $date->copy()->endOfMonth()->subDays(3);
            $runStatus  = $mo['status'] === 'closed' ? 'approved' : 'draft';

            $totBasic = $totAllow = $totDeduct = $totTax = $totNet = $count = 0;
            $runId    = DB::table('payroll_runs')->insertGetId([
                'payroll_period_id' => $periodId,
                'run_by'            => 1,
                'run_date'          => $runDate->toDateTimeString(),
                'status'            => $runStatus,
                'total_basic'       => 0,
                'total_allowances'  => 0,
                'total_deductions'  => 0,
                'total_tax'         => 0,
                'total_net'         => 0,
                'employee_count'    => 0,
                'approved_by'       => $runStatus === 'approved' ? 1 : null,
                'approved_at'       => $runStatus === 'approved' ? $runDate->copy()->addDay()->toDateTimeString() : null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            foreach ($employeeIds as $emp) {
                $basic      = (float) $emp['salary'];
                $empAllow   = $empDeduct = $empTax = 0;
                $slipItems  = [];

                foreach ($components as $comp) {
                    $amount = $comp->calculation_type === 'percentage'
                        ? round($basic * $comp->value / 100, 2)
                        : (float) $comp->value;
                    if ($amount == 0) continue;

                    $slipItems[] = [
                        'salary_component_id' => $comp->id,
                        'type'                => $comp->type,
                        'name'                => $comp->name,
                        'amount'              => $amount,
                    ];

                    if ($comp->type === 'allowance')     $empAllow  += $amount;
                    elseif ($comp->type === 'deduction') $empDeduct += $amount;
                    elseif ($comp->type === 'tax')       $empTax    += $amount;
                }

                $netPay = max(0, $basic + $empAllow - $empDeduct - $empTax);

                $slipId = DB::table('payslips')->insertGetId([
                    'payroll_run_id'    => $runId,
                    'payroll_period_id' => $periodId,
                    'employee_id'       => $emp['id'],
                    'basic_salary'      => $basic,
                    'total_allowances'  => $empAllow,
                    'total_deductions'  => $empDeduct,
                    'total_tax'         => $empTax,
                    'net_pay'           => $netPay,
                    'working_days'      => 22,
                    'days_worked'       => 22,
                    'status'            => $runStatus === 'approved' ? 'issued' : 'draft',
                    'issued_at'         => $runStatus === 'approved' ? $runDate->copy()->addDay()->toDateTimeString() : null,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]);

                foreach ($slipItems as $si) {
                    DB::table('payslip_items')->insert(array_merge($si, [
                        'payslip_id' => $slipId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]));
                }

                $totBasic  += $basic;
                $totAllow  += $empAllow;
                $totDeduct += $empDeduct;
                $totTax    += $empTax;
                $totNet    += $netPay;
                $count++;
            }

            DB::table('payroll_runs')->where('id', $runId)->update([
                'total_basic'      => $totBasic,
                'total_allowances' => $totAllow,
                'total_deductions' => $totDeduct,
                'total_tax'        => $totTax,
                'total_net'        => $totNet,
                'employee_count'   => $count,
            ]);
        }

        // ── 10. BUDGETS ───────────────────────────────────────────────────────
        $budgetPeriodId = 1;
        $deptBudgets = [
            ['dept'=>1, 'total'=>5800000],
            ['dept'=>2, 'total'=>2200000],
            ['dept'=>3, 'total'=>3100000],
            ['dept'=>4, 'total'=>1800000],
            ['dept'=>5, 'total'=>1200000],
            ['dept'=>6, 'total'=>8500000],
            ['dept'=>7, 'total'=>4200000],
            ['dept'=>8, 'total'=>3600000],
            ['dept'=>9, 'total'=>900000],
        ];

        $budgetLines = [
            'Staff Costs',
            'Travel & Transport',
            'Office Operations',
            'Training & Capacity Building',
            'Supplies & Materials',
        ];

        foreach ($deptBudgets as $bud) {
            $spent = round($bud['total'] * (rand(30, 65) / 100), 2);
            $budId = DB::table('budgets')->insertGetId([
                'budget_period_id' => $budgetPeriodId,
                'department_id'    => $bud['dept'],
                'prepared_by'      => 1,
                'approved_by'      => 1,
                'total_budget'     => $bud['total'],
                'total_spent'      => $spent,
                'status'           => 'approved',
                'approved_at'      => Carbon::now()->subMonths(3)->toDateTimeString(),
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);

            $lineTotal  = $bud['total'];
            $splits     = [];
            $remaining  = $lineTotal;
            foreach ($budgetLines as $li => $lname) {
                $isLast = $li === count($budgetLines) - 1;
                $amt    = $isLast ? $remaining : round($remaining * (rand(15, 40) / 100), 2);
                $remaining -= $amt;
                $splits[] = ['name' => $lname, 'amt' => $amt];
            }

            $lineCode = 1;
            foreach ($splits as $split) {
                $q = round($split['amt'] / 4, 2);
                $spentPct = rand(25, 70) / 100;
                DB::table('budget_lines')->insert([
                    'budget_id'       => $budId,
                    'account_code'    => 'ACC-' . str_pad($bud['dept'],2,'0',STR_PAD_LEFT) . str_pad($lineCode,2,'0',STR_PAD_LEFT),
                    'description'     => $split['name'],
                    'budgeted_amount' => $split['amt'],
                    'spent_amount'    => round($split['amt'] * $spentPct, 2),
                    'q1_budget'       => $q,
                    'q2_budget'       => $q,
                    'q3_budget'       => $q,
                    'q4_budget'       => round($split['amt'] - ($q * 3), 2),
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ]);
                $lineCode++;
            }
        }

        $this->command->info('✓ Test data seeded successfully:');
        $this->command->info('  · ' . count($employeeIds) . ' employees (portal accounts active)');
        $this->command->info('  · ' . DB::table('leave_requests')->count() . ' leave requests');
        $this->command->info('  · ' . count($supplierIds) . ' suppliers');
        $this->command->info('  · ' . count($itemIds) . ' inventory items + stock entries');
        $this->command->info('  · 15 purchase orders');
        $this->command->info('  · ' . count($vehicleIds) . ' vehicles + insurance + fuel logs');
        $this->command->info('  · ' . DB::table('expenses')->count() . ' expenses');
        $this->command->info('  · 10 announcements');
        $this->command->info('  · 3 payroll periods + runs + ' . DB::table('payslips')->count() . ' payslips');
        $this->command->info('  · ' . count($deptBudgets) . ' department budgets + lines');
    }
}
