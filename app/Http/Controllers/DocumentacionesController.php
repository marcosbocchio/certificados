<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentacionesRequest;
use App\Repositories\Documentaciones\DocumentacionesRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Documentaciones;
use App\Notificaciones;
use App\UsuarioDocumentaciones;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use App\VehiculoDocumentaciones;
use App\Ots;
use App\Users;
use App\InternoEquipoDocumentaciones;
use App\InternoFuenteDocumentaciones;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use ZipArchive;


class DocumentacionesController extends Controller
{

    Protected $documentaciones;

    public function __construct(DocumentacionesRepository $documentacionesRepository)
    {

        $this->middleware(['role_or_permission:Sistemas|M_documentaciones'],['only' => ['callView']]);
        $this->middleware(['role_or_permission:Sistemas|T_exportar_documentacion'],['only' => ['callViewDocOt']]);
        $this->documentaciones = $documentacionesRepository;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::debug("es aqui");
        $filtro = $request->search == 'null' ? '' : $request->search;;
        $tipo = $request->tipo == 'null' ? '' : $request->tipo;
        $vencido_sn =  $request->vencido_sn == 'true' ? true : false;

        DB::enableQueryLog();

        $query = Documentaciones::leftJoin('usuario_documentaciones','usuario_documentaciones.documentacion_id','=','documentaciones.id')
                                            ->orWhere('documentaciones.tipo','USUARIO')
                                            ->orWhere('documentaciones.tipo','OT')
                                            ->orWhere('documentaciones.tipo','INSTITUCIONAL')
                                            ->orWhere('documentaciones.tipo','PROCEDIMIENTO GENERAL')
                                            ->orWhere('documentaciones.tipo','EQUIPO')
                                            ->orWhere('documentaciones.tipo','FUENTE')
                                            ->orWhere('documentaciones.tipo','VEHICULO')
                                            ->with('metodoEnsayo')
                                            ->with('usuario')
                                            ->with('TipoDocumentoUsuario')
                                            ->with('internoEquipo.equipo.tipoEquipamiento')
                                            ->with('internoEquipo.equipo.metodoEnsayos')
                                            ->with('internoFuente')
                                            ->with('vehiculo')
                                            ->with('userInternoEquipo')
                                            ->Filtro($filtro,$tipo)
                                            ->vencido($vencido_sn)
                                            ->selectRaw('documentaciones.*')
                                            ->orderBy('documentaciones.tipo','ASC')
                                            ->orderBy('documentaciones.id','DESC');
         $user = Auth::user();
         Log::debug(Auth::user()->can('ver_no_visibles'));

         if (!$user->can('ver_no_visible')) {
            Log::debug("no debería tener el permiso");
            // Si el usuario no tiene el permiso "ver_no_visibles", filtra por visible_sn igual a 1.
            $query->where('visible_sn', 1);
            $query->WhereRaw("date(documentaciones.fecha_caducidad) > curdate()");
        }
         $documentaciones = $query->paginate(10);

        // $documentacion = Collection::make($documentacion);
       $queries = DB::getQueryLog();
       foreach($queries as $i=>$query)
       {
           Log::debug("Query $i: " . json_encode($query));
       }

        return $documentaciones;
    }
    
    public function generarZipDoc(Request $request)
{
    $request->validate([
        'registros' => 'required|array',
        'registros.*.tipo' => 'required|string',
        'registros.*.path' => 'required|string',
        'registros.*.titulo' => 'required|string',
    ]);

    $zip = new ZipArchive();
    $timestamp = now()->format('Ymd_His');
    $zipFileName = 'archivos_' . $timestamp . '.zip';
    $zipFilePath = public_path('documentos-zip-abm/' . $zipFileName);

    if (!is_dir(public_path('documentos-zip-abm'))) {
        mkdir(public_path('documentos-zip-abm'), 0777, true);
    }

    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        return response()->json(['message' => 'No se pudo crear el archivo ZIP'], 500);
    }

    $filesAdded = false;

