<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $programmes = [
            ['icon' => 'fa-virus-slash',   'title' => 'HIV & AIDS',          'desc' => 'Comprehensive ART, viral load suppression, PMTCT, and PrEP services across all 10 provinces.'],
            ['icon' => 'fa-lungs',         'title' => 'Tuberculosis (TB)',    'desc' => 'Genomics-based surveillance, drug-resistant TB management, and community screening programmes.'],
            ['icon' => 'fa-mosquito',      'title' => 'Malaria',             'desc' => '25% reduction in malaria cases achieved through last-mile delivery of prevention and treatment commodities.'],
            ['icon' => 'fa-syringe',       'title' => 'Immunisation',        'desc' => 'National immunisation campaigns and domestic resource mobilisation for sustainable vaccine supply.'],
            ['icon' => 'fa-baby',          'title' => 'Maternal & Child Health', 'desc' => 'Mother\'s waiting shelters, antenatal care at the doorstep, and safe delivery support.'],
            ['icon' => 'fa-flask',         'title' => 'Laboratory Services', 'desc' => 'Quality assured laboratory network with five sub-units supporting diagnostics, logistics, and research.'],
        ];

        return view('about', compact('programmes'));
    }

    public function board()
    {
        $trustees = [
            ['name' => 'Rev. Dr. John Banda',       'role' => 'Chairperson',            'org' => 'United Church of Zambia', 'initials' => 'JB'],
            ['name' => 'Dr. Mary Phiri',             'role' => 'Vice Chairperson',       'org' => 'Catholic Diocese of Lusaka', 'initials' => 'MP'],
            ['name' => 'Mr. David Mwale',            'role' => 'Treasurer',              'org' => 'Evangelical Fellowship of Zambia', 'initials' => 'DM'],
            ['name' => 'Dr. Grace Mutale',           'role' => 'Board Member – Medical', 'org' => 'Adventist Health Services', 'initials' => 'GM'],
            ['name' => 'Eng. Patrick Zulu',          'role' => 'Board Member – Finance', 'org' => 'Reformed Church of Zambia', 'initials' => 'PZ'],
            ['name' => 'Adv. Chanda Musonda',        'role' => 'Board Member – Legal',   'org' => 'Anglican Church of Zambia', 'initials' => 'CM'],
            ['name' => 'Prof. Esther Mumba',         'role' => 'Board Member – Nursing', 'org' => 'Baptist Convention of Zambia', 'initials' => 'EM'],
            ['name' => 'Dr. Francis Tembo',          'role' => 'Board Member – Pharmacy','org' => 'Christian Mission in Many Lands', 'initials' => 'FT'],
            ['name' => 'Mrs. Natasha Lungu',         'role' => 'Board Member – HR',      'org' => 'Brethren in Christ Church Zambia', 'initials' => 'NL'],
        ];

        return view('about-board', compact('trustees'));
    }
}
