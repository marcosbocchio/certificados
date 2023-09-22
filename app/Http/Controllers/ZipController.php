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
    public function generarYDescargarZip()
    {
    DB::beginTransaction();
    Log::debug("Iniciando la generación del ZIP: " . date("F j, Y, g:i a"));

    try {
        // Obtener los documentos desde la base de datos o la fuente deseada (en tu caso, desde la función 'getDocumentosZip()')
        $documentos = DB::select('CALL getDocumentosZip');

        // Nombre del archivo ZIP
        $zipFileName = 'general.zip';
        // Ruta completa del archivo ZIP en el sistema de archivos
        $zipFilePath = 'storage/zips/' . $zipFileName;

        // Crear una instancia de ZipArchive
        $zip = new ZipArchive;
        // Intentar abrir el archivo ZIP para escritura y sobre escritura (si ya existe)
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($documentos as $documento) {
                $tipo = $documento->tipo;
                $codigo = $documento->codigo;
                $nombreArchivo = $documento->nombre_archivo;
                $path = public_path($documento->path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);

                // Agregar directorios al archivo ZIP si no existen
                if (!$zip->addEmptyDir($tipo)) {
                    // Puedes agregar manejo de errores aquí si lo necesitas
                }

                if (!$zip->addEmptyDir($tipo . '/' . $codigo)) {
                    // Puedes agregar manejo de errores aquí si lo necesitas
                }

                // Obtener el nombre del archivo con la extensión
                $nombreConExtension = $nombreArchivo . '.' . $extension;

                // Agregar el archivo al archivo ZIP dentro de la estructura de carpetas
                $zip->addFile($path, $tipo . '/' . $codigo . '/' . $nombreConExtension);
            }
            
            // Cerrar el archivo ZIP
            $zip->close();
        } else {
            DB::rollback();
            return response()->json(['message' => 'No se pudo crear el archivo ZIP'], 500);
        }

        DB::commit();
    } catch (Exception $e) {
        DB::rollback();
        Log::error("Error en la generación del ZIP: " . $e->getMessage());
        throw $e;
    }

    // Devuelve una respuesta o realiza las acciones que necesites aquí
    // En lugar de generar una descarga directa, este código simplemente registra la finalización de la tarea en el registro

    Log::debug("ZIP generado y almacenado correctamente en: " . $zipFilePath);
    Log::debug("Finalizando la generación del ZIP: " . date("F j, Y, g:i a"));
    }
}
