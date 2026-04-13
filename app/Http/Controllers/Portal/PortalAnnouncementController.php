<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\{Announcement, Employee};

class PortalAnnouncementController extends Controller
{
    public function index()
    {
        $employee = Employee::find(session('portal_employee_id'));

        $announcements = Announcement::where('is_published', true)
            ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
            ->where(fn($q) => $q->where('target_audience', 'all')
                ->orWhere(fn($q2) => $q2->where('target_audience', 'department')
                    ->where('target_id', $employee->department_id)))
            ->orderByDesc('priority')->orderByDesc('published_at')
            ->paginate(15);

        return view('portal.announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        try { $announcement->increment('view_count'); } catch (\Exception $e) {}
        return view('portal.announcements.show', compact('announcement'));
    }
}
