<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\LoginHistory;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Position_has_permission;
use App\Models\Position_permission;
use App\Models\Post;
use App\Models\Tsm_has_Org;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->is_tsm) {
            $tsm_has_orgs = Tsm_has_Org::where('tsm_id', Auth::user()->id)->get();
            return view('tsm.home', compact('tsm_has_orgs'));
        } else {
            return view('home');
        }
    }

    public function storeHistory(Request $request) {
        try {
            if ($request->user()) {
                $loginHistory = new LoginHistory;
                $loginHistory->user_id = $request->user()->id;
                $loginHistory->ip_address = $request->ip();
                $loginHistory->agent = $request->userAgent();
                $loginHistory->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
        } finally {
            return redirect()->route('home');
        }
    }

    public function loginHistoryTable() {
        $histories = LoginHistory::where('user_id', Auth()->user()->id)->orderBy('created_at', "desc")->paginate(10);
        return view('loginHistory', compact('histories'));
    }

    public function registerNewUser(Request $request) {
        $request->validate([
            'org_name' => ['required', 'string', 'max:255'],
            'prefix_id' => ['required', 'integer'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required'],
        ], [
            'org_name.required' => 'กรุณากรอกชื่อองค์กร',
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
            $newOrg = Organization::create([
                'org_id' => Str::uuid(),
                'name' => $request->org_name,
                'expire_at' => now()->addDays(30),
                'accept_terms' => true,
            ]);

            $newBranch = Branch::create([
                'brn_id' => Str::uuid(),
                'name'=> 'สำนักงานใหญ่',
                'org_id' => $newOrg->id,
            ]);

            $newDpm = Department::create([
                'dpm_id' => Str::uuid(),
                'name'=> 'admin',
                'brn_id' => $newBranch->id,
            ]);

            $newUser = User::create([
                'user_id' => Str::uuid(),
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'pass_text' => $request->password ?? null,
            ]);

            $newPosition = Position::create([
                'name' => 'admin',
                'created_by' => $newUser->id,
                'org' => $newOrg->id,
            ]);

            User_detail::create([
                'user_id' => $newUser->id,
                'prefix' => $request->prefix_id,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'org' => $newOrg->id,
                'brn' => $newBranch->id,
                'dpm' => $newDpm->id,
                'position' => $newPosition->id,
            ]);

            $perms = Position_permission::whereIn('perm_name', ['can_manage_user', 'can_manage_org'])->get();

            foreach ($perms as $perm) {
                Position_has_permission::create([
                    'position_id' => $newPosition->id,
                    'permission_id' => $perm->id,
                    'user_id' => $newUser->id,
                    'org' => $newOrg->id,
                    'status' => true
                ]);
            }

            Auth::login($newUser);

            return redirect()->route('home');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
        }
    }
}
