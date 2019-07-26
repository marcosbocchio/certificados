<?php

namespace App\Repositories\InformesRi;
use App\Repositories\BaseRepository;
use App\InformesRi;
use App\Informe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DiametrosEspesor;


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
   

    
    $informe->ot_id  = $request->ot['id'];
    $informe->metodo_ensayo_id  = 1;
    $informe->fecha = date('Y-m-d',strtotime($request->fecha));
    $informe->numero = $request->numero_inf;
    $informe->ext_numero = $request->ext_numero_inf;
    $informe->contratista = $request->contratista;
    $informe->ieg = $request->ieg;
    $informe->componente = $request->componente;
    $informe->plano_isom = $request->plano_isom;
    $informe->observaciones = $request->observaciones;
    $informe->user_id = $user_id;
    $informe->save();
    

  }

  public function saveInformeRi($request,$informe){


       

    $informeRi  = new InformesRi;
    $informeRi->informe_id = $informe->id;
    $informeRi->gasoducto_sn = $request->gasoducto_sn;
    $informeRi->procedimiento_informe_id = $request->procedimiento['id'];
    $informeRi->material_id = $request->material['id'];   
    
    if ($request->diametro =='CHAPA'){

      $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro)                                         
                                          ->first(); 

      $informeRi->diametro_espesor_id = $diametro_espesor['id'];
      $informeRi->espesor_chapa       = $request->espesor_chapa;

    }else{

      $diametro_espesor = DiametrosEspesor::where('diametro',$request->diametro) 
                                          ->where('espesor',$request->espesor)
                                          ->first();

      $informeRi->diametro_espesor_id = $diametro_espesor['id'];



    }
    
    $informeRi->equipo_id = $request->equipo['id'];
    $informeRi->fuente_id = $request->fuente['id'];
    $informeRi->foco = $request->foco;
    $informeRi->tipo_pelicula_id = $request->tipo_pelicula['id'];
    $informeRi->pantalla = $request->pantalla;
    $informeRi->pos_ant = $request->pos_ant;
    $informeRi->pos_pos = $request->pos_pos;
    $informeRi->ici_id  = $request->ici['id'];
    $informeRi->lado    = $request->lado;
    $informeRi->distancia_fuente_pelicula = $request->distancia_fuente_pelicula;
    $informeRi->norma_evaluacion_id = $request->norma_evaluacion['id'];
    $informeRi->norma_ensayo_id = $request->norma_ensayo['id'];
    $informeRi->tecnica_id = $request->tecnica['id'];
    $informeRi->procedimiento_soldadura = $request->procedimiento_soldadura;
    $informeRi->eps = $request->eps;
    $informeRi->pqr = $request->pqr;
    $informeRi->actividad = $request->actividad;
    $informeRi->exposicion = $request->exposicion;

    $informeRi->save();



  }

}