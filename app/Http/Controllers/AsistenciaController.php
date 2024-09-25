<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AsistenciaHora;
use App\AsistenciaDetalle;
use App\Frentes;
use App\FrenteOperador;
use App\User;
use App\Clientes;
use App\Contratistas;
use App\OtOperarios;
use App\OperadorControl;
use App\Partes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas|A_asistencia_acceder'], ['only' => ['callViewTotalStock', 'getAsistencia','callView']]);
    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Control Asistencia";
        $header_descripcion = ".";
        
        // Obtener los frente_id únicos de AsistenciaHora
        $frenteIds = AsistenciaHora::distinct()->pluck('frente_id');
        
        // Obtener los frentes correspondientes
        $user_frente = FrenteOperador::where('user_id',$user->id)->get();


        $frentes = Frentes::whereIn('id', $frenteIds)->get();
        
        // Pasar los datos a la vista
        return view('control-asistencia.asistencia-table', compact('user', 'header_titulo', 'header_descripcion', 'frentes','user_frente'));
    }

    public function resumenView()
    {
        $user = auth()->user();
        $header_titulo = "Control Asistencia";
        $header_descripcion = "Resumen";
        $frente_sn = Frentes::where('controla_hs_extras_sn', 1)->get();
        return view('control-asistencia.asistencia-resumen', compact('user', 'header_titulo', 'header_descripcion','frente_sn'));
    }

    public function nuevo()
    {
        $user = auth()->user();
        $header_titulo = "Control Asistencia";
        $header_descripcion = "Carga";
    
        $user_frente = FrenteOperador::where('user_id', $user->id)->pluck('frente_id');

        $frente_sn = Frentes::whereIn('id', $user_frente)
            ->where('controla_hs_extras_sn', 1)
            ->get();

        $contratistas = Clientes::all();
    
        // Obtener los user_id únicos de la tabla ot_operarios
        $operarios = User::whereNull('cliente_id')
                ->where('habilitado_sn', 1)
                ->orderBy('name', 'asc')
                ->get();
    
        // Obtener las fechas existentes de asistencia_horas agrupadas por frente_id
        $fechasPorFrente = AsistenciaHora::select('frente_id', 'fecha')
            ->get()
            ->groupBy('frente_id')
            ->map(function ($group) {
                return $group->pluck('fecha')->toArray();
            });
    
        return view('control-asistencia.asistencia-nuevo', compact('user', 'header_titulo', 'header_descripcion', 'frente_sn', 'operarios', 'contratistas', 'fechasPorFrente'));
    }

    public function copia($id)
    {
        $user = auth()->user();
        $header_titulo = "Control Asistencia";
        $header_descripcion = "Copia";
        $user_frente = FrenteOperador::where('user_id', $user->id)->pluck('frente_id');
        $frente_sn = Frentes::whereIn('id', $user_frente)
            ->where('controla_hs_extras_sn', 1)
            ->get();
        $contratistas = Contratistas::all();
        $operarios = User::whereNull('cliente_id')
        ->where('habilitado_sn', 1)
        ->orderBy('name', 'asc')
        ->get();
        $contratistas = Contratistas::all();
        $fechasPorFrente = AsistenciaHora::select('frente_id', 'fecha')
        ->get()
        ->groupBy('frente_id')
        ->map(function ($group) {
            return $group->pluck('fecha')->toArray();
        });
    
        return view('control-asistencia.asistencia-copia', compact('user', 'header_titulo', 'header_descripcion', 'frente_sn', 'operarios', 'contratistas', 'id','fechasPorFrente'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $header_titulo = "Control Asistencia";
        $header_descripcion = "Edit";
        $user_frente = FrenteOperador::where('user_id', $user->id)->pluck('frente_id');
        $frente_sn = Frentes::whereIn('id', $user_frente)
            ->where('controla_hs_extras_sn', 1)
            ->get();
            $contratistas = Clientes::all();
        $operarios = User::whereNull('cliente_id')
                ->where('habilitado_sn', 1)
                ->orderBy('name', 'asc')
                ->get();

        return view('control-asistencia.asistencia_edit', compact('user', 'header_titulo', 'header_descripcion', 'frente_sn', 'operarios', 'contratistas', 'id'));
    }

    public function controlarUser($id_user, $fecha)
    {

        $mes = $fecha;  // Directamente asignamos $fecha a $mes porque ya tiene el formato correcto
    
        // Buscar en la base de datos usando operador_id y mes
        $operadorControl = OperadorControl::where('operador_id', $id_user)
            ->where('mes', $mes)  // Comparamos directamente con el campo mes
            ->first();
    

    
        if ($operadorControl) {
            // Crear la respuesta en una variable
            $response = [
                'fecha_pago_s1' => $operadorControl->fecha_pago_s1,
                'fecha_pago_s2' => $operadorControl->fecha_pago_s2,
                'fecha_pago_s3' => $operadorControl->fecha_pago_s3,
                'fecha_pago_s4' => $operadorControl->fecha_pago_s4,
                'fecha_pago_s5' => $operadorControl->fecha_pago_s5,
                'fecha_pago_mes' => $operadorControl->fecha_pago_mes,
            ];
    
            // Registrar la respuesta en el log

    
            // Devolver la respuesta como JSON
            return response()->json($response);
        }
    


        return response()->json(['message' => 'No se encontraron registros.'], 404);
    }

    public function getPaginatedAsistencia(Request $request)
    {
        $query = AsistenciaHora::with('frente');
    
        if ($request->has('frente_id') && $request->frente_id) {
            $query->where('frente_id', $request->frente_id);
        }
    
        if ($request->has('date') && $request->date) {
            [$year, $month] = explode('-', $request->date);
            $query->whereMonth('fecha', $month)->whereYear('fecha', $year);
        }
    
        $asistencia = $query->orderBy('fecha', 'desc')->paginate(10);
        return response()->json($asistencia);
    }
    
    public function getAsistencia($id)
    {


        $asistencia = AsistenciaHora::with(['frente', 'detalles.operador', 'detalles.contratista'])->findOrFail($id);

        return response()->json($asistencia);
    }

    public function guardarAsistencia(Request $request)
    {

        $asistenciaHora = new AsistenciaHora;
        $asistenciaHora->frente_id = $request->frente_id;
        $asistenciaHora->fecha = $request->fecha;
        $asistenciaHora->save();

        foreach ($request->detalles as $detalle) {
            $asistenciaDetalle = new AsistenciaDetalle;
            $asistenciaDetalle->asistencia_horas_id = $asistenciaHora->id;
            $asistenciaDetalle->operador_id = $detalle['operador']['id'];
            $asistenciaDetalle->ayudante_sn = $detalle['ayudante_sn'];
            $asistenciaDetalle->entrada = $detalle['entrada'];
            $asistenciaDetalle->salida = $detalle['salida'];
            $asistenciaDetalle->contratista_id = $detalle['contratista']['id'];
            $asistenciaDetalle->parte = $detalle['parte'];
            $asistenciaDetalle->observaciones = $detalle['observaciones'] ?? null;
            $asistenciaDetalle->hora_extra_sn = $detalle['hora_extra_sn'];
            $asistenciaDetalle->s_d_f_sn = $detalle['s_d_f_sn'];
            $asistenciaDetalle->save();
        }

        return response()->json(['success' => 'Datos guardados correctamente']);
    }

    public function updateAsistencia(Request $request, $id)
    {
        $asistenciaHora = AsistenciaHora::findOrFail($id);
        AsistenciaDetalle::where('asistencia_horas_id', $id)->delete();
        $asistenciaHora->fecha = $request->fecha;
        $asistenciaHora->frente_id = $request->frente_id;
        $asistenciaHora->save();

        foreach ($request->detalles as $detalle) {
            $nuevoDetalle = new AsistenciaDetalle([
                'asistencia_horas_id' => $asistenciaHora->id,
                'operador_id' => $detalle['operador']['id'],
                'ayudante_sn' => $detalle['ayudante_sn'],
                'entrada' => $detalle['entrada'],
                'salida' => $detalle['salida'],
                'contratista_id' => $detalle['contratista']['id'],
                'parte' => $detalle['parte'],
                'observaciones' => $detalle['observaciones'] ?? null,
                'hora_extra_sn' => $detalle['hora_extra_sn'],
                's_d_f_sn' => $detalle['s_d_f_sn'],
            ]);
            $nuevoDetalle->save();
        }

        return response()->json(['message' => 'Asistencia actualizada con éxito!', 'data' => $asistenciaHora]);
    }

    public function updateDetalleAsistencia(Request $request, $id)
    {
        $detalle = AsistenciaDetalle::findOrFail($id);
        $detalle->observaciones = $request->observaciones;
        $detalle->save();

        return response()->json(['message' => 'Observación actualizada con éxito!', 'data' => $detalle]);
    }

    public function getAsistenciaAgrupadaPorOperador(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $frenteId = $request->frent_id;
        $diasDelMes = $this->calcularDiasDelMes($year, $month);
    
        $asistenciaHoras = AsistenciaHora::with(['detalles.operador'])
            ->whereYear('fecha', $year)
            ->whereMonth('fecha', $month)
            ->where('frente_id', $frenteId)
            ->get();
    
        // Calcular la responsabilidad general
        if ($asistenciaHoras->isEmpty()) {
            return response()->json([
                'diasDelMes' => $diasDelMes,
                'message' => 'No se encontraron datos para la fecha y frente seleccionados.'
            ], 404);
        }
    
        $horasDiariasLaborables = Frentes::find($frenteId)->horas_diarias_laborables;
        $resumenOperarios = $this->calcularHorasTrabajadas($asistenciaHoras, $diasDelMes, $horasDiariasLaborables);
    
        $mes = Carbon::createFromFormat('Y-m', "$year-$month")->format('m-Y');
        $operadorControl = OperadorControl::where('frente_id', $frenteId)
            ->where('mes', $mes)
            ->get()
            ->keyBy('operador_id');
    
        foreach ($resumenOperarios as &$operador) {
            $operadorId = $operador['operador']['id'];
    
            // Llamar a la función obtenerResponsabilidad
            $responsabilidad = $this->obtenerResponsabilidad($operadorId, $month);
    
            // Agregar el resultado a la propiedad del operador
            $operador['ayudante_sn'] = $responsabilidad;
    
            if (isset($operadorControl[$operadorId])) {
                $control = $operadorControl[$operadorId];
                if ($control->pago_mes_sn) {
                    $operador['diasHabiles'] = $control->dias_habiles_trabajados;
                    $operador['sabados'] = $control->sabados_trabajados;
                    $operador['domingos'] = $control->domingos_trabajados;
                    $operador['feriados'] = $control->feriados_trabajados;
                    $operador['horasExtras'] = $control->horas_extras_trabajadas;
                    $operador['serviciosExtrasS1'] = $control->servicios_extras_s1;
                    $operador['serviciosExtrasS2'] = $control->servicios_extras_s2;
                    $operador['serviciosExtrasS3'] = $control->servicios_extras_s3;
                    $operador['serviciosExtrasS4'] = $control->servicios_extras_s4;
                    $operador['serviciosExtrasS5'] = $control->servicios_extras_s5;
                    $operador['pagosExtMensual'] = true;
                    $operador['pagoS1'] = true;
                    $operador['pagoS2'] = true;
                    $operador['pagoS3'] = true;
                    $operador['pagoS4'] = true;
                    $operador['pagoS5'] = true;
                    $operador['fecha_pago_s1'] = $control->fecha_pago_s1 ?? null;
                    $operador['fecha_pago_s2'] = $control->fecha_pago_s2 ?? null;
                    $operador['fecha_pago_s3'] = $control->fecha_pago_s3 ?? null;
                    $operador['fecha_pago_s4'] = $control->fecha_pago_s4 ?? null;
                    $operador['fecha_pago_s5'] = $control->fecha_pago_s5 ?? null;
                    $operador['fecha_pago_mes'] = $control->fecha_pago_mes ?? null;
                } else {
                    if ($control->servicios_extras_s1 !== null) {
                        $operador['serviciosExtrasS1'] = $control->servicios_extras_s1;
                        $operador['pagoS1'] = true;
                        $operador['fecha_pago_s1'] = $control->fecha_pago_s1 ?? null;
                    }
                    if ($control->servicios_extras_s2 !== null) {
                        $operador['serviciosExtrasS2'] = $control->servicios_extras_s2;
                        $operador['pagoS2'] = true;
                        $operador['fecha_pago_s2'] = $control->fecha_pago_s2 ?? null;
                    }
                    if ($control->servicios_extras_s3 !== null) {
                        $operador['serviciosExtrasS3'] = $control->servicios_extras_s3;
                        $operador['pagoS3'] = true;
                        $operador['fecha_pago_s3'] = $control->fecha_pago_s3 ?? null;
                    }
                    if ($control->servicios_extras_s4 !== null) {
                        $operador['serviciosExtrasS4'] = $control->servicios_extras_s4;
                        $operador['pagoS4'] = true;
                        $operador['fecha_pago_s4'] = $control->fecha_pago_s4 ?? null;
                    }
                    if ($control->servicios_extras_s5 !== null) {
                        $operador['serviciosExtrasS5'] = $control->servicios_extras_s5;
                        $operador['pagoS5'] = true;
                        $operador['fecha_pago_s5'] = $control->fecha_pago_s5 ?? null;
                    }
                }
            }
        }
        // Ordenar los operadores alfabéticamente por nombre
        usort($resumenOperarios, function ($a, $b) {
            return strcmp($a['operador']['name'], $b['operador']['name']);
        });
    
        return response()->json([
            'diasDelMes' => $diasDelMes,
            'asistencias' => $resumenOperarios
        ]);
    }

    public function obtenerResponsabilidad($operadorId, $month)
    {
        $hayUno = false;
        $todosSonCero = true;
    
        // Obtener los detalles de asistencia para el operador y el mes dado
        $detalles = AsistenciaDetalle::where('operador_id', $operadorId)
            ->whereMonth('created_at', $month)
            ->get();
    
        // Iterar sobre cada elemento del array de detalles
        foreach ($detalles as $detalle) {
            // Verificar si la propiedad 'ayudante_sn' existe y es numérica
            if (isset($detalle->ayudante_sn)) {
                // Si 'ayudante_sn' no es null, verificar su valor
                if ($detalle->ayudante_sn === 1) {
                    $hayUno = true; // Hay al menos un 1
                } elseif ($detalle->ayudante_sn !== 0) {
                    $todosSonCero = false; // Hay algún valor distinto de 0
                }
            }
        }
    
        // Determinar el texto basado en los contadores
        if ($hayUno) {
            return 'operador'; // Hay al menos un 1
        } elseif ($todosSonCero) {
            return 'ayudante'; // Todos son 0 o 'ayudante_sn' es null
        } else {
            return 'desconocido'; // No se puede determinar la responsabilidad
        }
    }

    public function controlarParte(Request $request)
    {
        // Validar que el parámetro 'num' esté presente
        $request->validate([
            'num' => 'required|string'
        ]);

        // Obtener el número del parte
        $num = $request->input('num');

        // Eliminar ceros a la izquierda para obtener el ID original
        $id = ltrim($num, '0');

        // Buscar si existe el parte con el ID
        $parte = Partes::find($id);

        // Retornar true si existe, false si no
        return response()->json(['exists' => !is_null($parte)]);
    }
    private function calcularHorasTrabajadas($asistenciaHoras, $diasDelMes, $horasDiariasLaborables)
    {
        $resumenOperarios = [];
        foreach ($asistenciaHoras as $asistenciaHora) {
            foreach ($asistenciaHora->detalles as $detalle) {
                $operadorId = $detalle->operador->id;
                $fecha = Carbon::parse($asistenciaHora->fecha);
                $entrada = Carbon::parse($detalle->entrada);
                $salida = Carbon::parse($detalle->salida);
                $horasTrabajadas = $salida->diffInMinutes($entrada) / 60;
                $semanaDelMes = $this->getSemanaDelMes($fecha, $diasDelMes['semanas']);
                $localNeuquen = $detalle->operador->local_neuquen_sn;
                if (!isset($resumenOperarios[$operadorId])) {
                    $resumenOperarios[$operadorId] = [
                        'operador' => $detalle->operador,
                        'diasHabiles' => 0,
                        'sabados' => 0,
                        'domingos' => 0,
                        'feriados' => 0,
                        'horasExtras' => 0,
                        'serviciosExtrasS1' => 0,
                        'pagoS1' => false,
                        'serviciosExtrasS2' => 0,
                        'pagoS2' => false,
                        'serviciosExtrasS3' => 0,
                        'pagoS3' => false,
                        'serviciosExtrasS4' => 0,
                        'pagoS4' => false,
                        'serviciosExtrasS5' => 0,
                        'pagoS5' => false,
                        'pagosExtMensual' => false,
                        
                    ];
                }

                // Contar feriados
                if ($this->esFeriado($fecha, $diasDelMes['feriadosArray'])) {
                    $resumenOperarios[$operadorId]['feriados']++;
                }

                // Contar sábados
                if ($fecha->isSaturday()) {
                    $resumenOperarios[$operadorId]['sabados']++;
                }

                // Contar domingos
                if ($fecha->isSunday()) {
                    $resumenOperarios[$operadorId]['domingos']++;
                }

                // Contar días hábiles
                if (!$this->esFeriado($fecha, $diasDelMes['feriadosArray']) && !$fecha->isSaturday() && !$fecha->isSunday()) {
                    $resumenOperarios[$operadorId]['diasHabiles']++;
                }

                // Contar servicios extras
                if ($detalle->contratista_id !== null) {
                    $resumenOperarios[$operadorId]["serviciosExtrasS$semanaDelMes"]++;
                } else {
                    // Contar horas extras
                    if ($horasTrabajadas > $horasDiariasLaborables) {
                        $resumenOperarios[$operadorId]['horasExtras'] += $horasTrabajadas - $horasDiariasLaborables;
                    }
                }
            }
        }

        return array_values($resumenOperarios);
    }

    private function getSemanaDelMes($fecha, $semanas)
    {
        foreach ($semanas as $index => $semana) {
            if ($fecha->between(Carbon::parse($semana['inicio']), Carbon::parse($semana['fin']))) {
                return $index + 1; // Retornar el índice de la semana (ajustado a 1 basado)
            }
        }
        return 0; // En caso de error
    }

    public function calcularDiasDelMes($year, $month)
    {
        $feriados = $this->getFeriados($year);
        $diasHabiles = 0;
        $sabados = 0;
        $domingos = 0;
        $feriadosCount = 0;
        $feriadosArray = [];
        $semanas = [];

        $totalDias = Carbon::createFromDate($year, $month)->daysInMonth;
        $inicioMes = Carbon::create($year, $month, 1);
        $inicioSemana = $inicioMes->copy()->startOfWeek(Carbon::FRIDAY);

        $finMes = Carbon::create($year, $month, $totalDias);
        $finSemana = $finMes->copy()->endOfWeek(Carbon::THURSDAY);

        for ($fecha = $inicioSemana; $fecha->lte($finSemana); $fecha->addDay()) {
            $diaDeLaSemana = $fecha->dayOfWeek;
            $esFeriado = $this->esFeriado($fecha, $feriados);

            if ($esFeriado) {
                $feriadosCount++;
                $feriadosArray[] = $fecha->toDateString();
            } elseif ($diaDeLaSemana == Carbon::SUNDAY) {
                $domingos++;
            } elseif ($diaDeLaSemana == Carbon::SATURDAY) {
                $sabados++;
            } else {
                $diasHabiles++;
            }

            $semanaInicio = $fecha->copy()->startOfWeek(Carbon::FRIDAY);
            $semanaFin = $fecha->copy()->endOfWeek(Carbon::THURSDAY);

            if (!isset($semanas[$semanaInicio->weekOfYear])) {
                $semanas[$semanaInicio->weekOfYear] = [
                    'inicio' => $semanaInicio->toDateString(),
                    'fin' => $semanaFin->toDateString()
                ];
            }
        }

        // Log the result before returning
        $resultado = [
            'diasHabiles' => $diasHabiles,
            'sabados' => $sabados,
            'domingos' => $domingos,
            'feriados' => $feriadosCount,
            'feriadosArray' => $feriadosArray,
            'semanas' => array_values($semanas)
        ];

        // Log the output for debugging
        Log::info('Resultado de calcularDiasDelMes', $resultado);

        return $resultado;
    }

    function getFeriados($year)
    {
        $path = public_path('feriados/feriados.json');
        if (!File::exists($path)) {
            return [];
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        // Verificar si el año existe en el JSON
        if (!isset($data[$year])) {
            return [];
        }

        // Filtrar los feriados por año y transformar el formato de los feriados
        $feriadosAnuales = $data[$year];
        $feriadosArray = array_map(function($feriado) use ($year) {
            return Carbon::create($year, $feriado['mes'], $feriado['dia'])->toDateString();
        }, $feriadosAnuales);

        return $feriadosArray;
    }


     function esFeriado($fecha, $feriados)
    {
        return in_array($fecha->toDateString(), $feriados);
    }

    public function guardarPagos(Request $request)
    {
        $frenteId = $request->frente_id;
        $selectedMonthYear = $request->selectedMonthYear;
        $operarios = $request->operarios;
        foreach ($operarios as $operador) {
            // Guardar solo si algún check está seleccionado
            if ($operador['pagoS1'] || $operador['pagoS2'] || $operador['pagoS3'] || $operador['pagoS4'] || $operador['pagoS5'] || $operador['pagosExtMensual']) {
                // Formatear el mes correctamente a 'mm-YYYY'
                $mes = Carbon::createFromFormat('Y-m', $selectedMonthYear)->format('m-Y');
                
                // Datos para encontrar el registro
                $attributes = [
                    'frente_id' => $frenteId,
                    'operador_id' => $operador['operador']['id'],
                    'mes' => $mes,
                ];

                // Datos para actualizar o crear el registro
                $values = [];

                if ($operador['pagosExtMensual']) {
                    $values = [
                        'dias_habiles_trabajados' => $operador['diasHabiles'],
                        'sabados_trabajados' => $operador['sabados'],
                        'domingos_trabajados' => $operador['domingos'],
                        'feriados_trabajados' => $operador['feriados'],
                        'horas_extras_trabajadas' => $operador['horasExtras'],
                        'servicios_extras_s1' => $operador['serviciosExtrasS1'],
                        'servicios_extras_s2' => $operador['serviciosExtrasS2'],
                        'servicios_extras_s3' => $operador['serviciosExtrasS3'],
                        'servicios_extras_s4' => $operador['serviciosExtrasS4'],
                        'servicios_extras_s5' => $operador['serviciosExtrasS5'],
                        'pago_mes_sn' => true,
                        'fecha_pago_s1' => $operador['fecha_pago_s1'] ?? null,
                        'fecha_pago_s2' => $operador['fecha_pago_s2'] ?? null,
                        'fecha_pago_s3' => $operador['fecha_pago_s3'] ?? null,
                        'fecha_pago_s4' => $operador['fecha_pago_s4'] ?? null,
                        'fecha_pago_s5' => $operador['fecha_pago_s5'] ?? null,
                        'fecha_pago_mes' => $operador['fecha_pago_mes'] ?? null,
                    ];
                } else {
                    if ($operador['pagoS1']) {
                        $values['servicios_extras_s1'] = $operador['serviciosExtrasS1'];
                        $values['fecha_pago_s1'] = $operador['fecha_pago_s1'] ?? null;
                    }
                    if ($operador['pagoS2']) {
                        $values['servicios_extras_s2'] = $operador['serviciosExtrasS2'];
                        $values['fecha_pago_s2'] = $operador['fecha_pago_s2'] ?? null;
                    }
                    if ($operador['pagoS3']) {
                        $values['servicios_extras_s3'] = $operador['serviciosExtrasS3'];
                        $values['fecha_pago_s3'] = $operador['fecha_pago_s3'] ?? null;
                    }
                    if ($operador['pagoS4']) {
                        $values['servicios_extras_s4'] = $operador['serviciosExtrasS4'];
                        $values['fecha_pago_s4'] = $operador['fecha_pago_s4'] ?? null;
                    }
                    if ($operador['pagoS5']) {
                        $values['servicios_extras_s5'] = $operador['serviciosExtrasS5'];
                        $values['fecha_pago_s5'] = $operador['fecha_pago_s5'] ?? null;
                    }
                }
                // Crear o actualizar el registro
                OperadorControl::updateOrCreate($attributes, $values);
            }
        }

        return response()->json(['success' => 'Pagos guardados con éxito']);
    }

    public function getDatosAsistencia(Request $request)
    {
        // Obtener frente_id y fecha desde los parámetros de la URL
        $frenteId = $request->input('frente_id');
        $fecha = $request->input('fecha');
    
        // Buscar todas las filas en AsistenciaHora que coincidan con el frente y la fecha (año-mes)
        $asistenciaHoras = AsistenciaHora::where('frente_id', $frenteId)
                                        ->where('fecha', 'like', $fecha . '%') // Buscar por año-mes
                                        ->get();
    
        // Obtener los IDs de AsistenciaHora para buscar en AsistenciaDetalle
        $asistenciaHorasIds = $asistenciaHoras->pluck('id'); // Lista de IDs
    
        // Buscar en AsistenciaDetalle con esos IDs, cargar la relación con User y AsistenciaHora
        $detallesAgrupados = AsistenciaDetalle::whereIn('asistencia_horas_id', $asistenciaHorasIds)
                                              ->with(['operador', 'asistenciaHora'])  // Incluir relaciones
                                              ->get()
                                              ->groupBy(function($detalle) {
                                                  // Agrupar por el nombre del operador en lugar del ID
                                                  return $detalle->operador->name;
                                              })
                                              ->map(function($detalles) {
                                                  // Verificar si todos los ayudante_sn son 0 o si alguno es 1
                                                  $ayudanteSnFlag = $detalles->every(function($detalle) {
                                                      return $detalle->ayudante_sn === 0;
                                                  }) ? 'ayudante' : 'operador';
    
                                                  // Modificar cada grupo de detalles para incluir 'fechaAsignacion' y 'ayudante_sn'
                                                  return $detalles->map(function($detalle) use ($ayudanteSnFlag) {
                                                      return [
                                                          'detalle' => $detalle,  // Todos los detalles del registro
                                                          'fechaAsignacion' => $detalle->asistenciaHora->fecha,  // Fecha de AsistenciaHora
                                                          'ayudante_sn' => $ayudanteSnFlag  // Ayudante u operador según los valores
                                                      ];
                                                  });
                                              });
    
        return response()->json($detallesAgrupados);
    }
}