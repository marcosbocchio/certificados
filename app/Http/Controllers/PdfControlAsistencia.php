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
    
        // Obtén los días del mes
        $diasDelMes = $this->getDiasDelMes($year, $month);
        $diashabiles_mes = $this->contarDiasHabil($diasDelMes);
        // Obtén los detalles agrupados de la asistencia
        $detallesAgrupados = $this->getDatosAsistencia($frenteId, $year, $month);
    
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
            'fecha' => now()->toDateString(),
            'obtenerValorDetalle' => function($detalle, $parametro) {
            return $this->obtenerValorDetalle($detalle, $parametro);
            },
            'contarParametros' => function($detalle, $parametro, $tipo) {
                return $this->contarParametros($detalle, $parametro, $tipo);
            }, // Fecha actual
        ])->setPaper('a3', 'landscape');
    
        // Mostrar el PDF en el navegador
        return $pdf->stream('asistencia-usuario.pdf');
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

    // Si contratista_id es null, verificar dia_semana_sn
    if ($parametro['dia_semana_sn'] === 1) {
        // Si es día de semana, miramos hora_extra_sn
        if (isset($detalle['hora_extra_sn']) && $detalle['hora_extra_sn'] === 1) {
            return '1'; // Mostrar 1 si tiene horas extra
        }
        return '0'; // Mostrar '0' si no tiene horas extra
    }

    // Si es fin de semana o feriado, miramos s_d_f_sn
    if ($parametro['dia_semana_sn'] === 0) {
        if (isset($detalle['s_d_f_sn']) && $detalle['s_d_f_sn'] === 1) {
            return '1'; // Mostrar el ícono si tiene S/D/F
        }
        return '0'; // Mostrar '0' si no tiene S/D/F
    }

    return '0'; // Por defecto mostramos '-'
}

protected function contarParametros($detalle, $parametro, $tipo)
{
    return collect($detalle)->reduce(function ($contador, $dia) use ($parametro, $tipo) {
        if ($dia && array_key_exists('parametros', $dia)) {
            $parametros = $dia['parametros']; // Accedemos a dia['parametros']

            // Para sumar horas extra (Hs. Ex)
            if ($tipo === 'sumar' && $parametro === 'hora_extra_sn' && $dia['detalle'][$parametro] == 1) {
                return $contador + 1; // Sumar solo los casos donde hora_extra_sn es 1
            }

            // Para contar contratistas (Sv. Ex)
            if ($tipo === 'conteo' && $parametro === 'contratista_id' && $dia['detalle'][$parametro] !== null) {
                return $contador + 1; // Contar solo si contratista_id no es null
            }

            // Para contar Sábados
            if ($tipo === 'sumar' && $parametro === 'sabado' && 
                $parametros['sabado_sn'] == 1 && 
                $dia['detalle']['s_d_f_sn'] == 1 &&
                $dia['detalle']['contratista_id'] === null) { // Verificación del contratista_id
                return $contador + 1; // Contamos como sábado
            }

            // Para contar Domingos y Feriados juntos
            if ($tipo === 'sumar' && $parametro === 'domingo_feriado' && 
                $dia['detalle']['s_d_f_sn'] == 1 &&
                $dia['detalle']['contratista_id'] === null) { // Verificación del contratista_id
                if ($parametros['domingo_sn'] == 1 || $parametros['feriado_sn'] == 1) {
                    return $contador + 1; // Contamos como domingo o feriado
                }
            }
        }
        return $contador;
    }, 0);
}

