<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe RI</title>
</head>

<style>

@page { margin: 319px 10px 125px 40px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -280px; 
   
    }

.contenido {

   
    margin-bottom: -2px;
}

.contenido table {

border: #000 2px solid;
margin: 0px 0px 0px 0px !important;
padding: 0px 0px 0px 0px !important;
}

footer {
    position: fixed; bottom:0px; 

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
                            <td style="font-size: 12px; width: 200px;border-right: 1px solid #000;"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 12px;width: 50px; " colspan="2" ><b>Equipo: </b></td>
                            <td style="font-size: 12px;" ><b>Kv: </b>{{$informe->kv}}</td>
                            <td style="font-size: 12px; width: 50px; border-right: 1px solid #000;" ><b>mA: </b>{{$informe->ma}}</td>
                            <td style="font-size: 11px;  " colspan="2"  ><b style="font-size: 12px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td>                            
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 12px;border-right: 1px solid #000;"  ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 12px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Fuente: </b>     

                            @if ($fuente)

                                {{$fuente->codigo}} 
                                
                            @endif
                            
                            
                            </td>
                            <td style="font-size: 12px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000;"  ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4"  ><b>Foco: </b>{{$informe_pm->foco}}</td>   
                            
                            <td style="font-size: 12px;  "  ><b>Actividad: </b>{{$informe_pm->pos_pos}}</td>
                            <td style="font-size: 12px;"  ><b>N° Exp. : </b>{{$informe_pm->exposicion}}</td>
                            
                        </tr>
                        <tr>
                            <td style="font-size: 12px; border-right: 1px solid #000;"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 12px; border-right: 1px solid #000; " colspan="4"  ><b>Pelicula : </b></td>    
                            <td style="font-size: 12px;  " colspan="2" ><b>Dis.Fuente/pelicula: </b>{{$informe_pm->distancia_fuente_pelicula}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000; "  ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                {{ $informe->espesor_chapa }}
                                @else
                                {{  $diametro_espesor->espesor }}
                                @endif                       
                            
                            </td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4"  ><b>Tipo: </b></td>    
                            <td style="font-size: 12px;  " colspan="2" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>                
                        
                        </tr>
                        <tr>                           
                            <td style="font-size: 12px;border-right: 1px solid #000;" ><b>Proc. Sold. : </b>{{$informe->procedimiento_soldadura}}</td>
                            
                            <td style="font-size: 12px; width: 75px"   ><b>Pantalla: </b>Pb</td>
                            <td style="font-size: 12px; width: 15px"  ><b>Ant: </b>{{$informe_pm->pos_ant}}</td>
                            <td style="font-size: 12px; width: 15px"  ><b>Pos: </b>{{$informe_pm->pos_pos}}</td>
                            <td style="font-size: 12px; width: 1px; border-right: 1px solid #000;"  ><b>Lado: </b>{{$informe_pm->lado}}</td>
                            
                            <td style="font-size: 12px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->descripcion}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000;" ><b>Eps: </b>{{$informe->eps}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000; " colspan="4" ><b>Proc. RI: </b>{{$procedimiento_inf->titulo}} </td>                        
                            <td style="text-align: center; " colspan="2" rowspan="2" >
                                          
                                    
                            </td>  
                        </tr>
                        <tr>                           
                            <td style="font-size: 12px;border-right: 1px solid #000;" ><b>Pqr: </b>{{$informe->pqr}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4" ><b>Ici : </b></td> 

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
                                <td style="font-size: 12px; width:65px;  text-align: center " rowspan="2" class="bordered-td" >PIEZA</td>
                                <td style="font-size: 12px; width:40px;  text-align: center;" rowspan="2" class="bordered-td">N°</td>
                                <td style="font-size: 12px; width:500px; text-align: center;" rowspan="2" class="bordered-td">DETALLE</td>
                                <td style="font-size: 12px; width:80px; text-align: center;" colspan="2" class="bordered-td">RESULTADO</td>  
                                <td style="font-size: 12px; text-align: center" rowspan="2" class="bordered-td">REF</td>                     
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
    
    <table width="100%" class="bordered-1" style="margin-bottom: 0px;">
        <tbody>
            @foreach ($detalles as $detalle)
                <tr>
                    <td style="font-size: 11px;  width:66px;text-align: center" class="bordered-td">{{ $detalle->pieza }}</td>
                    <td style="font-size: 11px;  width:40px;text-align: center" class="bordered-td">{{$detalle->numero}}</td>
                    <td style="font-size: 11px;  width:500px;" class="bordered-td">&nbsp; {{$detalle->detalle}}</td>               
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
                                        
        </tbody>
    </table>
</div>
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 469;
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