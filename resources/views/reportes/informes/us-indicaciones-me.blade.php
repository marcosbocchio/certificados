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

@page { margin: 306px 30px 120px 60px !important;
        padding: 0px 0px 0px 0px !important; }


body {
    margin: 0 1px 6px 1px;
    padding: 10px 0 0 0;
}
header {
    position:fixed;
    top: -269px;    
    }

main{
   
    margin-top: 9px;
}

table {page-break-before:auto;}


footer {
    position: fixed; bottom: 7px; 
    padding-top: -7.5px;
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



</style>

<body class="bordered">   

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
                                <td style="font-size: 11px;width: 190px;height: 45px;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}                            
                                    
                                </td>  

                                <td style="width: 140px;">
                                    @if($ot->logo_cliente_sn && $cliente->path)
                                    <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @else
                                     <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 35px;margin-top: 5px;">
                                   @endif    
                                </td>                                    
                            
                                <td style="font-size: 11px; width: 190px;">
                                  
                                        @if($contratista)
                                            <b>COMITENTE: </b>{{$contratista->nombre}}
                                        @endif                                               
                                 
                                </td> 
                                <td>
                                    
                                    @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                                       <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height:35px;margin-top: 5px;">
                                    @else
                                       <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 35px;margin-top: 5px;">
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
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 11px;">Norma Evaluación: </b>{{$norma_evaluacion->codigo}}</td> 
                           
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 11px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Encoder:{{$informe_us->encoder}} </b></td>
                            <td style="font-size: 11px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->codigo}}</td>     
           
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
                            <td style="font-size: 11px;  " colspan="2" ><b>Ejec. Ensayo: : </b>{{$ejecutor_ensayo->name}}</td>  

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
                <td style="border-bottom: 2px solid #000;background:#D8D8D8" >REGISTRO DE MEDICIONES</td>
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
    
    @foreach ($informes_us_me as $informe_us_me)   

            @php 
                $pos_gen = 1;
                $max_cant_genetratices_fila = 20;
                $genetratrices_fila = $max_cant_genetratices_fila;
            @endphp            
            <table>
                <tbody>
                    <tr>
                         <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Elemento : {{ strtoupper($informe_us_me->elemento)}}</span></td> 
                    </tr>
                    @if ($informe_us_me->umbral)
                        <tr>
                             <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Umbral : {{ strtoupper($informe_us_me->umbral)}}</span></td> 
                        </tr>                     
                    @endif

                    @if ($informe_us_me->espesor_minimo)
                        <tr>
                             <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Espesor Mínimo : {{ strtoupper($informe_us_me->espesor_minimo)}}</span></td> 
                        </tr>
                    @endif
                    <tr>
                        <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Ø : {{ $informe_us_me->diametro}}</span></td>  
                    </tr>
                </tbody>
            </table>            
            @while($pos_gen <= $informe_us_me->cantidad_generatrices)
                <table  style="text-align: center;margin-left:18px;margin-bottom: 10px;border-collapse: collapse;"  class="bordered">
                    <thead>                    
                        <tr>  
                            <th style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8"  class="bordered-1">&nbsp;</th>
                            @while( ($pos_gen <= $genetratrices_fila) && ($pos_gen <= $informe_us_me->cantidad_generatrices))   
                                <th style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8" class="bordered-1">
                                    @foreach ($generatrices as $generatriz )
                                            
                                        @if($generatriz->nro == $pos_gen)
                                            {{  $generatriz->valor }}
                                        @endif

                                    @endforeach

                                </th>
                                {{ $pos_gen = $pos_gen + 1}}
                            @endwhile   
                            {{ $genetratrices_fila = $genetratrices_fila + $max_cant_genetratices_fila }}                                
                        </tr>
                      </thead>
                      <tbody>
                        @for ( $pos_pos= 1 ;  $pos_pos <= $informe_us_me->cantidad_posiciones ; $pos_pos++)
                                <tr> 
                                    <td style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8" class="bordered-1">{{$pos_pos}}</td>
                                    @for ($pos_gen_fila = ($genetratrices_fila - (2*$max_cant_genetratices_fila)+1) ; $pos_gen_fila <= $pos_gen - 1 ; $pos_gen_fila++)

                                    {{ $x =0  }}
                                
                                        @foreach ($informe_us_me->detalle_us_me as $item_detalle )

                                            @foreach ($generatrices as $generatriz)
                                                
                                                @if ($pos_pos==$item_detalle->posicion && $pos_gen_fila == $generatriz->nro && $item_detalle->generatriz==$generatriz->valor)  

                                                    @if(($informe_us_me->espesor_minimo) && (strval($item_detalle->valor) < strval($informe_us_me->espesor_minimo)))

                                                       <td style="font-size: 13px; text-align: left;width:28px;text-align: center;color:red" class="bordered-1">{{$item_detalle->valor}}</td>

                                                    @else

                                                        <td style="font-size: 13px; text-align: left;width:28px;text-align: center" class="bordered-1">{{$item_detalle->valor}}</td>
                                                    
                                                    @endif

                                                    {{ $x =1  }}

                                                @endif

                                            @endforeach                                                                                            
                                        
                                    @endforeach                                                                             
                                    
                                    @if ($x==0)
                                            <td style="font-size: 13px; text-align: left;width:28px;text-align: center" class="bordered-1">X</td>
                                    @endif

                                    @endfor
                                </tr>                                        
                            @endfor
                        </tr>       
                    </tbody>
                </table>                               
            @endwhile           
    @endforeach


  @if($informe_us->path1_indicacion || $informe_us->path2_indicacion || $informe_us->path2_indicacion || $informe_us->path2_indicacion)
       
        <div class="page-break"></div>
  @endif
   
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
 
</script>

</body>
</html>