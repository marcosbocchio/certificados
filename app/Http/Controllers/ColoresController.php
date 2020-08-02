<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Colores;
class ColoresController extends Controller
{
   
public function index(){

    return Colores::all();

}

}
