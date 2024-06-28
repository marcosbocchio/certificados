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
        $header_titulo = "EEP";
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
        $header_titulo = "EEP Remito";
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
        $header_titulo = "EEP Operador";
        $header_descripcion = "Alta | Modificación";
        // Obtener el operador completo usando el ID
        $operador_data = $this->getUser($operador);
        return view('asistencia-ropa.asistencia-operador', compact('user', 'header_titulo', 'header_descripcion','operador_data'));
        
    }

    public function callOperadorManual($operador, $fechaw)
    {
        $user = auth()->user();
        $header_titulo = "EEP";
        $header_descripcion = "Alta | Modificación";

        // Obtener productos stockeables
        $productos = Productos::where('stockeable_sn', 1)->get();

        // Convertir la fecha a objeto Carbon si es necesario
        $fecha = Carbon::parse($fechaw);

        $operador = $this->getUser($operador);

        return view('asistencia-ropa.asistencia-operador-manual', compact('user', 'header_titulo', 'header_descripcion', 'productos', 'operador', 'fecha'));
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
    
            $detalles = DetalleRemitos::where('remito_id', $remito_id)->get();
    
            $productos = $detalles->map(function ($detalle) {
                return Productos::find($detalle->producto_id);
            });
    
            return response()->json([
                'detalle_remito_data' => $detalles,
                'productos_remito_data' => $productos,
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
}
