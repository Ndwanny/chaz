<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default superadmin (idempotent)
        if (!DB::table('admins')->where('email', 'admin@chaz.org.zm')->exists()) {
            DB::table('admins')->insert([
                'name'       => 'CHAZ Administrator',
                'email'      => 'admin@chaz.org.zm',
                'password'   => Hash::make('Chaz@2024!'),
                'role'       => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Sample news
        $newsItems = [
            [
                'title'        => 'Strengthening Domestic Resource Mobilisation for Immunisation: GHAI Communications Lead Visits CHAZ',
                'slug'         => 'ghai-communications-lead-visits-chaz',
                'tag'          => 'Immunisation',
                'author'       => 'CHAZ Communications',
                'excerpt'      => 'The Global Health Advocacy Incubator (GHAI) Associate Director of Communications visited CHAZ to advance domestic resource mobilisation strategies for immunisation.',
                'content'      => 'LUSAKA, 16th February, 2026 – The Global Health Advocacy Incubator (GHAI) Associate Director of Communications for Health Systems visited the Churches Health Association of Zambia (CHAZ) Secretariat to discuss collaborative strategies for strengthening domestic resource mobilisation for immunisation in Zambia. The visit marks a significant step in CHAZ\'s ongoing work to ensure sustainable, government-funded immunisation programmes that reach every child, especially in rural communities.',
                'status'       => 'published',
                'published_at' => '2026-02-17 08:00:00',
                'created_at'   => now(),
                'updated_at'   => now(),
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
                'created_at'   => now(),
                'updated_at'   => now(),
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
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];
        DB::table('news')->insert($newsItems);

        // Sample jobs
        DB::table('jobs')->insert([
            [
                'title'          => 'Programme Officer – HIV & AIDS',
                'department'     => 'HIV/AIDS Programme',
                'location'       => 'Lusaka Secretariat',
                'type'           => 'Full-time',
                'description'    => 'Seeking a qualified Programme Officer to support the implementation, monitoring, and reporting of HIV/AIDS programme activities under the ATEC II Global Fund grant.',
                'duties'         => json_encode(['Coordinate programme implementation with sub-recipients','Prepare monthly, quarterly, and annual reports','Conduct supportive supervision visits','Participate in stakeholder meetings']),
                'qualifications' => json_encode(['Bachelor\'s degree in Public Health or related field','Minimum 3 years experience in HIV/AIDS programming','Experience with Global Fund grant management is an advantage','Valid driver\'s licence']),
                'deadline'       => '2026-04-15',
                'posted_at'      => '2026-03-10',
                'status'         => 'open',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        // Sample tender
        DB::table('tenders')->insert([
            [
                'reference'   => 'CHAZ/T/2026/001',
                'title'       => 'Supply and Delivery of Malaria Rapid Diagnostic Test Kits',
                'category'    => 'Medical Supplies',
                'description' => 'CHAZ invites sealed bids from eligible and qualified suppliers for the supply and delivery of Malaria RDT kits to designated health facilities across 8 provinces.',
                'issued_at'   => '2026-03-01',
                'deadline'    => '2026-03-31',
                'status'      => 'open',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // Site settings
        $settings = [
            ['key' => 'site_name',        'value' => 'Churches Health Association of Zambia', 'group' => 'general'],
            ['key' => 'tagline',          'value' => 'Guided by Christian Values',            'group' => 'general'],
            ['key' => 'contact_email',    'value' => 'info@chaz.org.zm',                      'group' => 'contact'],
            ['key' => 'contact_phone',    'value' => '+260 211 236 281',                       'group' => 'contact'],
            ['key' => 'contact_address',  'value' => 'Plot 4669, Mosi-o-Tunya Road, Lusaka',  'group' => 'contact'],
            ['key' => 'facebook_url',     'value' => '',                                       'group' => 'social'],
            ['key' => 'twitter_url',      'value' => '',                                       'group' => 'social'],
            ['key' => 'youtube_url',      'value' => 'https://www.youtube.com/channel/UCW3fQT6ecpr-hLlngrfa3OQ', 'group' => 'social'],
        ];
        foreach ($settings as $s) {
            DB::table('settings')->insert(array_merge($s, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
