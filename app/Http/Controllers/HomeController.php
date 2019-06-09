<?php

namespace App\Http\Controllers;

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
        $users = \App\User::count();
        $setting = \App\Setting::orderBy('id', 'DESC')->get()->first();
        $in = \App\DispositionRelation::where('to_user', Auth::user()->id)->count();
        $out = \App\DispositionRelation::where('from_user', Auth::user()->id)->count();
        return view('home', compact('users', 'setting', 'in', 'out'));
    }
}
