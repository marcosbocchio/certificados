<?php

namespace App\Repositories\Riesgos;
use App\Repositories\BaseRepository;
use App\Riesgos;


class RiesgosRepository extends BaseRepository
{

  public function getModel()
  {
    return new Riesgos;
  }

}