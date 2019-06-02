<?php

namespace App\Repositories\User;
use App\BaseRepository;

class UserRepository extend BaseRepository
{

  public function getModel()
  {
    return new User();
  }

}
