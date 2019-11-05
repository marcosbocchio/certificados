<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe LP</title>
</head>

<style>

@page { margin: 319px 1px 141px 49px !important;
        padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -282px; 
   
    }

main{
   
    margin-top: -2px;
}

footer {
    position: fixed; bottom:4px; 

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
                                <td style="font-size: 18px; height: 30px; text-align: center;width:234px" rowspan="3"><b>INFORME LÍQUIDOS PENETRANTES</b></td>
                                <td style="font-size: 12px;"><b style="margin-left: 40px"></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 12px;" ><b style="margin-left: 120px" >INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'LP')}}</td>                      
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
                            <td style="font-size: 12px;  width: 260px; border-right: 1px solid #000;" colspan="4"  ><b>Inst. Medición: </b>{{$equipo->equipo->tipo_lp}} / {{$equipo->equipo->codigo}}</td>                            
                            <td style="font-size: 12px;width: 125px;  " colspan="1"  ><b style="font-size: 12px;">Rem: </b>
                             {{$removedor->tipo}}
                             @if ($removedor->marca)

                                /{{$removedor->marca}}

                             @endif
                            
                            </td>  
                            <td style="font-size: 12px;  " colspan="1"  ><b style="font-size: 12px;">Aplic.: </b>{{$removedor_aplicacion->codigo}}</td>                          
                        </tr>
                        <tr>                       
                            <td style="font-size: 12px;border-right: 1px solid #000;"  ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000; " colspan="4" ><b>Proc. LP: </b>{{$procedimiento_inf->titulo}} </td>
                            <td style="font-size: 12px; " colspan="2"  ><b>Limpieza Previa: </b>descripcion limpieza</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000;"  ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 12px;border-right: 1px solid #000; " colspan="4"  ><b>Método: </b>{{$metodo->tipo}}-{{$metodo->metodo}}</td>                         
                            <td style="font-size: 12px; " colspan="2"  ><b>Limpieza Intermedia: </b>descripcion limpieza</td>                      
                        </tr>
                        <tr>
                            <td style="font-size: 12px; border-right: 1px solid #000;"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 12px; border-right: 1px solid #000;" colspan="4"  ><b>Penetrante: </b>{{$informe_lp->tipo_penetrante}}</td>    
                            <td style="font-size: 12px; " colspan="2"  ><b>Limpieza Final: </b>descripcion limpieza</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000; "  ><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                {{ $informe->espesor_chapa }}
                                @else
                                {{  $diametro_espesor->espesor }}
                                @endif                       
                            
                            </td>
                            <td style="font-size: 12px;border-right: 1px solid #000; " colspan="4"  ><b>Tipo/Marca Pen.: </b>
                              {{$penetrante->tipo}}
                             @if ($penetrante->marca)

                                 &nbsp;/&nbsp;{{$penetrante->marca}}

                             @endif
                            
                            </td>                         
                            <td style="font-size: 12px;" colspan="2"  ><b style="font-size: 12px;">Norma Evaluación: </b>{{$norma_evaluacion->descripcion}}</td>                            
                        
                        </tr>
                        <tr>                           
                           <td style="font-size: 12px;border-right: 1px solid #000;" ><b>Proc. Sold. : </b>{{$informe->procedimiento_soldadura}}</td>
                           <td style="font-size: 12px;width: 150px" colspan="2" ><b>Aplic Pen.: </b>{{$penetrante_aplicacion->codigo}}</td>  
                           <td style="font-size: 12px;border-right: 1px solid #000;" colspan="2"  ><b>Tiempo Pen.: </b> {{$informe_lp->tiempo_penetracion}} Min.</td>
                           <td style="font-size: 12px; " colspan="2" ><b>Norma Ensayo: </b>{{$norma_ensayo->descripcion}}</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 12px;border-right: 1px solid #000;" ><b>EPS: </b>{{$informe->eps}}</td>
                            <td style="font-size: 12px;border-right: 1px solid #000;" colspan="4"  ><b>Revelador: </b>

                            {{$revelador->tipo}}
                             @if ($revelador->marca)

                                 &nbsp;/&nbsp;{{$revelador->marca}}

                             @endif
                             
                             </td>                                                
                            <td style="font-size: 12px;" colspan="2"  ><b>Iluminación: </b>{{$iluminacion->codigo}} </td>  
                        </tr>
                        <tr>                           
                            <td style="font-size: 12px;border-right: 1px solid #000;" ><b>PQR: </b>{{$informe->pqr}}</td>
                            <td style="font-size: 12px; border-right: 1px solid #000; " colspan="4" ><b>Aplic. Rev.: </b>{{$revelador_aplicacion->codigo}}</td>
                            <td style="font-size: 12px; " colspan="2" ><b>Ejecutor Ensayo : </b>{{$ejecutor_ensayo->name}}</td>
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
                                <td style="font-size: 12px; text-align: center;" class="bordered-td">AP</td>
                                <td style="font-size: 12px; text-align: center;" class="bordered-td">RZ</td>                            
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
            @foreach ($detalles as $detalle)
                <tr>
                    <td style="font-size: 12px;  width:66px;text-align: center" class="bordered-td">{{ $detalle->pieza }}</td>
                    <td style="font-size: 12px;  width:40px;text-align: center" class="bordered-td">{{$detalle->numero}}</td>
                    <td style="font-size: 12px;  width:500px;" class="bordered-td">&nbsp; {{$detalle->detalle}}</td>               
                    <td style="font-size: 12px; text-align: center;width:39px; " class="bordered-td">
                        @if ($detalle->aceptable_sn)
                            X
                        @endif
                    </td>

                    <td style="font-size: 12px; text-align: center;width:38px;" class="bordered-td">
                        @if (!$detalle->aceptable_sn)
                            X
                        @endif
                    </td>
                    <td class="bordered-td">&nbsp;
                        @if ($detalle->referencia_id)
                            <a href="{{ route('InformeLpReferencias',$detalle->referencia_id)}}"><img src="{{ public_path('img/fa-file-pdf.jpg')}}" alt="" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>                                                       
                        @endif
                    </td>
                </tr>                
            @endforeach    

            {{ $cantFilasTotal = count($detalles) }}
            {{ $filasPage = 30 }}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}  

             @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    <td style="font-size: 12px;  width:66px;text-align: center" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 12px;  width:40px;text-align: center" class="bordered-td">&nbsp;</td>
                    <td style="font-size: 12px;  width:500px;" class="bordered-td">&nbsp;</td>               
                    <td style="font-size: 12px; text-align: center;width:39px; " class="bordered-td">&nbsp;</td>
                    <td style="font-size: 12px; text-align: center;width:38px;" class="bordered-td">&nbsp;</td>
                    <td class="bordered-td">&nbsp;</td>
                </tr>
            @endfor                                  
        </tbody>
    </table>
</main>
     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 487;
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

    $pdf->line(38.5,130,38.5,800,array(0,0,0),1.5);
     $pdf->line(593,130,593,800,array(0,0,0),1.5);

</script>


</body>
</html>