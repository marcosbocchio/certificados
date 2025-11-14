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
        $fecha = date('d-m-Y');

        // Traemos los productos stockeables junto con su grupo
        $productos = Productos::where('stockeable_sn', 1)
            ->leftJoin('productos_grupo', 'productos.agrupacion_id', '=', 'productos_grupo.id')
            ->select('productos.*', 'productos_grupo.descripcion as grupo_descripcion')
            ->orderBy('grupo_descripcion')
            ->orderBy('productos.descripcion')
            ->get();

        // Armamos colección agrupada por nombre de grupo
        $productosAgrupados = $productos->groupBy(function ($producto) {
            // Si no tiene grupo, lo mandamos a un grupo "Sin grupo" (o el nombre que quieras)
            return $producto->grupo_descripcion ?: 'Sin grupo';
        });

        $pdf = PDF::loadView('stock.pdfstock_todos', [
            'productosAgrupados' => $productosAgrupados,
            'fecha'             => $fecha,
        ])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('stock_total.pdf');
    }
}
