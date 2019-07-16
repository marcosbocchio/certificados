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
        $header_titulo = "Usuarios";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('usuarios',compact('user','modelo','header_titulo','header_descripcion'));

    }

    public function store(Request $request){ 
      
    $request->validate([
    
      'name' => 'required',
      'email'  =>'required|unique:users|email',
      'password' =>'required|Min:8'
    
    ]);
     
    $this->users->create($request->all()) ;      
    
    }

    public function destroy($id){

      $user = $this->users->find($id);    
      $user->delete();
    }
}
