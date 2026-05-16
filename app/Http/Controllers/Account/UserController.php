<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Prefix;
use App\Models\Tsm_has_Org;
use App\Models\User;
use App\Models\User_detail;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $org_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->org_id = session('key') ?? null;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ((Auth()->user()->userDetail->org ?? false) || Auth()->user()->is_tsm) {
            $users = User::whereNot('username', 'tsmcadmin')->whereHas('userDetail', function ($query) {
                $query->where('org', Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org);
            })->paginate(15);
        } else {
            $users = User::whereNot('username', 'tsmcadmin')->where('is_tsm', false)->paginate(15);
        }
        return view('account.userAccounts', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account.createForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('user_id', $id)->firstOrFail();
        return view('account.myAccount', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit_id = $id;
        return view('account.editForm', compact('edit_id'));
    }
    public function editByOwn(string $id)
    {
        $edit_id = $id;
        return view('account.editByOwnForm', compact('edit_id'));
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
        try {
            $user = User::where('id', $id)->firstOrFail();
            if ($user->is_tsm) {
                if (Tsm_has_Org::where('tsm_id', $id)->count() > 0) {
                    $org_ids = Tsm_has_Org::where('tsm_id', $id)->pluck('org_id');
                    Organization::whereIn('id', $org_ids)->update([
                        'status' => 0,
                    ]);
                    Tsm_has_Org::where('tsm_id', $id)->delete();
                }
            }
            $user->delete();
            return response()->json([
                'message' => 'Data deleted successfully : ' . $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function storeImage(Request $request) {
        try {
            $request->validate([
                'store_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // 4MB
            ]);

            // Get the uploaded file
            $file = $request->file('store_image');
            // Generate a unique filename
            $filename = time() . '.' . $file->extension();
            // Specify the storage path (adjust as needed)
            $storagePath = public_path('uploads/userImages');
            // Move the file to the storage path
            $file->move($storagePath, $filename);

            $userUpdate = User_detail::where('user_id', $request->user()->id)->firstOrFail();
            $oldImg = null;
            switch ($request->file_type) {
                case 'profile':
                    $oldImg = $userUpdate->icon ?? null;
                    $userUpdate->icon = $filename;
                    break;
                case 'sign':
                    $oldImg = $userUpdate->sign ?? null;
                    $userUpdate->sign = $filename;
                    break;
                default:
                    # code...
                    break;
            }
            $userUpdate->save();

            try {
                if ($oldImg) {
                    $filePath = public_path('uploads/userImages/' . $oldImg);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }

            return response()->json([
                'success' => 'Store image successfully.' . json_encode($request->all())
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function exportUsers(Request $request) {
        $org_id = null;
        if ((Auth()->user()->userDetail->org ?? false) || Auth()->user()->is_tsm) {
            $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
        }

        $query = User::whereNot('username', 'tsmcadmin');

        if ($org_id) {
            $query->whereHas('userDetail', function ($q) use ($org_id) {
                $q->where('org', $org_id);
            });
        }

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhereHas('userDetail', function($q2) use ($search) {
                      $q2->where('fname', 'like', "%$search%")
                         ->orWhere('lname', 'like', "%$search%");
                  });
            });
        }

        if ($request->filled('branch')) {
            $query->whereHas('userDetail', function($q) use ($request) {
                $q->where('brn', $request->branch);
            });
        }

        if ($request->filled('department')) {
            $query->whereHas('userDetail', function($q) use ($request) {
                $q->where('dpm', $request->department);
            });
        }

        if ($request->filled('position')) {
            $query->whereHas('userDetail', function($q) use ($request) {
                $q->where('position', $request->position);
            });
        }

        $users = $query->get();

        // Get options for filters
        $branches = Branch::where('org_id', $org_id)->get();
        $departments = Department::whereHas('getBrn', function($q) use ($org_id) {
            $q->where('org_id', $org_id);
        })->get();
        $positions = Position::where('org', $org_id)->orWhereNull('org')->get();

        return view('account.exportUsers', compact('users', 'branches', 'departments', 'positions'));
    }
}
