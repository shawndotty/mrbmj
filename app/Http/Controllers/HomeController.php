<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = \App\Order::all();
        return view('home', ['orders'=>$orders]);
    }
    public function welcome()
    {
        $orders = \App\Order::all();
        return view('welcome', ['orders'=>$orders]);
    }
}
