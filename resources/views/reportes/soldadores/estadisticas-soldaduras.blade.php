<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Análisis de rechazo y defectología</title>
</head>
<style>
 
 @page { margin: 160px 40px 50px 40px !important;
        padding: 0px 0px 0px 0px !important; }

body {
    margin: 0px 1px 0px 1px;
    padding: 0 0 0 0;
}
header {
    position:fixed;
    top: -113px; 
   
    }
footer {
    position: fixed; bottom: -59px; 

}

.bordered {
    border-color: #000000;
    border-style: solid;
    border-width: 2px; 
    border-collapse: collapse;   
}

.bordered-td {
    border-color: #000000;
    border-style: solid;
    border-width: 1px; 
    border-collapse: collapse; 
}

b {

    margin-left: 2px;
}

</style>

 <body class="bordered" style="border-top: none;">
<header>
    <table style="text-align: center" class="bordered" width="100%">
        <tbody>
            <tr>
                <td class="bordered">
                    <table width="100%" >
                        <tbody>
                            <tr>
                                <td  colspan="4">&nbsp;</td>
                            </tr>
                            <tr>   
                                <td style="width:40px;" rowspan="1">
                                    @if($cliente->path)
                                    <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @else
                                     <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @endif    
                                </td>                                   
                                <td style="font-size: 14px;width: 140px;height: 45px;"rowspan="1"><b>{{$cliente->nombre_fantasia}}</b></td>      
                                <td style="font-size: 14px;width: 340px;"rowspan="1"><b>ANÁLIS DE RECHAZO Y DEFECTOLOGÍA</b></td>      
                                <td rowspan="1">logo</td>                                         
                            </tr>
                            <tr>
                                <td style="font-size: 12px;text-align: center;" colspan="4"><b>OBRA : {{ $obra}} / (ubicación)</b></td>
                            </tr>
                            <tr >
                                <td colspan="4" style="font-size: 12px;text-align: center;"><b>FECHA : Desde {{ $fecha_desde}} / hasta  {{$fecha_hasta}}</b></td>
                            </tr>    
                        </tbody>
                    </table>          
                </td>
            </tr>          
        </tbody>
    </table>
