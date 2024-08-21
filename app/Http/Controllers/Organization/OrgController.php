<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orgs = Organization::all();
        return view('organization.orgData.orgTable', compact('orgs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('organization.orgData.createOrgForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'orgLogo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2 megabytes (MB)
        ], [
            'orgLogo.max' => 'โลโก้หน่วยงานต้องมีขนาดไม่เกิน 2 MB',
        ]);
        try {
            $imageName = time() . '.' . $request->orgLogo->extension();
            $request->orgLogo->move(public_path('uploads/orglogoes'), $imageName);

            Organization::create([
                'name' => $request->orgName,
                'theme_color' => $request->orgTheme,
                'logo_img' => $imageName
            ]);
            return redirect()->route('organizations.index')->with(['success' => "เพิ่มหน่วยงานสำเร็จ"]);
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
        $org = Organization::find($id);
        return view('organization.orgData.editOrgForm', compact('org'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'orgLogo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // max 2 megabytes (MB)
        ], [
            'orgLogo.max' => 'โลโก้หน่วยงานต้องมีขนาดไม่เกิน 2 MB',
        ]);

        try {
            $org = Organization::find($id);
            $filePath = public_path('uploads/orglogoes/' . $org->logo_img);

            if ($request->hasFile('orgLogo')) {
                $imageName = time() . '.' . $request->orgLogo->extension();
                $request->orgLogo->move(public_path('uploads/orglogoes'), $imageName);
            }

            $org->update([
                'name' => $request->orgName,
                'theme_color' => $request->orgTheme,
            ]);

            if ($request->orgLogo) {
                $org->logo_img = $imageName;
                $org->save();

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            return redirect()->route('organizations.index')->with(['success' => "แก้ไขหน่วยงานสำเร็จ"]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => "ไม่สามารถแก้ไขหน่วยงาน"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Organization::where('id', $id)->delete();
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
