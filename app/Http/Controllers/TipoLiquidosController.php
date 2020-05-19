<?php

namespace App\Http\Controllers;
use App\TipoLiquidos;
use Illuminate\Http\Request;
use App\MetodosTrabajoLp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class TipoLiquidosController extends Controller
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

    public function getTipoLiquidos($penetrante_sn,$revelador_sn,$removedor_sn,$metodo_trabajo_lp_id){

        $metodo_trabajo = MetodosTrabajoLp::find($metodo_trabajo_lp_id);
        $fluorescente_sn = 0;
        $visible_sn = 0;
        $lavable_agua_sn = 0;
        $emusificante_lipofilico_sn = 0;
        $lavable_solvente_sn = 0;
        $emusificante_hidrofilico_sn = 0;
        $q = '';

        if($penetrante_sn){

            $q = $q . 'penetrante_sn = 1';

        }else if($revelador_sn){

            $q = $q . 'revelador_sn = 1';

        }else if($removedor_sn){

            $q = $q . 'removedor_sn = 1';
        }

        $q = $q ? ($q . ' and ') : '';

        switch ($metodo_trabajo->tipo) {

            case 'TIPO I':

                $q = $q . 'fluorescente_sn = 1';

                break;
            
            case 'TIPO II':

                $q = $q . 'visible_sn = 1';
                break;
        }

        $q = $q . ' and ';

        switch ($metodo_trabajo->metodo) {

            case 'METODO A':

                $q = $q . 'lavable_agua_sn = 1';         
                break;

            case 'METODO B':

                $q = $q . 'emusificante_lipofilico_sn = 1';            
                break;

            case 'METODO C':

                $q = $q . 'lavable_solvente_sn = 1'; 
                break;   

            case 'METODO D':

                $q = $q . 'emusificante_hidrofilico_sn = 1';       
                break;  
    
        }

    DB::enableQueryLog();      

    $tipo_liquidos = TipoLiquidos::whereRaw($q)
                                    ->get();    
    
    $queries = DB::getQueryLog();
    foreach($queries as $i=>$query)
    {
        Log::debug("Query $i: " . json_encode($query));
    }   

    return $tipo_liquidos;
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
