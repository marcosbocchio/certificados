<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PROYECTO : {{$ot->proyecto }} - OT N° : {{$ot->numero}}</title>
<link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

</head>

<style>

    @page { margin: 260px 40px 235px 40px !important;
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
    @include('reportes.partial.header-proyecto-ot-portrait')
    @include('reportes.partial.linea-amarilla')
</header>

<footer>

    @include('reportes.partial.linea-amarilla')
    @include('reportes.partial.observaciones')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.ots.firmas')

</footer>

<main>

    <table class="header-detalle-principal">
        <tbody>
            <tr>
                <td width="49%">
                    <table style="font-size: 12px;" width="100%" class="header-detalle">
                        <tbody>

                            <tr>
                                <th colspan="2">Lugar de ensayo</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$ot->lugar}}
                                    <a href="{{ $geo }}" target="_blank" >
                                        <img src="{{ public_path('img/mark-google-maps.png')}}" alt="" style="height: 14px;">
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Localidad</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$localidad->localidad}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Contacto 1</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$contacto1->nombre}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Email</th>
                            </tr>
                            <tr>
                                 <td colspan="2">{{$contacto1->email}}</td>
                            </tr>


                            @if($contacto2)
                                <tr>
                                    <th colspan="2">Contacto 2</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{$contacto2->nombre}}
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2">Email</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @if($contacto2->email)
                                            {{$contacto2->email}}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @if($contacto3)
                                <tr>
                                    <th colspan="2">Contacto 3</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{$contacto3->nombre}}
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2">Email</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @if($contacto3->email)
                                            {{$contacto3->email}}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                             @endif

                            <tr>
                                <th colspan="2">Métodos de Ensayos</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @foreach ( $metodos_ensayos as $metodo )

                                    @if (!$loop->first)
                                      ,
                                    @endif

                                        {{ $metodo->metodo }}

                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Fecha Estimada Ensayo</th>
                            </tr>

                            <tr>
                                <td colspan="2">{{ date('d-m-Y', strtotime($ot->fecha_hora_estimada_ensayo)) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </td>
                <td width="2%">
                    &nbsp;
                </td>
                <td width="49%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>

                            <tr>
                                <th colspan="2">Horario</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{ date('H:i', strtotime($ot->fecha_hora_estimada_ensayo)) }}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Provincia</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$provincia->provincia}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Cargo</th>
                            </tr>
                            <tr>
                                 <td colspan="2">{{$contacto1->cargo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Tel</th>
                            </tr>
                            <tr>
                                 <td colspan="2">{{$contacto1->tel}}</td>
                            </tr>

                            @if($contacto2)
                            <tr>
                                <th colspan="2">Cargo</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if($contacto2->cargo)
                                        {{$contacto2->cargo}}
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Tel</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if($contacto2->tel)
                                       {{ $contacto2->tel }}
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                            </tr>
                            @endif

                            @if($contacto3)
                                <tr>
                                    <th colspan="2">Cargo</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @if($contacto3->cargo)
                                            {{$contacto3->cargo}}
                                        @else
                                            &nbsp;
                                        @endif

                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2">Tel</th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @if($contacto3->tel)
                                            {{$contacto3->tel}}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                             @endif

                            <tr>
                                <th colspan="2" >Calidad de Placa</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="borderFilabottom">
                                    @if(count($ot_calidad_placas))
                                        @foreach ($ot_calidad_placas as $ot_calidad_placa)

                                        @if (!$loop->first)
                                        ,
                                        @endif

                                            {{ $ot_calidad_placa->codigo  }}

                                        @endforeach
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    @include('reportes.partial.linea-amarilla')

    <table width="100%">

        <tbody>
            @foreach ( $ot_servicios as $ot_servicio )
                  <tr>

                    <td style="font-size: 12px;"  >

                        @if ($ot_servicio->ot_referencia_id)
                        <li style="margin-left: 20px;"> <a href="{{ route('ServiciosReferencias',$ot_servicio->ot_referencia_id)}}">{{ $ot_servicio->servicio }}</a></li>
                        @else
                        <li style="margin-left: 20px;"> {{ $ot_servicio->servicio }} </li>
                        @endif
                        @if ($ot_servicio->procedimiento_sn)
                        <span style="margin-left: 30px; font-size:11px; ">Requiere Procedimiento</span><br>
                        @endif
                        <span style="margin-left: 30px; font-size:11px; ">Norma de ensayo:</span><span style="font-size: 9px;color:#808080;">{{$ot_servicio->norma_ensayo}}</span> <br>
                        <span style="margin-left: 30px; font-size:11px;">Norma de evaluación:</span><span style="font-size: 9px;color:#808080;">{{$ot_servicio->norma_evaluacion}}</span>
                      </td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_servicio->cantidad_servicios}}</td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_servicio->unidad_medida}}</td>

                  </tr>

                  @endforeach

                  @foreach ( $ot_productos as $ot_producto )
                  <tr>
                    <td style="font-size: 12px; width:470px;" >
                        @if ($ot_producto->ot_referencia_id)
                        <li style="margin-left: 20px;font-size: 11px;" class="EspecialCaracter"><a href="{{ route('ProductosReferencias',$ot_producto->ot_referencia_id)}}">{{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }}</a></li> <br>
                        @else
                        <li style="margin-left: 20px;font-size: 11px;" class="EspecialCaracter">  {{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }} </li> </span>
                        @endif
                      </td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_producto->cantidad_productos}}</td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_producto->unidad_medida_codigo}}</td>
                  </tr>

                  @endforeach

                  @for ( $x=0 ;  $x < 2 ; $x++)
                      <tr>
                          <td style="font-size: 12px;" colspan="3">&nbsp;</td>
                      </tr>
                  @endfor
        </tbody>
    </table>

    @if(count($ot_epps) || count($ot_riesgos))
        @include('reportes.partial.linea-amarilla-fina')
    @endif

    @if(count($ot_epps))
        <table width="100%">
            <tbody>
                <tr>
                    <td style="font-size: 13px;"><strong>Elementos de Seguridad: </strong> </td>
                </tr>
                <tr>
                    <td style="font-size: 13px;">
                        @foreach ( $ot_epps as $ot_epp )
                            @if (!$loop->first)
                            ,
                            @endif
                        {{$ot_epp->descripcion}}
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    @if(count($ot_riesgos))
        <table width="100%">
            <tbody>
                <tr>
                    <td style="font-size: 13px;"><strong>Riesgos: </strong> </td>
                </tr>
                <tr>
                    <td style="font-size: 13px;">
                        @foreach ( $ot_riesgos as $ot_riesgo )
                            @if (!$loop->first)
                                ,
                            @endif
                        {{$ot_riesgo->descripcion}}
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
</main>

@include('reportes.partial.nro_pagina')

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 518;
        $y = 78;
        $text = "RG.25 Rev.03";
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

