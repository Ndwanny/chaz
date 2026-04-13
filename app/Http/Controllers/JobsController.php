<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index()
    {
        $jobs = Job::open()->latest('posted_at')->get();
        return view('jobs', compact('jobs'));
    }

    public function show(int $id)
    {
        $job = Job::findOrFail($id);
        return view('jobs-show', compact('job'));
    }
}
