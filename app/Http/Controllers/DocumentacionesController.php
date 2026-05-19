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
use App\MetodoEnsayos;
use App\InternoEquipos;
use App\InternoFuentes;
use App\Vehiculos;
use App\TiposDocumentosUsuarios;


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
    $manifestItems = [];

    $prodFilesUrl = rtrim(env('PROD_FILES_URL', ''), '/');

    foreach ($request->registros as $registro) {
        $filePath = public_path($registro['path']);
        $extension = pathinfo($registro['path'], PATHINFO_EXTENSION);
        $zipFolderPath = $this->getZipFolderPath($registro);
        $fileNameInZip = $registro['titulo'] . '.' . $extension;
        $filePathInZip = $zipFolderPath . '/' . $fileNameInZip;

        if (file_exists($filePath)) {
            $zip->addFile($filePath, $filePathInZip);
            $filesAdded = true;
        } elseif (env('PROD_PUBLIC_URL')) {
            $url = rtrim(env('PROD_PUBLIC_URL'), '/') . '/' . ltrim($registro['path'], '/');
            $result = $this->fetchViaHttps($url);
            if ($result !== false && strlen($result['content']) > 0) {
                // Si el path no tiene extensión, inferirla del Content-Type
                if (!$extension) {
                    $extension = $this->extensionFromContentType($result['content_type']) ?? 'bin';
                    $fileNameInZip = $registro['titulo'] . '.' . $extension;
                    $filePathInZip = $zipFolderPath . '/' . $fileNameInZip;
                }
                $zip->addFromString($filePathInZip, $result['content']);
                $filesAdded = true;
            } else {
                Log::warning("HTTPS: no se pudo obtener {$url}");
                continue;
            }
        } else {
            Log::warning("Archivo no encontrado y sin PROD_PUBLIC_URL configurado: {$filePath}");
            continue;
        }

        // Construir entrada del manifest
        $manifestItems[] = [
            'tipo'                        => $registro['tipo'],
            'titulo'                      => $registro['titulo'],
            'descripcion'                 => $registro['descripcion'] ?? null,
            'visible_sn'                  => $registro['visible_sn'] ?? true,
            'fecha_caducidad'             => $registro['fecha_caducidad'] ?? null,
            'file_path_in_zip'            => $filePathInZip,
            'metodo_ensayo'               => isset($registro['metodo_ensayo']['metodo']) && $registro['metodo_ensayo']['metodo']
                                                ? ['metodo' => $registro['metodo_ensayo']['metodo']] : null,
            'usuario'                     => isset($registro['usuario'][0]['email'])
                                                ? ['email' => $registro['usuario'][0]['email']] : null,
            'tipo_documento_usuario'      => isset($registro['tipo_documento_usuario'][0]['codigo'])
                                                ? ['codigo' => $registro['tipo_documento_usuario'][0]['codigo']] : null,
            'interno_equipo'              => isset($registro['interno_equipo'][0]['nro_interno'])
                                                ? ['nro_interno' => $registro['interno_equipo'][0]['nro_interno']] : null,
            'certificado_verificacion_sn' => $registro['interno_equipo'][0]['pivot']['certificado_verificacion_sn'] ?? false,
            'user_dosimetro'              => isset($registro['user_interno_equipo'][0]['email'])
                                                ? ['email' => $registro['user_interno_equipo'][0]['email']] : null,
            'interno_fuente'              => isset($registro['interno_fuente'][0]['nro_serie'])
                                                ? ['nro_serie' => $registro['interno_fuente'][0]['nro_serie']] : null,
            'vehiculo'                    => isset($registro['vehiculo'][0]['nro_interno'])
                                                ? ['nro_interno' => $registro['vehiculo'][0]['nro_interno']] : null,
        ];
    }

    if (!$filesAdded) {
        $zip->close();
        return response()->json(['message' => 'No se agregaron archivos al ZIP'], 400);
    }

    // Agregar manifest.json al ZIP
    $manifest = json_encode([
        'exported_at'     => now()->toIso8601String(),
        'version'         => '1',
        'documentaciones' => $manifestItems,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $zip->addFromString('manifest.json', $manifest);

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

public function importarZipDoc(Request $request)
{
    $request->validate(['zip' => 'required|file']);

    $zip = new ZipArchive();
    $tmpDir = storage_path('app/import_tmp/' . Str::uuid());
    mkdir($tmpDir, 0777, true);

    if ($zip->open($request->file('zip')->getRealPath()) !== true) {
        $this->limpiarDirectorio($tmpDir);
        return response()->json(['message' => 'No se pudo abrir el ZIP'], 400);
    }
    $zip->extractTo($tmpDir);
    $zip->close();

    $manifestPath = $tmpDir . '/manifest.json';
    if (!file_exists($manifestPath)) {
        $this->limpiarDirectorio($tmpDir);
        return response()->json(['message' => 'El ZIP no contiene manifest.json'], 400);
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);
    $created = 0;
    $updated = 0;
    $errors = [];

    foreach ($manifest['documentaciones'] as $item) {
        try {
            // Resolver metodo_ensayo
            $metodoEnsayoId = null;
            if (!empty($item['metodo_ensayo']['metodo'])) {
                $metodo = MetodoEnsayos::where('metodo', $item['metodo_ensayo']['metodo'])->first();
                if (!$metodo) {
                    $errors[] = "{$item['titulo']}: metodo_ensayo '{$item['metodo_ensayo']['metodo']}' no encontrado";
                    continue;
                }
                $metodoEnsayoId = $metodo->id;
            }

            // Resolver relaciones por tipo
            $userId = null;
            $tipoDocUsuarioId = null;
            if ($item['tipo'] === 'USUARIO') {
                if (empty($item['usuario']['email'])) {
                    $errors[] = "{$item['titulo']}: sin email de usuario en manifest";
                    continue;
                }
                $user = \App\User::where('email', $item['usuario']['email'])->first();
                if (!$user) {
                    $errors[] = "{$item['titulo']}: usuario '{$item['usuario']['email']}' no encontrado";
                    continue;
                }
                $userId = $user->id;
                if (!empty($item['tipo_documento_usuario']['codigo'])) {
                    $tipoDoc = TiposDocumentosUsuarios::where('codigo', $item['tipo_documento_usuario']['codigo'])->first();
                    $tipoDocUsuarioId = $tipoDoc ? $tipoDoc->id : null;
                }
            }

            $internoEquipoId = null;
            $userDosimetroId = null;
            if ($item['tipo'] === 'EQUIPO') {
                if (empty($item['interno_equipo']['nro_interno'])) {
                    $errors[] = "{$item['titulo']}: sin nro_interno de equipo";
                    continue;
                }
                $equipo = InternoEquipos::where('nro_interno', $item['interno_equipo']['nro_interno'])->first();
                if (!$equipo) {
                    $errors[] = "{$item['titulo']}: equipo '{$item['interno_equipo']['nro_interno']}' no encontrado";
                    continue;
                }
                $internoEquipoId = $equipo->id;
                if (!empty($item['user_dosimetro']['email'])) {
                    $userDos = \App\User::where('email', $item['user_dosimetro']['email'])->first();
                    $userDosimetroId = $userDos ? $userDos->id : null;
                }
            }

            $internoFuenteId = null;
            if ($item['tipo'] === 'FUENTE') {
                if (empty($item['interno_fuente']['nro_serie'])) {
                    $errors[] = "{$item['titulo']}: sin nro_serie de fuente";
                    continue;
                }
                $fuente = InternoFuentes::where('nro_serie', $item['interno_fuente']['nro_serie'])->first();
                if (!$fuente) {
                    $errors[] = "{$item['titulo']}: fuente '{$item['interno_fuente']['nro_serie']}' no encontrada";
                    continue;
                }
                $internoFuenteId = $fuente->id;
            }

            $vehiculoId = null;
            if ($item['tipo'] === 'VEHICULO') {
                if (empty($item['vehiculo']['nro_interno'])) {
                    $errors[] = "{$item['titulo']}: sin nro_interno de vehiculo";
                    continue;
                }
                $vehiculo = Vehiculos::where('nro_interno', $item['vehiculo']['nro_interno'])->first();
                if (!$vehiculo) {
                    $errors[] = "{$item['titulo']}: vehiculo '{$item['vehiculo']['nro_interno']}' no encontrado";
                    continue;
                }
                $vehiculoId = $vehiculo->id;
            }

            // Copiar archivo al storage
            $newPath = null;
            $fileInZip = $tmpDir . '/' . $item['file_path_in_zip'];
            if (file_exists($fileInZip)) {
                $extension = pathinfo($fileInZip, PATHINFO_EXTENSION);
                $newFilename = Str::uuid() . '_' . Str::slug($item['titulo']) . '.' . $extension;
                $destDir = storage_path('app/public/documentaciones');
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0777, true);
                }
                copy($fileInZip, $destDir . '/' . $newFilename);
                $newPath = 'storage/documentaciones/' . $newFilename;
            }

            // Buscar existente por tipo + titulo
            $doc = Documentaciones::where('tipo', $item['tipo'])->where('titulo', $item['titulo'])->first();
            $isNew = !$doc;
            if (!$doc) {
                $doc = new Documentaciones();
            }

            $doc->tipo             = $item['tipo'];
            $doc->titulo           = $item['titulo'];
            $doc->descripcion      = $item['descripcion'] ?? null;
            $doc->visible_sn       = $item['visible_sn'] ?? true;
            $doc->metodo_ensayo_id = $metodoEnsayoId;
            $doc->fecha_caducidad  = $item['fecha_caducidad'] ?? null;
            if ($newPath) {
                $doc->path = $newPath;
            }
            $doc->save();

            // Pivot records
            if ($item['tipo'] === 'USUARIO') {
                $ud = UsuarioDocumentaciones::where('documentacion_id', $doc->id)->first() ?? new UsuarioDocumentaciones();
                $ud->documentacion_id               = $doc->id;
                $ud->user_id                        = $userId;
                $ud->tipo_documentacion_usuario_id  = $tipoDocUsuarioId;
                $ud->fecha_caducidad                = $item['fecha_caducidad'] ?? null;
                $ud->save();
            }

            if ($item['tipo'] === 'EQUIPO') {
                $ed = InternoEquipoDocumentaciones::where('documentacion_id', $doc->id)->first() ?? new InternoEquipoDocumentaciones();
                $ed->documentacion_id           = $doc->id;
                $ed->interno_equipo_id          = $internoEquipoId;
                $ed->certificado_verificacion_sn = $item['certificado_verificacion_sn'] ?? false;
                $ed->interno_equipo_user_id     = $userDosimetroId;
                $ed->save();
            }

            if ($item['tipo'] === 'FUENTE') {
                $fd = InternoFuenteDocumentaciones::where('documentacion_id', $doc->id)->first() ?? new InternoFuenteDocumentaciones();
                $fd->documentacion_id    = $doc->id;
                $fd->interno_fuente_id   = $internoFuenteId;
                $fd->save();
            }

            if ($item['tipo'] === 'VEHICULO') {
                $vd = VehiculoDocumentaciones::where('documentacion_id', $doc->id)->first() ?? new VehiculoDocumentaciones();
                $vd->documentacion_id = $doc->id;
                $vd->vehiculo_id      = $vehiculoId;
                $vd->save();
            }

            $isNew ? $created++ : $updated++;

        } catch (\Exception $e) {
            Log::error('importarZipDoc error: ' . $e->getMessage());
            $errors[] = ($item['titulo'] ?? '?') . ': ' . $e->getMessage();
        }
    }

    $this->limpiarDirectorio($tmpDir);

    return response()->json(['created' => $created, 'updated' => $updated, 'errors' => $errors]);
}

private function fetchViaHttps($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $error = curl_error($ch);
    curl_close($ch);
    if ($httpCode === 200 && $content !== false) {
        return ['content' => $content, 'content_type' => $contentType];
    }
    Log::warning("fetchViaHttps: {$url} | HTTP {$httpCode} | {$error}");
    return false;
}

private function extensionFromContentType(?string $contentType): ?string
{
    if (!$contentType) return null;
    $map = [
        'application/pdf'  => 'pdf',
        'image/jpeg'       => 'jpg',
        'image/jpg'        => 'jpg',
        'image/png'        => 'png',
        'image/bmp'        => 'bmp',
        'image/gif'        => 'gif',
        'image/webp'       => 'webp',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
    ];
    $mime = strtolower(explode(';', $contentType)[0]);
    return $map[$mime] ?? null;
}

private function limpiarDirectorio($dir)
{
    if (!is_dir($dir)) return;
    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }
    rmdir($dir);
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
