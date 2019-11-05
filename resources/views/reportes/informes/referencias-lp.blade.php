<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Referencia</title>
</head>
<style>
 
@page { margin: 329px 1px 194px 49px !important;
        padding: 0px 0px 0px 0px !important; }


.contenido {
    position:fixed;
    top: -291px; 
   
    }

.bordered {
    border-color: #000000;
    border-style: solid;
    border-width: 2px; 
    border-collapse: collapse;   
}

td {
  padding: 2px;
}

</style>

 <body>
    <div class="contenido">
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
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="font-size: 15px;">
                                        <p><strong>Observaciones: </strong>{{$detalle_lp_referencia->descripcion}}</p> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
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
    </div>

    <script type="text/php">

    if ( isset($pdf) ) {
        $x = 473;
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