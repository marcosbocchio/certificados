<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REMITO N°: </b>{{FormatearNumeroConCeros($remito->prefijo,'4')}} - {{FormatearNumeroConCeros($remito->numero,'8')}}</title>
</head>

<style>

@page { margin: 220px 30px 45px 60px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -175px; 
   
    }

main{
   
    margin-top: -2px;
}

footer {
    position: fixed; bottom: 4.5px; 

}

.pagenum:before {
    content: counter(page);
}

.bordered {
    border-color: #000000;
    border-style: solid;
    border-width: 2px; 
    border-collapse: collapse;   
}

.bordered-1 {
    border-color: #000000;
    border-style: solid;
    border-width: 1px; 
    border-collapse: collapse;   
}

.bordered-td {
    border-color: #000000;
    border-style: solid;
    border-width: 1px; 
    border-collapse: collapse; 
}

mail tr .bordered-0 td {
    border:0;
}

b {

    margin-left: 2px;
}
</style>

<body>   

<header>
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
            <tr>
                 <td>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="text-align: right;width: 240px;">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 19px; height: 30px;width: 200px; text-align: center;margin-left: 0px" rowspan="3"><b><b>REMITO INTERNO</b></b></td>
                                <td style="font-size: 11px;"><b ></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 100px;">REMITO N°: </b>{{FormatearNumeroConCeros($remito->prefijo,'4')}} - {{FormatearNumeroConCeros($remito->numero,'8')}}</td>                   
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 100px;">FECHA: </b>{{ date('d-m-Y', strtotime($remito->fecha)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b></b></td>                     
                                <td style="font-size: 11px;"><b></td>            
                            </tr>               
                        </tbody>
                    </table>          
                </td>
            </tr>
            <tr>
                <td class="bordered" style="border-bottom: none;">
                    <table width="100%" >
                        <tbody>
                            <tr>                         
                                <td style="font-size: 11px;width: 190px;height: 45px;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}                            
                                    
                                </td>  

                                <td style="width: 140px;">
                                    @if($ot->logo_cliente_sn && $cliente->path)
                                    <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @else
                                     <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @endif    
                                </td>                                    
                            
                                <td style="font-size: 11px; width: 190px;">
                                  
                                        @if($contratista)
                                            <b>COMITENTE: </b>{{$contratista->nombre}}
                                        @endif                                               
                                 
                                </td> 
                                <td>
                                    
                                    @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                                       <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height:35px;margin-top: 5px;">
                                    @else
                                       <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 35px;margin-top: 5px;">
                                    @endif

                                </td>                                                    
                            </tr>  
                       </tbody>
                    </table>          
                </td>
            </tr> 
            <tr>
                <td>
                    <table width="100%">
                        <tbody>             
                            <tr>                                                  
                                <td style="font-size: 11px; width: 480px;"><b>PROYECTO: </b>{{$ot->proyecto}}</td>                            
                                <td style="font-size: 11px;"><b>OBRA: </b>{{$ot->obra}}</td>     
                                <td style="font-size: 11px;"><b>OT N°: </b>{{$ot->numero}}</td>     
                            </tr>   
                        </tbody>
                    </table>          
                </td>
            </tr>             
        </tbody>
    </table>

    <table width="100%" class="bordered"style="margin-top:-4px;">
        <tr >
            <td>
                <table width="100%"  style="border-collapse: collapse;">
                    <tbody>
                        <tr >
                            <td style="font-size: 12px; width:40px;  text-align: center;border-right: 2px solid black;" >CANT</td>
                            <td style="font-size: 12px;  text-align: center;"">DESCRIPCIÓN</td>                                         
                        </tr>                         
                    </tbody>
                </table> 
            </td>
        </tr>        
    </table>
    
</header>

<footer>
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
             <tr>
                <td>
                    <table  width="100%" style="text-align: center;border-collapse: collapse;">
                        <tbody>
                            <tr>                             
                                <td style="font-size: 12px;  text-align: left;" class="bordered-td">RESPONSABLE REMITO : {{$user->name}}</td>                                         
                            </tr>                         
                        </tbody>
                    </table> 
                </td>
            </tr>        
        </tbody>
    </table>
</footer>

<main>    
    <table width="100%" class="bordered">
        <tbody>      
            {{ $filasPage = 49 }}
            @foreach ($detalle as $producto)
                @if (($loop->index + 1) % $filasPage != 0)
                    <tr class="bordered-0">
                        <td style="font-size: 13px;width:41.5px;text-align: center;border-right: 2px solid #000;">{{ $producto->cantidad }}</td>     
                        <td style="font-size: 13px;text-align: left"><span style="margin-left:5px"> {{ $producto->producto }} {{ $producto->medida}} {{ $producto->unidad_medida}} </span></td>     
                    </tr>  
                @else
                  <tr class="bordered-0">
                        <td style="font-size: 13px;  width:41.5px;text-align: center;border-right: 2px solid #000; border-bottom:2px solid #000">{{ $producto->cantidad }}</td>     
                        <td style="font-size: 13px;  text-align: left;border-bottom:2px solid #000""><span style="margin-left:5px"> {{ $producto->producto }} {{ $producto->medida}} {{ $producto->unidad_medida}} </span></td>     
                    </tr>  
                @endif

            @endforeach   

            @foreach ( $remito_interno_equipos as $remito_interno_equipo )

              
                    <tr class="bordered-0">
                        <td style="font-size: 13px;  width:41.5px;text-align: center;border-right: 2px solid #000;">1</td>     
                        <td style="font-size: 13px;  text-align: left"><span style="margin-left:5px">

                         {{ $remito_interno_equipo->InternoEquipo->equipo->codigo }} - N° Serie : {{ $remito_interno_equipo->InternoEquipo->nro_serie}} - N° Int : {{$remito_interno_equipo->InternoEquipo->nro_interno}} 
                         @if ($remito_interno_equipo->InternoEquipo->internoFuente)
                             
                         - Fuente : {{$remito_interno_equipo->InternoEquipo->internoFuente->fuente->codigo}}

                         @endif
                         
                          </span></td>     
                    </tr>  
              
                
            @endforeach

            {{ $cantFilasTotal = count($detalle) + count($remito_interno_equipos) }}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}
              
            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    <td style="font-size: 13px;width:40px;border-right: 2px solid #000;">&nbsp;</td>
                    <td style="font-size: 13px"></td>            
                </tr>
            @endfor
          
        </tbody>
    </table>
</main>   
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 460;
        $y = 82;
        $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
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