<?php

namespace App\Repositories\InformesRi;
use App\Repositories\BaseRepository;
use App\InformesRi;
use App\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DiametrosEspesor;
use App\Juntas;
use App\PasadasPosicion;
use Exception as Exception;
use App\Posicion;
use App\DefectosPasadasPosicion;



class InformesRiRepository extends BaseRepository
{

  public function getModel()
  {
    return new InformesRi;
  }

  public function store($request){

  
    $informe  = new Informe;    

    $this->saveInforme($request,$informe);
    $this->saveInformeRi($request,$informe);

    

  }

  public function saveInforme($request,$informe){

    $user_id = null;
    
    if (Auth::check())
    {
         $user_id = $userId = Auth::id();    
    }
   
    //revisar esto 
    
    $informe->ot_id  = $request->ot['id'];
    $informe->procedimiento_informe_id = $request->procedimiento['id'];

    if ($request->diametro =='CHAPA'){

      $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro)                                 
                                          ->first(); 

      $informe->diametro_espesor_id = $diametro_espesor['id'];
      $informe->espesor_chapa       = $request->espesor_chapa;

    }else{

      $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro) 
                                          ->where('espesor',$request->espesor)
                                          ->first();

      $informe->diametro_espesor_id = $diametro_espesor['id'];

    } 

    $informe->equipo_id = $request->equipo['id'];
    $informe->Kv = $request->kv;
    $informe->ma =$request->ma;  
    $informe->metodo_ensayo_id  = 1;
    $informe->norma_evaluacion_id = $request->norma_evaluacion['id'];
    $informe->norma_ensayo_id = $request->norma_ensayo['id'];
    $informe->tecnica_id = $request->tecnica['id'];
    $informe->user_id = $user_id;
    $informe->ejecutor_ensayo_id = $request->ejecutor_ensayo['ot_operario_id'];
    $informe->material_id = $request->material['id'];
    $informe->fecha = date('Y-m-d',strtotime($request->fecha));
    $informe->numero = $request->numero_inf;
    $informe->prefijo = $request->prefijo;  
    $informe->componente = $request->componente;
    $informe->procedimiento_soldadura = $request->procedimiento_soldadura;
    $informe->plano_isom = $request->plano_isom;
    $informe->eps = $request->eps;
    $informe->pqr = $request->pqr;
    $informe->observaciones = $request->observaciones;
    $informe->save();
    


    
  }

  public function saveInformeRi($request,$informe){

      

    $informeRi  = new InformesRi;
    $informeRi->informe_id = $informe->id;
    $informeRi->fuente_id = $request->fuente['id'];
    $informeRi->tipo_pelicula_id = $request->tipo_pelicula['id'];
    $informeRi->ici_id  = $request->ici['id'];
    $informeRi->gasoducto_sn = $request->gasoducto_sn;
    $informeRi->foco = $request->foco;
    $informeRi->pantalla = $request->pantalla;
    $informeRi->pos_ant = $request->pos_ant;
    $informeRi->pos_pos = $request->pos_pos;
    $informeRi->lado    = $request->lado;
    $informeRi->distancia_fuente_pelicula = $request->distancia_fuente_pelicula;
    $informeRi->tecnicas_grafico_id = $request->tecnica['grafico_id'];
    $informeRi->actividad = $request->actividad;
    $informeRi->exposicion = $request->exposicion;   

    $informeRi->save();   

    $this->saveDetallePlanta($request,$informeRi);

   

  }

  public function saveDetallePlanta($request,$informeRi){

   
      foreach ($request->detalles as $detalle){       

        try {

         $junta = $this->saveJunta($detalle,$informeRi);            
          
        } 
        catch(Exception $e){          

          if ($e->getCode() != '23000'){

            throw $e;    

          }
      
        }  

        try {

          $posicion = $this->savePosicion($detalle,$junta);   
  
           
         } 
         catch(Exception $u){          
 
           if ($u->getCode() != '23000'){
 
             throw $u;    
 
           }
       
         } 

         try {

          $pasadas_posicion = $this->savePasadasPosicion($request->gasoducto_sn,$detalle,$posicion);
  
           
         } 
         catch(Exception $z){          
 
           if ($z->getCode() != '23000'){
 
             throw $z;    
 
           }
       
         } 
        
       
       
      
      }
    
  }

  public function saveJunta($detalle ,$informeRi){

    $junta =  new Juntas;
    $junta->codigo = $detalle['junta'];
    $junta->tipo_soldadura_id = $detalle['tipo_soldadura']['id'];
    $junta->informe_ri_id = $informeRi->id;          
    $junta->km = $detalle['pk']; 
    $junta->save();
    
    return $junta;
  }


  public function savePosicion($detalle,$junta){

    $pos = new Posicion;  
    $pos->codigo = $detalle['posicion'];
    $pos->descripcion = $detalle['observacion'] ;
    $pos->junta_id = $junta['id'];
    $pos->aceptable_sn = $detalle['aceptable_sn'];
    $pos->save();

    return $pos;
  }


  public function savePasadasPosicion($gasoducto_sn,$detalle,$posicion){
 
     
     
     $defectosPosicion = $detalle['defectosPosicion'];
     $numero_pasada    = $detalle['pasada'] ? $detalle['pasada'] : 1;

      $pasadasPosicion = new PasadasPosicion;   
      $pasadasPosicion->numero = $numero_pasada;
      $pasadasPosicion->posicion_id = $posicion['id'];
      $pasadasPosicion->soldadorz_id = $detalle['soldador1']['id'];               
      $pasadasPosicion->soldadorl_id = $detalle['soldador2']['id'];
      $pasadasPosicion->soldadorp_id = $detalle['soldador3']['id'];

      $pasadasPosicion->save();
      
        foreach ($defectosPosicion as $defectoPosicion) {
          
          $defectos_pasadas_posicion = new DefectosPasadasPosicion;
          $defectos_pasadas_posicion->defecto_ri_id = $defectoPosicion['id'];
          $defectos_pasadas_posicion->pasada_posicion_id = $pasadasPosicion->id;

          if($gasoducto_sn){
          
            $defectos_pasadas_posicion->posicion = $defectoPosicion['posicion'];         

          }

          $defectos_pasadas_posicion->save();
        }

  
    
  }
}