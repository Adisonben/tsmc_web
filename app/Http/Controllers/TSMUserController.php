<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Tsm_has_Org;
use App\Models\User;
use App\Models\User_detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TSMUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->username === 'tsmcadmin') {
            $tsmUsers = User::whereNot('username', 'tsmcadmin')->where('is_tsm', true)->paginate(20);
        }
        return view('account.tsmAccountTable', compact('tsmUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prefix_id' => ['required', 'integer'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required'],
        ], [
            'prefix_id.required' => 'กรุณาเลือกคำนำหน้า',
            'fname.required' => 'กรุณากรอกชื่อ',
            'lname.required' => 'กรุณากรอกนามสกุล',
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'username.unique' => 'ชื่อผู้ใช้นี้มีผู้ใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'terms.required' => 'กรุณายอมรับข้อตกลงและเงื่อนไข',
        ]);

        try {
            $newUser = User::create([
                'user_id' => Str::uuid(),
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'pass_text' => $request->password ?? null,
                'is_tsm' => true,
                'expire_at' => now()->addDays(30),
            ]);

            User_detail::create([
                'user_id' => $newUser->id,
                'prefix' => $request->prefix_id,
                'fname' => $request->fname,
                'lname' => $request->lname,
            ]);

            Auth::login($newUser);

            return redirect()->route('home');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function showLogin() {
    //     return view('auth.tsm_login');
    // }

    public function register() {
        return view('auth.tsm_register');
    }

    // public function login(Request $request)
    // {
    //     // Validate input fields
    //     $request->validate([
    //         'username' => 'required|exists:users,username',
    //         'password' => 'required|min:6',
    //     ], [
    //         'username.exists' => 'ไม่พบชื่อผู้ใช้งานนี้ในระบบ',
    //         'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
    //     ]);

    //     // Attempt to authenticate user
    //     if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
    //         $request->session()->regenerate(); // Prevent session fixation attacks
    //         return redirect()->route('tsms.index'); // Redirect to dashboard or intended page
    //     }

    //     return back()->with('error', 'ไม่สามารถเข้าสู่ระบบได้ กรุณาลองใหม่อีกครั้ง');
    // }

    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect()->route('tsm.login');
    // }

    public function manageOrg()
    {
        $tsm_has_orgs = Tsm_has_Org::where('tsm_id', Auth::user()->id)->get();
        return view('tsm.org_manage', compact('tsm_has_orgs'));
    }

    public function storeOrg(Request $request, string $user_id)
    {
        $request->validate([
            'orgName' => 'required|string|max:255',
            'orgLogo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048', // max 2 megabytes (MB)
        ], [
            'orgName.required' => 'กรุณากรอกชื่อบริษัท',
            'orgLogo.max' => 'โลโก้บริษัทต้องมีขนาดไม่เกิน 2 MB',
        ]);

        try {
            if ($request->hasFile('orgLogo')) {
                $imageName = time() . '.' . $request->orgLogo->extension();
                $request->orgLogo->move(public_path('uploads/orglogoes'), $imageName);
            }

            $newOrg = Organization::create([
                'org_id' => Str::uuid(),
                'name' => $request->orgName,
                'logo_img' => $imageName ?? null,
                'expire_at' => now()->addDays(30),
                'accept_terms' => true,
            ]);

            Tsm_has_Org::create([
                'tsm_id' => $user_id,
                'org_id' => $newOrg->id,
            ]);

            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
        }
    }

    public function updateOrg(Request $request, string $id) {
        $request->validate([
            'orgName' => 'required|string|max:255',
            'orgLogo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2 megabytes (MB)
        ], [
            'orgLogo.max' => 'โลโก้บริษัทต้องมีขนาดไม่เกิน 2 MB',
            'orgName.required' => 'กรุณากรอกชื่อบริษัท',
        ]);

        try {
            $org = Organization::find($id);

            if ($request->hasFile('orgLogo')) {
                $imageName = time() . '.' . $request->orgLogo->extension();
                $request->orgLogo->move(public_path('uploads/orglogoes'), $imageName);
            }

            $org->update([
                'name' => $request->orgName,
            ]);

            if ($request->orgLogo) {
                $filePath = public_path('uploads/orglogoes/' . $org->logo_img);
                $org->logo_img = $imageName;
                $org->save();

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            return redirect()->back()->with(['success' => "แก้ไขบริษัทสำเร็จ"]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => "ไม่สามารถแก้ไขบริษัท"]);
        }
    }

    public function connectOrg(string $org_id)
    {
        try {
            $org = Organization::findOrFail($org_id);
            if (Auth::user()->expire_at) {
                $org->update([
                    'expire_at' => Auth::user()->expire_at,
                ]);
            } else {
                if ($org->expire_at) {
                    $expire_date = new Carbon($org->expire_at);
                    $diffDay = (int) ceil(Carbon::now()->diffInDays($expire_date));
                    if ($diffDay < 10) {
                        $org->update([
                            'expire_at' => Carbon::parse($org->expire_at)->addDays(30),
                        ]);
                    }
                } else {
                    $org->update([
                        'expire_at' => now()->addDays(30),
                    ]);
                }
            }
            Session::put('connected_org', $org->id);
            Session::put('org_status', $org->status);
            return redirect()->back()->with('success', 'เชื่อมต่อกับบริษัทเรียบร้อย');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
        }
    }

    public function destroyOrg(string $org_id)
    {
        try {
            if (Tsm_has_Org::where('org_id', $org_id)->where('tsm_id', Auth()->user()->id)->exists()) {
                Tsm_has_Org::where('org_id', $org_id)->where('tsm_id', Auth()->user()->id)->delete();
                Organization::where('id', $org_id)->update([
                    'status' => 0,
                ]);
            }
            return response()->json([
                'message' => 'ลบข้อมูลเรียบร้อย'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง'
            ], 500);}
    }
}
