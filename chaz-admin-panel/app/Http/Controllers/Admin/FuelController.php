<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{FuelLog, Vehicle, Employee, AuditLog};
use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function index(Request $request)
    {
        $query = FuelLog::with(['vehicle', 'driver'])->latest('date');

        if ($request->filled('vehicle_id')) $query->where('vehicle_id', $request->vehicle_id);
        if ($request->filled('month'))      $query->whereMonth('date', explode('-', $request->month)[1])->whereYear('date', explode('-', $request->month)[0]);

        $logs     = $query->paginate(25)->withQueryString();
        $vehicles = Vehicle::active()->orderBy('registration')->get();

        $totalCost     = FuelLog::when($request->vehicle_id, fn($q) => $q->where('vehicle_id', $request->vehicle_id))->sum('total_cost');
        $totalLitres   = FuelLog::when($request->vehicle_id, fn($q) => $q->where('vehicle_id', $request->vehicle_id))->sum('quantity');

        return view('admin.fleet.fuel.index', compact('logs', 'vehicles', 'totalCost', 'totalLitres'));
    }

    public function create()
    {
        $vehicles = Vehicle::active()->orderBy('registration')->get();
        $drivers  = Employee::active()->where('job_title', 'like', '%driver%')->orWhereHas('driverAssignments', fn($q) => $q->current())->orderBy('first_name')->get();
        return view('admin.fleet.fuel.form', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'driver_id'     => 'nullable|exists:employees,id',
            'date'          => 'required|date',
            'fuel_type'     => 'required|in:petrol,diesel',
            'quantity'      => 'required|numeric|min:0.1',
            'unit_price'    => 'required|numeric|min:0',
            'mileage_before' => 'nullable|integer|min:0',
            'mileage_after'  => 'nullable|integer|min:0',
            'station'        => 'nullable|string|max:100',
            'receipt_number' => 'nullable|string|max:30',
            'notes'          => 'nullable|string',
        ]);

        $data['total_cost']    = $data['quantity'] * $data['unit_price'];
        $data['recorded_by']   = session('admin_id');

        if ($data['mileage_before'] && $data['mileage_after'] && $data['quantity'] > 0) {
            $data['fuel_efficiency'] = round(($data['mileage_after'] - $data['mileage_before']) / $data['quantity'], 2);
        }

        // Update vehicle mileage
        if (!empty($data['mileage_after'])) {
            Vehicle::where('id', $data['vehicle_id'])->where('current_mileage', '<', $data['mileage_after'])->update(['current_mileage' => $data['mileage_after']]);
        }

        $log = FuelLog::create($data);
        AuditLog::record('recorded_fuel', 'FuelLog', $log->id);

        return redirect()->route('admin.fleet.fuel.index')->with('success', 'Fuel log recorded.');
    }
}
