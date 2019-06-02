<?php

namespace App\Repositories\User;
use App\Repositories\BaseRepository;
use App\User;


class UserRepository extends BaseRepository
{

  public function getModel()
  {
    return new User;
  }

}
