<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Informe {{FormatearNumeroInforme($informe->numero,'US')}}</title>
</head>

<style  type='text/css'>

.EspecialCaracter {
    font-family: DejaVu Sans;
}

.page-break {
    page-break-after: always;
}

@page { margin: 308px 30px 125px 60px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -271px;    
    }

main{
   
    margin-top: -2px;
}


footer {
    position: fixed; bottom: 6px; 
    padding-top: -5px;
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
  height:165px;
}

#vertical
{
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
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
                                            <b>CONTRATISTA: </b>{{$contratista->nombre}}
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
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>                 
                        <tr>
                            <td style="font-size: 11px; width: 200px;border-right: 1px solid #000;" colspan="2"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 11px;width: 50px;border-right: 1px solid #000; " colspan="4" ><b>Equipo: </b>{{$interno_equipo->equipo->codigo}}</td>
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 11px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td> 
                           
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 11px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Encoder:{{$informe_us->encoder}} </b></td>
                            <td style="font-size: 11px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>     
           
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="4"  ><b>Estado Superficie: </b>{{$estado_superficie->codigo}}</td>                            
                            <td style="font-size: 11px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->descripcion}}</td>
                        
                        </tr>
                        <tr>
                            <td style="font-size: 11px;" colspan="1"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 11px;border-right: 1px solid #000; " colspan="1" ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                   {{ $informe->espesor_chapa }}
                                @elseif ($diametro_espesor->diametro == 'VARIOS')
                                         &nbsp;
                                @else
                                    {{  $diametro_espesor->espesor }}
                                @endif                       
                            
                            </td>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="4"  ><b>Agente Acoplamiento : </b>{{$informe_us->agente_acoplamiento}}</td>
                            <td style="font-size: 11px;  " colspan="2" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>  

                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2"><b>Proc. Sold. : </b>{{$informe->procedimiento_soldadura}}</td>                            
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="4" ><b>EPS: </b>{{$informe->eps}}</td>
                            <td style="font-size: 11px;" colspan="2" >&nbsp;</td>
                        </tr>  
                        <tr>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="2" ><b>Proc. US: </b>{{$procedimiento_inf->titulo}} </td>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="4"><b>PQR: </b>{{$informe->pqr}}</td>
                            <td style="font-size: 11px;" colspan="2" >&nbsp;</td>
                        </tr>          
                        </tbody>
                    </table>   
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 2px solid #000;background:#D8D8D8" >REGISTRO DE INDICACIONES</td>
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
                                   <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>EVALUADOR </b></td>   
                                   <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>CONTRATISTA </b></td> 
                                   <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>CLIENTE </b></td>                              
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

    <table style="text-align: center;border-collapse: collapse;" class="bordered" >
        <thead>
            <tr>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 17px;margin-right: 17px;">ELEMENTO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 6px;margin-right: 6px;">DIAMETRO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -30px;margin-right: -30px;">N° INDICACIÓN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -38px;margin-right: -38px;">POSICION EXAMEN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -25px;margin-right: -25px;">ANG. INCIDENCIA</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -33px;margin-right:  -33px;">CAMINO SONICO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 7.2px;margin-right: 7.2px;">X (cm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 5px;margin-right: 5px;">Y (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 5.7px;margin-right: 5.7px;">Z (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -34px;margin-right: -34px;">LONGITUD (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -37.8px;margin-right: -37.8px;">NIVEL REGISTRO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;" ><div id="vertical" style="margin-left: -4px;margin-right: -4px;">RESULTADO</div></th>
                <th id="rotate" style="font-size: 13px;font-weight: normal;" ><div id="vertical" style="margin-left: -30px;margin-right: -30px;">REFERENCIA</div></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indicaciones_us_pa  as $indicacion)
            <tr>                
                  <td style="font-size: 10px;height: 16px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->elemento) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">ø {{ $indicacion->diametro }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->nro_indicacion }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->posicion_examen) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->angulo_incidencia) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->camino_sonico }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->x }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->y }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->z }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->longitud }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->nivel_registro)}}</td>

                  <td style="font-size: 10px;text-align: center;" class="bordered-td">
                  @if($indicacion->aceptable_sn)
                      APROBADO
                   @else
                      RECHAZADO
                  @endif
                  </td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">

                   @if ($indicacion->detalle_us_pa_us_referencia_id)
                        <a href="{{ route('InformeUsDetalleUsPaUsReferencias',$indicacion->detalle_us_pa_us_referencia_id)}}"><img src="{{ public_path('img/fa-file-pdf.jpg')}}" alt="" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>                                                       
                    @endif
                  
                  </td>
        
            </tr>        
            @endforeach   

            {{ $cantFilasTotal = count($indicaciones_us_pa) }}
            {{ $filasPage = 27}}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}

            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    <td style="font-size: 10px; height: 16px;text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>      
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 10px; text-align: center;" class="bordered-td">&nbsp;</td>
               </tr>
            @endfor
        </tbody>
    </table>

   
  <div class="page-break"></div>

   <table style="text-align: center;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td style="text-align: center; width: 340px;height: 190px;">
                                        
                                    @if ($informe_us->path1_indicacion)
                                        <img src="{{ public_path($informe_us->path1_indicacion) }}" alt="" style="height: 180px; width: 263px;">
                                    @endif  
                    
                                </td>

                                <td style="text-align: center; width: 340px;height: 190px;">
                                        
                                    @if ($informe_us->path2_indicacion)
                                        <img src="{{ public_path($informe_us->path2_indicacion) }}" alt="" style="height: 180px; width: 263px;">
                                    @endif  
                    
                                </td>  
                            </tr>
                            <tr>
                                <td style="text-align: center; width: 340px;height: 190px;">
                                    
                                    @if ($informe_us->path3_indicacion)
                                        <img src="{{ public_path($informe_us->path3_indicacion) }}" alt="" style="height: 180px; width: 263px;">
                                    @endif  
                        
                                </td>

                                <td style="text-align: center; width: 340px;height: 190px;">

                                    @if ($informe_us->path4_indicacion)
                                        <img src="{{ public_path($informe_us->path4_indicacion) }}" alt="" style="height: 180px; width: 263px;">
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

    $pdf->line(46.5,130,46.5,780,array(0,0,0),1.5);
    $pdf->line(571.3,130,571.3,780,array(0,0,0),1.5);
 
</script>


</body>
</html>