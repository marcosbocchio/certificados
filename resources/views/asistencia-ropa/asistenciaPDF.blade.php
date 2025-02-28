<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Asistencia</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header-table, .table, .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo img {
            height: auto;
            max-width: 180px;
            max-height: 60px;
        }
        .underline {
            text-decoration: underline;
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
        .table {
            margin-top: 10px;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #F2F2F2;
        }
        .info-table td {
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
        .dia-semana {
            background-color: #6BB5D9; /* Color para días de semana */
        }

        .sabado {
            background-color: #FFCC99; /* Color para sábados */
        }

        .domingo {
            background-color: #FFEB99; /* Color para domingos */
        }

        .feriado {
            background-color: #FF6666; /* Color para feriados */
        }

        @page {
            margin: 10mm;
        }
    </style>
</head>
<body>
@php
    // Convertimos el arreglo en una colección
    $asistenciaDatosCollection = collect($asistenciaDatos);
@endphp
<header>
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="{{ public_path('img/logo-enod-web.jpg') }}" alt="Logotipo ENOD">
            </td>
            <td class="title">CONTROL ASISTENCIA {{$modo}} </td>
            <td class="date"><b>FECHA:{{$fecha}}</b></td>
        </tr>
    </table>
    <div style="height: 3px; background-color: rgb(255,204, 0); margin-top: 10px;"></div>
    <table class="info-table">
        <tr>
            <td><strong>Frente:</strong> {{ $frente->codigo }}</td>
            <td><strong>Mes y Año:</strong> {{ $month }}/{{ $year }}</td>
            <td><strong>Días Hábiles del Mes:{{$diashabiles_mes}}</strong></td>
        </tr>
    </table>
</header>

@foreach ($asistenciaDatosCollection->chunk(25) as $asistenciaChunk) <!-- Dividir en grupos de 25 filas -->

<table class="table">
        <thead>
            <tr>
                <th>Operador</th>
                <th>Responsabilidad</th>
                @foreach ($diasDelMes as $dia)
                    <th 
                        class="
                            @if ($dia['domingo_sn']) domingo @endif
                            @if ($dia['sabado_sn']) sabado @endif
                            @if ($dia['feriado_sn']) feriado @endif
                            @if ($dia['dia_semana_sn']) dia-semana @endif
                        "
                    >
                        {{ $dia['dia'] }}
                    </th>
                @endforeach
                @if ($modo === 'Horas')
                <th>E</th>
                @endif
                @if ($modo === 'Servicios')
                    <th>SE</th>
                @endif
                @if ($modo === 'Horas')
                <th>S</th>
                <th>D/F</th>
                @endif
            </tr>
        </thead>
        <tbody>
                @foreach ($asistenciaChunk as $operador => $detalle)
                    <tr>
                    <td style="padding: 5px;">{{ explode('-', $operador)[0] }}</td>
                        <td style="padding: 5px;">{{ $detalle['responsabilidad'] }}</td>
                        @foreach ($diasDelMes as $index => $dia)
                        <td style="padding: 1px;" 
                        class="{{ ($detalle['dias'][$index]['detalle']['hora_extra_sn'] === 1 || $detalle['dias'][$index]['detalle']['s_d_f_sn'] === 1) ? 'underline' : '' }}"
                        >
                        @if (isset($detalle['dias'][$index]['merged_parte']))
                                {{ $detalle['dias'][$index]['merged_parte'] }}
                            @else
                                @php
                                    $valores = $obtenerValorDetalle($detalle['dias'][$index]['detalle'], $dia);
                                @endphp
                                @if (is_array($valores))
                                    @foreach ($valores as $valor)
                                        {{ trim($valor) }}<br>
                                    @endforeach
                                @else
                                    {{ $valores }}
                                @endif
                            @endif
                            @else
                                0
                            @endif
                        </td>
                    @endforeach
                    @if ($modo === 'Horas')
                        <td>
                            {{ $contarHoras($detalle['dias']) }}
                        </td>
                    @endif
                    @if ($modo === 'Servicios')
                    <td>{{ $contarParametros($detalle['dias'], 'contratista_id', 'conteo') }}</td>
                    @endif
                    @if ($modo === 'Horas')
                    <td>{{ $contarParametros($detalle['dias'], 'sabado', 'sumar') }}</td>
                    <td>{{ $contarParametros($detalle['dias'], 'domingo_feriado', 'sumar') }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Salto de página después de cada grupo de 25 filas, excepto el último -->
    @if (!$loop->last)
        <div style="page-break-after: always;"></div>
        
        <!-- Repetir cabecera en la siguiente página -->
        <table class="header-table">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('img/logo-enod-web.jpg') }}" alt="Logotipo ENOD">
                </td>
                <td class="title">CONTROL ASISTENCIA</td>
                <td class="date"><b>FECHA:{{$fecha}}</b></td>
            </tr>
        </table>
        <div style="height: 3px; background-color: rgb(255,204, 0); margin-top: 10px;"></div>
        <table class="info-table">
            <tr>
                <td><strong>Frente:</strong> {{ $frente->codigo }}</td>
                <td><strong>Mes y Año:</strong> {{ $month }}/{{ $year }}</td>
                <td><strong>Días Hábiles del Mes:{{$diashabiles_mes}}</strong></td>
            </tr>
        </table>
    @endif

@endforeach

</body>
</html>