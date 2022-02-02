<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PARTE DIARIO Nº: {{ $nro }}</title>
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
    @include('reportes.partial.header-proyecto-parte-portrait')
    @include('reportes.partial.linea-amarilla')
</header>
<footer>

    @include('reportes.partial.linea-amarilla')
    @include('reportes.partial.observaciones')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.partes.partial.firmas')
</footer>


<main>

    @include('reportes.partes.partial.header-detalle-parte')

    @if(count($vehiculos) > 0)

        @include('reportes.partial.linea-amarilla-fina')

        <table width="100%" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <td style="font-size: 12px;height: 20px; text-align: left;" colspan="6"><b>VEHÍCULOS</td>
                </tr>
                <tr>
                    <th style="font-size: 12px;height: 20px;width: 140px;">Marca</th>
                    <th style="font-size: 12px;height: 20px;width: 140px;">Modelo</th>
                    <th style="font-size: 12px;height: 20px;width: 140px;">Tipo</th>
                    <th style="font-size: 12px;height: 20px;width: 140px;">Patente</th>
                    <th style="font-size: 12px;height: 20px;width: 80px;">Km inicial</th>
                    <th style="font-size: 12px;height: 20px;">km final</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehiculos as $vehiculo)

                    <tr>
                        <td style="font-size: 12px;height: 20px;width: 140px;">{{$vehiculo->marca}}</td>
                        <td style="font-size: 12px;height: 20px;width: 140px;">{{$vehiculo->modelo}}</td>
                        <td style="font-size: 12px;height: 20px;width: 140px;">{{$vehiculo->tipo}}</td>
                        <td style="font-size: 12px;height: 20px;width: 140px;">{{$vehiculo->patente}}</td>
                        <td style="font-size: 12px;height: 20px;width: 80px;">{{$vehiculo->km_inicial}}</td>
                        <td style="font-size: 12px;height: 20px;">{{$vehiculo->km_final}}</td>

                    </tr>

                @endforeach

            </tbody>
        </table>
    @endif

    @if(count($responsables) > 0)

        @include('reportes.partial.linea-amarilla-fina')

        <table width="100%" style="border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="font-size: 12px;height: 20px; text-align: left;" colspan="2"><b>RESPONSABLES</td>
                </tr>

                    @foreach ($responsables as $responsable)

                        @if($loop->odd)

                            <tr>
                            <td style="font-size: 12px;height: 20px; width:365px;">{{$responsable->nombre}} <em>({{ strtolower($responsable->responsabilidad)}})</em></td>
                        @else
                            <td style="font-size: 12px;height: 20px;">{{$responsable->nombre}} <em>({{ strtolower($responsable->responsabilidad)}})</em></td>
                            </tr>

                        @endif

                        @if ($loop->last && $loop->odd)
                            <td style="font-size: 12px;height: 20px;">&nbsp;</td>
                            </tr>
                        @endif
                    @endforeach

            </tbody>
        </table>
    @endif

    @if(count($servicios) > 0)

        @include('reportes.partial.linea-amarilla-fina')

        <table width="100%" style="margin-top: -5px;margin-bottom: 10px;">
            <tbody>

                <tr>
                    <td style="font-size: 12px;height: 30px;" colspan="3"><b>SERVICIOS: </b></td>
                </tr>
                <tr>

                    <td style="font-size: 12px;width: 100px;margin-left: 4px;"><b>Metodo Ensayo: </b></td>
                    <td style="font-size: 12px;width: 500px;" ><b>Descripción </b></td>
                    <td style="font-size: 12px;text-align: center;"><b>Cantidad </b></td>
                </tr>
                @foreach($servicios as $servicio)

                    @if (($estado == 'original' && $servicio->cant_original !='')||($estado == 'final' && $servicio->cant_final !=''))

                        <tr>

                            <td style="font-size: 12px;width: 100px;"><span>{{$servicio->metodo}}</span></td>
                            <td style="font-size: 12px;width: 500px;"><span>{{$servicio->servicio_descripcion}}</span> </td>
                            <td style="font-size: 12px;text-align: center;text-align: center;">

                                @if($estado == 'original')
                                    {{$servicio->cant_original}}
                                @else
                                    {{$servicio->cant_final}}
                                @endif

                            </td>
                        </tr>

                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- DETALLE INFORME RI -->

    @php
     $ExisteRI = false;
     $ExisteRIManual = false;
        if(count($informes_ri_adicionales) >0)
           $ExisteRIManual = true;
    @endphp

    @foreach ($parte_detalle as $item)

        @if ($item->metodo == 'RI')
            @php $ExisteRI = true; @endphp
        @endif

    @endforeach

    @if ($ExisteRI || $ExisteRIManual)
        @include('reportes.partial.linea-amarilla-fina')
        <table width="100%" style="margin-top: -5px;">
            </tbody>
                <tr>
                    <td style="font-size: 12px;height: 30px;" colspan="5"><b>METODO ENSAYO: RI </b></td>
                </tr>
                @if ($estado == 'original')
                    <tr>
                        <td style="font-size: 13px;height: 30px" colspan="5"><b style="margin-left: 6px;">Placas Repetidas Total: </b>{{ $parte->placas_repetidas }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;height: 30px" colspan="5"><b style="margin-left: 6px;">Placas Testigos Total: </b>{{ $parte->placas_testigos }}</td>
                    </tr>
                @endif
                    <tr>
                        <td style="font-size: 12px;width: 50px;"><b>N° Informe</b></td>
                        <td style="font-size: 12px;width: 70px; text-align: center;"><b>Planta</b></td>
                        <td style="font-size: 12px;width: 45px; text-align: center;"><b>Costuras</b></td>
                        <td style="font-size: 12px;width: 45px; text-align: center;"><b>Pulgadas</b></td>
                        <td style="font-size: 12px;width: 45px; text-align: center;"><b>Placas</b></td>
                        <td style="font-size: 12px;width: 45px; text-align: center;"><b>Cm </b></td>
                        <td style="font-size: 12px;width: 80px; text-align: center;"><b>Solicitante</b></td>
                        <td style="font-size: 12px;width: 80px; text-align: center;"><b>Firma</b></td>
                    </tr>
                @foreach ($parte_detalle as $item)
                    @if ($item->metodo == 'RI')
                        <tr>
                            <td style="font-size: 12px;height: 10px;">{{$item->numero_formateado}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->planta ? $item->planta : ''}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->costura}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->pulgadas}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->placas}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->cm}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->solicitado_por ? $item->solicitado_por : ''}}</td>
                            <td style="font-size: 12px; text-align: center;">&nbsp;</td>
                        </tr>
                    @endif
                @endforeach

                @foreach ($informes_ri_adicionales as $item)
                        <tr>
                            <td style="font-size: 12px;height: 20px;">MANUAL</td>
                            <td style="font-size: 12px; text-align: center;">&nbsp;</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->costura}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->pulgadas}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->placas}}</td>
                            <td style="font-size: 12px; text-align: center;">{{$item->cm}}</td>
                        </tr>

                @endforeach
            </tbody>
        </table>
    @endif



    <!-- DETALLE INFORME PM -->

    @php $ExistePM = false @endphp

    @foreach ($parte_detalle as $item)

        @if ($item->metodo == 'PM')
            @php $ExistePM = true @endphp
        @endif

    @endforeach

    @if ($ExistePM)
        @include('reportes.partial.linea-amarilla-fina')
        <table width="100%" style="margin-top: -5px;">
            <tbody>
                <tr>
                    <td style="font-size: 12px;height: 30px;" colspan="5"><b>METODO ENSAYO: PM </b></td>
                </tr>
                <tr>
                    <td style="font-size: 12px;width: 50px;"><b>N° Informe</b></td>
                    <td style="font-size: 12px;width: 90px; text-align: center;"><b>Planta</b></td>
                    <td style="font-size: 12px;width: 110px; text-align: center;"><b>Componente</b></td>
                    <td style="font-size: 12px;width: 45px; text-align: center;"><b>Diámetro</b></td>
                    <td style="font-size: 12px;width: 80px; text-align: center;"><b>Solicitante</b></td>
                    <td style="font-size: 12px;width: 80px; text-align: center;"><b>Firma</b></td>
                </tr>
                @foreach ($informes_detalle as $item)
                    @if ($item->metodo == 'PM')
                        @foreach ($parte_detalle as $item_pm)
                            @if ($item->informe_id == $item_pm->informe_id)
                                <tr>
                                    <td style="font-size: 12px;text-align: center;">{{$item->numero_formateado}}</td>
                                    <td style="font-size: 12px;text-align: center; ">{{$item->planta ? $item->planta : ''}}</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->componente}}</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->diametro_especifico ? $item->diametro_especifico : ($item->diametro ? $item->diametro : '') }}</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->solicitado_por ? $item->solicitado_por : ''}}</td>
                                    <td style="font-size: 12px;text-align: center;">&nbsp;</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach

            </tbody>
        </table>
    @endif



    <!-- DETALLE INFORME LP -->

    @php $ExisteLP = false @endphp

    @foreach ($parte_detalle as $item)

        @if ($item->metodo == 'LP')
            @php $ExisteLP = true @endphp
        @endif

    @endforeach

    @if ($ExisteLP)
        @include('reportes.partial.linea-amarilla-fina')
        <table width="100%" style="margin-top: -5px;">
            <tbody>
                <tr>
                    <td style="font-size: 12px;height: 30px;" colspan="5"><b>METODO ENSAYO: LP </b></td>
                </tr>
                <tr>
                    <td style="font-size: 12px;width: 50px;"><b>N° Informe</b></td>
                    <td style="font-size: 12px;width: 90px; text-align: center;"><b>Planta</b></td>
                    <td style="font-size: 12px;width: 110px; text-align: center;"><b>Componente</b></td>
                    <td style="font-size: 12px;width: 45px; text-align: center;"><b>Diámetro</b></td>
                    <td style="font-size: 12px;width: 80px; text-align: center;"><b>Solicitante</b></td>
                    <td style="font-size: 12px;width: 80px; text-align: center;"><b>Firma</b></td>
                </tr>
                @foreach ($informes_detalle as $item)
                    @if ($item->metodo == 'LP')
                        @foreach ($parte_detalle as $item_lp)
                            @if ($item->informe_id == $item_lp->informe_id)
                                <tr>
                                    <td style="font-size: 12px;text-align: center;">{{$item->numero_formateado}}</td>
                                    <td style="font-size: 12px;text-align: center; ">{{$item->planta ? $item->planta : ''}}</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->componente}}</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->diametro_especifico ? $item->diametro_especifico : ($item->diametro ? $item->diametro : '') }}</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->solicitado_por ? $item->solicitado_por : ''}}</td>
                                    <td style="font-size: 12px;text-align: center;">&nbsp;</td>
                                </tr>
                                @endif
                            @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif




    <!-- DETALLE INFORME US -->

    @php $ExisteUS = false @endphp

    @foreach ($parte_detalle as $item)

        @if ($item->metodo == 'US')
            @php $ExisteUS = true @endphp
        @endif

    @endforeach


    @if ($ExisteUS)
        @include('reportes.partial.linea-amarilla-fina')
        <table width="100%" style="margin-top: -5px;">
            <tbody>
                @if ($ExisteUS)
                    <tr>
                        <td style="font-size: 12px;height: 30px;" colspan="5"><b>METODO ENSAYO: US </b></td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px;width: 50px;"><b>N° Informe</b></td>
                        <td style="font-size: 12px;width: 90px; text-align: center;"><b>Planta</b></td>
                        <td style="font-size: 12px;width: 110px; text-align: center;"><b>Componente</b></td>
                        <td style="font-size: 12px;width: 45px; text-align: center;"><b>Diámetro</b></td>
                        <td style="font-size: 12px;width: 80px; text-align: center;"><b>Solicitante</b></td>
                        <td style="font-size: 12px;width: 80px; text-align: center;"><b>Firma</b></td>
                    </tr>
                    @foreach ($informes_detalle as $item)
                        @if ($item->metodo == 'US')
                            @foreach ($parte_detalle as $item_us)
                                @if ($item->informe_id == $item_us->informe_id)
                                    <tr>
                                        <td style="font-size: 12px;text-align: center;">{{$item->numero_formateado}}</td>
                                        <td style="font-size: 12px;text-align: center; ">{{$item->planta ? $item->planta : ''}}</td>
                                        <td style="font-size: 12px;text-align: center;">{{$item->componente}}</td>
                                        <td style="font-size: 12px;text-align: center;">{{$item->diametro_especifico ? $item->diametro_especifico : ($item->diametro ? $item->diametro : '') }}</td>
                                        <td style="font-size: 12px;text-align: center;">{{$item->solicitado_por ? $item->solicitado_por : ''}}</td>
                                        <td style="font-size: 12px;text-align: center;">&nbsp;</td>
                                    </tr>
                                    @endif
                                @endforeach
                        @endif
                    @endforeach

                @endif
            </tbody>
        </table>
    @endif

    <!-- DETALLE INFORME CV -->

    @php $ExisteCV = false @endphp

    @foreach ($parte_detalle as $item)

        @if ($item->metodo == 'CV')
            @php $ExisteCV = true @endphp
        @endif

    @endforeach

    @if ($ExisteCV)
        @include('reportes.partial.linea-amarilla-fina')
        <table width="100%" style="margin-top: -5px;">
            <tbody>
                <tr>
                    <td style="font-size: 12px;height: 30px;" colspan="5"><b>METODO ENSAYO: CV </b></td>
                </tr>
                <tr>
                    <td style="font-size: 12px;width: 50px;"><b>N° Informe</b></td>
                    <td style="font-size: 12px;width: 90px; text-align: center;"><b>Planta</b></td>
                    <td style="font-size: 12px;width: 110px; text-align: center;"><b>Componente</b></td>
                    <td style="font-size: 12px;width: 45px; text-align: center;"><b>Diámetro</b></td>
                    <td style="font-size: 12px;width: 80px; text-align: center;"><b>Solicitante</b></td>
                    <td style="font-size: 12px;width: 80px; text-align: center;"><b>Firma</b></td>
                </tr>
            @foreach ($informes_detalle as $item)
                    @if ($item->metodo == 'CV')
                        @foreach ($parte_detalle as $item_cv)
                            @if ($item->informe_id == $item_cv->informe_id)
                                <tr>
                                    <td style="font-size: 12px;text-align: center;">{{$item->numero_formateado}}</td>
                                    <td style="font-size: 12px;text-align: center; ">{{$item->planta ? $item->planta : ''}}</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->componente}}</td>
                                    <td style="font-size: 12px;text-align: center;">N/A</td>
                                    <td style="font-size: 12px;text-align: center;">{{$item->solicitado_por ? $item->solicitado_por : ''}}</td>
                                    <td style="font-size: 12px;text-align: center;">&nbsp;</td>
                                </tr>
                                @endif
                            @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

        <!-- DETALLE INFORME DZ -->

        @php $ExisteDZ = false @endphp

        @foreach ($parte_detalle as $item)

            @if ($item->metodo == 'DZ')
                @php $ExisteDZ = true @endphp
            @endif

        @endforeach

        @if ($ExisteDZ)
            @include('reportes.partial.linea-amarilla-fina')
            <table width="100%" style="margin-top: -5px;">
                <tbody>
                    <tr>
                        <td style="font-size: 12px;height: 30px;" colspan="5"><b>METODO ENSAYO: DZ </b></td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px;width: 50px;"><b>N° Informe</b></td>
                        <td style="font-size: 12px;width: 90px; text-align: center;"><b>Planta</b></td>
                        <td style="font-size: 12px;width: 110px; text-align: center;"><b>Componente</b></td>
                        <td style="font-size: 12px;width: 45px; text-align: center;"><b>Diámetro</b></td>
                        <td style="font-size: 12px;width: 80px; text-align: center;"><b>Solicitante</b></td>
                        <td style="font-size: 12px;width: 80px; text-align: center;"><b>Firma</b></td>
                    </tr>
                    @foreach ($informes_detalle as $item)
                        @if ($item->metodo == 'DZ')
                            @foreach ($parte_detalle as $item_dz)
                                @if ($item->informe_id == $item_dz->informe_id)
                                    <tr>
                                        <td style="font-size: 12px;text-align: center;">{{$item->numero_formateado}}</td>
                                        <td style="font-size: 12px;text-align: center; ">{{$item->planta ? $item->planta : ''}}</td>
                                        <td style="font-size: 12px;text-align: center;">{{$item->componente}}</td>
                                        <td style="font-size: 12px;text-align: center;">N/A</td>
                                        <td style="font-size: 12px;text-align: center;">{{$item->solicitado_por ? $item->solicitado_por : ''}}</td>
                                        <td style="font-size: 12px;text-align: center;">&nbsp;</td>
                                    </tr>
                                    @endif
                                @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
</main>

@include('reportes.partial.nro_pagina')

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 518;
        $y = 78;
        $text = "RG.62 Rev.01";
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
