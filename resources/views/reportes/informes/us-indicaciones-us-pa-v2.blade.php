<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro_informe }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 151px 40px !important;
            padding: 0px 0px 0px 0px !important; }

    header {
        position:fixed;
        top: -237px;    
    }        
        
    footer {
        position: fixed; bottom:0px; 
        padding-top: 0px;
    }

#rotate
{
  height:170px;
}

#vertical
{
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
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

    @include('reportes.informes.partial.firmas') 

</footer>


<main>   

    <table style="text-align: center;border-collapse: collapse;" class="bordered-td">
        <thead>
            <tr>
                <td style="border-bottom: 1px solid #000;background:#D8D8D8" colspan="13" >REGISTRO DE MEDICIONES</td>
            </tr>
            <tr>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 20px;margin-right: 20px;">ELEMENTO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 6px;margin-right: 6px;">DIAMETRO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -30px;margin-right: -30px;">N° INDICACIÓN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -38px;margin-right: -38px;">POSICION EXAMEN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -25px;margin-right: -25px;">ANG. INCIDENCIA</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -33px;margin-right:  -33px;">CAMINO SONICO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 7.2px;margin-right: 7.2px;">X (cm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 5px;margin-right: 5px;">Y (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 5.7px;margin-right: 5.7px;">Z (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -34px;margin-right: -34px;">LONGITUD (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -37.8px;margin-right: -37.8px;">NIVEL REGISTRO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;" ><div id="vertical" style="margin-left: -2px;margin-right: -2px;">RESULTADO</div></th>
                <th id="rotate" style="font-size: 13px;font-weight: normal;" ><div id="vertical" style="margin-left: -29px;margin-right: -29px;">REFERENCIA</div></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indicaciones_us_pa  as $indicacion)
            <tr>                
                  <td style="font-size: 10px;height: 16px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->elemento) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">ø {{ $indicacion->diametro }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->nro_indicacion }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->posicion_examen) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->angulo_incidencia) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->camino_sonico }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->x }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->y }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->z }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->longitud }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->nivel_registro)}}</td>

                  <td style="font-size: 10px;text-align: center;" class="bordered-td">
                  @if($indicacion->aceptable_sn)
                      APROBADO
                   @else
                      RECHAZADO
                  @endif
                  </td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">

                   @if ($indicacion->detalle_us_pa_us_referencia_id)
                        <a href="{{ route('InformeUsDetalleUsPaUsReferencias',$indicacion->detalle_us_pa_us_referencia_id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" alt="" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>                                                       
                    @endif
                  
                  </td>
        
            </tr>        
            @endforeach   
        </tbody>
    </table>


    <!-- 
    <table style="text-align: center;border-collapse: collapse;" width="100%">
        <thead>
            <tr>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: 5px;margin-right: 5px;">ELEMENTO</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -6px;margin-right: -6px;">DIAMETRO</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -26px;margin-right: -26px;">N° INDICACIÓN</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -30px;margin-right: -30px;">POSICION EXAMEN</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -30px;margin-right: -30px;">ANG. INCIDENCIA</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -25px;margin-right: -25px;">CAMINO SONICO</div></td>            
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: 7.2px;margin-right: 7.2px;">X (cm)</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: 5px;margin-right: 5px;">Y (mm)</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: 5.7px;margin-right: 5.7px;">Z (mm)</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -20px;margin-right: -20px;">LONGITUD (mm)</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -25px;margin-right: -25px;">NIVEL REGISTRO</div></td>
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" style="margin-left: -10px;margin-right: -10px;">RESULTADO</div></td>           
                <td id="rotate" style="font-size: 13px;" class="bordered-td"><div id="vertical" >REFERENCIA</div></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($indicaciones_us_pa  as $indicacion)
            <tr>                
                  <td style="font-size: 10px;height: 16px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->elemento) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">ø {{ $indicacion->diametro }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->nro_indicacion }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->posicion_examen) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->angulo_incidencia) }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->camino_sonico }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->x }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->y }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->z }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->longitud }}</td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->nivel_registro)}}</td>

                  <td style="font-size: 10px;text-align: center;" class="bordered-td">
                  @if($indicacion->aceptable_sn)
                      APROBADO
                   @else
                      RECHAZADO
                  @endif
                  </td>
                  <td style="font-size: 10px;text-align: center;" class="bordered-td">

                   @if ($indicacion->detalle_us_pa_us_referencia_id)
                        <a href="{{ route('InformeUsDetalleUsPaUsReferencias',$indicacion->detalle_us_pa_us_referencia_id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" alt="" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>                                                       
                    @endif
                  
                  </td>
        
            </tr>        
            @endforeach   
        </tbody>
        -->
    @if($informe_us->path1_indicacion || $informe_us->path2_indicacion || $informe_us->path3_indicacion || $informe_us->path3_indicacion)

        <div class="page-break"></div> 
        <table style="text-align: center;" width="100%">
                <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center; width: 340px;height: 190px;">
                                                
                                            @if ($informe_us->path1_indicacion)
                                                <img src="{{ public_path($informe_us->path1_indicacion) }}" alt="" style="height: 180px; width: 263px;">
                                            @endif  
                            
                                        </td>

                                        <td style="text-align: center; width: 340px;height: 190px;">
                                                
                                            @if ($informe_us->path2_indicacion)
                                                <img src="{{ public_path($informe_us->path2_indicacion) }}" alt="" style="height: 180px; width: 263px;">
                                            @endif  
                            
                                        </td>  
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; width: 340px;height: 190px;">
                                            
                                            @if ($informe_us->path3_indicacion)
                                                <img src="{{ public_path($informe_us->path3_indicacion) }}" alt="" style="height: 180px; width: 263px;">
                                            @endif  
                                
                                        </td>

                                        <td style="text-align: center; width: 340px;height: 190px;">

                                            @if ($informe_us->path4_indicacion)
                                                <img src="{{ public_path($informe_us->path4_indicacion) }}" alt="" style="height: 180px; width: 263px;">
                                            @endif  
                                
                                        </td>
                                    </tr>                        
                                </tbody>
                            </table>             
                        </td>
                    </tr>
                </tbody>
            </table>
    @endif

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