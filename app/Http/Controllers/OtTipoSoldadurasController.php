<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtTipoSoldaduras;
use Illuminate\Support\Facades\DB;


class OtTipoSoldadurasController extends Controller
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
        $ot_id = $request->ot['id'];

        $ot_tipo_soldaduras = OtTipoSoldaduras::where('ot_id',$ot_id)->get();

        foreach ($ot_tipo_soldaduras as $ot_tipo_soldadura) {
          $existe = false;
            foreach ($request->tipo_soldaduras as $tipo_soldadura) {

                if( ($ot_tipo_soldadura['tipo_soldadura_id'] == $tipo_soldadura['tipo_soldadura']['id']) &&(($ot_tipo_soldadura['obra'] == $tipo_soldadura ['obra']))){
                  $existe = true;
                }
          
            }

          if (!$existe){
            OtTipoSoldaduras::where('ot_id',$ot_id)
                         ->where('tipo_soldadura_id',$ot_tipo_soldadura['tipo_soldadura_id'])
                         ->where('obra',$ot_tipo_soldadura['obra'])
                         ->delete();
            }
        }


        foreach ($request->tipo_soldaduras as $item) {
      
            $tipo_soldadura = OtTipoSoldaduras::updateOrCreate(
                
                ['ot_id' => $ot_id,'obra'=>$item['obra'],'tipo_soldadura_id' => $item['tipo_soldadura']['id']],
                ['ot_id' => $ot_id,'obra'=>$item['obra'],'tipo_soldadura_id' => $item['tipo_soldadura']['id'],'eps'=>$item['eps'],'pqr'=>$item['pqr']]

            );

        $tipo_soldadura->save();
  
         } 
    }


    public function TipoSoldadurasOt($ot_id){

        return OtTipoSoldaduras::where('ot_id',$ot_id)
                                ->join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
                                ->with('tipoSoldadura')
                                ->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')
                                 ->get();


    }

    public function TipoSoldadurasOtObra($ot_id,$obra = null){

        $obra = str_replace('--','/',$obra);
        return OtTipoSoldaduras::where('ot_id',$ot_id)
                                ->where('obra',$obra)    
                               // ->where('tipo_soldaduras.codigo','!=','R')
                                ->join('tipo_soldaduras','tipo_soldaduras.id','=','ot_tipo_soldaduras.tipo_soldadura_id')
                                ->with('tipoSoldadura')
                                ->select('ot_tipo_soldaduras.*','tipo_soldaduras.codigo')
                                 ->get();


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
