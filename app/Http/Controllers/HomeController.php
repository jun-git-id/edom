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
        $role_id = Auth::user()->role_id;

        switch ($role_id) {
            case '1':
                return redirect('/admin');
                break;
            case '2':
                return redirect('/mhs');
                break;
            case '3':
                return redirect('/dosen');
                break;
            case '4':
                return redirect('/kajur');
        }
        return view('home');
    }
}
