<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>certificado {{FormatearNumeroConCeros($certificado->numero,8)}}</title>
</head>

<style>  

@page {    
        margin: 198px 15px 150px 15px !important;
        padding: 0px 0px 0px 0px !important;
       }

body {
    margin: 0px 1px 0px 1px;
    padding: 0 0 0 0;
}

header {
    position:fixed;
    top: -159px;    
}

footer {
    position: fixed; bottom:5.5px; 
    padding-top: 0px;

}

main {
      margin-top: -2px;
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
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
            <tr>
                 <td>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="text-align: right; width:253px">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                               
                                <td style="font-size: 22px; height: 30px; text-align: center;width:534px;" rowspan="2"><b>CERTIFICADO</b></td>
                                <td style="font-size: 11px;">&nbsp;</td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 120px" >CERTIFICADO N°: </b>{{FormatearNumeroConCeros($certificado->numero,8)}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 15px;text-align: center;"><b style="margin-left: 120px"></b>{{ $certificado->titulo }}</td>
                                <td style="font-size: 11px;"><b style="margin-left: 120px">FECHA: </b>{{ date('d-m-Y', strtotime($certificado->fecha)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 120px"></b></td>                     
                                <td style="font-size: 11px;"><b style="margin-left: 120px"></td>            
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
                                    <td style="font-size: 11px;width: 220px"><b>PROYECTO: </b>{{$ot->proyecto}}</td>
                                    <td style="font-size: 11px;height: 45px;width: 220px"><span style="margin-top: -20px;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}</span>
                                    
                                    </td> 
                                    <td>
                                        <span>
                                            @if($ot->logo_cliente_sn && $cliente->path)
                                                <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 40px;margin-top: 5px;">
                                            @else
                                                <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 40px;margin-top: 5px;">
                                            @endif
                                        </span>
                                    </td>                                     
                                
                                    <td style="font-size: 11px;width: 220px">
                                        @if($contratista)
                                            <b>CONTRATISTA: </b>{{$contratista->nombre}}
                                        @endif                         
                                        
                                    </td>  
                                    <td>
                                        @if($ot->logo_contratista_sn && $contratista->path_logo)
                                            <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height: 40px;margin-top: 5px;">
                                        @else
                                            <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 40px;margin-top: 5px;">
                                        @endif
                                    </td>              

                                    @if($ot->obra)

                                         <td style="font-size: 11px;width: 90px;"><b>OBRA: </b>{{$ot->obra}}</td>

                                    @endif
                                    <td style="font-size: 11px;"><b>OT N°: </b>{{$ot->numero}}</td>  
                                    <td style="font-size: 11px;"><b>FTS N°: </b>{{$ot->presupuesto}}</td>   
                                </tr>  
                           </tbody>
                    </table>          
                </td>
            </tr>     
            <tr>

                <td style="background:#D8D8D8;text-align: left;font-size: 13px;" class="bordered">
                        {{$certificado->info_pedido_cliente}} &nbsp;
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

                                @for ( $x=0 ; $x< 5 ;$x++)
                                    @if(isset($servicios_parte[$x]))
                                          <td style="font-size: 11px; width:213px " class="bordered-td"><b>{{ $servicios_parte[$x]->abreviatura }} </b>{{ $servicios_parte[$x]->descripcion_servicio }}</td>
                                    @else
                                          <td style="font-size: 11px; " class="bordered-td">&nbsp;</td>    
                                    @endif
                                @endfor

                            </tr>
                            <tr>
                                @for ( $x=5 ; $x< 10 ;$x++)
                                    @if(isset($servicios_parte[$x]))
                                        <td style="font-size: 11px; " class="bordered-td"><b>{{ $servicios_parte[$x]->abreviatura }} </b>{{ $servicios_parte[$x]->descripcion_servicio }}</td>
                                    @else
                                        <td style="font-size: 11px; " class="bordered-td">&nbsp;</td>    
                                    @endif
                                @endfor   
                                                        
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
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>CONTRATISTA </b></td> 
                            </tr>
                            <tr>                               
                                <td style="font-size: 11px; text-align: left; height: 25px;width:100px;"><span style="margin-left: 2px">FIRMA:</span></td>  
                                <td style="font-size: 11px; border-right: 1px solid #000;" rowspan="2">
                                @if($evaluador && $evaluador->path)
                                     <img src="{{ public_path($evaluador->path)}}" alt="" style="height: 70px;margin-left:40px ">
                                @endif
                                </td> 
                                <td style="font-size: 11px; text-align: left; height: 25px;width:100px;"><span style="margin-left: 2px">FIRMA:</span></td> 
                                <td style="font-size: 11px; border-right: 1px solid #000;" rowspan="2"></td>                    
                            </tr>
                            <tr>                               
                                <td style="font-size: 11px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>   
                                <td style="font-size: 11px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>                                             
                            </tr>
                        </tbody>
                    </table> 
                </td>
            </tr>      
        </tbody>
    </table>
</footer>


<main>
    
    <table width="100%" class="bordered" style="text-align: center;padding: 0 -3px 0 -3px;" >
        <thead>
            <tr>
              {{ $unidad_medida = ($modalidadCobro == 'COSTURAS') ? '"' : 'CM'}}
               <th style="font-size: 12px; width:60px" class="bordered"  rowspan="2">Día</th>
               <th style="font-size: 12px;width:60px" class="bordered" rowspan="2">Parte</th>
               @if(!$ot->obra)
                    <th style="font-size: 12px;width:40px" class="bordered" rowspan="2">Obra</th>
               @endif
               <th style="font-size: 12px;" class="bordered" colspan="9" >SERVICIOS</th>
               <th style="font-size: 12px;" class="bordered" colspan="17">
                     {{ $modalidadCobro }} EN {{ $unidad_medida}}              
               </th>
            </tr>
            <tr>    
            {{ $cant_servicios_parte = count($servicios_abreviaturas) }}    
            {{ $cant_productos_parte = count($productos_unidades_medidas) }} 

            @foreach ($servicios_abreviaturas as $item)
                <th style="font-size: 10px;width: 33px;" class="bordered">{{ $item }}</th>
            @endforeach

            @for ($x =$cant_servicios_parte ; $x <9 ; $x++)
               <th style="font-size: 11px;" class="bordered">&nbsp;</th>
            @endfor
            
            @foreach ($productos_unidades_medidas as $item)
                <th style="font-size: 12px;" class="bordered">{{ $item }}</th>
            @endforeach

            @for ($x =$cant_productos_parte ; $x <17 ; $x++)
               <th style="font-size: 12px;" class="bordered">&nbsp;</th>
            @endfor
             
            </tr>
        </thead>
        <tbody>       
            @foreach ($partes_certificado as $item_partes_certificado )

                <tr>
                    <td style="font-size: 12px;" class="bordered">{{$item_partes_certificado->fecha_formateada}}</td>                        
                    <td style="font-size: 12px;" class="bordered">{{$item_partes_certificado->parte_numero}}</td>
                    @if (!$ot->obra)

                        <td style="font-size: 12px;" class="bordered">{{$item_partes_certificado->obra}}</td>
                        
                    @endif

               <!-- INSERTO LOS SERVICIOS EN LA TABLA -->           
              
                @foreach ($servicios_abreviaturas as $item_servicios_abreviaturas)
                    {{ $existeServicioEnParte = false }}

                    @foreach ($servicios_parte as $item_servicios_parte)
                        
                        @if (($item_servicios_abreviaturas == $item_servicios_parte->abreviatura)&&($item_servicios_parte->parte_numero == $item_partes_certificado->parte_numero))
                                 <td style="font-size: 12px;" class="bordered">{{$item_servicios_parte->cantidad}}</td>
                               
                                 {{ $existeServicioEnParte = true }}
                        @endif

                    @endforeach

                    @if (!$existeServicioEnParte)
                        
                        <td style="font-size: 12px;" class="bordered">&nbsp;</td>

                    @endif    


                @endforeach                   

                @for ( $x=$cant_servicios_parte  ;  $x < 9 ; $x++)
                    <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                @endfor
            <!-- INSERTO LOS PRODUCTOS EN LA TABLA --> 
          
                @foreach ($productos_unidades_medidas as $item_productos_unidades_medidas)
                    {{ $existeProductoEnParte = false }}

                    @foreach ($productos_parte as $item_productos_parte)

                        @if (($item_productos_unidades_medidas == $item_productos_parte->unidad_medida_producto)&&($item_productos_parte->parte_numero == $item_partes_certificado->parte_numero))
                                 <td style="font-size: 12px;" class="bordered">{{ $item_productos_parte->cantidad }}</td>
                                 {{ $existeProductoEnParte = true }}
                        @endif


                    @endforeach

                    @if (!$existeProductoEnParte)
                        
                        <td style="font-size: 12px;" class="bordered">&nbsp;</td>

                    @endif    

                @endforeach   


                @for ( $x=$cant_productos_parte ;  $x < 17 ; $x++)
                    <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                @endfor     
              </tr>     

              <!-- TERMINÓ DE PONER LOS PRODUCTOS -->

            @endforeach

              <!-- AGREGO LOS TOTALES -->
              
                <tr>
                    @if (!$ot->obra)
                        <td style="font-size: 12px;" colspan='3' class="bordered">Total </td>       
                    @else
                         <td style="font-size: 12px;" colspan='2' class="bordered">Total </td>    
                    @endif

                    <!--SERVICIOS -->
                
                    @foreach ($servicios_abreviaturas as $item_servicios_abreviaturas)
                        
                        {{ $total_servicio = 0 }}

                        @foreach ($servicios_parte as $item_servicios_parte)
                            @if ($item_servicios_abreviaturas == $item_servicios_parte->abreviatura)
                                {{ $total_servicio = $total_servicio + $item_servicios_parte->cantidad}}
                            @endif
                        @endforeach
                        <td style="font-size: 12px;" class="bordered">{{ $total_servicio }}</td>
                    @endforeach

                    @for ( $x=$cant_servicios_parte  ;  $x < 9 ; $x++)
                        <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                    @endfor

              
                    <!--PRODUCTOS -->
                
                    @foreach ($productos_unidades_medidas as $item_productos_unidades_medidas)
                        
                        {{ $total_producto = 0 }}

                        @foreach ($productos_parte as $item_productos_parte)
                            @if ($item_productos_unidades_medidas == $item_productos_parte->unidad_medida_producto)
                                {{ $total_producto = $total_producto + $item_productos_parte->cantidad}}
                            @endif
                        @endforeach
                        <td style="font-size: 12px;" class="bordered">{{ $total_producto }}</td>
                    @endforeach

                    @for ( $x=$cant_productos_parte  ;  $x < 17 ; $x++)
                        <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                    @endfor

                </tr>

        </tbody>
    </table>
    
    <!-- AGREGO LOS CUADROS POR OBRA -->
    @php

        $cant_obras = count($obras);
        $filasObras = intdiv($cant_obras,3);
        $resto = $cant_obras % 3;
        if($resto > 0){
            $filasObras++;
        }
      
    @endphp
    <table>
        <tbody>
            @for ($x =0 ; $x < $filasObras ; $x++)
                
                <tr>
                    <td width="400px">

                        @if (isset($tablas_por_obras[$x*3]))
                            
                            <table class="bordered">
                                <thead>
                                    <tr>                                   
                                        <th style="font-size: 12px; width:255px;text-align: center;" class="bordered"  colspan="2">Obra : {{ $tablas_por_obras[$x*3]->obra }}</th>                          
                                    </tr>
                                    <tr>                            
                                        <th style="font-size: 12px; width:125px;text-align: center;"class="bordered">Servicios</th>
                                        <th style="font-size: 12px; width:125px;text-align: center;" class="bordered">{{ $modalidadCobro }}</th>                            
                                    </tr>                         
                                </thead>
                                <tbody>
                                    {{ $cant_total_servicio = count($tablas_por_obras[$x*3]->servicios) }}
                                    {{ $cant_total_producto = count($tablas_por_obras[$x*3]->productos) }}

                                    {{ $filas_total = $cant_total_servicio > $cant_total_producto ? $cant_total_servicio : $cant_total_producto }}

                                    @for ( $z=0 ;  $z< $filas_total  ; $z++)
                                        
                                        <tr>
                                            @if (isset($tablas_por_obras[$x*3]->servicios[$z]))
                                                <td style="font-size: 12px;" class="bordered"> {{$tablas_por_obras[$x*3]->servicios[$z]->servicio }} : {{$tablas_por_obras[$x*3]->servicios[$z]->cant_total_servicio }} </td>   
                                            @else    
                                            <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                                            @endif

                                        @if (isset($tablas_por_obras[$x*3]->productos[$z]))
                                        <td style="font-size: 12px;" class="bordered">&nbsp;{{$tablas_por_obras[$x*3]->productos[$z]->producto }} : {{$tablas_por_obras[$x*3]->productos[$z]->cant_total_producto }} {{ $unidad_medida}}</td>                                  
                                            @else    
                                            <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                                            @endif
                                    
                                        </tr>
                                    @endfor                 
                                </tbody>
                            </table>

                        @endif
                    </td>
                    <td width="400px">

                    @if (isset($tablas_por_obras[($x*3)+1]))

                            <table class="bordered">
                                <thead>
                                    <tr>                                   
                                        <th style="font-size: 12px; width:255px;text-align: center;" class="bordered"  colspan="2">Obra : {{ $tablas_por_obras[($x*3)+1]->obra }}</th>                     
                                    </tr>
                                    <tr>                            
                                        <th style="font-size: 12px; width:125px;text-align: center;" class="bordered">Servicios</th>
                                        <th style="font-size: 12px; width:125px;text-align: center;" class="bordered">{{ $modalidadCobro }}</th>                           
                                    </tr>                         
                                </thead>
                                <tbody>
                                    {{ $cant_total_servicio = count($tablas_por_obras[($x*3)+1]->servicios) }}
                                    {{ $cant_total_producto = count($tablas_por_obras[($x*3)+1]->productos) }}

                                    {{ $filas_total = $cant_total_servicio > $cant_total_producto ? $cant_total_servicio : $cant_total_producto }}

                                    @for ( $z=0 ;  $z< $filas_total  ; $z++)
                                        
                                        <tr>
                                            @if (isset($tablas_por_obras[($x*3)+1]->servicios[$z]))
                                                <td style="font-size: 12px;" class="bordered"> {{$tablas_por_obras[($x*3)+1]->servicios[$z]->servicio }} : {{$tablas_por_obras[($x*3)+1]->servicios[$z]->cant_total_servicio }} </td>   
                                            @else    
                                            <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                                            @endif

                                        @if (isset($tablas_por_obras[($x*3)+1]->productos[$z]))
                                        <td style="font-size: 12px;" class="bordered">&nbsp;{{$tablas_por_obras[($x*3)+1]->productos[$z]->producto }} : {{$tablas_por_obras[($x*3)+1]->productos[$z]->cant_total_producto }} {{ $unidad_medida}}</td>                                  
                                            @else    
                                            <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                                            @endif
                                    
                                        </tr>
                                    @endfor      
                                </tbody>
                            </table>

                        @endif
                    </td>
                    <td width="400px">

                    @if (isset($tablas_por_obras[($x*3)+2]))

                            <table class="bordered">
                                <thead>
                                    <tr>                                   
                                        <th style="font-size: 12px; width:255px;text-align: center;" class="bordered"  colspan="2">Obra : {{ $tablas_por_obras[($x*3)+2]->obra }}</th>                     
                                    </tr>
                                    <tr>                            
                                        <th style="font-size: 12px; width:125px;text-align: center;" class="bordered">Servicios</th>
                                        <th style="font-size: 12px; width:125px;text-align: center;" class="bordered">{{ $modalidadCobro }}</th>                       
                                    </tr>                       
                                </thead>
                                <tbody>
                                    {{ $cant_total_servicio = count($tablas_por_obras[($x*3)+2]->servicios) }}
                                    {{ $cant_total_producto = count($tablas_por_obras[($x*3)+2]->productos) }}

                                    {{ $filas_total = $cant_total_servicio > $cant_total_producto ? $cant_total_servicio : $cant_total_producto }}

                                    @for ( $z=0 ;  $z< $filas_total  ; $z++)
                                        
                                        <tr>
                                            @if (isset($tablas_por_obras[($x*3)+2]->servicios[$z]))
                                                <td style="font-size: 12px;" class="bordered"> {{$tablas_por_obras[($x*3)+2]->servicios[$z]->servicio }} : {{$tablas_por_obras[($x*3)+2]->servicios[$z]->cant_total_servicio }} </td>   
                                            @else    
                                            <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                                            @endif

                                        @if (isset($tablas_por_obras[($x*3)+2]->productos[$z]))
                                        <td style="font-size: 12px;" class="bordered">&nbsp;{{$tablas_por_obras[($x*3)+2]->productos[$z]->producto }} : {{$tablas_por_obras[($x*3)+2]->productos[$z]->cant_total_producto }} {{ $unidad_medida}}</td>                                  
                                            @else    
                                            <td style="font-size: 12px;" class="bordered">&nbsp;</td>
                                            @endif
                                    
                                        </tr>
                                    @endfor      
                                </tbody>
                            </table>

                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</main>  

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 702;
        $y = 77;
        $text = "PÁGINA: {PAGE_NUM} de {PAGE_COUNT}";
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

