<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use Illuminate\Support\Facades\DB;
use App\User;
use App\OtOperarios;
use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\Log;

class OtOperariosController extends Controller
{
    public function __construct()
    {

        $this->middleware(['role_or_permission:Sistemas|T_operador_acceder'],['only' => ['index']]);
        $this->middleware(['role_or_permission:Sistemas|T_operador_actualiza'],['only' => ['store']]);

    }

    public function index($id)
    {
        $header_titulo = "Operadores";
        $header_descripcion ="Alta | Baja | Modificación";
        $accion = 'edit';
        $user = auth()->user();

        $ot = Ots::where('id',$id)->with('cliente')->first();
        $header_sub_titulo =' / ' .$ot->cliente->nombre_fantasia . ' / OT N°: ' . $ot->numero;

        $users_ot_operarios = $this->getOperadoresOt($id);


        return view('ot-operarios.index',compact('id',
                                        'users_ot_operarios',
                                        'user',
                                        'header_titulo',
                                        'header_sub_titulo',
                                        'header_descripcion'));

    }

    public function getOperadoresOt($ot_id){


        $users_ot_operarios = DB::table('users')
                                  ->join('ot_operarios','users.id','=','ot_operarios.user_id')
                                  ->join('ots','ot_operarios.ot_id','=','ots.id')
                                  ->where('ots.id',$ot_id)
                                  ->select('users.*','ot_operarios.id as ot_operario_id','ot_operarios.ayudante_sn')
                                  ->get();

        return $users_ot_operarios;

    }

    public function getEjecutorEnsayo($id){


        $ejecutor_ensayo = DB::table('users')
                                  ->join('ot_operarios','users.id','=','ot_operarios.user_id')
                                  ->where('ot_operarios.id',$id)
                                  ->select('users.*','ot_operarios.id as ot_operario_id')
                                  ->first();

        return Collection::make($ejecutor_ensayo);

    }

    public function store(Request $request)
    {
        DB::enableQueryLog();

        DB::beginTransaction();
        try
        {

                $ot_id = $request->ot_id;

                $ot_operarios = OtOperarios::where('ot_id',$ot_id)->get();

                foreach ($ot_operarios as $ot_operario) {
                  $existe = false;
                    foreach ($request->operarios as $operario) {

                        if( ($ot_operario['user_id'] == $operario['id'])){
                          $existe = true;
                        }

                    }

                  if (!$existe){
                     OtOperarios::where('ot_id',$ot_id)
                                 ->where('user_id',$ot_operario['user_id'])
                                 ->delete();
                    }
                }

               foreach ( $request->operarios as $operario) {

                    $ot_operarios_update =OtOperarios::updateOrCreate(
                        ['ot_id' => $request->ot_id,'user_id' => $operario['id']],
                        ['ot_id' => $request->ot_id,'user_id' => $operario['id'],'ayudante_sn' => $operario['ayudante_sn']]

                    );

                $ot_operarios_update->save();

              }
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }

    public function users(){

        return User::whereNull('cliente_id')->where('habilitado_sn',1)->orderBy('name','ASC')->get();

    }

    public function OtOperadoresTotal($ot_id){

        return OtOperarios::where('ot_id',$ot_id)->count();

    }

}
