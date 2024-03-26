<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimientos - {{ $productos->descripcion }}</title>
    <style>
        main {
            font-family: 'serif', 'Arial', serif;
            font-size: 12px; /* Ajustar el tamaño de la fuente general */
            color: #333; /* Color de texto general */
        }
        .header-table, .box {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .header-table td, .box td {
            padding: 5px;
        }
        .logo {
            width: 20%;
            padding-right: 10px;
        }
        .logo img {
            height: auto;
            width: 100%;
            max-width: 180px;
            max-height: 60px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            width: 80%;
        }
        .date {
            font-size: 10px;
            text-align: right;
            width: 20%;
        }
        .table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
            background-color: #ffffff;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border:none; /* Añadido para visualizar mejor las celdas */
        }
        .table th {
            background-color: rgb(41,128,186); /* Fondo azul para los encabezados de las columnas */
            color: #ffffff; /* Texto blanco para los encabezados */
            font-weight: bold;
        }
        .table tbody tr:nth-child(even) {
            background-color: #F2F2F2; /* Fondo en bandas de colores alternos */
        }
        .align-right {
            text-align: right;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<main>
    @php $itemsPerPage = 17; @endphp
    @foreach ($stocks->chunk($itemsPerPage) as $chunk)
        <table class="header-table">
                <tr>
                    <td class="logo">
                        <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="Logotipo ENOD">
                    </td>
                    <td class="title">
                        Movimientos - {{ $productos->descripcion }}
                    </td>
                    <td class="date">
                        <b>FECHA:</b> {{ $fecha }}
                    </td>
                </tr>
        </table>
        <div style="height: 3px;background-color:rgb(255,204, 0);"></div>
        <div class="box">
            <table class="table">
                <thead>
                    <tr>
                        <th width='10%;'>Fecha</th>
                        <th width='30%;'>Movimiento</th>
                        <th width='30%;'>Observaciones</th>
                        <th width='20%;'>Usuario</th>
                        <th width='5%;' class="align-right">Cantidad</th>
                        <th width='5%;' class="align-right">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chunk as $stock)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($stock->fecha)->format('Y-m-d') }}</td>
                            <td>{{ $stock->tipo_movimiento }}</td>
                            <td>{{ $stock->obs }}</td>
                            <td>{{ $stock->user->name ?? '-' }}</td>
                            <td class="align-right">{{ $stock->cantidad }}</td>
                            <td class="align-right">{{ $stock->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</main>
<script type="text/php">
    if ( isset($pdf) ) {
        $x = 737;
        $y = 47;
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