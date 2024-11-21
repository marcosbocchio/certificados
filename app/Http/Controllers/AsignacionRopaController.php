<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AsistenciaHora;
use App\AsistenciaDetalle;
use App\DetalleRemitos;
use App\Frentes;
use App\User;
use App\Stock;
use App\Productos;
use App\Remitos;
use App\Asignacion_epp;
use App\Detalle_asignacion_epp;
use App\Contratistas;
use App\OtOperarios;
use App\OperadorControl;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AsignacionRopaController extends Controller
{

    public function nuevo($operador, $remito_id)
    {
        $user = auth()->user();
        $header_titulo = "EPP";
        $header_descripcion = "Alta | Modificación";

        $productos = Productos::where('stockeable_sn', 1)->get();

        $remitos = Remitos::where('borrador_sn', 0)->get()->map(function ($remito) {
            $remito->formateado = sprintf('%04d-%08d', $remito->prefijo, $remito->numero);
            return $remito;
        });

        $remito_data = Remitos::where('id',$remito_id)->get()->map(function ($remito) {
            $remito->formateado = sprintf('%04d-%08d', $remito->prefijo, $remito->numero);
            return $remito;
        });
        

        
        $operadores = $this->getUsersByIds();

        $operador = $this->getUser($operador);
        
        return view('asistencia-ropa.asistencia-nuevo', compact('user', 'header_titulo', 'header_descripcion', 'productos', 'operadores', 'remitos', 'operador', 'remito_data'));
    }

    public function callRemito($id_remito)
    {
        $user = auth()->user();
        $header_titulo = "EPP Remito";
        $header_descripcion = "Alta | Modificación";

        
        $operadores = $this->getUsersByIds();
        $remito_data = Remitos::where('id',$id_remito)->get()->map(function ($remito) {
            $remito->formateado = sprintf('%04d-%08d', $remito->prefijo, $remito->numero);
            return $remito;
        });
        
        return view('asistencia-ropa.asistencia-remito', compact('user', 'header_titulo', 'header_descripcion', 'operadores','remito_data'));
    }

    public function callOperador($operador)
    {
        $user = auth()->user();
        $header_titulo = "EPP Operador";
        $header_descripcion = "Alta | Modificación";
        $operador_data = $this->getUser($operador);
        return view('asistencia-ropa.asistencia-operador', compact('user', 'header_titulo', 'header_descripcion','operador_data'));
        
    }

    public function callOperadorManual($operador, $fechaw, $edit)
    {
        $user = auth()->user();
        $header_titulo = "EPP";
        $header_descripcion = "Alta | Modificación";

        $productos = Productos::where('stockeable_sn', 1)->get();

        $fecha = Carbon::parse($fechaw);
        $edit_data = $edit;
        $operador = $this->getUser($operador);

        return view('asistencia-ropa.asistencia-operador-manual', compact('user', 'header_titulo', 'header_descripcion', 'productos', 'operador', 'fecha','edit_data'));
    }

    public function callViewReporteEPP(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="EPP";
        
        $operadores = $this->getUsersByIds();
        return view('reporte-epp.epp',compact('user','header_titulo','header_descripcion','operadores'));

    }
    
    /* funciones */

        private function getUniqueUserIds()
        {
            return OtOperarios::select('user_id')
                ->groupBy('user_id')
                ->havingRaw('COUNT(user_id) = 1')
                ->pluck('user_id');
        }
    
        private function getUsersByIds()
        {
            return User::whereNull('cliente_id')   
                ->orderBy('name', 'asc') 
                ->get();
        }
    
        private function getUser($id)
        {
            return User::find($id);
        }

        public function obtenerDetallesRemito($remito_id)
        {

            
            $detallesRemito = DetalleRemitos::where('remito_id', $remito_id)->get();

            
            $asignacionesEpp = Asignacion_epp::where('remito_id', $remito_id)->get();

            
            $detallesAsignacionEpp = collect();
            foreach ($asignacionesEpp as $asignacion) {
                $detallesAsignacionEpp = $detallesAsignacionEpp->merge(Detalle_asignacion_epp::where('asignacion_epp_id', $asignacion->id)->get());
            }

            $productosActualizados = $detallesRemito->map(function ($detalle) use ($detallesAsignacionEpp) {
                $producto = Productos::find($detalle->producto_id);
                $cantidadAsignada = $detallesAsignacionEpp->where('producto_id', $detalle->producto_id)->sum('cantidad');
                $cantidadDisponible = $detalle->cantidad - $cantidadAsignada;
                return [
                    'producto' => $producto,
                    'cantidad_disponible' => $cantidadDisponible
                ];
            });

            return response()->json([
                'detalle_remito_data' => $detallesRemito,
                'productos_actualizados' => $productosActualizados
            ]);
        }

        public function store(Request $request)
        {
            $this->validate($request, [
                'operador_id' => 'required|exists:users,id',
                'remito_id' => 'nullable|exists:remitos,id',
                'detalles' => 'required|array',
                'detalles.*.producto.id' => 'required|exists:productos,id',
                'detalles.*.cantidad' => 'required',
                'observaciones' => 'nullable|string',
                'fecha' => 'required|date_format:Y-m-d H:i:s'  
            ]);

            $user = auth()->user();
            $fechaActual = $request->fecha;

            
            if ($request->remito_id !== null) {
                $asignacionExistente = Asignacion_epp::where('remito_id', $request->remito_id)
                    ->where('operador_id', $request->operador_id)
                    ->first();
            } else {
                $asignacionExistente = null;
            }


            if ($asignacionExistente) {
                
                $asignacionExistente->obs = $request->observaciones;
                $asignacionExistente->save();

                foreach ($request->detalles as $detalle) {
                    $detalleExistente = Detalle_asignacion_epp::where('asignacion_epp_id', $asignacionExistente->id)
                        ->where('producto_id', $detalle['producto']['id'])
                        ->first();

                    if ($detalleExistente) {
                      
                        $detalleExistente->cantidad = $detalle['cantidad'];
                        $detalleExistente->save();
                    } else {
                        
                        Detalle_asignacion_epp::create([
                            'asignacion_epp_id' => $asignacionExistente->id,
                            'producto_id' => $detalle['producto']['id'],
                            'cantidad' => $detalle['cantidad']
                        ]);
                    }
                }
            } else {
                $asignacion = Asignacion_epp::create([
                    'fecha' => $fechaActual,
                    'operador_id' => $request->operador_id,
                    'user_id' => $user->id,
                    'remito_id' => $request->remito_id,
                    'obs' => $request->observaciones
                ]);

                foreach ($request->detalles as $detalle) {
                    Detalle_asignacion_epp::create([
                        'asignacion_epp_id' => $asignacion->id,
                        'producto_id' => $detalle['producto']['id'],
                        'cantidad' => $detalle['cantidad']
                    ]);
                }
            }

            return response()->json(['message' => 'Asignación guardada correctamente'], 201);
        }

        public function actualizarAsignacionStock(Request $request)
        {
            $detalles = $request->detalles;
            $observaciones = $request->observaciones;
            $user = auth()->user();
        
            try {
                DB::beginTransaction();
        
                foreach ($detalles as $detalle) {
                    $producto = Productos::find($detalle['producto']['id']);
        
                    if ($producto) {
                        
                        $cantidad = -$detalle['cantidad'];
        
                        
                        $producto->stock += $cantidad;
        
                        
                        $producto->save();
        
                        
                        Stock::create([
                            'fecha' => now(),
                            'obs' => $observaciones,
                            'cantidad' => $cantidad, 
                            'stock' => $producto->stock,
                            'producto_id' => $producto->id,
                            'tipo_movimiento' => 'EEP manual user',
                            'user_id' => $user->id,
                        ]);
                    } else {
                        throw new \Exception('Producto no encontrado');
                    }
                }
        
                DB::commit();
                return response()->json(['message' => 'Stock actualizado correctamente']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Error al actualizar el stock: ' . $e->getMessage()], 500);
            }
        }

        public function getAsignaciones($operador_id)
        {
            $asignaciones = Asignacion_epp::where('operador_id', $operador_id)
                ->with('remito', 'user')
                ->orderBy('updated_at', 'desc')
                ->get();
        
            return response()->json($asignaciones);
        }

        public function getAsignacionEppDetails($operadorId, $remitoId)
        {
            try {
                $asignacion = Asignacion_epp::where('operador_id', $operadorId)
                    ->where('remito_id', $remitoId)
                    ->with('detalles.producto') 
                    ->first();

                if (!$asignacion) {
                    return response()->json(['error' => 'No se encontró la asignación de EPP para el operador y remito especificados'], 404);
                }

                $observaciones = $asignacion->obs;
                $fecha = $asignacion->fecha;

                $response = [
                    'asignacion' => $asignacion,
                    'observaciones' => $observaciones, 
                    'fecha' => $fecha, 
                ];

                return response()->json($response);
            } catch (\Exception $e) {
                Log::error('Error al obtener detalles de asignación de EPP: ' . $e->getMessage());
                return response()->json(['error' => 'Error interno del servidor al obtener detalles de asignación de EPP'], 500);
            }
        }

        public function getAsignacionEppDetailsByFecha($fecha)
        {
            
                $asignacion = Asignacion_epp::where('fecha', $fecha)
                    ->with('detalles.producto') 
                    ->first();
        
                if (!$asignacion) {
                    return response()->json(['error' => 'No se encontró la asignación de EPP para la fecha especificada'], 404);
                }
        
                $observaciones = $asignacion->obs;
                $fecha = $asignacion->fecha;
        
                $response = [
                    'asignacion' => $asignacion,
                    'observaciones' => $observaciones, 
                    'fecha' => $fecha, 
                ];
                return response()->json($response);
        }

        public function getOperadoresByRemito($remito_id)
        {
            $asignaciones = Asignacion_epp::where('remito_id', $remito_id)->get();

            $operadores = [];
            foreach ($asignaciones as $asignacion) {
                $operador = User::find($asignacion->operador_id);
                if ($operador) {
                    $operadores[] = $operador;
                }
            }

            return response()->json(['operadores' => $operadores]);
        }

        public function buscarAsignacionesEPP(Request $request)
        {
            
            $startDate = $request->input('start_date') ?? '2001-01-01';
            $endDate = $request->input('end_date') ?? '2100-12-30';
            $userId = $request->input('user_id');
            $perPage = $request->input('per_page', 10);
        
            $query = DB::table('asignacion_epp AS ae')
                ->select(
                    DB::raw("DATE_FORMAT(ae.fecha, '%Y-%m-%d') AS fecha"),
                    DB::raw("COALESCE(CONCAT(LPAD(r.prefijo, 4, '0'), '-', LPAD(r.numero, 8, '0')), '-') AS remito"),
                    'u.name AS operador',
                    'p.descripcion AS epp',
                    'dae.cantidad AS cantidad'
                )
                ->leftJoin('remitos AS r', 'ae.remito_id', '=', 'r.id')
                ->join('users AS u', 'ae.operador_id', '=', 'u.id')
                ->join('detalle_asignacion_epp AS dae', 'ae.id', '=', 'dae.asignacion_epp_id')
                ->join('productos AS p', 'dae.producto_id', '=', 'p.id')
                ->whereBetween('ae.fecha', [$startDate, $endDate])
                ->orderBy('ae.fecha', 'desc'); 
        
            if ($userId) {
                $query->where('ae.operador_id', $userId);
            }
        
            $results = $query->paginate($perPage);
        
            return response()->json($results);
        }
}
