<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro_informe }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 280px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -237px;    
}        
    
footer {
    position: fixed; bottom:0px; 
    padding-top: 0px;
}

</style>

<body>
<header>
    @include('reportes.informes.partial.header-principal-portrait')     
    @include('reportes.partial.linea-amarilla')                
    @include('reportes.informes.partial.header-cliente-comitente-portrait')    
    @include('reportes.partial.linea-gris')        
    @include('reportes.informes.partial.header-proyecto-portrait')    
    @include('reportes.partial.linea-amarilla') 
</header>
<footer>
    @include('reportes.partial.linea-amarilla') 
    <table style="text-align: center;border-collapse: collapse;" width="100%" >
        <tbody>
            <tr>
                <td>
                    <table width="100%" style="border-collapse: collapse;" >
                        <tbody>
                            <tr>
                                <td style="font-size: 14px;"><strong>Diccionario</strong></td>
                            </tr>
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
                                <td style="font-size: 10px; " class="bordered-td"><b>MEL: </b>n Lineal</td>
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
        </tbody>
    </table>

    @include('reportes.partial.linea-amarilla') 

    @include('reportes.informes.partial.firmas') 
</footer>


<main>
    @include('reportes.informes.partial.header-detalle-ri-portrait')      
    
    @include('reportes.partial.linea-amarilla')  

        <table width="100%" style="border-collapse: collapse;">
            <thead>       
                <tr>
                    <td colspan="7"><strong style="font-size: 14px;">Indicaciones</strong></td>
                </tr>
               
                <tr>
                    <td style="font-size: 11px; width:65px;  text-align: center " rowspan="2" class="bordered-td" >Elem.</td>
                    <td style="font-size: 11px; width:65px;  text-align: center;" rowspan="2" class="bordered-td">Cuño</td>
                    <td style="font-size: 11px; width:50px; text-align: center;" colspan="2" class="bordered-td">Placa</td>
                    <td style="font-size: 11px; width:385px;  text-align: center;" rowspan="2" class="bordered-td">Indicaciones</td>  
                    <td style="font-size: 11px; text-align: center;" colspan="2" class="bordered-td">Resultado</td>  
                </tr>
                <tr>
                    <td style="font-size: 11px; text-align: center;width:64.5px;" class="bordered-td">Posición</td>
                    <td style="font-size: 11px; text-align: center;width:15px;" class="bordered-td"><span class="EspecialCaracter">ρ</span></td>  
                    <td style="font-size: 11px; text-align: center;" class="bordered-td">AP</td>
                    <td style="font-size: 11px; text-align: center;" class="bordered-td">RZ</td>                            
                </tr>  
            </thead>
            <tbody>
                @foreach ($juntas_posiciones as $junta_posicion)
                    <tr>
                        <td style="font-size: 11px;  width:65.7px;text-align: center" class="bordered-td">{{ $junta_posicion->junta }}</td>
                        <td style="font-size: 11px;  width:65.3px;text-align: center" class="bordered-td">
                            {{$junta_posicion->soldadorz}} 
        
                            @if ($junta_posicion->soldadorp)
                            
                                / {{$junta_posicion->soldadorp}} 
                                
                            @endif
                        </td>
                        <td style="font-size: 11px;  width:64.5px;text-align: center" class="bordered-td">{{$junta_posicion->posicion}}</td>
                        <td style="font-size: 11px;  width:23.5px;text-align: center" class="bordered-td">{{$junta_posicion->densidad}}</td>
                        <td style="font-size: 9px;   width:385px; " class="bordered-td">&nbsp;
                        @php $primero = true; @endphp
                            @foreach ($defectos_posiciones as $key => $defecto_posicion)                                
    
                                
                                @if ($defecto_posicion->posicion_id == $junta_posicion->posicion_id)
    
                                    @if (!$primero)
                                        /
                                    @endif
    
                                    @if ($defecto_posicion->posicion)                          
    
                                        @php
                                            $valor_imprimir = $defecto_posicion->codigo . '(' . $defecto_posicion->posicion . ')' ;
                                        @endphp
                         
                                    @else 
    
                                         @php
                                            $valor_imprimir = $defecto_posicion->codigo ;
                                        @endphp   
    
                                    @endif
    
                                    {{ $valor_imprimir}}
                                    {{ $primero = false}}    
    
                                @endif
                                
                            @endforeach
                        
                        </td>
    
                        <td style="font-size: 11px; text-align: center;width:37px; " class="bordered-td">
                            @if ($junta_posicion->aceptable_sn)
                                X
                            @endif
                        </td>
    
                        <td style="font-size: 11px; text-align: center;" class="bordered-td">
                            @if (!$junta_posicion->aceptable_sn)
                                X
                            @endif
                        </td>
                    </tr>       
                @endforeach                                       
            </tbody>
        </table>
    </main>   
     
    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 468;
            $y = 66;
            $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        /* $pdf->line(34,167,561,167,array(0,0,0),1.5); */
        }

    </script>

</body>
</html>