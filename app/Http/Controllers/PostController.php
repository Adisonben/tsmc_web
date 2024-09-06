<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\Post;
use App\Models\Post_comment;
use App\Models\Post_has_Permission;
use App\Models\Post_media;
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
        $user_list = User_detail::whereNot('fname', 'admin')->get();
        return view('post.createPostForm', compact('post_perms', 'dpms', 'positions', 'user_list'));
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
            $post = Post::create([
                'post_id' => Str::uuid(),
                'content' => $request->postContent,
                'theme_color' => $request->postColor,
                'created_by' => $request->user()->id
            ]);

            $doc_file_ids = $request->doc_files;
            if (count($doc_file_ids ?? []) > 0) {
                foreach ($doc_file_ids as $doc_file_id) {
                    Post_media::where('id' ,$doc_file_id)->update([
                        "post_id" => $post->id
                    ]);
                }
            }
            $postPerm = $request->postPerm ?? "ทั้งหมด";
            $perm = Post_permission::where('name', $postPerm)->first();
            if ($postPerm == "ฝ่าย" && $request->dpmPermTarget) {
                foreach ($request->dpmPermTarget as $target) {
                    Post_has_Permission::create([
                        "post_id" => $post->id,
                        "permission_id" => $perm->id,
                        "target" => $target
                    ]);
                }
            } elseif ($postPerm == "ตำแหน่ง" && $request->positPermTarget) {
                foreach ($request->positPermTarget as $target) {
                    Post_has_Permission::create([
                        "post_id" => $post->id,
                        "permission_id" => $perm->id,
                        "target" => $target
                    ]);
                }
            } elseif ($postPerm == "บุคคล" && $request->userPermTarget) {
                foreach ($request->userPermTarget as $target) {
                    Post_has_Permission::create([
                        "post_id" => $post->id,
                        "permission_id" => $perm->id,
                        "target" => $target
                    ]);
                }
            } else {
                Post_has_Permission::create([
                    "post_id" => $post->id,
                    "permission_id" => $perm->id,
                ]);
            }

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
        $postData = Post::where('post_id', $id)->firstOrFail();
        $post_perms = Post_permission::all();
        $dpms = Department::all();
        $positions = Position::all();
        $users = User_detail::all();
        return view('post.editPostForm', compact('post_perms', 'dpms', 'positions', 'users', 'postData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $post = Post::findOrFail($id);
            $request->validate([
                'postContent' => 'required|string|max:2000',
                'postColor' => 'required',
            ]);

            $post->update([
                'content' => $request->postContent,
                'theme_color' => $request->postColor,
            ]);

            return redirect()->route('home')->with(['success' => "แก้ไขโพสสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Post::where('id', $id)->delete();
            $post_medias = Post_media::where('post_id', $id)->get();
            foreach ($post_medias as $media) {
                $filePath = public_path($media->folder . '/' . $media->file_name);
                if (file_exists($filePath)) {
                    unlink($filePath);
                    $media->delete();
                }
            }
            return response()->json([
                'message' => 'Data deleted successfully : ' . $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
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
