<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Illuminate\Support\Facades\Log;

class ZipController extends Controller
{
    public function generarLink(Request $request) {

        $documentos = $request->documentos;

        /* Creo el directorio raiz donde voy a poner los archivos temporales */
        $folderName =  rand(1,99999);

        foreach ($documentos as $documento) {

            $infoPath = pathinfo(public_path($documento['path']));
            $extension = $infoPath['extension'];
            Storage::disk('public')->copy($documento['path'], 'storage/temp/' . $folderName . '/' . $documento['tipo'] . '/' . $documento['codigo'] . '/' . $documento['titulo'] . '.' . $extension);

        }

        $FileZipName = 'doc' . rand(1,99999);
        $dir = 'storage/zips/' . $FileZipName . '.zip';
        $url = url('/') . '/'. $dir;
        $zip = new \Chumper\Zipper\Zipper;
        $files = glob('storage/temp/'.$folderName);
        $zip = $zip->make(public_path($dir));
        $zip->add($files)->close();

        Log::debug("url: " . $url);

        return $url;

    }

    public function getValueUniqueArray($documentos,$var){

        $array_temp = [];

        foreach ($documentos as $documento) {

            $array_temp[] = $documento[$var];

        }

        return array_unique($array_temp);

    }


}
