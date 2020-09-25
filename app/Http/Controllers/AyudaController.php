<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
  public function openAyuda(){

    $user = auth()->user();
    $header_titulo = "";
    $header_descripcion = '';
    return view('ayuda.ayuda_general',compact('user','header_titulo','header_descripcion'));

  }

  public function openCambiarClave(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = 'Cambiar Clave';
    return view('cambiar_clave',compact('user','header_titulo','header_descripcion'));

  }

}
