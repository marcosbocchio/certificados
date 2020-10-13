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

  public function cambiarClave(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.cambiar_clave',compact('user','header_titulo','header_descripcion'));

  }

  public function BuscarFormularios(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.buscar_formularios',compact('user','header_titulo','header_descripcion'));

  }

  public function visualizarOt(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.visualizar_ot',compact('user','header_titulo','header_descripcion'));

  }

  public function crearOt(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.crear_ot',compact('user','header_titulo','header_descripcion'));

  }

  public function asignarSoldadoresUsuarios(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.asigar_soldadores_usuarios',compact('user','header_titulo','header_descripcion'));

  }

  public function generarInformes(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.generar_informes',compact('user','header_titulo','header_descripcion'));

  }



  public function generarInformesRi(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.generar_informes_ri',compact('user','header_titulo','header_descripcion'));

  }

  public function generarInformesPm(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.generar_informes_pm',compact('user','header_titulo','header_descripcion'));

  }

  public function generarInformesLp(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.generar_informes_lp',compact('user','header_titulo','header_descripcion'));

  }

}
