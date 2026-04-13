<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Vehicle, VehicleCategory, VehicleInsurance, Department, Employee, AuditLog};
use Illuminate\Http\Request;

class FleetController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with(['category', 'department', 'assignedDriver', 'currentInsurance'])->orderBy('registration');

        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);

        $vehicles   = $query->paginate(20)->withQueryString();
        $categories = VehicleCategory::active()->get();

        return view('admin.fleet.vehicles.index', compact('vehicles', 'categories'));
    }

    public function create()
    {
        $categories  = VehicleCategory::active()->get();
        $departments = Department::active()->orderBy('name')->get();
        $drivers     = Employee::active()->orderBy('first_name')->get();
        return view('admin.fleet.vehicles.form', compact('categories', 'departments', 'drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'registration'      => 'required|string|max:20|unique:vehicles,registration',
            'make'              => 'required|string|max:60',
            'model'             => 'required|string|max:60',
            'year'              => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'color'             => 'nullable|string|max:30',
            'category_id'       => 'required|exists:vehicle_categories,id',
            'department_id'     => 'nullable|exists:departments,id',
            'chassis_number'    => 'nullable|string|max:50',
            'engine_number'     => 'nullable|string|max:50',
            'fuel_type'         => 'required|in:petrol,diesel,electric,hybrid',
            'engine_capacity'   => 'nullable|string|max:20',
            'seating_capacity'  => 'nullable|integer|min:1',
            'purchase_date'     => 'nullable|date',
            'purchase_price'    => 'nullable|numeric|min:0',
            'current_mileage'   => 'nullable|integer|min:0',
            'status'            => 'required|in:available,active,maintenance,out_of_service',
        ]);

        $vehicle = Vehicle::create($data);
        AuditLog::record('created_vehicle', 'Vehicle', $vehicle->id);

        return redirect()->route('admin.fleet.vehicles.index')->with('success', 'Vehicle ' . $vehicle->registration . ' added.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['category', 'department', 'assignedDriver', 'insurances', 'fuelLogs' => fn($q) => $q->latest()->limit(10), 'maintenanceRecords' => fn($q) => $q->latest()->limit(10), 'tripLogs' => fn($q) => $q->latest()->limit(10)]);
        return view('admin.fleet.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $categories  = VehicleCategory::active()->get();
        $departments = Department::active()->orderBy('name')->get();
        $drivers     = Employee::active()->orderBy('first_name')->get();
        return view('admin.fleet.vehicles.form', compact('vehicle', 'categories', 'departments', 'drivers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'registration'     => 'required|string|max:20|unique:vehicles,registration,' . $vehicle->id,
            'make'             => 'required|string|max:60',
            'model'            => 'required|string|max:60',
            'year'             => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'color'            => 'nullable|string|max:30',
            'category_id'      => 'required|exists:vehicle_categories,id',
            'department_id'    => 'nullable|exists:departments,id',
            'fuel_type'        => 'required|in:petrol,diesel,electric,hybrid',
            'seating_capacity' => 'nullable|integer|min:1',
            'current_mileage'  => 'nullable|integer|min:0',
            'status'           => 'required|in:available,active,maintenance,out_of_service',
        ]);

        $vehicle->update($data);
        AuditLog::record('updated_vehicle', 'Vehicle', $vehicle->id);

        return redirect()->route('admin.fleet.vehicles.show', $vehicle)->with('success', 'Vehicle updated.');
    }

    // Insurance
    public function storeInsurance(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'insurer'          => 'required|string|max:100',
            'policy_number'    => 'required|string|max:60',
            'insurance_type'   => 'required|in:comprehensive,third_party,fire_and_theft',
            'start_date'       => 'required|date',
            'expiry_date'      => 'required|date|after:start_date',
            'premium_amount'   => 'required|numeric|min:0',
            'coverage_amount'  => 'nullable|numeric|min:0',
        ]);

        // Deactivate old
        $vehicle->insurances()->where('status', 'active')->update(['status' => 'superseded']);

        $data['vehicle_id'] = $vehicle->id;
        $data['status']     = 'active';
        VehicleInsurance::create($data);

        AuditLog::record('added_vehicle_insurance', 'Vehicle', $vehicle->id);

        return back()->with('success', 'Insurance record added.');
    }
}
