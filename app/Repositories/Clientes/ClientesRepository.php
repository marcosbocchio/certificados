<?php

namespace App\Repositories\Clientes;
use App\Repositories\BaseRepository;
use App\Clientes;


class ClientesRepository extends BaseRepository
{

  public function getModel()
  {
    return new Clientes;
  }

}