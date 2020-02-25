<?php

namespace App\Repositories\Ots;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ots;
use Auth;
use App\User;
use App\OtServicios;
Use App\OtProductos;
Use App\OtEpps;
Use App\OtRiesgos;
use App\OtReferencias;
use App\OtCalidadPlacas;
use App\OtOperarios;
use App\OtSoldadores;


class OtsRepository extends BaseRepository
{

  public function getModel()
  {
    return new Ots;
  }


  public function getAll(){

  
 

  }

  public function store( $request)
  {

   

    $ot = $this->getModel();
    $servicios = $request->servicios;
    $productos = $request->productos;
    $tipo_peliculas = $request->tipo_peliculas;
    $epps      = $request->epps;
    $riesgos   = $request->riesgos;


    DB::beginTransaction();
    try {  
    
        $this->setOt($request, $ot);  
        $this->setOperarios($ot);  
        $this->setServicios($servicios,$ot);
        $this->setTipoPeliculas($tipo_peliculas,$ot);
        $this->setProductos($productos,$ot);
        $this->setEpps($epps,$ot);
        $this->setRiesgos($riesgos,$ot);

      DB::commit();

    } catch (Exception $e) {

      DB::rollback();
      throw $e;      
      
    }


  }

  public function updateOt( $request, $id)
  {

        $ot = $this->getModel()->find($id);
        $servicios = $request->servicios;
        $tipo_peliculas = $request->tipo_peliculas;
        $productos = $request->productos;
        $epps      = $request->epps;
        $riesgos   = $request->riesgos;       



        DB::beginTransaction();
          try {  

              if ( $ot->cliente_id != $request->cliente) {

                $this->borrarSoldadoresOT($ot->id);
          
              }
              
                $this->setOt($request, $ot);       

                $this->setOperarios($ot);  

                OtCalidadPlacas::where('ot_id',$ot->id)->delete();
                $this->SetTipoPeliculas($tipo_peliculas,$ot);          

                OtServicios::where('ot_id',$ot->id)->delete();
                $this->setServicios($servicios,$ot);

                
                OtProductos::where('ot_id',$ot->id)->delete();
                $this->setProductos($productos,$ot);
                
                OtEpps::where('ot_id',$ot->id)->delete();
                $this->setEpps($epps,$ot);
                
                OtRiesgos::where('ot_id',$ot->id)->delete();
                $this->setRiesgos($riesgos,$ot);

                DB::commit();

      } catch (Exception $e) {
  
        DB::rollback();
        throw $e;      
        
      }

  }


  public function borrarSoldadoresOT($ot_id){

    OtSoldadores::where('ot_id',$ot_id)->delete();

  }


  public function SetOt($request ,$ot){

    $user_id = null;
    
    if (Auth::check())
    {
         $user_id = $userId = Auth::id();    
    }  

    $fecha = date('Y-m-d',strtotime($request->fecha));
    $fecha_hora_estimada_ensayo =  date('Y-m-d',strtotime($request->fecha_ensayo)) .' ' . date('H:i:s',strtotime($request->hora)) ;;
    $ot->proyecto          = $request->proyecto;
    $ot->cliente_id        = $request->cliente;
    $ot->logo_cliente_sn   = $request->logo_cliente_sn;
    $ot->contratista_id    = $request->contratista ? $request->contratista['id'] : null;
    $ot->logo_contratista_sn   = $request->logo_contratista_sn;
    $ot->obra              = $request->obra;
    $ot->fecha             = $fecha;
    $ot->numero            = $request->ot;
    $ot->presupuesto       = $request->fst;
    $ot->lugar             = $request->lugar_ensayo;
    $ot->localidad_id      = $request->localidad;
    $ot->lat               = $request->lat;
    $ot->lon               = $request->lon;
    $ot->contacto1_id      = $request->contacto1;
    $ot->contacto2_id      = $request->contacto2;
    $ot->contacto3_id      = $request->contacto3;
    $ot->responsable_ot_id = $request->user_empresa;
    $ot->observaciones     = $request->observaciones;
    $ot->fecha_hora_estimada_ensayo = $fecha_hora_estimada_ensayo;
    $ot->user_id            = $user_id;
    $ot->estado             = 'EDITANDO';
    $ot->save();     
  }

