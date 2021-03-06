<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REFERENCIA INFORME N°: {{FormatearNumeroInforme($informe->numero,'LP')}}</title>
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
                 <td>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="text-align: right;width: 240px;">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 19px; height: 30px;width: 200px; text-align: center;margin-left: 0px" rowspan="3"><b>LÍQUIDOS PENETRANTES</b></td>
                                <td style="font-size: 11px;"><b ></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 131px;">INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'LP')}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 131px;">FECHA: </b>{{ date('d-m-Y', strtotime($informe->fecha)) }}</td>
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
            <tr>
                <td class="bordered">
                    <table>
                        <tbody>
                            <tr>
                                <td style="font-size: 12px;" > <b>ELEMENTO: </b>  {{$detalle_lp->pieza}}</td>  
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
                                    <td style="font-size: 12px;" colspan="6" class="bordered-td"><b>Observaciones: </b>{{$detalle_lp_referencia->descripcion}}</td>                                  
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
                                <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>EVALUADOR </b></td>   
                                <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>COMITENTE </b></td> 
                                <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>COMITENTE </b></td>                              
                                </tr>
                                
                                <tr>                               
                                    <td style="font-size: 11px; text-align: left; height: 25px;width:75px;"><span style="margin-left: 2px">FIRMA:</span></td>   

                                    <td style="text-align:left ;font-size: 11px; border-right: 1px solid #000;width: 150px;margin-left: 15px;" rowspan="2">
                                        @if($evaluador && $evaluador->path)
                                        <img src="{{ public_path($evaluador->path)}}" alt="" style="width: 100px;height: 50px;">
                                        @endif
                                    </td> 

                                    <td style="font-size: 11px; text-align: left; height: 25px; border-right: 1px solid #000;" colspan="2"> <span style="margin-left: 2px">FIRMA:</span></td> 
                                    
                                    <td style="font-size: 11px; text-align: left; height: 25px; border-right: 1px solid #000;" colspan="2"><span style="margin-left: 2px">FIRMA:</span></td>
                                                            
                                </tr>
                            
                                <tr>                               
                                    <td style="font-size: 11px; text-align: left; height: 25px;width:75px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>   
                                    <td style="font-size: 11px; text-align: left; height: 25px; border-right: 1px solid #000;" colspan="2"><span style="margin-left: 2px">ACLARACIÓN:</span></td>
                                    <td style="font-size: 11px; text-align: left; height: 25px; border-right: 1px solid #000;" colspan="2"><span style="margin-left: 2px">ACLARACIÓN:</span></td>                       
                                </tr>
                            </tbody>
                        </table> 
                    </td>
                </tr>      
            </tbody>
        </table>
    </footer>

<main>
    <table style="text-align: center" class="" width="100%">
        <tbody>            
                <tr>
                    <td>                     
                        <table>    
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                            @if ($detalle_lp_referencia->path1!='/img/imagen1.jpg')
                                                <img src="{{ public_path($detalle_lp_referencia->path1) }}" alt="" style="height: 160; width: 234;">
                                            @endif  
                                            
                                    </td>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($detalle_lp_referencia->path2!='/img/imagen2.jpg')
                                            <img src="{{  public_path($detalle_lp_referencia->path2) }}" alt="" style="height: 160; width: 234;">
                                        @endif  
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($detalle_lp_referencia->path3!='/img/imagen3.jpg')
                                            <img src="{{  public_path($detalle_lp_referencia->path3) }}" alt="" style="height: 160; width: 234;">
                                    @endif  
                                    </td>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($detalle_lp_referencia->path4!='/img/imagen4.jpg')
                                            <img src="{{  public_path($detalle_lp_referencia->path4) }}" alt="" style="height: 160; width: 234;">
                                    @endif  
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
        </tbody>
    </table>
</main>

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