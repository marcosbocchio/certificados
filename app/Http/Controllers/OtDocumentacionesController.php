<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ots;
use App\OtDocumentaciones;

class OtDocumentacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($ot_id)
    {
        $header_titulo = "Documentaciones";
        $header_descripcion ="Alta | Baja | Modificación";      
        $accion = 'edit';      
        $user = auth()->user();

        $ot_documentaciones = $this->getdocumentacionesOt($ot_id);
        $ot = Ots::find($ot_id);

        $ot = Ots::where('id',$ot_id)->with('cliente')->first();
        $header_sub_titulo =' / ' .$ot->cliente->nombre_fantasia . ' / OT N°: ' . $ot->numero;
        
        return view('ot-documentaciones.index',compact('ot',
                                        'ot_documentaciones',                                   
                                        'user',                                       
                                        'header_titulo',
                                        'header_sub_titulo',
                                        'header_descripcion'));
    }

    public function getdocumentacionesOt($ot_id){

        return DB::table('documentaciones')
                    ->join('ot_documentaciones','ot_documentaciones.documentacion_id','=','documentaciones.id')
                    ->where('ot_documentaciones.ot_id',$ot_id)
                    ->select('documentaciones.*')
                    ->get();

    }

    public function OtDocumentacionesTotal($ot_id){


        return OtDocumentaciones::where('ot_id',$ot_id)->count(); 

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
        try
        {

                $ot = $request->ot;             
                $ot_documentaciones = OtDocumentaciones::where('ot_id',$ot['id'])->get();

                foreach ($ot_documentaciones as $ot_documento) {
                  $existe = false;
                    foreach ($request->documentaciones as $documento) {

                        if( ($ot_documento['documentacion_id'] == $documento['id'])){
                          $existe = true;
                        }
                  
                    }

                  if (!$existe){
                    OtDocumentaciones::where('ot_id',$ot['id'])
                                 ->where('documentacion_id',$ot_documento['documentacion_id'])
                                 ->delete();
                    }
                }
         
               foreach ($request->documentaciones as $documento) {

                    $ot_documentaciones_update = OtDocumentaciones::firstOrCreate(
                        
                       ['ot_id' => $ot['id'],'documentacion_id' => $documento['id']],
                       ['ot_id' => $ot['id'],'documentacion_id' => $documento['id']]

                    );
       
                $ot_documentaciones_update->save();

              
              } 
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }     
   
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
