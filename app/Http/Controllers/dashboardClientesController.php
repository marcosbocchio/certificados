<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardClientesController extends Controller
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
      $User = $Request->user();
      return view('testcliente',compact('User'));
  }
}