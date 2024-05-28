<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AsistenciaHora;
use App\AsistenciaDetalle;
use App\Frentes;
use App\User;
use App\Contratistas;
use App\OtOperarios;
use App\OperadorControl;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas|A_asistencia_acceder'], ['only' => ['callViewTotalStock', 'getAsistencia']]);
    }

    public function callView()
    {
        $user = auth()->user();
        $header_titulo = "Control Asistencia";
        $header_descripcion = "Tabla";
        return view('control-asistencia.asistencia-table', compact('user', 'header_titulo', 'header_descripcion'));
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
        $header_descripcion = "Tabla";
    
        $frente_sn = Frentes::where('controla_hs_extras_sn', 1)->get();
        $contratistas = Contratistas::all();
    
        // Obtener los user_id únicos de la tabla ot_operarios
        $uniqueUserIds = OtOperarios::select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) = 1')
            ->pluck('user_id');
    
        // Obtener los usuarios de la tabla User usando los user_id únicos
        $operarios = User::whereIn('id', $uniqueUserIds)->get();
    
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
        $header_descripcion = "Editar Asistencia";
        $frente_sn = Frentes::where('controla_hs_extras_sn', 1)->get();
            // Obtener los user_id únicos de la tabla ot_operarios
            $uniqueUserIds = OtOperarios::select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(user_id) = 1')
            ->pluck('user_id');
    
        // Obtener los usuarios de la tabla User usando los user_id únicos
        $operarios = User::whereIn('id', $uniqueUserIds)->get();
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
        $header_descripcion = "Editar Asistencia";
        $frente_sn = Frentes::where('controla_hs_extras_sn', 1)->get();
         // Obtener los user_id únicos de la tabla ot_operarios
         $uniqueUserIds = OtOperarios::select('user_id')
         ->groupBy('user_id')
         ->havingRaw('COUNT(user_id) = 1')
         ->pluck('user_id');
 
        // Obtener los usuarios de la tabla User usando los user_id únicos
        $operarios = User::whereIn('id', $uniqueUserIds)->get();
        $contratistas = Contratistas::all();

        return view('control-asistencia.asistencia_edit', compact('user', 'header_titulo', 'header_descripcion', 'frente_sn', 'operarios', 'contratistas', 'id'));
    }

    public function getPaginatedAsistencia()
    {
        $asistencia = AsistenciaHora::with('frente')->orderBy('fecha', 'desc')->paginate(10);
        return response()->json($asistencia);
    }
    
    public function getAsistencia($id)
    {
        Log::info("Recibida solicitud para Asistencia con ID: {$id}");

        $asistencia = AsistenciaHora::with(['frente', 'detalles.operador', 'detalles.contratista'])->findOrFail($id);

        return response()->json($asistencia);
    }

    public function guardarAsistencia(Request $request)
    {
        Log::info('Registro de asistencia recibido:', [
            'data' => $request->all()
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

    public function updateAsistencia(Request $request, $id)
    {
        $asistenciaHora = AsistenciaHora::findOrFail($id);
        Log::info('Actualizando asistencia con ID:', ['id' => $id, 'data' => $request->all()]);
        AsistenciaDetalle::where('asistencia_horas_id', $id)->delete();
        $asistenciaHora->fecha = $request->fecha;
        $asistenciaHora->frente_id = $request->frente_id;
        $asistenciaHora->save();

        foreach ($request->detalles as $detalle) {
            $nuevoDetalle = new AsistenciaDetalle([
                'asistencia_horas_id' => $asistenciaHora->id,
                'operador_id' => $detalle['operador']['id'],
                'entrada' => $detalle['entrada'],
                'salida' => $detalle['salida'],
                'contratista_id' => $detalle['contratista']['id'],
                'parte' => $detalle['parte'],
            ]);
            $nuevoDetalle->save();
        }

        return response()->json(['message' => 'Asistencia actualizada con éxito!', 'data' => $asistenciaHora]);
    }

    public function getAsistenciaAgrupadaPorOperador(Request $request)
{
    $year = $request->year;
    $month = $request->month;
    $frenteId = $request->frent_id;

    $asistenciaHoras = AsistenciaHora::with(['detalles.operador'])
        ->whereYear('fecha', $year)
        ->whereMonth('fecha', $month)
        ->where('frente_id', $frenteId)
        ->get();

    if ($asistenciaHoras->isEmpty()) {
        return response()->json(['message' => 'No se encontraron datos para la fecha y frente seleccionados.'], 404);
    }

    $diasDelMes = $this->calcularDiasDelMes($year, $month);
    $horasDiariasLaborables = Frentes::find($frenteId)->horas_diarias_laborables;
    $resumenOperarios = $this->calcularHorasTrabajadas($asistenciaHoras, $diasDelMes, $horasDiariasLaborables);

    $mes = Carbon::createFromFormat('Y-m', "$year-$month")->format('m-Y');
    $operadorControl = OperadorControl::where('frente_id', $frenteId)
        ->where('mes', $mes)
        ->get()
        ->keyBy('operador_id');

    foreach ($resumenOperarios as &$operador) {
        $operadorId = $operador['operador']['id'];
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
            } else {
                if ($control->servicios_extras_s1 !== null) {
                    $operador['serviciosExtrasS1'] = $control->servicios_extras_s1;
                    $operador['pagoS1'] = true;
                }
                if ($control->servicios_extras_s2 !== null) {
                    $operador['serviciosExtrasS2'] = $control->servicios_extras_s2;
                    $operador['pagoS2'] = true;
                }
                if ($control->servicios_extras_s3 !== null) {
                    $operador['serviciosExtrasS3'] = $control->servicios_extras_s3;
                    $operador['pagoS3'] = true;
                }
                if ($control->servicios_extras_s4 !== null) {
                    $operador['serviciosExtrasS4'] = $control->servicios_extras_s4;
                    $operador['pagoS4'] = true;
                }
                if ($control->servicios_extras_s5 !== null) {
                    $operador['serviciosExtrasS5'] = $control->servicios_extras_s5;
                    $operador['pagoS5'] = true;
                }
            }
        }
    }

    return response()->json([
        'diasDelMes' => $diasDelMes,
        'asistencias' => $resumenOperarios
    ]);
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
            $frenteId = $asistenciaHora->frente_id;
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
                    'serviciosExtrasS2' => 0,
                    'serviciosExtrasS3' => 0,
                    'serviciosExtrasS4' => 0,
                    'serviciosExtrasS5' => 0,
                    'pagoS1' => false,
                    'pagoS2' => false,
                    'pagoS3' => false,
                    'pagoS4' => false,
                    'pagoS5' => false,
                    'pagosExtMensual' => false
                ];
            }

            if ($this->esFeriado($fecha, $diasDelMes['feriadosArray']) && $detalle->contratista_id === null) {
                if ($frenteId != 2 || ($frenteId == 2 && $localNeuquen == 1)) {
                    $resumenOperarios[$operadorId]['feriados']++;
                }
            } elseif ($fecha->isSaturday() && $detalle->contratista_id === null) {
                if ($frenteId != 2 || ($frenteId == 2 && $localNeuquen == 1)) {
                    $resumenOperarios[$operadorId]['sabados']++;
                }
            } elseif ($fecha->isSunday() && $detalle->contratista_id === null) {
                if ($frenteId != 2 || ($frenteId == 2 && $localNeuquen == 1)) {
                    $resumenOperarios[$operadorId]['domingos']++;
                }
            }

            if ($detalle->contratista_id !== null) {
                $resumenOperarios[$operadorId]["serviciosExtrasS$semanaDelMes"]++;
            } else {
                if ($horasTrabajadas > $horasDiariasLaborables && $frenteId != 2) {
                    $resumenOperarios[$operadorId]['horasExtras'] += $horasTrabajadas - $horasDiariasLaborables;
                }

                if (!$this->esFeriado($fecha, $diasDelMes['feriadosArray']) && !$fecha->isSaturday() && !$fecha->isSunday()) {
                    $resumenOperarios[$operadorId]['diasHabiles']++;
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

private function calcularDiasDelMes($year, $month)
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
    $inicioSemana = $inicioMes->copy()->startOfWeek(Carbon::SATURDAY);

    $finMes = Carbon::create($year, $month, $totalDias);
    $finSemana = $finMes->copy()->endOfWeek(Carbon::FRIDAY);

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

        $semanaInicio = $fecha->copy()->startOfWeek(Carbon::SATURDAY);
        $semanaFin = $fecha->copy()->endOfWeek(Carbon::FRIDAY);

        if (!isset($semanas[$semanaInicio->weekOfYear])) {
            $semanas[$semanaInicio->weekOfYear] = [
                'inicio' => $semanaInicio->toDateString(),
                'fin' => $semanaFin->toDateString()
            ];
        }
    }

    return [
        'diasHabiles' => $diasHabiles,
        'sabados' => $sabados,
        'domingos' => $domingos,
        'feriados' => $feriadosCount,
        'feriadosArray' => $feriadosArray,
        'semanas' => array_values($semanas)
    ];
}

private function getFeriados($year)
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


private function esFeriado($fecha, $feriados)
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
                    'mes' => $mes
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
                    ];
                } else {
                    if ($operador['pagoS1']) {
                        $values['servicios_extras_s1'] = $operador['serviciosExtrasS1'];
                    }
                    if ($operador['pagoS2']) {
                        $values['servicios_extras_s2'] = $operador['serviciosExtrasS2'];
                    }
                    if ($operador['pagoS3']) {
                        $values['servicios_extras_s3'] = $operador['serviciosExtrasS3'];
                    }
                    if ($operador['pagoS4']) {
                        $values['servicios_extras_s4'] = $operador['serviciosExtrasS4'];
                    }
                    if ($operador['pagoS5']) {
                        $values['servicios_extras_s5'] = $operador['serviciosExtrasS5'];
                    }
                }

                // Crear o actualizar el registro
                OperadorControl::updateOrCreate($attributes, $values);
            }
        }

        return response()->json(['success' => 'Pagos guardados con éxito']);
    }
}