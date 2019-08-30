<?php

namespace App\Repositories\InformesRi;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
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
    $informeRi  = new InformesRi;  
    
    DB::beginTransaction();
    try { 
     
    
      $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
      $this->saveInformeRi($request,$informe,$informeRi);
      $this->saveDetalle($request,$informeRi);

      DB::commit(); 

    } catch (Exception $e) {

      DB::rollback();
      throw $e;      
      
    }
   
  }

  public function updateInforme($request, $id){

    $informe  = Informe::find($id);
    $informeRi =InformesRi::where('informe_id',$informe->id)->first();
    DB::beginTransaction();
    try {

        $informe = (new \App\Http\Controllers\InformesController)->saveInforme($request,$informe);
        $this->saveInformeRi($request,$informe,$informeRi);  
        $this->deleteDetalle($request,$informeRi->id);   
        $this->saveDetalle($request,$informeRi);

        DB::commit();
        
      } catch (Exception $e) {

        DB::rollback();
        throw $e;      
        
      }

  }
  
  public function saveInformeRi($request,$informe,$informeRi){      

   
    $informeRi->informe_id = $informe->id;
    $informeRi->fuente_id = isset($request->fuente['id']) ? $request->fuente['id'] : NULL;
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


   

  }

  public function saveDetalle($request,$informeRi){

   
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
    $pos->save();

    return $pos;
  }


  public function savePasadasPosicion($gasoducto_sn,$detalle,$posicion){
 
     
     
     $defectosPosicion = $detalle['defectosPosicion'];
     $numero_pasada    = $detalle['pasada'] ? $detalle['pasada'] : 1;

      $pasadasPosicion = new PasadasPosicion;   
      $pasadasPosicion->numero = $numero_pasada;
      $pasadasPosicion->posicion_id = $posicion['id'];
      $pasadasPosicion->aceptable_sn = $detalle['aceptable_sn'];

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

public function deleteDetalle($request,$id){

DB::delete('delete dpp from defectos_pasadas_posicion as dpp
                inner join pasadas_posicion as pp on dpp.pasada_posicion_id = pp.id
                inner join posicion as p on pp.posicion_id = p.id 
                inner join juntas as j on j.id = p.junta_id
                inner join informes_ri as ir on j.informe_ri_id = ir.id
                where
                ir.id= ?',[$id]);

DB::delete('delete pp from pasadas_posicion as pp
                inner join posicion as p on pp.posicion_id = p.id 
                inner join juntas as j on j.id = p.junta_id
                inner join informes_ri as ir on j.informe_ri_id = ir.id
                where
                ir.id= ?',[$id]);

DB::delete('delete p from posicion as p
                inner join juntas as j on j.id = p.junta_id
                inner join informes_ri as ir on j.informe_ri_id = ir.id
                where
                ir.id= ?',[$id]);
    
DB::delete('delete j from juntas as j
                inner join informes_ri as ir on j.informe_ri_id = ir.id
                where
                ir.id= ?',[$id]);    
  
  }

}