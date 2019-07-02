<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtProductos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

class OtProductosController extends Controller
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
        $ot_productos = DB::select('select 
                                    productos.id as id,
                                    ots.id as ot_id,
                                    productos.descripcion as producto,
                                    medidas.descripcion as medida,
                                    medidas.id as medida_id,
                                    productos.unidades_medida_id as unidad_medida_id,
                                    unidades_medidas.codigo as unidad_medida_codigo,
                                    ot_productos.cantidad as cantidad_productos,
                                    ot_productos.ot_referencia_id as ot_referencia_id,
                                    ot_referencias.descripcion as observaciones,
                                    ot_referencias.path1 as path1,
                                    ot_referencias.path2 as path2,
                                    ot_referencias.path3 as path3,
                                    ot_referencias.path4 as path4
                                    
                                    from productos
                                    inner join ot_productos on
                                    ot_productos.producto_id = productos.id
                                    left join ot_referencias on
                                    ot_referencias.id = ot_productos.ot_referencia_id
                                    inner join medidas on
                                    medidas.id = ot_productos.medida_id
                                    inner join unidades_medidas on
                                    medidas.unidades_medida_id = unidades_medidas.id
                                    inner join ots on
                                    ots.id = ot_productos.ot_id and
                                    ots.id=:id',['id' => $id ]);

        $ot_productos = Collection::make($ot_productos);
             
        return $ot_productos;
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
