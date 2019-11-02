<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TrazabilidadFuente;
use App\InternoFuentes;

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

        $trazabilidad_fuente_actual = TrazabilidadFuente::where('interno_equipo_id',$interno_equipo_id)->latest()->first(); 

        if((!$trazabilidad_fuente_actual) || ($trazabilidad_fuente_actual && $trazabilidad_fuente_actual->interno_fuente_id != $interno_fuente_id) ) {
            
            $interno_fuente = InternoFuentes::find($interno_fuente_id);

            $trazabilidad_fuente = New TrazabilidadFuente;
            $trazabilidad_fuente->interno_equipo_id = $interno_equipo_id;
            $trazabilidad_fuente->interno_fuente_id = $interno_fuente_id;
            $trazabilidad_fuente->user_id = $user_id;
            $trazabilidad_fuente->curie = $interno_fuente->curie;
            $trazabilidad_fuente->save();  
          } 
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