public function getDatosAsistencia($frenteId, $year, $month)
{
    // Crear la fecha en formato 'YYYY-MM'
    $fecha = sprintf('%04d-%02d', $year, $month);

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

    // Obtener los días del mes
    $diasDelMes = $this->getDiasDelMes($year, $month);

    // Formato de la fecha
    $formattedDate = sprintf('%04d-%02d', $year, $month);

    // Inicializar un array para almacenar los datos reorganizados
    $asistenciaReorganizada = [];

    // Iterar sobre cada operador en los detalles agrupados
    foreach ($detallesAgrupados as $operador => $asistencias) {
        // Inicializar una matriz para cada operador que contenga los días del mes
        $asistenciaReorganizada[$operador] = [];

        foreach ($diasDelMes as $dia) {
            // Convertir el día en el formato de fecha
            $fechaDelDia = sprintf('%s-%02d', $formattedDate, $dia['dia']); // Usa dia['dia']

            // Buscar si hay una entrada con la fecha que coincide con ese día
            $detalleDelDia = array_filter($asistencias->toArray(), function ($asistencia) use ($fechaDelDia) {
                return $asistencia['fechaAsignacion'] === $fechaDelDia;
            });

            // Si existe un detalle para ese día, lo guardamos junto con los parámetros; de lo contrario, devolvemos null
            if (!empty($detalleDelDia)) {
                // Tomar el primer resultado que coincida
                $detalleDelDia = reset($detalleDelDia);

                $asistenciaReorganizada[$operador][] = [
                    'detalle' => $detalleDelDia['detalle'],
                    'parametros' => [
                        'dia_semana_sn' => $dia['dia_semana_sn'],
                        'sabado_sn' => $dia['sabado_sn'],
                        'domingo_sn' => $dia['domingo_sn'],
                        'feriado_sn' => $dia['feriado_sn']
                    ]
                ];
            } else {
                // Si no hay coincidencia, devolvemos null
                $asistenciaReorganizada[$operador][] = null; // Si no hay coincidencia, devolvemos null
            }
        }
    }

    // Ordenar alfabéticamente por el nombre de los operadores
    ksort($asistenciaReorganizada);

    // Log de los datos reorganizados por operador y día
    Log::info('Datos reorganizados por operador y día:', $asistenciaReorganizada);

    // Devolver los detalles reorganizados
    return $asistenciaReorganizada; // Devuelve los datos reorganizados
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


    Log::info('Datos del mes:', $diasDelMes);

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

        // Agrupar las asistencias por día de la semana
        $resultado = [];
        foreach ($combinacion as $asistencia) {
            $fechaAsistencia = Carbon::parse($asistencia['fecha']);
            $horasTrabajadas = $this->calcularHorasTrabajadass($asistencia['entrada'], $asistencia['salida']);
            $feriadoSn = $this->esFeriado($fechaAsistencia, $feriados);
        
            // Obtener el día de la semana 
            $diaSemana = $fechaAsistencia->format('l');
            $diaSemanaEspanol = $diasEnEspanol[$diaSemana];
        
            // Calcular horasExtras basado en la presencia del contratista_id
            if ($asistencia['contratista_id'] !== null) {
                $horasExtras = 0; // Si hay contratista, no se consideran horas extras
            } else {
                $horasExtras = max(0, $horasTrabajadas - $horasDiariasLaborables);
            }
            
            // Si el frenteId es 2 y es un día laborable, establecer horas_trabajadas y hora_extras a 0
            if ($frenteId == 2 && in_array($diaSemanaEspanol, ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'])) {
                $horasTrabajadas = '-';
                $horasExtras = '-';
            }
        
            $resultado[$diaSemanaEspanol][] = [
                'fecha' => $fechaAsistencia->toDateString(),
                'entrada' => $asistencia['entrada'],
                'salida' => $asistencia['salida'],
                'pago_e_sdf' => $asistencia['pago_e_sdf'],
                'pago_servicio_extra' => $asistencia['pago_servicio_extra'],
                'contratista_id' => $asistencia['contratista_id'],
                'horas_trabajadas' => $horasTrabajadas,
                'hora_extras' => $horasExtras,
                'servicio_extra' => $asistencia['contratista_id'] ? 1 : 0,
                'feriado_sn' => $feriadoSn,
                'parte' => $asistencia['parte'],
                'hora_extra_sn' =>$asistencia['hora_extra_sn'],
            ];
        }
    
        // Ordenar días de la semana en español
        $ordenDiasSemana = [
            'Domingo', 'Sábado', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'
        ];

        uksort($resultado, function($a, $b) use ($ordenDiasSemana) {
            return array_search($a, $ordenDiasSemana) - array_search($b, $ordenDiasSemana);
        });


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

        // Opcional: Verificar el resultado
        Log::info(json_encode($diasDelMes) . '-----------------------------');
        // Generar PDF
        $pdf = PDF::loadView('asistencia-ropa.asistneciaPDFUser', [
            'resultado' => $resultado,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'frente' => $frente,
            'diasDelMes' => $diasDelMes,
            'fecha' => $fecha->toDateString(),
            'operador' => User::find($operadorId), 
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
        return AsistenciaDetalle::whereIn('asistencia_horas_id', $asistenciaHorasIds)
            ->where('operador_id', $operadorId)
            ->get();
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
                    'pago_e_sdf' => $detalleRelacion->pago_e_sdf,
                    'pago_servicio_extra' => $detalleRelacion->pago_servicio_extra,
                    'contratista_id' => $detalleRelacion->contratista_id,
                    'parte' => $detalleRelacion->parte,
                    'hora_extra_sn' =>$detalleRelacion->hora_extra_sn,
                ];
            }
        }

        return $resultado;
    }
    public function getAsistenciaAgrupadaPorOperador($year, $month, $frenteId)
    {
        $diasDelMes = $this->calcularDiasDelMes($year, $month);
    
        $asistenciaHoras = AsistenciaHora::with(['detalles.operador'])
            ->whereYear('fecha', $year)
            ->whereMonth('fecha', $month)
            ->where('frente_id', $frenteId)
            ->get();
    
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
            $responsabilidad = $this->obtenerResponsabilidad($operadorId, $month);
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
                    
                    // Formatear fechas sin hora
                    $operador['fecha_pago_s1'] = $control->fecha_pago_s1 ? Carbon::parse($control->fecha_pago_s1)->format('d-m-Y') : null;
                    $operador['fecha_pago_s2'] = $control->fecha_pago_s2 ? Carbon::parse($control->fecha_pago_s2)->format('d-m-Y') : null;
                    $operador['fecha_pago_s3'] = $control->fecha_pago_s3 ? Carbon::parse($control->fecha_pago_s3)->format('d-m-Y') : null;
                    $operador['fecha_pago_s4'] = $control->fecha_pago_s4 ? Carbon::parse($control->fecha_pago_s4)->format('d-m-Y') : null;
                    $operador['fecha_pago_s5'] = $control->fecha_pago_s5 ? Carbon::parse($control->fecha_pago_s5)->format('d-m-Y') : null;
                    $operador['fecha_pago_mes'] = $control->fecha_pago_mes ? Carbon::parse($control->fecha_pago_mes)->format('d-m-Y') : null;
                } else {
                    if ($control->servicios_extras_s1 !== null) {
                        $operador['serviciosExtrasS1'] = $control->servicios_extras_s1;
                        $operador['pagoS1'] = true;
                        $operador['fecha_pago_s1'] = $control->fecha_pago_s1 ? Carbon::parse($control->fecha_pago_s1)->format('d-m-Y') : null;
                    }
                    if ($control->servicios_extras_s2 !== null) {
                        $operador['serviciosExtrasS2'] = $control->servicios_extras_s2;
                        $operador['pagoS2'] = true;
                        $operador['fecha_pago_s2'] = $control->fecha_pago_s2 ? Carbon::parse($control->fecha_pago_s2)->format('d-m-Y') : null;
                    }
                    if ($control->servicios_extras_s3 !== null) {
                        $operador['serviciosExtrasS3'] = $control->servicios_extras_s3;
                        $operador['pagoS3'] = true;
                        $operador['fecha_pago_s3'] = $control->fecha_pago_s3 ? Carbon::parse($control->fecha_pago_s3)->format('d-m-Y') : null;
                    }
                    if ($control->servicios_extras_s4 !== null) {
                        $operador['serviciosExtrasS4'] = $control->servicios_extras_s4;
                        $operador['pagoS4'] = true;
                        $operador['fecha_pago_s4'] = $control->fecha_pago_s4 ? Carbon::parse($control->fecha_pago_s4)->format('d-m-Y') : null;
                    }
                    if ($control->servicios_extras_s5 !== null) {
                        $operador['serviciosExtrasS5'] = $control->servicios_extras_s5;
                        $operador['pagoS5'] = true;
                        $operador['fecha_pago_s5'] = $control->fecha_pago_s5 ? Carbon::parse($control->fecha_pago_s5)->format('d-m-Y') : null;
                    }
                }
            }
        }
    
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
