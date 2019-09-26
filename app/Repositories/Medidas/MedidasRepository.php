<?php

namespace App\Repositories\Medidas;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Medidas;


class MedidasRepository extends BaseRepository
{

  public function getModel()
  {
    return new Medidas;
  }

  public function getMedidasProducto($id){

    $Medidas = $this->getModel();

    return $Medidas->where('unidades_medida_id',$id)->get();
  }

  public function store($request){


    $medida = $this->getModel();   

    DB::beginTransaction();
    try { 

        $this->saveMedidas($request,$medida);
        DB::commit(); 

      } catch (Exception $e) {
  
        DB::rollback();
        throw $e;      
        
      }
   

  }

  public function updateMedidas($request,$id){

    $medida = Medidas::find($id);     
    
    DB::beginTransaction();
    try {
        $this->saveMedidas($request,$medida);
        DB::commit(); 

      } catch (Exception $e) {
  
        DB::rollback();
        throw $e;      
        
      }

  }

  public function saveMedidas($request,$medida){

    $medida->codigo = $request['codigo'];
    $medida->descripcion = $request['descripcion'];
    $medida->unidades_medida_id = $request['unidad_medida']['id'];
    $medida->save();

  }

}