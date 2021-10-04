<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
                    Storage::disk('public')->copy($documento['path'], 'storage/temp/' . $folderName . '/' . $documento['tipo'] . '/' . $documento['codigo'] . '/' . $documento['titulo'] . '.' . $extension);

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

}
