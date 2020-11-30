<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alarmas;
use Illuminate\Support\Facades\DB;

class AlarmasController extends Controller
{
    public function getTodas()
    {

        return Alarmas::all();

    }

    public function index()
    {
        return Alarmas::where('tipo','!=','DOSIMETRIA')->get();
    }

    public function getAlarmaDosimetria(){

        return Alarmas::where('tipo','DOSIMETRIA')->first();

    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Alarmas";
        $header_descripcion ="";
        return view('notificaciones.alarmas',compact('user','header_titulo','header_descripcion'));

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

        $alarmas = new Alarmas;

          DB::beginTransaction();

          try {

            foreach ($request->alarmas as $item) {

            $alarma = Alarmas::find($item['id']);
            $alarma->aviso1 = $item['aviso1'] ;
            $alarma->aviso2 = $item['aviso2'] ;
            $alarma->activo_sn = $item['activo_sn'] ;
            $alarma->save();

            }

            $alarma = Alarmas::where('tipo','DOSIMETRIA')->first();

            $alarma->aviso1 = isset($request->aviso1_dosimetria['dias']) ? $request->aviso1_dosimetria['dias'] : '' ;
            $alarma->aviso2 = $request->aviso2_dosimetria;
            $alarma->activo_sn = $request->activo_sn_dosimetria;
            $alarma->save();

            DB::commit();

          } catch (Exception $e) {

              DB::rollback();
              throw $e;

          }

    }

    public function BuscarAlarma($alarmas,$tipo){

        foreach ($alarmas as $alarma) {

            if($alarma->tipo == $tipo){

                return $alarma;

            }
        }

        return false;

     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        //
    }
}
