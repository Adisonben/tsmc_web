<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Car_type;
use Illuminate\Http\Request;
use Str;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        $car_types = Car_type::all();
        return view('organization.car.carTable', compact('cars', 'car_types'));
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
    public function store(Request $request)
    {
        try {
            $newCar = Car::create([
                'car_id' => Str::uuid(),
                'model' => $request->model,
                'plate_num' => $request->platNum,
                'gear_type' => $request->carGear,
                'car_type' => $request->carType,
                'owner_org' => $request->user()->userDetail->org ?? null,
                'created_by' => $request->user()->id,
            ]);

            return redirect()->back()->with(['carSuccess'=> 'บันทึกข้อมูลรถสำเร็จ']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['carError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง" . $th->getMessage()]);
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
    public function update(Request $request, string $id)
    {
        try {
            $newCar = Car::where('id', $id)->update([
                'model' => $request->model,
                'plate_num' => $request->platNum,
                'gear_type' => $request->carGear,
                'car_type' => $request->carType,
            ]);

            return redirect()->back()->with(['carSuccess'=> 'แก้ไขข้อมูลรถสำเร็จ']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['carError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Car::where('id', $id)->delete();
            return response()->json([
                'message' => 'Data deleted successfully : ' . $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getCarDetail($carId) {
        $getCar = Car::findOrFail($carId);
        $cardetail = [
            "carModel" => $getCar->model,
            "carType" => $getCar->getType->name
        ];
        return $cardetail;
    }
}
