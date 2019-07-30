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

</style>

<body>
    
<table style="text-align: center" width="100%">
    <tbody>
        <tr>
          <td>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td rowspan="3" style="text-align: right; width:233px" class="bordered">
                                <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                            </td>   
                            <td style="font-size: 18px; height: 30px; text-align: center;width:233px" rowspan="3" class="bordered"><b>INFORME RADIOGRAFÍA INDUSTRIAL</b></td>
                            <td style="font-size: 13px;" ><b>INFORME N°: </b>{{$informe->numero}}</td>                      
                        </tr>

                        <tr>
                            <td style="font-size: 13px;"><b>FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>
                        </tr>

                        <tr>
                            <td style="font-size: 13px;"><b>PÁGINA </b> 1 <b> de </b>1</td>            
                        </tr>   
                    <!--                       
                        <tr>
                            <td style="font-size: 13px;"><b>PROYECTO:</b>{{$ot->proyecto}}</td>
                            <td style="font-size: 13px;"><b>OBRA: </b>{{$ot->obra}}</td>
                        </tr>                  
                        <tr>
                            <td style="font-size: 13px;" colspan="2"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}</td>
                            <td style="font-size: 13px;"><b>OT N°: </b>{{$ot->numero}}</td>
                        </tr>
                    -->    
                    </tbody>
                </table>          
            </td>
        </tr>
        <tr>
                <td class="bordered">
                  <table>
                      <tbody>                 
                        <tr>
                          <td style="font-size: 13px; width:300px" ><b>Proc. Soldadura: </b>{{$informe_ri->procedimiento_soldadura}}</td>
                          <td style="font-size: 13px;  width:200px" ><b>Eps: </b>{{$informe_ri->eps}}</td>
                          <td style="font-size: 13px;  width:200px" ><b>Pqr: </b>{{$informe_ri->pqr}}</td>
                        </tr>
                        <tr>                
                           
                            <td style="font-size: 13px;  width:300px" ><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 13px; width:200px" ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 13px; width:200px" ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px;  width:300px" ><b>Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td>                            
                            <td style="font-size: 13px; width:200px" colspan="2" ><b>Proc. RI: </b>{{$procedimiento_inf->descripcion}} </td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; width:200px" ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>                
                            <td style="font-size: 13px; width:200px" ><b>Equipo: </b>{{$equipo->codigo}}</td>
                            <td style="font-size: 13px; width:200px" ><b>Fuente: </b>{{$fuente->codigo}} </td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; width:300px" ><b>Fabricante: </b>{{$fuente->fabricante}}</td>
                            <td style="font-size: 13px;  width:200px" ><b>Pelicula : </b>{{$tipo_pelicula->fabricante}}</td>    
                            <td style="font-size: 13px;  width:200px" ><b>Tipo: </b>{{$tipo_pelicula->codigo}}</td>    
                         </tr>
                         <tr>                           
                            <td style="font-size: 13px;  width:300px" ><b>Pantalla: </b>Pb</td>
                            <td style="font-size: 13px;  width:200px" ><b>Lado: </b>{{$informe_ri->lado}}</td>
                            <td style="font-size: 13px;  width:200px" ><b>Ant: </b>{{$informe_ri->pos_ant}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; width:300px" ><b>Pos: </b>{{$informe_ri->pos_pos}}</td>
                            <td style="font-size: 13px;  width:200px" ><b>Ici : </b>{{$ici->codigo}}</td>    
                            <td style="font-size: 13px;  width:200px" ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                        </tr>
                        <tr>                           
                            <td style="font-size: 13px;  width:300px" ><b>Espesor: </b>{{$diametro_espesor->espesor}}</td>
                            <td style="font-size: 13px;  width:200px" ><b>Tecnica: </b>{{$tecnica->codigo}}</td>
                            <td style="font-size: 13px;  width:200px" ><b>Dis.Fuente/pelicula: </b>{{$informe_ri->distancia_fuente_pelicula}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; width:300px" ><b>Actividad: </b>{{$informe_ri->pos_pos}}</td>
                            <td style="text-align: center; width:200px" >
                                    <img src="{{ public_path('img/tecnicas/Captura1.JPG')}}" alt="" style="height: 40px; margin-right: 25px;">                           
                                   
                            </td>  
                            <td style="font-size: 13px;  width:200px" ><b>Foco: </b>{{$informe_ri->foco}}</td>    
                        </tr>
                        <tr>
                            <td style="font-size: 13px; width:300px" ><b>N° Exp. : </b>{{$informe_ri->exposicion}}</td>
                            <td style="font-size: 13px;  width:200px" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>                             
                        </tr>
                      </tbody>
                    </table>   
                </td>
              </tr>
    </tbody>
</table>

</body>
</html>