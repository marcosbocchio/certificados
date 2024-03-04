<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Requests\StockRequest;
use App\Http\Requests\CompraRequest;
use App\Stock;
use App\Productos;
use App\Compra;
use App\Proveedor;
use App\DetalleCompra;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas|M_stock'], [
            'only' => [
                'callView', 
                'callViewTable', 
                'vistaAjusteStock', 
                'callViewTotalStock', 
                'callViewEditStock',  
                'callViewRegistro', 
                'callViewEditS',
                // Cualquier otro método que quieras proteger
            ]
        ]);
    }

    public function index()
    {
        $stockItems = Stock::all();
        return response()->json($stockItems);
    }
//__________________________________________________callView__________________________________________________
    public function callView()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "Compras"; // Título para la página
        $header_descripcion = "Alta"; // Descripción o subtítulo para la página
        $stockItems = Stock::all(); // Obtener todos los elementos de stock
    
        // Retornar la vista de stock, pasando los datos necesarios
        return view('stock.index', compact('user', 'header_titulo', 'header_descripcion', 'stockItems'));
    }

    public function callViewTable()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "COMPRAS"; // Título para la página
        $header_descripcion = "."; // Descripción o subtítulo para la página
        $proveedor = Proveedor::all();
    
        // Retornar la vista de stock, pasando los datos necesarios
        return view('stock.table', compact('user', 'header_titulo', 'header_descripcion','proveedor'));
    }

    public function vistaAjusteStock($id)
    {
        $user = auth()->user();
        $header_titulo = "Compras";
        $header_descripcion = "Vista";
        $stockItem = Compra::where('id', $id)->first(); 
        $stockItemCompra = DetalleCompra::where('compra_id', $id)->get();
        $proveedor = Proveedor::where('id', $stockItem->proveedor_id)->get();
        return view('stock.ajuste', compact('user', 'header_titulo', 'header_descripcion', 'stockItem','stockItemCompra','proveedor'));
    }

    public function callViewTotalStock()
    {
        $user = auth()->user();
        $header_titulo = "Stock";
        $header_descripcion = ".";
        return view('stock.total', compact('user', 'header_titulo', 'header_descripcion',));
    }
    public function callViewEditStock($id)
    {
        $user = auth()->user();
        $header_titulo = "Stock";
        $header_descripcion = "Ajuste";
        $productos = Productos::where('id', $id)->get();

        return view('stock.edit', compact('user', 'header_titulo', 'header_descripcion', 'productos',));
    }
    public function callViewRegistro($id)
    {
        $user = auth()->user();
        $getRegistroName = $productos = Productos::where('id', $id)->first();
        $RegistroName = $getRegistroName->descripcion;
        $header_titulo = "Movimientos - " . $RegistroName;
        $header_descripcion = ".";
        $id = $id;
        return view('stock.registro', compact('user', 'header_titulo', 'header_descripcion','id',));
    }
    public function callViewEditS($id)
    {
        $producto = Productos::where('id', $id)->first();
        $productoName = $producto->descripcion;
        $user = auth()->user();
        $header_titulo = "Ajuste" . $productoName;
        $header_descripcion = ".";
        $producto = Productos::where('id', $id)->first();
        return view('stock.edit', compact('user', 'header_titulo', 'header_descripcion', 'producto',));
    }
    
//__________________________________________________function__________________________________________________    
    
