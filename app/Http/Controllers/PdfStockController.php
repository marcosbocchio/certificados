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

    public function imprimirTodoStock(Request $request)
    {
        $fecha = date('d-m-Y');

        $search       = $request->query('search', '');
        $placas       = (int) $request->query('placas', 0);
        $placas_sn    = (int) $request->query('placas_sn', 0);
        $categoria_id = $request->query('categoria', null); // id numérico o null

        $query = Productos::where('stockeable_sn', 1)
            ->leftJoin('productos_grupo', 'productos.agrupacion_id', '=', 'productos_grupo.id')
            ->select('productos.*', 'productos_grupo.codigo as grupo_codigo');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('productos.codigo', 'LIKE', "%{$search}%")
                    ->orWhere('productos.descripcion', 'LIKE', "%{$search}%");
            });
        }

        if ($placas === 1) {
            $query->where('relacionado_a_placas_sn', 1);
        }

        if ($placas_sn === 1) {
            $query->where('placa_sn', 1);
        }

        if (!empty($categoria_id)) {
            $query->where('agrupacion_id', $categoria_id);
        }


        $query->orderBy('grupo_codigo')
            ->orderBy('productos.descripcion');

        $productos = $query->get();

        $productosAgrupados = $productos->groupBy(function ($producto) {
            return $producto->grupo_codigo ?: 'Sin grupo';
        });

        $pdf = PDF::loadView('stock.pdfstock_todos', [
            'productosAgrupados' => $productosAgrupados,
            'fecha'              => $fecha,
        ])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('stock_total.pdf');
    }
}
