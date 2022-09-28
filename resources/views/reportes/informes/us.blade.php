<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>INFORME {{FormatearNumeroInforme($informe->numero,'US')}}</title>
</head>

<style  type='text/css'>

.EspecialCaracter {
    font-family: DejaVu Sans;
}

@page { margin: 293px 40px 140px 40px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -253px;    
    }

body {
    margin: 0px 1px 0px 1px;
    padding: 0 0 0 0;
}

main{
   
    margin-top: -2px;
}


footer {
    position: fixed; bottom:6px; 
    padding-top: 2px;
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
.vcenter {
    display: table-cell;
    vertical-align: middle;
}

b {

    margin-left: 2px;
}

#rotate
{
  height:170px;
}

#vertical
{
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
}
</style>

<body class="bordered" style="border-top: none;border-bottom: none;">  

<header>
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
            <tr>
                 <td>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="text-align: right;width: 240px;">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 19px; height: 30px;width: 295px; text-align: center;margin-left: 0px" rowspan="4"><b>INFORME DE ULTRASONIDO ({{mb_strtoupper($tecnica->descripcion,"UTF-8")}})</b></td>
                                <td style="font-size: 11px;">&nbsp;</td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;width: 140px;"><span style="float:right"><b>INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'US')}}</span></td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 11px;width: 140px;"><span style="float:right;margin-right: 9px;"><b >FECHA: </b>{{ date('d-m-Y', strtotime($informe->fecha)) }}</span></td>
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
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>                 
                        <tr>
                            <td style="font-size: 11px; width: 200px;border-right: 1px solid #000;" colspan="2"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 11px;width: 50px;border-right: 1px solid #000; " colspan="4" ><b>Equipo: </b>{{$interno_equipo->equipo->codigo}}</td>
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 11px;">Norma Evaluación: </b>{{$norma_evaluacion->codigo}}</td> 
                           
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 11px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Encoder:{{$informe_us->encoder}} </b></td>
                            <td style="font-size: 11px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->codigo}}</td>     
           
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Material A.: </b>

                                @if ($material_accesorio)
                                    {{$material_accesorio->codigo}}                                
                                @endif
                                
                            </td>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="4"  ><b>Estado Superficie: </b>{{$estado_superficie->codigo}}</td>                            
                            <td style="font-size: 11px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->descripcion}}</td>
                        
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="4"  ><b>Agente Acoplamiento : </b>{{$agente_acoplamiento->codigo}}</td>
                            <td style="font-size: 11px;  " colspan="2" ><b>Ejec. Ensayo: </b>{{$ejecutor_ensayo->name}}</td>  

                        </tr>
                        <tr>
                            <td style="font-size: 11px;" colspan="1"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 11px;border-right: 1px solid #000; " colspan="1" ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                   {{ $informe->espesor_chapa }}
                                @elseif ($diametro_espesor->diametro == 'VARIOS')
                                         &nbsp;
                                @elseif($informe->espesor_especifico)
                                    {{ $informe->espesor_especifico }}
                                @else
                                    {{  $diametro_espesor->espesor }}
                                @endif    


                                                                @if ($informe->espesor_chapa)
                                    {{ $informe->espesor_chapa }}
                                @elseif($informe->espesor_especifico)
                                    {{ $informe->espesor_especifico }}
                                @else
                                     {{ $diametro_espesor->espesor }}
                                @endif                      
                            
                            </td>    
                            <td style="font-size: 10px;border-right: 1px solid #000;" colspan="4" ><b>EPS: </b>{{$ot_tipo_soldadura->eps}}</td>
                            <td style="font-size: 11px;" colspan="2" >&nbsp;</td>
                        </tr>  
                        <tr>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="2" ><b>Proc. : </b>{{$procedimiento_inf->titulo}} </td>
                            <td style="font-size: 10px;border-right: 1px solid #000;" colspan="4"><b>PQR: </b>{{$ot_tipo_soldadura->pqr}}</td>
                            <td style="font-size: 11px;" colspan="2" >&nbsp;</td>
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
                                    <td style="font-size: 11px;height: 30px;" colspan="6" rowspan="2" class="bordered-td"><b>Observaciones: </b>{{$informe->observaciones}}</td>                                  
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
                                   <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>CLIENTE </b></td> 
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
    <table style="text-align: center;border-collapse: collapse;">
        <tbody>
                <tr>           
                <td>
                    <tr>
                        <td style="border-bottom: 2px solid #000;background:#D8D8D8;padding-top:5px;" colspan="16">DATOS DE CALIBRACIÓN</td>
                    </tr>
                    <tr>
                        
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: 14px;margin-right: 14px;">ZAPATA</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: 6px;margin-right: 6px;">PALPADOR</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: 13px;margin-right: 13px;">N° SERIE</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -48px;margin-right: -48px;">FRECUENCIA (Mhz)</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -30px;margin-right: -30px;">ANG. APERTURA</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -3px;margin-right:  -3px;">RANGO</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -12px;margin-right: -12px;">POSICIÓN</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -45px;margin-right: -45px;">CURVA ELEVACION</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -55px;margin-right: -55px;">BLOCK CALIBRACIÓN</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -50px;margin-right: -50px;">BLOCK SENSIBILIDAD</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -49.5px;margin-right: -49.5px;">REFLECTOR REF. (mm)</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -50px;margin-right: -50px;">GANANCIA REF. (dB)</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -38px;margin-right: -38px;">NIVEL REGISTRO</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -54.5px;margin-right: -54.5px;">CORREC. TRANSF (dB)</div></td>
                        <td id="rotate" style="border-right: 1px solid #000;font-size: 13px;"><div id="vertical" style="margin-left: -67.5px;margin-right: -67.5px;">ADICIONAL BARRIDO (dB)</div></td>
                        <td id="rotate" style="font-size: 13px;"><div id="vertical" style="margin-left: -45px;margin-right: -45px;">AMPLIF. TOTAL (dB)</div></td>
        
                    </tr>
                </td>
            </tr>
        </tbody>
    </table> 
    <table width="100%" class="bordered" style="padding: 0 -3px 0 -3px;" >
        <tbody>
            @foreach ($calibraciones_us as $calibracion)
                <tr>
                    <td style="font-size: 10px; width:80px;text-align: center;"class="bordered-td">{{ strtoupper($calibracion->zapata) }}</td>
                    <td style="font-size: 10px; width:80px;text-align: center;" class="bordered-td">
                        @if ($calibracion->palpador)
                          {{$calibracion->palpador->equipo->codigo}}    
                        @endif
                    </td>
                    <td style="font-size: 10px; width:79.7px;text-align: center;" class="bordered-td">
                        @if ($calibracion->palpador)
                           {{$calibracion->palpador->nro_serie}}
                        @endif
                    </td>
                    <td style="font-size: 10px; width:20.9px;  text-align: center;" class="bordered-td">{{$calibracion->frecuencia}}</td> 
                    <td style="font-size: 10px; width:42.8px;text-align: center;" class="bordered-td">{{$calibracion->angulo_apertura}}</td>          
                    <td style="font-size: 10px; width:39.7px;text-align: center;" class="bordered-td">{{$calibracion->rango}}</td>               
                    <td style="font-size: 10px; width:35.5px;text-align: center;" class="bordered-td">{{strtoupper($calibracion->posicion)}}</td>               
                    <td style="font-size: 10px; width:32.8px;text-align:   center;" class="bordered-td">{{$calibracion->curva_elevacion}}</td>               
                    <td style="font-size: 10px; width:25.5px;text-align: center;" class="bordered-td">
                        @if ($calibracion->block_calibracion == 'Probeta')
                            Pr
                        @elseif(($calibracion->block_calibracion == 'Escalonado'))
                            Es
                        @else
                              {{$calibracion->block_calibracion}}
                        @endif
                    </td>               
                    <td style="font-size: 10px; width:36.5px;text-align: center;" class="bordered-td">{{$calibracion->block_sensibilidad}}</td>               
                    <td style="font-size: 10px; width:37.5px;text-align: center;" class="bordered-td"><span class="EspecialCaracter">{{$calibracion->tipo_reflector}}</span> &nbsp; {{$calibracion->reflector_referencia}}</td>               
                    <td style="font-size: 10px; width:26px;text-align: center;" class="bordered-td">{{$calibracion->ganancia_referencia}}</td>               
                    <td style="font-size: 10px; width:29.3px;text-align: center;" class="bordered-td">{{$calibracion->nivel_registro}}&nbsp;%</td>               
                    <td style="font-size: 10px; width:25.5px;text-align: center;" class="bordered-td">{{$calibracion->correccion_transferencia}}</td>               
                    <td style="font-size: 10px; width:25.7px;text-align: center;" class="bordered-td">{{$calibracion->adicional_barrido}}</td>               
                    <td style="font-size: 10px;text-align: center" class="bordered-td">{{$calibracion->amplificacion_total}}</td>               

                </tr>     
            @endforeach
          
            {{ $filasACompletar = 4 - count($calibraciones_us) }}  
            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    <td style="font-size: 10px; width:80px;text-align: center;"class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; width:80px;text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; width:79.7px;text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; width:20.9px;  text-align: center;" class="bordered-td">&nbsp;</td> 
                    <td style="font-size: 10px; width:42.8px;text-align: center;" class="bordered-td">&nbsp;</td>          
                    <td style="font-size: 10px; width:39.7px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:35.5px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:32.8px;text-align:   center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:25.5px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:36.5px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:37.5px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:26px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:29.3px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:25.5px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px; width:25.7px;text-align: center;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 10px;text-align: center" class="bordered-td">&nbsp;</td>
                </tr>
            @endfor
       
        </tbody>
    </table>
    
    <table style="text-align: center;margin-top: 5px;" width="100%" >
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td style="text-align: center; width: 340px;height: 190px;">
                                        
                                    @if ($informe_us->path1_calibracion)
                                        <img src="{{ public_path($informe_us->path1_calibracion) }}" alt="" style="height: 180px; width: 263px;">
                                    @endif  
                    
                                </td>

                                <td style="text-align: center; width: 340px;height: 190px;">
                                        
                                    @if ($informe_us->path2_calibracion)
                                        <img src="{{ public_path($informe_us->path2_calibracion) }}" alt="" style="height: 180px; width: 263px;">
                                    @endif  
                    
                                </td>  
                            </tr>
                            <tr>
                                <td style="text-align: center; width: 340px;height: 190px;">
                                    
                                    @if ($informe_us->path3_calibracion)
                                        <img src="{{ public_path($informe_us->path3_calibracion) }}" alt="" style="height: 180px; width: 263px;">
                                    @endif  
                        
                                </td>

                                <td style="text-align: center; width: 340px;height: 190px;">

                                    @if ($informe_us->path4_calibracion)
                                        <img src="{{ public_path($informe_us->path4_calibracion) }}" alt="" style="height: 180px; width: 263px;">
                                    @endif  
                        
                                </td>
                            </tr>                        
                        </tbody>
                    </table>             
                </td>
            </tr>
            <tr>
                <td style="border-top: 2px solid #000;background:#D8D8D8;text-align: center;" >
                   REGISTRO DE MEDICIONES
                   @if($tecnica->codigo == 'US' || $tecnica->codigo=='PA')
                   <a href="{{ route('InformeUsIndicacionesUsPa',$informe->id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>
                   @elseif($tecnica->codigo ='ME')
                   <a href="{{ route('InformeUsIndicacionesMe',$informe->id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>
                   @endif
               </td>
            </tr>
        </tbody>
    </table>
</main>
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 484;
        $y = 75;
        $current_page = "{PAGE_NUM}";
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