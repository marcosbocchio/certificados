<?php

namespace App\Repositories\Servicios;
use App\Repositories\BaseRepository;
use App\Servicios;


class ServiciosRepository extends BaseRepository
{

  public function getModel()
  {
    return new Servicios;
  }

}