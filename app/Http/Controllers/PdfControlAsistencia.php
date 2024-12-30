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
use DateTime;

class PdfControlAsistencia extends Controller
{
    public function imprimirAsistenciaResumen(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $frenteId = $request->input('frent_id');
        $modo = $request->input('modo');
        // Obtén los días del mes
        $diasDelMes = $this->getDiasDelMes($year, $month);
        $diashabiles_mes = $this->contarDiasHabil($diasDelMes);
        // Obtén los detalles agrupados de la asistencia
        $detallesAgrupados = $this->getDatosAsistencia($frenteId, $year, $month, $modo);
    
        // Establecer nombre del frente (esto debe cambiarse según tu lógica)
        $frente = Frentes::find($frenteId); // Cambia esto por el nombre real del frente que deseas mostrar
    
        // Generar PDF
        $pdf = PDF::loadView('asistencia-ropa.asistenciaPDF', [
            'asistenciaDatos' => $detallesAgrupados, // Asegúrate de que esto tenga el formato correcto
            'month' => $month,
            'year' => $year,
            'frente' => $frente,
            'diasDelMes' => $diasDelMes,
            'diashabiles_mes' => $diashabiles_mes,
            'modo' => $modo,
            'fecha' => now()->toDateString(),
            'obtenerValorDetalle' => function ($detalle, $parametro) {
                return $this->obtenerValorDetalle($detalle, $parametro);
            },
            'contarParametros' => function ($detalle, $parametro, $tipo) {
                return $this->contarParametros($detalle, $parametro, $tipo);
            },
            'contarHoras' => function ($dias) use ($frente) {
                return $this->contarHoras($dias, $frente); // Pasa $frente a la función contarHoras
            },
            'obtenerResponsabilidad' => function ($detalles) {
                return $this->obtenerResponsabilidad($detalles); // Llama a la nueva función
            },
        ])->setPaper('a3', 'landscape');
        
        // Mostrar el PDF en el navegador
        return $pdf->stream('asistencia-usuario.pdf');
        
    }

    public function contarHoras($dias, $frente)
    {
        $totalHorasExtras = 0;
        $horasLaborables = $frente->horas_diarias_laborables; // Usa el valor de horas laborales de $frente
    
        foreach ($dias as $dia) {
            // Verificar si el día debe ser considerado (basado en dia_semana_sn)
            if (isset($dia['dia_semana_sn']) && $dia['dia_semana_sn'] == 1) {
                // Verificar si el detalle tiene entrada, salida y condiciones adicionales
                if (
                    isset($dia['detalle']) && 
                    isset($dia['detalle']['entrada']) && 
                    isset($dia['detalle']['salida']) &&
                    (isset($dia['detalle']['hora_extra_sn']) && $dia['detalle']['hora_extra_sn'] === 1 || 
                     isset($dia['detalle']['s_d_f_sn']) && $dia['detalle']['s_d_f_sn'] === 1)
                ) {
                    $entrada = $this->convertirHoraADate($dia['detalle']['entrada']);
                    $salida = $this->convertirHoraADate($dia['detalle']['salida']);
        
                    // Calcular la diferencia entre las horas de entrada y salida
                    $intervalo = $salida->diff($entrada);
                    $horasTrabajadas = $intervalo->h + ($intervalo->i / 60); // Diferencia en horas (y minutos como fracción)
        
                    // Calcular las horas extras trabajadas
                    if ($horasTrabajadas > $horasLaborables) {
                        $totalHorasExtras += $horasTrabajadas - $horasLaborables;
                    }
                }
            }
        }
        // Devolver el resultado formateado
        return $this->formatearHorasExtras($totalHorasExtras);
    }
    

public function convertirHoraADate($hora)
{
    // Convertir una cadena "HH:mm:ss" a un objeto Date en PHP
    $horaParts = explode(":", $hora);
    $hora = (int)$horaParts[0];
    $minutos = (int)$horaParts[1];
    $segundos = isset($horaParts[2]) ? (int)$horaParts[2] : 0;

    $date = new \DateTime();
    $date->setTime($hora, $minutos, $segundos);
    
    return $date;
}

public function formatearHorasExtras($horasExtras)
{
    // Convertir un número decimal de horas extras a formato "HH:MM"
    $horas = floor($horasExtras);
    $minutos = round(($horasExtras - $horas) * 60);

    return sprintf("%02d:%02d", $horas, $minutos);
}

public function obtenerResponsabilidad($detalles)
{
    // Verificar si todos los detalles tienen ayudante_sn igual a 1
    $esAyudante = collect($detalles)->every(function ($detalle) {
        return $detalle['ayudante_sn'] === 1;
    });

    // Si todos tienen ayudante_sn igual a 1, devolver 'ayudante'; de lo contrario, 'operador'
    return $esAyudante ? 'ayudante' : 'operador';
}

