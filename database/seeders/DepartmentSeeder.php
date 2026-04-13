<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            // Core departments
            ['code' => 'EXEC',   'name' => 'Executive / Secretariat',        'type' => 'executive',    'province' => null],
            ['code' => 'HR',     'name' => 'Human Resources',                'type' => 'operational',  'province' => null],
            ['code' => 'FIN',    'name' => 'Finance & Accounts',             'type' => 'operational',  'province' => null],
            ['code' => 'IT',     'name' => 'Information Technology',         'type' => 'support',      'province' => null],
            ['code' => 'COMMS',  'name' => 'Communications & Marketing',     'type' => 'operational',  'province' => null],
            ['code' => 'PROG',   'name' => 'Programmes',                     'type' => 'operational',  'province' => null],
            ['code' => 'PROC',   'name' => 'Procurement & Logistics',        'type' => 'operational',  'province' => null],
            ['code' => 'FLEET',  'name' => 'Fleet / Transport',              'type' => 'support',      'province' => null],
            ['code' => 'ADMIN',  'name' => 'Administration',                 'type' => 'support',      'province' => null],
            // Provincial offices
            ['code' => 'PROV_LS', 'name' => 'Lusaka Province Office',        'type' => 'provincial',   'province' => 'Lusaka'],
            ['code' => 'PROV_CB', 'name' => 'Copperbelt Province Office',    'type' => 'provincial',   'province' => 'Copperbelt'],
            ['code' => 'PROV_EP', 'name' => 'Eastern Province Office',       'type' => 'provincial',   'province' => 'Eastern'],
            ['code' => 'PROV_SP', 'name' => 'Southern Province Office',      'type' => 'provincial',   'province' => 'Southern'],
            ['code' => 'PROV_NP', 'name' => 'Northern Province Office',      'type' => 'provincial',   'province' => 'Northern'],
            ['code' => 'PROV_LP', 'name' => 'Luapula Province Office',       'type' => 'provincial',   'province' => 'Luapula'],
            ['code' => 'PROV_WP', 'name' => 'Western Province Office',       'type' => 'provincial',   'province' => 'Western'],
            ['code' => 'PROV_NW', 'name' => 'North-Western Province Office', 'type' => 'provincial',   'province' => 'North-Western'],
            ['code' => 'PROV_CN', 'name' => 'Central Province Office',       'type' => 'provincial',   'province' => 'Central'],
            ['code' => 'PROV_MK', 'name' => 'Muchinga Province Office',      'type' => 'provincial',   'province' => 'Muchinga'],
        ];

        foreach ($departments as $dept) {
            DB::table('departments')->updateOrInsert(
                ['code' => $dept['code']],
                array_merge($dept, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
