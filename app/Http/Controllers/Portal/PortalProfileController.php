<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\{Employee, PerformanceReview};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PortalProfileController extends Controller
{
    public function show()
    {
        $employee = Employee::with(['department','salaryGrade'])->find(session('portal_employee_id'));
        $reviews  = PerformanceReview::where('employee_id', $employee->id)
            ->latest('period_end')->get();
        return view('portal.profile.show', compact('employee', 'reviews'));
    }

    public function changePassword(Request $request)
    {
        $employee = Employee::find(session('portal_employee_id'));

        $rules = ['new_password' => 'required|string|min:8|confirmed'];
        if ($employee->portal_password) {
            $rules['current_password'] = 'required|string';
        }

        $validated = $request->validateWithBag('password', $rules);

        // Verify current password when one is set
        if ($employee->portal_password) {
            if (!Hash::check($request->current_password, $employee->portal_password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'], 'password');
            }
        }

        $employee->update(['portal_password' => Hash::make($request->new_password)]);
        return back()->with('success', 'Password changed successfully.');
    }

    public function updateContact(Request $request)
    {
        $request->validateWithBag('contact', [
            'address'                        => 'nullable|string|max:300',
            'province'                       => 'nullable|string|max:100',
            'district'                       => 'nullable|string|max:100',
            'emergency_contact_name'         => 'nullable|string|max:100',
            'emergency_contact_phone'        => 'nullable|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:60',
        ]);

        $employee = Employee::find(session('portal_employee_id'));
        $employee->update($request->only([
            'address', 'province', 'district',
            'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship',
        ]));

        return back()->with('success', 'Contact information updated.');
    }
}
