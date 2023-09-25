<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Response;
use ZipArchive; 


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
        Log::debug("Inicio de la generación del archivo ZIP: " . date("F j, Y, g:i a"));

        try {
            $documentos = DB::select('CALL getDocumentosZip');
            $zipFileName = 'general.zip';
            $zipFilePath = public_path('storage/zips/' . $zipFileName);

            // Crear un nuevo archivo ZIP
            $zip = new Zipper;
            $zip->make($zipFilePath);

            // Recorrer la lista de documentos y agregarlos al archivo ZIP
            foreach ($documentos as $documento) {
                $tipo = $documento->tipo;
                $codigo = $documento->codigo;
                $nombreArchivo = $documento->nombre_archivo;
                $path = public_path($documento->path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);

                try {
                    // Agregar el archivo al directorio correspondiente en el ZIP
                    $zip->folder($tipo . '/' . $codigo)->add($path, $nombreArchivo . '.' . $extension);
                } catch (\Exception $ex) {
                    // En caso de error al agregar el archivo, ignorar y continuar
                    Log::error("Error al agregar archivo al ZIP: " . $ex->getMessage());
                }
            }

            // Cerrar el archivo ZIP después de agregar todos los archivos
            $zip->close();

            DB::commit();
            Log::debug("Archivo ZIP creado correctamente a las: " . date("F j, Y, g:i a"));
        } catch (Exception $e) {
            // En caso de error, realizar un rollback en la base de datos
            DB::rollback();
            Log::error("Error durante la generación del archivo ZIP: " . $e);
            throw $e;
        }

        // Devolver una respuesta adecuada, como la descarga del ZIP
        return response()->download($zipFilePath, $zipFileName);
    }

    public function descargarZip()
    {
        $zipFileName = 'general.zip';
        $zipFilePath = 'storage/zips/'.$zipFileName;
        if (file_exists($zipFilePath)) {
            return response()->download($zipFilePath, $zipFileName);
        } else {
            return response()->json(['message' => 'El archivo ZIP no existe'], 404);
        }
    }
     
}
