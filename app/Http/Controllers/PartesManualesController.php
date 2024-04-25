<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\ParteManual;
use App\ParteManualDetalle;
use App\Informe;
use App\Clientes;
use App\Ots;
use App\Plantas;
use App\OtOperarios;
use App\User;
use App\MetodoEnsayos;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PartesManualesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas'], ['only' => ['index', 'create', 'store', 'update', 'edit']]);
    }
    public function index($ot_id)
    {
        $header_titulo = "Partes";
        $header_descripcion = "Alta | Modificación";
        $user = auth()->user();
        $header_sub_titulo = ' / ';

        $ot = Ots::findOrFail($ot_id);
        $cliente = Clientes::findOrFail($ot->cliente_id);
        $clienteNombre = $cliente->nombre_fantasia;
        log::info($cliente);
        $proyecto = $ot->proyecto;
        
        $ordenTrabajoNumero = $ot->numero;
        
        $plantas = Plantas::where('cliente_id', $ot->cliente_id)->get();


        $operador_opcion = obtenerNombresOperadoresPorOt($ot_id);
        
        return view('partes.manual', compact(
            'ot_id',
            'user',
            'header_titulo',
            'header_sub_titulo',
            'header_descripcion',
            'clienteNombre',
            'proyecto',
            'ordenTrabajoNumero',
            'plantas',
            'operador_opcion',
            'ot'
        ));
    }

    public function edit($id)
    {
        try {

            $header_titulo = "Partes";
            $header_descripcion = "Alta | Modificación";
            $user = auth()->user();
            $header_sub_titulo = ' / ';
            $parteManual = ParteManual::findOrFail($id);
            $fecha = $parteManual->fecha;
            $fecha_sin_hora = Carbon::parse($fecha)->toDateString();
            $ot = Ots::findOrFail($parteManual->ot_id);
            $cliente = Clientes::findOrFail($ot->cliente_id);
            $clienteNombre = $cliente->nombre_fantasia;   
            $proyecto = $ot->proyecto;
            $ordenTrabajoNumero = $ot->numero;
            $detalles = ParteManualDetalle::where('parte_manual_id', $id)->get();
            $plantas = Plantas::where('cliente_id', $ot->cliente_id)->get();
            $operador_opcion = obtenerNombresOperadoresPorOt($ot->id);
            
            return view('partes.manual-edit', compact(
                'parteManual',
                'fecha_sin_hora',
                'ot',
                'cliente',
                'clienteNombre',
                'proyecto',
                'ordenTrabajoNumero',
                'detalles',
                'plantas',
                'header_titulo',
                'operador_opcion',
                'header_descripcion',
                'user',
                'header_sub_titulo',
            ));
        } catch (\Exception $e) {
            \Log::error('Error al cargar la edición de la parte manual: ' . $e->getMessage());
            abort(404);
        }
    }

    public function show($id)
    {
        try {
            $parteManual = ParteManual::findOrFail($id);
            return response()->json($parteManual);
        } catch (\Exception $e) {
            \Log::error('Error al obtener la parte manual: ' . $e->getMessage());
            return response()->json(['message' => 'Parte manual no encontrada.'], 404);
        }
    }

    public function getPartesPaginadas()
    {
        // Obtener todas las partes manuales con la columna numero_formateado, nombre del usuario y fecha formateada, ordenadas por fecha
        $partes = ParteManual::leftJoin('users', 'parte_manual.usuario_alta_id', '=', 'users.id')
            ->select(
                \DB::raw("LPAD(parte_manual.id, 8, '0') as numero_formateado"),
                'parte_manual.id',
                'parte_manual.usuario_alta_id',
                'users.name as nombre_usuario',
                \DB::raw("DATE_FORMAT(parte_manual.fecha, '%d/%m/%Y') as fecha_formateada")
            )
            ->orderBy('parte_manual.fecha', 'desc')  // Ordena por la columna fecha de manera descendente
            ->get();
    
        return $partes;
    }

    public function store(Request $request)
    {

        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }
        // Validación de datos recibidos
        $validatedData = $request->validate([
            'ordenTrabajo' => 'required|integer',
            'fecha' => 'required|date',
            'ot_obra' => 'required|string',
            'detalles' => 'required|array',
            'selectedInformes' => 'array',
        ]);

        try {
            \DB::beginTransaction();
            $parteManual = ParteManual::create([
                'ot_id' => $request->ot_id,
                'usuario_alta_id' => $user_id,
                'fecha' => $request->fecha,
            ]);
            foreach ($request->detalles as $detalle) {
                ParteManualDetalle::create([
                    'parte_manual_id' => $parteManual->id,
                    'tecnica' => $detalle['tecnica'],
                    'cantidad' => $detalle['cantidad'],
                    'planta' => $detalle['planta']['label'], 
                    'equipo' => $detalle['equipo_linea'],
                    'operador1' => $detalle['operadores'][0]['value'] ?? null,
                    'operador2' => $detalle['operadores'][1]['value'] ?? null,
                    'horario' => $detalle['horario'],
                    'informe_nro' => $detalle['n_informe'],
                ]);
            }

            // Asociar los informes seleccionados
            if (!empty($validatedData['selectedInformes'])) {
                foreach ($validatedData['selectedInformes'] as $informeId) {
                    $informe = Informe::find($informeId);
                    if ($informe) {
                        $informe->parte_id = $parteManual->id;
                        $informe->parte_manual_sn = 1;
                        $informe->save();
                    }
                }
            }

            \DB::commit();
            return response()->json(['message' => 'Parte manual y detalles guardados exitosamente, informes asociados.', 'id' => $parteManual->id], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error al guardar los datos: ' . $e->getMessage() . ' en el archivo ' . $e->getFile() . ' en la línea ' . $e->getLine());
            \Log::debug("Stack Trace: " . $e->getTraceAsString());
            \Log::debug("Request data: ", $request->all());
            return response()->json(['message' => 'Error al guardar: ' . $e->getMessage()], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }
    
        try {
            
            \DB::beginTransaction();
    
            // Obtener el parte manual existente por su ID
            $parteManual = ParteManual::findOrFail($id);
    
            // Actualizar el parte manual con los datos proporcionados en la solicitud
            $parteManual->update([
                'ot_id' => $request->ot,
                'usuario_alta_id' => $user_id,
                'fecha' => $request->fecha,
            ]);
    
            // Eliminar todos los detalles de parte manual asociados al parte manual que se está actualizando
            $parteManual->detalles()->delete();
    
            // Iterar sobre los nuevos detalles proporcionados en la solicitud y crear registros de detalles de parte manual
            foreach ($request->detalles as $detalle) {
                $parteManual->detalles()->create([
                    'tecnica' => $detalle['tecnica'],
                    'cantidad' => $detalle['cantidad'],
                    'planta' => $detalle['planta']['label'], 
                    'equipo' => $detalle['equipo_linea'],
                    'operador1' => $detalle['operadores'][0]['value'] ?? null,
                    'operador2' => $detalle['operadores'][1]['value'] ?? null,
                    'horario' => $detalle['horario'],
                    'informe_nro' => $detalle['n_informe'],
                ]);
            }
    
            // Asociar los informes seleccionados, si los hay, al parte manual actualizado
            if (!empty($validatedData['selectedInformes'])) {
                foreach ($validatedData['selectedInformes'] as $informeId) {
                    $informe = Informe::find($informeId);
                    if ($informe) {
                        $informe->parte_id = $parteManual->id;
                        $informe->parte_manual_sn = 1;
                        $informe->save();
                    }
                }
            }
    
            \DB::commit();
            return response()->json(['message' => 'Parte manual actualizado exitosamente.'], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error al actualizar el parte manual: ' . $e->getMessage());
            return response()->json(['message' => 'Error al actualizar el parte manual: ' . $e->getMessage()], 500);
        }
    }

    public function getInformesSinParte(Request $request) {
        $fechaSeleccionada = $request->query('hasta');
        $otId = $request->query('ot_id');
        
        // Ajusta la consulta para obtener los informes que coincidan exactamente con la fecha seleccionada
        $informesSinParte = Informe::select('informes.*', 'metodo_ensayos.metodo', 'users.name as solicitante', 'plantas.nombre as nombre_planta')
                                    ->leftJoin('metodo_ensayos', 'informes.metodo_ensayo_id', '=', 'metodo_ensayos.id')
                                    ->leftJoin('users', 'informes.solicitado_por', '=', 'users.id')
                                    ->leftJoin('plantas', 'informes.planta_id', '=', 'plantas.id') // Unión con la tabla plantas
                                    ->where('informes.ot_id', $otId)
                                    ->whereNull('informes.parte_id')
                                    ->whereDate('informes.fecha', '=', $fechaSeleccionada) // Modificado para coincidir exactamente con la fecha
                                    ->get();

        return response()->json($informesSinParte);
    }
}