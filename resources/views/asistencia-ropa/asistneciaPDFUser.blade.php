<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Asistencia</title>
    <style>

@font-face {
        font-family: 'fontawesome';
        src: url('fonts/fontawesome-webfont.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
    .fa {
        font-family: 'fontawesome';
    }

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
                    <td width="303px"><strong>Operador:</strong> {{ $operador->name }}</td>
                    <td width="230px"><strong>Frente:</strong> {{ $frente->codigo }}</td>
                    <td width="230px"><strong>Mes y Año:</strong> {{ $selectedMonth }} / {{ $selectedYear }}</td>
                    <td><strong>Días Hábiles del Mes:</strong> {{ $diasDelMes['diasHabiles'] }}</td>
                </tr>
            </table>
        </div>
    </header>

    <!-- Attendance Details -->
    <div class="content">
    @php
        // Declaramos la función obtenerFechaPago
        function obtenerFechaPago($fechaAsistencia, $semanas) {
            foreach ($semanas as $semana) {
                if ($fechaAsistencia >= $semana['inicio'] && $fechaAsistencia <= $semana['fin']) {
                    return $semana['fecha_pago'] ?? '-'; // Retorna la fecha de pago o '-' si no está disponible
                }
            }
            return '-'; // Si no coincide con ninguna semana
        }

        $rowCount = 0;
        $rowsPerPage = 14; // Número de filas por página
        $totalHorasTrabajadas = 0;
        $totalHorasExtras = 0;
        $totalServicioExtra = 0;
    @endphp

    <table class="content-table">
        <thead>
            <tr>
                <th width="70px">Día</th>
                <th width="70px">Fecha</th>
                <th width="120px">Horas Trabajadas</th>
                <th width="120px">Horas Extras</th>
                <th width="120px">Servicio Extra</th>
                <th width="100px">Fecha Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultado as $dia => $asistencias)
                @foreach($asistencias as $index => $asistencia)
                    @php
                        $esFeriado = $asistencia['feriado_sn'] ? 'highlight' : '';
                        $horasExtras = $asistencia['hora_extras'];
                        $servicioExtra = $asistencia['servicio_extra'] ?? '-';
                        $totalHorasExtras += $asistencia['hora_extras'];
                        $totalServicioExtra += $asistencia['servicio_extra'] ? 1 : 0;

                        // Obtenemos la fecha de pago usando la función
                        $fechaPago = obtenerFechaPago($asistencia['fecha'], $diasDelMes['semanas']);
                        $fechaPago = date('Y-m-d', strtotime($asistencia['fecha']));
                    @endphp
                    @if($index === 0) <!-- Mostrar el día solo en la primera fila de ese día -->
                        <tr>
                            <td>{{ $dia }}</td>
                            <td class="{{ $esFeriado }}">{{ $asistencia['fecha'] }}</td>
                            <td>{{ $asistencia['horas_trabajadas'] }}</td>
                            <td style="text-align: center;">
                                @if($asistencia['hora_extra_sn'])
                                    <span style="padding-left: 85px;">&#10004;</span> <!-- Checkmark -->
                                @else
                                    <span style="padding-left: 85px;">&#10008;</span> <!-- Cross -->
                                @endif
                            </td>
                            <td>{{ $asistencia['servicio_extra'] != '-' ? $asistencia['parte'] ?? '-' : '-' }}</td>
                            <td>{{ $fechaPago }}</td> <!-- Mostrar la fecha de pago -->
                        </tr>
                    @else
                        <tr>
                            <td class="empty-cell"></td>
                            <td class="{{ $esFeriado }}">{{ $asistencia['fecha'] }}</td>
                            <td>{{ $asistencia['horas_trabajadas'] }}</td>
                                <td style="text-align: center;">
                                    @if($asistencia['hora_extra_sn'])
                                        <span style="padding-left: 85px;">&#10004;</span> <!-- Checkmark -->
                                    @else
                                        <span style="padding-left: 85px;">&#10008;</span> <!-- Cross -->
                                    @endif
                                </td>
                            <td>{{ $asistencia['servicio_extra'] != '-' ? $asistencia['parte'] ?? '-' : '-' }}</td>
                            <td>{{ $fechaPago }}</td> <!-- Mostrar la fecha de pago -->
                        </tr>
                    @endif

                    @php $rowCount++; @endphp

                    @if($rowCount % $rowsPerPage === 0) <!-- Dividir tabla cada 14 filas -->
                        </tbody>
                    </table>
                    
                    <!-- Repetir el encabezado -->
                    <div style="page-break-before: always;"></div> <!-- Opcional: para forzar una nueva página -->
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
                            <td width="303px"><strong>Operador:</strong> {{ $operador->name }}</td>
                            <td width="230px"><strong>Frente:</strong> {{ $frente->codigo }}</td>
                            <td width="230px"><strong>Mes y Año:</strong> {{ $selectedMonth }} / {{ $selectedYear }}</td>
                            <td><strong>Días Hábiles del Mes:</strong> {{ $diasDelMes['diasHabiles'] }}</td>
                        </tr>
                        </table>
                        </div>
                    </header>
                    <table class="content-table">
                        <thead>
                        <tr>
                            <th width="70px">Día</th>
                            <th width="70px">Fecha</th>
                            <th width="120px">Horas Trabajadas</th>
                            <th width="120px">Horas Extras</th>
                            <th width="120px">Servicio Extra</th>
                            <th width="100px">Fecha Pago</th>
                        </tr>
                        </thead>
                        <tbody>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>

    <!-- Tabla de Totales -->
    <table class="totals-table">
        <tr>
            <td width="110px"><strong>Total</strong></td>
            <td width="110px">&nbsp;</td>
            <td width="183px">&nbsp;</td>
            <td width="183px">&nbsp;</td>
            <td>{{ $totalServicioExtra }}</td>
            <td width="153px">&nbsp;</td>
        </tr>
    </table>
</div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 755;
            $y = 55;
            $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>
</html>