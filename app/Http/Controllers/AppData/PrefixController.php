<?php

namespace App\Http\Controllers\AppData;

use App\Http\Controllers\Controller;
use App\Models\Prefix;
use Illuminate\Http\Request;

class PrefixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prefixes = Prefix::orderByDesc('id')->get();
        return view('appData.prefix.prefixTable', compact('prefixes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appData.prefix.createPrefixForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Prefix::create([
                'name' => $request->prefixName,
            ]);
            return redirect()->route('prefixes.index')->with(['success' => "เพิ่มคำนำหน้าสำเร็จ"]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => "ไม่สามารถเพิ่มคำนำหน้า"]);
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
        $prefix = Prefix::find($id);
        return view('appData.prefix.editPrefixForm', compact('prefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            Prefix::where('id', $id)->update([
                'name' => $request->prefixName,
            ]);
            return response()->json([
                'message' => 'แก้ไขคำนำหน้าสำเร็จ'
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
            Prefix::where('id', $id)->delete();
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
