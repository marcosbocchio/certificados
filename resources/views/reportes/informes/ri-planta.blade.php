<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe RI</title>
</head>

<style>

@page { margin: 329px 10px 194px 40px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -290px; 
   
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
                                <td rowspan="4" style="text-align: right; width:233px">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 18px; height: 30px; text-align: center;width:234px" rowspan="3"><b>INFORME RADIOGRAFÍA INDUSTRIAL</b></td>
                                <td style="font-size: 12px;"><b style="margin-left: 40px"></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 12px;" ><b style="margin-left: 120px" >INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'RI')}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 120px">FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 120px"></b></td>                     
                                <td style="font-size: 12px;"><b style="margin-left: 120px"></td>            
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
            <tr>
                <td class="bordered">
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>                 
                        <tr>
                            <td style="font-size: 12px; width: 200px;border-right: 1px solid #000;" colspan="2"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 12px;width: 50px; " colspan="2" ><b>Equipo: </b>{{$interno_equipo->equipo->codigo}}</td>
                            <td style="font-size: 12px;" ><b>Kv: </b>{{$interno_equipo->voltaje}}</td>
                            <td style="font-size: 12px; width: 50px; border-right: 1px solid #000;" ><b>mA: </b>{{$interno_equipo->amperaje}}</td>
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 12px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td>                            
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 12px;border-right: 1px solid #000;" colspan="2" ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 12px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Fuente: </b>     

                            @if ($fuente)

                                {{$fuente->codigo}} 
                                
                            @endif
                            
                            
                            </td>
                            <td style="font-size: 12px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000;" colspan="2" ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4"  ><b>Foco: </b>{{$informe_ri->foco}}</td>                            
                            <td style="font-size: 12px;  " colspan="2" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>                          
                        </tr>
                        <tr>
                            <td style="font-size: 12px;" colspan="1"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 12px;border-right: 1px solid #000; " colspan="1" ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                {{ $informe->espesor_chapa }}
                                @else
                                {{  $diametro_espesor->espesor }}
                                @endif                       
                            
                            </td>
                            <td style="font-size: 12px;" colspan="2"  ><b>Pelicula : </b>{{$tipo_pelicula->fabricante}}</td>    
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="2"  ><b>Tipo: </b>{{$tipo_pelicula->codigo}}</td> 
                            <td style="font-size: 12px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->codigo}}</td>

                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000;" colspan="2"><b>Proc. Sold. : </b>{{$informe->procedimiento_soldadura}}</td>                            
                            <td style="font-size: 12px; width: 75px"   ><b>Pantalla: </b>Pb</td>
                            <td style="font-size: 12px; width: 15px"  ><b>Ant: </b>{{$informe_ri->pos_ant}}</td>
                            <td style="font-size: 12px; width: 15px"  ><b>Pos: </b>{{$informe_ri->pos_pos}}</td>
                            <td style="font-size: 12px; width: 1px; border-right: 1px solid #000;"  ><b>Lado: </b>{{$informe_ri->lado}}</td>      
                            <td style="text-align: center; " colspan="2" rowspan="4" >
                               <img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height: 65px; margin-right: 25px;">                                   
                            </td>                  
                        </tr>
                        <tr>                           
                            <td style="font-size: 12px;border-right: 1px solid #000;" colspan="2" ><b>Eps: </b>{{$informe->eps}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4" ><b>Ici : </b>{{$ici->codigo}}</td>                            
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000;" colspan="2"><b>Pqr: </b>{{$informe->pqr}}</td>
                            <td style="font-size: 12px;" colspan="2" ><b>Actividad: </b>{{$informe_ri->actividad}}</td>
                            <td style="font-size: 12px;border-right: 1px solid #000;" colspan="2" ><b>N° Exp. : </b>{{$informe_ri->exposicion}}</td>  
                           
                        </tr>
                        <tr>                           
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="2" ><b>Proc. RI: </b>{{$procedimiento_inf->titulo}} </td>
                             <td style="font-size: 12px;border-right: 1px solid #000;" colspan="4" ><b>Dis.Fuente/pelicula: </b>{{$informe_ri->distancia_fuente_pelicula}}</td>


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
                                <td style="font-size: 12px; width:65px;  text-align: center " rowspan="2" class="bordered-td" >JUNTA</td>
                                <td style="font-size: 12px; width:65px;  text-align: center;" rowspan="2" class="bordered-td">CUÑO</td>
                                <td style="font-size: 12px; width:64.5px; text-align: center;" rowspan="2" class="bordered-td">POSICIÓN</td>
                                <td style="font-size: 12px; width:201.5px;  text-align: center;" rowspan="2" class="bordered-td">DEFECTOS</td>  
                                <td style="font-size: 12px; width:80px; text-align: center;" colspan="2" class="bordered-td">RESULTADO</td>  
                                <td style="font-size: 12px; text-align: center" rowspan="2" class="bordered-td">OBSERVACIÓN</td>                     
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
                                <td style="font-size: 11px; " class="bordered-td"><b>F: </b>Fisura</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>FF: </b>Falta de fusion</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>FP: </b>Falta de Penetración</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>FPD: </b>FP por Desalineación</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>FFP: </b>FF por Pasadas</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>HL: </b>Desalineación</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px; " class="bordered-td"><b>PE: </b>Penetración Excesiva</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>Q: </b>Quemaduras</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>CI: </b>Concavidad Interna</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>CE: </b>Concavidad Externa</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>SI: </b>Socavado Interior</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>SE: </b>Socavado Exterior</td>                                
                            </tr>
                            <tr>
                                <td style="font-size: 11px; " class="bordered-td"><b>ME: </b>Escoria Aislada</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>MEL: </b>Socavado Lineal</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>P: </b>Poros</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>NP: </b>Nido de Poros</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>PV: </b>Poro Vermicular</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>CH: </b>Cordón Hueco</td>                                
                            </tr>
                            <tr>
                                <td style="font-size: 11px; " class="bordered-td"><b>IT: </b>Inclusión de Tungteno</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>SA: </b>Salto de Arco</td>
                                <td style="font-size: 11px; " colspan="2" class="bordered-td"><b>AD: </b>Acumulación de Discontinuidades</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>DP: </b>Defecto de Placa</td>
                                <td style="font-size: 11px; " class="bordered-td"><b>RP: </b>Repetir Placa</td>
                            </tr>
                            <tr>
                                 <td style="font-size: 11px; " colspan="3" class="bordered-td"><b>AP: </b>Aprobado</td>                          
                                 <td style="font-size: 11px; " colspan="3" class="bordered-td"><b>RZ: </b>Rechazado</td>
                            </tr>
                            <tr>                                
                                <td style="font-size: 12px;" colspan="6" class="bordered-td"><b>Observaciones: </b>{{$informe->observaciones}}</td>                                  
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
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td"><b>CLIENTE </b></td>                              
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;width:50px;"><span style="margin-left: 2px">FIRMA:</span></td>   
                                <td style="font-size: 12px; border-right: 1px solid #000;width:150px;" rowspan="2">
                                @if($evaluador && $evaluador->path)
                                     <img src="{{ public_path($evaluador->path)}}" alt="" style="height: 70px;margin:0 0 0 5px;">
                                @endif
                                </td> 
                                <td style="font-size: 12px; text-align: left; height: 25px;width:50px"><span style="margin-left: 2px">FIRMA:</span></td> 
                                <td style="font-size: 12px; border-right: 1px solid #000;" rowspan="2"></td>
                                <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">FIRMA:</span></td>
                                <td style="font-size: 12px; border-right: 1px solid #000;" rowspan="2"></td>                              
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>   
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
            @foreach ($juntas_posiciones as $junta_posicion)
                <tr>
                    <td style="font-size: 11px;  width:66px;text-align: center" class="bordered-td">{{ $junta_posicion->junta }}</td>
                    <td style="font-size: 11px;  width:65px;text-align: center" class="bordered-td">{{$junta_posicion->soldadorz}} / {{$junta_posicion->soldadorp}} </td>
                    <td style="font-size: 11px;  width:64.5px;text-align: center" class="bordered-td">{{$junta_posicion->posicion}}</td>
                    <td style="font-size: 11px;  width:201.5px; " class="bordered-td">&nbsp;
                        @foreach ($defectos_posiciones as $key => $defecto_posicion)                                

                            
                            @if ($defecto_posicion->posicion_id == $junta_posicion->posicion_id)


                                {{$defecto_posicion->codigo}} /&nbsp;


                            @endif
                            
                        @endforeach
                    
                    </td>

                    <td style="font-size: 11px; text-align: center;width:39px; " class="bordered-td">
                        @if ($junta_posicion->aceptable_sn)
                            X
                        @endif
                    </td>

                    <td style="font-size: 11px; text-align: center;width:38px;" class="bordered-td">
                        @if (!$junta_posicion->aceptable_sn)
                            X
                        @endif
                    </td>

                    <td style="font-size: 11px;" class="bordered-td">&nbsp;{{$junta_posicion->observacion}}</td>
                </tr>

                
            @endforeach

            {{ $cantFilasTotal = count($juntas_posiciones) }}
            {{ $filasPage = 37 }}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}

            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    <td style="font-size: 11px;  width:66px;text-align: center" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px;  width:65px;text-align: center" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px;  width:64.5px;text-align: center" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px;  width:201.5px; " class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px; text-align: center;width:39px; " class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px; text-align: center;width:39px; " class="bordered-td">&nbsp;</td>
                    <td style="font-size: 11px;" class="bordered-td">&nbsp;</td>
                </tr>
            @endfor
         
                
            
                                        
        </tbody>
    </table>
</main>   
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 480;
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

</script>


</body>
</html>