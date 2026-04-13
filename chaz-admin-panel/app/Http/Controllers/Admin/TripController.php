<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{TripLog, Vehicle, Employee, AuditLog};
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = TripLog::with(['vehicle', 'driver'])->latest('departure_datetime');

        if ($request->filled('status'))     $query->where('status', $request->status);
        if ($request->filled('vehicle_id')) $query->where('vehicle_id', $request->vehicle_id);

        $trips    = $query->paginate(20)->withQueryString();
        $vehicles = Vehicle::active()->orderBy('registration')->get();

        return view('admin.fleet.trips.index', compact('trips', 'vehicles'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->orderBy('registration')->get();
        $drivers  = Employee::active()->orderBy('first_name')->get();
        return view('admin.fleet.trips.form', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'          => 'required|exists:vehicles,id',
            'driver_id'           => 'required|exists:employees,id',
            'purpose'             => 'required|string|max:300',
            'destination'         => 'required|string|max:200',
            'departure_location'  => 'required|string|max:200',
            'departure_datetime'  => 'required|date',
            'return_datetime'     => 'nullable|date|after:departure_datetime',
            'notes'               => 'nullable|string',
        ]);

        $data['trip_number']  = TripLog::generateTripNumber();
        $data['requested_by'] = session('admin_id');
        $data['status']       = 'pending';

        $trip = TripLog::create($data);
        AuditLog::record('created_trip', 'TripLog', $trip->id);

        return redirect()->route('admin.fleet.trips.index')->with('success', 'Trip request ' . $trip->trip_number . ' created.');
    }

    public function approve(TripLog $trip)
    {
        $trip->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);
        Vehicle::where('id', $trip->vehicle_id)->update(['status' => 'active']);
        AuditLog::record('approved_trip', 'TripLog', $trip->id);
        return back()->with('success', 'Trip approved.');
    }

    public function depart(TripLog $trip)
    {
        $trip->update(['status' => 'ongoing', 'actual_departure' => now(), 'start_mileage' => $trip->vehicle->current_mileage]);
        AuditLog::record('trip_departed', 'TripLog', $trip->id);
        return back()->with('success', 'Trip marked as departed.');
    }

    public function complete(Request $request, TripLog $trip)
    {
        $request->validate(['end_mileage' => 'required|integer|min:0']);
        $trip->update(['status' => 'completed', 'actual_return' => now(), 'end_mileage' => $request->end_mileage]);
        Vehicle::where('id', $trip->vehicle_id)->update(['status' => 'available', 'current_mileage' => $request->end_mileage]);
        AuditLog::record('completed_trip', 'TripLog', $trip->id);
        return back()->with('success', 'Trip completed.');
    }
}
