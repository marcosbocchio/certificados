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

    @include('reportes.informes.partial.header-detalle-tt-portrait')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.imagen-temperatura-tt')
    @if($informe->informeTt->detalle)
       <div class="page_break"></div>
        <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <td colspan="2"><strong style="font-size: 14px;">Indicaciones</strong></td>
                </tr>
                <tr>
                    <td style="font-size: 11px; width:270px; text-align: center " class="bordered-td">ELEMENTO</td>
                    <td style="font-size: 11px; text-align: center;" class="bordered-td">TERMOCUPLA</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($informe->informeTt->detalle as $detalle)
                    <tr>
                        <td style="font-size: 11px; text-align: center" class="bordered-td">{{ $detalle->elemento }}</td>
                        <td style="font-size: 11px; text-align: center" class="bordered-td">

                            @if ($detalle->termocupla)

                                {{$detalle->termocupla}}
                            @else
                                -
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endIf

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
