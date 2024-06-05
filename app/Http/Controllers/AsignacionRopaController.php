<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AsistenciaHora;
use App\AsistenciaDetalle;
use App\DetalleRemitos;
use App\Frentes;
use App\User;
use App\Remitos;
use App\Contratistas;
use App\OtOperarios;
use App\OperadorControl;
use App\Productos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AsignacionRopaController extends Controller
{

    public function nuevo($operador, $remito_id)
{
    $user = auth()->user();
    $header_titulo = "Control Asistencia";
    $header_descripcion = "Resumen";

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

    // Pasar los productos, remitos y operador a la vista
    return view('asistencia-ropa.asistencia-nuevo', compact('user', 'header_titulo', 'header_descripcion', 'productos', 'operadores', 'remitos', 'operador', 'remito_data'));
}

    public function callRemito($id_remito)
    {
        $user = auth()->user();
        $header_titulo = "Control Remito";
        $header_descripcion = "Resumen";

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
        $header_titulo = "Control Operador";
        $header_descripcion = "Resumen";
        // Obtener el operador completo usando el ID
        $operador_data = $this->getUser($operador);
        return view('asistencia-ropa.asistencia-operador', compact('user', 'header_titulo', 'header_descripcion','operador_data'));
        
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
            Log::info($detalles);
    
            $productos = $detalles->map(function ($detalle) {
                return Productos::find($detalle->producto_id);
            });
    
            return response()->json([
                'detalle_remito_data' => $detalles,
                'productos_remito_data' => $productos,
            ]);
        }
}
