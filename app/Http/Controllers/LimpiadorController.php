<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LimpiadorController extends Controller
{
    public function getDocumentaciones()
    {
        // Obtener todos los registros en la base de datos
        $documentaciones = Documentaciones::pluck('path')->map(function ($path) {
            // Extraer la parte después de "documentaciones/"
            return str_replace('storage/documentaciones/', '', $path);
        });
    
        // Buscar archivos existentes en el almacenamiento
        $archivosEnStorage = collect(Storage::files('documentaciones'))->map(function ($file) {
            return basename($file);
        });
    
        // Identificar archivos existentes y sobrantes
        $encontrados = $documentaciones->intersect($archivosEnStorage);
        $sobrantes = $archivosEnStorage->diff($documentaciones);
    
        return response()->json([
            'encontrados' => $encontrados,
            'sobrantes' => $sobrantes,
            'total_registros' => $documentaciones->count(),
            'total_encontrados' => $encontrados->count(),
            'total_sobrantes' => $sobrantes->count(),
        ]);
    }
    
    public function borrarDocumentaciones(Request $request)
    {
        $paths = $request->input('paths', []);
    
        foreach ($paths as $path) {
            Storage::delete("documentaciones/{$path}");
        }
    
        return response()->json(['status' => 'success', 'message' => 'Archivos borrados correctamente.']);
    }
}
