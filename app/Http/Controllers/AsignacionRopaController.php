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

        // Obtener productos stockeables
        $productos = Productos::where('stockeable_sn', 1)->get();

        // Obtener remitos no borradores y formatear el número
        $remitos = Remitos::where('borrador_sn', 0)->get()->map(function ($remito) {
            $remito->formateado = sprintf('%04d-%08d', $remito->prefijo, $remito->numero);
            return $remito;
        });

        $remito_data = Remitos::where('id',$remito_id)->get()->map(function ($remito) {
            $remito->formateado = sprintf('%04d-%08d', $remito->prefijo, $remito->numero);
            return $remito;
        });
        

        // Obtener los user_id únicos y los usuarios correspondientes
        $uniqueUserIds = $this->getUniqueUserIds();
        $operadores = $this->getUsersByIds($uniqueUserIds);

        // Obtener el operador completo usando el ID
        $operador = $this->getUser($operador);
        
        return view('asistencia-ropa.asistencia-nuevo', compact('user', 'header_titulo', 'header_descripcion', 'productos', 'operadores', 'remitos', 'operador', 'remito_data'));
    }

    public function callRemito($id_remito)
    {
        $user = auth()->user();
        $header_titulo = "EPP Remito";
        $header_descripcion = "Alta | Modificación";

        // Obtener los user_id únicos y los usuarios correspondientes
        $uniqueUserIds = $this->getUniqueUserIds();
        $operadores = $this->getUsersByIds($uniqueUserIds);
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
        // Obtener el operador completo usando el ID
        $operador_data = $this->getUser($operador);
        return view('asistencia-ropa.asistencia-operador', compact('user', 'header_titulo', 'header_descripcion','operador_data'));
        
    }

    public function callOperadorManual($operador, $fechaw, $edit)
    {
        $user = auth()->user();
        $header_titulo = "EPP";
        $header_descripcion = "Alta | Modificación";

        // Obtener productos stockeables
        $productos = Productos::where('stockeable_sn', 1)->get();

        // Convertir la fecha a objeto Carbon si es necesario
        $fecha = Carbon::parse($fechaw);
        $edit_data = $edit;
        $operador = $this->getUser($operador);

        return view('asistencia-ropa.asistencia-operador-manual', compact('user', 'header_titulo', 'header_descripcion', 'productos', 'operador', 'fecha','edit_data'));
    }

    public function callViewReporteEPP(){

        $user = auth()->user();
        $header_titulo = "Reportes";
        $header_descripcion ="EPP";
        // Obtener los user_id únicos y los usuarios correspondientes
        $uniqueUserIds = $this->getUniqueUserIds();
        $operadores = $this->getUsersByIds($uniqueUserIds);
        return view('reporte-epp.epp',compact('user','header_titulo','header_descripcion','operadores'));

    }
    
    /* funciones */

        // Función para obtener los user_id únicos de la tabla ot_operarios
        private function getUniqueUserIds()
        {
            return OtOperarios::select('user_id')
                ->groupBy('user_id')
                ->havingRaw('COUNT(user_id) = 1')
                ->pluck('user_id');
        }
    
        // Función para obtener los usuarios de la tabla User usando los user_id únicos
        private function getUsersByIds($ids)
        {
            return User::whereIn('id', $ids)->get();
        }
    
        // Función para obtener un usuario por su ID
        private function getUser($id)
        {
            return User::find($id);
        }

        public function obtenerDetallesRemito($remito_id)
        {
            Log::info('Entro en obtener');

            // Obtener detalles del remito
            $detallesRemito = DetalleRemitos::where('remito_id', $remito_id)->get();

            // Obtener asignaciones EPP relacionadas con el remito
            $asignacionesEpp = Asignacion_epp::where('remito_id', $remito_id)->get();

            // Recorrer las asignaciones EPP para obtener los detalles
            $detallesAsignacionEpp = collect();
            foreach ($asignacionesEpp as $asignacion) {
                $detallesAsignacionEpp = $detallesAsignacionEpp->merge(Detalle_asignacion_epp::where('asignacion_epp_id', $asignacion->id)->get());
            }

            // Crear una colección de productos con cantidades actualizadas
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
                'fecha' => 'required|date_format:Y-m-d H:i:s'  // Validar la fecha y hora
            ]);

            $user = auth()->user();
            $fechaActual = $request->fecha;

            // Verificar si ya existe una asignación para esta fecha y operador
            if ($request->remito_id !== null) {
                $asignacionExistente = Asignacion_epp::where('remito_id', $request->remito_id)
                    ->where('operador_id', $request->operador_id)
                    ->first();
            } else {
                $asignacionExistente = null;
            }

            log::info($asignacionExistente);

            if ($asignacionExistente) {
                // Si ya existe, actualizamos los detalles existentes y la observación
                $asignacionExistente->obs = $request->observaciones;
                $asignacionExistente->save();

                foreach ($request->detalles as $detalle) {
                    $detalleExistente = Detalle_asignacion_epp::where('asignacion_epp_id', $asignacionExistente->id)
                        ->where('producto_id', $detalle['producto']['id'])
                        ->first();

                    if ($detalleExistente) {
                        // Si existe, actualizamos la cantidad
                        $detalleExistente->cantidad = $detalle['cantidad'];
                        $detalleExistente->save();
                    } else {
                        // Si no existe, creamos un nuevo detalle
                        Detalle_asignacion_epp::create([
                            'asignacion_epp_id' => $asignacionExistente->id,
                            'producto_id' => $detalle['producto']['id'],
                            'cantidad' => $detalle['cantidad']
                        ]);
                    }
                }
            } else {
                // Si no existe, creamos una nueva asignación
                $asignacion = Asignacion_epp::create([
                    'fecha' => $fechaActual,
                    'operador_id' => $request->operador_id,
                    'user_id' => $user->id,
                    'remito_id' => $request->remito_id,
                    'obs' => $request->observaciones
                ]);

                // detalles de asignación
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
            log::info($request);
            log::info($observaciones);
            $user = auth()->user();
        
            try {
                DB::beginTransaction();
        
                foreach ($detalles as $detalle) {
                    $producto = Productos::find($detalle['producto']['id']);
        
                    if ($producto) {
                        // Invertir el signo de la cantidad recibida
                        $cantidad = -$detalle['cantidad'];
        
                        // Actualizar el stock del producto
                        $producto->stock += $cantidad;
        
                        // Guardar el producto actualizado
                        $producto->save();
        
                        // Registrar movimiento en la tabla de stock
                        Stock::create([
                            'fecha' => now(),
                            'obs' => $observaciones,
                            'cantidad' => $cantidad, // Guardar la cantidad modificada
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
                ->orderBy('updated_at', 'desc') // Ordena por updated_at de más nuevo a más viejo
                ->get();
        
            return response()->json($asignaciones);
        }

        public function getAsignacionEppDetails($operadorId, $remitoId)
        {
            try {
                // Buscar la asignación de EPP por operador_id y remito_id
                $asignacion = Asignacion_epp::where('operador_id', $operadorId)
                    ->where('remito_id', $remitoId)
                    ->with('detalles.producto') // Cargar detalles y productos asociados
                    ->first();

                if (!$asignacion) {
                    return response()->json(['error' => 'No se encontró la asignación de EPP para el operador y remito especificados'], 404);
                }

                // Obtener las observaciones y la fecha de la asignación
                $observaciones = $asignacion->obs;
                $fecha = $asignacion->fecha;

                // Preparar los datos para enviar de vuelta
                $response = [
                    'asignacion' => $asignacion,
                    'observaciones' => $observaciones, // Incluir observaciones en la respuesta
                    'fecha' => $fecha, // Incluir fecha en la respuesta
                ];

                return response()->json($response);
            } catch (\Exception $e) {
                Log::error('Error al obtener detalles de asignación de EPP: ' . $e->getMessage());
                return response()->json(['error' => 'Error interno del servidor al obtener detalles de asignación de EPP'], 500);
            }
        }

        public function getAsignacionEppDetailsByFecha($fecha)
        {
            log::info($fecha);
            log::info('entro en getAsignacionEppDetailsByFecha');
            
                // Buscar la asignación de EPP por fecha
                $asignacion = Asignacion_epp::where('fecha', $fecha)
                    ->with('detalles.producto') // Cargar detalles y productos asociados
                    ->first();
        
                if (!$asignacion) {
                    return response()->json(['error' => 'No se encontró la asignación de EPP para la fecha especificada'], 404);
                }
        
                // Obtener las observaciones y la fecha de la asignación
                $observaciones = $asignacion->obs;
                $fecha = $asignacion->fecha;
        
                // Preparar los datos para enviar de vuelta
                $response = [
                    'asignacion' => $asignacion,
                    'observaciones' => $observaciones, // Incluir observaciones en la respuesta
                    'fecha' => $fecha, // Incluir fecha en la respuesta
                ];
                log::info($response);
                return response()->json($response);
        }

        public function getOperadoresByRemito($remito_id)
        {
            // Buscar asignaciones de EPP por remito_id
            $asignaciones = Asignacion_epp::where('remito_id', $remito_id)->get();

            $operadores = [];
            foreach ($asignaciones as $asignacion) {
                // Buscar el usuario por operador_id
                $operador = User::find($asignacion->operador_id);
                if ($operador) {
                    $operadores[] = $operador;
                }
            }

            return response()->json(['operadores' => $operadores]);
        }

        public function buscarAsignacionesEPP(Request $request)
        {
            // Obtener los parámetros de la solicitud
            $startDate = $request->input('start_date') ?? '2001-01-01';
            $endDate = $request->input('end_date') ?? '2100-12-30';
            $userId = $request->input('user_id');
            $perPage = $request->input('per_page', 10);

            // Consulta para obtener las asignaciones de EPP
            $query = DB::table('asignacion_epp AS ae')
                ->select(
                    DB::raw("DATE_FORMAT(ae.fecha, '%Y-%m-%d') AS fecha"),
                    DB::raw("CONCAT(LPAD(r.prefijo, 4, '0'), '-', LPAD(r.numero, 8, '0')) AS remito"),
                    'u.name AS operador',
                    'p.descripcion AS epp',
                    'dae.cantidad AS cantidad'
                )
                ->join('remitos AS r', 'ae.remito_id', '=', 'r.id')
                ->join('users AS u', 'ae.operador_id', '=', 'u.id')
                ->join('detalle_asignacion_epp AS dae', 'ae.id', '=', 'dae.asignacion_epp_id')
                ->join('productos AS p', 'dae.producto_id', '=', 'p.id')
                ->whereBetween('ae.fecha', [$startDate, $endDate])
                ->orderBy('ae.fecha', 'desc'); // Ordenar por fecha del más nuevo al más viejo

            // Aplicar filtro por usuario si se proporciona
            if ($userId) {
                $query->where('ae.operador_id', $userId);
            }

            // Obtener resultados
            $results = $query->paginate($perPage);

            return response()->json($results);
        }
}
