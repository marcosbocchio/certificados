<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe {{FormatearNumeroInforme($informe->numero,'US')}}</title>
</head>

<style>

@page { margin: 365px 30px 192px 60px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -326px;    
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
.vcenter {
    display: table-cell;
    vertical-align: middle;
}

b {

    margin-left: 2px;
}

#rotate
{
  height:125px;
}

#vertical
{
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    margin-left: -50px;
    margin-right: -50px;
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
                                <td style="font-size: 19px; height: 30px;width: 200px; text-align: center;margin-left: 0px" rowspan="3"><b>INFORME DE ULTRASONIDO</b></td>
                                <td style="font-size: 11px;"><b ></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 131px;">INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'RI')}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 131px;">FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>
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
                            <td style="font-size: 11px;border-left: 1px solid #000;" colspan="2" ><b>EPS: </b>{{$informe->eps}}</td>
                           
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 11px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Encoder:{{$informe_us->encoder}} </b></td>
                            <td style="font-size: 11px;border-left: 1px solid #000;" colspan="2"><b>PQR: </b>{{$informe->pqr}}</td>
           
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2" ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="4"  ><b>Estado Superficie: </b>{{$estado_superficie->codigo}}</td>                            
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 11px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td> 
                        
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
                            <td style="font-size: 11px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>     

                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2"><b>Proc. Sold. : </b>{{$informe->procedimiento_soldadura}}</td>                            
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="4" ><b>Proc. US: </b>{{$procedimiento_inf->titulo}} </td>
                            <td style="font-size: 11px;  " colspan="2" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>  
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
                                
                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">ZAPATA</div></td>
                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">PALPADOR</div></td>
                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">FRECUENCIA</div></td>
                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">ANGULO APERTURA</div></td>

                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">JUNTA</div></td>

                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">JUNTA</div></td>

                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">Elemento</div></td>

                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">JUNTA</div></td>

                                <td style="font-size: 11px; height:20px;border-right: 1px solid #000;" id="rotate"> <div id="vertical">JUNTA</div></td>

                                <td id="rotate" class="bordered"><div id="vertical"></div></td>
                                
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
                                <td style="font-size: 10px; " class="bordered-td"><b>F: </b>Fisura</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>FF: </b>Falta de fusion</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>FP: </b>Falta de Penetración</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>FPD: </b>FP por Desalineación</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>FFP: </b>FF por Pasadas</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>HL: </b>Desalineación</td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px; " class="bordered-td"><b>PE: </b>Penetración Excesiva</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>Q: </b>Quemaduras</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>CI: </b>Concavidad Interna</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>CE: </b>Concavidad Externa</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>SI: </b>Socavado Interior</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>SE: </b>Socavado Exterior</td>                                
                            </tr>
                            <tr>
                                <td style="font-size: 10px; " class="bordered-td"><b>ME: </b>Escoria Aislada</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>MEL: </b>Socavado Lineal</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>P: </b>Poros</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>NP: </b>Nido de Poros</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>PV: </b>Poro Vermicular</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>CH: </b>Cordón Hueco</td>                                
                            </tr>
                            <tr>
                                <td style="font-size: 10px; " class="bordered-td"><b>IT: </b>Inclusión de Tungteno</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>SA: </b>Salto de Arco</td>
                                <td style="font-size: 10px; " colspan="2" class="bordered-td"><b>AD: </b>Acumulación de Discontinuidades</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>DP: </b>Defecto de Placa</td>
                                <td style="font-size: 10px; " class="bordered-td"><b>RP: </b>Repetir Placa</td>
                            </tr>
                            <tr>
                                 <td style="font-size: 10px; " colspan="3" class="bordered-td"><b>AP: </b>Aprobado</td>                          
                                 <td style="font-size: 10px; " colspan="3" class="bordered-td"><b>RZ: </b>Rechazado</td>
                            </tr>
                            <tr>                                
                                <td style="font-size: 10px;" colspan="6" class="bordered-td"><b>Observaciones: </b>{{$informe->observaciones}}</td>                                  
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
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 484;
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