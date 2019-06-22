<?php

namespace App\Repositories\Certificados;
use App\Repositories\BaseRepository;
use App\Certificados;


class CertificadosRepository extends BaseRepository
{

  public function getModel()
  {
    return new Certificados;
  }

}