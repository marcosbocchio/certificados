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

    @include('reportes.informes.partial.header-detalle-rd-portrait')

    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td colspan="5"><strong style="font-size: 14px;">Mediciones</strong></td>
            </tr>

            <tr>
                <td style="font-size: 11px; width:60px;  text-align: center " class="bordered-td" >Tramo</td>
                <td style="font-size: 11px; width:60px;  text-align: center;" class="bordered-td">Bola Comp.</td>
                <td style="font-size: 11px; width:60px; text-align: center;" class="bordered-td">Espesor</td>
                <td style="font-size: 11px; width:60px;  text-align: center;" class="bordered-td">Espesor real</td>
                <td style="font-size: 11px; width:340px; text-align: center;" class="bordered-td">Observaciones</td>
                </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $tramo)
                <tr>
                    <td style="font-size: 11px;  width:60px;text-align: center" class="bordered-td">{{ $tramo->tramo }}</td>
                    <td style="font-size: 11px;  width:60px;text-align: center" class="bordered-td">
                        {{$tramo->bola_comparadora}}
                    </td>
                    <td style="font-size: 11px;  width:60px;text-align: center" class="bordered-td">{{$tramo->espesor}}</td>
                    <td style="font-size: 11px;  width:60px;text-align: center" class="bordered-td">{{(round((($tramo->espesor*25.4)/$tramo->bola_comparadora),2))}}</td>
                    <td style="font-size: 11px;  width:420px;text-align: center" class="bordered-td">{{$tramo->observaciones}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @foreach ( $detalles as $detalle )
    @if ( $detalle->referencia)
        @php
            $referencia = $detalle->referencia;
        @endphp
            @if ($referencia->path1 && $referencia->path2 =='/img/imagen2.jpg' && $referencia->path3 =='/img/imagen3.jpg' && $referencia->path4 =='/img/imagen4.jpg')
            <div class="page_break"></div>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td style="font-size: 12px;padding-top:10px"><strong>Tramo: </strong>
                                @isset($detalle->tramo)
                                    {{ $detalle->tramo }}
                                @endisset
                                @isset($detalle->pieza)
                                    {{ $detalle->pieza }}
                                @endisset
                            </td>
                            <tr>
                                <td style="font-size: 12px"><strong>OBSERVACIÓN: </strong>  {{$referencia->descripcion }} </td>
                            </tr>
                            <tr style="text-align: center">
                                <td style="text-align: center; width: 30px;height: 10px">
                                    @if ($referencia->path1!='/img/imagen1.jpg')
                                        <img src="{{ public_path($referencia->path1) }}" alt="" style="height: 300; width: 400;">
                                    @endif
                                </td>
                            </tr>
                    </tbody>
                </table>
             @endif
        @if ($referencia->path2!='/img/imagen2.jpg' || $referencia->path3!='/img/imagen3.jpg' || $referencia->path4!='/img/imagen4.jpg')
        <div class="page_break"></div>
            <table width="100%">
                <tbody>
                    <tr>
                        <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                             IMAGENES REFERENCIAS
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px;padding-top:10px"><strong>ELEMENTO: </strong>
                            @isset($detalle->elemento)
                                {{ $detalle->elemento }}
                            @endisset
                            @isset($detalle->pieza)
                                {{ $detalle->pieza }}
                            @endisset
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px"><strong>OBSERVACIÓN: </strong>  {{$referencia->descripcion }} </td>
                    </tr>
                </tbody>
            </table>
            <table style="text-align: center; margin-top: 10px;" class="" width="100%">
                <tbody>
                    <tr>
                        <td>
                            <table style="border-spacing: 15px 1rem;">
                                <tbody>
                                    <tr>
                                        <td style="text-align: center; width: 300px;height: 200px">
                                                @if ($referencia->path1!='/img/imagen1.jpg')
                                                    <img src="{{ public_path($referencia->path1) }}" alt="" style="height: 150; width: 218;">
                                                @endif

                                        </td>
                                        <td style="text-align: center; width: 300px;height: 200px">
                                            @if ($referencia->path2!='/img/imagen2.jpg')
                                                <img src="{{  public_path($referencia->path2) }}" alt="" style="height: 150; width: 218;">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; width: 300px;height: 200px">
                                            @if ($referencia->path3!='/img/imagen3.jpg')
                                                <img src="{{  public_path($referencia->path3) }}" alt="" style="height: 150; width: 218;">
                                        @endif
                                        </td>
                                        <td style="text-align: center; width: 300px;height: 200px">
                                            @if ($referencia->path4!='/img/imagen4.jpg')
                                                <img src="{{  public_path($referencia->path4) }}" alt="" style="height: 150; width: 218;">
                                        @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endif
@endforeach

    @include('reportes.informes.partial.modelos3d-portrait')

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
