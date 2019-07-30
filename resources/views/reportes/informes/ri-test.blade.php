<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <title>Informe RI</title>
</head>

<style>
.bordered {
    border-color: #000000;
    border-style: solid;
    border-width: 2px; 
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
                            <td style="font-size: 12px;"><b style="margin-left: 120px">PÁGINA </b> 1 <b> de </b>1</td>            
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
                        <td style="font-size: 12px; width: 218px;  " class="bordered-td"><b>Componente: </b>{{$informe->componente}}</td>
                        <td style="font-size: 12px; " class="bordered-td" colspan="2" ><b>Equipo: </b>{{$equipo->codigo}}</td>
                        <td style="font-size: 12px; " class="bordered-td" ><b>Kv: </b>{{$informe->kv}}</td>
                        <td style="font-size: 12px; " class="bordered-td" ><b>mA: </b>{{$informe->ma}}</td>
                        <td style="font-size: 11px;  " colspan="2" class="bordered-td" ><b style="font-size: 12px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td>                            
                    </tr>
                    <tr>                
                        
                        <td style="font-size: 12px; width: 218px" class="bordered-td" ><b>Material: </b>{{$material->codigo}}</td>
                        <td style="font-size: 12px;  width: 260px;" colspan="4" class="bordered-td" ><b>Fuente: </b>     

                        @if ($fuente)

                             {{$fuente->codigo}} 
                            
                        @endif
                        
                        
                        </td>
                        <td style="font-size: 12px; " colspan="2" class="bordered-td" ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>                
                    </tr>
                    <tr>
                        <td style="font-size: 12px; width: 218px" class="bordered-td" ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                        <td style="font-size: 12px; " colspan="4" class="bordered-td" ><b>Foco: </b>{{$informe_ri->foco}}</td>   
                        
                        <td style="font-size: 12px;  " class="bordered-td" ><b>Actividad: </b>{{$informe_ri->pos_pos}}</td>
                        <td style="font-size: 12px;" class="bordered-td" ><b>N° Exp. : </b>{{$informe_ri->exposicion}}</td>
                        
                    </tr>
                    <tr>
                        <td style="font-size: 12px;  width: 218px" class="bordered-td" ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                        <td style="font-size: 12px;  " colspan="4" class="bordered-td" ><b>Pelicula : </b>{{$tipo_pelicula->fabricante}}</td>    
                        <td style="font-size: 12px;  " colspan="2"class="bordered-td" ><b>Dis.Fuente/pelicula: </b>{{$informe_ri->distancia_fuente_pelicula}}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px; width: 218px " class="bordered-td" ><b>Espesor: </b>

                            @if ($informe->espesor_chapa)
                               {{ $informe->espesor_chapa }}
                            @else
                              {{  $diametro_espesor->espesor }}
                            @endif                       
                        
                        </td>
                        <td style="font-size: 12px; " colspan="4" class="bordered-td" ><b>Tipo: </b>{{$tipo_pelicula->codigo}}</td>    
                        <td style="font-size: 12px;  " colspan="2" class="bordered-td"><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>                
                      
                    </tr>
                    <tr>                           
                        <td style="font-size: 12px;  width: 218px" class="bordered-td"><b>Proc. Sold. : </b>{{$informe_ri->procedimiento_soldadura}}</td>
                        
                        <td style="font-size: 12px; width: 75px"  class="bordered-td" ><b>Pantalla: </b>Pb</td>
                        <td style="font-size: 12px; width: 15px" class="bordered-td" ><b>Ant: </b>{{$informe_ri->pos_ant}}</td>
                        <td style="font-size: 12px; width: 15px" class="bordered-td" ><b>Pos: </b>{{$informe_ri->pos_pos}}</td>
                        <td style="font-size: 12px; width: 1px" class="bordered-td" ><b>Lado: </b>{{$informe_ri->lado}}</td>
                        
                        <td style="font-size: 12px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->codigo}}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px;  width: 218px" class="bordered-td"><b>Eps: </b>{{$informe_ri->eps}}</td>
                        <td style="font-size: 12px; " colspan="4"class="bordered-td" ><b>Proc. RI: </b>{{$procedimiento_inf->descripcion}} </td>                        
                        <td style="text-align: center; " colspan="2" rowspan="2" >
                                <img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height: 40px; margin-right: 25px;">              
                                
                        </td>  
                    </tr>
                    <tr>                           
                        <td style="font-size: 12px;  width: 218px" class="bordered-td"><b>Pqr: </b>{{$informe_ri->pqr}}</td>
                        <td style="font-size: 12px;  " colspan="4" class="bordered-td" ><b>Ici : </b>{{$ici->codigo}}</td> 

                    </tr>                
                    </tbody>
                </table>   
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>