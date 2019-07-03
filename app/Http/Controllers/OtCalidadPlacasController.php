<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtCalidadPlacas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

class OtCalidadPlacasController extends Controller
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
        $ot_calidad_placas = DB::select('select 
        
                                        tipo_peliculas.id,
                                        tipo_peliculas.codigo ,
                                        tipo_peliculas.descripcion,
                                        tipo_peliculas.fabricante 
                                        
                                        from tipo_peliculas
                                        inner join ot_calidad_placas on
                                        tipo_peliculas.id = ot_calidad_placas.tipo_pelicula_id 
                                        inner join ots  on
                                        ots.id = ot_calidad_placas.ot_id
                                        where
                                        ots.id =:id',['id' => $id ]);

        $ot_calidad_placas = Collection::make($ot_calidad_placas);

        return $ot_calidad_placas;
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
