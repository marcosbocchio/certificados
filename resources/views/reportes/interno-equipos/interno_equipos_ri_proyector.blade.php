<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INTERNO EQUIPOS RI</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>

    @page {
        margin: 217px 15px 50px 15px !important;
        padding: 0px 0px 0px 0px !important;
        height: 100%;
       }
    header {
    position:fixed;
    top: -210px;
}

main th, main td {
    border: 1px solid;
    text-align: center;
}

main {
      margin-top: 0px;
}

.vencidas {
    color:red;
}

.notificaciones {
    color:blue;
}

footer {
    position: fixed; bottom:0.0px;
    padding-top: 0px;

}

.pagenum:before {
    content: counter(page);
}

</style>

<body>
    <header>
        <table style="text-align: center;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td rowspan="4" style="text-align: right; width:253px">
                                        <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                    </td>

                                    <td style="font-size: 22px; height: 30px; text-align: center;width:534px;" rowspan="2"><b>INTERNO EQUIPOS RI</b></td>
                                    <td style="font-size: 11px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px;"><b style="margin-left: 120px;">FECHA: </b>{{ date("d-m-Y") }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b style="margin-left: 120px"></b></td>
                                    <td style="font-size: 11px;"><b style="margin-left: 120px"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        @include('reportes.partial.linea-amarilla')
        <table class="header-detalle-principal" style="margin-top: 10px">
            <tbody>
                <tr>
                    <td width="49%">
                        <table style="font-size: 12px;" width="100%" class="header-detalle">
                            <tbody>
                                <tr>
                                    <th colspan="4" >Documentación Vencida</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        @if ($vencidas_sn)
                                          SI
                                        @else
                                          NO
                                        @endif

                                    </td>
                                </tr>

                               <tr>
                                   <th colspan="4">Sin Cert. Verif / Doc.</th>
                                </tr>
                               <tr>
                                   <td colspan="4">
                                        @if ($todos_sn)
                                            SI
                                        @else
                                            NO
                                        @endif
                                    </td>
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
                                    <th colspan="4" >Documentación NO Vencida</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        @if ($noVencidas_sn)
                                          SI
                                        @else
                                          NO
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                   <th colspan="4">Tipo equipamiento</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                         @if ($tipo_equipamiento)
                                             {{$tipo_equipamiento->codigo}}
                                         @else
                                             TODOS
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

    </header>

    <footer>
        <table width="100%" class="bordered">
            <tbody>
                <tr>
                    <td style="font-size: 12px;height: 18px;width:75px;height: 30px"><span class="EspecialCaracter" style="margin-left:5px;color:red">█ </span>Vencidas</td>
                    <td style="font-size: 12px;height: 18px"><span class="EspecialCaracter" style="margin-left:5px;color:blue">█ </span>Notificado</td>
                </tr>
            </tbody>
        </table>
    </footer>

    <main>
        <table width="100%" class="bordered">
            <thead>
               <tr>
                    <th style="font-size: 10px;width: 40px;">Método</th>
                    <th style="font-size: 10px;width: 40px;"><b>N° Int</b></th>
                    <th style="font-size: 10px;width: 60px;">N° Serie</th>
                    <th style="font-size: 10px;width: 225px;">Modelo</th>
                    <th style="font-size: 10px;width: 225px;">Fuente</th>
                    <th style="font-size: 10px;width: 80px;">Ubicacion</th>
                    <th style="font-size: 10px;width: 80px;">Actividad</th>
                    <th style="font-size: 10px;width: 200px;">Usuario</th>
                    <th style="font-size: 10px;width: 80px;">Fecha vencimiento</th>
                    <th style="font-size: 10px;">Doc.</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($data as $item )
                    <tr>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->metodo }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->nro_interno }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->nro_serie }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->equipo_codigo }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ isset($item->nro_serie_fuente) ? $item->nro_serie_fuente . ' - ' : '' }}{{ $item->codigo_fuente ?? ''}}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->ubicacion }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ isset($item->curie_actual) ? $item->curie_actual . ' Ci' : '' }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->name }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->fecha_cad_formateada }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif">
                            @if ($item->path)
                                 <a href="{{ URL::to('/') . '/' . $item->path }}" target="_blank"><img src="{{ public_path('img/fa-file-pdf.png')}}" alt="" style="height: 12px;margin-left:3px;;margin-top:2px;text-align: center;"></a>
                            @else
                                &nbsp;
                            @endif

                        </span></td></tr>
                @endforeach
            </tbody>
        </table>
    </main>

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 702;
        $y = 45;
        $text = "PÁGINA: {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 9;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }

</script>

</body>

</html>
