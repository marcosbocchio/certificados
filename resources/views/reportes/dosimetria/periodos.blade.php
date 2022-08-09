<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DOSIMETRIA: ALTAS Y BAJAS</title>
</head>

<style>  

@page {    
        margin: 123px 15px 30px 15px !important;
        padding: 0px 0px 0px 0px !important;
       }


header {
    position:fixed;
    top: -83px;    
}

footer {
    position: fixed; bottom:15.5px; 
    padding-top: 0px;

}

main th, main td {
    border: 1px solid;  
    text-align: center;
  }

main {
      margin-top: -2px;
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

.maxRxMensual {

color: red;
}

.maxDifOpRx {

text-decoration: underline;
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
                                <td rowspan="4" style="text-align: right; width:253px">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                                </td>   
                                <td style="font-size: 18px; height: 30px; text-align: center;width:520px;" rowspan="3"><b>DOSIMETRIA: ALTAS Y BAJAS</b></td>
                                <td style="font-size: 11px;"><b style="margin-left: 40px"></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 130px"></b></td>     
                            </tr>

                            <tr>
                                <td style="font-size: 12px;" colspan="2"><b style="margin-left: 130px">FECHA: </b>{{ date('d-m-Y', strtotime($fecha)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 130px"></b></td>                     
                                <td style="font-size: 12px;"><b style="margin-left: 130px"></td>            
                            </tr>               
                        </tbody>
                    </table>          
                </td>
            </tr>            
        </tbody>
    </table>    
</header>

<main>
<table width="100%" class="bordered">
    <thead>
        <tr>
            <th style="font-size: 10px;width: 160px;" ><b>OPERADOR</b></th>         
            <th style="font-size: 10px;width: 30px;">FILM</th> 

            @for ($x = 1 ; $x <=6 ; $x++)
                    
                <th style="font-size: 10px;" >ALTA</th>  
                <th style="font-size: 10px;" >BAJA</th>   

            @endfor                                       

        </tr>
    </thead>
    
    <tbody>
        @foreach ($operadores as $item )
        <tr>
            <td style="font-size: 10px;"><span style="float: left;margin-left: 5px;"> {{ $item->name }}</span> </td>       
            <td style="font-size: 10px;">{{ $item->film }}</td>     
            {{ $cant_operador_periodos = count($item->periodos) }}
            {{ $cant_altas_bajas = 0 }}

            @for ($x =0 ; $x < $cant_operador_periodos ; $x++)
                
                {{ $cant_altas_bajas++ }}

                 <td style="font-size: 10px;">{{ date('m-Y',strtotime($item->periodos[$x]->alta)) }}</td>  

                 @if ($item->periodos[$x]->baja)

                        {{ $cant_altas_bajas++ }}
                        <td style="font-size: 10px;">{{ date('m-Y',strtotime($item->periodos[$x]->baja)) }}</td>  

                 @endif     

            @endfor
            @for ($x = 1 ; $x <= (12 - $cant_altas_bajas)  ; $x++)

                   <td style="font-size: 10px;"></td>

            @endfor
             
        </tr>

        @endforeach
            {{ $cantFilasTotal = count($operadores) }}
            {{ $filasPage = 41}}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}

            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    @for ($c = 1; $c <= 14; $c++)
                        
                         <td style="font-size: 10px;">&nbsp;</td>

                    @endfor
         
                </tr>
            @endfor
    </tbody>
</table>
</main>  

<script type="text/php">

    if ( isset($pdf) ) {
        $x = 699;
        $y = 77;
        $text = "PÁGINA: {PAGE_NUM} de {PAGE_COUNT}";
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
