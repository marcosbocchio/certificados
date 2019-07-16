<?php

namespace App\Repositories\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\User;

class UserRepository extends BaseRepository
{

  public function getModel()
  {
    return new User;
  }

  public function create(Array $data){


        $User = $this->getModel();
        
        
        $User->name = $data['name'];
        $User->email = $data['email'];     
        $User->password = bcrypt($data['password']);
        $User->api_token = str_random(60);
        $User->save();

        $User->assignRole('Operador');
     

  }
 
}
