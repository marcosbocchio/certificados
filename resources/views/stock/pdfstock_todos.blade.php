<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Stock de Productos</title>
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
        .table{
            margin-top: 10px;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: none;
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
    </style>
</head>
<main>
    @php $itemsPerPage = 30; @endphp
    @foreach ($productos->chunk($itemsPerPage) as $chunk)
        <header>
            <table class="header-table">
                <tr>
                    <td class="logo">
                        <img src="{{ public_path('img/logo-enod-web.jpg') }}" alt="Logotipo ENOD">
                    </td>
                    <td class="title">Stock de Productos</td>
                    <td class="date"><b>FECHA:</b> {{ date('d-m-Y') }}</td>
                </tr>
            </table>
            <div style="height: 3px; background-color: rgb(255,204, 0); margin-top: 10px;"></div>
        </header>
        <main>
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th class="align-right">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chunk as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td class="align-right">{{ $producto->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
        @if (!$loop->last)
            <div class="page-break"></div>
@endif
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
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        /* $pdf->line(34,167,561,167,array(0,0,0),1.5); */
    }

</script>
</html>
