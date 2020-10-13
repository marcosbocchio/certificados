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

      $this->middleware(['role_or_permission:Sistemas|M_usuarios'], ['only' => ['callView']]);

      $this->users = $userRepository;

    }

    public function index(Request $request)
    {

      return User::with('cliente')->orderBy('name','ASC')->get();

    }

    public function paginate(Request $request){

      $filtro = $request->search;

      return User::with('cliente')
                  ->with('roles')
                  ->Filtro($filtro)
                  ->orderBy('name','ASC')
                  ->paginate(10);

    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Usuarios";
        $header_descripcion ="Alta | Baja | Modificación";
        return view('usuarios',compact('user','header_titulo','header_descripcion'));

    }

    public function store(UserRequest $request){

        $this->users->create($request->all()) ;

    }

    public function destroy($id){

      $user = $this->users->find($id);
      $user->delete();
    }

    public function getUsersEmpresa(){

      return User::where('cliente_id',null)->orderBy('name','ASC')->get();

    }

    public function update(UserRequest $request,$id){

      return $this->users->updateUser($request,$id);

    }

    public function UserCliente($id){

      return User::where('cliente_id',$id)->orderBy('name','ASC')->get();
    }

    public function callviewPerfil(){

       $user = auth()->user();
       $header_titulo = "Usuarios";
       $header_descripcion ="";
       return view('perfil',compact('user','header_titulo','header_descripcion'));

    }

}
