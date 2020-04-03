<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DocumentosEscaneados;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DocumentoEscaneadoRequest;


class DocumentosEscaneadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($ot_id,$tipo_documento,$id)
    {
        $user = auth()->user(); 
        $header_titulo = "Documentos Escaneados";
        $header_descripcion ="Alta | Baja | Modificación";    
     
        return view('documentos-escaneados.index',compact('ot_id', 
                                                          'tipo_documento',  
                                                          'id',                                                                          
                                                          'user',                                       
                                                          'header_titulo',
                                                          'header_descripcion'));
    }

    public function DocumentosEscaneadosOt($ot_id,$tipo_documento,$id){

        $filtro  = $this->getFiltro($tipo_documento);
        return DocumentosEscaneados::where('ot_id',$ot_id)   
                                     ->where($filtro,$id)                                        
                                      ->get();

    }

    public function getFiltro($tipo_documento){

        $filtro  = '';

        switch ($tipo_documento) {

            case 'informe':
                $filtro = 'informe_id';
                break;

            case 'parte':
                $filtro = 'parte_id';
                break;
                
            case 'certificado':
                 $filtro = 'certificado_id';
                 break;

        }

        return $filtro;
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
    public function store(DocumentoEscaneadoRequest $request)
    {
        
        $documento_escaneado = new DocumentosEscaneados;   

        DB::beginTransaction();
        try { 

            $this->saveDocumentoEscaneado($request,$documento_escaneado);
            DB::commit(); 

        } catch (Exception $e) {
    
            DB::rollback();
            throw $e;      
            
        }     

    }

    public function saveDocumentoEscaneado($request,$documento_escaneado){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }

        switch ($request->tipo_documento) {

            case 'informe':
                $documento_escaneado->informe_id = $request->id;
                break;

            case 'parte':
                $documento_escaneado->parte_id = $request->id;
                break;
                
            case 'certificado':
                 $documento_escaneado->certificado_id = $request->id;
                 break;

        }
        $documento_escaneado->ot_id = $request->ot_id;
        $documento_escaneado->path = $request->path;
        $documento_escaneado->descripcion = $request->descripcion;
        $documento_escaneado->user_id = $user_id;
        $documento_escaneado->save();

      
    }

    public function updateDocumentoEscaneado($request,$documento_escaneado){

        $user_id = null;
        
        if (Auth::check())
        {
             $user_id = $userId = Auth::id();    
        }  
               
        $documento_escaneado->path = $request->path;
        $documento_escaneado->descripcion = $request->descripcion;
        $documento_escaneado->user_id = $user_id;
        $documento_escaneado->save();

      
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
    public function update(DocumentoEscaneadoRequest $request,$id)
    {
        $documento_escaneado = DocumentosEscaneados::findOrFail($id);     
      
        DB::beginTransaction();
        try {

            $this->updateDocumentoEscaneado($request,$documento_escaneado);
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
        $documento_escaneado = DocumentosEscaneados::find($id);    
        $documento_escaneado->delete();
    }
}
