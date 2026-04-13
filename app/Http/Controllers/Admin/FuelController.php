<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{FuelLog, Vehicle, Employee, AuditLog};
use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function index(Request $request)
    {
        $query = FuelLog::with(['vehicle', 'driver'])->latest('log_date');

        if ($request->filled('vehicle_id')) $query->where('vehicle_id', $request->vehicle_id);
        if ($request->filled('month'))      $query->whereMonth('log_date', explode('-', $request->month)[1])->whereYear('log_date', explode('-', $request->month)[0]);

        $logs     = $query->paginate(25)->withQueryString();
        $vehicles = Vehicle::active()->orderBy('registration_number')->get();

        $totalCost   = FuelLog::when($request->vehicle_id, fn($q) => $q->where('vehicle_id', $request->vehicle_id))->sum('total_cost');
        $totalLitres = FuelLog::when($request->vehicle_id, fn($q) => $q->where('vehicle_id', $request->vehicle_id))->sum('litres');

        return view('admin.fleet.fuel.index', compact('logs', 'vehicles', 'totalCost', 'totalLitres'));
    }

    public function create()
    {
        $vehicles = Vehicle::active()->orderBy('registration_number')->get();
        $drivers  = Employee::active()->orderBy('first_name')->get();
        return view('admin.fleet.fuel.form', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'       => 'required|exists:vehicles,id',
            'driver_id'        => 'nullable|exists:employees,id',
            'log_date'         => 'required|date',
            'litres'           => 'required|numeric|min:0.1',
            'unit_cost'        => 'required|numeric|min:0',
            'odometer_reading' => 'nullable|integer|min:0',
            'fuel_station'     => 'nullable|string|max:100',
            'receipt_number'   => 'nullable|string|max:30',
            'notes'            => 'nullable|string',
        ]);

        $data['total_cost'] = $data['litres'] * $data['unit_cost'];
        $data['created_by'] = session('admin_id');

        // Update vehicle odometer if higher
        if (!empty($data['odometer_reading'])) {
            Vehicle::where('id', $data['vehicle_id'])
                ->where('current_mileage', '<', $data['odometer_reading'])
                ->update(['current_mileage' => $data['odometer_reading']]);
        }

        $log = FuelLog::create($data);
        AuditLog::record('recorded_fuel', 'FuelLog', $log->id);

        return redirect()->route('admin.fleet.fuel.index')->with('success', 'Fuel log recorded.');
    }
}
