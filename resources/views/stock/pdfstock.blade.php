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
    .header-table {
        width: 100%;
        margin-bottom: 15px;
    }
    .header-table td {
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
        text-align: right;
        width: 30%;
    }
    .date {
        font-size: 10px;
        text-align: right;
        width: 30%;
    }
    .box {
        background: #ffffff;
        padding: 10px;
        margin: 0;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
    }
    .table th, .table td {
        padding: 8px;
        text-align: left;
    }
    .table th {
        background-color: rgb(41,128,186); /* Fondo azul para los encabezados de las columnas */
        color: #ffffff; /* Texto blanco para los encabezados */
        font-weight: bold;
    }
    .table tbody tr {
        background-color: #ffffff; /* Fondo blanco para las filas */
    }
    .table tbody tr:nth-child(even) {
        background-color: #F2F2F2; /* Fondo en bandas de colores alternos */
    }
    .table td.align-right {
        text-align: right;
    }
    .table th.align-right {
        text-align: right;
    }
    .table tr {
        page-break-inside: avoid;
    }
    #tablaEspecifica {
        margin: 2px;
        border-spacing: 0;
        border-collapse: collapse;
    }
    #tablaEspecifica td, #tablaEspecifica tr {
        padding: 0;
        font-size: 15px;
    }
    </style>
</head>
<body>
<main>
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
    <table id="tablaEspecifica">
        <tbody>
            <tr>
                <td><b>&nbsp;</b></td>
                <td><b>&nbsp;</b></td>
                <td style="font-size:15px;"><b>Desde</b></td>
            </tr>
            <tr>
                <td><b>&nbsp;</b></td>
                <td><b>&nbsp;</b></td>
                <td style="font-size:12px;">{{ $fechaInicioFormato }}</td>
            </tr>
        </tbody>
    </table>
    <div style="height: 3px;background-color:rgb(255,204, 0);"></div>
    <div class="box">
        <table class="table">
            <thead>
                <tr width='100%;'>
                    <th width='10%;'>Fecha</th>
                    <th width='40%;'>Movimiento</th>   
                    <th width='40%;'>Observaciones</th>  
                    <th width='5%;'class="align-right">Cantidad</th>
                    <th width='5%;'class="align-right">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($stock->fecha)->format('Y-m-d') }}</td>
                        <td>{{ $stock->tipo_movimiento }}</td>
                        <td>{{ $stock->obs }}</td>
                        <td class="align-right">{{ $stock->cantidad }}</td>
                        <td class="align-right">{{ $stock->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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

        /* $pdf->line(34,167,561,167,array(0,0,0),1.5); */

    }

</script>
</html>