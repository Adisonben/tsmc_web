<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\User;
use App\Models\User_detail;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
        $vehicles = Vehicle::where('org_id', $org_id ?? '')->orderByDesc('id')->get();
        return view('organization.vehicle.vehicleTable', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        $vehicle_data = $request->validated();
        try {
            $vehicle_data['org_id'] = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;

            Vehicle::create($vehicle_data);

            return redirect()->back()->with(['vehicleSuccess'=> 'บันทึกข้อมูลรถสำเร็จ']);
        } catch (\Throwable $th) {
            dd("error controller : ", $th->getMessage());
            return redirect()->back()->with(['vehicleError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreVehicleRequest $request, string $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($request->validated());
            return redirect()->back()->with(['vehicleSuccess'=> 'อัพเดทข้อมูลรถสำเร็จ']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['vehicleError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
        }
    }

    public function updateData(StoreVehicleRequest $request, string $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($request->validated());
            return redirect()->back()->with(['vehicleSuccess'=> 'อัพเดทข้อมูลรถสำเร็จ']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['vehicleError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Vehicle::findOrFail($id)->delete();
            return response()->json(['success'=> 'ลบข้อมูลรถสำเร็จ']);
        } catch (\Throwable $th) {
            return response()->json(['error'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
        }
    }

    public function showVehicleAssignmentTable() {
        $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
        $users = User_detail::where('org', $org_id ?? '')->get(['user_id', 'fname', 'lname', 'prefix']);
        $vehicles = Vehicle::where('org_id', $org_id ?? '')->orderByDesc('created_at')->get(['id', 'license_plate', 'brand']);
        return view('vehicleAssignment.asssignTable', compact('users', 'vehicles'));
    }

    public function storeVehicleAssignment(Request $request, $vehicle_id) {
        $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);
        try {
            if (!VehicleAssignment::where('user_id', $request->driver_id)->where('vehicle_id', $vehicle_id)->exists()) {
                VehicleAssignment::where('user_id', $request->driver_id)->orWhere('vehicle_id', $vehicle_id)->delete();
                VehicleAssignment::create([
                    'user_id' => $request->driver_id,
                    'vehicle_id' => $vehicle_id,
                ]);
            }

            return redirect()->back()->with(['vehicleSuccess'=> 'บันทึกข้อมูลการจassignรถสำเร็จ']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['vehicleError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
        }
    }

    public function importVehicles(Request $request) {
        $request->validate([
            'vehicle_datas' => 'required',
            'vehicle_datas.*.license_plate' => [
                'required',
                'string',
                'max:255',
            ],
            'vehicle_datas.*.brand' => 'required|string|max:255',
            'vehicle_datas.*.type' => 'nullable|string|max:255',
            'vehicle_datas.*.standard' => 'nullable|string|max:255',
            'vehicle_datas.*.ins_company' => 'nullable|string|max:255',
            'vehicle_datas.*.ins_type' => 'nullable|string|max:255',
            'vehicle_datas.*.license_category' => 'nullable|string|max:255',
            'vehicle_datas.*.registration_province' => 'nullable|string|max:255',
        ]);

        try {
            $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
            $vehicle_datas = json_decode($request['vehicle_datas'], true);
            if (count($vehicle_datas) > 0) {
                foreach ($vehicle_datas as $key => $vehicle_data) {
                    $vehicle = Vehicle::where('license_plate', $vehicle_data['license_plate'])->where('org_id', $org_id);
                    if ($vehicle->withTrashed()->exists()) {
                        if ($vehicle->onlyTrashed()->exists()) {
                            $vehicle->onlyTrashed()->restore();
                        }
                        $vehicle->update($vehicle_data);
                    } else {
                        $vehicle_data['org_id'] = $org_id;
                        Vehicle::create($vehicle_data);
                    }
                }
            }
            return response()->json(['success'=> 'บันทึกข้อมูลรถสำเร็จ']);
        } catch (\Throwable $th) {
            return response()->json(['error'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง " . $th->getMessage()]);
        }
    }
}
