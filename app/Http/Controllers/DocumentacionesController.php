<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DocumentacionesRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use App\Documentaciones;
use App\UsuarioDocumentaciones;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;





class DocumentacionesController extends Controller
{

    Protected $documentaciones;

    public function __construct(DocumentacionesRepository $documentacionesRepository)
    {
      $this->documentaciones = $documentacionesRepository;
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentaciones = DB::select('select   
                                        documentaciones.id as id,
                                        documentaciones.tipo as tipo,
                                        documentaciones.titulo as titulo,
                                        documentaciones.descripcion as descripcion,
                                        documentaciones.path as path,
                                        metodo_ensayos.metodo,
                                        usuario_documentaciones.user_id as user_id,
                                        documentaciones.metodo_ensayo_id as metodo_ensayo_id,
                                        usuario_documentaciones.fecha_caducidad as fecha_caducidad,
                                        users.name
                                        
                                        from
                                        documentaciones left join usuario_documentaciones on                                
                                        usuario_documentaciones.documentacion_id = documentaciones.id
                                        left join users on users.id = usuario_documentaciones.user_id
                                        left join metodo_ensayos on metodo_ensayos.id = documentaciones.metodo_ensayo_id
                              ');

        $documentaciones = Collection::make($documentaciones);

        return $documentaciones;
    }

    public function callView()
    {
        $user = auth()->user()->name;
        $header_titulo = "Documentaciones";
        $header_descripcion ="Alta | Baja | Modificación";      
        return view('abm.documentaciones',compact('user','header_titulo','header_descripcion'));
        
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
    public function store(DocumentacionesRequest $request)
    {
        
        return $this->documentaciones->store($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $documentacion = DB::select('select   
                                    documentaciones.id as id,
                                    documentaciones.tipo as tipo,
                                    documentaciones.titulo as titulo,
                                    documentaciones.descripcion as descripcion,
                                    documentaciones.path as path,
                                    usuario_documentaciones.user_id as user_id,
                                    documentaciones.metodo_ensayo_id as metodo_ensayo_id,
                                    usuario_documentaciones.fecha_caducidad as fecha_caducidad
                                    
                                    from
                                    documentaciones left join usuario_documentaciones on
                                    usuario_documentaciones.documentacion_id = documentaciones.id
                                    where
                                    documentaciones.id=:id',['id' => $id ]);

        $documentacion = Collection::make($documentacion);

        return $documentacion;
    }

    public function institucionales($id)
    {
        $document = Documentaciones::where('id' , $id)
                                     ->where('tipo','INSTITUCIONAL')
                                     ->firstOrFail();
        $path = storage_path('app/'. $document->path);
        return response()->file($path);

    }

    public function operarios($id)
    {
       
        $document = Documentaciones::where('id' , $id)
                                     ->where('tipo','USUARIO')
                                     ->firstOrFail();   

        $path = storage_path('app/'. $document->path);    
        return response()->file($path);
       
    }

    public function getDocOtOperarios($ot_id,$user_id){

                        $documentacion = DB::select('select 
                        documentaciones.id,
                        documentaciones.tipo,
                        documentaciones.descripcion,
                        documentaciones.titulo as titulo,
                        documentaciones.path,
                        usuario_documentaciones.user_id,
                        documentaciones.metodo_ensayo_id,
                        usuario_documentaciones.fecha_caducidad,
                        users.name 
                        
                        from usuario_documentaciones
                        inner join documentaciones on
                        documentaciones.id = usuario_documentaciones.documentacion_id
                        inner join users on
                        users.id = usuario_documentaciones.user_id
                        inner join ot_operarios on
                        ot_operarios.user_id = users.id 
                        where 
                        (documentaciones.metodo_ensayo_id is null or documentaciones.metodo_ensayo_id in (Select servicios.metodo_ensayo_id from servicios
                        inner join ot_servicios on 
                        ot_servicios.servicio_id = servicios.id                          
                        where
                        ot_servicios.ot_id = ot_operarios.ot_id )) and
                        ot_operarios.ot_id =:ot_id and
                        ot_operarios.user_id=:user_id',['user_id' => $user_id, 'ot_id' =>$ot_id]);

        $documentacion = Collection::make($documentacion);

        return $documentacion;

    }

    public function ProcedimientosMetodo($ot_id,$metodo)
    {
        return DB::table('ot_procedimientos_propios')
        ->join('ots','ots.id','=','ot_procedimientos_propios.ot_id')
        ->join('documentaciones','documentaciones.id','=','ot_procedimientos_propios.documentacion_id')      
        ->join('metodo_ensayos','metodo_ensayos.id','=','documentaciones.metodo_ensayo_id')   
        ->where('ots.id','=',$ot_id)
        ->where('metodo_ensayos.metodo','=',$metodo)
        ->select('documentaciones.*','ot_procedimientos_propios.id as ot_procedimientos_propios_id')
        ->get();
    }

    public function ProcedimientoInformeId($id)
    {
        $procedimiento = DB::table('documentaciones')
        ->join('ot_procedimientos_propios','ot_procedimientos_propios.documentacion_id','=','documentaciones.id')
        ->where('ot_procedimientos_propios.id','=',$id)      
        ->select('documentaciones.*','ot_procedimientos_propios.id as ot_procedimientos_propios_id')
        ->first();

        return  $procedimiento = Collection::make($procedimiento); 
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
        $documento = $this->documentaciones->find($id);    
        
        $usuarioDocumento = new UsuarioDocumentaciones;
    
        $usuarioDocumento->where('documentacion_id',$id)->delete();
  
      
        $documento->delete();

    }
}
