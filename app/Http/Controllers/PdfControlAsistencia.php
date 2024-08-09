<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\AsistenciaHora;
use App\AsistenciaDetalle;
use App\Frentes;
use App\FrenteOperador;
use App\User;
use App\Contratistas;
use App\OtOperarios;
use App\OperadorControl;
use App\Partes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class PdfControlAsistencia extends Controller
{
    public function imprimirAsistenciaResumen(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $frenteId = $request->input('frent_id');

        if (!$year || !$month || !$frenteId) {
            return response()->json(['error' => 'Faltan datos necesarios.'], 400);
        }

        // Llamar a getAsistenciaAgrupadaPorOperador con los parámetros necesarios
        $asistenciaAgrupada = $this->getAsistenciaAgrupadaPorOperador($year, $month, $frenteId);

        if ($asistenciaAgrupada->status() !== 200) {
            return $asistenciaAgrupada; // Propagar el error si ocurre
        }

        $asistencias = $asistenciaAgrupada->original['asistencias'];
        $diasDelMes = $asistenciaAgrupada->original['diasDelMes'];

        // Genera el PDF utilizando la vista 'asistencia-ropa.asistenciaPDF'
        $pdf = PDF::loadView('asistencia-ropa.asistenciaPDF', [
            'operarios' => $asistencias,
            'diasDelMes' => $diasDelMes
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('asistencia-resumen.pdf');
    }

    public function pdfUsuario($operadorId, $frenteId, $selectedDate)
    {
        // Recuperar los datos necesarios usando los parámetros
        $operador = User::find($operadorId);
        $frente = Frentes::find($frenteId);
    
        // Eliminar la parte problemática de la cadena de fecha
        $formattedDate = preg_replace('/\(.+\)/', '', $selectedDate);
    
        // Parsear y formatear la fecha para obtener solo el mes y año
        $fecha = Carbon::parse($formattedDate);
        $selectedMonth = $fecha->format('m');
        $selectedYear = $fecha->format('Y');
    
        // Buscar en asistencia_horas usando frenteId y filtrar por mes y año
        $asistenciaHoras = AsistenciaHora::where('frente_id', $frenteId)
            ->whereYear('fecha', $selectedYear)
            ->whereMonth('fecha', $selectedMonth)
            ->get();
    
        // Obtener los IDs de asistencia_horas
        $asistenciaHorasIds = $asistenciaHoras->pluck('id');
    
        // Buscar en asistencia_detalle usando asistencia_horas_id y operadorId
        $asistenciaDetalles = AsistenciaDetalle::whereIn('asistencia_horas_id', $asistenciaHorasIds)
            ->where('operador_id', $operadorId)
            ->get();
    
        // Crear un nuevo objeto que contenga los datos combinados
        $resultado = [];
    
        foreach ($asistenciaHoras as $asistencia) {
            // Asegurarse de que la fecha sea un objeto Carbon
            $fechaAsistencia = $asistencia->fecha instanceof Carbon ? $asistencia->fecha : Carbon::parse($asistencia->fecha);
    
            // Crear una estructura para cada asistencia
            $detalle = [
                'id' => $asistencia->id,
                'fecha' => $fechaAsistencia->format('Y-m-d'),
                'detalles' => []  // Para almacenar detalles relacionados
            ];
    
            // Obtener los detalles correspondientes a este asistenciaHoras
            $detallesRelacionados = $asistenciaDetalles->where('asistencia_horas_id', $asistencia->id);
    
            foreach ($detallesRelacionados as $detalleRelacion) {
                // Obtener el nombre del operador
                $operador = User::find($detalleRelacion->operador_id);
                $name = $operador ? $operador->name : 'N/A';
    
                // Agregar el detalle al arreglo de detalles
                $detalle['detalles'][] = [
                    'name' => $name,
                    'entrada' => $detalleRelacion->entrada,
                    'salida' => $detalleRelacion->salida,
                    'contratista_id' => $detalleRelacion->contratista_id
                ];
            }
    
            // Agregar al resultado final
            $resultado[] = $detalle;
        }
    
        // Mostrar la información obtenida para depuración
        dd($resultado);
    
        // Generar el PDF utilizando compact para pasar los datos a la vista
        $pdf = PDF::loadView('asistencia-ropa.asistenciaPDFUser', compact('operador', 'frente', 'fecha', 'resultado'));
    
        // Descargar o mostrar el PDF
        return $pdf->stream('asistencia-resumen-user.pdf');
    }

    public function getAsistenciaAgrupadaPorOperador($year, $month, $frenteId)
    {
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
                if ($this->esFeriado($fecha, $diasDelMes['feriadosArray']) && $detalle->contratista_id === null) {
                    $resumenOperarios[$operadorId]['feriados']++;
                }

                // Contar sábados
                if ($fecha->isSaturday() && $detalle->contratista_id === null) {
                    $resumenOperarios[$operadorId]['sabados']++;
                }

                // Contar domingos
                if ($fecha->isSunday() && $detalle->contratista_id === null) {
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

    private function esFeriado($fecha, $feriados)
    {
        return in_array($fecha->toDateString(), $feriados);
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

    private function getSemanaDelMes($fecha, $semanas)
    {
        foreach ($semanas as $index => $semana) {
            if ($fecha->between(Carbon::parse($semana['inicio']), Carbon::parse($semana['fin']))) {
                return $index + 1; // Retornar el índice de la semana (ajustado a 1 basado)
            }
        }
        return 0; // En caso de error
    }
}
