<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all();
        $dpms = Department::all();
        return view('organization.position.positionTable', compact('positions', 'dpms'));
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
            $newPosition = Position::create([
                'name' => $request->positName,
                'created_by' => $request->user()->id,
                'org' => $request->user()->userDetail->org ?? null,
            ]);
            if ($request->parent && $request->parent !== '-') {
                $parent = Position::find($request->parent);
                $parent->appendNode($newPosition);
            } elseif ($request->parent && $request->parent === '-') {
                $newPosition->saveAsRoot();
            }

            return redirect()->back()->with(['positSuccess'=> 'สร้างตำแหน่งสำเร็จ']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['positError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
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
            $updPosition = Position::where('id', $id)->firstOrFail();
            $updPosition->update([
                'name' => $request->positName,
            ]);
            if ($request->parent && $request->parent !== '-') {
                $parent = Position::find($request->parent);
                $parent->appendNode($updPosition);
            } elseif ($request->parent && $request->parent === '-') {
                $updPosition->saveAsRoot();
            }

            return redirect()->back()->with(['positSuccess'=> 'แก้ไขตำแหน่งสำเร็จ']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['positError'=> "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Position::where('id', $id)->delete();
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
