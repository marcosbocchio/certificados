<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro_informe }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 233px 40px !important;
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

    @include('reportes.informes.partial.observaciones') 

    @include('reportes.partial.linea-amarilla')

    @include('reportes.informes.partial.firmas') 
</footer>


<main>   
    
    @include('reportes.informes.partial.header-detalle-lp-portrait')      
    
    @include('reportes.partial.linea-amarilla')  

    <table width="100%" style="border-collapse: collapse;">
        <thead>  
            <tr>
                <td colspan="6"><strong style="font-size: 14px;">Indicaciones</strong></td>
            </tr>        
            <tr>
                <td style="font-size: 11px; width:65px;  text-align: center " rowspan="2" class="bordered-td" >ELEM.</td>
                <td style="font-size: 11px; width:40px;  text-align: center;" rowspan="2" class="bordered-td">CM</td>
                <td style="font-size: 11px; width:477px; text-align: center;" rowspan="2" class="bordered-td">DETALLE</td>
                <td style="font-size: 11px; width:80px; text-align: center;" colspan="2" class="bordered-td">RESULTADO</td>  
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">REF</td>                     
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center;" class="bordered-td">AP</td>
                <td style="font-size: 11px; text-align: center;" class="bordered-td">RZ</td>                            
            </tr>         
        </thead>
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
                    <td style="font-size: 11px;  width:477px;" class="bordered-td">&nbsp; {{$detalle->detalle}}</td>               
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
                            <a href="{{ route('InformeLpReferencias',$detalle->referencia_id)}}"><img src="{{ public_path('img/fa-file-pdf.png')}}" alt="" style="height: 15px;margin-left:3px;;margin-top:2px;text-align: center;"></a>                                                       
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