  public function setOperarios($ot){

    $ot_operario = OtOperarios::where('ot_id',$ot->id)
                              ->where('user_id',$ot->responsable_ot_id)
                              ->first();

    if($ot_operario == null) {
        
      $ot_operario = new OtOperarios;
      $ot_operario->ot_id = $ot->id;
      $ot_operario->user_id = $ot->responsable_ot_id;
      $ot_operario->save();

    }

  }

  public function SetServicios($servicios,Ots $ot){    

    foreach ($servicios as $servicio) {  
      
     $referencia_id = $this->setReferencia($servicio);
    

      $ot_servicios                       = new OtServicios;
      $ot_servicios->ot_id                = $ot->id;
      $ot_servicios->servicio_id          = $servicio['id'];
      $ot_servicios->norma_ensayo_id      = $servicio['norma_ensayo_id'];
      $ot_servicios->norma_evaluacion_id  = $servicio['norma_evaluacion_id'];
      $ot_servicios->cantidad             = $servicio['cantidad_servicios'];
      $ot_servicios->procedimiento_sn     = $servicio['procedimiento_sn'];
      $ot_servicios->combinado_sn         = $servicio['combinado_sn'];
      $ot_servicios->ot_referencia_id     = $referencia_id;
      $ot_servicios->save();
      
      }

  }


  public function setReferencia($servicio){
 
    if (($servicio['observaciones'])||
        ($servicio['path1']) ||
        ($servicio['path2']) ||
        ($servicio['path3']) ||
        ($servicio['path4'])){

          $ot_referencias                     = new OtReferencias;
          $ot_referencias->descripcion        = $servicio['observaciones'];
          $ot_referencias->path1              = $servicio['path1'];
          $ot_referencias->path2              = $servicio['path2'];
          $ot_referencias->path3              = $servicio['path3'];
          $ot_referencias->path4              = $servicio['path4'];
          $ot_referencias->save();

          return $ot_referencias->id;
       }
       else{
          return null;
       }

  }

  public function SetProductos($productos,Ots $ot){
  

    foreach ($productos as $producto ) {

      $referencia_id = $this->setReferencia($producto);
      
      $ot_productos                       = new OtProductos;
      $ot_productos->ot_id                = $ot->id;
      $ot_productos->producto_id          = $producto['id'];
      $ot_productos->medida_id            = $producto['medida_id'];
      $ot_productos->cantidad             = $producto['cantidad_productos'];
      $ot_productos->ot_referencia_id     = $referencia_id;
      $ot_productos->save();
     

     }

  }

  public function SetEpps($epps,Ots $ot){


    foreach ($epps as $epp ) {

      $ot_epps                            = new OtEpps;
      $ot_epps->ot_id                     = $ot->id;
      $ot_epps->epp_id                    = $epp['id'];
      $ot_epps->save();

    }

  }

  public function SetRiesgos($riesgos,Ots $ot){

  
      foreach ($riesgos as $riesgo ) {

        $ot_riesgos                         = new OtRiesgos;
        $ot_riesgos->ot_id                  = $ot->id;
        $ot_riesgos->riesgo_id              = $riesgo['id'];
        $ot_riesgos->save();
        
      }

  }

  public function SetTipoPeliculas($tipo_peliculas,Ots $ot){

  
    foreach ($tipo_peliculas as $tipo_pelicula ) {

      $ot_tipo_placas                     = new OtCalidadPlacas;
      $ot_tipo_placas->ot_id              = $ot->id;
      $ot_tipo_placas->tipo_pelicula_id  = $tipo_pelicula['id'];     

      $ot_tipo_placas->save();
      
    }

}


}