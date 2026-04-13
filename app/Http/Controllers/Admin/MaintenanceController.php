<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{MaintenanceRecord, Vehicle, AuditLog};
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRecord::with('vehicle')->latest('start_date');

        if ($request->filled('vehicle_id')) $query->where('vehicle_id', $request->vehicle_id);
        if ($request->filled('status'))     $query->where('status', $request->status);

        $records  = $query->paginate(20)->withQueryString();
        $vehicles = Vehicle::orderBy('registration_number')->get();

        $upcoming = MaintenanceRecord::with('vehicle')
            ->where('next_service_date', '<=', now()->addDays(30))
            ->where('status', '!=', 'completed')
            ->orderBy('next_service_date')
            ->get();

        return view('admin.fleet.maintenance.index', compact('records', 'vehicles', 'upcoming'));
    }

    public function create()
    {
        $vehicles = Vehicle::active()->orderBy('registration_number')->get();
        return view('admin.fleet.maintenance.form', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'           => 'required|exists:vehicles,id',
            'maintenance_type'     => 'required|in:preventive,corrective,inspection,tyres,oil_change,service',
            'description'          => 'required|string|max:500',
            'start_date'           => 'required|date',
            'end_date'             => 'nullable|date|after_or_equal:start_date',
            'next_service_date'    => 'nullable|date',
            'mileage_at_service'   => 'nullable|integer|min:0',
            'next_service_mileage' => 'nullable|integer|min:0',
            'cost'                 => 'required|numeric|min:0',
            'workshop'             => 'nullable|string|max:150',
            'invoice_number'       => 'nullable|string|max:30',
            'status'               => 'required|in:pending,in_progress,completed,scheduled',
            'notes'                => 'nullable|string',
        ]);

        $data['created_by'] = session('admin_id');

        if ($data['status'] === 'in_progress') {
            Vehicle::where('id', $data['vehicle_id'])->update(['status' => 'maintenance']);
        }

        $record = MaintenanceRecord::create($data);
        AuditLog::record('recorded_maintenance', 'MaintenanceRecord', $record->id);

        return redirect()->route('admin.fleet.maintenance.index')->with('success', 'Maintenance record saved.');
    }

    public function complete(Request $request, MaintenanceRecord $record)
    {
        $record->update(['status' => 'completed', 'end_date' => now()->toDateString()]);
        $ongoing = MaintenanceRecord::where('vehicle_id', $record->vehicle_id)->where('status', 'in_progress')->exists();
        if (!$ongoing) {
            Vehicle::where('id', $record->vehicle_id)->where('status', 'maintenance')->update(['status' => 'available']);
        }
        AuditLog::record('completed_maintenance', 'MaintenanceRecord', $record->id);
        return back()->with('success', 'Maintenance marked as completed.');
    }
}
