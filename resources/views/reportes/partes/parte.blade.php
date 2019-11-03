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
                               <td style="font-size: 13px; text-align: center" colspan="2" class="bordered-td" ><b>EVALUADOR </b></td>   
                               <td style="font-size: 13px; text-align: center" colspan="2" class="bordered-td" ><b>CONTRATISTA </b></td>                            
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;width:100px;"><span style="margin-left: 2px">FIRMA:</span></td>  
                                <td style="font-size: 12px; border-right: 1px solid #000;width:253px;" rowspan="2">
                                    @if($evaluador && $evaluador->path)
                                        <img src="{{ public_path($evaluador->path)}}" alt="" style="height: 70px;">
                                    @endif
                                </td>  
                                <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">FIRMA:</span></td>    
                                <td style="font-size: 12px; border-right: 1px solid #000;" rowspan="2"></td>                              
                            </tr>
                            <tr>                               
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
    <table width="100%" class="bordered">
        <tbody>  
            <tr>      
                <td class="bordered">
                     <table width="100%"  >
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
                <td >
                    <table width="100%" >
                        <tbody>
                            <td style="font-size: 12px;height: 20px; width: 233px;"><b>INFORMES DEL PARTE: </b>

                                @foreach ($metodos_informe as $item)

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

            {{$ExisteRI = false}} 
            @foreach ($parte_detalle as $item)

                @if ($item->metodo == 'RI')
                        {{ $ExisteRI = true }}}
                @endif
                
            @endforeach

            @if ($ExisteRI)       
                <tr > 
                    <td class="bordered">
                        <table width="100%" >
                            <tbody>
                                <tr>                         
                                    <td style="font-size: 12px;height: 20px;" colspan="5"><b>METODO ENSAYO: RI </b></td>                                         
                                </tr>  
                                @foreach ($parte_detalle as $item)
                                    @if ($item->metodo == 'RI')                               
                                        <tr>                         
                                            <td style="font-size: 12px;height: 20px;" colspan="5"><b>{{$item->numero_formateado}} </b></td>                                         
                                        </tr>   
                                        <tr>    
                                            <td style="font-size: 12px; "><b></b></td>  
                                            <td style="font-size: 12px;  text-align: center; "><b>Costuras </b></td>                        
                                            <td style="font-size: 12px;  text-align: center;"><b>Pulgadas </b></td>                         
                                            <td style="font-size: 12px;  text-align: center;"><b>Placas </b></td>    
                                            <td style="font-size: 12px;  text-align: center;"><b>Cm </b></td>    
                                        </tr> 
                                        <tr> 
                                            <td style="font-size: 12px; "><b></b></td>  
                                            <td style="font-size: 12px; text-align: center;">{{$item->costura}}</td>                        
                                            <td style="font-size: 12px; text-align: center;">{{$item->pulgadas}}</td>                         
                                            <td style="font-size: 12px; text-align: center;">{{$item->placas}}</td>    
                                            <td style="font-size: 12px; text-align: center;">{{$item->cm}}</td>                        
                                        </tr>
                                    @endif
                                @endforeach                     
                                    
                            </tbody>
                        </table>          
                    </td>
                </tr>  
            @endif

            {{$ExistePM = false}} 
            @foreach ($parte_detalle as $item)

                @if ($item->metodo == 'PM')
                        {{ $ExistePM = true }}}
                @endif
                
            @endforeach

            @if ($ExistePM)       
                <tr > 
                    <td class="bordered">
                        <table width="100%" >
                            <tbody>
                                <tr>                         
                                    <td style="font-size: 12px;height: 20px;" colspan="4"><b>METODO ENSAYO: PM </b></td>                                         
                                </tr>                           
                                @foreach ($informes_detalle as $item)
                                    @if ($item->metodo == 'PM')      
                                        <tr>                         
                                            <td style="font-size: 12px;height: 20px;" colspan="4"><b>{{$item->numero_formateado}} </b></td>                                         
                                        </tr>  
                                        <tr> 
                                            <td style="font-size: 12px;text-align: center;"><b></b></td>  
                                            <td style="font-size: 12px;text-align: center; "><b>Pieza </b></td>                        
                                            <td style="font-size: 12px;text-align: center; "><b>Número </b></td>                         
                                            <td style="font-size: 12px;text-align: center;"><b>Metros Lineales </b></td>                                            
                                        </tr> 
                                        @foreach ($parte_detalle as $item_pm)
                                            @if ($item->informe_id == $item_pm->informe_id)      
                                                <tr> 
                                                    <td style="font-size: 12px;text-align: center;"><b></b></td>  
                                                    <td style="font-size: 12px;text-align: center; ">{{$item_pm->pieza}}</td>                        
                                                    <td style="font-size: 12px;text-align: center; ">{{$item_pm->nro}}</td>                         
                                                    <td style="font-size: 12px;text-align: center;">{{$item_pm->metros_lineales}}</td>                                            
                                                </tr>
                                             @endif
                                         @endforeach      
                                    @endif
                                @endforeach                             
                            </tbody>
                        </table>          
                    </td>
                </tr>  
            @endif

            {{$ExisteLP = false}} 
            @foreach ($parte_detalle as $item)

                @if ($item->metodo == 'PM')
                        {{ $ExisteLP = true }}}
                @endif
                
            @endforeach

            @if ($ExisteLP)       
                <tr > 
                    <td class="bordered">
                        <table width="100%" >
                            <tbody>
                                <tr>                         
                                    <td style="font-size: 12px;height: 20px;" colspan="4"><b>METODO ENSAYO: LP </b></td>                                         
                                </tr>                           
                                @foreach ($informes_detalle as $item)
                                    @if ($item->metodo == 'LP')      
                                        <tr>                         
                                            <td style="font-size: 12px;height: 20px;" colspan="4"><b>{{$item->numero_formateado}} </b></td>                                         
                                        </tr>  
                                        <tr> 
                                            <td style="font-size: 12px;text-align: center;"><b></b></td>  
                                            <td style="font-size: 12px;text-align: center; "><b>Pieza </b></td>                        
                                            <td style="font-size: 12px;text-align: center; "><b>Número </b></td>                         
                                            <td style="font-size: 12px;text-align: center;"><b>Metros Lineales </b></td>                                            
                                        </tr> 
                                        @foreach ($parte_detalle as $item_lp)
                                            @if ($item->informe_id == $item_lp->informe_id)      
                                                <tr> 
                                                    <td style="font-size: 12px;text-align: center;"><b></b></td>  
                                                    <td style="font-size: 12px;text-align: center; ">{{$item_lp->pieza}}</td>                        
                                                    <td style="font-size: 12px;text-align: center; ">{{$item_lp->nro}}</td>                         
                                                    <td style="font-size: 12px;text-align: center;">{{$item_lp->metros_lineales}}</td>                                            
                                                </tr>
                                             @endif
                                         @endforeach      
                                    @endif
                                @endforeach                             
                            </tbody>
                        </table>          
                    </td>
                </tr>  
            @endif
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

   
     $pdf->line(31.5,130,31.5,800,array(0,0,0),1.5);
     $pdf->line(586.3,130,586.3,800,array(0,0,0),1.5);
        

</script>


</body>
</html>