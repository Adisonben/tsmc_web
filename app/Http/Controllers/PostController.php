<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\Post;
use App\Models\Post_comment;
use App\Models\Post_permission;
use App\Models\User_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post_perms = Post_permission::all();
        $dpms = Department::all();
        $positions = Position::all();
        $users = User_detail::all();
        return view('post.createPostForm', compact('post_perms', 'dpms', 'positions', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'postContent' => 'required|string|max:2000',
                'postColor' => 'required',
            ]);
            Post::create([
                'post_id' => Str::uuid(),
                'content' => $request->postContent,
                'theme_color' => $request->postColor,
                'created_by' => $request->user()->id
            ]);

            return redirect()->route('home')->with(['success' => "โพสสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => $th->getMessage()]);
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

    public function storeComment(Request $request)
    {
        try {
            Post_comment::create([
                'post_id' => $request->post_id,
                'user_id' => $request->user()->id,
                'content' => $request->postComment,
            ]);
            return response()->json([
                'message' => 'Post comment successfully.' . $request->post_id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delComment($id) {
        try {
            Post_comment::where('id', $id)->delete();
            return response()->json([
                'message' => 'Post comment deleted successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
