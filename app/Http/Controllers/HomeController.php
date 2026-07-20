<?php

namespace App\Http\Controllers;

use App\Helpers\FunctionHelpers;
use App\Models\Branch;
use App\Models\Department;
use App\Models\LoginHistory;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Position_has_permission;
use App\Models\Position_permission;
use App\Models\PositionHasForm;
use App\Models\Post;
use App\Models\Tsm_has_Org;
use App\Models\User;
use App\Models\User_detail;
use App\Models\WorkRecord;
use App\Services\MasterDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $default_org = Organization::where('status', 2)->first();
            return view('tsm.home', compact('tsm_has_orgs', 'default_org'));
        } else {
            $work_record = WorkRecord::where('user_id', Auth::user()->id)->whereNull('end_at')->orderBy('created_at', 'desc')->first();
            return view('home', compact('work_record'));
        }
    }

    public function usermanual() {
        return view('usermanual');
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

    private function filterAllLoginHistory(Request $request) {
        $query = LoginHistory::whereHas('getUser', function ($q) {
            $q->where('username', '!=', 'tsmcadmin');
        })->with(['getUser.userDetail.getOrg']);

        if ($request->filled('username')) {
            $username = $request->username;
            $query->whereHas('getUser', function ($q) use ($username) {
                $q->where('username', 'like', "%$username%");
            });
        }

        if ($request->filled('org')) {
            $org = $request->org;
            $query->whereHas('getUser.userDetail', function ($q) use ($org) {
                $q->where('org', $org);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if (!$request->filled('date_from') && !$request->filled('date_to')) {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function allLoginHistory(Request $request) {
        if (Auth::user()->username !== 'tsmcadmin') {
            abort(403);
        }

        $histories = $this->filterAllLoginHistory($request)->paginate(10)->appends($request->query());
        $organizations = Organization::orderBy('name')->get();

        return view('allLoginHistory', compact('histories', 'organizations'));
    }

    public function exportAllLoginHistory(Request $request) {
        if (Auth::user()->username !== 'tsmcadmin') {
            abort(403);
        }

        $histories = $this->filterAllLoginHistory($request)->get();

        return view('exportAllLoginHistory', compact('histories'));
    }

    public function registerNewUser(Request $request, MasterDataService $masterDataService) {
        $request->validate([
            'org_name' => ['required', 'string', 'max:255'],
            'prefix_id' => ['required', 'integer'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required'],
        ], [
            'org_name.required' => 'กรุณากรอกชื่อบริษัท',
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
            DB::beginTransaction();

            $newOrg = Organization::create([
                'org_id' => Str::uuid(),
                'name' => $request->org_name,
                'expire_at' => now()->addDays(90),
                'accept_terms' => true,
            ]);
            
            $newUser = User::create([
                'user_id' => Str::uuid(),
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'pass_text' => $request->password ?? null,
            ]);

            $masterData = $masterDataService->generate($newOrg->id, $newUser->id);

            User_detail::create([
                'user_id' => $newUser->id,
                'prefix' => $request->prefix_id,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'org' => $newOrg->id,
                'brn' => $masterData['brn_id'],
                'dpm' => $masterData['dpm_id'],
                'position' => $masterData['pos_id'],
            ]);

            DB::commit();

            Auth::login($newUser);

            return redirect()->route('home');
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
        }
    }
}
