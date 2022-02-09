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

    @include('reportes.informes.partial.header-detalle-dz-portrait')

    @include('reportes.partial.linea-amarilla')

    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td colspan="5"><strong style="font-size: 14px;">Detalles</strong></td>
            </tr>
            <tr>
                <td style="font-size: 11px; width:10px;  text-align: center " class="bordered-td" rowspan="2">ELEMENTO</td>
                <td style="font-size: 11px; width:10px;  text-align: center;" class="bordered-td" rowspan="2">DIÁMETRO</td>
                <td style="font-size: 11px; width:10px;  text-align: center;" class="bordered-td" rowspan="2">ESPESOR</td>
                <td style="font-size: 11px; width:20px; text-align: center;" class="bordered-td" rowspan="2">CUÑO</td>
                <td style="font-size: 11px; width:92px; text-align: center;" class="bordered-td" colspan="3">{{$informe_unidad_medicion_dureza->descripcion}}-{{$informe_unidad_medicion_dureza->codigo}}</td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center;width:64.5px;" class="bordered-td">Material base</td>
                <td style="font-size: 11px; text-align: center;width:64.5px;" class="bordered-td">Soldadura</td>
                <td style="font-size: 11px; text-align: center;width:64.5px;" class="bordered-td">Material base</td>
            </tr>

        </thead>
        <tbody>
            @foreach ($detalles as $detalle)
                <tr>
                    <td style="font-size: 11px;  width:20px;" class="bordered-td">{{ $detalle->elemento }}</td>
                    <td style="font-size: 11px;  width:20px;text-align: center" class="bordered-td">
                        {{$detalle->diametro_especifico ? $detalle->diametro_especifico : $detalle->diametro}}
                    </td>
                    <td style="font-size: 11px;  width:20px;text-align: center" class="bordered-td">
                        {{$detalle->espesor_especifico ? $detalle->espesor_especifico : $detalle->espesor}}
                    </td>
                    <td style="font-size: 11px;  width:22px;" class="bordered-td">{{$detalle->codigo}}</td>
                    <td style="font-size: 11px;  width:22px;" class="bordered-td">{{ $detalle->material_base_izq }}</td>
                    <td style="font-size: 11px;  width:22px;" class="bordered-td">{{ $detalle->soldadura }}</td>
                    <td style="font-size: 11px;  width:22px;" class="bordered-td">{{ $detalle->material_base_der }}</td>
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
        $text = "RG.28 Rev.02";
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
