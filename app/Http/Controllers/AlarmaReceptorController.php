<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlarmaReceptor;
use App\User;

class AlarmaReceptorController extends Controller
{

    public function __construct()
    {

       $this->middleware(['role_or_permission:Sistemas|N_asignar_alarma'],['only' => ['callView']]);

    }


    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Alarmas receptor";
        $header_descripcion ="";
        return view('notificaciones.alarma-receptor',compact('user','header_titulo','header_descripcion'));

    }

    public function getAlarmaReceptor($id){

        return AlarmaReceptor::join('users','users.id','=','alarma_receptor.user_id')
                               ->where('alarma_id',$id)
                               ->select('users.*')
                               ->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $alarma = $request->alarma;
      $receptores= $request->receptores;

      AlarmaReceptor::where('alarma_id',$alarma['id'])
                      ->delete();

      foreach ($receptores as $receptor) {

        $alarma_receptor = new AlarmaReceptor;
        $alarma_receptor->user_id = $receptor['id'];
        $alarma_receptor->alarma_id = $alarma['id'];
        $alarma_receptor->save();

      }

    }

    public function BuscarReceptores($tipo){

        return User::join('alarma_receptor','alarma_receptor.user_id','=','users.id')
                     ->join('alarmas','alarmas.id','=','alarma_receptor.alarma_id')
                     ->where('alarmas.tipo',$tipo)
                     ->select('users.*')
                     ->get();


     }


}
