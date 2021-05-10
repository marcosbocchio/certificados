<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternoEquipos;
use App\OtInternosEquipos;
use App\Ots;
use Illuminate\Support\Facades\DB;

class OtInternosEquiposController extends Controller
{
    public function __construct()
    {

          $this->middleware(['role_or_permission:Sistemas|T_equipos_acceder'],['only' => ['OtInternoEquipos']]);

    }
    public function index()
    {
        //
    }

    public function OtInternoEquipos($ot_id){

        $header_titulo = "Equipos OT";
        $header_descripcion ="Alta | Baja | Modificación";
        $accion = 'edit';
        $user = auth()->user();

        $ot = Ots::where('id',$ot_id)->with('cliente')->first();
        $header_sub_titulo =' / ' .$ot->cliente->nombre_fantasia . ' / OT N°: ' . $ot->numero;

        $ot_interno_equipos = $this->getInternoEquiposOt($ot_id);


        return view('ot-interno-equipos.index',compact('ot_id',
                                                       'ot_interno_equipos',
                                                       'user',
                                                       'header_titulo',
                                                       'header_sub_titulo',
                                                       'header_descripcion'));


      }

    public function getInternoEquiposOt($ot_id){

        return InternoEquipos::join('ot_internos_equipos','ot_internos_equipos.interno_equipo_id','=','interno_equipos.id')
                               ->where('ot_internos_equipos.ot_id',$ot_id)
                               ->with('equipo')
                               ->with('internoFuente.fuente')
                               ->select('interno_equipos.*')
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

    public function Update(Request $request,$ot_id){

        DB::beginTransaction();
        try
        {

            $ot_interno_equipos = OtInternosEquipos::where('ot_id',$ot_id)->get();

            foreach ($ot_interno_equipos as $ot_interno_equipo) {
                $existe = false;
                foreach ($request->interno_equipos as $interno_equipo) {

                    if( ($ot_interno_equipo['interno_equipo_id'] == $interno_equipo['id'])){
                        $existe = true;
                    }

                }

                if (!$existe){
                    OtInternosEquipos::where('ot_id',$ot_id)
                                        ->where('interno_equipo_id',$ot_interno_equipo['interno_equipo_id'])
                                        ->delete();
                }
            }

            foreach ($request->interno_equipos as $interno_equipo) {

                $ot_interno_equipo_update = OtInternosEquipos::firstOrCreate(

                    ['ot_id' => $ot_id,'interno_equipo_id' => $interno_equipo['id']],
                    ['ot_id' => $ot_id,'interno_equipo_id' => $interno_equipo['id']]

                );

            $ot_interno_equipo_update->save();

            }


            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
      }

    public function OtInternoEquiposTotal($ot_id){


        return OtInternosEquipos::where('ot_id',$ot_id)->count();

    }


    public function edit($id)
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