   protected function obtenerValorDetalle($detalle, $parametro)
{
    // Verificar si contratista_id tiene valor
    if (isset($detalle['contratista_id']) && $detalle['contratista_id'] !== null) {
        // Si existe 'parte', separa por '-'
        if (isset($detalle['parte'])) {
            return explode('-', $detalle['parte']); // Retorna como un array
        }
    }

    if ($parametro['dia_semana_sn'] === 1) {
        // Convertimos las horas de entrada y salida a objetos DateTime
        $entrada = DateTime::createFromFormat('H:i:s', $detalle['entrada']);
        $salida = DateTime::createFromFormat('H:i:s', $detalle['salida']);

        // Calculamos la diferencia
        if ($entrada && $salida) {
            $intervalo = $entrada->diff($salida);

            // Formateamos la diferencia a horas y minutos
            $horasTrabajadas = $intervalo->format('%H:%I');

            return $horasTrabajadas; // Retornar horas trabajadas
        }

        return '0'; // En caso de error o datos faltantes
    }

    // Si es fin de semana o feriado, miramos s_d_f_sn
    if ($parametro['dia_semana_sn'] === 0) {
        if ($detalle) {
            return '1'; // Mostrar el ícono si tiene S/D/F
        }
        return '0'; // Mostrar '0' si no tiene S/D/F
    }

    return '0'; // Por defecto mostramos '-'
}

protected function contarParametros($detalle, $parametro, $tipo)
{
    return collect($detalle)->reduce(function ($contador, $dia) use ($parametro, $tipo) {
        // Si $dia es null o no contiene 'detalle', lo ignoramos
        if ($dia === null || !is_array($dia) || !array_key_exists('detalle', $dia)) {
            return $contador;
        }

        $detalleDia = $dia['detalle']; // Detalle del día actual

        // Logs para depuración


        // Contar contratistas
        if ($tipo === 'conteo' && $parametro === 'contratista_id') {
            if (!empty($detalleDia['contratista_id'])) {
                return $contador + 1;
            }
        }

        // Contar sábados
        if ($tipo === 'sumar' && $parametro === 'sabado') {
            if (!empty($dia['sabado_sn']) && $dia['sabado_sn'] == 1 &&
                !empty($detalleDia['s_d_f_sn']) && $detalleDia['s_d_f_sn'] == 1 &&
                empty($detalleDia['contratista_id'])) {
                return $contador + 1;
            }
        }

        // Contar domingos y feriados juntos
        if ($tipo === 'sumar' && $parametro === 'domingo_feriado') {
            if (!empty($detalleDia['s_d_f_sn']) && $detalleDia['s_d_f_sn'] == 1 &&
                empty($detalleDia['contratista_id']) &&
                (!empty($dia['domingo_sn']) || !empty($dia['feriado_sn']))) {
                return $contador + 1;
            }
        }

        return $contador;
    }, 0);
}



public function getDatosAsistencia($frenteId, $year, $month, $modo)
{
    $fecha = sprintf('%04d-%02d', $year, $month);

    $asistenciaHoras = AsistenciaHora::where('frente_id', $frenteId)
        ->where('fecha', 'like', $fecha . '%')
        ->get();

    $asistenciaHorasIds = $asistenciaHoras->pluck('id');
    $detallesAgrupados = AsistenciaDetalle::whereIn('asistencia_horas_id', $asistenciaHorasIds)
    ->when($modo === 'Horas', function ($query) {
        return $query->where(function ($query) {
            $query->whereNull('contratista_id')
                  ->orWhere('hora_extra_sn', 1)
                  ->orWhere('s_d_f_sn', 1);
        });
    })
        ->when($modo === 'Servicios', function ($query) {
            return $query->whereNotNull('contratista_id');
        })
        ->with(['operador', 'asistenciaHora', 'ayudante'])
        ->get()
        ->flatMap(function ($detalle) use ($modo) {
            $resultados = [];

            // Operador
            if ($detalle->operador) {
                $resultados[] = [
                    'detalle' => $detalle,
                    'fechaAsignacion' => $detalle->asistenciaHora->fecha,
                    'tipo' => 'operador',
                    'id' => $detalle->operador_id,
                    'name' => $detalle->operador->name,
                    'ayudante_sn' => $modo === 'Horas' ? $detalle->ayudante_sn : 1
                ];
            }

            // Ayudante
            if ($detalle->ayudante) {
                $resultados[] = [
                    'detalle' => $detalle,
                    'fechaAsignacion' => $detalle->asistenciaHora->fecha,
                    'tipo' => 'ayudante',
                    'id' => $detalle->ayudante_id,
                    'name' => $detalle->ayudante->name,
                    'ayudante_sn' => $modo === 'Horas' ? $detalle->ayudante_sn : 0
                ];
            }

            return $resultados;
        })
        ->groupBy(function ($detalle) {
            return $detalle['name'] . '-' . $detalle['tipo']; // Agrupa por ID y Tipo
        })
        ->map(function ($detalles) {
            return [
                'dias' => $detalles,
                'responsabilidadPorDia' => $detalles->mapWithKeys(function ($detalle) {
                    return [
                        $detalle['fechaAsignacion'] => $detalle['ayudante_sn'] === 0 ? 'ayudante' : 'operador'
                    ];
                }),
            ];
        });

    // Obtener los días del mes
    $diasDelMes = collect($this->getDiasDelMes($year, $month));
    $formattedDate = sprintf('%04d-%02d', $year, $month);

    // Reorganizar datos en la estructura final
    $asistenciaReorganizada = [];

    foreach ($detallesAgrupados as $clave => $data) {
        $asistenciaReorganizada[$clave] = [
            'dias' => [],
        ];

        foreach ($diasDelMes as $dia) {
            $fechaDelDia = sprintf('%s-%02d', $formattedDate, $dia['dia']);

            $detalleDelDia = collect($data['dias'])->firstWhere('fechaAsignacion', $fechaDelDia);

            // Asignar características del día al detalle
            if ($detalleDelDia) {
                $detalleDelDia['dia_semana_sn'] = $dia['dia_semana_sn'];
                $detalleDelDia['sabado_sn'] = $dia['sabado_sn'];
                $detalleDelDia['domingo_sn'] = $dia['domingo_sn'];
                $detalleDelDia['feriado_sn'] = $dia['feriado_sn'];
                $detalleDelDia['name'] = $detalleDelDia['name']; // Añade el nombre del operador/ayudante
            }

            $asistenciaReorganizada[$clave]['dias'][] = $detalleDelDia ?: null;
        }

        // Determinar responsabilidad principal
        $responsabilidad = $data['responsabilidadPorDia']->values()->contains('operador')
            ? 'operador'
            : 'ayudante';

        $asistenciaReorganizada[$clave]['responsabilidad'] = $responsabilidad;
    }

    log::debug($asistenciaReorganizada);
    ksort($asistenciaReorganizada);

    return $asistenciaReorganizada;
}




public function formatearDia($dia)
{
    $year = date('Y'); // Año actual
    $month = date('n'); // Mes actual (1-12)
    
    return sprintf('%04d-%02d-%02d', $year, $month, $dia);
}
public function getDiasDelMes($year, $month)
{
    // Llamamos a la función para obtener los feriados antes de calcular los días
    $feriados = $this->getFeriados($year);

    // Obtenemos el número de días del mes
    $numDias = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Número de días en el mes

    // Recorremos todos los días del mes
    $diasDelMes = [];
    for ($dia = 1; $dia <= $numDias; $dia++) {
        $fecha = new DateTime("$year-$month-$dia"); // Creamos la fecha completa
        $diaSemana = $fecha->format('w'); // 0 = domingo, 1 = lunes, ..., 6 = sábado
        $esFeriado = $this->esFeriado($fecha, $feriados); // Verificamos si es feriado

        // Creamos el objeto con todas las propiedades solicitadas
        $diasDelMes[] = [
            'dia' => $dia, // El día del mes (1, 2, 3, etc.)
            'dia_semana_sn' => $esFeriado ? 0 : ($diaSemana >= 1 && $diaSemana <= 5 ? 1 : 0), // 1 si es entre lunes y viernes y no es feriado, 0 si no
            'sabado_sn' => $diaSemana == 6 ? 1 : 0, // 1 si es sábado
            'domingo_sn' => $diaSemana == 0 ? 1 : 0, // 1 si es domingo
            'feriado_sn' => $esFeriado ? 1 : 0 // 1 si es feriado, 0 si no
        ];
    }

    // Retornamos los datos
    return $diasDelMes;
}

public function contarDiasHabil($diasDelMes)
{
    $diasHabil = 0;

    foreach ($diasDelMes as $dia) {
        // Sumar si es día hábil
        $diasHabil += $dia['dia_semana_sn'];
    }

    return $diasHabil;
}

