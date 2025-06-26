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

  private function returnAyudaView($viewName, $titulo = "Ayuda", $descripcion = '')
  {
      $user = auth()->user();
      $header_titulo = $titulo;
      $header_descripcion = $descripcion;
      return view($viewName, compact('user', 'header_titulo', 'header_descripcion'));
  }

  public function openAyuda(){

    return $this->returnAyudaView('ayuda.ayuda_general', "", "");

  }

  public function cambiarClave(){

    return $this->returnAyudaView('ayuda.cambiar_clave');

  }

  public function BuscarFormularios(){

    return $this->returnAyudaView('ayuda.buscar_formularios');

  }

  public function VisualizarDocOperadores(){

    return $this->returnAyudaView('ayuda.visualizar_doc_operadores');

  }

  public function VisualizarGestionUsuario(){

    return $this->returnAyudaView('ayuda.gestion_usuario');

  }

  public function visualizarOt(){

    return $this->returnAyudaView('ayuda.visualizar_ot');

  }

  public function crearOt(){

    return $this->returnAyudaView('ayuda.crear_ot');

  }

  public function asignarOperadores(){

    return $this->returnAyudaView('ayuda.asignar_operadores');

  }

  public function asignarSoldadoresUsuarios(){

    return $this->returnAyudaView('ayuda.asignar_soldadores_usuarios');

  }

  public function generarInformes(){

    return $this->returnAyudaView('ayuda.generar_informes');

  }



  public function generarInformesRi(){

    return $this->returnAyudaView('ayuda.generar_informes_ri');

  }

  public function generarInformesUs(){

    return $this->returnAyudaView('ayuda.generar_informes_us');

  }

  public function generarInformesPm(){

    return $this->returnAyudaView('ayuda.generar_informes_pm');

  }

  public function generarInformesLp(){

    return $this->returnAyudaView('ayuda.generar_informes_lp');

  }
  public function asignarVehiculos(){

    return $this->returnAyudaView('ayuda.asignar_vehiculos');

  }

  public function visualizarVehiculos(){

    return $this->returnAyudaView('ayuda.visualizar_vehiculos');

  }

  public function AsignarProcedimientos(){

    return $this->returnAyudaView('ayuda.asignar_procedimientos');

  }

  public function visualizarProcedimientos(){

    return $this->returnAyudaView('ayuda.visualizar_procedimientos');

  }

  public function creacionRemito()
  {
      return $this->returnAyudaView('ayuda.creacion_remito');
  }

  public function gestionNormas()
  {
      return $this->returnAyudaView('ayuda.gesiton_normas');
  }

  public function gestionMedidas()
  {
      return $this->returnAyudaView('ayuda.gestiona_medidas');
  }

  public function gestionarInternoFuente()
  {
      return $this->returnAyudaView('ayuda.gestionar_internofuente');
  }

  public function gestionCliente()
  {
      return $this->returnAyudaView('ayuda.gestion_cliente');
  }

  public function gestionComitente()
  {
      return $this->returnAyudaView('ayuda.gestion_comitente');
  }

  public function gestionDocumentaciones()
  {
      return $this->returnAyudaView('ayuda.gestion_documentaciones');
  }

  public function gestionEquipos()
  {
      return $this->returnAyudaView('ayuda.gestion_equipos');
  }

  public function gestionFuentes()
  {
      return $this->returnAyudaView('ayuda.gestion_fuentes');
  }

  public function gestionInternoEquipos()
  {
      return $this->returnAyudaView('ayuda.gestion_internoequipos');
  }

  public function gestionMateriales()
  {
      return $this->returnAyudaView('ayuda.gestion_materiales');
  }

  public function gestionProductos()
  {
      return $this->returnAyudaView('ayuda.gestion_productos');
  }

  public function gestionServicios()
  {
      return $this->returnAyudaView('ayuda.gestion_servicios');
  }

  public function gestionSoldadores()
  {
      return $this->returnAyudaView('ayuda.gestion_soldadores');
  }

  public function gestionUnidadesDeMedida()
  {
      return $this->returnAyudaView('ayuda.gestion_unidadesdemedida');
  }

  public function gestionarRoles()
  {
      return $this->returnAyudaView('ayuda.gesitonar_roles');
  }

}
