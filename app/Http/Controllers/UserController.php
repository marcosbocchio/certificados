<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
//use App\User;

class UserController extends Controller
{
    Protected $users;

    public function __construct(UserRepository $userRepository)
    {
      $this->users = $userRepository;
    }

    public function index()
    {
         return  $this->users->getAll();

    }

    public function store(Request $request){


     $this->users->create($request) ;

    }

    public function destroy($id){

      $this->users->delete($id);
    }
}
