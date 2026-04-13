<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Full settings schema: group → [key, label, type, default, help?]
     * Types: text, email, url, textarea, number, select, boolean
     */
    public static function schema(): array
    {
        return [
            'organisation' => [
                'label'  => 'Organisation',
                'icon'   => 'fa-building',
                'fields' => [
                    ['key' => 'org_name',       'label' => 'Organisation Name',   'type' => 'text',    'default' => 'Churches Health Association of Zambia'],
                    ['key' => 'org_short_name', 'label' => 'Short Name / Acronym','type' => 'text',    'default' => 'CHAZ'],
                    ['key' => 'org_tagline',    'label' => 'Tagline / Motto',     'type' => 'text',    'default' => ''],
                    ['key' => 'org_website',    'label' => 'Website URL',         'type' => 'url',     'default' => ''],
                    ['key' => 'org_address',    'label' => 'Physical Address',    'type' => 'textarea','default' => ''],
                    ['key' => 'org_city',       'label' => 'City',                'type' => 'text',    'default' => 'Lusaka'],
                    ['key' => 'org_country',    'label' => 'Country',             'type' => 'text',    'default' => 'Zambia'],
                    ['key' => 'org_po_box',     'label' => 'P.O. Box',            'type' => 'text',    'default' => ''],
                    ['key' => 'org_phone',      'label' => 'Main Phone',          'type' => 'text',    'default' => ''],
                    ['key' => 'org_email',      'label' => 'Main Email',          'type' => 'email',   'default' => ''],
                ],
            ],
            'system' => [
                'label'  => 'System',
                'icon'   => 'fa-gear',
                'fields' => [
                    ['key' => 'timezone',         'label' => 'Timezone',              'type' => 'select', 'default' => 'Africa/Lusaka',
                     'options' => ['Africa/Lusaka' => 'Africa/Lusaka (CAT)', 'UTC' => 'UTC', 'Africa/Johannesburg' => 'Africa/Johannesburg', 'Africa/Nairobi' => 'Africa/Nairobi']],
                    ['key' => 'date_format',      'label' => 'Date Display Format',   'type' => 'select', 'default' => 'd M Y',
                     'options' => ['d M Y' => '13 Apr 2026', 'd/m/Y' => '13/04/2026', 'Y-m-d' => '2026-04-13', 'd-m-Y' => '13-04-2026']],
                    ['key' => 'currency',         'label' => 'Currency Code',         'type' => 'text',   'default' => 'ZMW'],
                    ['key' => 'currency_symbol',  'label' => 'Currency Symbol',       'type' => 'text',   'default' => 'K'],
                    ['key' => 'fiscal_year_start','label' => 'Fiscal Year Start Month','type' => 'select','default' => '1',
                     'options' => ['1'=>'January','2'=>'February','3'=>'March','4'=>'April','7'=>'July','10'=>'October']],
                    ['key' => 'admin_email',      'label' => 'Admin Notification Email','type' => 'email','default' => ''],
                    ['key' => 'session_timeout',  'label' => 'Session Timeout (minutes)','type' => 'number','default' => '120',
                     'help' => 'How long before an inactive session is logged out'],
                    ['key' => 'max_login_attempts','label' => 'Max Login Attempts',  'type' => 'number', 'default' => '5',
                     'help' => 'Failed login attempts before lockout'],
                ],
            ],
            'hr' => [
                'label'  => 'HR & Leave',
                'icon'   => 'fa-users',
                'fields' => [
                    ['key' => 'working_days_per_month',  'label' => 'Working Days per Month',      'type' => 'number',  'default' => '22'],
                    ['key' => 'working_hours_per_day',   'label' => 'Working Hours per Day',       'type' => 'number',  'default' => '8'],
                    ['key' => 'probation_period_months', 'label' => 'Probation Period (months)',   'type' => 'number',  'default' => '3'],
                    ['key' => 'leave_approval_levels',   'label' => 'Leave Approval Levels',       'type' => 'select',  'default' => '1',
                     'options' => ['1' => 'Single (Line Manager)', '2' => 'Two-level (Manager + HR)']],
                    ['key' => 'leave_notice_days',       'label' => 'Min. Notice Days for Leave',  'type' => 'number',  'default' => '3',
                     'help' => 'Minimum days in advance a leave request must be submitted'],
                    ['key' => 'annual_leave_days',       'label' => 'Annual Leave Entitlement (days)','type' => 'number','default' => '24'],
                    ['key' => 'sick_leave_days',         'label' => 'Sick Leave Entitlement (days)', 'type' => 'number','default' => '14'],
                    ['key' => 'maternity_leave_days',    'label' => 'Maternity Leave (days)',      'type' => 'number',  'default' => '84'],
                    ['key' => 'paternity_leave_days',    'label' => 'Paternity Leave (days)',      'type' => 'number',  'default' => '5'],
                ],
            ],
            'payroll' => [
                'label'  => 'Payroll & Statutory',
                'icon'   => 'fa-money-bill-wave',
                'fields' => [
                    ['key' => 'napsa_employee_rate', 'label' => 'NAPSA Employee Rate (%)',  'type' => 'number', 'default' => '5',
                     'help' => 'Employee NAPSA contribution as a % of basic salary'],
                    ['key' => 'napsa_employer_rate', 'label' => 'NAPSA Employer Rate (%)',  'type' => 'number', 'default' => '5',
                     'help' => 'Employer NAPSA contribution as a % of basic salary'],
                    ['key' => 'nhima_employee_rate', 'label' => 'NHIMA Employee Rate (%)',  'type' => 'number', 'default' => '1'],
                    ['key' => 'nhima_employer_rate', 'label' => 'NHIMA Employer Rate (%)',  'type' => 'number', 'default' => '1'],
                    ['key' => 'payroll_requires_approval', 'label' => 'Payroll Requires Approval Before Issuing',
                     'type' => 'boolean', 'default' => '1'],
                    ['key' => 'payslip_footer_note', 'label' => 'Payslip Footer Note', 'type' => 'textarea', 'default' => 'This is a computer-generated payslip. No signature required.'],
                    ['key' => 'payroll_payment_day', 'label' => 'Default Pay Day of Month', 'type' => 'number', 'default' => '25',
                     'help' => 'Day of the month salaries are typically paid'],
                ],
            ],
            'portal' => [
                'label'  => 'Employee Portal',
                'icon'   => 'fa-door-open',
                'fields' => [
                    ['key' => 'portal_enabled',            'label' => 'Employee Portal Enabled',    'type' => 'boolean', 'default' => '1'],
                    ['key' => 'portal_allow_self_service',  'label' => 'Allow Self-Service Profile Updates', 'type' => 'boolean', 'default' => '1'],
                    ['key' => 'portal_leave_self_service',  'label' => 'Allow Leave Requests via Portal',    'type' => 'boolean', 'default' => '1'],
                    ['key' => 'portal_show_payslips',      'label' => 'Show Payslips in Portal',    'type' => 'boolean', 'default' => '1'],
                    ['key' => 'portal_show_announcements', 'label' => 'Show Announcements in Portal','type' => 'boolean', 'default' => '1'],
                    ['key' => 'portal_welcome_message',    'label' => 'Portal Welcome Message',     'type' => 'textarea','default' => 'Welcome to the CHAZ Employee Self-Service Portal.'],
                ],
            ],
        ];
    }

    public function index()
    {
        $schema = self::schema();

        // Fetch all current values from DB as key → value map
        $stored = Setting::all()->pluck('value', 'key');

        // Seed missing keys with their defaults (first visit)
        $toInsert = [];
        foreach ($schema as $group => $groupDef) {
            foreach ($groupDef['fields'] as $field) {
                if (!$stored->has($field['key'])) {
                    $toInsert[] = [
                        'key'        => $field['key'],
                        'value'      => $field['default'],
                        'group'      => $group,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $stored[$field['key']] = $field['default'];
                }
            }
        }
        if ($toInsert) {
            Setting::insert($toInsert);
        }

        return view('admin.settings.index', compact('schema', 'stored'));
    }

    public function update(Request $request)
    {
        $schema = self::schema();

        // Build flat list of all known keys
        $allKeys = collect($schema)->flatMap(fn($g) => collect($g['fields'])->pluck('key'))->all();

        $submitted = $request->input('settings', []);

        foreach ($allKeys as $key) {
            // Booleans come through only when checked — treat missing as '0'
            $value = $submitted[$key] ?? '0';
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
