<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 260px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -237px;
}

footer {
    position: fixed; bottom:0px;
    padding-top: 0px;
}

#rotate
{
  height:170px;
}

#vertical
{
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
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

    <table width="100%">
        <tbody>
            <tr>
                <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                   REGISTRO DE MEDICIONES
                   @if($tecnica->codigo == 'US' || $tecnica->codigo=='PA')
                   <a href="{{ route('InformeUsIndicacionesUsPa',$informe->id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>
                   @elseif($tecnica->codigo ='ME')
                   <a href="{{ route('InformeUsIndicacionesMe',$informe->id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>
                   @endif
               </td>
            </tr>
        </tbody>
    </table>

    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.observaciones')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.firmas')

</footer>


<main>

    @include('reportes.informes.partial.header-detalle-us-portrait')

    @include('reportes.partial.linea-amarilla')

    @if($tecnica->codigo == 'US' || $tecnica->codigo=='PA')

        <table style="text-align: center;border-collapse: collapse;margin-top: 10px;" width="100%">
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;background:#D8D8D8;" colspan="16">DATOS DE CALIBRACIÓN</td>
                </tr>
                <tr>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -3.5px;margin-right: -3.5px;">ZAPATA</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -12px;margin-right: -12px;">PALPADOR</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -4px;margin-right: -4px;">N° SERIE</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -48px;margin-right: -48px;">FRECUENCIA (Mhz)</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -35px;margin-right: -35px;">ANG. APERTURA</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -14px;margin-right: -14px;">RANGO</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -22px;margin-right: -22px;">POSICIÓN</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -45px;margin-right: -45px;">CURVA ELEVACION</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -55px;margin-right: -55px;">BLOCK CALIBRACIÓN</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -50px;margin-right: -50px;">BLOCK SENSIBILIDAD</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -49.5px;margin-right: -49.5px;">REFLECTOR REF. (mm)</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -50px;margin-right: -50px;">GANANCIA REF. (dB)</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -38px;margin-right: -38px;">NIVEL REGISTRO</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -54.5px;margin-right: -54.5px;">CORREC. TRANSF (dB)</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -67.5px;margin-right: -67.5px;">ADICIONAL BARRIDO (dB)</div></td>
                    <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -45px;margin-right: -45px;">AMPLIF. TOTAL (dB)</div></td>
                </tr>
            </tbody>
        </table>

        <table style="border-collapse: collapse;" width="100%">
            <tbody>
                @foreach ($calibraciones_us as $calibracion)
                    <tr>
                        <td style="font-size: 9px; width:85px;text-align: center;"class="bordered-td">
                            @if($calibracion->zapata)
                            {{ strtoupper($calibracion->zapata) }}
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px; width:85.3px;text-align: center;" class="bordered-td">
                            @if ($calibracion->palpador)
                            {{$calibracion->palpador->equipo->codigo}}
                            @endif
                        </td>
                        <td style="font-size: 9px; width:70px;text-align: center;" class="bordered-td">
                            @if ($calibracion->palpador)
                            {{$calibracion->palpador->nro_serie}}
                            @endif
                        </td>
                        <td style="font-size: 9px; width:25px;text-align: center;" class="bordered-td">{{$calibracion->frecuencia}}</td>
                        <td style="font-size: 9px; width:35.1px;text-align: center;" class="bordered-td">{{$calibracion->angulo_apertura}}</td>
                        <td style="font-size: 9px; width:36.3px;text-align: center;" class="bordered-td">{{$calibracion->rango}}</td>
                        <td style="font-size: 9px; width:32.3px;text-align: center;" class="bordered-td">{{strtoupper($calibracion->posicion)}}</td>
                        <td style="font-size: 9px; width:35.1px;text-align: center;" class="bordered-td">
                            @if($calibracion->curva_elevacion)
                                {{$calibracion->curva_elevacion}}
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px; width:28.8px;text-align: center;" class="bordered-td">
                            @if ($calibracion->block_calibracion == 'Proveta')
                                Pr
                            @elseif(($calibracion->block_calibracion == 'Escalonado'))
                                Es
                            @else
                                {{$calibracion->block_calibracion}}
                            @endif
                        </td>
                        <td style="font-size: 9px; width:38.2px;text-align: center;" class="bordered-td">
                            @if($calibracion->block_sensibilidad)
                            {{$calibracion->block_sensibilidad}}
                            @else
                            &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px; width:39.1px;text-align: center;" class="bordered-td"><span class="EspecialCaracter">
                            @if($calibracion->tipo_reflector)
                                {{$calibracion->tipo_reflector}}</span> &nbsp; {{$calibracion->reflector_referencia}}
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px; width:29.5px;text-align: center;" class="bordered-td">
                            @if($calibracion->ganancia_referencia)
                                {{$calibracion->ganancia_referencia}}
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px; width:32.2px;text-align: center;" class="bordered-td">
                            @if($calibracion->nivel_registro)
                                {{$calibracion->nivel_registro}}&nbsp;%
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px; width:29.3px;text-align: center;" class="bordered-td">
                            @if($calibracion->correccion_transferencia)
                                {{$calibracion->correccion_transferencia}}
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px; width:28.8px;text-align: center;" class="bordered-td">
                            @if($calibracion->adicional_barrido)
                            {{$calibracion->adicional_barrido}}
                            @else
                            &nbsp;
                            @endif
                        </td>
                        <td style="font-size: 9px;text-align: center" class="bordered-td">
                            @if($calibracion->amplificacion_total)
                                {{$calibracion->amplificacion_total}}
                            @else
                                &nbsp;
                            @endif
                        </td>

                    </tr>
                @endforeach


                {{ $filasACompletar = 4 - count($calibraciones_us) }}
                @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                    <tr>
                        <td style="font-size: 9px; width:85px;text-align: center;"class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:85.3px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:70px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:25px;  text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:35.1px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:36.3px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:32.3px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:35.1px;text-align:   center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:28.8px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:38.2px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:39.1px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:29.5px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:32.2px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:29.3px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px; width:28.8px;text-align: center;" class="bordered-td">&nbsp;</td>
                        <td style="font-size: 9px;text-align: center" class="bordered-td">&nbsp;</td>
                    </tr>
                @endfor
            </tbody>
        </table>

    @endif


    @if($tecnica->codigo == 'ME')
    <table style="text-align: center;border-collapse: collapse;margin-top: 10px;" width="100%">
        <thead>
                <tr>
                    <td style="font-size: 11px; width:120px; text-align: center " class="bordered-td" >PALPADOR</td>
                    <td style="font-size: 11px; width:70px; text-align: center;" class="bordered-td">N° SERIE</td>
                    <td style="font-size: 11px; width:80px; text-align: center;"  class="bordered-td">FRECUENCIA (Mhz)</td>
                    <td style="font-size: 11px; width:80px;text-align: center;"  class="bordered-td">ANG. APERTURA</td>
                    <td style="font-size: 11px; width:80px; text-align: center;" class="bordered-td">RANGO</td>
                    <td style="font-size: 11px; width:80px; text-align: center;" class="bordered-td">POSICIÓN</td>
                    <td style="font-size: 11px;  text-align: center;" class="bordered-td">BLOCK CALIBRACIÓN</td>
                </tr>

            </thead>
            <tbody>
                @foreach ($calibraciones_us as $calibracion)
                <tr>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">
                        @if ($calibracion->palpador)
                           {{$calibracion->palpador->equipo->codigo}}
                        @endif
                    </td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">
                        @if ($calibracion->palpador)
                        {{$calibracion->palpador->nro_serie}}
                        @endif
                    </td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">{{$calibracion->frecuencia}}</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">{{$calibracion->angulo_apertura}}</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">{{$calibracion->rango}}</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">{{strtoupper($calibracion->posicion)}}</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">{{$calibracion->block_calibracion}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if( $informe_us->path1_calibracion || $informe_us->path2_calibracion || $informe_us->path3_calibracion || $informe_us->path4_calibracion)

        <table style="text-align: center;margin-top: 5px;" width="100%" >
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 340px;height: 190px;">

                                        @if ($informe_us->path1_calibracion)
                                            <img src="{{ public_path($informe_us->path1_calibracion) }}" alt="" style="width: 262px;height: 180px;">
                                        @endif

                                    </td>

                                    <td style="text-align: center; width: 340px;height: 190px;">

                                        @if ($informe_us->path2_calibracion)
                                            <img src="{{ public_path($informe_us->path2_calibracion) }}" alt="" style="width: 262px;height: 180px;">
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 340px;height: 190px;">

                                        @if ($informe_us->path3_calibracion)
                                            <img src="{{ public_path($informe_us->path3_calibracion) }}" alt="" style="width: 262px;height: 180px;">
                                        @endif

                                    </td>

                                    <td style="text-align: center; width: 340px;height: 190px;">

                                        @if ($informe_us->path4_calibracion)
                                            <img src="{{ public_path($informe_us->path4_calibracion) }}" alt="" style="width: 262px;height: 180px;">
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

    @include('reportes.informes.partial.modelos3d-portrait')

</main>

@include('reportes.partial.nro_pagina')

@if($tecnica->codigo=='US')

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 520;
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

@elseif ($tecnica->codigo=='PA')

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 520;
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

 @else

 <script type="text/php">
    if ( isset($pdf) ) {
        $x = 518;
        $y = 78;
        $text = "RG.33 Rev.02";
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


</body>

</html>
