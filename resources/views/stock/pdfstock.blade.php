<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimientos - {{ $productos->descripcion }}</title>
    <style>
    body {
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
</style>
</head>
<body>
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
    <div style="height: 3px;background-color:rgb(255,204, 0);margin-top:10px;">
    </div>
    <table style="margin-top:20px;">
        <tbody>
            <tr>
                <td><b>&nbsp;</b></td>
                <td style="font-size:18px"><b>Desde</b></td>
            </tr>
            <tr>
                <td><b>&nbsp;</b></td>
                <td><p>{{ $fechaInicioFormato }}</p></td>
            </tr>
        </tbody>
    </table>
    <div style="height: 3px;background-color:rgb(255,204, 0);margin-top:10px;">
    </div>
    
    <div class="box">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Movimiento</th>   
                    <th>Observaciones</th>  
                    <th>Cantidad</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($stock->fecha)->format('Y-m-d') }}</td>
                        <td>{{ $productos->descripcion }}</td>
                        <td>{{ $stock->tipo_movimiento }}</td>
                        <td>{{ $stock->obs }}</td>
                        <td>{{ $stock->cantidad }}</td>
                        <td>{{ $stock->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
<script type="text/php">

if ( isset($pdf) ) {
        $x = 734;
        $y = 48;
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
</html>