<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{


public function __construct()
{

    $this->middleware(['role_or_permission:Sistemas|enod'],['only' =>
     ['crearOt','asignarOperadores','asignarSoldadoresUsuarios','asignarSoldadoresUsuarios',
     'generarInformes','generarInformesRi','generarInformesLp','generarInformesPm','generarInformesUs','asignarVehiculos']]);

}


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

  public function VisualizarDocOperadores(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.visualizar_doc_operadores',compact('user','header_titulo','header_descripcion'));

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

  public function asignarOperadores(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.asignar_operadores',compact('user','header_titulo','header_descripcion'));

  }

  public function asignarSoldadoresUsuarios(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.asignar_soldadores_usuarios',compact('user','header_titulo','header_descripcion'));

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

  public function generarInformesUs(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.generar_informes_us',compact('user','header_titulo','header_descripcion'));

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
  public function asignarVehiculos(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.asignar_vehiculos',compact('user','header_titulo','header_descripcion'));

  }

  public function visualizarVehiculos(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.visualizar_vehiculos',compact('user','header_titulo','header_descripcion'));

  }

  public function AsignarProcedimientos(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.asignar_procedimientos',compact('user','header_titulo','header_descripcion'));

  }

  public function visualizarProcedimientos(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.visualizar_procedimientos',compact('user','header_titulo','header_descripcion'));

  }

  /*_____________________________________ */

  public function creaciónDeRemito(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.generar_remito',compact('user','header_titulo','header_descripcion'));

  }
  public function creaciónCertificado(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.generar_certificados',compact('user','header_titulo','header_descripcion'));

  }
  public function visualizarCertificado(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.visualizar_certificado',compact('user','header_titulo','header_descripcion'));

  }
  public function gestionarUsuario(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.gestionar_usuario',compact('user','header_titulo','header_descripcion'));

  }
  public function gestionarCliente(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.gestionar_cliente',compact('user','header_titulo','header_descripcion'));

  }
  public function gestionarProveedores(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.gestionar_proveedores',compact('user','header_titulo','header_descripcion'));

  }
  public function gestionarComitente(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.gestionar_comitente',compact('user','header_titulo','header_descripcion'));

  }
  public function gestionarMateriales(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.gestionar_materiales',compact('user','header_titulo','header_descripcion'));

  }
  public function gestionarNormaEnsayo(){

    $user = auth()->user();
    $header_titulo = "Ayuda";
    $header_descripcion = '';
    return view('ayuda.gestionar_nomra_ensayo',compact('user','header_titulo','header_descripcion'));

  }

}
