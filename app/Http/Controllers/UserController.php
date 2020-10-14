<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Log;
use Session;

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
       $cliente = Clientes::find($user->cliente_id);
       $header_titulo = "Usuarios";
       $header_descripcion ="";
       return view('perfil',compact('user','cliente','header_titulo','header_descripcion'));

    }

    public function updatePerfil(UserRequest $request,$id){

      // dd(request()->all());

        $user = User::findOrFail($id);

        if( ($request->get('password')!="********"))
        {
            if ($request->get('password') == $request->get('password_confirmation'))
            {
                $user->password = bcrypt($request->get('password'));
            }
            else
            {
                return back()->with('error','Las contraseñas ingresadas no coinciden.');
            }
        }

        $user->name= $request->get('name');
        $user->dni = $request->get('email');
        $user->dni = $request->get('dni');


        $user->save();

        return back()->with('success','El usuario fue actualizado.');



      }

}
