<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{FormatearNumeroInforme($informe->numero,'RI')}}</title>
</head>

<style>

.titulosHead {

    font-size: 13px;
    font-weight: bold;

}

.datosHead {

    font-style: italic;
}

</style>
<body>
    <header>
        <table style="text-align: center;border: 1px solid;" width="100%">
            <tbody>
                <tr>
                     <td>
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td rowspan="4" style="text-align: right;width: 240px;">
                                        <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                    </td>   
                                    <td style="font-size: 19px; height: 30px;width: 200px; text-align: center;margin-left: 0px" rowspan="3"><b>RADIOGRAFIA INDUSTRIAL</b></td>
                                    <td style="font-size: 11px;" ><b style="margin-left: 131px;">INFORME N°: </b>{{FormatearNumeroInforme($informe->numero,'RI')}}</td>                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b style="margin-left: 131px;">FECHA: </b>{{ date('d-m-Y', strtotime($informe->fecha)) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b></b></td>                     
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b></b></td>                     
                                    <td style="font-size: 11px;"><b></td>            
                                </tr>               
                            </tbody>
                        </table>          
                    </td>
                </tr>
            </tbody>
        </table>    
        @include('reportes.informes.partial.header-portrait-v2')                
    </header>   


     
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 473;
        $y = 69;
        $text = "PÁGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 9;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        $pdf->line(34,167,561,167,array(0,0,0),1.5);
    }

</script>
</body>
</html>