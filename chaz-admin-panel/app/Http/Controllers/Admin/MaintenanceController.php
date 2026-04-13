<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{MaintenanceRecord, Vehicle, AuditLog};
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRecord::with('vehicle')->latest('service_date');

        if ($request->filled('vehicle_id')) $query->where('vehicle_id', $request->vehicle_id);
        if ($request->filled('status'))     $query->where('status', $request->status);

        $records  = $query->paginate(20)->withQueryString();
        $vehicles = Vehicle::orderBy('registration')->get();

        // Upcoming due
        $upcoming = MaintenanceRecord::with('vehicle')
            ->where('next_service_date', '<=', now()->addDays(30))
            ->where('status', '!=', 'completed')
            ->orderBy('next_service_date')
            ->get();

        return view('admin.fleet.maintenance.index', compact('records', 'vehicles', 'upcoming'));
    }

    public function create()
    {
        $vehicles = Vehicle::active()->orderBy('registration')->get();
        return view('admin.fleet.maintenance.form', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'          => 'required|exists:vehicles,id',
            'maintenance_type'    => 'required|in:preventive,corrective,inspection,tyres,oil_change,service',
            'description'         => 'required|string|max:500',
            'service_date'        => 'required|date',
            'next_service_date'   => 'nullable|date|after:service_date',
            'mileage_at_service'  => 'nullable|integer|min:0',
            'next_service_mileage'=> 'nullable|integer|min:0',
            'cost'                => 'required|numeric|min:0',
            'service_provider'    => 'nullable|string|max:150',
            'invoice_number'      => 'nullable|string|max:30',
            'status'              => 'required|in:pending,in_progress,completed,scheduled',
            'notes'               => 'nullable|string',
        ]);

        $data['performed_by'] = session('admin_id');

        // Set vehicle to maintenance status if in_progress
        if ($data['status'] === 'in_progress') {
            Vehicle::where('id', $data['vehicle_id'])->update(['status' => 'maintenance']);
        }

        $record = MaintenanceRecord::create($data);
        AuditLog::record('recorded_maintenance', 'MaintenanceRecord', $record->id);

        return redirect()->route('admin.fleet.maintenance.index')->with('success', 'Maintenance record saved.');
    }

    public function complete(Request $request, MaintenanceRecord $record)
    {
        $record->update(['status' => 'completed']);
        // Return vehicle to available if no other ongoing maintenance
        $ongoing = MaintenanceRecord::where('vehicle_id', $record->vehicle_id)->where('status', 'in_progress')->exists();
        if (!$ongoing) {
            Vehicle::where('id', $record->vehicle_id)->where('status', 'maintenance')->update(['status' => 'available']);
        }
        AuditLog::record('completed_maintenance', 'MaintenanceRecord', $record->id);
        return back()->with('success', 'Maintenance marked as completed.');
    }
}
