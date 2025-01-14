<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Documentaciones;

class LimpiadorController extends Controller
{
    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "GESTIONAR ARCHIVOS";
        $header_descripcion = " ";    
        // Pasar los datos a la vista
        return view('limpiador.limpiador', compact('user', 'header_titulo', 'header_descripcion'));
    }
    

    // Obtener solo los paths de la base de datos
public function getDocumentacionesPaths()
{
    $documentaciones = Documentaciones::pluck('path')->map(function ($path) {
        // Extraer la parte después de "documentaciones/"
        return str_replace('storage/documentaciones/', '', $path);
    });

    return response()->json([
        'documentaciones' => $documentaciones, // Solo los paths
        'total_registros' => $documentaciones->count(),
    ]);
}

// Obtener los archivos en storage
public function getArchivosEnStorage()
{
    // Busca los archivos en la carpeta public/storage/documentaciones
    $path = public_path('storage/documentaciones'); // Obtiene la ruta completa
    $archivosEnStorage = [];

    if (file_exists($path)) {
        $archivosEnStorage = collect(scandir($path))
            ->filter(function ($file) use ($path) {
                return is_file($path . DIRECTORY_SEPARATOR . $file); // Filtra solo archivos
            })
            ->values()
            ->all(); // Convierte a un array limpio
    }

    return response()->json([
        'archivosEnStorage' => $archivosEnStorage,
        'total_archivos_storage' => count($archivosEnStorage),
    ]);
}


// Comparar archivos de la base de datos con los del almacenamiento
public function compararArchivos()
{
    $documentaciones = Documentaciones::pluck('path')->map(function ($path) {
        return str_replace('storage/documentaciones/', '', $path);
    });

    $archivosEnStorage = collect(Storage::files('documentaciones'))->map(function ($file) {
        return basename($file); 
    });

    $encontrados = $documentaciones->intersect($archivosEnStorage);
    $sobrantes = $archivosEnStorage->diff($documentaciones);

    return response()->json([
        'encontrados' => $encontrados,
        'sobrantes' => $sobrantes,
        'total_encontrados' => $encontrados->count(),
        'total_sobrantes' => $sobrantes->count(),
    ]);
}


}
