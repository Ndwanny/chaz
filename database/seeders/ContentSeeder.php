<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if already seeded — prevents duplicate key errors on redeploy
        if (DB::table('news')->exists()) {
            $this->command->info('ContentSeeder: data already present, skipping.');
            return;
        }

        $now = now();

        // ── NEWS ─────────────────────────────────────────────────────────────
        DB::table('news')->insert([
            [
                'title'        => 'Strengthening Domestic Resource Mobilisation for Immunisation: GHAI Communications Lead Visits CHAZ',
                'slug'         => 'ghai-communications-lead-visits-chaz',
                'tag'          => 'Immunisation',
                'author'       => 'CHAZ Communications',
                'excerpt'      => 'The Global Health Advocacy Incubator (GHAI) Associate Director of Communications visited CHAZ to advance domestic resource mobilisation strategies for immunisation.',
                'content'      => 'LUSAKA, 16th February, 2026 – The Global Health Advocacy Incubator (GHAI) Associate Director of Communications for Health Systems visited the Churches Health Association of Zambia (CHAZ) Secretariat to discuss collaborative strategies for strengthening domestic resource mobilisation for immunisation in Zambia. The visit marks a significant step in CHAZ\'s ongoing work to ensure sustainable, government-funded immunisation programmes that reach every child, especially in rural communities.',
                'status'       => 'published',
                'published_at' => '2026-02-17 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'Strengthening Genomics-Based Surveillance for Drug-Resistant TB in Zambia',
                'slug'         => 'genomics-based-surveillance-drug-resistant-tb',
                'tag'          => 'Tuberculosis',
                'author'       => 'CHAZ Laboratory Unit',
                'excerpt'      => 'CHAZ convened a Stakeholder Engagement Inception Meeting to launch genomics-based surveillance for drug-resistant TB across Zambia.',
                'content'      => 'LUSAKA, 4th February 2026 – The Churches Health Association of Zambia (CHAZ) convened a Stakeholder Engagement Inception Meeting to launch the country\'s first coordinated genomics-based surveillance programme for drug-resistant tuberculosis (DR-TB).',
                'status'       => 'published',
                'published_at' => '2026-02-06 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Makes Submission to Parliament on Zambia\'s Growing Cancer Burden',
                'slug'         => 'chaz-parliament-cancer-burden',
                'tag'          => 'Advocacy',
                'author'       => 'CHAZ Policy Team',
                'excerpt'      => 'CHAZ appeared before the Parliamentary Committee on Health to present evidence on Zambia\'s escalating cancer burden.',
                'content'      => 'LUSAKA, 25th January 2026 – CHAZ appeared before the Parliamentary Committee on Health, Environment and Social Welfare to make a formal submission on Zambia\'s growing cancer burden, recommending targeted budget allocations and national cancer screening programmes.',
                'status'       => 'published',
                'published_at' => '2026-01-27 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Launches Community Health Worker Training Programme in Eastern Province',
                'slug'         => 'community-health-worker-training-eastern-province',
                'tag'          => 'Community Health',
                'author'       => 'CHAZ Programmes',
                'excerpt'      => 'Over 120 community health workers received refresher training on maternal and child health, nutrition, and malaria case management.',
                'content'      => 'CHIPATA, 12th March 2026 – CHAZ, in partnership with the Ministry of Health, successfully conducted a 5-day community health worker training programme in Eastern Province, equipping 120 CHWs with updated skills in maternal and child health, malaria case management, and nutrition counselling.',
                'status'       => 'published',
                'published_at' => '2026-03-14 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Annual General Meeting 2026: Key Resolutions Passed',
                'slug'         => 'chaz-agm-2026-resolutions',
                'tag'          => 'Governance',
                'author'       => 'CHAZ Secretariat',
                'excerpt'      => 'The 2026 CHAZ Annual General Meeting approved strategic priorities for the next fiscal year and elected new board members.',
                'content'      => 'LUSAKA, 28th March 2026 – The Churches Health Association of Zambia held its Annual General Meeting at Taj Pamodzi Hotel, Lusaka. Members approved the 2025 audited accounts, strategic priorities for FY 2026/27, and elected three new board trustees representing the Anglican, Catholic, and Seventh-day Adventist church networks.',
                'status'       => 'published',
                'published_at' => '2026-03-29 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'Partnership with Global Fund Renewed for Another Cycle',
                'slug'         => 'global-fund-partnership-renewed',
                'tag'          => 'Funding',
                'author'       => 'CHAZ Finance Unit',
                'excerpt'      => 'CHAZ has been awarded a new Global Fund grant cycle covering HIV, TB and Malaria programming for 2026–2029.',
                'content'      => 'LUSAKA, 5th April 2026 – The Churches Health Association of Zambia has been formally awarded the 2026–2029 Global Fund grant for HIV, Tuberculosis, and Malaria programming. The grant totals USD 34.2 million and will be implemented across 8 provinces through 22 sub-recipient organisations.',
                'status'       => 'published',
                'published_at' => '2026-04-07 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'Malnutrition Screening Drive Reaches 15,000 Children in Northern Province',
                'slug'         => 'malnutrition-screening-northern-province',
                'tag'          => 'Nutrition',
                'author'       => 'CHAZ Nutrition Programme',
                'excerpt'      => 'A six-week nutrition screening and supplementation campaign covered 47 health facilities across Northern Province.',
                'content'      => 'KASAMA, 20th February 2026 – CHAZ\'s nutrition team, supported by UNICEF Zambia, completed a six-week malnutrition screening and supplementation campaign across Northern Province, screening 15,247 children under five and enrolling 1,832 children with moderate acute malnutrition into therapeutic feeding programmes.',
                'status'       => 'published',
                'published_at' => '2026-02-22 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ ICT Strategy 2026–2030: Digital Health Roadmap Launched',
                'slug'         => 'ict-strategy-digital-health-roadmap',
                'tag'          => 'Digital Health',
                'author'       => 'CHAZ ICT Unit',
                'excerpt'      => 'CHAZ has launched its five-year ICT strategy to digitise health facility reporting and strengthen data systems across member institutions.',
                'content'      => 'LUSAKA, 10th January 2026 – CHAZ formally launched its 2026–2030 ICT Strategy, outlining a roadmap to digitise health facility reporting, deploy electronic health records at 45 mission hospitals, and strengthen real-time data systems to improve programme management and health outcomes.',
                'status'       => 'published',
                'published_at' => '2026-01-12 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'Capacity Building Workshop for Finance Officers at CHAZ Member Hospitals',
                'slug'         => 'finance-officers-capacity-building-workshop',
                'tag'          => 'Capacity Building',
                'author'       => 'CHAZ Finance',
                'excerpt'      => 'Over 60 finance officers from CHAZ member institutions attended a three-day workshop on financial management and grant reporting.',
                'content'      => 'LIVINGSTONE, 18th March 2026 – CHAZ organised a three-day financial management and grant reporting workshop in Livingstone, attended by 62 finance officers from member hospitals across all 10 provinces. Sessions covered IPSAS, donor reporting standards, and hands-on use of the CHAZ finance portal.',
                'status'       => 'published',
                'published_at' => '2026-03-20 08:00:00',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Secretariat Relocates to New Offices in Lusaka East',
                'slug'         => 'chaz-secretariat-new-offices',
                'tag'          => 'Organisation',
                'author'       => 'CHAZ Secretariat',
                'excerpt'      => 'The CHAZ Secretariat has relocated to a new, purpose-built office facility in Lusaka East to accommodate growing staff capacity.',
                'content'      => 'LUSAKA, 3rd April 2026 – The Churches Health Association of Zambia Secretariat has completed its relocation to a new, purpose-built office facility in Lusaka East. The new premises accommodate 85 staff, two boardrooms, a training suite, and a dedicated IT data centre.',
                'status'       => 'draft',
                'published_at' => null,
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'Malaria Prevention Campaign 2026: Bed Net Distribution Begins',
                'slug'         => 'malaria-prevention-bed-net-distribution-2026',
                'tag'          => 'Malaria',
                'author'       => 'CHAZ Malaria Programme',
                'excerpt'      => 'CHAZ kicks off its annual bed net distribution campaign targeting 280,000 households across rural Zambia.',
                'content'      => 'MONGU, 1st April 2026 – The Churches Health Association of Zambia has launched its 2026 bed net distribution campaign in Western Province, targeting 280,000 households with long-lasting insecticidal nets (LLINs). The campaign will run across six provinces over eight weeks.',
                'status'       => 'draft',
                'published_at' => null,
                'created_at'   => $now, 'updated_at' => $now,
            ],
        ]);

        // ── JOBS ─────────────────────────────────────────────────────────────
        DB::table('jobs')->insert([
            [
                'title'          => 'Programme Officer – HIV & AIDS',
                'department'     => 'HIV/AIDS Programme',
                'location'       => 'Lusaka Secretariat',
                'type'           => 'Full-time',
                'description'    => 'Seeking a qualified Programme Officer to support implementation, monitoring, and reporting of HIV/AIDS programme activities under the ATEC II Global Fund grant.',
                'duties'         => json_encode(['Coordinate programme implementation with sub-recipients', 'Prepare monthly, quarterly, and annual reports', 'Conduct supportive supervision visits to health facilities', 'Participate in stakeholder coordination meetings']),
                'qualifications' => json_encode(['Bachelor\'s degree in Public Health or related field', 'Minimum 3 years experience in HIV/AIDS programming', 'Experience with Global Fund grant management is an advantage', 'Valid driver\'s licence']),
                'deadline'       => '2026-04-30',
                'posted_at'      => '2026-04-01',
                'status'         => 'open',
                'created_at'     => $now, 'updated_at' => $now,
            ],
            [
                'title'          => 'Finance Officer – Grants',
                'department'     => 'Finance & Administration',
                'location'       => 'Lusaka Secretariat',
                'type'           => 'Full-time',
                'description'    => 'CHAZ seeks a Finance Officer to support grant financial management, sub-recipient financial oversight, and donor reporting.',
                'duties'         => json_encode(['Manage grant budgets and forecasts', 'Prepare donor financial reports', 'Conduct financial monitoring visits to sub-recipients', 'Ensure compliance with donor financial rules']),
                'qualifications' => json_encode(['ACCA/CIMA Part II or Bachelor\'s in Accountancy', 'Minimum 3 years in grant financial management', 'Experience with Global Fund, USAID or PEPFAR grants preferred', 'Proficiency in QuickBooks or similar accounting software']),
                'deadline'       => '2026-04-25',
                'posted_at'      => '2026-03-28',
                'status'         => 'open',
                'created_at'     => $now, 'updated_at' => $now,
            ],
            [
                'title'          => 'Monitoring & Evaluation Officer',
                'department'     => 'Strategic Information',
                'location'       => 'Lusaka Secretariat',
                'type'           => 'Full-time',
                'description'    => 'The M&E Officer will support design, implementation, and oversight of monitoring and evaluation systems for CHAZ programmes.',
                'duties'         => json_encode(['Develop and maintain M&E frameworks and data collection tools', 'Analyse programme data and produce reports', 'Train sub-recipient M&E staff', 'Coordinate data quality assessments']),
                'qualifications' => json_encode(['Bachelor\'s degree in Statistics, Epidemiology, or Public Health', 'Minimum 3 years M&E experience in health programming', 'Proficiency in DHIS2, DATIM, and statistical software', 'Strong report-writing skills']),
                'deadline'       => '2026-04-22',
                'posted_at'      => '2026-03-25',
                'status'         => 'open',
                'created_at'     => $now, 'updated_at' => $now,
            ],
            [
                'title'          => 'Logistics & Supply Chain Officer',
                'department'     => 'Procurement & Logistics',
                'location'       => 'Lusaka Secretariat',
                'type'           => 'Full-time',
                'description'    => 'Responsible for coordinating procurement and logistics for medical commodities and programme supplies.',
                'duties'         => json_encode(['Coordinate procurement of health commodities and supplies', 'Manage supplier relationships and contracts', 'Monitor stock levels at central and facility level', 'Prepare logistics reports and forecasts']),
                'qualifications' => json_encode(['Bachelor\'s degree in Supply Chain, Procurement, or Business', 'Minimum 2 years in health commodity logistics', 'Experience with ZAMICS or other health supply chain systems', 'CIPS certification is an added advantage']),
                'deadline'       => '2026-05-05',
                'posted_at'      => '2026-04-05',
                'status'         => 'open',
                'created_at'     => $now, 'updated_at' => $now,
            ],
            [
                'title'          => 'Human Resources Officer',
                'department'     => 'Human Resources',
                'location'       => 'Lusaka Secretariat',
                'type'           => 'Full-time',
                'description'    => 'Manages HR operations including recruitment, staff welfare, payroll coordination, and performance management.',
                'duties'         => json_encode(['Manage end-to-end recruitment processes', 'Administer staff benefits and leave records', 'Support performance review cycles', 'Maintain HR database and personnel files']),
                'qualifications' => json_encode(['Bachelor\'s degree in Human Resource Management or related field', 'Minimum 3 years HR generalist experience', 'Member of Zambia Institute of Human Resource Management (ZIHRM)', 'Experience in an NGO or health sector is preferred']),
                'deadline'       => '2026-03-15',
                'posted_at'      => '2026-02-20',
                'status'         => 'closed',
                'created_at'     => $now, 'updated_at' => $now,
            ],
            [
                'title'          => 'Communications & Knowledge Management Officer',
                'department'     => 'Communications',
                'location'       => 'Lusaka Secretariat',
                'type'           => 'Full-time',
                'description'    => 'Responsible for CHAZ external communications, website content, social media, and knowledge management products.',
                'duties'         => json_encode(['Produce newsletters, success stories, and press releases', 'Manage the CHAZ website and social media channels', 'Document best practices and lessons learned', 'Coordinate media relations and events']),
                'qualifications' => json_encode(['Bachelor\'s degree in Communications, Journalism, or Public Relations', 'Minimum 2 years in communications for an NGO or health organisation', 'Excellent writing and editing skills', 'Proficiency in graphic design tools (Canva, Adobe Suite)']),
                'deadline'       => '2026-03-10',
                'posted_at'      => '2026-02-14',
                'status'         => 'closed',
                'created_at'     => $now, 'updated_at' => $now,
            ],
        ]);

        // ── TENDERS ──────────────────────────────────────────────────────────
        DB::table('tenders')->insert([
            [
                'reference'   => 'CHAZ/T/2026/001',
                'title'       => 'Supply and Delivery of Malaria Rapid Diagnostic Test Kits',
                'category'    => 'Medical Supplies',
                'description' => 'CHAZ invites sealed bids from eligible and qualified suppliers for the supply and delivery of Malaria Rapid Diagnostic Test (RDT) kits to designated health facilities across 8 provinces of Zambia.',
                'issued_at'   => '2026-03-01',
                'deadline'    => '2026-04-30',
                'status'      => 'open',
                'created_at'  => $now, 'updated_at' => $now,
            ],
            [
                'reference'   => 'CHAZ/T/2026/002',
                'title'       => 'Provision of Fleet Management and Vehicle Tracking Services',
                'category'    => 'Services',
                'description' => 'CHAZ seeks proposals from qualified firms to provide fleet management software, GPS vehicle tracking, and monthly fleet reporting services for its 15-vehicle fleet.',
                'issued_at'   => '2026-03-10',
                'deadline'    => '2026-04-20',
                'status'      => 'open',
                'created_at'  => $now, 'updated_at' => $now,
            ],
            [
                'reference'   => 'CHAZ/T/2026/003',
                'title'       => 'Construction of Staff Canteen and Kitchen Facility',
                'category'    => 'Construction',
                'description' => 'CHAZ invites bids from registered building contractors for the construction of a staff canteen and kitchen facility at the CHAZ Secretariat premises in Lusaka.',
                'issued_at'   => '2026-03-15',
                'deadline'    => '2026-04-25',
                'status'      => 'open',
                'created_at'  => $now, 'updated_at' => $now,
            ],
            [
                'reference'   => 'CHAZ/T/2026/004',
                'title'       => 'Supply of ICT Equipment – Laptops, Printers, and Networking Hardware',
                'category'    => 'ICT Equipment',
                'description' => 'CHAZ invites quotations from registered ICT suppliers for the supply and delivery of laptops, printers, and networking hardware for the Secretariat and selected member hospitals.',
                'issued_at'   => '2026-03-20',
                'deadline'    => '2026-05-10',
                'status'      => 'open',
                'created_at'  => $now, 'updated_at' => $now,
            ],
            [
                'reference'   => 'CHAZ/T/2026/005',
                'title'       => 'Provision of External Audit Services – FY 2025/2026',
                'category'    => 'Professional Services',
                'description' => 'CHAZ invites proposals from registered audit firms to conduct the annual external audit for the financial year ending 31 March 2026, including Global Fund programme audits.',
                'issued_at'   => '2026-02-01',
                'deadline'    => '2026-03-15',
                'status'      => 'awarded',
                'created_at'  => $now, 'updated_at' => $now,
            ],
            [
                'reference'   => 'CHAZ/T/2025/018',
                'title'       => 'Supply of Laboratory Reagents and Consumables',
                'category'    => 'Medical Supplies',
                'description' => 'Supply and delivery of laboratory reagents, consumables, and equipment for TB diagnostics across CHAZ member hospitals in Northern, Luapula, and Muchinga provinces.',
                'issued_at'   => '2025-11-01',
                'deadline'    => '2025-12-15',
                'status'      => 'awarded',
                'created_at'  => $now, 'updated_at' => $now,
            ],
            [
                'reference'   => 'CHAZ/T/2025/019',
                'title'       => 'Printing of IEC Materials and Programme Reports',
                'category'    => 'Printing',
                'description' => 'CHAZ invites quotations from registered printing firms for the printing of IEC materials, programme brochures, and annual reports for 2025.',
                'issued_at'   => '2025-10-15',
                'deadline'    => '2025-11-30',
                'status'      => 'closed',
                'created_at'  => $now, 'updated_at' => $now,
            ],
        ]);

        // ── MEMBERS ──────────────────────────────────────────────────────────
        $provinces = ['Lusaka','Copperbelt','Southern','Eastern','Northern','Western','Central','Luapula','Muchinga','North-Western'];
        $denominations = ['Roman Catholic','Anglican','Seventh-day Adventist','United Church of Zambia','Reformed Church in Zambia','Baptist','Lutheran','Evangelical Church','Brethren in Christ','Methodist'];

        $members = [
            // Lusaka
            ['name' => 'Lubwa Mission Hospital', 'type' => 'hospital', 'province' => 'Lusaka', 'denomination' => 'United Church of Zambia', 'district' => 'Chinsali'],
            ['name' => 'St. Francis Mission Hospital', 'type' => 'hospital', 'province' => 'Lusaka', 'denomination' => 'Roman Catholic', 'district' => 'Katete'],
            ['name' => 'Chilonga Rural Health Centre', 'type' => 'centre', 'province' => 'Lusaka', 'denomination' => 'Anglican', 'district' => 'Lusaka'],
            ['name' => 'Kabwata Community Health CBO', 'type' => 'cbo', 'province' => 'Lusaka', 'denomination' => 'Baptist', 'district' => 'Lusaka'],

            // Copperbelt
            ['name' => 'Mindolo Mission Hospital', 'type' => 'hospital', 'province' => 'Copperbelt', 'denomination' => 'United Church of Zambia', 'district' => 'Kitwe'],
            ['name' => 'Mikomfwa Health Centre', 'type' => 'centre', 'province' => 'Copperbelt', 'denomination' => 'Reformed Church in Zambia', 'district' => 'Luanshya'],
            ['name' => 'Copperbelt SDA Health Ministry', 'type' => 'cbo', 'province' => 'Copperbelt', 'denomination' => 'Seventh-day Adventist', 'district' => 'Ndola'],

            // Southern
            ['name' => 'Macha Mission Hospital', 'type' => 'hospital', 'province' => 'Southern', 'denomination' => 'Brethren in Christ', 'district' => 'Choma'],
            ['name' => 'Zimba Mission Hospital', 'type' => 'hospital', 'province' => 'Southern', 'denomination' => 'Seventh-day Adventist', 'district' => 'Kalomo'],
            ['name' => 'Livingstone SDA Clinic', 'type' => 'centre', 'province' => 'Southern', 'denomination' => 'Seventh-day Adventist', 'district' => 'Livingstone'],
            ['name' => 'Tonga Women\'s Health CBO', 'type' => 'cbo', 'province' => 'Southern', 'denomination' => 'Methodist', 'district' => 'Mazabuka'],

            // Eastern
            ['name' => 'St. Francis Mission Hospital', 'type' => 'hospital', 'province' => 'Eastern', 'denomination' => 'Roman Catholic', 'district' => 'Katete'],
            ['name' => 'Chipata Mission Health Centre', 'type' => 'centre', 'province' => 'Eastern', 'denomination' => 'Anglican', 'district' => 'Chipata'],
            ['name' => 'Petauke Baptist Health Centre', 'type' => 'centre', 'province' => 'Eastern', 'denomination' => 'Baptist', 'district' => 'Petauke'],

            // Northern
            ['name' => 'Mbereshi Mission Hospital', 'type' => 'hospital', 'province' => 'Northern', 'denomination' => 'United Church of Zambia', 'district' => 'Kawambwa'],
            ['name' => 'Chilonga Mission Health Centre', 'type' => 'centre', 'province' => 'Northern', 'denomination' => 'Roman Catholic', 'district' => 'Kasama'],
            ['name' => 'Northern Province Catholic Health CBO', 'type' => 'cbo', 'province' => 'Northern', 'denomination' => 'Roman Catholic', 'district' => 'Kasama'],

            // Western
            ['name' => 'Mukinge Mission Hospital', 'type' => 'hospital', 'province' => 'Western', 'denomination' => 'Evangelical Church', 'district' => 'Kasempa'],
            ['name' => 'Lewanika General Hospital Annex', 'type' => 'centre', 'province' => 'Western', 'denomination' => 'Anglican', 'district' => 'Mongu'],

            // Central
            ['name' => 'Kabwe Anglican Health Centre', 'type' => 'centre', 'province' => 'Central', 'denomination' => 'Anglican', 'district' => 'Kabwe'],
            ['name' => 'Fiwila Mission Hospital', 'type' => 'hospital', 'province' => 'Central', 'denomination' => 'United Church of Zambia', 'district' => 'Serenje'],
            ['name' => 'Central Province SDA Clinic', 'type' => 'centre', 'province' => 'Central', 'denomination' => 'Seventh-day Adventist', 'district' => 'Mkushi'],

            // Luapula
            ['name' => 'Mansa SDA Mission Hospital', 'type' => 'hospital', 'province' => 'Luapula', 'denomination' => 'Seventh-day Adventist', 'district' => 'Mansa'],
            ['name' => 'Samfya Catholic Health Centre', 'type' => 'centre', 'province' => 'Luapula', 'denomination' => 'Roman Catholic', 'district' => 'Samfya'],
            ['name' => 'Luapula CBO Health Network', 'type' => 'cbo', 'province' => 'Luapula', 'denomination' => 'Lutheran', 'district' => 'Mansa'],

            // Muchinga
            ['name' => 'Chinsali Mission Hospital', 'type' => 'hospital', 'province' => 'Muchinga', 'denomination' => 'United Church of Zambia', 'district' => 'Chinsali'],
            ['name' => 'Mpika Catholic Health Centre', 'type' => 'centre', 'province' => 'Muchinga', 'denomination' => 'Roman Catholic', 'district' => 'Mpika'],

            // North-Western
            ['name' => 'Kalene Mission Hospital', 'type' => 'hospital', 'province' => 'North-Western', 'denomination' => 'Evangelical Church', 'district' => 'Ikelenge'],
            ['name' => 'Solwezi Baptist Health Centre', 'type' => 'centre', 'province' => 'North-Western', 'denomination' => 'Baptist', 'district' => 'Solwezi'],
            ['name' => 'North-Western Diocese Health CBO', 'type' => 'cbo', 'province' => 'North-Western', 'denomination' => 'Anglican', 'district' => 'Solwezi'],
        ];

        foreach ($members as $m) {
            DB::table('members')->insert([
                'name'       => $m['name'],
                'type'       => $m['type'],
                'province'   => $m['province'],
                'denomination' => $m['denomination'],
                'district'   => $m['district'],
                'contact'    => '+260 9' . rand(10, 99) . ' ' . rand(100000, 999999),
                'active'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ── DOWNLOADS ────────────────────────────────────────────────────────
        DB::table('downloads')->insert([
            [
                'title'        => 'CHAZ Annual Report 2024/2025',
                'category'     => 'annual_report',
                'type'         => 'PDF',
                'year'         => 2025,
                'issue'        => null,
                'file_path'    => 'downloads/annual-report-2024-2025.pdf',
                'file_size'    => '4.2 MB',
                'pages'        => 68,
                'description'  => 'Comprehensive annual report covering CHAZ programmes, financials, and impact for the 2024/2025 financial year.',
                'published_at' => '2025-09-01',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Annual Report 2023/2024',
                'category'     => 'annual_report',
                'type'         => 'PDF',
                'year'         => 2024,
                'issue'        => null,
                'file_path'    => 'downloads/annual-report-2023-2024.pdf',
                'file_size'    => '3.8 MB',
                'pages'        => 62,
                'description'  => 'Annual report for the 2023/2024 financial year, including Global Fund and government grant performance.',
                'published_at' => '2024-09-15',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Newsletter – Q1 2026',
                'category'     => 'newsletter',
                'type'         => 'PDF',
                'year'         => 2026,
                'issue'        => 'Q1 2026',
                'file_path'    => 'downloads/newsletter-q1-2026.pdf',
                'file_size'    => '1.1 MB',
                'pages'        => 12,
                'description'  => 'First quarter 2026 newsletter featuring programme updates, staff news, and upcoming events.',
                'published_at' => '2026-04-01',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Newsletter – Q4 2025',
                'category'     => 'newsletter',
                'type'         => 'PDF',
                'year'         => 2025,
                'issue'        => 'Q4 2025',
                'file_path'    => 'downloads/newsletter-q4-2025.pdf',
                'file_size'    => '0.9 MB',
                'pages'        => 10,
                'description'  => 'Fourth quarter 2025 newsletter covering year-end programme highlights and community impact stories.',
                'published_at' => '2026-01-15',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Newsletter – Q3 2025',
                'category'     => 'newsletter',
                'type'         => 'PDF',
                'year'         => 2025,
                'issue'        => 'Q3 2025',
                'file_path'    => 'downloads/newsletter-q3-2025.pdf',
                'file_size'    => '1.0 MB',
                'pages'        => 11,
                'description'  => 'Third quarter 2025 newsletter with malaria programme updates and new partnership highlights.',
                'published_at' => '2025-10-10',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Strategic Plan 2023–2027',
                'category'     => 'publication',
                'type'         => 'PDF',
                'year'         => 2023,
                'issue'        => null,
                'file_path'    => 'downloads/strategic-plan-2023-2027.pdf',
                'file_size'    => '2.6 MB',
                'pages'        => 44,
                'description'  => 'The five-year strategic plan outlining CHAZ vision, mission, strategic objectives, and implementation framework.',
                'published_at' => '2023-04-01',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'HIV Programme Performance Report 2025',
                'category'     => 'publication',
                'type'         => 'PDF',
                'year'         => 2025,
                'issue'        => null,
                'file_path'    => 'downloads/hiv-programme-report-2025.pdf',
                'file_size'    => '1.8 MB',
                'pages'        => 28,
                'description'  => 'Annual HIV programme performance report for 2025, covering ATEC II Global Fund grant achievements and targets.',
                'published_at' => '2026-02-01',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'Malaria Programme Report 2025',
                'category'     => 'publication',
                'type'         => 'PDF',
                'year'         => 2025,
                'issue'        => null,
                'file_path'    => 'downloads/malaria-programme-report-2025.pdf',
                'file_size'    => '1.5 MB',
                'pages'        => 24,
                'description'  => 'Annual malaria programme performance report including bed net distribution, IRS, and case management results.',
                'published_at' => '2026-02-15',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'TB & DR-TB Programme Report 2025',
                'category'     => 'publication',
                'type'         => 'PDF',
                'year'         => 2025,
                'issue'        => null,
                'file_path'    => 'downloads/tb-programme-report-2025.pdf',
                'file_size'    => '1.3 MB',
                'pages'        => 20,
                'description'  => 'Annual tuberculosis programme report covering case detection, treatment success rates, and drug-resistant TB surveillance.',
                'published_at' => '2026-03-01',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Member Hospital Directory 2026',
                'category'     => 'publication',
                'type'         => 'PDF',
                'year'         => 2026,
                'issue'        => null,
                'file_path'    => 'downloads/member-hospital-directory-2026.pdf',
                'file_size'    => '0.8 MB',
                'pages'        => 18,
                'description'  => 'Directory of all CHAZ member hospitals, health centres, and CBOs with contact details and service profiles.',
                'published_at' => '2026-01-20',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Newsletter – Q2 2025',
                'category'     => 'newsletter',
                'type'         => 'PDF',
                'year'         => 2025,
                'issue'        => 'Q2 2025',
                'file_path'    => 'downloads/newsletter-q2-2025.pdf',
                'file_size'    => '0.9 MB',
                'pages'        => 10,
                'description'  => 'Second quarter 2025 newsletter with community health worker programme updates and capacity building highlights.',
                'published_at' => '2025-07-12',
                'created_at'   => $now, 'updated_at' => $now,
            ],
            [
                'title'        => 'CHAZ Annual Report 2022/2023',
                'category'     => 'annual_report',
                'type'         => 'PDF',
                'year'         => 2023,
                'issue'        => null,
                'file_path'    => 'downloads/annual-report-2022-2023.pdf',
                'file_size'    => '3.5 MB',
                'pages'        => 58,
                'description'  => 'Annual report for 2022/2023 covering CHAZ 60th anniversary activities and programme milestones.',
                'published_at' => '2023-10-01',
                'created_at'   => $now, 'updated_at' => $now,
            ],
        ]);

        // ── CONTACT MESSAGES ─────────────────────────────────────────────────
        $messages = [
            ['name' => 'Dr. Chanda Mwansa', 'email' => 'cmwansa@mutendere.org', 'phone' => '+260 955 123456', 'subject' => 'Partnership Inquiry – Mutendere Mission Hospital', 'message' => 'We are interested in exploring a formal partnership with CHAZ for our upcoming maternal health programme. Please let us know whom to contact for further discussion.', 'read' => false],
            ['name' => 'Patricia Ng\'oma', 'email' => 'pngoma@gmail.com', 'phone' => '+260 977 234567', 'subject' => 'Application for HIV Programme Officer Position', 'message' => 'I would like to express my interest in the HIV Programme Officer position advertised on your website. I have attached my CV and cover letter. Please confirm receipt.', 'read' => false],
            ['name' => 'James Mulenga', 'email' => 'jmulenga@unicef.org', 'phone' => '+260 966 345678', 'subject' => 'Request for CHAZ Programme Data – Q1 2026', 'message' => 'Following our meeting in February, I am writing to formally request the Q1 2026 programme performance data for inclusion in our joint donor report. Thank you for your continued support.', 'read' => false],
            ['name' => 'Sister Mary Phiri', 'email' => 'smaryphiri@lubwa.org', 'phone' => '+260 978 456789', 'subject' => 'Request for Financial Management Training Dates', 'message' => 'We received information about the upcoming financial management training for member hospitals. Could you please confirm the dates and venue? We have three staff members who wish to attend.', 'read' => false],
            ['name' => 'Emmanuel Tembo', 'email' => 'etembo@who.int', 'phone' => '+260 211 254600', 'subject' => 'WHO Collaboration – TB Genomics Surveillance Project', 'message' => 'Following the inception meeting in February, WHO would like to discuss a formal collaboration agreement for the TB genomics surveillance project. Please advise on your earliest availability for a meeting.', 'read' => true, 'read_at' => '2026-03-15 10:30:00'],
            ['name' => 'Blessings Banda', 'email' => 'bbanda@moh.gov.zm', 'phone' => '+260 211 253040', 'subject' => 'MOU Review – Ministry of Health Partnership', 'message' => 'The Ministry of Health Procurement Unit would like to schedule a meeting to review the current MOU terms ahead of the annual renewal. Please share your availability for a meeting in April.', 'read' => true, 'read_at' => '2026-04-02 09:15:00'],
            ['name' => 'Grace Zulu', 'email' => 'gzulu@globalfund.org', 'phone' => '+41 22 791 1700', 'subject' => 'Grant Performance Review – ATEC II Cycle', 'message' => 'This is a follow-up regarding the ATEC II grant performance review scheduled for May 2026. The Global Fund team requires the following documents at least two weeks before the review. Please confirm you have received the full documentation checklist.', 'read' => true, 'read_at' => '2026-04-05 14:20:00'],
            ['name' => 'Mulima Katongo', 'email' => 'mkatongo@chipata-hospital.org', 'phone' => '+260 962 567890', 'subject' => 'Request for ARV Stockout Support – Chipata Mission Hospital', 'message' => 'We are experiencing a critical stockout of Tenofovir/Lamivudine at our facility. We have 340 patients on ART who require urgent resupply. Please advise on emergency commodity support procedures.', 'read' => false],
        ];

        foreach ($messages as $msg) {
            DB::table('contact_messages')->insert([
                'name'       => $msg['name'],
                'email'      => $msg['email'],
                'phone'      => $msg['phone'],
                'subject'    => $msg['subject'],
                'message'    => $msg['message'],
                'read'       => $msg['read'],
                'read_at'    => $msg['read_at'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
