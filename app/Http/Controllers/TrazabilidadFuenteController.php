<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TrazabilidadFuente;
use App\InternoFuentes;
use Carbon\carbon;
use App\InternoEquipos;
use Illuminate\Support\Facades\Log;

class TrazabilidadFuenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    public function saveTrazabilidadFuente($interno_equipo_id,$interno_fuente_id){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }
     
        $fecha_actual =  Carbon::now();

        $trazabilidad_fuente_actual = TrazabilidadFuente::where('interno_equipo_id',$interno_equipo_id)->latest()->first(); 

        if($interno_fuente_id){

                if((!$trazabilidad_fuente_actual) || ($trazabilidad_fuente_actual && $trazabilidad_fuente_actual->interno_fuente_id != $interno_fuente_id) ) {
                    
                    /*  Agrego el nuevo registro de trazabilidad*/

                    $interno_fuente = InternoFuentes::find($interno_fuente_id);
                    $trazabilidad_fuente = New TrazabilidadFuente;
                    $trazabilidad_fuente->interno_equipo_id = $interno_equipo_id;
                    $trazabilidad_fuente->interno_fuente_id = $interno_fuente_id;
                    $trazabilidad_fuente->fecha_alta =  $fecha_actual;
                    $trazabilidad_fuente->user_id = $user_id;
                    $trazabilidad_fuente->curie = $interno_fuente->curie;
                    $trazabilidad_fuente->save();  

                } 

          }


          if($trazabilidad_fuente_actual && !$trazabilidad_fuente_actual->fecha_baja){

                $trazabilidad_fuente_actual->fecha_baja =  $fecha_actual;
                $trazabilidad_fuente_actual->save();  

          }
        
    }

    public function getTrazabilidad(Request $request,$interno_equipo_id){

        $page = $request->page;
        Log::debug("Query page: " . $page);
        $trazabilidad_fuente = TrazabilidadFuente::where('interno_equipo_id',$interno_equipo_id)->with('internoFuente.fuente')->orderBy('fecha_alta','desc')->paginate(10);

        return $trazabilidad_fuente;

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
