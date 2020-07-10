<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro_informe }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 300px 40px 160px 40px !important;
            padding: 0px 0px 0px 0px !important; }

    header {
        position:fixed;
        top: -277px;    
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
    
    <table width="100%" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <td style="border: 1px solid #000;border-collapse: collapse; background:#D8D8D8;text-align: center;">REGISTRO DE MEDICIONES</td>
            </tr>
        </tbody>
    </table>

</header>

<footer>

    @include('reportes.partial.linea-amarilla') 

    @include('reportes.informes.partial.firmas') 

</footer>


<main>   
    
    @foreach ($informes_us_me as $informe_us_me)   

            @php 
                $pos_gen = 1;
                $max_cant_genetratices_fila = 20;
                $genetratrices_fila = $max_cant_genetratices_fila;
            @endphp            
            <table>
                <tbody>
                    <tr>
                         <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Elemento : {{ strtoupper($informe_us_me->elemento)}}</span></td> 
                    </tr>
                    @if ($informe_us_me->umbral)
                        <tr>
                             <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Espesor Nominal : {{ strtoupper($informe_us_me->umbral)}}</span></td> 
                        </tr>                     
                    @endif

                    @if ($informe_us_me->espesor_minimo)
                        <tr>
                             <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Espesor Mínimo : {{ strtoupper($informe_us_me->espesor_minimo)}}</span></td> 
                        </tr>
                    @endif
                    <tr>
                        <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Ø : {{ $informe_us_me->diametro}}</span></td>  
                    </tr>
                </tbody>
            </table>            
            @while($pos_gen <= $informe_us_me->cantidad_generatrices)
                <table  style="text-align: center;margin-left:18px;border-collapse: collapse;margin-bottom: 20px;"  class="bordered">
                    <thead>                    
                        <tr>  
                            <th style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8"  class="bordered-td">&nbsp;</th>
                            @while( ($pos_gen <= $genetratrices_fila) && ($pos_gen <= $informe_us_me->cantidad_generatrices))   
                                <th style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8" class="bordered-td">
                                    @foreach ($generatrices as $generatriz )
                                            
                                        @if($generatriz->nro == $pos_gen)
                                            {{  $generatriz->valor }}
                                        @endif

                                    @endforeach

                                </th>
                                {{ $pos_gen = $pos_gen + 1}}
                            @endwhile   
                            {{ $genetratrices_fila = $genetratrices_fila + $max_cant_genetratices_fila }}                                
                        </tr>
                      </thead>
                      <tbody>
                        @for ( $pos_pos= 1 ;  $pos_pos <= $informe_us_me->cantidad_posiciones ; $pos_pos++)
                                <tr> 
                                    <td style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8" class="bordered-td">{{$pos_pos}}</td>
                                    @for ($pos_gen_fila = ($genetratrices_fila - (2*$max_cant_genetratices_fila)+1) ; $pos_gen_fila <= $pos_gen - 1 ; $pos_gen_fila++)

                                    {{ $x =0  }}
                                
                                        @foreach ($informe_us_me->detalle_us_me as $item_detalle )

                                            @foreach ($generatrices as $generatriz)
                                                
                                                @if ($pos_pos==$item_detalle->posicion && $pos_gen_fila == $generatriz->nro && $item_detalle->generatriz==$generatriz->valor)  

                                                    @if(($informe_us_me->espesor_minimo) && (strval($item_detalle->valor) < strval($informe_us_me->espesor_minimo)))

                                                       <td style="font-size: 13px; text-align: left;width:28px;text-align: center;color:red" class="bordered-td">{{$item_detalle->valor}}</td>

                                                    @else

                                                        <td style="font-size: 13px; text-align: left;width:28px;text-align: center" class="bordered-td">{{$item_detalle->valor}}</td>
                                                    
                                                    @endif

                                                    {{ $x =1  }}

                                                @endif

                                            @endforeach                                                                                            
                                        
                                    @endforeach                                                                             
                                    
                                    @if ($x==0)
                                            <td style="font-size: 13px; text-align: left;width:28px;text-align: center" class="bordered-td">X</td>
                                    @endif

                                    @endfor
                                </tr>                                        
                            @endfor
                        </tr>       
                    </tbody>
                </table>                               
            @endwhile           
    @endforeach

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