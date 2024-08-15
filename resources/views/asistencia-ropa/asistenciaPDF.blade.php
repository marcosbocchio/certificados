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
    @php
        $chunks = array_chunk($operarios, 12);
    @endphp

    @foreach($chunks as $chunk)
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
            <table class="info-table">
                <tr>
                    <td width="343px"><strong>Frente:</strong> {{ $frente->codigo }}</td>
                    <td width="352px"><strong>Mes y Año:</strong> {{ $mes }} / {{ $año }}</td>
                    <td><strong>Días Hábiles del Mes:</strong> {{ $diasDelMes['diasHabiles'] }}</td>
                </tr>
            </table>
        </header>

        <main>
            <table class="table">
                <thead>
                    <tr>
                        <th width="100px">Operario</th>
                        <th width="20px">Días Háb.</th>
                        <th width="20px">Sáb.</th>
                        <th width="20px">Dom.</th>
                        <th width="20px">Fer.</th>
                        <th width="20px">Hs. Ext.</th>
                        <th width="20px">S.E S1</th>
                        <th width="52px">Pago S1</th>
                        <th width="20px">S.E S2</th>
                        <th width="52px">Pago S2</th>
                        <th width="20px">S.E S3</th>
                        <th width="52px">Pago S3</th>
                        <th width="20px">S.E S4</th>
                        <th width="53px">Pago S4</th>
                        <th width="20px">S.E S5</th>
                        <th width="55px">Pago S5</th>
                        <th width="52px">Pago Mes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chunk as $operario)
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

        @if(!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach

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