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
use App\DefectosPosicion;


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
    $informeRi->kv = $request->kv;
    $informeRi->ma = $request->ma;
    $informeRi->interno_fuente_id =  $request->interno_fuente ? $request->interno_fuente['id'] : null;
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

          $this->savePasadasPosicion($detalle['pasadas'],$posicion);
          $this->saveDefectos($detalle['defectos'],$posicion);
           
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
    $junta->tipo_soldadura_id = $detalle['tipo_soldadura']['id'];
    $junta->codigo = $detalle['junta'];
    $junta->informe_ri_id = $informeRi->id;          
    $junta->km = $detalle['pk']; 
    $junta->save();
    
    return $junta;
  }


  public function savePosicion($detalle,$junta){

    $posicion = new Posicion;  
    $posicion->junta_id = $junta['id'];
    $posicion->codigo = $detalle['posicion'];
    $posicion->descripcion = $detalle['observacion'] ;
    $posicion->aceptable_sn = $detalle['aceptable_sn'];
    $posicion->save();

    return $posicion;
  }


  public function savePasadasPosicion($pasadas,$posicion){   
     
 
      foreach ($pasadas as $pasada) {

        $pasadasPosicion = new PasadasPosicion;   
        $pasadasPosicion->numero = $pasada['pasada'];
        $pasadasPosicion->posicion_id =  $posicion['id'];
        $pasadasPosicion->soldadorz_id = $pasada['soldador1']['id'];               
        $pasadasPosicion->soldadorl_id = $pasada['soldador2']['id'];
        $pasadasPosicion->soldadorp_id = $pasada['soldador3']['id'];
  
        $pasadasPosicion->save();

       
      }
    }

  public function saveDefectos($defectos,$posicion){
      
        foreach ($defectos as $defecto) {
          
          $defectosPosicion = new DefectosPosicion;
          $defectosPosicion->posicion_id = $posicion['id'];
          $defectosPosicion->defecto_ri_id = $defecto['id'];       
          $defectosPosicion->posicion = $defecto['posicion']; 
          $defectosPosicion->save();
        }  
    
  }

public function deleteDetalle($request,$id){

      DB::delete('delete dpp from defectos_posicion as dpp              
                      inner join posicion as p on dpp.posicion_id = p.id 
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