<?php

namespace App\Repositories\NormaEvaluaciones;
use App\Repositories\BaseRepository;
use App\NormaEvaluaciones;


class NormaEvaluacionesRepository extends BaseRepository
{

  public function getModel()
  {
    return new NormaEvaluaciones;
  }

}