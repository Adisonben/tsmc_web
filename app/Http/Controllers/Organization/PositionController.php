<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use App\Models\Position_has_permission;
use App\Models\Position_permission;
use App\Models\PositionHasForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ((Auth()->user()->userDetail->org ?? false) || Auth()->user()->is_tsm) {
            $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
            $positions = Position::where('org', $org_id)->orWhereNull('org')->get();
        } else {
            $positions = Position::paginate(10);
        }
        return view('organization.position.positionTable', compact('positions'));
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
            $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
            $newPosition = Position::create([
                'name' => $request->positName,
                'created_by' => $request->user()->id,
                'org' => $org_id,
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

    public function managePermission() {
        if ((Auth()->user()->userDetail->org ?? false) || Auth()->user()->is_tsm) {
            $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
            $positions = Position::where('org', $org_id)->orWhereNull('org')->get();
        } else {
            $positions = Position::all();
        }
        $posit_perms = Position_permission::all();
        return view('organization.perm.managePerm', compact('positions', 'posit_perms'));
    }

    public function updatePermission($positId , $permId , $status, $checkType) {
        try {
            $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org ?? null;
            if ($checkType === "perm") {
                $permExist = Position_has_permission::where('position_id', $positId)->where('permission_id', $permId)->where('org', $org_id)->exists();
                $permNullExist = Position_has_permission::where('position_id', $positId)->where('permission_id', $permId)->whereNull('org')->exists();
                if ($status == 'true') {
                    if (is_null(Auth()->user()->userDetail->org) && !Auth()->user()->is_tsm) {
                        if ($permNullExist) {
                            Position_has_permission::where('position_id', $positId)->where('permission_id', $permId)->whereNull('org')->update([
                                'status' => true
                            ]);
                        } else {
                            Position_has_permission::create([
                                'position_id' => $positId,
                                'permission_id' => $permId,
                                'user_id' => Auth()->user()->id,
                                'org' => $org_id ?? null,
                                'status' => true
                            ]);
                        }
                    } else {
                        if ($permExist) {
                            Position_has_permission::where('position_id', $positId)->where('permission_id', $permId)->where('org', $org_id)->update([
                                'status' => true
                            ]);
                        } else {
                            Position_has_permission::create([
                                'position_id' => $positId,
                                'permission_id' => $permId,
                                'user_id' => Auth()->user()->id,
                                'org' => $org_id,
                                'status' => true
                            ]);
                        }
                    }
                } else {
                    if (is_null(Auth()->user()->userDetail->org)  && !Auth()->user()->is_tsm) {
                        Position_has_permission::where('position_id', $positId)->where('permission_id', $permId)->whereNull('org')->update([
                            'status' => false
                        ]);
                    } else {
                        if ($permExist) {
                            Position_has_permission::where('position_id', $positId)->where('permission_id', $permId)->where('org', $org_id)->update([
                                'status' => false
                            ]);
                        } else {
                            Position_has_permission::create([
                                'position_id' => $positId,
                                'permission_id' => $permId,
                                'user_id' => Auth()->user()->id,
                                'org' => $org_id,
                                'status' => false
                            ]);
                        }
                    }
                }
            } elseif ($checkType === "form") {
                // $permExist = PositionHasForm::where('position_id', $positId)->where('form_type_id', $permId)->where('org', optional(Auth()->user()->userDetail)->org)->exists();
                // $permNullExist = PositionHasForm::where('position_id', $positId)->where('form_type_id', $permId)->whereNull('org')->exists();
                // if ($status == 'true') {
                //     if (is_null(Auth()->user()->userDetail->org)) {
                //         if ($permNullExist) {
                //             PositionHasForm::where('position_id', $positId)->where('form_type_id', $permId)->whereNull('org')->update([
                //                 'status' => true
                //             ]);
                //         } else {
                //             PositionHasForm::create([
                //                 'position_id' => $positId,
                //                 'form_type_id' => $permId,
                //                 'user_id' => Auth()->user()->id,
                //                 'org' => Auth()->user()->userDetail->org ?? null,
                //                 'status' => true
                //             ]);
                //         }
                //     } else {
                //         if ($permExist) {
                //             PositionHasForm::where('position_id', $positId)->where('form_type_id', $permId)->where('org', optional(Auth()->user()->userDetail)->org)->update([
                //                 'status' => true
                //             ]);
                //         } else {
                //             PositionHasForm::create([
                //                 'position_id' => $positId,
                //                 'form_type_id' => $permId,
                //                 'user_id' => Auth()->user()->id,
                //                 'org' => Auth()->user()->userDetail->org,
                //                 'status' => true
                //             ]);
                //         }
                //     }
                // } else {
                //     if (is_null(Auth()->user()->userDetail->org)) {
                //         PositionHasForm::where('position_id', $positId)->where('form_type_id', $permId)->whereNull('org')->update([
                //             'status' => false
                //         ]);
                //     } else {
                //         if ($permExist) {
                //             PositionHasForm::where('position_id', $positId)->where('form_type_id', $permId)->where('org', optional(Auth()->user()->userDetail)->org)->update([
                //                 'status' => false
                //             ]);
                //         } else {
                //             PositionHasForm::create([
                //                 'position_id' => $positId,
                //                 'form_type_id' => $permId,
                //                 'user_id' => Auth()->user()->id,
                //                 'org' => Auth()->user()->userDetail->org,
                //                 'status' => false
                //             ]);
                //         }
                //     }
                // }
            }

            return response()->json([
                'message' => 'Update perm : ' . $positId . $permId . $status . $checkType . " : " . Auth()->user()->userDetail->fname
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 200);
        }
    }
}
