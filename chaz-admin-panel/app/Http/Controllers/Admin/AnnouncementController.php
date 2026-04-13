<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Announcement, AuditLog};
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('createdBy')->latest()->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:200',
            'content'            => 'required|string',
            'category'           => 'required|in:general,hr,finance,it,operations,event,urgent',
            'priority'           => 'required|in:low,normal,high,urgent',
            'target_audience'    => 'required|in:all,staff,management,department',
            'target_departments' => 'nullable|array',
            'target_departments.*' => 'integer|exists:departments,id',
            'is_published'       => 'boolean',
            'expires_at'         => 'nullable|date|after:now',
            'attachment'         => 'nullable|file|mimes:pdf,docx,jpg,png|max:10240',
        ]);

        $data['created_by']   = session('admin_id');
        $data['is_published'] = $request->boolean('is_published');

        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('announcements', 'public');
        }

        $announcement = Announcement::create($data);
        AuditLog::record('created_announcement', 'Announcement', $announcement->id);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement published.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:200',
            'content'            => 'required|string',
            'category'           => 'required|in:general,hr,finance,it,operations,event,urgent',
            'priority'           => 'required|in:low,normal,high,urgent',
            'target_audience'    => 'required|in:all,staff,management,department',
            'target_departments' => 'nullable|array',
            'is_published'       => 'boolean',
            'expires_at'         => 'nullable|date|after:now',
        ]);

        $data['updated_by']   = session('admin_id');
        $data['is_published'] = $request->boolean('is_published');

        if ($data['is_published'] && !$announcement->published_at) {
            $data['published_at'] = now();
        }

        $announcement->update($data);
        AuditLog::record('updated_announcement', 'Announcement', $announcement->id);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        AuditLog::record('deleted_announcement', 'Announcement', $announcement->id);
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
}
