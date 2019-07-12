<?php

namespace App\Repositories\Documentaciones;
use App\Repositories\BaseRepository;
use App\Documentaciones;


class DocumentacionesRepository extends BaseRepository
{

  public function getModel()
  {
    return new Documentaciones;
  }

 

}