<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documentaciones;

class dashboardController extends Controller
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
         $header_titulo = "Tablero Principal";
         $header_descripcion ="";     
         return view('dashboard',compact('user','title','header_titulo','header_descripcion','documentos'));
     }
}
