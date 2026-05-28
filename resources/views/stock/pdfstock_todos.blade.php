<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Stock de Productos</title>
    <style>
        @page {
            margin: 85px 25px 40px 25px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }

        header {
            position: fixed;
            top: -75px;
            left: 0;
            right: 0;
            height: 70px;
        }

        .header-table,
        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .logo img {
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
            margin-top: 15px;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        .table th,
        .table td {
            padding: 8px;
            word-wrap: break-word;
        }

        .table thead .column-headers th {
            background-color: rgb(41, 128, 186);
            color: #fff;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .group-subtitle-cell {
            font-size: 14px;
            font-weight: bold;
            padding: 10px 0;
            background: #e9ecef;
            text-align: left;
        }

        .col-codigo {
            width: 25%;
            text-align: left;
        }

        .col-descripcion {
            width: 55%;
            text-align: left;
        }

        .col-stock {
            width: 20%;
            text-align: left;
        }
    </style>
</head>

<body>

    <header>
        <table class="header-table">
            <tr>
                <td class="logo">
                    <img src="{{ public_path('img/logo-empresa.png') }}" alt="Logo">
                </td>
                <td class="title">Stock de Productos</td>
                <td class="date"><b>FECHA:</b> {{ $fecha }}</td>
            </tr>
        </table>
        <div style="height:3px;background:rgb(255,204,0);margin-top:10px;"></div>
    </header>

    <main>
        @foreach ($productosAgrupados as $nombreDelGrupo => $productosDelGrupo)
        <table class="table">
            <thead>
                <tr>
                    <th colspan="3" class="group-subtitle-cell">
                        {{ $nombreDelGrupo }}
                    </th>
                </tr>
                <tr class="column-headers">
                    <th class="col-codigo">Código</th>
                    <th class="col-descripcion">Descripción</th>
                    <th class="col-stock">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productosDelGrupo as $producto)
                <tr>
                    <td class="col-codigo">{{ $producto->codigo }}</td>
                    <td class="col-descripcion">{{ $producto->descripcion }}</td>
                    <td class="col-stock">{{ $producto->stock }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach
    </main>

    <script type="text/php">
        if (isset($pdf)) {
        $pdf->page_text(507, 40, "PAGINA : {PAGE_NUM} de {PAGE_COUNT}", $fontMetrics->get_font("serif","bold"), 8);
}
</script>

</body>

</html>
