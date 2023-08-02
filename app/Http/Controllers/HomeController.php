<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', "verified"]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function comment(Request $request)
    {
        $data = $request->validate([
            "commentable_id" => "required",
            "commentable_type" => "required",
            "parent_id" => "required",
            "comment" => "required"
        ]);

        auth()->user()->comments()->create($data);

        Alert::success('Your Comment Successfully Send :)', 'Success Message');
        return back();
    }
}
