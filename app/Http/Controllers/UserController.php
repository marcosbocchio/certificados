<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;
use App\User;

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

    public function callView()
    {   
        $user = auth()->user()->name;      
        return view('usuarios',compact('user','modelo'));

    }

    public function store(Request $request){ 
      
    $request->validate([

      'codigo'  => 'required |unique:users|Max:10',
      'name' => 'required',
      'email'  =>'required|unique:users|email',
      'password' =>'required|Min:8'
    
    ]);
     
    $this->users->create($request->all()) ;      
    
    }

    public function destroy($id){

      $this->users->delete($id);
    }
}
