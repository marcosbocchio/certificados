<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{FormatearNumeroInforme($informe->numero,'RI')}}</title>
</head>

<style>  

@page {    
        margin: 358px 15px 195px 15px !important;
        padding: 0px 0px 0px 0px !important;
       }

.EspecialCaracter {
    font-family: DejaVu Sans;
}

body {
    margin: 0px 1px 0px 1px;
    padding: 0 0 0 0;
}

header {
    position:fixed;
    top: -319px;    
}

footer {
    position: fixed; bottom:7px; 
    padding-top: 0px;

}

main {
      margin-top: -2px;
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

 <body class="bordered" style="border-top: none;border-bottom: none;">  

<header>
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
            <tr>
                <td>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="text-align: right; width:253px">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 18px; height: 30px; text-align: center;width:534px;" rowspan="3"><b>RADIOGRAFÍA INDUSTRIAL</b></td>
                                <td style="font-size: 11px;"><b style="margin-left: 40px"></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 120px" >INFORME N°: </b>{{$informe->km}}-{{$ot_tipo_soldadura->TipoSoldadura->codigo}}-{{FormatearNumeroInforme($informe->numero,'RI')}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 120px">FECHA: </b>{{ date('d-m-Y', strtotime($informe->fecha)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 120px"></b></td>                     
                                <td style="font-size: 11px;"><b style="margin-left: 120px"></td>            
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
                                    
                                    <td style="font-size: 10px;height: 45px;width: 235px"><span style="margin-top: -20px;"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}</span></td> 
                                    <td  style="width: 140px">
                                        <span>
                                            @if($ot->logo_cliente_sn && $cliente->path)
                                                <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 43px;max-width: 130px;margin-top: 5px;">
                                            @else
                                                <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 43px;margin-top: 5px;">
                                            @endif
                                        </span>
                                    </td>                                     
                                
                                    <td style="font-size: 10px;width: 235px">
                                        @if($contratista)
                                            <b>COMITENTE: </b>{{$contratista->nombre}}
                                        @endif                         
                                        
                                    </td>  
                                    <td style="width: 180px">
                                        @if($ot->logo_contratista_sn && $contratista->path_logo)
                                            <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height: 43px;max-width: 130px;margin-top: 5px;">
                                        @else
                                            <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 43px;margin-top: 5px;">
                                        @endif
                                    </td>              

                                    <td style="font-size: 10px;">&nbsp;</td>   
                                    @if($informe->obra)

                                         <td style="font-size: 10px;"><b>OBRA: </b>{{$informe->obra}}</td>

                                    @endif
                                    <td style="font-size: 10px;"><b>OT N°: </b>{{$ot->numero}}</td>  
                                </tr>  
                                <tr>
                                   <td style="font-size: 10px;" colspan="6"><b>PROYECTO: </b>{{$ot->proyecto}}</td>
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
                            <td style="font-size: 11px; width: 280px;border-right: 1px solid #000;" colspan="2"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 11px; width: 280px;border-right: 1px solid #000;" colspan="2" ><b>Equipo: </b>{{$interno_equipo->equipo->codigo}}</td>
                            <td style="font-size: 11px; width: 140px;" colspan="2" ><b>Ici : </b>{{$ici->codigo}}</td>    
                            <td style="font-size: 11px; width: 140px;border-right: 1px solid #000;" ><b>Lado: </b>{{$informe_ri->lado}}</td> 
                            <td style="font-size: 11px;"><b>Tecnica: </b>{{$tecnica->codigo}}</td>                                          
                        </tr>
                        <tr>                      
                            <td style="font-size: 11px; width: 140px;"><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 11px; width: 140px;border-right: 1px solid #000;"  ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 11px; width: 140px;"><b>Kv: </b>
                                @if ($informe_ri->kv)
                                   {{ $informe_ri->kv }}
                                @else
                                   {{$interno_equipo->voltaje}}
                                @endif
                            </td>
                            <td style="font-size: 11px; width: 140px;border-right: 1px solid #000;" ><b>mA: </b>
                                @if ($informe_ri->ma)
                                   {{ $informe_ri->ma }}
                                @else
                                   {{$interno_equipo->amperaje}}</td>
                                @endif
                            <td style="font-size: 11px; width: 85px"><b>Pantalla: </b>Pb</td>
                            <td style="font-size: 11px; width: 40px"><b>Ant: </b>{{$informe_ri->pos_ant}}</td>
                            <td style="font-size: 11px; width: 40px;border-right: 1px solid #000;"  ><b>Pos: </b>{{$informe_ri->pos_pos}}</td>
                            <td style="text-align: center;" rowspan="5" >
                                    <img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height: 80px; ">                                   
                            </td>                                                                   
                        </tr>
                        <tr>                            
                            <td style="font-size: 11px;width: 140px;"><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>   
                            <td style="font-size: 11px;width: 140px;border-right: 1px solid #000; "  ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                    {{ $informe->espesor_chapa }}
                                @elseif($informe->espesor_especifico)
                                    {{ $informe->espesor_especifico }}
                                @else
                                     {{ $diametro_espesor->espesor }}
                                @endif                        
                            
                            </td>                 
                            <td style="font-size: 11px;width: 180px;"><b>Fuente: </b>     

                              @if ($interno_fuente)

                                {{$interno_fuente->fuente->codigo}} 
                                
                              @endif                          
                            
                            </td>
                            <td style="font-size: 11px;width: 100px;border-right: 1px solid #000;" ><b>Act: </b>{{$actividad}}</td>
                            <td style="font-size: 11px; border-right: 1px solid #000;"  colspan="3"><b>Proc. RI: </b>{{$procedimiento_inf->titulo}} </td>       
                        </tr>
                        <tr>
                            <td style="font-size: 11px;width: 280px; border-right: 1px solid #000;" colspan="2"><b style="font-size: 11px;">Norma Evaluación: </b>{{$norma_evaluacion->codigo}}</td>  
                            <td style="font-size: 11px;"><b>Foco: </b>                  
                                @if ($interno_fuente)
                                    {{$interno_fuente->foco}}
                                @else
                                    {{$interno_equipo->foco}}    
                                @endif
                            </td>
                            <td style="font-size: 11px; border-right: 1px solid #000;"><b>N° Exp. : </b>{{$informe_ri->exposicion}}</td>
                            <td style="font-size: 11px;width: 280px; border-right: 1px solid #000;"  colspan="3" ><b>EPS: </b>{{$ot_tipo_soldadura->eps}}</td>                        
               
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000; " colspan="2"><b>Norma Ensayo: </b>{{$norma_ensayo->codigo}}</td>
                            <td style="font-size: 11px;"><b>Pelicula : </b>{{$tipo_pelicula->fabricante}}</td>   
                            <td style="font-size: 11px;border-right: 1px solid #000;"><b>Tipo: </b>{{$tipo_pelicula->codigo}}</td>    
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="3"><b>PQR: </b>{{$ot_tipo_soldadura->pqr}}</td>                    
                        </tr>
                        <tr>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="2" ><b>Ejec. Ensayo: </b>{{$ejecutor_ensayo->name}}</td>           
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="2"><b>Dis.Fuente/pelicula: </b>{{$informe_ri->distancia_fuente_pelicula}}</td>
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="3"></td>                    
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
                                <td style="font-size: 11px; text-align: center " colspan="3" class="bordered-td" >Junta</td>
                                <td style="font-size: 11px; text-align: center " colspan="13" class="bordered-td" >Cuño</td>
                                <td style="font-size: 11px; text-align: center " colspan="2" rowspan="2" class="bordered-td" >Placa</td>
                                <td style="font-size: 11px; text-align: center " rowspan="2" colspan="2" class="bordered-td" >Indicaciones</td>
                                <td style="font-size: 11px; text-align: center " rowspan="2" colspan="2" class="bordered-td" >Resultados</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px; width:29px;  text-align: center " rowspan="2" class="bordered-td" >Pk</td>
                                <td style="font-size: 11px; width:39px;  text-align: center " rowspan="2" class="bordered-td" >Elem.</td>
                                <td style="font-size: 11px; width:39px;  text-align: center;" rowspan="2" class="bordered-td">Tipo</td>
                                <td style="font-size: 11px; width:84px;  text-align: center;" colspan="3" class="bordered-td">1° Pasada</td>
                                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">2° Pasada</td>
                                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">3° Pasada</td>
                                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">4° Pasada</td>
                                <td style="font-size: 11px; width:58px;  text-align: center;" colspan="2" class="bordered-td">5° Pasada</td>
                                <td style="font-size: 11px; width:60px;  text-align: center;" colspan="2" class="bordered-td">6° Pasada</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">L</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>   
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>  
                                <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>    
                                <td style="font-size: 11px; width:49px; text-align: center;" class="bordered-td">Posición</td> 
                                <td style="font-size: 11px; width:16px; text-align: center;" class="bordered-td"><span class="EspecialCaracter">ρ</span></td>
                                <td style="font-size: 11px; width:60px; text-align: center;" class="bordered-td">Tipo</td>  
                                <td style="font-size: 11px; width:135px; text-align: center"  class="bordered-td">Posición</td>                     
                                <td style="font-size: 11px; width:25px; text-align: center;" class="bordered-td">AP</td>
                                <td style="font-size: 11px; width:25px; text-align: center;" class="bordered-td">RZ</td>
                            
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
                                <td style="font-size: 11px; " class="bordered-td"><b>MEL: </b>Escoria Lineal</td>
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
                                 <td style="font-size: 11px; "  class="bordered-td"><b>R: </b>Raiz</td>                          
                                 <td style="font-size: 11px; "  class="bordered-td"><b>Y: </b>Relleno</td>
                                 <td style="font-size: 11px; "  class="bordered-td"><b>S: </b>Sobremonta</td>
                                 <td style="font-size: 11px; "  class="bordered-td"><b>AP: </b>Aprobado</td>                          
                                 <td style="font-size: 11px; " colspan="2" class="bordered-td"><b>RZ: </b>Rechazado</td>
                            </tr>
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
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>CLIENTE </b></td> 
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td"><b>COMITENTE </b></td>                               
                            </tr>
                            <tr>                               
                                <td style="font-size: 11px; text-align: left; height: 25px;width:100px;"><span style="margin-left: 2px">FIRMA:</span></td>  
                                <td style="font-size: 11px; border-right: 1px solid #000;" rowspan="2">
                                @if($evaluador && $evaluador->path)
                                     <img src="{{ public_path($evaluador->path)}}" alt="" style="height: 70px;width: 140px; margin-left:40px ">
                                @endif
                                </td> 
                                <td style="font-size: 11px; text-align: left; height: 25px;width:100px;"><span style="margin-left: 2px">FIRMA:</span></td> 
                                <td style="font-size: 11px; border-right: 1px solid #000;" rowspan="2"></td> 
                                <td style="font-size: 11px; text-align: left; height: 25px;width:100px;"><span style="margin-left: 2px">FIRMA:</span></td>    
                                <td style="font-size: 11px; border-right: 1px solid #000;" rowspan="2"></td>                           
                            </tr>
                            <tr>                               
                                <td style="font-size: 11px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>   
                                <td style="font-size: 11px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>
                                <td style="font-size: 11px; text-align: left; height: 25px;"><span style="margin-left: 2px">ACLARACIÓN:</span></td>                      
                            </tr>
                        </tbody>
                    </table> 
                </td>
            </tr>      
        </tbody>
    </table>
</footer>


<main>
    
    <table width="100%" class="bordered" style="padding: 0 -3px 0 -3px;" >
        <tbody>
            @foreach ($juntas_posiciones as $junta_posiciones)
                <tr>
                    <td style="font-size: 11px;  width:38.5px;text-align: center" class="bordered-td">
                    @if ($informe->km)

                       {{ $informe->km}}
                       
                    @else

                        &nbsp;   
                        
                    @endif
                    
                    </td>
                    <td style="font-size: 11px;  width:51px;text-align: center" class="bordered-td">{{$junta_posiciones->junta}} </td>
                    <td style="font-size: 11px;  width:51px;text-align: center" class="bordered-td">{{$ot_tipo_soldadura->TipoSoldadura->codigo}}</td>
                 
                        {{ $x = 0  }}

                        <!--   Pasada 1 -->
                        @foreach ($pasadas_juntas as $key => $pasadas_junta)                                

                            
                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 1 ))

                                 <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>                           
                                  {{  $x = 1 }}

                            @endif

                           @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 1 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorl}} </td>                           


                            @endif

                           @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 1 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>                           


                            @endif
                            
                        @endforeach  

                        @if ($x == 0)

                             <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                            
                        @endif   
                    
                         <!--   Pasada 2 -->

                         {{ $x = 0  }}

                         @foreach ($pasadas_juntas as $key => $pasadas_junta)                    

                             
                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 2 ))

                               {{  $x = 1 }}

                                 <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>                           


                            @endif
                     

                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 2 ))


                                 <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>                           


                            @endif
                            
                        @endforeach

                           @if ($x == 0)
                             <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">&nbsp;</td>                            
                          @endif   

                        <!--   Pasada 3 -->

                         {{ $x =0  }}

                         @foreach ($pasadas_juntas as $key => $pasadas_junta)                      

                            
                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 3 ))

                                 {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>                           


                            @endif                       

                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 3 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>                           


                            @endif
                            
                        @endforeach

                         @if ($x == 0)
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                             <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>                            
                          @endif 

                        <!--   Pasada 4 -->

                         {{ $x =0  }}

                        @foreach ($pasadas_juntas as $key => $pasadas_junta)                       

                            
                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 4 ))

                                {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>                           


                            @endif


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 4 ))


                                 <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>                           


                            @endif
                            
                        @endforeach

                        @if ($x == 0)
                            <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                            <td style="font-size: 11px;  width:36.8px; text-align:center;" class="bordered-td">&nbsp;</td>                            
                        @endif 

                        <!--   Pasada 5 -->

                        {{ $x =0  }}

                        @foreach ($pasadas_juntas as $key => $pasadas_junta)                      

                            
                           @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 5 ))

                                 {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>                           


                            @endif


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 5 ))


                                 <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>                           


                            @endif
                            
                        @endforeach

                        @if ($x == 0)
                            <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>
                            <td style="font-size: 11px;  width:36.7px; text-align:center;" class="bordered-td">&nbsp;</td>                            
                        @endif 

                        <!--   Pasada 6 -->

                        {{ $x =0  }}

                         @foreach ($pasadas_juntas as $key => $pasadas_junta)                       

                            
                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 6 ))

                                 {{  $x = 1 }}
                                 <td style="font-size: 11px;  width:37px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorz}} </td>                           


                            @endif


                            @if (($pasadas_junta->junta_id == $junta_posiciones->id) && ($pasadas_junta->numero == 6 ))


                                 <td style="font-size: 11px;  width:37px; text-align:center;" class="bordered-td">{{$pasadas_junta->soldadorp}} </td>                           


                            @endif
                            
                        @endforeach

                        @if ($x == 0)
                            <td style="font-size: 11px;  width:37.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                            <td style="font-size: 11px;  width:37.5px; text-align:center;" class="bordered-td">&nbsp;</td>                            
                        @endif 

                    <td style="font-size: 11px;  width:63.5px;text-align: center" class="bordered-td">{{$junta_posiciones->codigo}}</td>

                    <!-- Defectos Posición -->

                    <!-- Densidad  -->

                    <td style="font-size: 11px;width:21.5px; text-align: center" class="bordered-td">{{$junta_posiciones->densidad}}</td>

                    <!-- Tipo -->

                    <td style="font-size: 9px;width:77.7px;  text-align: center" class="bordered-td">
                      @php $primero = true; @endphp
                        @foreach ( $defectos_posiciones as  $defectos_posicion)
                            @if ($defectos_posicion->posicion_id == $junta_posiciones->posicion_id)

                                @if (!$primero)
                                    /
                                @endif

                                {{ $defectos_posicion->codigo }}   
                                {{ $primero = false}}                  

                            @endif

                        @endforeach

                    </td>

                    <!-- Posicion -->

                    <td style="font-size: 9px;width:174px; text-align: center" class="bordered-td">
                        @php $primero = true; @endphp
                        @foreach ( $defectos_posiciones as  $defectos_posicion)
                            @if ($defectos_posicion->posicion_id == $junta_posiciones->posicion_id)

                                @if (!$primero)
                                    /
                                @endif
                                
                                @if ($defectos_posicion->pasada)
                                    @if ($defectos_posicion->pasada == 'RAIZ')
                                        @php
                                            $sector = 'R'; 
                                        @endphp
                                    @elseif ($defectos_posicion->pasada == 'RELLENO')
                                        @php
                                            $sector = 'Y'; 
                                        @endphp
                                    @elseif ($defectos_posicion->pasada == 'SOBREMONTA')
                                        @php
                                            $sector = 'S'; 
                                        @endphp
                                    @endif                               

                                @php
                                    $valor_imprimir = $defectos_posicion->codigo . '(' . $defectos_posicion->posicion . ')' . $sector ;
                                @endphp

                                    {{ $valor_imprimir}}
                                    {{ $primero = false}}     
                                    
                                @endif
                            @endif
                        @endforeach

                    </td>

                    <!-- Resultado-->   
                    <td style="font-size: 11px;width:32.7px; text-align: center; " class="bordered-td">
                        @if ($junta_posiciones->aceptable_sn == 1)
                            X
                        @endif
                    </td>

                    <td style="font-size: 11px; text-align: center;" class="bordered-td">
                        @if ($junta_posiciones->aceptable_sn == 0)
                            X
                        @endif
                    </td>
                </tr>
                
            @endforeach    
  <!--
            {{ $cantFilasTotal = count($juntas_posiciones) }}
            {{ $filasPage = 14 }}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}  

             @for ( $x=0 ;  $x < $filasACompletar ; $x++)
            <tr>
                <td style="font-size: 11px;  width:38px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:50px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:50px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:36.5px; text-align:center;" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;  width:64px;text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;width:75px;  text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;width:93.5px; text-align: center" class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px;width:76px; text-align: center" class="bordered-td">        
                <td style="font-size: 11px;width:32.2px; text-align: center; " class="bordered-td">&nbsp;</td>
                <td style="font-size: 11px; text-align: center;" class="bordered-td">&nbsp;</td>
               
            </tr>
            @endfor
    -->                                
        </tbody>
    </table> 
</main>  

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 702;
        $y = 77;
        $text = "PÁGINA: {PAGE_NUM} de {PAGE_COUNT}";
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

