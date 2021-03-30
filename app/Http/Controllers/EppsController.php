<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Epps;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class EppsController extends Controller
{

    public function index()
    {
        // return Epps::orderBy('descripcion','ASC')->get();
    }

    public function eppsMetodos($ids_servicios){

        Log::debug("epps: " . $ids_servicios);
        return Epps::join('epps_metodo','epps_metodo.epps_id','=','epps.id')
                     ->join('metodo_ensayos','metodo_ensayos.id','=','epps_metodo.metodo_ensayo_id')
                     ->join('servicios','servicios.metodo_ensayo_id','=','metodo_ensayos.id')
                     ->whereRaw('FIND_IN_SET(servicios.id,?)',[$ids_servicios])
                     ->selectRaw('epps.*')
                     ->groupBy('epps.id')
                     ->orderBy('epps.descripcion','ASC')->get();
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
