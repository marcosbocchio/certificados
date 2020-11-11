<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REFERENCIA INFORME N°: {{ $nro }}</title>
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

    <table width="100%">>
        <tbody>
            <td style="font-size: 12px;" > <b>ELEMENTO: </b>
                @if(isset($detalle->pieza))
                    {{$detalle->pieza}}
                @elseif(isset($detalle->elemento))
                    {{$detalle->elemento}}
                @endif

            </td>
        </tbody>
    </table>

    <table style="text-align: center" class="" width="100%">
        <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($detalle_referencia->path1!='/img/imagen1.jpg')
                                            <img src="{{ public_path($detalle_referencia->path1) }}" alt="" style="height: 160; width: 234;">
                                        @endif

                                    </td>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($detalle_referencia->path2!='/img/imagen2.jpg')
                                            <img src="{{  public_path($detalle_referencia->path2) }}" alt="" style="height: 160; width: 234;">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($detalle_referencia->path3!='/img/imagen3.jpg')
                                            <img src="{{  public_path($detalle_referencia->path3) }}" alt="" style="height: 160; width: 234;">
                                    @endif
                                    </td>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($detalle_referencia->path4!='/img/imagen4.jpg')
                                            <img src="{{  public_path($detalle_referencia->path4) }}" alt="" style="height: 160; width: 234;">
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
        </tbody>
    </table>

</main>

@include('reportes.partial.nro_pagina')

    @if($metodo_ensayo->metodo=='PM')

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

    @elseif($metodo_ensayo->metodo=='LP')

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

        @elseif($metodo_ensayo->metodo=='US')

            @if ($tecnica->codigo=="US")
                <script type="text/php">

                    if ( isset($pdf) ) {
                        $x = 518;
                        $y = 78;
                        $text = "RG.30 Rev.02";
                        $font = $fontMetrics->get_font("serif", "normal");
                        $size = 8;
                        $color = array(0,0,0);
                        $word_space = 0.0;  //  default
                        $char_space = 0.0;  //  default
                        $angle = 0.0;   //  default
                        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

                    }

                </script>

            @elseif($tecnica->codigo=="PA")

                <script type="text/php">

                    if ( isset($pdf) ) {
                        $x = 518;
                        $y = 78;
                        $text = "RG.79 Rev.01";
                        $font = $fontMetrics->get_font("serif", "normal");
                        $size = 8;
                        $color = array(0,0,0);
                        $word_space = 0.0;  //  default
                        $char_space = 0.0;  //  default
                        $angle = 0.0;   //  default
                        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

                    }

                </script>

            @endif

    @endif



</body>
</html>
