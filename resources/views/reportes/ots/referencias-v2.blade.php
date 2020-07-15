<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REFERENCIA INFORME N°: {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 235px 40px !important;
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
    @include('reportes.partial.header-principal-portrait')     
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
    @include('reportes.ots.firmas') 
</footer>

<main>   

    <table width="100%">>
        <tbody>
                <td style="font-size: 13px;" > <b>{{ $tabla }}: </b>  {{$modelo->descripcion}}</td>  
        </tbody>
    </table>

    <table style="text-align: center" class="" width="100%">
        <tbody>            
                <tr>
                    <td>                     
                        <table>    
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                            @if ($ot_referencia->path1!='/img/imagen1.jpg')
                                                <img src="{{ public_path($ot_referencia->path1) }}" alt="" style="height: 160; width: 234;">
                                            @endif  
                                            
                                    </td>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($ot_referencia->path2!='/img/imagen2.jpg')
                                            <img src="{{  public_path($ot_referencia->path2) }}" alt="" style="height: 160; width: 234;">
                                        @endif  
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($ot_referencia->path3!='/img/imagen3.jpg')
                                            <img src="{{  public_path($ot_referencia->path3) }}" alt="" style="height: 160; width: 234;">
                                    @endif  
                                    </td>
                                    <td style="text-align: center; width: 330px;height: 275px">
                                        @if ($ot_referencia->path4!='/img/imagen4.jpg')
                                            <img src="{{  public_path($ot_referencia->path4) }}" alt="" style="height: 160; width: 234;">
                                    @endif  
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
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