<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Response;

class ZipController extends Controller
{
    public function generarLink(Request $request) {

        DB::beginTransaction();
        try {

            $documentos = $request->documentos;
            Log::debug("documentos: ". json_encode($documentos));

            /* Creo el directorio raiz donde voy a poner los archivos temporales */
            $folderName =  rand(1,99999);
            Storage::makeDirectory(public_path('storage/temp/'.$folderName));

            foreach ($documentos as $documento) {

                $exists = Storage::disk('public')->exists($documento['path']);
                if ($exists) {

                    $infoPath = pathinfo(public_path($documento['path']));
                    $extension = $infoPath['extension'];
                    $copiado = Storage::disk('public')->exists('storage/temp/' . $folderName . '/' . $documento['tipo'] . '/' . $documento['codigo'] . '/' . $documento['titulo'] . '.' . $extension);
                    if (!$copiado) {
                        Storage::disk('public')->copy($documento['path'], 'storage/temp/' . $folderName . '/' . $documento['tipo'] . '/' . $documento['codigo'] . '/' . $documento['titulo'] . '.' . $extension);
                    }

                }

            }

            $FileZipName = 'doc' . rand(1,9999999);
            $dir = 'storage/zips/' . $FileZipName . '.zip';
            $url = url('/') . '/'. $dir;
            $zip = new \Chumper\Zipper\Zipper;
            $files = glob('storage/temp/'.$folderName);
            $zip = $zip->make(public_path($dir));
            $zip->add($files)->close();

            Log::debug("file temp: ".public_path('storage/temp/'.$folderName));
            Storage::disk('public')->deleteDirectory('storage/temp/'.$folderName);

          DB::commit();



        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }
        Log::debug("url: ". $url);
        return $url;

    }
    public function generarYDescargarZip(){
        DB::beginTransaction();

        try {
            $documentos = DB::select('CALL getDocumentosZip()');
            $tempFolderName = 'temp_' . time();
            $zipFileName = 'ZipDocumentacion.zip';
            $zipFilePath = Storage::makeDirectory(public_path('storage/documentos-zip-general/'.$zipFileName));
    
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
        
        //return Log::debug("Esto se ejecuto como tarea automatica, guardo el zip : " . date("F j, Y, g:i a"));;
        return Response::download($zipFilePath, $zipFileName);
        //return Storage::put('ruta_en_el_servidor/'.$zipFileName, file_get_contents($zipFilePath));    

    }
    public function descargarZip()
    {
        $zipFileName = 'ZipDocumentacion.zip';
        $zipFilePath = storage_path('app/public/documentos-zip-general/' . $zipFileName);

        if (file_exists($zipFilePath)) {
            return response()->download($zipFilePath, $zipFileName);
        } else {
            return response()->json(['message' => 'El archivo ZIP no existe'], 404);
        }
    }

}
