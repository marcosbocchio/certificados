<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Remito</title>
</head>

<style>

@page { margin: 319px 10px 141px 40px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -280px; 
   
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
                                <td rowspan="4" style="text-align: right; width:233px">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 18px; height: 30px; text-align: center;width:234px" rowspan="4"><b>REMITO INTERNO</b></td>
                                <td style="font-size: 13px; margin-left: 90px " ><b>REMITO N°: </b>{{FormatearNumeroConCeros($remito->prefijo,'4')}}-{{FormatearNumeroConCeros($remito->numero,'8')}}</td>                                        
                            </tr>
                            <tr>
                                <td style="font-size: 13px;"><b style="margin-left: 80px">FECHA: </b>{{ date('d-m-Y', strtotime($remito->fecha_hora)) }}</td>
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

<footer>
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
            <tr>
                <td>
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>                           
                            <tr>                                
                                <td style="font-size: 12px;" colspan="6" class="bordered-td"><b>Observaciones: </b></td>                                  
                            </tr>                         
                        </tbody>
                    </table>
                </td>               
            </tr>
            <tr>
                <td>
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>
                            <tr>                               
                               <td style="font-size: 13px; text-align: center" class="bordered-td" ><b>EVALUADOR </b></td>   
                               <td style="font-size: 13px; text-align: center" class="bordered-td" ><b>CONTRATISTA </b></td> 
                               <td style="font-size: 13px; text-align: center" class="bordered-td"><b>CLIENTE </b></td>                               
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td>   
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td> 
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td>                              
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>   
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>  
                     
                            </tr>
                        </tbody>
                    </table> 
                </td>
            </tr>      
        </tbody>
    </table>
</footer>
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 451;
        $y = 70;
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