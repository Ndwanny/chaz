<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{TripLog, Vehicle, Employee, AuditLog};
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = TripLog::with(['vehicle', 'driver'])->latest('departure_date');

        if ($request->filled('status'))     $query->where('status', $request->status);
        if ($request->filled('vehicle_id')) $query->where('vehicle_id', $request->vehicle_id);

        $trips    = $query->paginate(20)->withQueryString();
        $vehicles = Vehicle::active()->orderBy('registration_number')->get();

        return view('admin.fleet.trips.index', compact('trips', 'vehicles'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->orderBy('registration_number')->get();
        $drivers  = Employee::active()->orderBy('first_name')->get();
        return view('admin.fleet.trips.form', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'         => 'required|exists:vehicles,id',
            'driver_id'          => 'required|exists:employees,id',
            'purpose'            => 'required|string|max:300',
            'destination'        => 'required|string|max:200',
            'departure_location' => 'required|string|max:200',
            'departure_date'     => 'required|date',
            'departure_time'     => 'nullable|date_format:H:i',
            'return_date'        => 'nullable|date|after_or_equal:departure_date',
            'return_time'        => 'nullable|date_format:H:i',
            'passenger_count'    => 'nullable|integer|min:0',
            'notes'              => 'nullable|string',
        ]);

        $data['trip_number'] = TripLog::generateTripNumber();
        $data['created_by']  = session('admin_id');
        $data['status']      = 'pending';

        $trip = TripLog::create($data);
        AuditLog::record('created_trip', 'TripLog', $trip->id);

        return redirect()->route('admin.fleet.trips.index')->with('success', 'Trip request ' . $trip->trip_number . ' created.');
    }

    public function approve(TripLog $trip)
    {
        $trip->update(['status' => 'approved', 'authorized_by' => session('admin_id')]);
        Vehicle::where('id', $trip->vehicle_id)->update(['status' => 'active']);
        AuditLog::record('approved_trip', 'TripLog', $trip->id);
        return back()->with('success', 'Trip approved.');
    }

    public function depart(TripLog $trip)
    {
        $trip->update(['status' => 'ongoing', 'starting_odometer' => $trip->vehicle->current_mileage]);
        AuditLog::record('trip_departed', 'TripLog', $trip->id);
        return back()->with('success', 'Trip marked as departed.');
    }

    public function complete(Request $request, TripLog $trip)
    {
        $request->validate(['ending_odometer' => 'required|integer|min:0']);
        $dist = $trip->starting_odometer ? ($request->ending_odometer - $trip->starting_odometer) : null;
        $trip->update([
            'status'          => 'completed',
            'return_date'     => now()->toDateString(),
            'ending_odometer' => $request->ending_odometer,
            'distance_km'     => $dist,
        ]);
        Vehicle::where('id', $trip->vehicle_id)->update(['status' => 'available', 'current_mileage' => $request->ending_odometer]);
        AuditLog::record('completed_trip', 'TripLog', $trip->id);
        return back()->with('success', 'Trip completed.');
    }
}
