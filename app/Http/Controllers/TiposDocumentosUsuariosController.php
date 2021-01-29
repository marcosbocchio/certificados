<?php

namespace App\Http\Controllers;

use App\TiposDocumentosUsuarios;
use Illuminate\Http\Request;

class TiposDocumentosUsuariosController extends Controller
{
   public function index(){

    return TiposDocumentosUsuarios::all();

   }
}
