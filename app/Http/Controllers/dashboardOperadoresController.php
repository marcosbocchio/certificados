<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardOperadoresController extends Controller
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
     public function index(Request $Request )
     {
         $user = $Request->user()->name;
         $title = 'Area Enod' ;
         $header_titulo = "Dashboard";
         $header_descripcion ="Control panel";     
         return view('testoperador',compact('user','title','header_titulo','header_descripcion'));
     }
}
