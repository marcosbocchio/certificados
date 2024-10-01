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
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: rgb(41,128,186);
            color: #ffffff;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #F2F2F2;
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
        @page {
            margin: 10mm;
        }
    </style>
</head>
<body>

<header>
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="{{ public_path('img/logo-enod-web.jpg') }}" alt="Logotipo ENOD">
            </td>
            <td class="title">CONTROL ASISTENCIA</td>
            <td class="date"><b>FECHA:</b></td>
        </tr>
    </table>
    <div style="height: 3px; background-color: rgb(255,204, 0); margin-top: 10px;"></div>
    <table class="info-table">
        <tr>
            <td><strong>Frente:</strong> {{ $frente }}</td>
            <td><strong>Mes y Año:</strong> {{ $month }}/{{ $year }}</td>
            <td><strong>Días Hábiles del Mes:</strong></td>
        </tr>
    </table>
</header>

<table class="table">
    <thead>
        <tr>
            <th>Operador</th>
            @foreach ($diasDelMes as $dia)
                <th>{{ $dia['dia'] }}</th>
            @endforeach
            <th>Hs. Ex</th>
            <th>Sv. Ex</th>
            <th>S/D/F</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($asistenciaDatos as $operador => $detalle)
        <tr>
            <td>{{ $operador }}</td>
            @foreach ($diasDelMes as $index => $dia)
                <td>
                    {{ isset($detalle[$index]) ? $obtenerValorDetalle($detalle[$index]['detalle'], $dia) : '-' }}
                </td>
            @endforeach
            <td>{{ $contarParametros($detalle, 'hora_extra_sn', 'sumar') }}</td>
            <td>{{ $contarParametros($detalle, 'contratista_id', 'conteo') }}</td>
            <td>{{ $contarParametros($detalle, 's_d_f_sn', 'sumar') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>