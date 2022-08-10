<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INTERNO EQUIPOS RI</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>

    @page { margin:230px 40px 70px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -210px;
}

main th, main td {
    border: 1px solid;  
    text-align: center;
} 

main {
      margin-top: -5px;
}

.vencidas {
    color:red;
}

.notificaciones {
    color:blue;
}

footer {
    position: fixed;  
    bottom:-0px;
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
                                    <td rowspan="4" style="width: 210px;">
                                        <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px;margin-left:2px;">
                                    </td>
                                    <td style="font-size: 18px; height: 30px;width: 295px; text-align: center;" rowspan="4"><b>INTERNO EQUIPOS RI</b></td>
                                    <td style="font-size: 10px;" ><b style="margin-left:35px;"></b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px;"><b style="margin-left: 35px;">FECHA: </b>{{ date("d-m-Y") }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b style="margin-left: 35px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;">&nbsp;</td>
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
                    <th style="font-size: 10px;width: 100px;">Modelo</th>
                    <th style="font-size: 10px;width: 190px;">Tipo equipamiento</th>               
                    <th style="font-size: 10px;width: 150px;">Usuario</th>               
                    <th style="font-size: 10px;width: 80px;">Fecha vencimiento</th>
                    <th style="font-size: 10px;">Doc.</th>
                </tr>
            </thead>
            
            <tbody>

                {{ $cantFilasTotal = count($data) }}
                {{ $filasPage = 53 }}
                {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}

                @foreach ($data as $item )
                    <tr>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->metodo }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->nro_interno }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->nro_serie }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->equipo_codigo }}</span></td>
                        <td style="font-size: 10px;"><span class="@if ($item->vencida_sn) vencidas @elseif($item->cant_notificaciones) notificaciones @endif"> {{ $item->tipo_equipamiento_codigo }}</span></td>
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
    
{{--                 @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                    <tr>
                        <td style="font-size: 10px;"><span>{{$filasACompletar}}-{{$cantFilasTotal}}</span></td>
                        <td style="font-size: 10px;"><span>&nbsp;</span></td>
                        <td style="font-size: 10px;"><span>&nbsp;</span></td>
                        <td style="font-size: 10px;"><span>&nbsp;</span></td>
                        <td style="font-size: 10px;"><span>&nbsp;</span></td>
                        <td style="font-size: 10px;"><span>&nbsp;</span></td>
                    </tr>
                @endfor --}}
            </tbody>
        </table>    
    </main>

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 445;
        $y = 50;
        $text = "PÁGINA: {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
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
