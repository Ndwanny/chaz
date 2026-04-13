<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Download;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

// ── Members ─────────────────────────────────────────────────────────────────
class MembersController extends Controller
{
    public function index()   { $members = Member::orderBy('province')->orderBy('name')->paginate(20); return view('admin.members.index', compact('members')); }
    public function create()  { return view('admin.members.form', ['member' => null, 'action' => route('admin.members.store')]); }
    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:255','type'=>'required|in:hospital,centre,cbo','province'=>'required|string|max:100','denomination'=>'required|string|max:200','district'=>'nullable|string|max:100','contact'=>'nullable|string|max:100','active'=>'boolean']);
        $data['active'] = $request->boolean('active', true);
        Member::create($data);
        return redirect()->route('admin.members.index')->with('success','Member institution added.');
    }
    public function edit(Member $member)  { return view('admin.members.form', ['member' => $member, 'action' => route('admin.members.update', $member)]); }
    public function update(Request $request, Member $member)
    {
        $data = $request->validate(['name'=>'required|string|max:255','type'=>'required|in:hospital,centre,cbo','province'=>'required|string|max:100','denomination'=>'required|string|max:200','district'=>'nullable|string|max:100','contact'=>'nullable|string|max:100']);
        $data['active'] = $request->boolean('active', true);
        $member->update($data);
        return redirect()->route('admin.members.index')->with('success','Member updated.');
    }
    public function destroy(Member $member) { $member->delete(); return redirect()->route('admin.members.index')->with('success','Member deleted.'); }
}
