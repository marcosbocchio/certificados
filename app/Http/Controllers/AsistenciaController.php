<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Frentes;
use App\User;
use App\Contratistas;
use App\AsistenciaHora;
use App\AsistenciaDetalle;
use Illuminate\Support\Facades\Log;

class AsistenciaController extends Controller
{
    public function __construct()
    {

     $this->middleware(['role_or_permission:Sistemas|A_asistencia_acceder'],['only' => ['callViewTotalStock']]);

    }

    public function callView()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "Control Asistencia"; // Título para la página
        $header_descripcion = "Tabla"; // Descripción o subtítulo para la página
        return view('control-asistencia.asistencia-table', compact('user', 'header_titulo', 'header_descripcion'));
    }
    
    public function nuevo()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "Control Asistencia"; // Título para la página
        $header_descripcion = "Tabla"; // Descripción o subtítulo para la página
        
        $frente_sn = Frentes::where('controla_hs_extras_sn', 1)->get();
        $operarios = User::where('local_neuquen_sn', 1)->get();
        $contratistas = Contratistas::all();

        return view('control-asistencia.asistencia-nuevo', compact('user', 'header_titulo', 'header_descripcion','frente_sn','operarios','contratistas'));
    }

    public function edit($id)
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $header_titulo = "Control Asistencia";
        $header_descripcion = "Editar Asistencia";
        $frente_sn = Frentes::where('controla_hs_extras_sn', 1)->get();
        $operarios = User::where('local_neuquen_sn', 1)->get();
        $contratistas = Contratistas::all();
        
        return view('control-asistencia.asistencia_edit', compact('user', 'header_titulo', 'header_descripcion','frente_sn','operarios','contratistas','id'));
    }

    public function getPaginatedAsistencia()
    {
        $asistencia = AsistenciaHora::with('frente')->paginate(10);
        return response()->json($asistencia);
    }

    public function getAsistencia($id)
    {
        // Carga los detalles de asistencia y también los detalles del operador y el contratista.
        $asistencia = AsistenciaHora::with(['detalles.operador', 'detalles.contratista'])
                        ->findOrFail($id);
    
        return response()->json($asistencia);
    }
    public function guardarAsistencia(Request $request)
    {
        Log::info('Registro de asistencia recibido:', [
            'data' => $request->all()  // Captura todo el contenido de la solicitud
        ]);
        
        $asistenciaHora = new AsistenciaHora;
        $asistenciaHora->frente_id = $request->frente_id;
        $asistenciaHora->fecha = $request->fecha;
        $asistenciaHora->save();

        foreach ($request->detalles as $detalle) {
            $asistenciaDetalle = new AsistenciaDetalle;
            $asistenciaDetalle->asistencia_horas_id = $asistenciaHora->id;
            $asistenciaDetalle->operador_id = $detalle['operador']['id'];
            $asistenciaDetalle->entrada = $detalle['entrada'];
            $asistenciaDetalle->salida = $detalle['salida'];
            $asistenciaDetalle->contratista_id = $detalle['contratista']['id'];
            $asistenciaDetalle->parte = $detalle['parte'];
            $asistenciaDetalle->save();
        }

        return response()->json(['success' => 'Datos guardados correctamente']);
    }
}
