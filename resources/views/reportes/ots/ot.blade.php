<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Proyecto : {{$ot->proyecto }} - OT N° : {{$ot->numero}}</title>

 <style>

@page { margin: 430px 30px 200px 60px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -388px;    
    }

main{
   
    margin-top: -2px;
}

footer {

  position: fixed; bottom:0px; 
  padding-top: 0px;

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

td {
  padding: 2px;
}

td b,td span {
  margin-left: 10px;
} 
</style>

</head>

<body>

<header>
    <table style="text-align: center;border-bottom: none;" class="bordered" width="100%">
        <tbody>
            <tr>
                 <td>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="text-align: right;width: 240px;">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 19px; height: 30px;width: 250px; text-align: center;margin-left: 0px" rowspan="3"><b>ORDEN DE TRABAJO</b></td>
                                <td style="font-size: 11px;"><b ></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 80px;">OT N°: </b>{{$ot->numero}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 80px;">FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b></b></td>                     
                                <td style="font-size: 11px;"><b></td>            
                            </tr>               
                        </tbody>
                    </table>          
                </td>
            </tr>
            <tr>
                <td class="bordered">
                    <table width="100%" >
                        <tbody>
                            <tr>                         
                                <td style="font-size: 11px;width: 200px;height: 45px;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}                            
                                    
                                </td>  

                                <td style="width: 175px;">
                                    @if($ot->logo_cliente_sn && $cliente->path)
                                    <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 40px;margin-top: 5px;">
                                   @else
                                     <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 40px;margin-top: 5px;">
                                   @endif    
                                </td>                                    
                            
                                <td style="font-size: 11px; width: 200px;">
                                  
                                        @if($contratista)
                                            <b>COMITENTE: </b>{{$contratista->nombre}}
                                        @endif                                               
                                 
                                </td> 
                                <td>
                                    
                                    @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                                       <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height:40px;margin-top: 5px;">
                                    @else
                                       <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 40px;margin-top: 5px;">
                                    @endif

                                </td>
                                                    
                            </tr>            
                            <tr>                                                  
                                <td style="font-size: 11px; width: 253px;" colspan="2"><b>PROYECTO: </b>{{$ot->proyecto}}</td>                            
                                <td style="font-size: 11px;"><b>OBRA: </b>{{$ot->obra}}</td>     
                                <td style="font-size: 11px;"><b>OT N°: </b>{{$ot->numero}}</td>     
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
                    <td style="font-size: 12px; width:270px;" ><b>Lugar de ensayo: </b>{{$ot->lugar}}

                     <a href="{{ $geo }}" target="_blank" >
                        <img src="{{ public_path('img/mark-google-maps.jpg')}}" alt="" style="height: 18px;">
                     </a>  
                    
                    </td>
                    <td style="text-align: left; width:105px">&nbsp;</td>
                    <td style="font-size: 12px;  width:240px" ><b>Horario: </b>{{ date('H:i', strtotime($ot->fecha_hora_estimada_ensayo)) }}</td>    
                  </tr>
                  <tr>
                    <td style="font-size: 12px;"" ><b>Localidad: </b>{{$localidad->localidad}}</td>
                    <td> &nbsp;</td>
                    <td style="font-size: 12px;" ><b>Provincia: </b>{{$provincia->provincia}}</td>
                  </tr>
                  <tr>                          
                      <td style="font-size: 12px;" colspan="2"><b>Contacto 1: </b>{{$contacto1->nombre}}</td>
                      <td style="font-size: 12px;" ><b>Cargo: </b>{{$contacto1->cargo}}</td>
                  </tr>
                  <tr>
                      <td style="font-size: 12px;padding-top:-5px" colspan="2" ><b>Tel: </b>{{$contacto1->tel}}</td>
                      <td style="font-size: 12px;padding-top:-5px"><b>Email: </b>{{$contacto1->email}} </td>
                  </tr>
                  <tr>
                      <td style="font-size: 12px;" colspan="2" ><b>Contacto 2: </b>{{$contacto2->nombre ?? ''}}</td>
                      <td style="font-size: 12px;"><b>Cargo: </b>{{$contacto2->cargo ?? ''}}</td>
                  </tr>
                  <tr>
                      <td style="font-size: 12px;padding-top:-5px" colspan="2" ><b>Tel: </b>{{$contacto2->tel ?? ''}}</td>
                      <td style="font-size: 12px;padding-top:-5px"><b>Email: </b>{{$contacto2->email ?? ''}} </td>
                  </tr>
                  <tr>
                      <td style="font-size: 12px;" colspan="2" ><b>Contacto 3: </b> {{ $contacto3->nombre ?? ''}}</td>        
                      <td style="font-size: 12px;"><b>Cargo: </b>{{$contacto3->cargo ?? ''}}</td>              
                  </tr>
                  <tr>
                      <td style="font-size: 12px;padding-top:-5px" colspan="2" ><b>Tel: </b>{{$contacto3->tel ?? ''}}</td>
                      <td style="font-size: 12px;padding-top:-5px"><b>Email: </b>{{$contacto3->email ?? ''}} </td>
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
                        <td style="font-size: 12px; width:220px" ><b>Métodos de ensayos: </b>
                          @foreach ( $metodos_ensayos as $metodo )

                              @if (!$loop->first)
                                ,
                              @endif 

                              {{ $metodo->metodo }} 

                           @endforeach
                        
                        </td>
                        <td style="font-size: 12px; width:210px" ><b>Calidad de Placa: </b>
                            @foreach ($ot_calidad_placas as $ot_calidad_placa)
                              
                                @if (!$loop->first)
                                  ,
                                @endif 

                                {{ $ot_calidad_placa->codigo  }}

                            @endforeach
                        
                        </td>
                        <td style="font-size: 12px; width:240px" ><b>Fecha Estimada ensayo: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora_estimada_ensayo)) }} </td>
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
                      <td style="font-size: 12px; width:500px; height: 20px;" ><b>Datos de elementos a ensayar </b></td>
                      <td style="font-size: 12px; width:100px;text-align: center;" ><b>Cantidad </b></td>
                      <td style="font-size: 12px; width:70px;text-align: center;" ><b>Unidad </b></td>
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
                <table width="100%" class="bordered" style="border-collapse: collapse;" >
                    <tbody>                           
                        <tr>                                
                            <td style="font-size: 11px;"><strong>Observaciones:</strong> {{$ot->observaciones}}</p>                                
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
                    <td style="font-size: 12px;"><b>Elementos de Seguridad: </b>
                      @foreach ( $ot_epps as $ot_epp )
                          @if (!$loop->first)
                            ,
                          @endif
                        {{$ot_epp->descripcion}}
                      @endforeach
                    </td>                                                   
                  </tr>
                  <tr>
                      <td style="font-size: 12px;border-bottom: 1px solid black;" ><b>Riesgos: </b>
                        @foreach ( $ot_riesgos as $ot_riesgo )
                            @if (!$loop->first)
                                ,
                            @endif
                          {{$ot_riesgo->descripcion}}
                        @endforeach
                      </td>       
                  </tr>
                </tbody>
              </table>   
            </td>
          </tr>
          <tr>
              <td>
                 <table width="100%" style="border-collapse: collapse;">
                  <tbody>
                    <tr >
                        <td style="font-size: 12px; width: 400px; padding: 20px 0px 10px 0px"><b>Responsable OT: </b>{{$responsable_ot->name }}</td>      
                        <td style="font-size: 12px; width: 40px; padding: 20px 0px 10px 0px"><b>Firma: </b></td>        
                        <td style="font-size: 11px;" rowspan="2">
                          @if($evaluador && $evaluador->path)
                                <img src="{{ public_path($evaluador->path)}}" alt="" style="height: 70px;margin-left:40px ">
                          @endif
                        </td> 
                    </tr>
                      <tr >
                        <td style="font-size: 12px; width: 400px; padding: 10px 0px 20px 0px"><b>Generador OT: </b>{{$generador_ot->name }}</td>            
                    </tr>      
                  </tbody>
                </table>  
              </td>
          </tr>
        </tbody>
    </table>
