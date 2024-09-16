<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Prefix;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth()->user()->userDetail->org ?? false) {
            $users = User::whereNot('username', 'tsmcadmin')->whereHas('userDetail', function ($query) {
                $query->where('org', Auth()->user()->userDetail->org);
            })->get();
        } else {
            $users = User::whereNot('username', 'tsmcadmin')->get();
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
            User::where('id', $id)->delete();
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
}
