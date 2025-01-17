<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Asistencia</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }

        .header-table, .info-table, .content-table, .totals-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .logo img {
            height: auto;
            max-width: 180px;
            max-height: 60px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }

        .date {
            font-size: 10px;
            text-align: right;
        }

        .separator {
            height: 3px;
            background-color: rgb(255, 204, 0);
            margin-top: 10px;
        }

        .info-table td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
            font-weight: bold;
            background-color: #f2f2f2;
            font-size: 11px;
        }
        .info-table td:first-child {
            text-align: left;
        }
        .info-table td:last-child {
            text-align: right;
        }

        .content-table th, .content-table td, .totals-table th, .totals-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .content-table th {
            background-color: rgb(41, 128, 186);
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
        }

        .content-table tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .content-table tr:nth-child(even) {
            background-color: #ffffff;
        }

        .content-table td.highlight {
            background-color: #ffe58a; /* Color más suave para resaltar feriados */
        }

        .empty-cell {
            border: none;
            background-color: transparent;
        }

        .totals-table {
            margin-top: 10px;
        }

        .totals-table td {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        @page {
            margin: 10mm;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <table class="header-table">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('img/logo-enod-web.jpg') }}" alt="Logotipo ENOD">
                </td>
                <td class="title">CONTROL ASISTENCIA</td>
                <td class="date"><b>FECHA:</b> {{ $fecha }}</td>
            </tr>
        </table>
        <div class="separator"></div>
        <div class="content">
            <table class="info-table">
                <tr>
                    <td width="218px"><strong>Operador:</strong> {{ $operador->name }}</td>
                    <td width="294px"><strong>Frente:</strong> {{ $frente->codigo }}</td>
                    <td width="344px"><strong>Mes y Año:</strong> {{ $selectedMonth }} / {{ $selectedYear }}</td>
                    <td><strong>Días Hábiles del Mes:</strong> {{ $diasDelMes['diasHabiles'] }}</td>
                </tr>
            </table>
        </div>
    </header>

    <!-- Attendance Details -->
    @php
        function obtenerFechaPago($fechaAsistencia, $semanas) {
            foreach ($semanas as $semana) {
                if ($fechaAsistencia >= $semana['inicio'] && $fechaAsistencia <= $semana['fin']) {
                    return $semana['fecha_pago'] ?? '-';
                }
            }
            return '-';
        }

        $rowCount = 0;
        $rowsPerPage = 8;
        $totalServicioExtraNull = 0;
        $totalServicioExtraNotNull = 0;
    @endphp

    <!-- Tabla para contratista_id === null -->
    <div class="content">
        <h3>Horas Extras</h3>
        <table class="content-table">
            <thead>
                <tr>
                    <th width="70px">Día</th>
                    <th width="70px">Fecha</th>
                    <th width="70px">Responsabilidad</th>
                    <th width="120px">Hora Entrada</th>
                    <th width="120px">Hora Salida</th>
                    <th width="100px">Fecha Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultado as $asistencia)
                    @if($asistencia['contratista_id'] === null)
                        @php
                            // Determina si es un feriado para destacar la fila
                            $esFeriado = $asistencia['s_d_f_sn'] ? 'highlight' : '';
                            
                            // Obtiene la fecha de pago usando la función definida
                            $fechaPago = obtenerFechaPago($asistencia['fecha'], $diasDelMes['semanas']);
                        @endphp
                        <tr>
                        <td>
    {{ $diasEnEspanol[\Carbon\Carbon::parse($asistencia['fecha'])->format('l')] ?? \Carbon\Carbon::parse($asistencia['fecha'])->format('l') }}
</td>

                            <td class="{{ $esFeriado }}">{{ $asistencia['fecha'] }}</td>
                            <td>{{ $asistencia['ayudante_sn'] === 0 ? 'ayudante' : 'operador' }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $asistencia['entrada'])->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $asistencia['salida'])->format('H:i') }}</td>
                            <td>
                                @if ($asistencia['no_pagar'] == 1)
                                    Cancelado
                                @else
                                    {{ $asistencia['pago_e_sdf'] ?? $asistencia['pago_servicio_extra'] ?? $fechaPago }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        
    </div>

    <!-- Tabla para contratista_id !== null -->
    <div class="content">
        <h3>Servicios Extras</h3>
        <table class="content-table">
    <thead>
        <tr>
            <th width="70px">Día</th>
            <th width="70px">Fecha</th>
            <th width="70px">Responsabilidad</th>
            <th width="120px">Hora Entrada</th>
            <th width="120px">Hora Salida</th>
            <th width="120px">Cliente</th>
            <th width="100px">Parte</th>
            <th width="100px">Técnica</th>
            <th width="100px">Fecha Pago</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resultado as $asistencia)
            @if($asistencia['contratista_id'] !== null)
                @php
                    $esFeriado = $asistencia['s_d_f_sn'] ? 'highlight' : '';
                    $fechaPago = obtenerFechaPago($asistencia['fecha'], $diasDelMes['semanas']);
                            $responsabilidad = $asistencia['ayudante_sn'] === 1 ? 'Ayudante' : 'Operador';;
                           
                @endphp
                <tr>
                <td>
    {{ $diasEnEspanol[\Carbon\Carbon::parse($asistencia['fecha'])->format('l')] ?? \Carbon\Carbon::parse($asistencia['fecha'])->format('l') }}
</td>

                    <td class="{{ $esFeriado }}">{{ $asistencia['fecha'] }}</td>
                    <td>{{ $asistencia['ayudante_sn'] === 1 ? 'operador' : 'ayudante' }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $asistencia['entrada'])->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $asistencia['salida'])->format('H:i') }}</td>
                    <td>{{ $asistencia['contratista']['nombre_fantasia'] }}</td>
                    <td>{{ $asistencia['parte'] }}</td>
                    <td>{{ $asistencia['metodoEnsayo']['metodo'] ?? '-' }}</td>
                    <td>
                                @if ($asistencia['no_pagar'] == 1)
                                    Cancelado
                                @else
                                    {{ $asistencia['pago_e_sdf'] ?? $asistencia['pago_servicio_extra'] ?? $fechaPago }}
                                @endif
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $x = 755;
            $y = 55;
            $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 8;
            $color = array(0,0,0);
            $pdf->page_text($x, $y, $text, $font, $size, $color);
        }
    </script>
</body>
</html>