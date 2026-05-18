<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>
    @page {
        margin: 150px 40px 230px 40px !important;
        padding: 0px 0px 0px 0px !important;
    }

    header {
        position: fixed;
        top: -135px;
    }

    footer {
        position: fixed;
        bottom: 20px;
        padding-top: 0px;
    }

    .page-break {
        page-break-before: always;
    }
</style>

<body>
<header>
    @include('reportes.partial.header-principal-landscape')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.partial.header-cliente-comitente-landscape')
    @include('reportes.partial.linea-gris')
    @include('reportes.partial.header-proyecto-landscape')
    @include('reportes.partial.linea-amarilla')
</header>
<footer>
    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.rd-diccionario', ['dictionaryFontSize' => 9, 'showObservaciones' => true])
    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.firmas')
</footer>


<main>
    @include('reportes.informes.partial.header-detalle-rd-landscope')

    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td colspan="23"><strong style="font-size: 14px;">Indicaciones</strong></td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center" colspan="3" class="bordered-td">Junta</td>
                <td style="font-size: 11px; text-align: center" colspan="13" class="bordered-td">Cu&ntilde;o</td>
                <td style="font-size: 11px; text-align: center" colspan="3" class="bordered-td">Placa</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">Indicaciones</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">Resultados</td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Pk</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Elem.</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Tipo</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">L</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Posicion</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Mng</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">SNRn</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Tipo</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Posicion</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">AP</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">RZ</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($juntas_posiciones as $junta_posicion)
                @include('reportes.informes.partial.junta-completa-rd-v12', [
                    'junta_posicion'    => $junta_posicion,
                    'pasadas_juntas'    => $pasadas_juntas,
                    'defectos_posiciones' => $defectos_posiciones,
                    'informe'           => $informe,
                    'ot_tipo_soldadura' => $ot_tipo_soldadura,
                ])
            @endforeach
        </tbody>
    </table>

    @include('reportes.informes.partial.modelos3d-landscope')

</main>

    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 700;
            $y = 8;
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

    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 600;
            $y = 8;
            $text = "RG.27 Rev.02";
            $font = $fontMetrics->get_font("serif", "normal");
            $size = 7;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }

    </script>

</body>
</html>
