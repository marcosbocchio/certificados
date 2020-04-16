<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Análisis de rechazo y defectología</title>
</head>
<style>
 
 @page { margin: 193px 30px 194px 60px !important;
        padding: 0px 0px 0px 0px !important; }


header {
    position:fixed;
    top: -153px; 
   
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

 <body>
<header>
    <table style="text-align: center" class="bordered" width="100%">
        <tbody>
            <tr>
                <td class="bordered">
                    <table width="100%" >
                        <tbody>
                            <tr>                         
                                <td style="font-size: 11px;width: 190px;height: 45px;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}                            
                                    
                                </td>  

                                <td style="width: 140px;">
                                    @if($cliente->path)
                                    <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @else
                                     <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @endif    
                                </td>                                   

                                                    
                            </tr>    
                        </tbody>
                    </table>          
                </td>
            </tr>          
        </tbody>
    </table>
</header>

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 484;
        $y = 77;
        $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 9;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }

    $pdf->line(46.5,130,46.5,800,array(0,0,0),1.5);
    $pdf->line(571.3,130,571.3,800,array(0,0,0),1.5);

</script>
  </body>  
</html>