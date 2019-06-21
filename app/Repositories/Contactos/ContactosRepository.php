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

  public function getContactos($id){

    $Contactos = $this->getModel();

    return $Contactos->where('cliente_id',$id)->get();

  }

}