    public function pdfUsuario($operadorId, $frenteId, $selectedDate)
    {
        // Configurar la localización de Carbon a español
        Carbon::setLocale('es');
        
        // Formatear la fecha usando el método definido
        $fecha = $this->formatFecha($selectedDate);
        $selectedMonth = $fecha->format('m');
        $selectedYear = $fecha->format('Y');
        
        // Obtener los feriados para el año seleccionado
        $feriados = $this->getFeriados($selectedYear);

        // Buscar el Frente usando el frenteId
        $frente = Frentes::find($frenteId);
        $horasDiariasLaborables = $frente->horas_diarias_laborables;

        // Obtener las horas de asistencia
        $asistenciaHoras = $this->obtenerAsistenciaHoras($frenteId, $selectedYear, $selectedMonth);
        $asistenciaHorasIds = $asistenciaHoras->pluck('id');
        $asistenciaDetalles = $this->obtenerAsistenciaDetalles($asistenciaHorasIds, $operadorId);

        // Combinar las asistencias con sus detalles
        $combinacion = $this->combinarAsistenciasYDetalles($asistenciaHoras, $asistenciaDetalles);

        // Mapeo de los días de la semana en inglés a español
        $diasEnEspanol = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ];



        $fechasOperador = OperadorControl::where('frente_id', $frenteId)
            ->where('operador_id', $operadorId)
            ->where('mes', $fecha->format('m-Y'))
            ->first();

