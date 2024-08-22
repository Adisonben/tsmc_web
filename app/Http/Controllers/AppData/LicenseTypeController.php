<?php

namespace App\Http\Controllers\AppData;

use App\Http\Controllers\Controller;
use App\Models\License_type;
use Illuminate\Http\Request;

class LicenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $license_types = License_type::orderByDesc('id')->get();
        return view('appData.licenseType.licenseTypeTable', compact('license_types'));
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
            License_type::create([
                'name' => $request->licTypeName,
            ]);
            return response()->json([
                'message' => 'License type create successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
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
            License_type::where('id', $id)->update([
                'name' => $request->licTypeName,
            ]);
            return response()->json([
                'message' => 'แก้ไขประเภทใบขับขี่สำเร็จ'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            License_type::where('id', $id)->delete();
            return response()->json([
                'message' => 'Data deleted successfully : ' . $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
