<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;

class TendersController extends Controller
{
    public function index()
    {
        $tenders = Tender::latest()->paginate(15);
        return view('admin.tenders.index', compact('tenders'));
    }

    public function create()
    {
        return view('admin.tenders.form', ['tender' => null, 'action' => route('admin.tenders.store')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference'   => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'required|string',
            'issued_at'   => 'required|date',
            'deadline'    => 'required|date',
            'status'      => 'required|in:open,closed,awarded',
        ]);

        Tender::create($data);
        return redirect()->route('admin.tenders.index')->with('success', 'Tender created successfully.');
    }

    public function edit(Tender $tender)
    {
        return view('admin.tenders.form', ['tender' => $tender, 'action' => route('admin.tenders.update', $tender)]);
    }

    public function update(Request $request, Tender $tender)
    {
        $data = $request->validate([
            'reference'   => 'required|string|max:100',
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'required|string',
            'issued_at'   => 'required|date',
            'deadline'    => 'required|date',
            'status'      => 'required|in:open,closed,awarded',
        ]);

        $tender->update($data);
        return redirect()->route('admin.tenders.index')->with('success', 'Tender updated successfully.');
    }

    public function destroy(Tender $tender)
    {
        $tender->delete();
        return redirect()->route('admin.tenders.index')->with('success', 'Tender deleted.');
    }
}
