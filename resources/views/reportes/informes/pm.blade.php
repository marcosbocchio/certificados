<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe {{FormatearNumeroInforme($informe->numero,'PM')}}</title>
</head>

<style>

@page { margin: 352px 30px 130px 60px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -313px;    
    }

main{
   
    margin-top: -2px;
}

footer {

  position: fixed; bottom:6px; 
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
                                <td rowspan="4" style="text-align: right;">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 18px; height: 30px; text-align: center;" rowspan="3"><b>INFORME RADIOGRAFÍA INDUSTRIAL</b></td>
                                <td style="font-size: 11px;"><b style="margin-left: 40px"></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 80px" >INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'PM')}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 80px">FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 80px"></b></td>                     
                                <td style="font-size: 11px;"><b style="margin-left: 80px"></td>            
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
                                <td style="font-size: 11px;width: 233px;height: 45px; vertical-align: middle"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}} 
                                   
                                    @if($ot->logo_cliente_sn && $cliente->path)
                                     <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 40px; margin-left: 15px;margin-top: 5px;vertical-align:middle">
                                    @else
                                      <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 40px; margin-left: 15px;margin-top: 5px;vertical-align:middle">
                                    @endif
                                    
                                </td>                                      
                            
                                <td style="font-size: 11px; width: 253px; vertical-align: middle">
                                    @if($contratista)
                                        <b>CONTRATISTA: </b>{{$contratista->nombre}}
                                    @endif

                               
                                    @if($ot->logo_contratista_sn && $contratista->path_logo)
                                       <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height: 40px; margin-left: 15px;margin-top: 5px;vertical-align:middle">
                                    @else
                                       <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 40px; margin-left: 15px;margin-top: 5px;vertical-align:middle">
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
                            <td style="font-size: 11px; width: 200px;border-right: 1px solid #000;"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 11px;width: 50px; " colspan="2" ><b>Equipo: </b>{{$interno_equipo->equipo->codigo}}</td>
                            <td style="font-size: 11px;" ><b>Kv: </b>{{$informe->kv}}</td>
                            <td style="font-size: 11px; width: 50px; border-right: 1px solid #000;" ><b>mA: </b>{{$informe->ma}}</td>
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 11px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td>                            
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 11px;border-right: 1px solid #000;"  ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 11px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Método: </b>{{$metodo->codigo}}</td>
                            <td style="font-size: 11px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;"  ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 11px;border-right: 1px solid #000; " colspan="4"  ><b>Vehículo: </b>{{$informe_pm->vehiculo}}</td>
                            
                            
                            <td style="font-size: 11px;" colspan="2"  ><b>Desmaganetización: </b>

                            @if ($desmagnetizacion_sn)
                                SI
                            @else
                                NO 
                            @endif                    
                            
                            
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="font-size: 11px; border-right: 1px solid #000;"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 11px;border-right: 1px solid #000; " colspan="4"  ><b>Aditivo: </b>{{$informe_pm->aditivo}}</td>    
                            <td style="font-size: 11px;  " colspan="2" ><b>Dis.Fuente/pelicula: </b>{{$informe_pm->distancia_fuente_pelicula}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000; "  ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                {{ $informe->espesor_chapa }}
                                @else
                                {{  $diametro_espesor->espesor }}
                                @endif                       
                            
                            </td>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="4"  ><b>Tipo Magnetización: </b>{{$tipo_magnetizacion->codigo}}</td>    
                            <td style="font-size: 11px;  " colspan="2" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>                
                        
                        </tr>
                        <tr>                           
                            <td style="font-size: 11px;border-right: 1px solid #000;" ><b>Proc. Sold. : </b>{{$informe->procedimiento_soldadura}}</td>
                            
                           <td style="font-size: 11px;  " colspan="2"  ><b>Magnetización : </b>{{$magnetizacion->codigo}}</td>  
                           <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2"  ><b>Fueza Portante: </b>{{$magnetizacion->fuerza_portante}}</td>                            
                           <td style="font-size: 11px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->descripcion}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;" ><b>EPS: </b>{{$informe->eps}}</td>
                            <td style="font-size: 11px;" colspan="2"  ><b>Concentración: </b>{{$informe_pm->concentracion}}</td>
                            <td style="font-size: 11px;" colspan="1"  ><b>V: </b>{{$informe_pm->voltaje}}</td>  
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="1"  ><b>Am: </b>{{$informe_pm->amperaje}}</td>                          
                            <td style="font-size: 11px;" colspan="2"  ><b>Color Partículas: </b>{{$color_particula->codigo}} </td>  
                        </tr>
                        <tr>                           
                            <td style="font-size: 11px;border-right: 1px solid #000;" ><b>PQR: </b>{{$informe->pqr}}</td>
                            <td style="font-size: 11px; border-right: 1px solid #000; " colspan="4" ><b>Proc. PM: </b>{{$procedimiento_inf->titulo}} </td>
                             <td style="font-size: 11px;" colspan="2"  ><b>Iluminación: </b>{{$iluminacion->codigo}} </td>  

                        </tr>                
                        </tbody>
                    </table>   
                </td>
            </tr>
           
            <tr >
                <td >
                    <table  width="100%" style="text-align: center;border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="font-size: 11px; width:65px;  text-align: center " rowspan="2" class="bordered-td" >PIEZA</td>
                                <td style="font-size: 11px; width:40px;  text-align: center;" rowspan="2" class="bordered-td">N°</td>
                                <td style="font-size: 11px; width:465px; text-align: center;" rowspan="2" class="bordered-td">DETALLE</td>
                                <td style="font-size: 11px; width:80px; text-align: center;" colspan="2" class="bordered-td">RESULTADO</td>  
                                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">REF</td>                     
                            </tr>
                            <tr>
                                <td style="font-size: 11px; text-align: center;" class="bordered-td">AP</td>
                                <td style="font-size: 11px; text-align: center;" class="bordered-td">RZ</td>                            
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
                                <td style="font-size: 11px;" colspan="6" class="bordered-td"><b>Observaciones: </b>{{$informe->observaciones}}</td>                                  
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
    
    <table width="100%" class="bordered">
        <tbody>
            @foreach ($detalles as $detalle)
                <tr>
                    <td style="font-size: 11px;  width:66px;text-align: center" class="bordered-td">{{ $detalle->pieza }}</td>
                    <td style="font-size: 11px;  width:40px;text-align: center" class="bordered-td">{{$detalle->numero}}</td>
                    <td style="font-size: 11px;  width:465px;" class="bordered-td">&nbsp; {{$detalle->detalle}}</td>               
                    <td style="font-size: 11px; text-align: center;width:39px; " class="bordered-td">
                        @if ($detalle->aceptable_sn)
                            X
                        @endif
                    </td>

                    <td style="font-size: 11px; text-align: center;width:38px;" class="bordered-td">
                        @if (!$detalle->aceptable_sn)
                            X
                        @endif
                    </td>
                    <td class="bordered-td">&nbsp;
                        @if ($detalle->referencia_id)
                            <a href="{{ route('InformePmReferencias',$detalle->referencia_id)}}"><img src="{{ public_path('img/fa-file-pdf.jpg')}}" alt="" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>                                                       
                        @endif
                    </td>
                </tr>                
            @endforeach    

            {{ $cantFilasTotal = count($detalles) }}
            {{ $filasPage = 29 }}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}  

                  @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    <td style="font-size: 11px;  width:66px;text-align: center" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px;  width:40px;text-align: center" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px;  width:465px;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 11px; text-align: center;width:39px; " class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px; text-align: center;width:38px;" class="bordered-td">&nbsp;</td>
                    <td class="bordered-td">&nbsp;</td>
                </tr>
            @endfor                                  
        </tbody>
    </table>
</main>
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 485;
        $y = 77;
        $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 9;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }

    $pdf->line(46.5,130,46.5,800,array(0,0,0),1.5);
    $pdf->line(571.3,130,571.3,800,array(0,0,0),1.5);


</script>


</body>
</html>