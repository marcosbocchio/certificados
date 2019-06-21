<?php

namespace App\Repositories\Localidades;
use App\Repositories\BaseRepository;
use App\Localidades;


class LocalidadesRepository extends BaseRepository
{

  public function getModel()
  {
    return new Localidades;
  }

  public function getLocalidades($id){

    $Localidades = $this->getModel();

    return $Localidades->where('provincia_id',$id)->get();

  }

}