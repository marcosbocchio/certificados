<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TrazabilidadCurie;

class TrazabilidadCurieController extends Controller
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

    public function saveTrazabilidadCurie($interno_fuente_id,$curie){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
         }

        $trazabilidad_curie_actual = TrazabilidadCurie::where('interno_fuente_id',$interno_fuente_id)->latest()->first(); 

        if((!$trazabilidad_curie_actual) || ($trazabilidad_curie_actual && $trazabilidad_curie_actual->curie != $curie) ) {
            
            $trazabilidad_curie = New TrazabilidadCurie;
            $trazabilidad_curie->interno_fuente_id = $interno_fuente_id;
            $trazabilidad_curie->user_id = $user_id;
            $trazabilidad_curie->curie = $curie;
            $trazabilidad_curie->save();  
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
