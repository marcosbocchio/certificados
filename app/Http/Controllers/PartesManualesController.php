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
        $this->middleware(['role_or_permission:Sistemas|T_partes_acceder'], ['only' => ['index', 'create', 'store', 'update', 'edit']]);
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

        $inspectores_op = User::where('cliente_id',$ot->cliente_id)->get();
        
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
            'inspectores_op',
            'ot',

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
            $inspectores_op = User::where('cliente_id',$ot->cliente_id)->get();
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
                'inspectores_op',
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

    public function getPartesPaginadas(Request $request)
    {
        // Recupera el ot_id desde la solicitud, null si no se proporciona
        $otId = $request->query('ot_id');
    
        // Construye la consulta base
        $query = ParteManual::leftJoin('users', 'parte_manual.usuario_alta_id', '=', 'users.id')
            ->select(
                \DB::raw("LPAD(parte_manual.id, 8, '0') as numero_formateado"),
                'parte_manual.id',
                'parte_manual.usuario_alta_id',
                'users.name as nombre_usuario',
                \DB::raw("DATE_FORMAT(parte_manual.fecha, '%d/%m/%Y') as fecha_formateada")
            );
    
        // Filtra por ot_id si se proporciona
        if (!is_null($otId)) {
            $query->where('parte_manual.ot_id', $otId);
        }
    
        // Ordena primero por fecha de manera descendente y luego por id de manera descendente
        $partes = $query->orderBy('parte_manual.fecha', 'desc')
                         ->orderBy('parte_manual.id', 'desc')
                         ->paginate(10);
    
        return $partes;
    }

    public function store(Request $request)
    {
        $user_id = Auth::check() ? Auth::id() : null;
    
        \Log::info('Detalles recibidos: ' . json_encode($request->detalles));
        try {
            \DB::beginTransaction();
    
            $parteManual = ParteManual::create([
                'ot_id'             => $request->ot_id,
                'usuario_alta_id'   => $user_id,
                'fecha'             => $request->fecha,
            ]);
    
            foreach ($request->detalles as $detalle) {
                \Log::debug($detalle);
                ParteManualDetalle::create([
                    'parte_manual_id' => $parteManual->id,
                    // Asignamos el primer valor a tecnica_1 y el segundo (si existe) a tecnica_2
                    'tecnica_1'       => isset($detalle['tecnica'][0]) ? $detalle['tecnica'][0] : null,
                    'tecnica_2'       => isset($detalle['tecnica'][1]) ? $detalle['tecnica'][1] : null,
                    // De igual forma para las cantidades
                    'cantidad_1'      => isset($detalle['cantidad'][0]) ? $detalle['cantidad'][0] : null,
                    'cantidad_2'      => isset($detalle['cantidad'][1]) ? $detalle['cantidad'][1] : null,
                    // Para las plantas, accedemos al campo "value" de cada objeto
                    'planta_1'        => isset($detalle['planta'][0]['value']) ? $detalle['planta'][0]['value'] : null,
                    'planta_2'        => isset($detalle['planta'][1]['value']) ? $detalle['planta'][1]['value'] : null,
                    'equipo'          => $detalle['equipo_linea'],
                    // Operadores: primer y segundo (si existen)
                    'operador1'       => isset($detalle['operadores'][0]['value']) ? $detalle['operadores'][0]['value'] : null,
                    'operador2'       => isset($detalle['operadores'][1]['value']) ? $detalle['operadores'][1]['value'] : null,
                    'horario'         => $detalle['horario'],
                    // Inspectores: usamos el campo "id"
                    'inspector_id_1'  => isset($detalle['inspector_secl'][0]['id']) ? $detalle['inspector_secl'][0]['id'] : null,
                    'inspector_id_2'  => isset($detalle['inspector_secl'][1]['id']) ? $detalle['inspector_secl'][1]['id'] : null,
                    'informe_nro'     => $detalle['n_informe'],
                ]);
            }
    
            // Procesamos los informes seleccionados (si existen)
            if (!empty($request->selectedInformes)) {
                foreach ($request->selectedInformes as $informeId) {
                    $informe = Informe::find($informeId);
                    if ($informe) {
                        $informe->parte_id = $parteManual->id;
                        $informe->parte_manual_sn = 1;
                        $informe->save();
                    }
                }
            }
    
            \DB::commit();
            return response()->json([
                'message' => 'Parte manual y detalles guardados exitosamente, informes asociados.',
                'id'      => $parteManual->id
            ], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error al guardar los datos: ' . $e->getMessage() . ' en ' . $e->getFile() . ' en la línea ' . $e->getLine());
            \Log::debug("Stack Trace: " . $e->getTraceAsString());
            \Log::debug("Request data: ", $request->all());
            return response()->json(['message' => 'Error al guardar: ' . $e->getMessage()], 500);
        }
    }
      
    
    public function update(Request $request, $id)
    {
        $user_id = null;
    
        if (Auth::check()) {
             $user_id = Auth::id();
        }
    
        try {
            \DB::beginTransaction();
    
            // Obtener el parte manual existente por su ID
            $parteManual = ParteManual::findOrFail($id);
    
            // Actualizar el parte manual con los datos proporcionados en la solicitud
            $parteManual->update([
                'ot_id'           => $request->ot,
                'usuario_alta_id' => $user_id,
                'fecha'           => $request->fecha,
            ]);
    
            // Eliminar todos los detalles de parte manual asociados al parte manual que se está actualizando
            $parteManual->detalles()->delete();
            
            // Iterar sobre los nuevos detalles proporcionados en la solicitud y crear registros de detalles de parte manual
            foreach ($request->detalles as $detalle) {
                log::info($detalle);
                $parteManual->detalles()->create([
                    'tecnica_1'       => isset($detalle['tecnica1']) ? $detalle['tecnica1'] : null,
                    'tecnica_2'       => isset($detalle['tecnica2']) ? $detalle['tecnica2'] : null,
                    'cantidad_1'      => isset($detalle['cantidad1']) ? $detalle['cantidad1'] : null,
                    'cantidad_2'      => isset($detalle['cantidad2']) ? $detalle['cantidad2'] : null,
                    'planta_1'        => isset($detalle['planta'][0]['value']) ? $detalle['planta'][0]['value'] : null,
                    'planta_2'        => isset($detalle['planta'][1]['value']) ? $detalle['planta'][1]['value'] : null,
                    'equipo'          => isset($detalle['equipo_linea']) ? $detalle['equipo_linea'] : null,
                    'operador1'       => isset($detalle['operadores'][0]['value']) ? $detalle['operadores'][0]['value'] : null,
                    'operador2'       => isset($detalle['operadores'][1]['value']) ? $detalle['operadores'][1]['value'] : null,
                    'horario'         => isset($detalle['horario']) ? $detalle['horario'] : null,
                    'inspector_id_1'  => isset($detalle['inspector_secl'][0]['id']) ? $detalle['inspector_secl'][0]['id'] : null,
                    'inspector_id_2'  => isset($detalle['inspector_secl'][1]['id']) ? $detalle['inspector_secl'][1]['id'] : null,
                    'informe_nro'     => isset($detalle['n_informe']) ? $detalle['n_informe'] : null,
                ]);
            }
            
            
    
            // Asociar los informes seleccionados, si los hay, al parte manual actualizado
            if (!empty($request->selectedInformes)) {
                foreach ($request->selectedInformes as $informeId) {
                    $informe = Informe::find($informeId);
                    if ($informe) {
                        $informe->parte_id = $parteManual->id;
                        $informe->parte_manual_sn = 1;
                        $informe->save();
                    }
                }
            }
            \Log::info($request->selectedInformes);
    
            // Desasociar los informes deseleccionados
            if (!empty($request->deselectedInformes)) {
                foreach ($request->deselectedInformes as $informeId) {
                    $informe = Informe::find($informeId);
                    if ($informe) {
                        $informe->parte_id = null;
                        $informe->parte_manual_sn = 0;
                        $informe->save();
                    }
                }
            }
            \Log::info($request->deselectedInformes);
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
        $informesSinParte = Informe::select('informes.*', 'metodo_ensayos.metodo', 'users.name as solicitante', 'plantas.nombre as nombre_planta',\DB::raw("DATE_FORMAT(informes.fecha, '%d/%m/%Y') as fecha_formateada")) // Formatea la fecha como DD/MM/YYYY)
                                    ->leftJoin('metodo_ensayos', 'informes.metodo_ensayo_id', '=', 'metodo_ensayos.id')
                                    ->leftJoin('users', 'informes.solicitado_por', '=', 'users.id')
                                    ->leftJoin('plantas', 'informes.planta_id', '=', 'plantas.id') // Unión con la tabla plantas
                                    ->where('informes.ot_id', $otId)
                                    ->whereNull('informes.parte_id')
                                    ->whereDate('informes.fecha', '=', $fechaSeleccionada) // Modificado para coincidir exactamente con la fecha
                                    ->get();
        log::info($informesSinParte);
        return response()->json($informesSinParte);
    }

    public function getInformesConParte(Request $request) {
        $parteId = $request->query('parte_id');
        $otId = $request->query('ot_id');  // Recuperar ot_id del query string
    
        try {
            $informesConParte = Informe::select(
                'informes.*', 
                'metodo_ensayos.metodo', 
                'users.name as solicitante', 
                'plantas.nombre as nombre_planta',
                \DB::raw("DATE_FORMAT(informes.fecha, '%d/%m/%Y') as fecha_formateada")
            )
            ->leftJoin('metodo_ensayos', 'informes.metodo_ensayo_id', '=', 'metodo_ensayos.id')
            ->leftJoin('users', 'informes.solicitado_por', '=', 'users.id')
            ->leftJoin('plantas', 'informes.planta_id', '=', 'plantas.id')
            ->where('informes.parte_id', $parteId)
            ->where('informes.ot_id', $otId)  // Filtrar por ot_id
            ->where('informes.parte_manual_sn', 1)  // Filtrar por parte_manual_sn = 1
            ->get();
    
            return response()->json($informesConParte);
        } catch (\Exception $e) {
            \Log::error("Error retrieving reports with part: " . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}