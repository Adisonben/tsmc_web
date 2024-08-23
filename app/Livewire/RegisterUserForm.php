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
        $this->orgs = Organization::all();
        $this->positions = Position::all();
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
                'username' => 'required|string|max:255',
                'password' => 'required|min:8',
                'prefix_id' => 'required',
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'org_id' => 'required',
                'branch_id' => 'required',
                'department_id' => 'required',
                'position_id' => 'required',
            ]);

            // Create the user
            $newUser = User::create([
                'user_id' => Str::uuid(),
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);

            User_detail::create([
                'user_id' => $newUser->id,
                'prefix' => $this->prefix_id,
                'fname' => $this->fname,
                'lname' => $this->lname,
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
