<?php

namespace App\Repositories\NormaEnsayos;
use App\Repositories\BaseRepository;
use App\NormaEnsayos;


class NormaEnsayosRepository extends BaseRepository
{

  public function getModel()
  {
    return new NormaEnsayos;
  }

}