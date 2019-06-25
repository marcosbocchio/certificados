<?php

namespace App\Repositories\Ots;
use App\Repositories\BaseRepository;
use App\Ots;


class OtsRepository extends BaseRepository
{

  public function getModel()
  {
    return new Ots;
  }

}