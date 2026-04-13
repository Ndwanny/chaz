<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::where('active', true)->orderBy('name')->get();
        $provinces = Member::where('active', true)->distinct()->orderBy('province')->pluck('province');

        return view('members', compact('members', 'provinces'));
    }
}