public function store(CompraRequest $request)
{
    DB::beginTransaction();

    try {
        $compra = new Compra([
            'fecha' => $request->fecha,
            'fecha_remito' => $request->fecha_remito,
            'proveedor_id' => $request->proveedor_id,
            'numero_remito' => $request->numero_remito,
        ]);
        $compra->save();

        foreach ($request->detalles as $detalle) {
            $detalleCompra = new DetalleCompra([
                'compra_id' => $compra->id,
                'producto_id' => $detalle['producto_id'],
                'cantidad' => $detalle['cantidad'],
            ]);
            $detalleCompra->save();
            $this->actualizarStock($detalleCompra, $request);
        }

        DB::commit();
        return response()->json(['message' => 'Compra guardada con éxito', 'compra' => $compra], 200);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error al guardar la compra: ' . $e->getMessage());
        return response()->json(['error' => 'Error interno del servidor'], 500);
    }
}
public function reemplazarStockProducto(StockRequest $request)
{
    DB::beginTransaction();
    try {
        $producto = Productos::findOrFail($request->producto_id);
        $nuevoValorStock = $request->stock; // El nuevo valor del stock a establecer

        // Reemplazar el stock del producto con el nuevo valor
        $producto->stock = $nuevoValorStock;
        $producto->save();
        log::info($request->tipo_movimiento);
        // Registrar el ajuste en la tabla 'stock'
        $registroStock = new Stock([
            'producto_id' => $request->producto_id,
            'fecha' => now(),
            'cantidad' =>  $request->cantidad,
            'obs' => $request->observaciones,
            'stock'=> $nuevoValorStock,
            'tipo_movimiento'=> $request->tipo_movimiento,
        ]);
        $registroStock->save();

        DB::commit();
        return response()->json(['message' => 'Stock reemplazado y registrado con éxito.']);
    } catch (\Exception $e) {
        Log::error('Error al reemplazar stock: ' . $e->getMessage());
        DB::rollback();
        return response()->json(['error' => 'Error interno del servidor', 'exception' => $e->getMessage()], 500);
    }
}
public function actualizarStock($detalleCompra, $request)
{
    try {
        $producto = Productos::find($detalleCompra->producto_id);
        if (!$producto) {
            throw new \Exception("Producto no encontrado");
        }

        // Actualizar el stock del producto
        $producto->stock += $detalleCompra->cantidad;
        $producto->save();

        // Crear un nuevo registro en la tabla de stock
        $nuevoStock = new Stock([
            'producto_id' => $detalleCompra->producto_id,
            'cantidad' => $detalleCompra->cantidad,
            'obs' => $request->obs,
            'stock' => $producto->stock,
            'tipo_movimiento' => $request->tipo_movimiento,
        ]);
        $nuevoStock->save();

    } catch (\Exception $e) {
        Log::error('Error al actualizar el stock del producto', [
            'producto_id' => $detalleCompra->producto_id,
            'error' => $e->getMessage()
        ]);
        
        throw $e;
    }
}

    public function show($id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['message' => 'Registro de stock no encontrado.'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($stock);
    }

    public function update(Request $request, $id)
{
    $compra = Compra::findOrFail($id);

    DB::beginTransaction();
    try {
        // Actualizar la compra con nuevos campos, incluyendo observaciones a nivel de compra
        $compra->update($request->only(['fecha', 'fecha_remito', 'proveedor_id', 'numero_remito', 'obs']));

        // Eliminar detalles de compra antiguos
        DetalleCompra::where('compra_id', $compra->id)->delete();

        // Crear nuevos detalles de compra y actualizar stock
        foreach ($request->detalles as $detalle) {
            $detalleCompra = new DetalleCompra([
                'compra_id' => $compra->id,
                'producto_id' => $detalle['producto_id'],
                'cantidad' => $detalle['cantidad'],
            ]);
            $detalleCompra->save();
        }

        DB::commit();
        return response()->json(['message' => 'Compra actualizada exitosamente', 'compra' => $compra], 200);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error("Error al actualizar la compra: {$e->getMessage()}");
        return response()->json(['error' => 'Error interno del servidor'], 500);
    }
}
    public function destroy($id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['message' => 'Registro de stock no encontrado.'], Response::HTTP_NOT_FOUND);
        }

        DB::beginTransaction();
        try {
            $stock->delete();
            DB::commit();
            return response()->json(['message' => 'Registro de stock eliminado exitosamente.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al eliminar el registro de stock', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

//__________________________________________________paginate__________________________________________________ 

    public function paginate(Request $request)
    {
        $filtro = $request->search;
        $fechaInicio = $request->fechaInicio ? Carbon::parse($request->fechaInicio) : Carbon::now()->subDays(30);
        $fechaFin = $request->fechaFin ? Carbon::parse($request->fechaFin)->endOfDay() : Carbon::now();

        $stockItems = Compra::with('proveedor')
                            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                            ->withSearch($filtro)
                            ->orderBy('created_at', 'DESC')
                            ->paginate(10);

        return response()->json($stockItems);
    }


    public function paginateStock(Request $request)
    {
        $perPage = 10;

        $productos = Productos::where('stockeable_sn', 1)->paginate($perPage);

    
        return response()->json($productos);
    }


    public function paginateRegistro(Request $request, $id)
    {
        $perPage = 10;
        
        // Inicializa la fecha de inicio desde la solicitud, o usa por defecto la fecha de hace 30 días
        $fechaInicio = $request->input('fechaInicio', Carbon::now()->subDays(30)->toDateString());
    
        $registro = Stock::where('producto_id', $id)
                         ->whereDate('created_at', '>=', $fechaInicio) // Filtra por fecha de inicio
                         ->orderBy('created_at', 'DESC')
                         ->paginate($perPage);
        
        return response()->json($registro);
    }



//__________________________________________________Anular__________________________________________________ 

    public function compraAnulacion($id)
    {
        DB::beginTransaction();
        try {
            $detallesCompra = DetalleCompra::where('compra_id', $id)->get();
            $compra = Compra::find($id);

            if (!$compra) {
                throw new \Exception("Compra no encontrada con ID: {$id}");
            }

            foreach ($detallesCompra as $detalle) {
                $producto = Productos::find($detalle->producto_id);
                if (!$producto) {
                    throw new \Exception("Producto no encontrado con ID: {$detalle->producto_id}");
                }

                // Ajustar el stock del producto
                $producto->stock -= $detalle->cantidad;
                if ($producto->stock < 0) {
                    throw new \Exception("Stock negativo para el producto ID: {$detalle->producto_id}");
                }
                $producto->save();

                // Crear registro de anulación en Stock
                $stock = new Stock([
                    'fecha' => now(),
                    'obs' => "",
                    'cantidad' => -$detalle->cantidad,
                    'stock' => $producto->stock,
                    'producto_id' => $detalle->producto_id,
                    'tipo_movimiento' => "Anul. remito de compra N° " . $compra->numero_remito,
                ]);
                $stock->save();
            }

            // Marcar la compra como anulada
            $compra->anulado_sn = 1;
            $compra->save();

            DB::commit();
            return response()->json(['message' => 'Compra anulada y stock ajustado correctamente.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al anular la compra: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor', 'detalle' => $e->getMessage()], 500);
        }
    }

    public function desanularInforme($id)
    {
        DB::beginTransaction();
        try {
            $compra = Compra::find($id);
            if (!$compra) {
                throw new \Exception("Compra no encontrada con ID: {$id}");
            }

            // Verificar si la compra ya está desanulada para evitar duplicación de stock
            if ($compra->anulado_sn != 1) {
                throw new \Exception("La compra con ID: {$id} ya está desanulada o nunca fue anulada.");
            }

            $detallesCompra = DetalleCompra::where('compra_id', $id)->get();

            foreach ($detallesCompra as $detalle) {
                $producto = Productos::find($detalle->producto_id);
                if (!$producto) {
                    throw new \Exception("Producto no encontrado con ID: {$detalle->producto_id}");
                }

                // Incrementar el stock del producto
                $producto->stock += $detalle->cantidad;
                $producto->save();

                // Crear registro de desanulación en Stock con cantidad positiva
                $stock = new Stock([
                    'fecha' => now(),
                    'obs' => "",
                    'cantidad' => $detalle->cantidad, // Positivo para reflejar el incremento en el stock
                    'stock' => $producto->stock,
                    'producto_id' => $detalle->producto_id,
                    'tipo_movimiento' => 'Desanul. remito de compra N° '. $compra->numero_remito,
                ]);
                $stock->save();
            }

            // Marcar la compra como desanulada cambiando anulado_sn a 0
            $compra->anulado_sn = 0;
            $compra->save();

            DB::commit();
            return response()->json(['message' => 'Compra desanulada, stock ajustado correctamente, y movimiento de stock registrado.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al desanular la compra: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor', 'detalle' => $e->getMessage()], 500);
        }
    }
}