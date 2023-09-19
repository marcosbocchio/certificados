<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Str;
use ZipArchive;
use Illuminate\Support\Facades\Response;

class generarZip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generarZip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $documentos = DB::select('CALL getDocumentosZip()');
            $tempFolderName = 'temp_' . time();
            $zipFileName = 'ZipDocumentacion.zip';
            $zipFilePath = public_path('storage/documentos-zip-general/'.$zipFileName);
    
            $zip = new ZipArchive;

            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                foreach ($documentos as $documento) {
                    $tipo = $documento->tipo;
                    $codigo = $documento->codigo;
                    $nombreArchivo = $documento->nombre_archivo;
                    $path = public_path($documento->path);
                    $extension = pathinfo($path, PATHINFO_EXTENSION);
    
                    
                    if (!$zip->addEmptyDir($tipo)) {
                        
                    }
    
                    // Crear una subcarpeta con el "codigo" bajo el "tipo"
                    if (!$zip->addEmptyDir($tipo . '/' . $codigo)) {
                        
                    }
    
                    // Obtener el nombre del archivo con la extensión
                    $nombreConExtension = $nombreArchivo . '.' . $extension;
    
                    // Agregar el archivo a la subcarpeta con el "nombre_archivo" como nombre
                    $zip->addFile($path, $tipo . '/' . $codigo . '/' . $nombreConExtension);
                }
    
                $zip->close();
            } else {
                DB::rollback();
                return response()->json(['message' => 'No se pudo crear el archivo ZIP'], 500);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        
        return Log::debug("Esto se ejecuto como tarea automatica, guardo el zip : " . date("F j, Y, g:i a"));;
        //return Response::download($zipFilePath, $zipFileName);
        //return Storage::put('ruta_en_el_servidor/'.$zipFileName, file_get_contents($zipFilePath));

    }
}
