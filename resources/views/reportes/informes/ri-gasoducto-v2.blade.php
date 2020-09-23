<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>

    @page { margin: 245px 40px 260px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -230px;
}

footer {
    position: fixed; bottom:0px;
    padding-top: 0px;
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

    <table width="100%" style="border-collapse: collapse;" >
        <tbody>
            <tr>
                <td style="font-size: 14px;"><strong>Diccionario</strong></td>
            </tr>
            <tr>
                <td style="font-size: 11px; " class="bordered-td"><b>F: </b>Fisura</td>
                <td style="font-size: 11px; " class="bordered-td"><b>FF: </b>Falta de fusion</td>
                <td style="font-size: 11px; " class="bordered-td"><b>FP: </b>Falta de Penetración</td>
                <td style="font-size: 11px; " class="bordered-td"><b>FPD: </b>FP por Desalineación</td>
                <td style="font-size: 11px; " class="bordered-td"><b>FFP: </b>FF por Pasadas</td>
                <td style="font-size: 11px; " class="bordered-td"><b>HL: </b>Desalineación</td>
            </tr>
            <tr>
                <td style="font-size: 11px; " class="bordered-td"><b>PE: </b>Penetración Excesiva</td>
                <td style="font-size: 11px; " class="bordered-td"><b>Q: </b>Quemaduras</td>
                <td style="font-size: 11px; " class="bordered-td"><b>CI: </b>Concavidad Interna</td>
                <td style="font-size: 11px; " class="bordered-td"><b>CE: </b>Concavidad Externa</td>
                <td style="font-size: 11px; " class="bordered-td"><b>SI: </b>Socavado Interior</td>
                <td style="font-size: 11px; " class="bordered-td"><b>SE: </b>Socavado Exterior</td>
            </tr>
            <tr>
                <td style="font-size: 11px; " class="bordered-td"><b>ME: </b>Escoria Aislada</td>
                <td style="font-size: 11px; " class="bordered-td"><b>MEL: </b>Escoria Lineal</td>
                <td style="font-size: 11px; " class="bordered-td"><b>P: </b>Poros</td>
                <td style="font-size: 11px; " class="bordered-td"><b>NP: </b>Nido de Poros</td>
                <td style="font-size: 11px; " class="bordered-td"><b>PV: </b>Poro Vermicular</td>
                <td style="font-size: 11px; " class="bordered-td"><b>CH: </b>Cordón Hueco</td>
            </tr>
            <tr>
                <td style="font-size: 11px; " class="bordered-td"><b>IT: </b>Inclusión de Tungteno</td>
                <td style="font-size: 11px; " class="bordered-td"><b>SA: </b>Salto de Arco</td>
                <td style="font-size: 11px; " colspan="2" class="bordered-td"><b>AD: </b>Acumulación de Discontinuidades</td>
                <td style="font-size: 11px; " class="bordered-td"><b>DP: </b>Defecto de Placa</td>
                <td style="font-size: 11px; " class="bordered-td"><b>RP: </b>Repetir Placa</td>
            </tr>
            <tr>
                    <td style="font-size: 11px; "  class="bordered-td"><b>R: </b>Raiz</td>
                    <td style="font-size: 11px; "  class="bordered-td"><b>Y: </b>Relleno</td>
                    <td style="font-size: 11px; "  class="bordered-td"><b>S: </b>Sobremonta</td>
                    <td style="font-size: 11px; "  class="bordered-td"><b>AP: </b>Aprobado</td>
                    <td style="font-size: 11px; " colspan="2" class="bordered-td"><b>RZ: </b>Rechazado</td>
            </tr>
            <tr>
                <td style="font-size: 11px;" colspan="6" class="bordered-td"><b>Observaciones: </b>{{$informe->observaciones}}</td>
            </tr>
        </tbody>
    </table>

    @include('reportes.partial.linea-amarilla')

    @include('reportes.informes.partial.firmas')
</footer>


<main>
    @include('reportes.informes.partial.header-detalle-ri-landscope')

    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td colspan="19"><strong style="font-size: 14px;">Indicaciones</strong></td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center " colspan="3" class="bordered-td" >Junta</td>
                <td style="font-size: 11px; text-align: center " colspan="13" class="bordered-td" >Cuño</td>
                <td style="font-size: 11px; text-align: center " colspan="2" rowspan="2" class="bordered-td" >Placa</td>
                <td style="font-size: 11px; text-align: center " rowspan="2" colspan="2" class="bordered-td" >Indicaciones</td>
                <td style="font-size: 11px; text-align: center " rowspan="2" colspan="2" class="bordered-td" >Resultados</td>
            </tr>
            <tr>
                <td style="font-size: 11px; width:29px;  text-align: center " rowspan="2" class="bordered-td" >Pk</td>
                <td style="font-size: 11px; width:39px;  text-align: center " rowspan="2" class="bordered-td" >Elem.</td>
                <td style="font-size: 11px; width:39px;  text-align: center;" rowspan="2" class="bordered-td">Tipo</td>
                <td style="font-size: 11px; width:84px;  text-align: center;" colspan="3" class="bordered-td">1° Pasada</td>
                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">2° Pasada</td>
                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">3° Pasada</td>
                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">4° Pasada</td>
                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">5° Pasada</td>
                <td style="font-size: 11px; width:60px;  text-align: center;" colspan="2" class="bordered-td">6° Pasada</td>
            </tr>
            <tr>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">L</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                <td style="font-size: 11px; width:49px; text-align: center;" class="bordered-td">Posición</td>
                <td style="font-size: 11px; width:16px; text-align: center;" class="bordered-td"><span class="EspecialCaracter">ρ</span></td>
                <td style="font-size: 11px; width:50px; text-align: center;" class="bordered-td">Tipo</td>
                <td style="font-size: 11px; width:110px; text-align: center"  class="bordered-td">Posición</td>
                <td style="font-size: 11px; width:25px; text-align: center;" class="bordered-td">AP</td>
                <td style="font-size: 11px; width:25px; text-align: center;" class="bordered-td">RZ</td>

            </tr>
        </thead>
        <tbody>
            @foreach ($juntas_posiciones as $junta_posiciones)
                <tr>
                    <td style="font-size: 11px;  width:38.5px;text-align: center" class="bordered-td">
                    @if ($informe->km)

                       {{ $informe->km}}

                    @else

                        &nbsp;

                    @endif

                    </td>
                    <td style="font-size: 11px;  width:51px;text-align: center" class="bordered-td">{{$junta_posiciones->junta}} </td>
                    <td style="font-size: 11px;  width:51px;text-align: center" class="bordered-td">{{$ot_tipo_soldadura->TipoSoldadura->codigo}}</td>

                        {{ $x = 0  }}

                        <!--   Pasada 1 -->
                        @foreach ($pasadas_juntas as $key => $pasadas_junta)


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 1 ))

                                 <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>
                                  {{  $x = 1 }}

                            @endif

                           @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 1 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorl}} </td>


                            @endif

                           @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 1 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>


                            @endif

                        @endforeach

                        @if ($x == 0)

                             <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>

                        @endif

                         <!--   Pasada 2 -->

                         {{ $x = 0  }}

                         @foreach ($pasadas_juntas as $key => $pasadas_junta)


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 2 ))

                               {{  $x = 1 }}

                                 <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>


                            @endif


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 2 ))


                                 <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>


                            @endif

                        @endforeach

                           @if ($x == 0)
                             <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">&nbsp;</td>
                          @endif

                        <!--   Pasada 3 -->

                         {{ $x =0  }}

                         @foreach ($pasadas_juntas as $key => $pasadas_junta)


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 3 ))

                                 {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>


                            @endif

                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 3 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>


                            @endif

                        @endforeach

                         @if ($x == 0)
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                          @endif

                        <!--   Pasada 4 -->

                         {{ $x =0  }}

                        @foreach ($pasadas_juntas as $key => $pasadas_junta)


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 4 ))

                                {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>


                            @endif


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 4 ))


                                 <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>


                            @endif

                        @endforeach

                        @if ($x == 0)
                            <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                            <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">&nbsp;</td>
                        @endif

                        <!--   Pasada 5 -->

                        {{ $x =0  }}

                        @foreach ($pasadas_juntas as $key => $pasadas_junta)


                           @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 5 ))

                                 {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>


                            @endif


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 5 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>


                            @endif

                        @endforeach

                        @if ($x == 0)
                            <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                            <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                        @endif

                        <!--   Pasada 6 -->

                        {{ $x =0  }}

                         @foreach ($pasadas_juntas as $key => $pasadas_junta)


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 6 ))

                                 {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:37px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>


                            @endif


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 6 ))


                                 <td style="font-size: 11px;  width:37px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>


                            @endif

                        @endforeach

                        @if ($x == 0)
                            <td style="font-size: 11px;  width:37.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                            <td style="font-size: 11px;  width:37.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                        @endif

                    <td style="font-size: 11px;  width:63.5px;text-align: center" class="bordered-td">{{$junta_posiciones->codigo}}</td>

                    <!-- Defectos Posición -->

                    <!-- Densidad  -->

                    <td style="font-size: 11px;width:21.5px; text-align: center" class="bordered-td">{{$junta_posiciones->densidad}}</td>

                    <!-- Tipo -->

                    <td style="font-size: 9px;width:67.7px;  text-align: center" class="bordered-td">
                      @php $primero = true; @endphp
                        @foreach ( $defectos_posiciones as  $defectos_posicion)
                            @if ($defectos_posicion->posicion_id == $junta_posiciones->posicion_id)

                                @if (!$primero)
                                    /
                                @endif

                                {{ $defectos_posicion->codigo }}
                                {{ $primero = false}}

                            @endif

                        @endforeach

                    </td>

                    <!-- Posicion -->

                    <td style="font-size: 9px;width:110px; text-align: center" class="bordered-td">
                        @php $primero = true; @endphp
                        @foreach ( $defectos_posiciones as  $defectos_posicion)
                            @if ($defectos_posicion->posicion_id == $junta_posiciones->posicion_id)

                                @if (!$primero)
                                    /
                                @endif

                                @if ($defectos_posicion->pasada)
                                    @if ($defectos_posicion->pasada == 'RAIZ')
                                        @php
                                            $sector = 'R';
                                        @endphp
                                    @elseif ($defectos_posicion->pasada == 'RELLENO')
                                        @php
                                            $sector = 'Y';
                                        @endphp
                                    @elseif ($defectos_posicion->pasada == 'SOBREMONTA')
                                        @php
                                            $sector = 'S';
                                        @endphp
                                    @endif

                                @php
                                    $valor_imprimir = $defectos_posicion->codigo . '(' . $defectos_posicion->posicion . ')' . $sector ;
                                @endphp

                                    {{ $valor_imprimir}}
                                    {{ $primero = false}}

                                @endif
                            @endif
                        @endforeach

                    </td>

                    <!-- Resultado-->
                    <td style="font-size: 11px;width:32.7px; text-align: center; " class="bordered-td">
                        @if ($junta_posiciones->aceptable_sn == 1)
                            X
                        @endif
                    </td>

                    <td style="font-size: 11px; text-align: center;" class="bordered-td">
                        @if ($junta_posiciones->aceptable_sn == 0)
                            X
                        @endif
                    </td>
                </tr>

            @endforeach
  <!--
            {{ $cantFilasTotal = count($juntas_posiciones) }}
            {{ $filasPage = 14 }}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}

             @for ( $x=0 ;  $x < $filasACompletar ; $x++)
            <tr>
                <td style="font-size: 11px;  width:38px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:50px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:50px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:64px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;width:75px;  text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;width:93.5px; text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;width:76px; text-align: center" class="bordered-td">
                <td style="font-size: 11px;width:32.2px; text-align: center; " class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px; text-align: center;" class="bordered-td">&nbsp;</td>

            </tr>
            @endfor
    -->
        </tbody>
    </table>

    @include('reportes.informes.partial.modelos3d-landscope')

</main>

    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 692;
            $y = 60;
            $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        /*    $pdf->line(44,180,819,180,array(0,0,0),1.5);  */
        }

    </script>

</body>
</html>
