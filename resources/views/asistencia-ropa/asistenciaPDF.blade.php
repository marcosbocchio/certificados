<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AsistenciaPDF</title>
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
            text-align: center;
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
                <td class="date"><b>FECHA:</b> {{ date('d-m-Y') }}</td>
            </tr>
        </table>
        <div style="height: 3px; background-color: rgb(255,204, 0); margin-top: 10px;"></div>
    </header>

    <main>
        <table class="info-table">
            <tr>
                <td><strong>Frente:</strong> {{ $frente->codigo }}</td>
                <td><strong>Mes y Año:</strong> {{ $mes }} / {{ $año }}</td>
                <td><strong>Días Hábiles del Mes:</strong> {{ $diasDelMes['diasHabiles'] }}</td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Operario</th>
                    <th>Días Háb.</th>
                    <th>Sáb.</th>
                    <th>Dom.</th>
                    <th>Fer.</th>
                    <th>Hs. Ext.</th>
                    <th>S.E S1</th>
                    <th>Pago S1</th>
                    <th>S.E S2</th>
                    <th>Pago S2</th>
                    <th>S.E S3</th>
                    <th>Pago S3</th>
                    <th>S.E S4</th>
                    <th>Pago S4</th>
                    <th>S.E S5</th>
                    <th>Pago S5</th>
                    <th>Pago Mes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($operarios as $operario)
                <tr>
                    <td>
                        <div style="font-weight: bold; text-align: center; font-size: 10px;">
                            {{ $operario['operador']['name'] }}
                        </div>
                        <div style="text-align: center;font-size: 9px;">
                            {{ $operario['ayudante_sn'] }}
                        </div>
                    </td>
                    <td>{{ $operario['diasHabiles'] }}</td>
                    <td>{{ $operario['sabados'] }}</td>
                    <td>{{ $operario['domingos'] }}</td>
                    <td>{{ $operario['feriados'] }}</td>
                    <td>{{ $operario['horasExtras'] }}</td>
                    <td>{{ $operario['serviciosExtrasS1'] }}</td>
                    <td>{{ $operario['fecha_pago_s1'] ?? '-' }}</td>
                    <td>{{ $operario['serviciosExtrasS2'] }}</td>
                    <td>{{ $operario['fecha_pago_s2'] ?? '-' }}</td>
                    <td>{{ $operario['serviciosExtrasS3'] }}</td>
                    <td>{{ $operario['fecha_pago_s3'] ?? '-' }}</td>
                    <td>{{ $operario['serviciosExtrasS4'] }}</td>
                    <td>{{ $operario['fecha_pago_s4'] ?? '-' }}</td>
                    <td>{{ $operario['serviciosExtrasS5'] }}</td>
                    <td>{{ $operario['fecha_pago_s5'] ?? '-' }}</td>
                    <td>{{ $operario['fecha_pago_mes'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>