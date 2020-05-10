<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REMITO N°: </b>{{FormatearNumeroConCeros($remito->prefijo,'4')}} - {{FormatearNumeroConCeros($remito->numero,'8')}}</title>
</head>

<style>

@page { margin: 222px 30px 30px 60px !important;
        padding: 0px 0px 0px 0px !important; }

body {
    margin: 0px 1px 0px 1px;
    padding: 0 0 0 0;
}

header {
    position:fixed;
    top: -177px; 
   
    }

main{
   
    margin-top: -2px;
}

footer {
    position: fixed; bottom: 5px; 

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

<body class="bordered" style="border-top: none;border-bottom: none;">  

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
             @include('reportes.informes.partial.header-portrait')           
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
    <table width="100%" class="bordered" style="padding: 0 -3px 0 -3px;border-bottom: none;" >
        <tbody>      

            @foreach ($detalle as $producto)

                    <tr class="bordered-0">
                        <td style="font-size: 13px;width:41.5px;text-align: center;">{{ $producto->cantidad }}</td>     
                        <td style="font-size: 13px;text-align: left"><span style="margin-left:5px"> {{ $producto->producto }} {{ $producto->medida}} {{ $producto->unidad_medida}} </span></td>     
                    </tr>  

            @endforeach   

            @foreach ( $remito_interno_equipos as $remito_interno_equipo )

              
                    <tr class="bordered-0">
                        <td style="font-size: 13px;  width:41.5px;text-align: center;">1</td>     
                        <td style="font-size: 13px;  text-align: left"><span style="margin-left:5px">

                         {{ $remito_interno_equipo->InternoEquipo->equipo->codigo }} - N° Serie : {{ $remito_interno_equipo->InternoEquipo->nro_serie}} - N° Int : {{$remito_interno_equipo->InternoEquipo->nro_interno}} 
                         @if ($remito_interno_equipo->InternoEquipo->internoFuente)
                             
                         - Fuente : {{$remito_interno_equipo->InternoEquipo->internoFuente->fuente->codigo}}

                         @endif
                         
                          </span></td>     
                    </tr>  
              
            @endforeach

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

    $pdf->line(80,152,80,818,array(0,0,0),1.5);


</script>


</body>
</html>