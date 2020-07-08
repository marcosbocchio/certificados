<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PROYECTO : {{$ot->proyecto }} - OT N° : {{$ot->numero}}</title>
<link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

</head>

<style>

    @page { margin: 260px 40px 220px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -237px;    
}        
    
footer {
    position: fixed; bottom:0px; 
    padding-top: 0px;
}


</style>

<body>
<header>
<table style="text-align: center;" width="100%">
    <tbody>
        <tr>
            <td>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td rowspan="4" style="text-align: right;width: 240px;">
                                <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                            </td>   
                            <td style="font-size: 19px; height: 30px;width: 200px; text-align: center;margin-left: 0px" rowspan="3"><b>{{ $titulo }}</b></td>
                            <td style="font-size: 11px;" ><b style="margin-left: 131px;">&nbsp;</td>          
                        </tr>
                        <tr>
                            <td style="font-size: 11px;" ><b style="margin-left: 131px;">OT N°: </b>{{ $nro_ot }}</td>     
                            
                        </tr>
                        <tr>
                            <td style="font-size: 11px;"><b style="margin-left: 131px;">FECHA: </b>{{ $fecha }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;">&nbsp;</td>                     
                            <td style="font-size: 11px;">&nbsp;</td>            
                        </tr>               
                    </tbody>
                </table>          
            </td>
        </tr>
    </tbody>
</table>
    @include('reportes.partial.linea-amarilla')                
    @include('reportes.informes.partial.header-cliente-comitente-portrait')    
    @include('reportes.partial.linea-gris')        
    @include('reportes.informes.partial.header-proyecto-portrait')    
    @include('reportes.partial.linea-amarilla') 
</header>

<footer>
    <table width="100%">
        <tbody>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>               
            </tr>
        </tbody>
    </table>

    @include('reportes.partial.linea-amarilla') 

    @include('reportes.informes.partial.observaciones') 

    @include('reportes.partial.linea-amarilla') 

    <table width="100%">
        <tbody>
            <tr>
                <td style="font-size: 13px;" colspan="6"><b>Firmas </b></td> 
            </tr>
            <tr>
                <td style="font-size: 13px;text-align: center;height: 50px;" colspan="2">
                    @if($evaluador && $evaluador->path)
                        <img src="{{ public_path($evaluador->path)}}" alt="" style="width: 100px;height: 50px;">
                    @endif     
                </td>               
            </tr>
            <tr>                               
                <td style="font-size: 14px; text-align: center;"" colspan="3"><em>Responsable OT </em></td>   
                <td style="font-size: 14px; text-align: center;" colspan="3"><em>Generador OT </em></td> 
            </tr>
        </tbody>
    </table>

</footer>

<main>   

    <table class="header-detalle-principal">
        <tbody>
            <tr>
                <td width="49%">
                    <table style="font-size: 12px;" width="100%" class="header-detalle">
                        <tbody>

                            <tr>
                                <th colspan="2">Lugar de ensayo</th>
                            </tr>  
                            <tr>
                                <td colspan="2">{{$ot->lugar}}
                                    <a href="{{ $geo }}" target="_blank" >
                                        <img src="{{ public_path('img/mark-google-maps.jpg')}}" alt="" style="height: 14px;">
                                    </a>                                  
                                </td>
                            </tr>   
                            
                            <tr>
                                <th colspan="2">Localidad</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$localidad->localidad}}</td>
                            </tr>  
                            
                            <tr>
                                <th colspan="1">Contacto 1</th>
                                <th colspan="1">Tel</th>
                            </tr>
                            <tr>
                                <td colspan="1">{{$contacto1->nombre}}</td>
                                <td colspan="1">{{$contacto1->tel}}</td>
                            </tr>

                            @if($contacto2)
                                <tr>
                                    <th colspan="1">Contacto 2</th>
                                    <th colspan="1">Tel</th>
                                </tr>
                                <tr>
                                    <td colspan="1">                                  
                                        {{$contacto2->nombre}}                               
                                    </td>
                                    <td colspan="1">
                                        @if($contacto2->tel)
                                        {{$contacto2->tel}}
                                        @else
                                        &nbsp;
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            
                            @if($contacto3)
                                <tr>
                                    <th colspan="1">Contacto 3</th>
                                    <th colspan="1">Tel</th>
                                </tr>
                                <tr>
                                    <td colspan="1">           
                                        {{$contacto3->nombre}}                                
                                    </td>
                                    <td colspan="1">
                                        @if($contacto3->tel)
                                        {{$contacto3->tel}}
                                        @else
                                        &nbsp;
                                        @endif                    
                                    </td>
                                </tr>            
                             @endif

                            <tr>
                                <th colspan="2">Métodos de Ensayos</th>
                            </tr>   
                            <tr>
                                <td colspan="2">
                                    @foreach ( $metodos_ensayos as $metodo )

                                    @if (!$loop->first)
                                      ,
                                    @endif 
      
                                        {{ $metodo->metodo }} 
      
                                    @endforeach
                                </td>
                            </tr> 

                            <tr>
                                <th colspan="2">Fecha Estimada Ensayo</th>   
                            </tr>

                            <tr>
                                <td colspan="2" class="borderFila">{{ date('d-m-Y', strtotime($ot->fecha_hora_estimada_ensayo)) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </td>
                <td width="2%">
                    &nbsp;
                </td>
                <td width="49%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>
             
                            <tr>
                                <th colspan="2">Horario</th>
                            </tr>  
                            <tr>
                                <td colspan="2">{{ date('H:i', strtotime($ot->fecha_hora_estimada_ensayo)) }}</td>
                            </tr>   
                            
                            <tr>
                                <th colspan="2">Provincia</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$provincia->provincia}}</td>
                            </tr>   

                            <tr>
                                <th colspan="1">Cargo</th>
                                <th colspan="1">Email</th>
                            </tr>
                            <tr>
                                <td colspan="1">{{$contacto1->email ?? ''}}</td>
                                <td colspan="1">{{$contacto1->tel ?? ''}}</td>
                            </tr>

                            @if($contacto2)
                                <tr>
                                    <th colspan="1">Cargo</th>
                                    <th colspan="1">Email</th>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                        @if($contacto2->email)
                                            {{$contacto2->email}}
                                        @else
                                            &nbsp;
                                        @endif
                                        
                                    </td>
                                    <td colspan="1">
                                        @if($contacto2->tel)
                                            {{$contacto2->tel}}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                             @endif

                             @if($contacto3)

                                <tr>
                                    <th colspan="1">Cargo</th>
                                    <th colspan="1">Email</th>
                                </tr>
                                <tr>
                                    <td colspan="1">                          
                                        @if($contacto3->email)
                                            {{$contacto3->email}}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    <td colspan="1">
                                        @if($contacto3->tel)
                                            {{$contacto3->tel}}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                             @endif   

                            <tr>
                                <th colspan="2">Calidad de Placa</th>
                            </tr>     
                            <tr>
                                <td colspan="2">
                                    @foreach ($ot_calidad_placas as $ot_calidad_placa)
                          
                                    @if (!$loop->first)
                                    ,
                                    @endif 
                                    
                                        {{ $ot_calidad_placa->codigo  }}
                                    
                                    @endforeach
                                </td>                                
                            </tr>  
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    
    @include('reportes.partial.linea-amarilla')  

    <table width="100%">

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
                        <li style="margin-left: 20px;font-size: 11px;" class="EspecialCaracter"><a href="{{ route('ProductosReferencias',$ot_producto->ot_referencia_id)}}">{{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }}</a></li> <br>
                        @else
                        <li style="margin-left: 20px;font-size: 11px;" class="EspecialCaracter">  {{ $ot_producto->producto }} {{ $ot_producto->medida }} {{ $ot_producto->unidad_medida_codigo }} </li> </span>  
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
            $x = 468;
            $y = 66;
            $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        /* $pdf->line(34,167,561,167,array(0,0,0),1.5); */
        }

    </script>

</body>
</html>