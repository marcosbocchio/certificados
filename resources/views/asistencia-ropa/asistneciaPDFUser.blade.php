<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Asistencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-table td {
            padding: 5px;
            vertical-align: top;
        }

        .logo img {
            width: 150px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .date {
            text-align: right;
            font-size: 16px;
        }

        .separator {
            height: 3px;
            background-color: rgb(255, 204, 0);
            margin-top: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .info-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .content-table th, .content-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .content-table th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .content-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .content-table tr:hover {
            background-color: #f1f1f1;
        }

        .content-table td {
            vertical-align: middle;
        }

        .content-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .highlight {
            background-color: yellow;
        }

        .empty-cell {
            border: none;
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
    </header>

    <!-- Summary Info -->
    <div class="content">
        <h2 class="content-title">Detalles del Operador</h2>
        <table class="info-table">
            <tr>
                <td><strong>Frente:</strong> {{ $frente->codigo }}</td>
                <td><strong>Mes y Año:</strong> {{ $selectedMonth }} / {{ $selectedYear }}</td>
                <td><strong>Días Hábiles del Mes:</strong> {{ $diasDelMes['diasHabiles'] }}</td>
            </tr>
        </table>
    </div>

    <!-- Attendance Details -->
    <div class="content">
        <h2 class="content-title">Detalles de Asistencia</h2>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Fecha</th>
                    <th>Horas Trabajadas</th>
                    <th>Horas Extras</th>
                    <th>Servicio Extra</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $fechaMostrada = '';
                @endphp
                @foreach($resultado as $dia => $asistencias)
                    @foreach($asistencias as $index => $asistencia)
                        @php
                            $fechaActual = $asistencia['fecha'];
                            $esFeriado = $asistencia['feriado_sn'] ? 'highlight' : '';
                            $horasExtras = $asistencia['hora_extras'] > 0 ? $asistencia['hora_extras'] : '';
                            $servicioExtra = $asistencia['servicio_extra'] ? $asistencia['servicio_extra'] : '';
                        @endphp
                        @if($index === 0) <!-- Mostrar el día solo en la primera fila de ese día -->
                            <tr>
                                <td>{{ $dia }}</td>
                                <td class="{{ $esFeriado }}">{{ $fechaActual }}</td>
                                <td>{{ $asistencia['horas_trabajadas'] }}</td>
                                <td>{{ $horasExtras }}</td>
                                <td>{{ $servicioExtra }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="empty-cell"></td>
                                <td class="{{ $esFeriado }}">{{ $fechaActual }}</td>
                                <td>{{ $asistencia['horas_trabajadas'] }}</td>
                                <td>{{ $horasExtras }}</td>
                                <td>{{ $servicioExtra }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>