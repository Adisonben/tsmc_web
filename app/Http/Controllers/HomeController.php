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
            })->orderBy('created_at', "desc")->get();
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
