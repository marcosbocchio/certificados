<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Parte</title>
</head>

<style>

@page { margin:190px 10px 120px 40px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -162px; 
   
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
                                <td style="font-size: 18px; height: 30px; text-align: center;width:234px" rowspan="3"><b>PARTE DIARIO DE TRABAJO</b></td>
                                <td style="font-size: 13px;" colspan="2" ><b style="margin-left: 80px">PARTE N°: </b>{{$parte->id}}</td>                                        
                            </tr>
                            <tr>
                                <td style="font-size: 13px;" colspan="2"><b style="margin-left: 80px">FECHA: </b>{{ date('d-m-Y', strtotime($parte->fecha_hora)) }}</td>
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
            <tr > 
                <td class="bordered">
                    <table width="100%" >
                        <tbody>
                            <tr>                         
                                <td style="font-size: 12px;height: 20px; width: 233px;"><b>TIPO SERVICIO: </b>{{$parte->tipo_servicio}}</td>                        
                                <td style="font-size: 12px; width: 253px;"><b>HORARIO: </b>{{$parte->horario}}</td>    
                                <td style="font-size: 12px;"><b>MOVILIDAD PROPIA : </b>
                                    @if ($parte->movilidad_propia_sn)
                                         SI   
                                    @else
                                        NO
                                    @endif
                                </td>             
                            </tr>    
                            <tr>                         
                                <td style="font-size: 12px;height: 20px; width: 233px;"><b>PATENTE: </b>{{$parte->patente}}</td>                        
                                <td style="font-size: 12px; width: 253px;"><b>KM INICIAL: </b>{{$parte->km_inicial}}</td>                         
                                <td style="font-size: 12px;"><b>KM FINAL: </b>{{$parte->km_final}}</td>                 
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
                                <td style="font-size: 12px;"  class="bordered-td"><b>OBSERVACIONES: </b>{{$parte->observaciones}}</td>                                  
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
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td>   
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td>                                 
                            </tr>
                            <tr>                               
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

<main>
    <table width="100%" class="bordered">
        <tbody>  
            <tr>      
                <td class="bordered">
                     <table width="100%" >
                        <tbody> 
                            <tr>                         
                                <td style="font-size: 14px;height: 20px; text-align: center;" colspan="2"><b>RESPONSABLES</td>                                       
                            </tr>   
                                @foreach ($responsables as $responsable)

                                    @if($loop->odd)
                                    
                                        <tr>                                      
                                         <td style="font-size: 12px;height: 20px; width: 450px;" ><b>{{$responsable->responsabilidad}}: </b>{{$responsable->nombre}}</td>      
                                    @else
                                         <td style="font-size: 12px;height: 20px;" ><b>{{$responsable->responsabilidad}}: </b>{{$responsable->nombre}}</td>         
                                        </tr>  

                                    @endif
                                                            

                                    @if ($loop->last && $loop->odd)
                                        <td style="font-size: 12px;height: 20px;"></td> 
                                        </tr>                                         
                                    @endif  
                                @endforeach               
                        </tbody>
                    </table>          
                </td> 
            </tr> 
           
            <tr>
               <td class="bordered">
                    <table width="100%" >
                        <tbody>
                            <td style="font-size: 12px;height: 20px; width: 233px;"><b>INFORMES DEL PARTE: </b>

                                @foreach ($parte_detalle as $item)

                                    @if (!$loop->first)
                                    ,
                                    @endif 

                                    {{$item->numero_formateado}}
                                    
                                @endforeach

                            </td> 
                         </tbody>
                    </table>
                </td>
            </tr> 
            <tr > 
                <td class="bordered">
                    <table width="100%" >
                        <tbody>
                            <tr>                         
                                <td style="font-size: 12px;height: 20px;" colspan="5"><b>METODO ENSAYO: RI </b></td>                                         
                            </tr>    
                           
                            @foreach ($parte_detalle as $item)
                              <tr>                         
                                <td style="font-size: 12px;height: 20px;" colspan="5"><b>{{$item->numero_formateado}} </b></td>                                         
                             </tr>   
                            <tr> 
                                <td style="font-size: 12px; "><b></b></td>  
                                <td style="font-size: 12px; "><b>Costuras: </b>{{$item->costura}}</td>                        
                                <td style="font-size: 12px; "><b>Pulgadas: </b>{{$item->pulgadas}}</td>                         
                                <td style="font-size: 12px;"><b>Placas: </b>{{$item->placas}}</td>    
                                <td style="font-size: 12px; "><b>Cm: </b>{{$item->cm}}</td>                        
                            </tr>
                            @endforeach                     
                                   
                        </tbody>
                    </table>          
                </td>
            </tr>  
        </tbody>
    </table>
<main>
     
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