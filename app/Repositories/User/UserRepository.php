<?php

namespace App\Repositories\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\User;
use Spatie\Permission\Models\Role;

class UserRepository extends BaseRepository
{

  public function getModel()
  {
    return new User;
  }

  public function create(Array $request){


        $User = $this->getModel();   
        $this->saveUser($request,$User);      

  }

  public function updateUser($request,$id){

    $User = User::find($id);    
    $this->saveUser($request,$User);

  }

  public function saveUser($request,$User){

    if ($request['isEnod']) {

      $User->cliente_id = null ;   
      
    }else {
      
      $User->cliente_id = $request['cliente']['id'];     
   
    }        
    
    $User->name = $request['name'];
    $User->email = $request['email'];

    if($request['password'] != '********'){

      $User->password = bcrypt($request['password']);

    }
    $User->api_token = str_random(60);
    $User->path = $request['path'];
    $User->syncRoles($request['roles']);
    $User->save();

    

  }
 
}
