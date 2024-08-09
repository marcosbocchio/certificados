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
        .header-table, .table {
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
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: rgb(41,128,186);
            color: #ffffff;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #F2F2F2;
        }
        .page-break {
            page-break-after: always;
        }
        @page {
            margin: 20mm;
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
    @php
        $data = $operarios; // Asegúrate de que $operarios es el array con los datos
        $chunkSize = 6; // Tamaño de cada bloque de datos
        $chunks = array_chunk($data, $chunkSize);
    @endphp

    @foreach($chunks as $index => $chunk)
        @php
            // Determinar el tamaño de las tablas en la página actual
            $table1 = array_slice($chunk, 0, 3);
            $table2 = array_slice($chunk, 3, 3);
        @endphp

        <!-- Tabla 1 -->
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    @foreach($table1 as $operario)
                        <th>
                            <div style="font-weight: bold; text-align: center; font-size: 12px;">
                                {{ $operario['operador']['name'] }}
                            </div>
                            <div style="text-align: center;font-size: 9px;">
                                {{ $operario['ayudante_sn'] }}
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Días Hábiles</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['diasHabiles'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Sábados</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['sabados'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Domingos</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['domingos'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Feriados</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['feriados'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Horas Extras</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['horasExtras'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Servicios Extras S1</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['serviciosExtrasS1'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Servicios Extras S2</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['serviciosExtrasS2'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Servicios Extras S3</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['serviciosExtrasS3'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Servicios Extras S4</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['serviciosExtrasS4'] }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Servicios Extras S5</td>
                    @foreach($table1 as $operario)
                        <td>{{ $operario['serviciosExtrasS5'] }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <!-- Tabla 2 (si existe) -->
        @if(count($table2) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        @foreach($table2 as $operario)
                            <th>
                                <div style="font-weight: bold; text-align: center; font-size: 12px;">
                                    {{ $operario['operador']['name'] }}
                                </div>
                                <div style="text-align: center;font-size: 9px;">
                                    {{ $operario['ayudante_sn'] }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Días Hábiles</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['diasHabiles'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Sábados</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['sabados'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Domingos</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['domingos'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Feriados</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['feriados'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Horas Extras</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['horasExtras'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Servicios Extras S1</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['serviciosExtrasS1'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Servicios Extras S2</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['serviciosExtrasS2'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Servicios Extras S3</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['serviciosExtrasS3'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Servicios Extras S4</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['serviciosExtrasS4'] }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Servicios Extras S5</td>
                        @foreach($table2 as $operario)
                            <td>{{ $operario['serviciosExtrasS5'] }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- Salto de página solo si hay más bloques para mostrar -->
        @if($index + 1 < count($chunks))
            <div class="page-break"></div>
            <!-- Insertar encabezado para las nuevas páginas -->
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
        @endif

    @endforeach
    </main>
</body>
</html>