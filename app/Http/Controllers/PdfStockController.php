<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Productos;
use App\Productos_grupo;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PdfStockController extends Controller
{
    public function imprimir(Request $request, $productoId)
    {
        Log::info('Fecha inicio recibida para el PDF:', [$request->query('fechaInicio')]);
        $fechaInicio = $request->query('fechaInicio', Carbon::now()->subDays(30)->toDateString());
        $fechaInicioFormato = Carbon::parse($fechaInicio)->format('d-m-Y');

        $stocks = Stock::with('user') // Cargar la relación con User
                ->where('producto_id', $productoId)
                ->whereDate('fecha', '>=', $fechaInicio)
                ->orderBy('fecha', 'desc')
                ->get();

        $productos = Productos::where('id', $productoId)->first();
        $fecha = date('d-m-Y'); // Esta podría ser la fecha actual o podrías querer usar la fechaInicio para algo en el PDF

        $pdf = PDF::loadView('stock.pdfstock', compact('stocks', 'productos', 'fecha', 'fechaInicioFormato'))
                ->setPaper('a4', 'landscape')
                ->setWarnings(false);

        return $pdf->stream();
    }

    public function imprimirTodoStock(Request $request)
    {
        $searchTerm = $request->search;
        $filtroPlacas = (bool) $request->input('placas');
        $filtroPlacas_sn = (bool) $request->input('placas_sn');

        // 1. Construimos la consulta base
        $query = Productos::query();

        // === MODIFICACIÓN AÑADIDA ===
        // Se agrega el filtro OBLIGATORIO para que solo traiga productos stockeables.
        $query->where('stockeable_sn', 1);

        // El resto de los filtros se aplican sobre el resultado anterior
        if ($filtroPlacas) {
            $query->where('relacionado_a_placas_sn', 1);
        }
        if ($filtroPlacas_sn) {
            $query->where('placa_sn', 1);
        }
        if ($searchTerm) {
            $query->where(function($subquery) use ($searchTerm) {
                $subquery->where('descripcion', 'like', "%{$searchTerm}%")
                        ->orWhere('codigo', 'like', "%{$searchTerm}%");
            });
        }

        // 2. Obtenemos los resultados y cargamos la relación con el grupo
        $productos = $query->with('grupo')->orderBy('codigo', 'asc')->get();

        // 3. Agrupamos la colección de resultados
        $productosAgrupados = $productos->groupBy(function ($producto) {
            if ($producto->grupo) {
                return $producto->grupo->codigo;
            }
            return 'Sin Asignar';
        });

        // 4. Pasamos la nueva colección a la vista del PDF
        $fecha = date('d-m-Y');
        $pdf = PDF::loadView('stock.pdfstock_todos', compact('productosAgrupados', 'fecha'))->setPaper('a4', 'portrait');

        return $pdf->stream('stock_total.pdf');
    }
}
