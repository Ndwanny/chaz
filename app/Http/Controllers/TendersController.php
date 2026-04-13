<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\SubRecipientAdvert;
use Illuminate\Http\Request;

class TendersController extends Controller
{
    public function index()
    {
        $tenders = Tender::latest('issued_at')->get();
        return view('tenders.index', compact('tenders'));
    }

    public function subRecipientAdverts()
    {
        $adverts = SubRecipientAdvert::latest('created_at')->get();
        return view('tenders.sub-recipient-adverts', compact('adverts'));
    }
}