</header>
<main>

    <h5 style="margin-left: 5px;">ÍNDICE DE RECHAZO DE SOLDADURAS</h5>

    <h5 style="margin-left: 5px;">Totales Período Análisis</h5>


    @php 
         $total_costuras_aprobadas_porcentaje = number_format(($total_costuras_aprobadas * 100) / $total_costuras_radiografiadas,1);
         $total_costuras_rechazadas_porcentaje = number_format(100 - $total_costuras_aprobadas_porcentaje,1) ;
         $total_posiciones_aprobadas_porcentaje = number_format(($total_posiciones_aprobadas * 100) / $total_posiciones_radiografiadas,1);
         $total_posiciones_rechazadas_porcentaje = number_format(100 - $total_posiciones_aprobadas_porcentaje,1);
    @endphp

    <table style="text-align: center;margin-top: 20px;border-collapse: collapse;" width="100%" >
        <tbody >
            <tr> 
                <td style="width: 50px;">&nbsp;</td>
                <td style="font-size: 10px;text-align: left;"class="bordered-td">COSTURAS RADIOGRAFIADAS</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_costuras_radiografiadas }}</td>
                <td style="width: 35px;">&nbsp;</td>
                <td style="width: 35px;">&nbsp;</td>
                <td style="font-size: 10px;text-align: left;"class="bordered-td">POSICIONES RADIOGRAFIADAS</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_posiciones_radiografiadas }}</td>
                <td style="width: 35px;">&nbsp;</td>
                <td style="width: 50px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 50px;">&nbsp;</td>
                <td style="font-size: 10px;text-align: left;"class="bordered-td">COSTURAS APROBADAS</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_costuras_aprobadas }}</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_costuras_aprobadas_porcentaje }} %</td>
                <td style="width: 35px;">&nbsp;</td>
                <td style="font-size: 10px;text-align: left;"class="bordered-td">POSICIONES APROBADAS</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_posiciones_aprobadas }}</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_posiciones_aprobadas_porcentaje }} %</td>
                <td style="width: 50px;">&nbsp;</td>                    
            </tr>
            <tr>
                <td style="width: 50px;">&nbsp;</td>
                <td style="font-size: 10px;text-align: left;"class="bordered-td">COSTURAS RECHAZADAS</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_costuras_rechazadas }}</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_costuras_rechazadas_porcentaje }} %</td>
                <td style="width: 35px;">&nbsp;</td>
                <td style="font-size: 10px;text-align: left;"class="bordered-td">POSICIONES RECHAZADAS</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_posiciones_rechazadas }}</td>
                <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $total_posiciones_rechazadas_porcentaje }} %</td>
                <td style="width: 50px;">&nbsp;</td>                    
            </tr>
        </tbody>
    </table>


    @foreach ($estadisticasGenerales as $item)

    @php 
         $costuras_aprobadas_porcentaje = number_format(($item->costuras_aprobadas * 100) / $item->costuras_radiografiadas,1);
         $costuras_rechazadas_porcentaje = number_format(100 - $costuras_aprobadas_porcentaje,1) ;
         $posiciones_aprobadas_porcentaje = number_format(($item->posiciones_aprobadas * 100) / $item->posiciones_radiografiadas,1);
         $posiciones_rechazadas_porcentaje = number_format(100 - $posiciones_aprobadas_porcentaje,1);
    @endphp
   
    <h6 style="margin-left: 5px;">{{ $item->titulo}}</h6>
    <table style="text-align: center;margin-top: 20px;border-collapse: collapse;" width="100%" >
            <tbody >
                <tr> 
                    <td style="width: 50px;">&nbsp;</td>
                    <td style="font-size: 10px;text-align: left;"class="bordered-td">COSTURAS RADIOGRAFIADAS</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $item->costuras_radiografiadas }}</td>
                    <td style="width: 35px;">&nbsp;</td>
                    <td style="width: 35px;">&nbsp;</td>
                    <td style="font-size: 10px;text-align: left;"class="bordered-td">POSICIONES RADIOGRAFIADAS</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $item->posiciones_radiografiadas }}</td>
                    <td style="width: 35px;">&nbsp;</td>
                    <td style="width: 50px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width: 50px;">&nbsp;</td>
                    <td style="font-size: 10px;text-align: left;"class="bordered-td">COSTURAS APROBADAS</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $item->costuras_aprobadas }}</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $costuras_aprobadas_porcentaje }} %</td>
                    <td style="width: 35px;">&nbsp;</td>
                    <td style="font-size: 10px;text-align: left;"class="bordered-td">POSICIONES APROBADAS</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $item->posiciones_aprobadas }}</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $posiciones_aprobadas_porcentaje }} %</td>
                    <td style="width: 50px;">&nbsp;</td>                    
                </tr>
                <tr>
                    <td style="width: 50px;">&nbsp;</td>
                    <td style="font-size: 10px;text-align: left;"class="bordered-td">COSTURAS RECHAZADAS</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $item->costuras_rechazadas }}</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $costuras_rechazadas_porcentaje }} %</td>
                    <td style="width: 35px;">&nbsp;</td>
                    <td style="font-size: 10px;text-align: left;"class="bordered-td">POSICIONES RECHAZADAS</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $item->posiciones_rechazadas }}</td>
                    <td style="font-size: 10px;text-align: center;width: 35px;"class="bordered-td">{{ $posiciones_rechazadas_porcentaje }} %</td>
                    <td style="width: 50px;">&nbsp;</td>                    
                </tr>
            </tbody>
        </table>
        
    @endforeach
    <table>
    </table>
</main>
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 490;
        $y = 97;
        $text_pagina = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $text_titulo = "INFORME FINAL";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 9;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text_pagina, $font, $size, $color, $word_space, $char_space, $angle);
        $size = 12;
        $x = 260;
        $y = 45;
        $pdf->page_text($x, $y, $text_titulo, $font, $size, $color, $word_space, $char_space, $angle);
    }

</script>
  </body>  
</html>