        $diasDelMes = $this->calcularDiasDelMes($selectedYear, $selectedMonth);
        // Recorremos las semanas y asignamos las fechas de pago a las posiciones correspondientes
        for ($i = 0; $i < count($diasDelMes['semanas']); $i++) {
            switch ($i) {
                case 0:
                    $diasDelMes['semanas'][$i]['fecha_pago'] = $fechasOperador->fecha_pago_s1 ?? null;
                    break;
                case 1:
                    $diasDelMes['semanas'][$i]['fecha_pago'] = $fechasOperador->fecha_pago_s2 ?? null;
                    break;
                case 2:
                    $diasDelMes['semanas'][$i]['fecha_pago'] = $fechasOperador->fecha_pago_s3 ?? null;
                    break;
                case 3:
                    $diasDelMes['semanas'][$i]['fecha_pago'] = $fechasOperador->fecha_pago_s4 ?? null;
                    break;
                case 4:
                    $diasDelMes['semanas'][$i]['fecha_pago'] = $fechasOperador->fecha_pago_s5 ?? null;
                    break;
            }
        }
        log::info($combinacion);
        // Opcional: Verificar el resultado
        // Generar PDF
        $pdf = PDF::loadView('asistencia-ropa.asistneciaPDFUser', [
            'resultado' => $combinacion,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'frente' => $frente,
            'diasDelMes' => $diasDelMes,
            'fecha' => $fecha->toDateString(),
            'operador' => User::find($operadorId), 
            'diasEnEspanol' => $diasEnEspanol,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('asistencia-usuario.pdf');
    }

    private function calcularHorasTrabajadass($entrada, $salida)
    {
        // Convertir a instancias de Carbon si no lo son
        $entrada = $entrada instanceof Carbon ? $entrada : Carbon::parse($entrada);
        $salida = $salida instanceof Carbon ? $salida : Carbon::parse($salida);
    
        // Calcular la diferencia en minutos
        $diferenciaEnMinutos = $salida->diffInMinutes($entrada);
    
        // Convertir la diferencia a horas decimales y redondear a 2 decimales
        $diferenciaEnHorasDecimales = round($diferenciaEnMinutos / 60, 2);
    
        return $diferenciaEnHorasDecimales;
    }

    private function formatFecha($selectedDate)
    {
        // Eliminar la parte problemática de la cadena de fecha
        $formattedDate = preg_replace('/\(.+\)/', '', $selectedDate);

        // Parsear y formatear la fecha para obtener solo el mes y año
        return Carbon::parse($formattedDate);
    }

    private function obtenerAsistenciaHoras($frenteId, $selectedYear, $selectedMonth)
    {
        return AsistenciaHora::where('frente_id', $frenteId)
            ->whereYear('fecha', $selectedYear)
            ->whereMonth('fecha', $selectedMonth)
            ->get();
    }

    private function obtenerAsistenciaDetalles($asistenciaHorasIds, $operadorId)
    {
        $asistencias = AsistenciaDetalle::with('ayudante', 'metodoEnsayo', 'contratista') // Carga las relaciones necesarias
            ->whereIn('asistencia_horas_id', $asistenciaHorasIds)
            ->where(function ($query) use ($operadorId) {
                $query->where('operador_id', $operadorId)
                      ->orWhere('ayudante_id', $operadorId);
            })
            ->get();
    
        // Crear un nuevo conjunto de resultados modificados
        $resultados = $asistencias->map(function ($asistencia) use ($operadorId) {
            $asistenciaClone = clone $asistencia; // Clonamos el objeto para no modificar directamente el original
            if ($asistenciaClone->operador_id == $operadorId) {
                $asistenciaClone->ayudante_sn = 1; // Proviene de operador_id
            } elseif ($asistenciaClone->ayudante_id == $operadorId) {
                $asistenciaClone->ayudante_sn = 0; // Proviene de ayudante_id
            }
            return $asistenciaClone;
        });
    
        return $resultados;
    }
    
    

    private function combinarAsistenciasYDetalles($asistenciaHoras, $asistenciaDetalles)
    {
        $resultado = [];

        foreach ($asistenciaHoras as $asistencia) {
            $fechaAsistencia = $asistencia->fecha instanceof Carbon ? $asistencia->fecha : Carbon::parse($asistencia->fecha);

            // Obtener los detalles correspondientes a este asistenciaHoras
            $detallesRelacionados = $asistenciaDetalles->where('asistencia_horas_id', $asistencia->id);

            foreach ($detallesRelacionados as $detalleRelacion) {
                // Obtener el nombre del operador
                $operador = User::find($detalleRelacion->operador_id);
                $name = $operador ? $operador->name : 'N/A';
                
                // Crear un objeto plano con todos los datos
                $resultado[] = [
                    'id' => $asistencia->id,
                    'fecha' => $fechaAsistencia->format('Y-m-d'),
                    'name' => $name,
                    'entrada' => $detalleRelacion->entrada,
                    'salida' => $detalleRelacion->salida,
                    'contratista' => $detalleRelacion->contratista,
                    'pago_e_sdf' => $detalleRelacion->pago_e_sdf,
                    'ayudante' => $detalleRelacion->ayudante,
                    'metodoEnsayo'=> $detalleRelacion->metodoEnsayo,
                    'pago_servicio_extra' => $detalleRelacion->pago_servicio_extra,
                    'contratista_id' => $detalleRelacion->contratista_id,
                    'parte' => $detalleRelacion->parte,
                    'hora_extra_sn' =>$detalleRelacion->hora_extra_sn,
                    's_d_f_sn' =>$detalleRelacion->s_d_f_sn,
                    'ayudante_sn' =>$detalleRelacion->ayudante_sn,
                    'no_pagar' =>$detalleRelacion->no_pagar,
                ];
            }
        }

        return $resultado;
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

    private function esFeriado($fecha, $feriados)
    {
        // Utiliza el método format() para obtener la fecha en formato 'YYYY-MM-DD'
        $fechaFormateada = $fecha->format('Y-m-d');
        
        return in_array($fechaFormateada, $feriados);
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
