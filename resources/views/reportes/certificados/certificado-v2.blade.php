<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CERTIFICADO Nº: {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 250px 40px 215px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -235px;
}

footer {
    position: fixed; bottom:0px;
    padding-top: 0px;
}

</style>

<body>
<header>
    @include('reportes.certificados.partial.header-principal-landscape')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.partial.header-cliente-comitente-landscape')
    @include('reportes.partial.linea-gris')
    @include('reportes.certificados.partial.header-proyecto-landscape')
    @include('reportes.partial.linea-amarilla')
</header>
<footer>

    @include('reportes.partial.linea-amarilla')

    <table width="100%" class="bordered-td" style="margin-top: 8px;">
        <tbody>
            <tr>
                @for ( $x=0 ; $x< 3 ;$x++)
                    @if(isset($servicios_footer[$x]))
                            <td style="font-size: 11px; width:33.33%px " class="bordered-td"><b>{{ $servicios_footer[$x]->abreviatura }}: </b>{{ $servicios_footer[$x]->descripcion_servicio }}</td>
                    @else
                            <td style="font-size: 11px; " class="bordered-td">&nbsp;</td>
                    @endif
                @endfor

            </tr>
            <tr>
                @for ( $x=3 ; $x< 6;$x++)
                    @if(isset($servicios_footer[$x]))
                            <td style="font-size: 11px; width:33.33%px " class="bordered-td"><b>{{ $servicios_footer[$x]->abreviatura }}: </b>{{ $servicios_footer[$x]->descripcion_servicio }}</td>
                    @else
                            <td style="font-size: 11px; " class="bordered-td">&nbsp;</td>
                    @endif
                @endfor

            </tr>

            <tr>
                @for ( $x=6 ; $x< 9 ;$x++)
                    @if(isset($servicios_footer[$x]))
                            <td style="font-size: 11px; width:33.33%px " class="bordered-td"><b>{{ $servicios_footer[$x]->abreviatura }}: </b>{{ $servicios_footer[$x]->descripcion_servicio }}</td>
                    @else
                            <td style="font-size: 11px; " class="bordered-td">&nbsp;</td>
                    @endif
                @endfor

            </tr>
        </tbody>
    </table>

    @include('reportes.partial.linea-amarilla')
    @include('reportes.certificados.partial.firma')

</footer>


<main>

@if($certificado->info_pedido_cliente)

    <table width="100%" style="border-collapse: collapse;border: 1px solid black;margin-bottom: 5px;">
        <tbody>
            <tr>
                <td style="background:#D8D8D8;text-align: left;font-size: 13px;"><span style="margin-left: 2px;"> {{$certificado->info_pedido_cliente}}</span> &nbsp;</td>
            </tr>
        </tbody>
    </table>

@endif

