<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;

class DownloadsController extends Controller
{
    public function index()
    {
        return view('downloads.index');
    }

    public function publications()
    {
        $publications = Download::where('category', 'publication')
            ->latest('published_at')
            ->get();
        return view('downloads.publications', compact('publications'));
    }

    public function annualReports()
    {
        $reports = Download::where('category', 'annual_report')
            ->orderBy('year', 'desc')
            ->get();
        return view('downloads.annual-reports', compact('reports'));
    }

    public function newsletters()
    {
        $newsletters = Download::where('category', 'newsletter')
            ->latest('published_at')
            ->get();
        return view('downloads.newsletters', compact('newsletters'));
    }
}
