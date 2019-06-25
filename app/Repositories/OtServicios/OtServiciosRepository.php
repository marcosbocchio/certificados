<?php

namespace App\Repositories\OtServicios;
use App\Repositories\BaseRepository;
use App\OtServicios;


class OtServiciosRepository extends BaseRepository
{

  public function getModel()
  {
    return new OtServicios;
  }

}