<table width="100%" class="bordered-td" style="text-align: center;" >
    <thead>
        <tr>
          {{ $unidad_medida = ($modalidadCobro == 'COSTURAS') ? '"' : 'Cm'}}
           <th style="font-size: 12px; width:60px" class="bordered-td"  rowspan="2">Día</th>
           <th style="font-size: 12px;width:60px" class="bordered-td" rowspan="2">Parte</th>
           @if(!$ot->obra)
                <th style="font-size: 12px;width:40px" class="bordered-td" rowspan="2">Obra</th>
           @endif
           <th style="font-size: 12px;" class="bordered-td" colspan="9" >SERVICIOS</th>
           <th style="font-size: 12px;" class="bordered-td" colspan="17">
                 {{ $modalidadCobro }} EN {{ $unidad_medida}}
           </th>
        </tr>
        <tr>
        {{ $cant_servicios_parte = count($servicios_abreviaturas) }}
        {{ $cant_productos_parte = count($productos_unidades_medidas) }}

        @foreach ($servicios_abreviaturas as $item)
            <th style="font-size: 10px;width: 33px;" class="bordered-td">{{ $item }}</th>
        @endforeach

        @for ($x =$cant_servicios_parte ; $x <9 ; $x++)
           <th style="font-size: 11px;" class="bordered-td">&nbsp;</th>
        @endfor

        @foreach ($productos_unidades_medidas as $item)
            <th style="font-size: 12px;" class="bordered-td">{{ $item }}
                @if ($modalidadCobro == 'COSTURAS')
                    {{ $unidad_medida}}
                @endif
            </th>
        @endforeach

        @for ($x =$cant_productos_parte ; $x <17 ; $x++)
           <th style="font-size: 12px;" class="bordered-td">&nbsp;</th>
        @endfor

        </tr>
    </thead>
    <tbody>
        @foreach ($partes_certificado as $item_partes_certificado )

            <tr>
                <td style="font-size: 12px;" class="bordered-td">{{$item_partes_certificado->fecha_formateada}}</td>
                <td style="font-size: 12px;" class="bordered-td">{{$item_partes_certificado->parte_numero}}</td>
                @if (!$ot->obra)

                    <td style="font-size: 12px;" class="bordered-td">{{$item_partes_certificado->obra}}</td>

                @endif

           <!-- INSERTO LOS SERVICIOS EN LA TABLA -->

            @foreach ($servicios_abreviaturas as $item_servicios_abreviaturas)
                {{ $existeServicioEnParte = false }}

                @foreach ($servicios_parte as $item_servicios_parte)

                    @if (($item_servicios_abreviaturas == $item_servicios_parte->abreviatura)&&($item_servicios_parte->parte_numero == $item_partes_certificado->parte_numero))
                             <td style="font-size: 12px;" class="bordered-td">{{$item_servicios_parte->cantidad}}</td>

                             {{ $existeServicioEnParte = true }}
                    @endif

                @endforeach

                @if (!$existeServicioEnParte)

                    <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>

                @endif


            @endforeach

            @for ( $x=$cant_servicios_parte  ;  $x < 9 ; $x++)
                <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
            @endfor
        <!-- INSERTO LOS PRODUCTOS EN LA TABLA -->

            @foreach ($productos_unidades_medidas as $item_productos_unidades_medidas)
                {{ $existeProductoEnParte = false }}

                @foreach ($productos_parte as $item_productos_parte)

                    @if (($item_productos_unidades_medidas == $item_productos_parte->unidad_medida_producto)&&($item_productos_parte->parte_numero == $item_partes_certificado->parte_numero))
                             <td style="font-size: 12px;" class="bordered-td">{{ $item_productos_parte->cantidad }} </td>
                             {{ $existeProductoEnParte = true }}
                    @endif


                @endforeach

                @if (!$existeProductoEnParte)

                    <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>

                @endif

            @endforeach


            @for ( $x=$cant_productos_parte ;  $x < 17 ; $x++)
                <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
            @endfor
          </tr>

          <!-- TERMINÓ DE PONER LOS PRODUCTOS -->

        @endforeach

          <!-- AGREGO LOS TOTALES -->

            <tr>
                @if (!$ot->obra)
                    <td style="font-size: 12px;" colspan='3' class="bordered-td">Total </td>
                @else
                     <td style="font-size: 12px;" colspan='2' class="bordered-td">Total </td>
                @endif

                <!--SERVICIOS -->

                @foreach ($servicios_abreviaturas as $item_servicios_abreviaturas)

                    {{ $total_servicio = 0 }}

                    @foreach ($servicios_parte as $item_servicios_parte)
                        @if ($item_servicios_abreviaturas == $item_servicios_parte->abreviatura)
                            {{ $total_servicio = $total_servicio + $item_servicios_parte->cantidad}}
                        @endif
                    @endforeach
                    <td style="font-size: 12px;" class="bordered-td">{{ $total_servicio }}</td>
                @endforeach

                @for ( $x=$cant_servicios_parte  ;  $x < 9 ; $x++)
                    <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                @endfor


                <!--PRODUCTOS -->

                @foreach ($productos_unidades_medidas as $item_productos_unidades_medidas)

                    {{ $total_producto = 0 }}

                    @foreach ($productos_parte as $item_productos_parte)
                        @if ($item_productos_unidades_medidas == $item_productos_parte->unidad_medida_producto)
                            {{ $total_producto = $total_producto + $item_productos_parte->cantidad}}
                        @endif
                    @endforeach
                    <td style="font-size: 12px;" class="bordered-td">{{ $total_producto }}
                    </td>
                @endforeach

                @for ( $x=$cant_productos_parte  ;  $x < 17 ; $x++)
                    <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                @endfor

            </tr>

    </tbody>
</table>

<!-- AGREGO LOS CUADROS POR OBRA -->
@php

    $cant_obras = count($obras);
    $filasObras = intdiv($cant_obras,3);
    $resto = $cant_obras % 3;
    if($resto > 0){
        $filasObras++;
    }

