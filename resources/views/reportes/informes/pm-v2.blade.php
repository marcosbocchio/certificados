<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 233px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -237px;
}

footer {
    position: fixed; bottom:0px;
    padding-top: 0px;
}
.page_break { page-break-before: always; }

</style>

<body>
<header>
    @include('reportes.partial.header-principal-portrait')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.partial.header-cliente-comitente-portrait')
    @include('reportes.partial.linea-gris')
    @include('reportes.partial.header-proyecto-portrait')
    @include('reportes.partial.linea-amarilla')
</header>

<footer>
    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.observaciones')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.firmas')
</footer>


<main>

    @include('reportes.informes.partial.header-detalle-pm-portrait')

    @include('reportes.partial.linea-amarilla')

    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td colspan="5"><strong style="font-size: 14px;">Indicaciones</strong></td>
            </tr>
            <tr>
                <td style="font-size: 11px; width:270px;  text-align: center " rowspan="2" class="bordered-td" >ELEMENTO</td>
                <td style="font-size: 11px; width:40px;  text-align: center;" rowspan="2" class="bordered-td">CM</td>
                <td style="font-size: 11px; width:312px; text-align: center;" rowspan="2" class="bordered-td">DETALLE</td>
                <td style="font-size: 11px; width:80px; text-align: center;" colspan="2" class="bordered-td">RESULTADO</td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center;" class="bordered-td">AP</td>
                <td style="font-size: 11px; text-align: center;" class="bordered-td">RZ</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $detalle)
                <tr>
                    <td style="font-size: 11px;  width:231px;text-align: center" class="bordered-td">{{ $detalle->pieza }}</td>
                    <td style="font-size: 11px;  width:40px;text-align: center" class="bordered-td">

                        @if ($detalle->cm)

                            {{$detalle->cm}}
                        @else
                            -
                        @endif

                    </td>
                    <td style="font-size: 11px;  width:312px;" class="bordered-td">&nbsp; {{$detalle->detalle}}</td>
                    <td style="font-size: 11px; text-align: center;width:39px; " class="bordered-td">
                        @if ($detalle->aceptable_sn)
                            X
                        @endif
                    </td>

                    <td style="font-size: 11px; text-align: center;width:38px;" class="bordered-td">
                        @if (!$detalle->aceptable_sn)
                            X
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('reportes.informes.partial.modelos3d-portrait')
    @include('reportes.informes.partial.referencias')
</main>


@include('reportes.partial.nro_pagina')

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 518;
        $y = 78;
        $text = "RG.29 Rev.02";
        $font = $fontMetrics->get_font("serif", "normal");
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
