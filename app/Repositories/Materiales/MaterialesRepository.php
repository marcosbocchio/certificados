<?php

namespace App\Repositories\Materiales;
use App\Repositories\BaseRepository;
use App\Materiales;


class MaterialesRepository extends BaseRepository
{

  public function getModel()
  {
    return new Materiales;
  }

}