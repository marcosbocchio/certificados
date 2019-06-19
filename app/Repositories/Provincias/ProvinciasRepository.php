<?php

namespace App\Repositories\Provincias;
use App\Repositories\BaseRepository;
use App\Provincias;


class ProvinciasRepository extends BaseRepository
{

  public function getModel()
  {
    return new Provincias;
  }

}