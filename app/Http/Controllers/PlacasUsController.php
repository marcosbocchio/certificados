<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlacaRequest;
use App\Informe;
use App\PlacasUs;
use App\InformesUs;
use Illuminate\Support\Facades\DB;

class PlacasUsController extends Controller
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


    public function PlacasInforme($informe_id){

        $placas = DB::table('placas_us')
                    ->join('informes_us','informes_us.id','=','placas_us.informe_us_id')
                    ->join('informes','informes.id','=','informes_us.informe_id')
                    ->where('informes.id',$informe_id)
                    ->select('placas_us.*')
                    ->get();
            
        
        return $placas;


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

    public function store(PlacaRequest $request)

    { 
        DB::beginTransaction();
        try { 

            $informe_us = InformesUs::where('informe_id',$request->informe_id)->first();
            $placa = new PlacasUs();
            $this->savePlacas($placa,$informe_us,$request);
            DB::commit();

        } catch (Exception $e) {
        
            DB::rollback();
            throw $e;      
            
            }
       
    }

    public function savePlacas($placa,$informe_us,$request){

        $placa->informe_us_id = $informe_us->id;
        $placa->descripcion = $request->descripcion;
        $placa->path = $request->path;
        $placa->save();

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
    public function update(PlacaRequest $request, $id)
    {
        DB::beginTransaction();
        try { 

        $informe_us = InformesUs::where('informe_id',$request->informe_id)->first();
        $placa = PlacasUs::findORfail($id);
        $this->savePlacas($placa,$informe_us,$request);
        DB::commit();

        
    } catch (Exception $e) {
        
        DB::rollback();
        throw $e;      
        
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
        
        $placas = PlacasUs::find($id);    
      
        $placas->delete();
    }
}
