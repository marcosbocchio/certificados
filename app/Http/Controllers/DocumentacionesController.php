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
use App\MetodoEnsayos;
use App\Users;


class DocumentacionesController extends Controller
{

    Protected $documentaciones;

    public function __construct(DocumentacionesRepository $documentacionesRepository)
    {

        $this->middleware(['role_or_permission:Super Admin|M_documentaciones'],['only' => ['callView']]);   
        $this->documentaciones = $documentacionesRepository;
     
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $filtro = $request->search == 'null' ? '' : $request->search;;
        $tipo = $request->tipo == 'null' ? '' : $request->tipo;
        $documentaciones = Documentaciones::leftJoin('usuario_documentaciones','usuario_documentaciones.documentacion_id','=','documentaciones.id')
                                            ->orWhere('documentaciones.tipo','USUARIO')
                                            ->orWhere('documentaciones.tipo','OT')
                                            ->orWhere('documentaciones.tipo','INSTITUCIONAL')
                                            ->orWhere('documentaciones.tipo','PROCEDIMIENTO GENERAL') 
                                            ->orWhere('documentaciones.tipo','EQUIPO')
                                            ->orWhere('documentaciones.tipo','FUENTE')
                                            ->orWhere('documentaciones.tipo','VEHICULO')
                                            ->with('metodoEnsayo')   
                                            ->with('usuario')
                                            ->with('internoEquipo')
                                            ->with('InternoFuente')      
                                            ->Filtro($filtro,$tipo)                      
                                            ->selectRaw('documentaciones.*')                               
                                            ->orderBy('documentaciones.tipo','ASC')    
                                            ->orderBy('documentaciones.id','DESC')                         
                                            ->paginate(10);             
        
        return $documentaciones;
    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Documentaciones";
        $header_descripcion ="Alta | Baja | Modificación";      
        return view('abm.documentaciones',compact('user','header_titulo','header_descripcion'));
        
    }

    public function DocumentacionesDeOt(){

        return Documentaciones::where('tipo','OT')->get();

    }

    public function verificarDuplicados($tipo = null,$titulo= null,$user_id = null,$interno_equipo_id= null,$interno_fuente_id = null){

        if($tipo ==  'USUARIO'){

            return documentaciones::join('usuario_documentaciones','usuario_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->where('usuario_documentaciones.user_id',$user_id) 
                                    ->get();

        }else if ($tipo == 'EQUIPO'){

            return documentaciones::join('interno_equipo_documentaciones','interno_equipo_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->where('interno_equipo_documentaciones.interno_equipo_id',$interno_equipo_id) 
                                    ->get();
        }else if($tipo == 'FUENTE'){

            return documentaciones::join('interno_fuente_documentaciones','interno_fuente_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->where('interno_fuente_documentaciones.interno_fuente_id',$interno_fuente_id) 
                                    ->get();

        }
        else{
            
            return documentaciones::where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->get();
        }

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
                                    documentaciones.fecha_caducidad as fecha_caducidad
                                    
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
        $path = public_path($document->path);
        return response()->file($path);

    }

    public function operarios($id)
    {
       
        $document = Documentaciones::where('id' , $id)
                                     ->where('tipo','USUARIO')
                                     ->firstOrFail();   

        $path = public_path($document->path);    
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
                        documentaciones.fecha_caducidad,
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
            $procedimientos = DB::table('ot_procedimientos_propios')
                                    ->join('ots','ots.id','=','ot_procedimientos_propios.ot_id')
                                    ->join('documentaciones','documentaciones.id','=','ot_procedimientos_propios.documentacion_id')      
                                    ->join('metodo_ensayos','metodo_ensayos.id','=','documentaciones.metodo_ensayo_id')   
                                    ->where('ots.id','=',$ot_id)
                                    ->where('metodo_ensayos.metodo','=',$metodo)
                                    ->select('documentaciones.*','ot_procedimientos_propios.id as ot_procedimientos_propios_id')
                                    ->get();
                               
            if(count($procedimientos) == 0){                
                
                
            $procedimientos = DB::table('documentaciones')
                                ->join('metodo_ensayos','metodo_ensayos.id','=','documentaciones.metodo_ensayo_id')                              
                                ->where('metodo_ensayos.metodo','=',$metodo)
                                ->where('documentaciones.tipo','PROCEDIMIENTO GENERAL')
                                ->select('documentaciones.*')
                                ->get();
        } 

        return $procedimientos;

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
    public function update(DocumentacionesRequest $request, $id)
    {

       return $this->documentaciones->updateDocumentacion($request,$id);
   

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

    public function DocumentacionesTotal(){

        return Documentaciones::orWhere('documentaciones.tipo','USUARIO')
                                ->orWhere('documentaciones.tipo','OT')
                                ->orWhere('documentaciones.tipo','INSTITUCIONAL')
                                ->orWhere('documentaciones.tipo','PROCEDIMIENTO GENERAL')->count(); 

    }
}
