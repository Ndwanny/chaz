<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;

class DownloadsController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(20);
        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.downloads.form', [
            'download' => null,
            'action'   => route('admin.downloads.store'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|in:publication,annual_report,newsletter',
            'type'         => 'nullable|string|max:100',
            'year'         => 'nullable|digits:4',
            'issue'        => 'nullable|string|max:100',
            'pages'        => 'nullable|integer|min:1',
            'description'  => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('downloads', 'public');
            $data['file_size'] = round($file->getSize() / 1048576, 1) . ' MB';
        }

        Download::create($data);
        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download added successfully.');
    }

    public function edit(Download $download)
    {
        return view('admin.downloads.form', [
            'download' => $download,
            'action'   => route('admin.downloads.update', $download),
        ]);
    }

    public function update(Request $request, Download $download)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|in:publication,annual_report,newsletter',
            'type'         => 'nullable|string|max:100',
            'year'         => 'nullable|digits:4',
            'issue'        => 'nullable|string|max:100',
            'pages'        => 'nullable|integer|min:1',
            'description'  => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('downloads', 'public');
            $data['file_size'] = round($file->getSize() / 1048576, 1) . ' MB';
        }

        $download->update($data);
        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download updated successfully.');
    }

    public function destroy(Download $download)
    {
        $download->delete();
        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download deleted.');
    }
}
