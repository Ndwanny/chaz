<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::published()->latest('published_at')->take(3)->get();

        $achievements = [
            ['num' => '97.6', 'suffix' => '%', 'label' => 'Viral Suppression among PLHIV',           'icon' => 'fa-virus-slash'],
            ['num' => '25',   'suffix' => '%', 'label' => 'Reduction in Malaria Cases',               'icon' => 'fa-mosquito-net'],
            ['num' => '98.8', 'suffix' => '%', 'label' => 'Mother-to-Child HIV Transmissions Averted','icon' => 'fa-heart-pulse'],
            ['num' => '39',   'suffix' => '%', 'label' => 'Increase in PrEP Uptake (Adolescents)',    'icon' => 'fa-shield-heart'],
        ];

        return view('home', compact('news', 'achievements'));
    }
}
