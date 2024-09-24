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

class EditrUserForm extends Component
{
    // init form data
    public $prefixes;
    public $orgs;
    public $brns;
    public $dpms;
    public $positions;
    public $error = null;
    public $user;

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

    public function mount($edit_id)
    {
        $user = User::where('user_id', $edit_id)->firstOrFail();
        $this->user = $user;
        $userDetail = $this->user->userDetail;
        $this->prefixes = Prefix::all();
        $this->orgs = Organization::all();
        $this->positions = Position::all();

        // querry form select data
        $this->brns = Branch::where('org_id', $userDetail->org)->get();
        $this->dpms = Department::where('brn_id', $userDetail->brn)->get();

        // init form
        $this->username = $user->username;
        $this->prefix_id = $userDetail->prefix;
        $this->fname = $userDetail->fname;
        $this->lname = $userDetail->lname;
        $this->org_id = $userDetail->org;
        $this->branch_id = $userDetail->brn;
        $this->department_id = $userDetail->dpm;
        $this->position_id = $userDetail->position;
    }

    public function selectedOrgId()
    {
        $this->brns = Branch::where('org_id', $this->org_id)->get();
    }
    public function selectedBranchId()
    {
        $this->dpms = Department::where('brn_id', $this->branch_id)->get();
    }

    public function updateUser()
    {
        try {
            $this->validate([
                'username' => 'required|string|max:255',
                'prefix_id' => 'required',
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'org_id' => 'required',
                'branch_id' => 'required',
                'department_id' => 'required',
                'position_id' => 'required',
            ]);

            if ($this->password) {
                $this->validate([
                    'password' => 'min:8|max:20',
                ]);
            }

            // Create the user
            $this->user->update([
                'user_id' => Str::uuid(),
                'username' => $this->username,
            ]);

            if ($this->password) {
                $this->user->update([
                    'password' => Hash::make($this->password),
                    'pass_text' => $this->password ?? null,
                ]);
            }


            User_detail::where('user_id', $this->user->id)->update([
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
            return redirect()->route('users.index')->with(['success' => "อัพเดทผู้ใช้สำเร็จ"]);
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();
            // $this->error = "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง";
        }
    }
    public function render()
    {
        return view('livewire.editr-user-form');
    }
}
