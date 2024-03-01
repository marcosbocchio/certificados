<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Stock de Productos</title>
    <style>
        main {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 10px; /* Ajustar el tamaño de la fuente general */
        color: #333; /* Color de texto general */
        margin: 0;
        padding: 0;
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
    }.table td.align-right {
    text-align: right;
    }
    .table th.align-right {
    text-align: right;
    }.table tr {
    page-break-inside: avoid;
    }
    </style>
</head>
<main>
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="Logotipo ENOD">
            </td>
            <td class="title">
                Stock de Productos
            </td>
            <td class="date">
                <b>FECHA:</b> {{ date('d-m-Y') }}
            </td>
        </tr>
    </table>
    <div style="height: 3px;background-color:rgb(255,204, 0);margin-top:10px;">
    </div>
    <div class="box">
        <table class="table">
            <thead>
                <tr width='100%;'>
                    <th width='20%;'>Código</th>
                    <th width='60%;'>Descripción</th>
                    <th width='20%;' class="align-right">Stock</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td class="align-right">{{ $producto->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 487;
        $y = 43;
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
