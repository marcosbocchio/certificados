<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alarmas;
use Illuminate\Support\Facades\DB;

class AlarmasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Alarmas::where('pos_vencimiento_sn',0)->get();
    }

    public function getAlarmaDosimetria(){

        return Alarmas::where('pos_vencimiento_sn',1)->first();

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
            $alarma->save();

            }

            $alarma = Alarmas::where('tipo','DOSIMETRIA')->first();

            $alarma->aviso1 = isset($request->aviso1_dosimetria['dias']) ? $request->aviso1_dosimetria['dias'] : '' ;
            $alarma->aviso2 = $request->aviso2_dosimetria;
            $alarma->save();

            DB::commit();

          } catch (Exception $e) {

              DB::rollback();
              throw $e;

          }

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
