<?php

namespace App\Repositories\Medidas;
use App\Repositories\BaseRepository;
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

}