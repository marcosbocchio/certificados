<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <title>Informe RI</title>
</head>

<style>

@page { margin: 360px 25px; }

header {
    position:fixed;
    top: -292px; 
   
    }

.contenido {
    margin-bottom: -135px;
}
footer {
    position: fixed; bottom: -129px; 

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
                                <td style="font-size: 12px;" ><b style="margin-left: 120px" >INFORME N°: </b>{{$informe->numero}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 120px">FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 120px"></b></td>                     
                                <td style="font-size: 12px;"><b style="margin-left: 120px">PÁGINA </b> <span class="pagenum"></span></div> <b> de </b>1</td>            
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
                <td >
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>                 
                        <tr>
                            <td style="font-size: 12px; width: 219px;border-right: 1px solid #000;"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 12px; " colspan="2" ><b>Equipo: </b>{{$equipo->codigo}}</td>
                            <td style="font-size: 12px;" ><b>Kv: </b>{{$informe->kv}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" ><b>mA: </b>{{$informe->ma}}</td>
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 12px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td>                            
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 12px; width: 218px;border-right: 1px solid #000;"  ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 12px;  width: 260px; border-right: 1px solid #000;" colspan="4"  ><b>Fuente: </b>     

                            @if ($fuente)

                                {{$fuente->codigo}} 
                                
                            @endif
                            
                            
                            </td>
                            <td style="font-size: 12px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 12px; width: 218px;border-right: 1px solid #000;"  ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4"  ><b>Foco: </b>{{$informe_ri->foco}}</td>   
                            
                            <td style="font-size: 12px;  "  ><b>Actividad: </b>{{$informe_ri->pos_pos}}</td>
                            <td style="font-size: 12px;"  ><b>N° Exp. : </b>{{$informe_ri->exposicion}}</td>
                            
                        </tr>
                        <tr>
                            <td style="font-size: 12px;  width: 218px;border-right: 1px solid #000;"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 12px; border-right: 1px solid #000; " colspan="4"  ><b>Pelicula : </b>{{$tipo_pelicula->fabricante}}</td>    
                            <td style="font-size: 12px;  " colspan="2" ><b>Dis.Fuente/pelicula: </b>{{$informe_ri->distancia_fuente_pelicula}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px; width: 218px;border-right: 1px solid #000; "  ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                {{ $informe->espesor_chapa }}
                                @else
                                {{  $diametro_espesor->espesor }}
                                @endif                       
                            
                            </td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4"  ><b>Tipo: </b>{{$tipo_pelicula->codigo}}</td>    
                            <td style="font-size: 12px;  " colspan="2" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>                
                        
                        </tr>
                        <tr>                           
                            <td style="font-size: 12px;  width: 218px;border-right: 1px solid #000;" ><b>Proc. Sold. : </b>{{$informe_ri->procedimiento_soldadura}}</td>
                            
                            <td style="font-size: 12px; width: 75px"   ><b>Pantalla: </b>Pb</td>
                            <td style="font-size: 12px; width: 15px"  ><b>Ant: </b>{{$informe_ri->pos_ant}}</td>
                            <td style="font-size: 12px; width: 15px"  ><b>Pos: </b>{{$informe_ri->pos_pos}}</td>
                            <td style="font-size: 12px; width: 1px; border-right: 1px solid #000;"  ><b>Lado: </b>{{$informe_ri->lado}}</td>
                            
                            <td style="font-size: 12px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->codigo}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;  width: 218px;border-right: 1px solid #000;" ><b>Eps: </b>{{$informe_ri->eps}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000; " colspan="4" ><b>Proc. RI: </b>{{$procedimiento_inf->descripcion}} </td>                        
                            <td style="text-align: center; " colspan="2" rowspan="2" >
                                    <img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height: 40px; margin-right: 25px;">              
                                    
                            </td>  
                        </tr>
                        <tr>                           
                            <td style="font-size: 12px;  width: 218px;border-right: 1px solid #000;" ><b>Pqr: </b>{{$informe_ri->pqr}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000;  " colspan="4" ><b>Ici : </b>{{$ici->codigo}}</td> 

                        </tr>                
                        </tbody>
                    </table>   
                </td>
            </tr>
            <tr >
                <td class="bordered" >
                    <table  width="100%" style="text-align: center;border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="font-size: 12px; width:70px;  text-align: center " rowspan="2" class="bordered-td" >JUNTA</td>
                                <td style="font-size: 12px; width:70px;  text-align: center;" rowspan="2" class="bordered-td">CUNIO</td>
                                <td style="font-size: 12px; width:71px; text-align: center;" rowspan="2" class="bordered-td">POSICIÓN</td>
                                <td style="font-size: 12px; width:190px;  text-align: center;" rowspan="2" class="bordered-td">DEFECTOS</td>  
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
                                <td style="font-size: 12px;" colspan="6" class="bordered-td"><b>Observaciones: </b>{{$informe->Observaciones}}</td>                                  
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
                               <td style="font-size: 13px; text-align: center" class="bordered-td" ><b>EVALUADOR </b></td>   
                               <td style="font-size: 13px; text-align: center" class="bordered-td" ><b>CONTRATISTA </b></td> 
                               <td style="font-size: 13px; text-align: center" class="bordered-td"><b>CLIENTE </b></td>                               
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td>   
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td> 
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">FIRMA:</span></td>                              
                            </tr>
                            <tr>                               
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>   
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>
                                <td style="font-size: 12px; text-align: left; height: 25px;border-right: 1px solid #000;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>  
                     
                            </tr>
                        </tbody>
                    </table> 
                </td>
            </tr>      
        </tbody>
    </table>
</footer>
<div class="contenido">
    
    <table width="100%" class="bordered" >
        <tbody>
            @foreach ($juntas_posiciones as $junta_posicion)
                <tr>
                    <td style="font-size: 11px;  width:72px;text-align: center" class="bordered-td">{{ $junta_posicion->junta }}</td>
                    <td style="font-size: 11px;  width:71px;text-align: center" class="bordered-td">{{$junta_posicion->soldadorz}} / {{$junta_posicion->soldadorl}} </td>
                    <td style="font-size: 11px;  width:71px;text-align: center" class="bordered-td">{{$junta_posicion->posicion}}</td>
                    <td style="font-size: 11px;  width:190px; " class="bordered-td">&nbsp;
                        @foreach ($defectos_posiciones as $key => $defecto_posicion)                                

                            
                            @if ($defecto_posicion->pasada_posicion_id == $junta_posicion->pasada_posicion_id)


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
                                        
        </tbody>
    </table>
</div>   
     


<!--
    <div class="contenido">
        @for ($x = 0 ; $x <30 ; $x++)
            <p>El valor es {{ $x }}</p>
        @endfor
    </div>
-->
</body>
</html>