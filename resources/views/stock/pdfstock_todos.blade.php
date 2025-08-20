<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Stock de Productos</title>
    <style>
        @page {
            /* Dejamos espacio en el margen superior para el encabezado fijo */
            margin: 85px 25px 40px 25px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }

        header {
            position: fixed;
            top: -75px; /* Posicionamos el encabezado en el margen superior */
            left: 0px;
            right: 0px;
            height: 70px;
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
        .table{
            margin-top: 15px; /* Espacio entre tablas de diferentes grupos */
            border-collapse: collapse;
            page-break-inside: auto; /* Permite que la tabla se divida entre páginas */
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: none;
        }
        /* === SELECTOR CORREGIDO === */
        /* Este estilo ahora solo se aplica a los th dentro de la fila con la clase .column-headers */
        .table thead .column-headers th {
            background-color: rgb(41,128,186);
            color: #ffffff;
        }
        .table thead {
            display: table-header-group;
        }
        .table tbody tr {
            page-break-inside: avoid; /* Intenta no cortar una fila por la mitad */
        }
        .table tbody tr:nth-child(odd) {
            background-color: #F2F2F2;
        }
        /* Se eliminó !important ya que no hay conflicto */
        .group-subtitle-cell {
            font-size: 14px;
            font-weight: bold;
            padding: 10px 0;
            background-color: #e9ecef;
            color: #333;
            text-align: center;
        }
        .align-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- El encabezado ahora está FUERA del bucle y se repetirá en cada página gracias al CSS -->
    <header>
        <table class="header-table">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('img/logo-enod-web.jpg') }}" alt="Logotipo ENOD">
                </td>
                <td class="title">Stock de Productos</td>
                <td class="date"><b>FECHA:</b> {{ $fecha }}</td>
            </tr>
        </table>
        <div style="height: 3px; background-color: rgb(255,204, 0); margin-top: 10px;"></div>
    </header>

    <main>
        <!-- El bucle principal recorre los grupos -->
        @foreach ($productosAgrupados as $nombreDelGrupo => $productosDelGrupo)
            <!-- Ahora creamos una tabla por cada grupo -->
            <table class="table">
                <thead>
                    <!-- Fila 1 del encabezado: Título del Grupo -->
                    <tr>
                        <th colspan="3" class="group-subtitle-cell">
                            {{ $nombreDelGrupo }}
                        </th>
                    </tr>
                    <!-- Fila 2 del encabezado: Títulos de las Columnas -->
                    <!-- === CLASE AÑADIDA AQUÍ === -->
                    <tr class="column-headers">
                        <th>Código</th>
                        <th>Descripción</th>
                        <th class="align-right">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- El segundo bucle recorre los productos de este grupo específico -->
                    @foreach ($productosDelGrupo as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td class="align-right">{{ $producto->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </main>

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 492;
            $y = 43;
            $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;
            $char_space = 0.0;
            $angle = 0.0;
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>
</html>
