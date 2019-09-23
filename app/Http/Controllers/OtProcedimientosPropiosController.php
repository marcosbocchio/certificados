<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Documentaciones;
use App\OtProcedimientosPropios;
use App\Ots;

class OtProcedimientosPropiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($ot_id)
    {
        $header_titulo = "Procedimientos OT";
        $header_descripcion ="Alta | Baja | Modificación";      
        $accion = 'edit';      
        $user = auth()->user()->name;
        $ot = Ots::findOrFail($ot_id);
        $ot_procedimientos = $this->ProcedimientosPropiosOt($ot_id);
 

        return view('ot-procedimientos.index',compact('ot_id',
                                        'ot_procedimientos',                                   
                                        'user',                                       
                                        'header_titulo',
                                        'header_descripcion'));
    }

    public function ProcedimientosPropiosOt($ot_id){

        $documentaciones = DB::table('documentaciones')
                    ->join('ot_procedimientos_propios','ot_procedimientos_propios.documentacion_id','=','documentaciones.id')
                    ->where('ot_procedimientos_propios.ot_id',$ot_id)
                    ->select('documentaciones.*')
                    ->get();

        foreach ($documentaciones as $documentacion) {

                $metodo_ensayo = DB::table('documentaciones')
                                    ->leftJoin('metodo_ensayos','documentaciones.metodo_ensayo_id','=','metodo_ensayos.id')
                                    ->where('documentaciones.id',$documentacion->id)   
                                    ->select('metodo_ensayos.*')
                                    ->first();
    
                $usuario = DB::table('documentaciones')
                                    ->leftJoin('usuario_documentaciones','usuario_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->leftJoin('users','usuario_documentaciones.user_id','=','users.id')
                                    ->where('documentaciones.id',$documentacion->id)   
                                    ->select('users.*')
                                    ->first();  
    
                $metodo_ensayo = $metodo_ensayo ? $metodo_ensayo : "";       
                $usuario = $usuario ? $usuario : "";        
                $documentacion->metodo_ensayo = $metodo_ensayo ;
                $documentacion->usuario = $usuario ;
            }               
        
            return $documentaciones;


}

    public function OtProcedimientosTotal($ot_id){


        return OtProcedimientosPropios::where('ot_id',$ot_id)->count(); 

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
        $documento = Documentaciones::find($id);    
        
        $ot_procedimiento_propio = new OtProcedimientosPropios;
    
        $ot_procedimiento_propio->where('documentacion_id',$id)->delete();
  
      
        $documento->delete();
    }
}
