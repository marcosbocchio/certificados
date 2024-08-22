<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frentes;
use App\Remitos;
use App\DetalleRemitos;
use App\Productos;
use App\Ots; // Asegúrate de que esta es la clase correcta para Ots
use App\Partes; // Asegúrate de que esta es la clase correcta para Partes
use App\ParteDetalles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

    class PlacasUsadasController extends Controller
    {
        public function callView()
        {
            $user = auth()->user();
            $header_titulo = "Reportes";
            $header_descripcion = "placas usadas";
            return view('reporte-placas.placa', compact('user', 'header_titulo', 'header_descripcion'));
        }

        // Función para obtener todos los frentes
        public function getFrentePlacas()
        {
            $frentes = Frentes::all();
            return response()->json($frentes);
        }
        
        // Función para obtener los remitos relacionados con un frente específico
        public function getRemitosPlacas(Request $request)
        {
            $request->validate([
                'frente_id' => 'required|exists:frentes,id',
                'fecha_desde' => 'required|date',
                'fecha_hasta' => 'required|date',
            ]);
    
            
                $remitos = Remitos::where('frente_destino_id', $request->frente_id)
                    ->whereBetween('fecha', [$request->fecha_desde, $request->fecha_hasta])
                    ->get();
    
                return response()->json($remitos);
        }

        public function getRemitosPlacasProductos(Request $request)
        {
            $idsRemitos = $request->input('ids_remitos');
        
            $productos = DetalleRemitos::whereIn('remito_id', $idsRemitos)
                ->join('productos', 'detalle_remitos.producto_id', '=', 'productos.id')
                ->where('productos.relacionado_a_placas_sn', 1)
                ->select(
                    'detalle_remitos.producto_id',
                    'productos.descripcion',
                    'productos.metros', 
                    DB::raw('SUM(detalle_remitos.cantidad) as cantidad')
                )
                ->groupBy('detalle_remitos.producto_id', 'productos.descripcion', 'productos.metros') 
                ->get();
        
            // Mapeo de productos para el formato de respuesta
            $productosFormatted = $productos->map(function ($detalle) {
                return [
                    'producto_id' => $detalle->producto_id,
                    'cantidad' => $detalle->cantidad,
                    'descripcion' => $detalle->descripcion,
                    'metros' => $detalle->metros 
                ];
            });
        
            return response()->json($productosFormatted);
        }

        // Nueva función para obtener Ots
        public function getOtsParte()
        {
            $ots = Ots::all(['id', 'numero', 'proyecto']);
            return response()->json($ots);
        }
        // Nueva función para obtener partes por OTs y fechas
        public function getPartesPlacas(Request $request)
        {
            $selectedOtsIds = $request->ots_ids;
            $fechaOtDesde = $request->fecha_ot_desde;
            $fechaOtHasta = $request->fecha_ot_hasta;

            $partes = Partes::whereIn('ot_id', $selectedOtsIds)
                ->whereBetween('fecha', [$fechaOtDesde, $fechaOtHasta])
                ->select('id', 'placas_repetidas', 'placas_testigos')
                ->get();

            return response()->json($partes);
        }
        public function getDetallePlaca(Request $request)
        {
            log::info($request->input('ids_partes'));
            $partesIds = $request->input('ids_partes');
            // Obtener los detalles agrupados
            $detallesAgrupados = ParteDetalles::whereIn('parte_id', $partesIds)
                ->whereNotNull('placas_final') // Filtrar solo donde placas_final no es null
                ->get()
                ->groupBy('cm_final') // Agrupar por cm_final
                ->map(function ($items, $cmFinal) {
                    return [
                        'cm_agrupacion' => $cmFinal,
                        'placas_total' => $items->sum('placas_final'), // Sumar placas_final
                    ];
                })
                ->values();

            return response()->json($detallesAgrupados);
        }
    }