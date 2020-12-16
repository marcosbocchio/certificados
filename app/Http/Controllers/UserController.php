<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Log;
use Session;
use Hash;
use App\UsuarioMetodosEnsayos;

class UserController extends Controller
{
    Protected $users;

    public function __construct()
    {

      $this->middleware(['role_or_permission:Sistemas|M_usuarios'], ['only' => ['callView']]);


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

        $User = new User;

        DB::beginTransaction();
        try {

            $this->saveUser($request,$User);
            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }

    }

    public function update(UserRequest $request,$id){

        DB::beginTransaction();
        try {

            $User = User::find($id);
            $this->saveUser($request,$User);
            UsuarioMetodosEnsayos::where('user_id',$id)->delete();
            $this->saveUser($request,$User);
            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }

    }

    public function saveUser($request,$User){

        if ($request['isEnod']) {

          $User->cliente_id = null ;
          $User->dni   = $request['dni'];
          $User->film  = $request['film'];
          $User->habilitado_arn_sn = $request['habilitado_arn_sn'];
          $User->notificar_doc_vencida_sn = !$request['exceptuar_notificar_doc_vencida_sn'];
          $User->notificar_demora_dosimetria_sn = !$request['exceptuar_notificar_demora_dosimetria_sn'];


        }else {

          $User->cliente_id = $request['cliente']['id'];

        }

        $User->name = $request['name'];
        $User->email = $request['email'];

        if($request['password'] != '********'){

          $User->password = bcrypt($request['password']);

        }

        if(!$User->api_token){

          $User->api_token = str_random(60);

        }
        $User->path = $request['path'];
        $User->syncRoles($request['roles']);
        $User->save();

        $this->saveUsuarioMetodos($request['metodos_firmas'],$User->id);

      }

    public function destroy($id){

      $user = User::find($id);
      $user->delete();

    }

    public function getUsersEmpresa(){

      return User::where('cliente_id',null)->orderBy('name','ASC')->get();

    }

    public function UserCliente($id){

      return User::where('cliente_id',$id)->orderBy('name','ASC')->get();

    }

    public function callviewPerfil(){

       $user = auth()->user();
       $cliente = Clientes::find($user->cliente_id);
       $header_titulo = "Perfil";
       $header_descripcion = "";
       return view('perfil',compact('user','cliente','header_titulo','header_descripcion'));

    }

    public function updatePerfil(UserRequest $request,$id){

      // dd(request()->all());

        $user = User::findOrFail($id);

        if (Hash::check($request->get('password'), $user->password)) {

            if ($request->get('password_nuevo')!='')  {

                if ($request->get('password_nuevo') == $request->get('password_confirmation'))
                {
                    $user->password = bcrypt($request->get('password_nuevo'));
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
            return back()->with('success','Perfil de usuario actualizado.');

        }else{

            return back()->with('error','La contraseña ingresada no es correcta.');
        }

      }

    public function getUsuarioMetodos($user_id){

        return UsuarioMetodosEnsayos::join('metodo_ensayos','metodo_ensayos.id','=','usuario_metodos_ensayos.metodo_ensayo_id')
                                      ->where('user_id',$user_id)
                                      ->select('metodo_ensayos.*')
                                      ->get();


    }

    public function saveUsuarioMetodos($metodos_firmas,$user_id){

        foreach ($metodos_firmas as $item) {

            UsuarioMetodosEnsayos::create(['metodo_ensayo_id' => $item['id'],'user_id'=> $user_id]);

        }

      }

}
