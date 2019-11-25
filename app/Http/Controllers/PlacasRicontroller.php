<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Informe;
use App\InformesRi;
use App\PlacasRi;
use Illuminate\Support\Facades\DB;

class PlacasRicontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($informe_id)
    {
        $header_titulo = "Placas Informes";
        $header_descripcion ="Alta | Baja | Modificación";      
        $accion = 'edit';      
        $user = auth()->user()->name;
        $informe = informe::findOrFail($informe_id);
        $placas_informe = $this->PlacasInforme($informe_id);
 
        
        return view('informe-placas.index',compact('informe_id',                                   
                                                    'user',                                       
                                                    'header_titulo',
                                                    'header_descripcion'));
    }

    public function PlacasInforme($informe_id){

        $placas = DB::table('placas_ri')
                    ->join('informes_ri','informes_ri.id','=','placas_ri.informe_ri_id')
                    ->join('informes','informes.id','=','informes_ri.informe_id')
                    ->where('informes.id',$informe_id)
                    ->select('placas_ri.*')
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)

    { 
        DB::beginTransaction();
        try { 

            $informe_ri = InformesRi::where('informe_id',$request->informe_id)->first();
            $placa = new PlacasRi();
            $this->savePlacas($placa,$informe_ri,$request);
            DB::commit();

        } catch (Exception $e) {
        
            DB::rollback();
            throw $e;      
            
            }
       
    }

    public function savePlacas($placa,$informe_ri,$request){

        $placa->informe_ri_id = $informe_ri->id;
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
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try { 

        $informe_ri = InformesRi::where('informe_id',$request->informe_id)->first();
        $placa = PlacasRi::findORfail($id);
        $this->savePlacas($placa,$informe_ri,$request);
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
        
        $placas = PlacasRi::find($id);    
      
        $placas->delete();
    }
}