    foreach ($request->registros as $registro) {
        $filePath = public_path($registro['path']);
        if (!file_exists($filePath)) {
            \Log::warning("El archivo {$filePath} no existe y no fue agregado al ZIP.");
            continue;
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $zipFolderPath = $this->getZipFolderPath($registro);
        $fileNameInZip = $registro['titulo'] . '.' . $extension;

        // Agregar el archivo al ZIP
        $zip->addFile($filePath, $zipFolderPath . '/' . $fileNameInZip);
        $filesAdded = true;
    }

    if (!$filesAdded) {
        $zip->close();
        return response()->json(['message' => 'No se agregaron archivos al ZIP'], 400);
    }

    $zip->close();

    return response()->download($zipFilePath)->deleteFileAfterSend(true);
}

private function getZipFolderPath($registro)
{
    Log::info('_________________________________________________');
    Log::debug($registro);
    Log::info('_________________________________________________');

    switch ($registro['tipo']) {
        case 'INSTITUCIONAL':
        case 'OT':
            return $registro['tipo'];

        case 'PROCEDIMIENTO GENERAL':
            return isset($registro['metodo_ensayo']['metodo']) 
                ? $registro['tipo'] . '/' . $registro['metodo_ensayo']['metodo'] 
                : $registro['tipo'];

        case 'USUARIO':
            return isset($registro['usuario'][0]['name']) 
                ? $registro['tipo'] . '/' . $registro['usuario'][0]['name'] 
                : $registro['tipo'];

        case 'EQUIPO':
            return isset($registro['interno_equipo'][0]['nro_interno']) 
                ? $registro['tipo'] . '/' . $registro['interno_equipo'][0]['nro_interno'] 
                : $registro['tipo'];

        case 'FUENTE':
            return isset($registro['interno_fuente'][0]['nro_serie']) 
                ? $registro['tipo'] . '/' . $registro['interno_fuente'][0]['nro_serie'] 
                : $registro['tipo'];

        case 'VEHICULO':
            return isset($registro['vehiculo'][0]['nro_interno']) 
                ? $registro['tipo'] . '/' . $registro['vehiculo'][0]['nro_interno'] 
                : $registro['tipo'];

        default:
            return $registro['tipo'];
    }
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

    public function verificarDuplicados($tipo = null,$titulo= null,$user_id = null,$interno_equipo_id= null,$interno_fuente_id = null,$vehiculo_id = null){

        if($tipo ==  'USUARIO'){

            return documentaciones::join('usuario_documentaciones','usuario_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->where('usuario_documentaciones.user_id',$user_id)
                                    ->get();

        }elseif ($tipo == 'EQUIPO'){

            return documentaciones::join('interno_equipo_documentaciones','interno_equipo_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->where('interno_equipo_documentaciones.interno_equipo_id',$interno_equipo_id)
                                    ->get();

        }elseif($tipo == 'FUENTE'){

            return documentaciones::join('interno_fuente_documentaciones','interno_fuente_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->where('interno_fuente_documentaciones.interno_fuente_id',$interno_fuente_id)
                                    ->get();

        }elseif ($tipo == 'VEHICULO'){

            return documentaciones::join('vehiculo_documentaciones','vehiculo_documentaciones.documentacion_id','=','documentaciones.id')
                                    ->where('documentaciones.tipo',$tipo)
                                    ->where('documentaciones.titulo',$titulo)
                                    ->where('vehiculo_documentaciones.vehiculo_id',$vehiculo_id)
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
        Log::debug($request);
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
        $document = Documentaciones::where('id', $id)
                                   ->whereIn('tipo', ['USUARIO', 'EQUIPO'])  // Permite 'USUARIO' y 'EQUIPO'
                                   ->firstOrFail();
    
        $path = public_path($document->path);
        return response()->file($path);
    }

    public function getDocOtOperarios($ot_id,$user_id){

        DB::enableQueryLog();

        $documentacion = Documentaciones::selectRaw('documentaciones.id,
                                                     documentaciones.tipo,
                                                     documentaciones.descripcion,
                                                     documentaciones.titulo as titulo,
                                                     documentaciones.path,
                                                     usuario_documentaciones.user_id,
                                                     documentaciones.metodo_ensayo_id,
                                                     documentaciones.fecha_caducidad,
                                                     users.name')
                                        ->join('usuario_documentaciones','usuario_documentaciones.documentacion_id','=','documentaciones.id')
                                        ->join('users','users.id','=','usuario_documentaciones.user_id')
                                        ->join('ot_operarios','ot_operarios.user_id','=','users.id')
                                        ->whereRaw('(documentaciones.metodo_ensayo_id is null or documentaciones.metodo_ensayo_id in (Select servicios.metodo_ensayo_id from servicios
                                                    inner join ot_servicios on
                                                    ot_servicios.servicio_id = servicios.id
                                                    where
                                                    ot_servicios.ot_id = ot_operarios.ot_id )) and
                                                    ot_operarios.ot_id = ? and
                                                    ot_operarios.user_id= ?',array($ot_id,$user_id))
                                        ->where('visible_sn', 1)
                                        ->WhereRaw("date(documentaciones.fecha_caducidad) > curdate()")
                                        ->get();

       // $documentacion = Collection::make($documentacion);
       $queries = DB::getQueryLog();
       foreach($queries as $i=>$query)
       {
           Log::debug("Query $i: " . json_encode($query));
       }
        return $documentacion;

    }

    public function getDocOtEquipo($user_id) {

        DB::enableQueryLog();
    
        // Selecciona solo los documentos asociados con equipos a través de interno_equipo_documentaciones
        $documentacion = Documentaciones::selectRaw('documentaciones.id,
                                                     documentaciones.tipo,
                                                     documentaciones.descripcion,
                                                     documentaciones.titulo as titulo,
                                                     documentaciones.path,
                                                     documentaciones.metodo_ensayo_id,
                                                     documentaciones.fecha_caducidad,
                                                     users.name')
                                        ->join('interno_equipo_documentaciones', 'interno_equipo_documentaciones.documentacion_id', '=', 'documentaciones.id')
                                        ->join('users', 'users.id', '=', 'interno_equipo_documentaciones.interno_equipo_user_id')
                                        ->where('interno_equipo_documentaciones.interno_equipo_user_id', $user_id)
                                        ->where('documentaciones.visible_sn', 1)
                                        ->whereRaw("date(documentaciones.fecha_caducidad) > curdate()")
                                        ->get();
        $queries = DB::getQueryLog();
        log::info($documentacion);
        foreach($queries as $i => $query) {
            Log::debug("Query $i: " . json_encode($query));
        }
        return $documentacion;
    }


    public function getDocVehiculo($vehiculo_id){

        /*
        $documentacion = DB::select('select
                                        documentaciones.id,
                                        documentaciones.tipo,
                                        documentaciones.descripcion,
                                        documentaciones.titulo as titulo,
                                        documentaciones.path,
                                        vehiculo_documentaciones.vehiculo_id,
                                        documentaciones.metodo_ensayo_id,
                                        documentaciones.fecha_caducidad

                                        from vehiculo_documentaciones
                                        inner join documentaciones on documentaciones.id = vehiculo_documentaciones.documentacion_id
                                        inner join vehiculos on vehiculos.id = vehiculo_documentaciones.vehiculo_id
                                        where
                                        vehiculos.id=:vehiculo_id',['vehiculo_id' => $vehiculo_id]);
        */

        $documentacion = Documentaciones::selectRaw('documentaciones.id,
                                                    documentaciones.tipo,
                                                    documentaciones.descripcion,
                                                    documentaciones.titulo as titulo,
                                                    documentaciones.path,
                                                    vehiculo_documentaciones.vehiculo_id,
                                                    documentaciones.metodo_ensayo_id,
                                                    documentaciones.fecha_caducidad')
                                                  ->join('vehiculo_documentaciones','documentaciones.id','=','vehiculo_documentaciones.documentacion_id')
                                                  ->join('vehiculos','vehiculos.id','=','vehiculo_documentaciones.vehiculo_id')
                                                  ->where('vehiculos.id',$vehiculo_id)
                                                  ->get();

       // $documentacion = Collection::make($documentacion);

        return $documentacion;

    }

    public function getDocInternoEquipo($interno_equipo_id){

        $documentacion = Documentaciones::join('interno_equipo_documentaciones','interno_equipo_documentaciones.documentacion_id','=','documentaciones.id')
                                          ->where('interno_equipo_documentaciones.interno_equipo_id',$interno_equipo_id)
                                          ->select('documentaciones.*')
                                          ->get();


        return $documentacion;

    }

    public function getDocPorInternoOt($ot_id,$interno_equipo_id){

       return DB::select('CALL getDocFuentePorInternoOt(?,?)',array($ot_id,$interno_equipo_id));

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
        DB::beginTransaction();
        try {
            $usuario_documento = new UsuarioDocumentaciones;
            $usuario_documento->where('documentacion_id',$id)->delete();

            $equipo_documento = new InternoEquipoDocumentaciones;
            $equipo_documento->where('documentacion_id',$id)->delete();

            $fuente_documento = new InternoFuenteDocumentaciones;
            $fuente_documento->where('documentacion_id',$id)->delete();

            $vehiculo_documento = new VehiculoDocumentaciones;
            $vehiculo_documento->where('documentacion_id',$id)->delete();

            Notificaciones::where('documentacion_id',$id)->forceDelete();

            $documento->delete();
            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }
    }

    public function DocumentacionesTotal(){

        return Documentaciones::orWhere('documentaciones.tipo','USUARIO')
                                ->orWhere('documentaciones.tipo','OT')
                                ->orWhere('documentaciones.tipo','INSTITUCIONAL')
                                ->orWhere('documentaciones.tipo','EQUIPO')
                                ->orWhere('documentaciones.tipo','FUENTE')
                                ->orWhere('documentaciones.tipo','VEHICULO')
                                ->orWhere('documentaciones.tipo','PROCEDIMIENTO GENERAL')->count();

    }

    public function callViewDocOt($ot_id) {

        $user = auth()->user();
        $ot = Ots::where('id',$ot_id)->with('cliente')->first();
        $header_sub_titulo =' / ' .$ot->cliente->nombre_fantasia . ' / OT N°: ' . $ot->numero;
        $header_titulo = "Documentaciones";
        $header_descripcion ="";
        return view('documentacion.exportar',compact('user','header_titulo','header_descripcion','header_sub_titulo','ot'));

    }

    public function getDocumentosOt($ot_id) {

       return DB::select('CALL getDocumentosOt(?)',array($ot_id));

    }


}
