<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Prefix;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUserForm extends Component
{
    // init form data
    public $prefixes;
    public $orgs;
    public $brns;
    public $dpms;
    public $positions;
    public $error = null;
    public $citizen_id;

    // submit data
    public $username;
    public $password;
    public $prefix_id;
    public $fname;
    public $lname;
    public $org_id;
    public $branch_id;
    public $department_id;
    public $position_id;

    public function mount()
    {
        $this->prefixes = Prefix::all();
        if ((Auth()->user()->userDetail->org ?? false) || Auth()->user()->is_tsm) {
            $this->orgs = Organization::where('id', Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org)->get();
            // $this->brns = Branch::where('org_id', Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org)->get();
            // $this->dpms = Department::where('brn_id', Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org)->get();
            $this->positions = Position::where('org', Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org)->orWhereNull('org')->get();
        } else {
            $this->orgs = Organization::all();
            $this->positions = Position::all();
        }
    }

    public function selectedOrgId()
    {
        $this->brns = Branch::where('org_id', $this->org_id)->get();
    }
    public function selectedBranchId()
    {
        $this->dpms = Department::where('brn_id', $this->branch_id)->get();
    }

    public function registerUser()
    {
        try {
            $this->validate([
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|min:8',
                'prefix_id' => 'required',
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'org_id' => 'required',
                'branch_id' => 'required',
                'department_id' => 'required',
                'citizen_id' => 'max:255|nullable',
            ], [
                'username.required' => 'กรุณากรอกชื่อผู้ใช้',
                'username.unique' => 'ชื่อผู้ใช้นี้มีอยู่แล้ว',
                'password.required' => 'กรุณากรอกรหัสผ่าน',
                'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
                'prefix_id.required' => 'กรุณาเลือกคำนำหน้า',
                'fname.required' => 'กรุณากรอกชื่อ',
                'lname.required' => 'กรุณากรอกนามสกุล',
                'org_id.required' => 'กรุณาเลือกหน่วยงาน',
                'branch_id.required' => 'กรุณาเลือกสาขา',
                'department_id.required' => 'กรุณาเลือกแผนก',
                'citizen_id.required' => 'กรุณากรอกเลขบัตรประชาชน',
            ]);

            // Create the user
            $newUser = User::create([
                'user_id' => Str::uuid(),
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'pass_text' => $this->password ?? null,
            ]);

            User_detail::create([
                'user_id' => $newUser->id,
                'prefix' => $this->prefix_id,
                'fname' => $this->fname,
                'lname' => $this->lname,
                'citizen_id' => $this->citizen_id,
                'org' => $this->org_id,
                'brn' => $this->branch_id,
                'dpm' => $this->department_id,
                'position' => $this->position_id,
            ]);

            // Redirect to a successful registration page
            $this->error = null;
            return redirect()->route('users.index')->with(['success' => "เพิ่มผู้ใช้สำเร็จ"]);
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();
            // $this->error = "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง";
        }
    }
    public function render()
    {
        return view('livewire.register-user-form');
    }
}
