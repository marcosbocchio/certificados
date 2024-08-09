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

    public function imprimirTodoStock()
    {
        $productos = Productos::where('stockeable_sn', 1)->get();
        $fecha = date('d-m-Y');

        $pdf = PDF::loadView('stock.pdfstock_todos', compact('productos','fecha'))->setPaper('a4','portrait');

        return $pdf->stream('stock_total.pdf');
    }
}