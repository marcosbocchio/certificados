<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notificaciones;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class NotificacionesController extends Controller
{

    public function __construct()
    {

       $this->middleware(['role_or_permission:Sistemas|N_notificaciones'],['only' => ['callView']]);

    }

    public function callView()
    {

        $user = auth()->user();
        $header_titulo = "";
        $header_descripcion ="";
        $operador = auth()->user();
        return view('notificaciones.notificaciones',compact('user','operador','header_titulo','header_descripcion'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getNotificaciones($user_id){

        return Notificaciones::where('user_id',$user_id)
                               ->with('documentacion')
                               ->orderby('fecha','DESC')
                               ->get();


    }

    public function marcarNotificaciones($id){

        $notificacion = Notificaciones::find($id);
        $notificacion->notificado_sn = !$notificacion->notificado_sn;
        $notificacion->save();


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
    public function store($user_id,$item)
    {

        $notificacion = new notificaciones;

        $descripcion = '';

        switch ($item->tipo) {

            case 'INSTITUCIONAL':

                $descripcion ='Le informamos el vencimiento de la siguiente documentación institucional '. $item->name . ': ' . $item->titulo . ' con fecha de vencimiento al día ' . date("d-m-Y", strtotime($item->fecha_caducidad));
                break;

            case 'USUARIO':
                $descripcion ='Le informamos el vencimiento de la siguiente documentación del usuario '. $item->name . ': ' . $item->titulo . ' con fecha de vencimiento al día ' . date("d-m-Y", strtotime($item->fecha_caducidad));
                break;

            case 'FUENTE':
                $descripcion ='Le informamos el vencimiento de la siguiente documentación de la fuente ' .$item->name . ': INT Nº ' . $item->nro_serie . ', código ' . $item->codigo . ' con fecha de vencimiento al día ' . date("d-m-Y", strtotime($item->fecha_caducidad));
                break;

            case 'EQUIPO':
                $descripcion ='Le informamos el vencimiento de la siguiente documentación del equipo '. $item->name . ': INT Nº ' . $item->nro_serie . ', código ' . $item->codigo . ' con fecha de vencimiento al día ' . date("d-m-Y", strtotime($item->fecha_caducidad));
                break;

            case 'PROCEDIMIENTO GENERAL':
                $descripcion ='Le informamos el vencimiento de la siguiente documentación del procedimiento: ' . $item->titulo . ' con fecha de vencimiento al día ' . date("d-m-Y", strtotime($item->fecha_caducidad));
                break;

            case 'VEHICULO':
                $descripcion ='Le informamos el vencimiento de la siguiente documentación del vehículo: ' . $item->titulo . ', marca' . $item->marca . ', modelo ' . $item->modelo . ', patente ' . $item->patente . ' con fecha de vencimiento al día ' . date("d-m-Y", strtotime($item->fecha_caducidad));;
                break;

            default:
                # code...
                break;

        }

        $notificacion->descripcion =  $descripcion;
        $notificacion->documentacion_id = $item->documentacion_id;
        $notificacion->user_id = $user_id;
        $notificacion->fecha = DB::raw('now()');
        $notificacion->notificado_sn = false;
        $notificacion->save();
    }

    public function storeDosimetria($receptor_id,$user,$fechas_demoras){

        $notificacion = new notificaciones;

        $str_fechas = '';

        foreach ($fechas_demoras as $item) {
            $str_fechas = $str_fechas . ' ' . $item;
        }

        $notificacion->descripcion = 'Le informamos que el usuario ' . $user->name . ' tiene demora en la carga de dosimetría en las siguientes fechas : ' . $str_fechas ;
        $notificacion->user_id = $receptor_id;
        $notificacion->fecha = DB::raw('now()');
        $notificacion->notificado_sn = false;
        $notificacion->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $material = Notificaciones::find($id);
        $material->delete();
    }
}
