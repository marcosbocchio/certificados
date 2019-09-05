<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>

 <style>
.bordered {
    border-color: #000000;
    border-style: solid;
    border-width: 2px; 
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

    <table style="text-align: center;" class="bordered" width="100%">
      <tbody>
        <tr> 
          <td class="bordered">
           <table width="100%">
             <tbody>
               <tr>
                 <td style="font-size: 14px; height: 30px;" colspan="3"><b style="margin-left: 50px;">PROYECTO: </b>{{ $ot->proyecto}} </td>
               </tr>
               <tr>
                 <td style="font-size: 13px;" colspan="2"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}</td>
                
                  <td rowspan="3" style="text-align: right;">
                      <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                  </td>               
                             
               </tr>
               <tr>
                  <td style="font-size: 13px;"><b>OBRA: </b>{{$ot->obra}}</td>
                  <td style="font-size: 13px;"><b>FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>    
                </tr>                  
                <tr>
                  <td style="font-size: 13px;"><b>OT N°: </b>{{$ot->numero}}</td>
                  <td style="font-size: 13px;"><b>FTS N°: </b>{{$ot->presupuesto}}</td>

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
                    <td style="font-size: 13px; width:300px" ><b>Lugar de ensayo: </b>{{$ot->lugar}}</td>
                    <td style="text-align: left; width:150px">
                      <a href="{{ $geo }}" target="_blank" >
                        <img src="{{ public_path('img/mark-google-maps.jpg')}}" alt="" style="height: 20px;">
                      </a>  
                    </td>
                    <td style="font-size: 13px;  width:250px" ><b>Horario: </b>{{ date('H:i', strtotime($ot->fecha_hora)) }}</td>    
                  </tr>
                  <tr>
                    <td style="font-size: 13px; width:300px"" ><b>Localidad: </b>{{$localidad->localidad}}</td>
                    <td style="width:150px" > &nbsp;</td>
                    <td style="font-size: 13px;  width:250px" ><b>Provincia: </b>{{$provincia->provincia}}</td>
                  </tr>
                  <tr>                
                     
                      <td style="font-size: 13px; width:300px" ><b>Contacto 1: </b>{{$contacto1->nombre}} - {{$contacto1->cargo}}</td>
                      <td style="font-size: 13px; width:150px" ><b>Tel: </b>{{$contacto1->tel}}</td>
                      <td style="font-size: 13px; width:250px" ><b>Email: </b>{{$contacto1->email}} </td>
                  </tr>
                  <tr>
                      <td style="font-size: 13px; width:300px" ><b>Contacto 2: </b>{{$contacto2->nombre ?? ''}} - {{$contacto2->cargo ?? ''}}</td>
                      <td style="font-size: 13px; width:150px" ><b>Tel: </b>{{$contacto2->tel ?? ''}}</td>
                      <td style="font-size: 13px; width:250px" ><b>Email: </b>{{$contacto2->email ?? ''}} </td>
                  </tr>
                  <tr>
                      <td style="font-size: 13px; width:300px" ><b>Contacto 3: </b> {{ $contacto3->nombre ?? ''}} - {{$contacto3->cargo ?? ''}}</td>                      
                      <td style="font-size: 13px; width:150px" ><b>Tel: </b>{{$contacto3->tel ?? ''}}</td>
                      <td style="font-size: 13px; width:250px" ><b>Email: </b>{{$contacto3->email ?? ''}} </td>
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
                        <td style="font-size: 13px; width:250px" ><b>Métodos de ensayos: </b>
                          @foreach ( $metodos_ensayos as $metodo )

                              @if (!$loop->first)
                                ,
                              @endif 

                              {{ $metodo->metodo }} 

                           @endforeach
                        
                        </td>
                        <td style="font-size: 13px; width:200px" ><b>Calidad de Placa: </b>
                            @foreach ($ot_calidad_placas as $ot_calidad_placa)
                              
                                @if (!$loop->first)
                                  ,
                                @endif 

                                {{ $ot_calidad_placa->codigo  }}

                            @endforeach
                        
                        </td>
                        <td style="font-size: 13px; width:250px" ><b>Fecha Estimada ensayo: </b>{{ date('d-m-Y', strtotime($ot->fecha_estimada_ensayo)) }} </td>
                    </tr>
                </tbody>
              </table>   
            </td>
        </tr>
        <tr>
            <td style="height: 540px;vertical-align: top;">
              <table>
                  <tbody>
                      <tr>
                          <td style="font-size: 13px; width:500px" ><b>Datos de elementos a ensayar </b></td>
                          <td style="font-size: 13px; width:80px;text-align: center;" ><b>Cantidad </b></td>
                          <td style="font-size: 13px; width:80px;text-align: center;" ><b>Unidad </b></td>
                      </tr>
                                          
                         
                     
                      @foreach ( $ot_servicios as $ot_servicio )
                      <tr> 
                        
                        <td style="font-size: 13px; width:500px;" >
                          
                            @if ($ot_servicio->ot_referencia_id)
                              <li style="margin-left: 20px;"> <a href="{{ route('ServiciosReferencias',$ot_servicio->ot_referencia_id)}}">{{ $ot_servicio->servicio }}</a></li>                               
                            @else
                              <li style="margin-left: 20px;"> {{ $ot_servicio->servicio }} </li> 
                            @endif
                            @if ($ot_servicio->procedimiento_sn)
                                <span style="margin-left: 30px; font-size:12px; ">Requiere Procedimiento</span><br>
                            @endif
                            <span style="margin-left: 30px; font-size:12px; ">Norma de ensayo:</span><span style="font-size: 9px;color:#808080;">{{$ot_servicio->norma_ensayo}}</span> <br>
                            <span style="margin-left: 30px; font-size:12px;">Norma de evaluación:</span><span style="font-size: 9px;color:#808080;">{{$ot_servicio->norma_evaluacion}}</span>
                          
                          </td>
                          <td style="font-size: 13px; width:80px;text-align: center;" >{{$ot_servicio->cantidad_servicios}}</td>
                          <td style="font-size: 13px; width:80px;text-align: center;" >Días</td>
                        
                      
                      @endforeach
                    </ul>
                    

                      @foreach ( $ot_productos as $ot_producto )
                      <tr> 
                        <td style="font-size: 13px; width:500px;" >
                          @if ($ot_producto->ot_referencia_id)
                          <li style="margin-left: 20px;"><a href="{{ route('ProductosReferencias',$ot_producto->ot_referencia_id)}}">{{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }}</a></li> <br>
                          @else
                          <li style="margin-left: 20px;">  {{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }} </li> </span>  
                          @endif 
                        </td>
                        <td style="font-size: 13px; width:80px;text-align: center;" >{{$ot_producto->cantidad_productos}}</td>
                        <td style="font-size: 13px; width:80px;text-align: center;" >Unidad</td>
                      </tr>  
                      @endforeach                  
                         
                  </tbody>
                </table>   
                
              </td>             
              
          </tr>
          <tr >
            <td>
              <table class="bordered" style="margin: 0px 7px 0px 7px">
                <tbody>
                  <tr style="vertical-align: bottom " >
                      <td style="font-size: 13px; width: 696px;">
                        <p style="margin: 5px 10px 5px 10px;"> <strong>Observaciones:</strong> {{$ot->observaciones}}</p>
                      </td>             
                  </tr>
                </tbody>
              </table>   
            </td>
          </tr>
          <tr>
            <td  style="width: 500px; padding: 5px 0px 5px 0px">
              <table >
                <tbody>
                  <tr>                     
                    <td style="font-size: 13px; width:500px" ><b>Elementos de Seguridad: </b>
                      @foreach ( $ot_epps as $ot_epp )
                          @if (!$loop->first)
                            ,
                          @endif
                        {{$ot_epp->descripcion}}
                      @endforeach
                    </td>                                                   
                  </tr>
                  <tr>
                      <td style="font-size: 13px; width:500px" ><b>Riesgos: </b>
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
          <tr >
            <td  class="bordered">
              <table>
                <tbody>
                  <tr >
                      <td style="font-size: 13px; width: 500px; padding: 20px 0px 10px 0px"><b>Responsable OT: </b>{{$responsable_ot->name }}</td>      
                      <td style="font-size: 13px; width: 200px; padding: 20px 0px 10px 0px"><b>Firma: </b></td>        
                  </tr>
                   <tr >
                      <td style="font-size: 13px; width: 500px; padding: 10px 0px 20px 0px"><b>Generador OT: </b>{{$generador_ot->name }}</td>     
                            
                  </tr>
                  
                </tbody>
              </table>   
            </td>
          </tr>   
        
      </tbody>
    </table>   

  </body>
</html>
