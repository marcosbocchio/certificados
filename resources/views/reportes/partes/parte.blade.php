<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PARTE DIARIO N°: {{$parte->id}} </title>
</head>

<style>

@page { margin:210px 30px 140px 60px !important;
        padding: 0px 0px 0px 0px !important; }

body {
    margin: 0px 1px 0px 1px;
    padding: 0 0 0 0;
}

header {
    position:fixed;
    top: -182px; 
   
    }

main{
   
    margin-top: -2px;
}

footer {
    position: fixed; bottom:4px; 
    padding-top: -1px;

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
 <body class="bordered" style="border-top: none;">  

<header>
    <table style="text-align: center;" width="100%" class="bordered">
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
                                <td style="font-size: 13px;" colspan="2"><b style="margin-left: 80px">FECHA: </b>{{ date('d-m-Y', strtotime($parte->fecha)) }}</td>
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
                                <td style="font-size: 12px;height: 20px;width: 350;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}</td>                         
                                <td style="font-size: 12px;"><b>OBRA: </b>{{$ot->obra}}</td>     
                                <td style="font-size: 12px;"><b>OT N°: </b>{{$ot->numero}}</td>     
                            </tr>    
                            <tr>
                                <td style="font-size: 12px;"" colspan="3"><b>PROYECTO: </b>{{$ot->proyecto}}</td>
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
                                <td style="font-size: 12px;height: 30px;" colspan="6" rowspan="2" class="bordered-td"><b>Observaciones: </b>{{$parte->observaciones}}</td>                                  
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
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>RESPONSABLE </b></td>   
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>CLIENTE </b></td> 
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>COMITENTE </b></td>                              
                            </tr>
                            
                            <tr>                               
                                <td style="font-size: 11px; text-align: left; height: 25px;width:75px;"><span style="margin-left: 2px">FIRMA:</span></td>   

                                <td style="text-align:left ;font-size: 11px; border-right: 1px solid #000;width: 150px;margin-left: 15px;" rowspan="2">
                                    @if($evaluador && $evaluador->path)
                                        <img src="{{ public_path($evaluador->path)}}" alt="" style="width: 100px;">
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
 
    <table width="100%" style="padding: 0 -4px 0 -4px;">
        <tbody>
             <tr>
                <td>
                    <table width="100%" style="border-collapse: collapse;">
                        <tbody> 
                            <tr>                         
                                <td style="font-size: 14px;height: 20px; text-align: center;" colspan="2"><b>RESPONSABLES</td>                                       
                            </tr>   
                            
                                @foreach ($responsables as $responsable)

                                    @if($loop->odd)
                                    
                                        <tr>                                      
                                        <td style="font-size: 12px;height: 20px; width: 450px;"><b style="margin-left: 6px;">{{$responsable->responsabilidad}}: </b>{{$responsable->nombre}}</td>      
                                    @else
                                        <td style="font-size: 12px;height: 20px;"><b>{{$responsable->responsabilidad}}: </b>{{$responsable->nombre}}</td>         
                                        </tr>  

                                    @endif                                                           

                                    @if ($loop->last && $loop->odd)
                                        <td style="font-size: 12px;height: 20px;">&nbsp;</td> 
                                        </tr>                                         
                                    @endif  
                                @endforeach   
                                        
                        </tbody>
                    </table>
                </td>
             </tr>
             <tr>
                 <td class="bordered">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td style="font-size: 12px;height: 20px; width: 233px;"><b>INFORMES DEL PARTE: </b>

                                    @foreach ($metodos_informe as $item)

                                        @if (!$loop->first)
                                        ,
                                        @endif 

                                        {{$item->numero_formateado}}
                                        
                                    @endforeach

                                </td> 
                            </tr>
                        </tbody>
                    </table>
                </td>
             </tr>
        </tbody>
    </table>
    
 
    <table width="100%" style="margin-top: -5px;">
        <tbody>        

            <tr> 
                <td style="font-size: 13px;height: 30px;" colspan="5"><b style="margin-left: 4px;">SERVICIOS: </b></td>                                             
            </tr>  
            <tr>
                 
                <td style="font-size: 12px;width: 100px; "><b>Metodo Ensayo: </b></td>                        
                <td style="font-size: 12px;width: 350px; " colspan="3"><b>Descripción </b></td>                         
                <td style="font-size: 12px;text-align: center;"><b>Cantidad </b></td>        
            </tr>    
            @foreach($servicios as $servicio)
                <tr>
                    
                    <td style="font-size: 12px;width: 100px;"><span style="margin-left:10px;">{{$servicio->metodo}}</span></td>                        
                    <td style="font-size: 12px;width: 350px; " colspan="3"><span style="margin-left:10px;">{{$servicio->servicio_descripcion}}</span> </td>                         
                    <td style="font-size: 12px;text-align: center;text-align: center;">

                        @if($estado == 'original')
                            {{$servicio->cant_original}}
                        @else
                            {{$servicio->cant_final}}
                        @endif
                    
                    </td>        
                </tr>                 
            @endforeach


            {{$ExisteRI = false}} 
            @foreach ($parte_detalle as $item)

                @if ($item->metodo == 'RI')
                        {{ $ExisteRI = true }}}
                @endif
                
            @endforeach

            @if ($ExisteRI)       
                <tr>                         
                    <td style="font-size: 13px;height: 30px;border-top: 1px dashed black;" colspan="5"><b style="margin-left: 6px;">METODO ENSAYO: RI </b></td>                                         
                </tr> 
                @if ($estado == 'original')
                    <tr>                         
                        <td style="font-size: 13px;height: 30px" colspan="5"><b style="margin-left: 6px;">Placas Repetidas Total: </b>{{ $parte->placas_repetidas }}</td>                                         
                    </tr>                       
                @endif
                @foreach ($parte_detalle as $item)
                    @if ($item->metodo == 'RI')                               
                         <tr>                         
                            <td style="font-size: 12px;height: 20px;" colspan="5"><b style="margin-left: 8px;">{{$item->numero_formateado}} </b></td>                                         
                        </tr> 
                        <tr>    
                            <td style="font-size: 12px;width: 100px; "><&nbsp;></b></td>  
                            <td style="font-size: 12px;width: 150px;  text-align: center; "><b>Costuras </b></td>                        
                            <td style="font-size: 12px;width: 150px;  text-align: center;"><b>Pulgadas </b></td>                         
                            <td style="font-size: 12px;width: 150px;  text-align: center;"><b>Placas </b></td>    
                            <td style="font-size: 12px; text-align: center;"><b>Cm </b></td>    
                        </tr> 
                        <tr> 
                            <td style="font-size: 12px; "><b>&nbsp;</b></td>  
                            <td style="font-size: 12px; text-align: center;">{{$item->costura}}</td>                        
                            <td style="font-size: 12px; text-align: center;">{{$item->pulgadas}}</td>                         
                            <td style="font-size: 12px; text-align: center;">{{$item->placas}}</td>    
                            <td style="font-size: 12px; text-align: center;">{{$item->cm}}</td>                        
                        </tr>
                    @endif
                @endforeach                     

            @endif

            {{$ExistePM = false}} 
            @foreach ($parte_detalle as $item)

                @if ($item->metodo == 'PM')
                        {{ $ExistePM = true }}}
                @endif
                
            @endforeach

            @if ($ExistePM)           
                <tr>                         
                    <td style="font-size: 13px;height: 30px;border-top: 1px dashed black;" colspan="5"><b style="margin-left: 8px;">METODO ENSAYO: PM </b></td>                                         
                </tr>                           
                @foreach ($informes_detalle as $item)
                    @if ($item->metodo == 'PM')      
                        <tr>                         
                            <td style="font-size: 12px;height: 20px;" colspan="5"><b style="margin-left: 8px;">{{$item->numero_formateado}} </b></td>                                         
                        </tr>  
                        <tr> 
                            <td style="font-size: 12px;text-align: center;width: 100px;"><b>&nbsp;</b></td>  
                            <td style="font-size: 12px;text-align: center;width: 150px; "><b>Elemento </b></td>                        
                            <td style="font-size: 12px;text-align: center;"><b>Cm</b></td>                                            
                        </tr> 
                        @foreach ($parte_detalle as $item_pm)
                            @if ($item->informe_id == $item_pm->informe_id)      
                                <tr> 
                                    <td style="font-size: 12px;text-align: center;"><b>&nbsp;</b></td>  
                                    <td style="font-size: 12px;text-align: center; ">{{$item_pm->pieza}}</td>                        
                                    <td style="font-size: 12px;text-align: center;">{{$item_pm->cm}}</td>                                            
                                </tr>
                                @endif
                            @endforeach      
                    @endif
                @endforeach                             
             
            @endif

            {{$ExisteLP = false}} 
            @foreach ($parte_detalle as $item)

                @if ($item->metodo == 'LP')
                        {{ $ExisteLP = true }}}
                @endif
                
            @endforeach

            @if ($ExisteLP)        
                <tr>                         
                    <td style="font-size: 13px;height: 30px;border-top: 1px dashed black;" colspan="5"><b style="margin-left: 8px;">METODO ENSAYO: LP </b></td>                                         
                </tr>                           
                @foreach ($informes_detalle as $item)
                    @if ($item->metodo == 'LP')      
                        <tr>                         
                            <td style="font-size: 12px;height: 20px;" colspan="5"><b style="margin-left: 8px;">{{$item->numero_formateado}} </b></td>                                         
                        </tr>  
                        <tr> 
                            <td style="font-size: 12px;text-align: center;width: 100px;"><b>&nbsp;</b></td>  
                            <td style="font-size: 12px;text-align: center;width: 150px; "><b>Elemento </b></td>                                            
                            <td style="font-size: 12px;text-align: center;"><b>Cm</b></td>                                            
                        </tr> 
                        @foreach ($parte_detalle as $item_lp)
                            @if ($item->informe_id == $item_lp->informe_id)      
                                <tr> 
                                    <td style="font-size: 12px;text-align: center;"><b>&nbsp;</b></td>  
                                    <td style="font-size: 12px;text-align: center; ">{{$item_lp->pieza}}</td>                        
                                    <td style="font-size: 12px;text-align: center;">{{$item_lp->cm}}</td>                                            
                                </tr>
                                @endif
                            @endforeach      
                    @endif
                @endforeach                             
  
            @endif

            {{$ExisteUS = false}} 
            @foreach ($parte_detalle as $item)

                @if ($item->metodo == 'US')
                        {{ $ExisteUS = true }}}
                @endif
                
            @endforeach

            @if ($ExisteUS)            
                <tr>                         
                    <td style="font-size: 13px;height: 30px;border-top: 1px dashed black;" colspan="5"><b style="margin-left: 8px;">METODO ENSAYO: US </b></td>                                         
                </tr>                           
                @foreach ($informes_detalle as $item)
                    @if ($item->metodo == 'US')      
                        <tr>                         
                            <td style="font-size: 12px;height: 20px;" colspan="5"><b style="margin-left: 8px;">{{$item->numero_formateado}} </b></td>                                         
                        </tr>  
                        <tr> 
                            <td style="font-size: 12px;text-align: center;width: 100px;"><b>&nbsp;</b></td>  
                            <td style="font-size: 12px;text-align: center;width: 150px; "><b>Elemento </b></td>                        
                            <td style="font-size: 12px;text-align: center;width: 150px;"><b>Diametro </b></td>   
                            <td style="font-size: 12px;text-align: center;"><b>Cm</b></td>                                           
                        </tr> 
                        @foreach ($parte_detalle as $item_us)
                            @if ($item->informe_id == $item_us->informe_id)      
                                <tr> 
                                    <td style="font-size: 12px;text-align: center;"><b>&nbsp;</b></td>  
                                    <td style="font-size: 12px;text-align: center; ">{{$item_us->pieza}}</td>                        
                                    <td style="font-size: 12px;text-align: center;">{{$item_us->pulgadas}}</td> 
                                    <td style="font-size: 12px;text-align: center;">{{$item_us->cm}}</td>                                               
                                </tr>
                                @endif
                            @endforeach      
                    @endif
                @endforeach  
         
            @endif
        </tbody>
    </table>
<main>
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 466;
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