@endphp
<table style="padding: 0 -3px 0 -3px;">
    <tbody>
        @for ($x =0 ; $x < $filasObras ; $x++)

            <tr>
                <td width="400px">

                    @if (isset($tablas_por_obras[$x*3]))

                        <table class="bordered-td">
                            <thead>
                                <tr>
                                    <th style="font-size: 12px; width:255px;text-align: center;" class="bordered-td"  colspan="2">Obra : {{ $tablas_por_obras[$x*3]->obra }}</th>
                                </tr>
                                <tr>
                                    <th style="font-size: 12px; width:125px;text-align: center;"class="bordered-td">Servicios</th>
                                    <th style="font-size: 12px; width:125px;text-align: center;" class="bordered-td">{{ $modalidadCobro }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{ $cant_total_servicio = count($tablas_por_obras[$x*3]->servicios) }}
                                {{ $cant_total_producto = count($tablas_por_obras[$x*3]->productos) }}

                                {{ $filas_total = $cant_total_servicio > $cant_total_producto ? $cant_total_servicio : $cant_total_producto }}

                                @for ( $z=0 ;  $z< $filas_total  ; $z++)

                                    <tr>
                                        @if (isset($tablas_por_obras[$x*3]->servicios[$z]))
                                            <td style="font-size: 12px;" class="bordered-td"> {{$tablas_por_obras[$x*3]->servicios[$z]->servicio }} : {{$tablas_por_obras[$x*3]->servicios[$z]->cant_total_servicio }} </td>
                                        @else
                                        <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                                        @endif

                                    @if (isset($tablas_por_obras[$x*3]->productos[$z]))
                                    <td style="font-size: 12px;" class="bordered-td">&nbsp;{{$tablas_por_obras[$x*3]->productos[$z]->producto }} {{ $unidad_medida}} : {{$tablas_por_obras[$x*3]->productos[$z]->cant_total_producto }}</td>
                                        @else
                                        <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                                        @endif

                                    </tr>
                                @endfor
                            </tbody>
                        </table>

                    @endif
                </td>
                <td width="400px">

                @if (isset($tablas_por_obras[($x*3)+1]))

                        <table class="bordered-td">
                            <thead>
                                <tr>
                                    <th style="font-size: 12px; width:255px;text-align: center;" class="bordered-td"  colspan="2">Obra : {{ $tablas_por_obras[($x*3)+1]->obra }}</th>
                                </tr>
                                <tr>
                                    <th style="font-size: 12px; width:125px;text-align: center;" class="bordered-td">Servicios</th>
                                    <th style="font-size: 12px; width:125px;text-align: center;" class="bordered-td">{{ $modalidadCobro }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{ $cant_total_servicio = count($tablas_por_obras[($x*3)+1]->servicios) }}
                                {{ $cant_total_producto = count($tablas_por_obras[($x*3)+1]->productos) }}

                                {{ $filas_total = $cant_total_servicio > $cant_total_producto ? $cant_total_servicio : $cant_total_producto }}

                                @for ( $z=0 ;  $z< $filas_total  ; $z++)

                                    <tr>
                                        @if (isset($tablas_por_obras[($x*3)+1]->servicios[$z]))
                                            <td style="font-size: 12px;" class="bordered-td"> {{$tablas_por_obras[($x*3)+1]->servicios[$z]->servicio }} : {{$tablas_por_obras[($x*3)+1]->servicios[$z]->cant_total_servicio }} </td>
                                        @else
                                        <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                                        @endif

                                    @if (isset($tablas_por_obras[($x*3)+1]->productos[$z]))
                                    <td style="font-size: 12px;" class="bordered-td">&nbsp;{{$tablas_por_obras[($x*3)+1]->productos[$z]->producto }} {{ $unidad_medida}} : {{$tablas_por_obras[($x*3)+1]->productos[$z]->cant_total_producto }}</td>
                                        @else
                                        <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                                        @endif

                                    </tr>
                                @endfor
                            </tbody>
                        </table>

                    @endif
                </td>
                <td width="400px">

                @if (isset($tablas_por_obras[($x*3)+2]))

                        <table class="bordered-td">
                            <thead>
                                <tr>
                                    <th style="font-size: 12px; width:255px;text-align: center;" class="bordered-td"  colspan="2">Obra : {{ $tablas_por_obras[($x*3)+2]->obra }}</th>
                                </tr>
                                <tr>
                                    <th style="font-size: 12px; width:125px;text-align: center;" class="bordered-td">Servicios</th>
                                    <th style="font-size: 12px; width:125px;text-align: center;" class="bordered-td">{{ $modalidadCobro }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{ $cant_total_servicio = count($tablas_por_obras[($x*3)+2]->servicios) }}
                                {{ $cant_total_producto = count($tablas_por_obras[($x*3)+2]->productos) }}

                                {{ $filas_total = $cant_total_servicio > $cant_total_producto ? $cant_total_servicio : $cant_total_producto }}

                                @for ( $z=0 ;  $z< $filas_total  ; $z++)

                                    <tr>
                                        @if (isset($tablas_por_obras[($x*3)+2]->servicios[$z]))
                                            <td style="font-size: 12px;" class="bordered-td"> {{$tablas_por_obras[($x*3)+2]->servicios[$z]->servicio }} : {{$tablas_por_obras[($x*3)+2]->servicios[$z]->cant_total_servicio }} </td>
                                        @else
                                        <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                                        @endif

                                    @if (isset($tablas_por_obras[($x*3)+2]->productos[$z]))
                                    <td style="font-size: 12px;" class="bordered-td">&nbsp;{{$tablas_por_obras[($x*3)+2]->productos[$z]->producto }} {{ $unidad_medida}} : {{$tablas_por_obras[($x*3)+2]->productos[$z]->cant_total_producto }}</td>
                                        @else
                                        <td style="font-size: 12px;" class="bordered-td">&nbsp;</td>
                                        @endif

                                    </tr>
                                @endfor
                            </tbody>
                        </table>

                    @endif
                </td>
            </tr>
        @endfor
    </tbody>
</table>

</main>

    <script type="text/php">

          if ( isset($pdf) ) {
            $x = 692;
            $y = 63;
            $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

            /* $pdf->line(34,167,561,167,array(0,0,0),1.5); */
        }

    </script>

</body>
</html>
