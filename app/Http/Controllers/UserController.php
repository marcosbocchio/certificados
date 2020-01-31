<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
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

    public function index(Request $request)
    {   
      return User::with('cliente')->get();
  
    }

    public function paginate(Request $request){

      return User::with('cliente')->with('roles')->orderBy('name','ASC')->paginate(10);

    }

    public function callView()
    {   
        $user = auth()->user()->name; 
        $header_titulo = "Usuarios";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('usuarios',compact('user','modelo','header_titulo','header_descripcion'));

    }

    public function store(request $request){     
      
      $condicion_cliente ='';
        if(!$request->isEnod) {
            $condicion_cliente ='required';
        }

      
      $request->validate([
    
        'name' => 'required',
        'dni'  =>'nullable|unique:users|numeric|digits_between:7,8',
        'film' => 'nullable|numeric|unique:users|digits_between:1,3',
        'email'  =>'required|unique:users|email',
        'password' =>'required|Min:8',
        'cliente'  =>$condicion_cliente
      
      ]);
     
    $this->users->create($request->all()) ;      
    
    }

    public function destroy($id){

      $user = $this->users->find($id);    
      $user->delete();
    }

    public function getUsersEmpresa(){

      return User::where('cliente_id',null)->get();

  }

  public function update(request $request,$id){

    $condicion_cliente ='';
        if(!$request->isEnod) {
            $condicion_cliente ='required';
        }
    
    $User = user::find($id);
    $condicion_email ='';
        if($request->email != $User->email) {
            $condicion_email ='unique:users';
        }

      
      $request->validate([
    
        'name' => 'required',
        'dni'  =>'nullable|unique:users|numeric|digits_between:7,8',
        'film' => 'nullable|numeric|unique:users||digits_between:1,3',
        'email'  =>'required|email|' . $condicion_email,
        'password' =>'required|Min:8',
        'cliente'  =>$condicion_cliente
      
      ]);

    return $this->users->updateUser($request,$id);

  }

  public function UserCliente($id){

    return User::where('cliente_id',$id)->get();
  }
}
