<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.form', ['job' => null, 'action' => route('admin.jobs.store')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'department'     => 'required|string|max:150',
            'location'       => 'required|string|max:150',
            'type'           => 'required|string|max:60',
            'description'    => 'required|string',
            'duties'         => 'required|string',
            'qualifications' => 'required|string',
            'deadline'       => 'required|date',
            'posted_at'      => 'required|date',
            'status'         => 'required|in:open,closed',
        ]);

        $data['duties']         = array_filter(array_map('trim', explode("\n", $data['duties'])));
        $data['qualifications'] = array_filter(array_map('trim', explode("\n", $data['qualifications'])));

        Job::create($data);
        return redirect()->route('admin.jobs.index')->with('success', 'Job posting created.');
    }

    public function edit(Job $job)
    {
        return view('admin.jobs.form', ['job' => $job, 'action' => route('admin.jobs.update', $job)]);
    }

    public function update(Request $request, Job $job)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'department'     => 'required|string|max:150',
            'location'       => 'required|string|max:150',
            'type'           => 'required|string|max:60',
            'description'    => 'required|string',
            'duties'         => 'required|string',
            'qualifications' => 'required|string',
            'deadline'       => 'required|date',
            'posted_at'      => 'required|date',
            'status'         => 'required|in:open,closed',
        ]);

        $data['duties']         = array_filter(array_map('trim', explode("\n", $data['duties'])));
        $data['qualifications'] = array_filter(array_map('trim', explode("\n", $data['qualifications'])));

        $job->update($data);
        return redirect()->route('admin.jobs.index')->with('success', 'Job posting updated.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job posting deleted.');
    }
}
