<?php

namespace App\Repositories\Productos;
use App\Repositories\BaseRepository;
use App\Productos;


class ProductosRepository extends BaseRepository
{

  public function getModel()
  {
    return new Productos;
  }

}