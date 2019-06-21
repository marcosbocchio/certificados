<?php

namespace App\Repositories\Contactos;
use App\Repositories\BaseRepository;
use App\Contactos;


class ContactosRepository extends BaseRepository
{

  public function getModel()
  {
    return new Contactos;
  }

}