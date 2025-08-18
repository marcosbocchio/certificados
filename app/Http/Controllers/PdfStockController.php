<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Productos;
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
        // CORRECCIÓN: Recibimos el 1 o 0 y lo tratamos como un booleano
        $filtroPlacas = (bool) $request->input('placas');
        $filtroPlacas_sn = (bool) $request->input('placas_sn');
        // Construimos la consulta con la misma lógica unificada
        $query = Productos::query();

        if ($filtroPlacas) {
            // CORRECCIÓN: Apuntamos a la columna correcta.
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

        // Obtenemos TODOS los resultados que coinciden, sin paginar
        $productos = $query->orderBy('codigo', 'asc')->get();

        // El resto de tu lógica para generar el PDF se mantiene igual
        $fecha = date('d-m-Y');
        $pdf = PDF::loadView('stock.pdfstock_todos', compact('productos','fecha'))->setPaper('a4','portrait');

        return $pdf->stream('stock_total.pdf');
    }
}
