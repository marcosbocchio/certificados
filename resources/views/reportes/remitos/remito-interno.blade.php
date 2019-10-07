<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Remito</title>
</head>

<style>

@page { margin:167px 10px 53px 40px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -140px; 
   
    }

header-detalle {
    position:fixed;
    top: -21px; 
   
    }

main{
   
    margin-top: -2px;
}

footer {
    position: fixed; bottom:4px; 

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
                                <td rowspan="3" style="text-align: right; width:233px">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 18px; height: 30px; text-align: center;width:234px" rowspan="3"><b>REMITO INTERNO</b></td>
                                <td style="font-size: 13px;" colspan="2" ><b style="margin-left: 80px">REMITO N°: </b>{{FormatearNumeroConCeros($remito->prefijo,'4')}} - {{FormatearNumeroConCeros($remito->numero,'8')}}</td>                                        
                            </tr>
                            <tr>
                                <td style="font-size: 13px;" colspan="2"><b style="margin-left: 80px">FECHA: </b>{{ date('d-m-Y', strtotime($remito->fecha_hora)) }}</td>
                            </tr>                         
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 80px"></b></td>                     
                                <td style="font-size: 12px;"><b style="margin-left: 80px"></td>            
                            </tr>            
                        </tbody>
                    </table>          
                </td>
            </tr>
            <tr >
                <td class="bordered">
                    <table width="100%" >
                        <tbody>
                            <tr>                         
                                <td style="font-size: 12px;height: 20px; width: 233px;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}</td>                        
                                <td style="font-size: 12px; width: 253px;"><b>PROYECTO: </b>{{$ot->proyecto}}</td>               
                                
                                <td style="font-size: 12px;"><b>OBRA: </b>{{$ot->obra}}</td>     
                                <td style="font-size: 12px;"><b>OT N°: </b>{{$ot->numero}}</td>     
                            </tr>               
                        </tbody>
                    </table>          
                </td>
            </tr>           
        </tbody>
    </table>    
</header>

<header-detalle>
        <table style="text-align: center" width="100%" class="bordered">
            <tbody>
                    <tr >
                            <td >
                                <table  width="100%" style="text-align: center;border-collapse: collapse;">
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 12px; width:40px;  text-align: center " class="bordered-td" >CANT</td>
                                            <td style="font-size: 12px;  text-align: center;" class="bordered-td">DESCRIPCIÓN</td>                                         
                                        </tr>                         
                                    </tbody>
                                </table> 
                            </td>
                        </tr>    
            </tbody>
        </table>        

</header-detalle>

<footer>
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
             <tr >
                <td >
                    <table  width="100%" style="text-align: center;border-collapse: collapse;">
                        <tbody>
                            <tr>                             
                                <td style="font-size: 12px;  text-align: left" class="bordered-td">RESPONSABLE REMITO : {{$user->name}}</td>                                         
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
            {{ $filasPage = 51 }}
            @foreach ($detalle as $producto)
                @if (($loop->index + 1) % $filasPage != 0)
                    <tr class="bordered-0">
                        <td style="font-size: 13px;  width:41.5px;text-align: center;border-right: 1px solid #000;">{{ $producto->cantidad }}</td>     
                        <td style="font-size: 13px;  text-align: left"><span style="margin-left:5px"> {{ $producto->producto }} {{ $producto->medida}} {{ $producto->unidad_medida}} </span></td>     
                    </tr>  
                @else
                  <tr class="bordered-0">
                        <td style="font-size: 13px;  width:41.5px;text-align: center;border-right: 1px solid #000; border-bottom:2px solid #000">{{ $producto->cantidad }}</td>     
                        <td style="font-size: 13px;  text-align: left;border-bottom:2px solid #000""><span style="margin-left:5px"> {{ $producto->producto }} {{ $producto->medida}} {{ $producto->unidad_medida}} </span></td>     
                    </tr>  
                @endif

            @endforeach   

            {{ $cantFilasTotal = count($detalle) }}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}
              
            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    <td style="font-size: 13px;width:40px;border-right: 1px solid #000;">&nbsp;</td>
                    <td style="font-size: 13px">{{$x}}</td>            
                </tr>
            @endfor
          
        </tbody>
    </table>
</main>   
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 450;
        $y = 63;
        $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }

</script>


</body>
</html>