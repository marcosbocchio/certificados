<?php

namespace App\Repositories\Epps;
use App\Repositories\BaseRepository;
use App\Epps;


class EppsRepository extends BaseRepository
{

  public function getModel()
  {
    return new Epps;
  }

}