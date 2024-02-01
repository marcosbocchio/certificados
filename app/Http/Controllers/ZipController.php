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


            Storage::disk('public')->deleteDirectory('storage/temp/'.$folderName);

          DB::commit();



        } catch (Exception $e) {

            DB::rollback();
            throw $e;

        }

        return $url;

    }

    public function generarYDescargarZip()
    {
        DB::beginTransaction();



        try {
            $documentos = DB::select('CALL getDocumentosZip');
            $zipFileName = 'general.zip';
            $zipFilePath = public_path('storage/zips/' . $zipFileName);

            if (file_exists($zipFilePath)) {
                unlink($zipFilePath);
            }

            // Crear un nuevo archivo ZIP
            $zip = new Zipper;
            $zip->make($zipFilePath);

            foreach ($documentos as $documento) {
                $tipo = $documento->tipo;
                $codigo = $documento->codigo;
                $nombreArchivo = $documento->descripcion;
                $path = public_path($documento->path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);

                // Verifica si el archivo existe antes de intentar agregarlo al ZIP
                if (file_exists($path)) {
                    // Agrega el archivo al directorio correspondiente en el ZIP
                    $zip->folder($tipo . '/' . $codigo)->add($path, $nombreArchivo . '.' . $extension);
                }

            }


            $zip->close();
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }



        // Devolver una respuesta adecuada, como la descarga del ZIP
        // return response()->download($zipFilePath, $zipFileName);
    }
     
}
