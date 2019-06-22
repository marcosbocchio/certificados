<?php

namespace App\Repositories\MetodoEnsayos;
use App\Repositories\BaseRepository;
use App\MetodoEnsayos;


class MetodoEnsayosRepository extends BaseRepository
{

  public function getModel()
  {
    return new MetodoEnsayos;
  }

}