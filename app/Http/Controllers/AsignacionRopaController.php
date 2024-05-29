<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AsistenciaHora;
use App\AsistenciaDetalle;
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
    public function nuevo()
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

        // Obtener los user_id únicos de la tabla ot_operarios
        $uniqueUserIds = OtOperarios::select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) = 1')
            ->pluck('user_id');
    
        // Obtener los usuarios de la tabla User usando los user_id únicos
        $operadores = User::whereIn('id', $uniqueUserIds)->get();

        // Pasar los productos y remitos formateados a la vista
        return view('asistencia-ropa.asistencia-nuevo', compact('user', 'header_titulo', 'header_descripcion', 'productos', 'operadores', 'remitos'));
    }
}
