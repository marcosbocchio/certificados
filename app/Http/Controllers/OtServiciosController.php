<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtServicios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\User;

class OtServiciosController extends Controller
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

    public function getOtServiciosInforme($informe_id,$importado_sn){

        $servicio =  DB::select('CALL getServiciosInforme(?,?)',array($informe_id,$importado_sn));


        return $servicio;
    }


    public function getOtServicios($ot_id){

        $servicios =  DB::select('CALL getServiciosOt(?)',array($ot_id));

        return  $servicios;
    }


    public function getOtServiciosGenerales($ot_id){

        $servicio_generales =  DB::select('CALL getServiciosGenerales(?)',array($ot_id));

        return  $servicio_generales;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ot_servicios = DB::select('select 
                                    servicios.id as id,
                                    ots.id as ot_id,
                                    servicios.descripcion as servicio,
                                    norma_ensayos.codigo as norma_ensayo,
                                    norma_ensayos.id as norma_ensayo_id,
                                    metodo_ensayos.metodo as metodo,
                                    norma_evaluaciones.codigo as norma_evaluacion,
                                    norma_evaluaciones.id as norma_evaluacion_id,
                                    ot_servicios.cantidad as cantidad_servicios,
                                    ot_servicios.cant_max_placas as cantidad_placas,
                                    ot_servicios.combinado_sn as combinado_sn,
                                    ot_servicios.procedimiento_sn as procedimiento_sn,
                                    ot_servicios.ot_referencia_id as ot_referencia_id,
                                    ot_referencias.descripcion as observaciones,
                                    ot_referencias.path1 as path1,
                                    ot_referencias.path2 as path2,
                                    ot_referencias.path3 as path3,
                                    ot_referencias.path4 as path4,
                                    unidades_medidas.codigo as unidad_medida
                                    
                                    from ot_servicios
                                    inner join servicios on 
                                    servicios.id = ot_servicios.servicio_id
                                    inner join unidades_medidas on 
                                    unidades_medidas.id = servicios.unidades_medida_id
                                    left join ot_referencias on
                                    ot_referencias.id = ot_servicios.ot_referencia_id
                                    left join norma_ensayos on
                                    norma_ensayos.id = ot_servicios.norma_ensayo_id
                                    left join norma_evaluaciones on
                                    norma_evaluaciones.id = ot_servicios.norma_evaluacion_id
                                    inner join metodo_ensayos on
                                    servicios.metodo_ensayo_id = metodo_ensayos.id
                                    inner join ots on
                                    ot_servicios.ot_id=ots.id and
                                    ots.id=:id',['id' => $id ]);
                                    

        $ot_servicios = Collection::make($ot_servicios);

        return $ot_servicios;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