</footer>

<main>    
    <table width="100%" style="border-right: 2px solid black;border-left: 2px solid black;border-collapse: collapse;">
        <tbody>

            @foreach ( $ot_servicios as $ot_servicio )
                  <tr> 
                    
                    <td style="font-size: 12px;"  >
                        
                        @if ($ot_servicio->ot_referencia_id)
                        <li style="margin-left: 20px;"> <a href="{{ route('ServiciosReferencias',$ot_servicio->ot_referencia_id)}}">{{ $ot_servicio->servicio }}</a></li>                               
                        @else
                        <li style="margin-left: 20px;"> {{ $ot_servicio->servicio }} </li> 
                        @endif
                        @if ($ot_servicio->procedimiento_sn)
                        <span style="margin-left: 30px; font-size:11px; ">Requiere Procedimiento</span><br>
                        @endif
                        <span style="margin-left: 30px; font-size:11px; ">Norma de ensayo:</span><span style="font-size: 9px;color:#808080;">{{$ot_servicio->norma_ensayo}}</span> <br>
                        <span style="margin-left: 30px; font-size:11px;">Norma de evaluación:</span><span style="font-size: 9px;color:#808080;">{{$ot_servicio->norma_evaluacion}}</span>
                      </td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_servicio->cantidad_servicios}}</td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_servicio->unidad_medida}}</td>
                      
                  </tr>
                      
                  @endforeach
                      
                      
                      
                  @foreach ( $ot_productos as $ot_producto )
                  <tr> 
                    <td style="font-size: 12px; width:470px;" >
                        @if ($ot_producto->ot_referencia_id)
                        <li style="margin-left: 20px;"><a href="{{ route('ProductosReferencias',$ot_producto->ot_referencia_id)}}">{{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }}</a></li> <br>
                        @else
                        <li style="margin-left: 20px;">  {{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }} </li> </span>  
                        @endif 
                      </td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_producto->cantidad_productos}}</td>
                      <td style="font-size: 12px; width:80px;text-align: center;" >{{$ot_producto->unidad_medida_codigo}}</td>
                  </tr>               

                  @endforeach  
                  
               

                  @for ( $x=0 ;  $x < 2 ; $x++)
                      <tr>
                          <td style="font-size: 12px;" colspan="3">&nbsp;</td>                           
                      </tr>
                  @endfor
        </tbody>
    </table>
</main>

<script type="text/php">

    if ( isset($pdf) ) {      

        $x = 488;
        $y = 85;
        $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 9;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
      
        $pdf->page_line(46.5,130,46.5,800,array(0,0,0),1.5);
        $pdf->page_line(571.3,130,571.3,800,array(0,0,0),1.5); 

    }      

</script>

</body>
</html>
