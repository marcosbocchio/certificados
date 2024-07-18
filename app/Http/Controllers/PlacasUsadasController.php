<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ots;
use App\Parte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlacasUsadasController extends Controller
{
    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="Certificados";
        return view('reporte-placas.placa', compact('user', 'header_titulo', 'header_descripcion'));
    }

    public function getOTs()
    {
        $ots = DB::table('ots')
                ->select('id', 'numero', 'proyecto')
                ->orderBy('numero') // Ordenar por el campo 'id'
                ->get();
    
        return response()->json($ots);
    }

    // Obtener partes por ID de OT
    public function getPartes($otId)
    {
        $partes = DB::table('partes')->where('ot_id', $otId)->select('id', 'created_at')->get();
        return response()->json($partes);
    }

    // Obtener informes y procesar datos
    public function getInformesRI($parte_id, $fecha_desde, $fecha_hasta)
    {
        Log::info('Solicitud para obtener informes recibida:', [
            'parte_id' => $parte_id,
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta,
        ]);
    
        // Convertir fechas al formato esperado si es necesario
        $fechaDesde = date('Y-m-d', strtotime($fecha_desde));
        $fechaHasta = date('Y-m-d', strtotime($fecha_hasta));
    
        // Obtener datos del parte
        $parte = DB::table('partes')
                    ->select('id', 'placas_repetidas', 'placas_testigos', 'created_at')
                    ->where('id', $parte_id)
                    ->first();
    
        // Verificar si se encontró el parte
        if (!$parte) {
            return response()->json(['error' => 'Parte no encontrado'], 404);
        }
    
        // Llamar al procedimiento almacenado una sola vez
        $informes = DB::select('CALL GetInformesRI(?, ?, ?)', [$parte_id, $fechaDesde, $fechaHasta]);
    
        // Retornar los informes y los datos del parte
        return response()->json([
            'parte' => [
                'id' => $parte->id,
                'placas_repetidas' => $parte->placas_repetidas,
                'placas_testigos' => $parte->placas_testigos,
                'created_at' => $parte->created_at,
            ],
            'informes' => $informes,
        ]);
    }
}