<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Referencia</title>
</head>
<style>
 
 @page { margin: 193px 1px 194px 49px !important;
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
                                <td rowspan="4" style="text-align: right; width:233px">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 18px; height: 30px; text-align: center;width:234px" rowspan="3"><b>INFORME LÍQUIDOS PENETRANTES</b></td>
                                <td style="font-size: 12px;"><b style="margin-left: 40px"></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 12px;" ><b style="margin-left: 120px" >INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'LP')}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 120px">FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 120px"></b></td>                     
                                <td style="font-size: 12px;"><b style="margin-left: 120px"></td>            
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
            <tr>
                <td class="bordered">
                    <table>
                        <tbody>
                            <tr>
                                <td style="font-size: 13px;" > <b>PIEZA: </b>  {{$detalle_lp->pieza}} &nbsp;&nbsp; <b>N°: </b>{{$detalle_lp->numero}}</td>  
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
                                    <td style="font-size: 13px; text-align: center;width:170px" colspan="2" class="bordered-td" ><b>EVALUADOR </b></td>   
                                    <td style="font-size: 13px; text-align: center;width:230px" colspan="2" class="bordered-td" ><b>CONTRATISTA </b></td> 
                                    <td style="font-size: 13px; text-align: center;width:230px" colspan="2" class="bordered-td"><b>CLIENTE </b></td>                              
                                    </tr>
                                <tr>                               
                                    <td style="font-size: 12px; text-align: left; height: 25px;width:50px;"><span style="margin-left: 2px">FIRMA:</span></td>   
                                    <td style="font-size: 12px; border-right: 1px solid #000;" rowspan="2">
                                    @if($evaluador && $evaluador->path)
                                            <img src="{{ public_path($evaluador->path)}}" alt="" style="height: 60px;margin:0 0 0 0px;">
                                    @endif
                                    </td> 
                                    <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">FIRMA:</span></td> 
                                    <td style="font-size: 12px; border-right: 1px solid #000;" rowspan="2"></td>
                                    <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">FIRMA:</span></td>
                                    <td style="font-size: 12px; border-right: 1px solid #000;" rowspan="2"></td>                              
                                </tr>
                                <tr>                               
                                    <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>   
                                    <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>
                                    <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>                                  
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
                                    <td style="text-align: center; width: 360px;height: 300px">
                                            @if ($detalle_lp_referencia->path1!='/img/imagen1.jpg')
                                                <img src="{{ public_path($detalle_lp_referencia->path1) }}" alt="" style="height: 174; width: 255;">
                                            @endif  
                                            
                                    </td>
                                    <td style="text-align: center; width: 360px;height: 300px">
                                        @if ($detalle_lp_referencia->path2!='/img/imagen2.jpg')
                                            <img src="{{  public_path($detalle_lp_referencia->path2) }}" alt="" style="height: 174; width: 255;">
                                        @endif  
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 360px;height: 300px">
                                        @if ($detalle_lp_referencia->path3!='/img/imagen3.jpg')
                                            <img src="{{  public_path($detalle_lp_referencia->path3) }}" alt="" style="height: 174; width: 255;">
                                    @endif  
                                    </td>
                                    <td style="text-align: center; width: 360px;height: 300px">
                                        @if ($detalle_lp_referencia->path4!='/img/imagen4.jpg')
                                            <img src="{{  public_path($detalle_lp_referencia->path4) }}" alt="" style="height: 174; width: 255;">
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
        $x = 492;
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

    $pdf->line(38.5,130,38.5,750,array(0,0,0),1.5);
    $pdf->line(593,130,593,750,array(0,0,0),1.5);

</script>
  </body>  
</html>