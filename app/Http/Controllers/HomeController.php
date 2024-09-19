<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth()->user()->userDetail->org ?? false) {
            $posts = Post::whereHas('getUser', function ($query) {
                $query->where('org', Auth()->user()->userDetail->org);
            })->where(function ($query) {
                $query->orWhereHas('permissions', function ($query2) {
                    $query2->where('name', "บุคคล")
                          ->where('target', Auth()->user()->id);
                })
                ->orWhereHas('permissions', function ($query2) {
                    $query2->where('name', "ตำแหน่ง")
                          ->where('target', Auth()->user()->userDetail->position);
                })
                ->orWhereHas('permissions', function ($query2) {
                    $query2->where('name', "ฝ่าย")
                          ->where('target', Auth()->user()->userDetail->dpm);
                })
                ->orWhereHas('permissions', function ($query2) {
                    $query2->where('name', "ทั้งหมด");
                });
            })->orWhere('created_by', Auth()->user()->id)
            ->orderBy('created_at', "desc")->get();
        } else {
            $posts = Post::orderBy('created_at', "desc")->get();
        }
        return view('home', compact('posts'));
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
}
