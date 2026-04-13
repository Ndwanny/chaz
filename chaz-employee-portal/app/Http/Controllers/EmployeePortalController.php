<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeePortalController extends Controller
{
    public function index()
    {
        $features = [
            [
                'icon'  => 'fa-gauge',
                'title' => 'Personalised Dashboard',
                'desc'  => 'Each employee gets a customisable interface showing their relevant tasks, announcements, leave balance, and upcoming events in one place.',
                'color' => 'green',
            ],
            [
                'icon'  => 'fa-user-pen',
                'title' => 'Self-Service Profile',
                'desc'  => 'Update personal details, emergency contacts, banking information, and professional qualifications independently without raising an HR ticket.',
                'color' => 'gold',
            ],
            [
                'icon'  => 'fa-file-lines',
                'title' => 'Document Management',
                'desc'  => 'Secure access to payslips, employment contracts, HR policy documents, letters of appointment, and the CHAZ Employee Handbook.',
                'color' => 'blue',
            ],
            [
                'icon'  => 'fa-calendar-check',
                'title' => 'Leave Management',
                'desc'  => 'Submit, track, and manage annual leave, sick leave, maternity/paternity leave, and compassionate leave requests with real-time approval status.',
                'color' => 'teal',
            ],
            [
                'icon'  => 'fa-bullhorn',
                'title' => 'Staff Noticeboard',
                'desc'  => 'Stay informed with organisation-wide announcements, circulars, event notices, and programme updates from CHAZ Secretariat and provincial offices.',
                'color' => 'gold',
            ],
            [
                'icon'  => 'fa-graduation-cap',
                'title' => 'Training & Development',
                'desc'  => 'Enrol in CPD courses, access training materials from the James Cairns Training Institute, and track your professional development progress.',
                'color' => 'green',
            ],
            [
                'icon'  => 'fa-hospital-user',
                'title' => 'Employee Directory',
                'desc'  => 'Search the organisation-wide staff directory across all 10 provinces and departments. Full directory access is restricted to administrators.',
                'color' => 'blue',
            ],
            [
                'icon'  => 'fa-shield-halved',
                'title' => 'Benefits & Medical Aid',
                'desc'  => 'View and manage your employee benefits, medical aid coverage, GRZ pension contributions, and allowance entitlements.',
                'color' => 'teal',
            ],
            [
                'icon'  => 'fa-chart-bar',
                'title' => 'Performance Management',
                'desc'  => 'Access your appraisal forms, track performance objectives, review feedback from supervisors, and set goals aligned to the CHAZ Strategic Plan.',
                'color' => 'gold',
            ],
            [
                'icon'  => 'fa-triangle-exclamation',
                'title' => 'Incident & Grievance Reporting',
                'desc'  => 'Submit workplace safety incidents, grievance reports, or whistleblower concerns confidentially through the secure reporting system.',
                'color' => 'red',
            ],
            [
                'icon'  => 'fa-comments',
                'title' => 'Internal Communication',
                'desc'  => 'Send messages to colleagues, participate in department forums, and collaborate across CHAZ Secretariat and all four provincial offices.',
                'color' => 'green',
            ],
            [
                'icon'  => 'fa-sitemap',
                'title' => 'Organisational Chart',
                'desc'  => 'Navigate the CHAZ organisational structure — from the Board of Trustees through programme departments to provincial field offices.',
                'color' => 'blue',
            ],
        ];

        $benefits = [
            [
                'icon'  => 'fa-clock',
                'title' => 'Increased Efficiency',
                'desc'  => 'Self-service features eliminate back-and-forth communication between staff and HR, freeing up time for strategic health programme work.',
            ],
            [
                'icon'  => 'fa-people-group',
                'title' => 'Higher Engagement',
                'desc'  => 'Every CHAZ employee — from Lusaka Secretariat to remote rural health facilities — has equal, instant access to the same tools and resources.',
            ],
            [
                'icon'  => 'fa-eye',
                'title' => 'Greater Transparency',
                'desc'  => 'Staff gain visibility into HR policies, processes, and decisions that affect them, building trust between teams and management.',
            ],
            [
                'icon'  => 'fa-money-bill-trend-up',
                'title' => 'Reduced Admin Costs',
                'desc'  => 'Digitising and automating HR workflows reduces printing, document storage, and manual processing costs across all CHAZ offices.',
            ],
        ];

        $quickLinks = [
            ['icon' => 'fa-file-invoice',     'label' => 'My Payslips',          'color' => 'green'],
            ['icon' => 'fa-calendar-days',    'label' => 'Apply for Leave',      'color' => 'gold'],
            ['icon' => 'fa-book-open',        'label' => 'HR Policies',          'color' => 'blue'],
            ['icon' => 'fa-user-tie',         'label' => 'My Profile',           'color' => 'teal'],
            ['icon' => 'fa-clipboard-list',   'label' => 'Performance Review',   'color' => 'green'],
            ['icon' => 'fa-graduation-cap',   'label' => 'Training Courses',     'color' => 'gold'],
            ['icon' => 'fa-triangle-exclamation', 'label' => 'Report Incident',  'color' => 'red'],
            ['icon' => 'fa-headset',          'label' => 'HR Help Desk',         'color' => 'blue'],
        ];

        $metrics = [
            ['value' => '162',  'label' => 'Connected Institutions'],
            ['value' => '10',   'label' => 'Provinces Covered'],
            ['value' => '24/7', 'label' => 'Portal Availability'],
            ['value' => '100%', 'label' => 'Paperless HR Target'],
        ];

        return view('employee-portal', compact('features', 'benefits', 'quickLinks', 'metrics'));
    }
}
