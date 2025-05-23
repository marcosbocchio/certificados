<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{FormatearNumeroInforme($informe->numero,'PM')}}</title>
</head>

<style>

@page { margin: 357px 30px 124px 60px !important;
        padding: 0px 0px 0px 0px !important; }

body {
    margin: 0px 1px 0px 1px;
    padding: 0 0 0 0;
}

header {
    position:fixed;
    top: -317px;    
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

<body class="bordered" style="border-top: none;border-bottom: none;">  

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
                                <td style="font-size: 19px; height: 30px;width: 200px; text-align: center;margin-left: 0px" rowspan="3"><b>PARTÍCULAS MAGNETIZABLES</b></td>
                                <td style="font-size: 11px;"><b ></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 11px;" ><b style="margin-left: 131px;">INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'PM')}}</td>                      
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 131px;">FECHA: </b>{{ date('d-m-Y', strtotime($informe->fecha)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b></b></td>                     
                                <td style="font-size: 11px;"><b></td>            
                            </tr>               
                        </tbody>
                    </table>          
                </td>
            </tr>
            @include('reportes.informes.partial.header-portrait')
            <tr>
                <td class="bordered">
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>                 
                        <tr>
                            <td style="font-size: 11px; width: 200px;border-right: 1px solid #000;"><b>Componente: </b>{{$informe->componente}}</td>
                            <td style="font-size: 11px;width: 50px; " colspan="2" ><b>Equipo: </b>{{$interno_equipo->equipo->codigo}}</td>
                            <td style="font-size: 11px;" ><b>Kv: </b>                     
                               @if ($informe_pm->voltaje)
                                   {{$informe_pm->voltaje }}
                                @else
                                   {{$interno_equipo->voltaje}}
                                @endif
                            </td>
                            <td style="font-size: 11px; width: 50px; border-right: 1px solid #000;" ><b>mA: </b>
                                @if ($informe_pm->amperaje)
                                   {{$informe_pm->amperaje }}
                                @else
                                   {{$interno_equipo->amperaje}}
                                @endif
                            <td style="font-size: 11px;" colspan="2"  ><b style="font-size: 11px;">Norma Evaluación: </b>{{$norma_evaluacion->codigo}}</td>                            
                        </tr>
                        <tr>                
                            
                            <td style="font-size: 11px;border-right: 1px solid #000;"  ><b>Material: </b>{{$material->codigo}}</td>
                            <td style="font-size: 11px;  width: 270px; border-right: 1px solid #000;" colspan="4"  ><b>Método: </b>{{$metodo->codigo}}</td>
                            <td style="font-size: 11px; " colspan="2"  ><b>Norma Ensayo: </b>{{$norma_ensayo->codigo}}</td>                
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;"  ><b>Material A. :</b>

                                @if ($material_accesorio)
                                    {{$material_accesorio->codigo}}                                
                                @endif
                            
                            </td>
                            <td style="font-size: 11px;" colspan="2"><b>Vehículo: </b>{{$informe_pm->vehiculo}}</td>
                            <td style="font-size: 11px;border-right: 1px solid #000; " colspan="2"  ><b>Aditivo: </b>{{$informe_pm->aditivo}}</td>    

                            
                            <td style="font-size: 11px;" colspan="2"><b>Desmaganetización: </b>

                                @if ($desmagnetizacion_sn)
                                    SI
                                @else
                                    NO 
                                @endif                             
                            
                            </td>
                            
                        </tr>
                        <tr>
                            <td style="font-size: 11px;border-right: 1px solid #000;"  ><b>Plano / Isom :</b>{{$informe->plano_isom}}</td>
                            <td style="font-size: 11px;border-right: 1px solid #000;" colspan="4"  ><b>Particula: </b>{{$particula->tipo}} / {{$particula->marca}}</td>    
                           <td style="font-size: 11px; " colspan="2" ><b>Tecnica: </b>{{$tecnica->descripcion}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px; border-right: 1px solid #000;"  ><b>Diametro: </b>{{$diametro_espesor->diametro}}</td>    
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="4"  ><b>Tipo Magnetización: </b>{{$tipo_magnetizacion->codigo}}</td>  
                            <td style="font-size: 11px;" colspan="2"  ><b>Color Partículas: </b>{{$particula->color->codigo}} </td>    
                        
                        </tr>
                        <tr>                           
                            <td style="font-size: 11px;border-right: 1px solid #000;"><b>Espesor: </b>

                                @if ($informe->espesor_chapa)
                                    {{ $informe->espesor_chapa }}
                                @elseif($informe->espesor_especifico)
                                    {{ $informe->espesor_especifico }}
                                @else
                                     {{ $diametro_espesor->espesor }}
                                @endif                     
                            
                            </td>                            
                           <td style="font-size: 11px;  " colspan="2"  ><b>Magnetización : </b>{{$magnetizacion->codigo}}</td>  
                           <td style="font-size: 11px;border-right: 1px solid #000;" colspan="2"  ><b>Fueza Portante: </b>{{$magnetizacion->fuerza_portante}}</td>                            
                             <td style="font-size: 11px;" colspan="2"  ><b>Iluminación: </b>{{$iluminacion->codigo}}</td>  
                        </tr>
                        <tr>
                            <td style="font-size: 10px;border-right: 1px solid #000;" ><b>EPS:</b>{{$ot_tipo_soldadura->eps}}</td>
                            <td style="font-size: 11px;" colspan="2"  ><b>Concentración: </b>{{$informe_pm->concentracion}}</td>
                            <td style="font-size: 11px;" colspan="1"  ><b>V: </b>{{$informe_pm->voltaje}}</td>  
                            <td style="font-size: 11px; border-right: 1px solid #000;" colspan="1"  ><b>Am: </b>{{$informe_pm->amperaje}}</td>                          
                            <td style="font-size: 11px;  " colspan="2" ><b>Contraste :</b>
                            @if ($contraste)
                                
                                {{$contraste->tipo}} / {{$contraste->marca}}

                            @endif
                            
                            </td>                
                        </tr>
                        <tr>                           
                            <td style="font-size: 10px;border-right: 1px solid #000;" ><b>PQR:</b>{{$ot_tipo_soldadura->pqr}}</td>
                            <td style="font-size: 11px; border-right: 1px solid #000; " colspan="4" ><b>Proc. : </b>{{$procedimiento_inf->titulo}} </td>
                            <td style="font-size: 11px;  " colspan="2" ><b>Ejec. Ensayo: </b>{{$ejecutor_ensayo->name}}</td>                

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
                                <td style="font-size: 11px; width:65px;  text-align: center " rowspan="2" class="bordered-td" >ELEM.</td>
                                <td style="font-size: 11px; width:40px;  text-align: center;" rowspan="2" class="bordered-td">CM</td>
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
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>CLIENTE </b></td> 
                               <td style="font-size: 13px; text-align: center;" colspan="2" class="bordered-td" ><b>COMITENTE </b></td>                              
                            </tr>
                            
                            <tr>                               
                                <td style="font-size: 11px; text-align: left; height: 25px;width:75px;"><span style="margin-left: 2px">FIRMA:</span></td>   

                                <td style="text-align:left ;font-size: 11px; border-right: 1px solid #000;width: 150px;margin-left: 15px;" rowspan="2">
                                    @if($evaluador && $evaluador->path)
                                        <img src="{{ public_path($evaluador->path)}}" alt="" style="width: 100px;height: 50px;">
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
    <table width="100%" class="bordered" style="padding: 0 -3px 0 -3px;" >
        <tbody>
            @foreach ($detalles as $detalle)
                <tr>
                    <td style="font-size: 11px;  width:66px;text-align: center" class="bordered-td">{{ $detalle->pieza }}</td>
                    <td style="font-size: 11px;  width:40px;text-align: center" class="bordered-td">   

                        @if ($detalle->cm)

                            {{$detalle->cm}}
                        @else
                            -    
                        @endif
                    
                    </td>
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
                            <a href="{{ route('InformePmReferencias',$detalle->referencia_id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" alt="" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>                                                       
                        @endif
                    </td>
                </tr>                
            @endforeach    

        <!--
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

        -->
                                
        </tbody>
    </table>
</main>
     
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

</script>


</body>
</html>