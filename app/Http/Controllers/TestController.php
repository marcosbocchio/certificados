<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
  public function index(Request $request)

  {
    $var = env('APP_ENV');
    return $var;

  }

}
