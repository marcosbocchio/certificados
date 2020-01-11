<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Dodimetria {{$year}}</title>
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
                                <td style="font-size: 18px; height: 30px; text-align: center;width:520px;" rowspan="3"><b>DOSIMETRIA {{$year}}</b></td>
                                <td style="font-size: 11px;"><b style="margin-left: 40px"></b></td>                         
                            </tr>
                            <tr>
                                <td style="font-size: 12px;"><b style="margin-left: 130px"></b></td>     
                            </tr>

                            <tr>
                                <td style="font-size: 13px;" colspan="2"><b style="margin-left: 130px">FECHA: </b>{{ date('d-m-Y', strtotime($fecha)) }}</td>
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
            <th style="font-size: 10px;width: 160px;" rowspan="2"><b>OPERADOR</b></th>
            <th style="font-size: 10px;width: 50px;" rowspan="2">DNI</th>
            <th style="font-size: 10px;width: 30px;" rowspan="2">FILM</th> 
            <th style="font-size: 10px;" colspan="3">ENE</th>  
            <th style="font-size: 10px;" colspan="3">FEB</th>                                                     
            <th style="font-size: 10px;" colspan="3">MAR</th>                                                     
            <th style="font-size: 10px;" colspan="3">ABR</th>                                                     
            <th style="font-size: 10px;" colspan="3">MAY</th>                                                     
            <th style="font-size: 10px;" colspan="3">JUN</th>                                                     
            <th style="font-size: 10px;" colspan="3">JUL</th>                                                     
            <th style="font-size: 10px;" colspan="3">AGO</th>                                                     
            <th style="font-size: 10px;" colspan="3">SEP</th>                                                     
            <th style="font-size: 10px;" colspan="3">OCT</th>                                                     
            <th style="font-size: 10px;" colspan="3">NOV</th>                                                     
            <th style="font-size: 10px;" colspan="3">DIC</th>  
            <th style="font-size: 10px;" colspan="2">ACUM</th>   
        </tr>
        <tr> 
            @for ($x = 1 ; $x <=12 ; $x++)
                    
                <th style="font-size: 10px;">OP</th>     
                <th style="font-size: 10px;">RX</th>             
                <th style="font-size: 10px;">ES</th>   

            @endfor  

            <th style="font-size: 10px;">OP</th>     
            <th style="font-size: 10px;">RX</th>
        </tr>
    </thead>
    <tbody>
            @foreach ($resumen as $item)
                <tr>
                    <td style="font-size: 10px;"><span style="float: left;margin-left: 5px;"> {{ $item->operador }}</span> </td>
                    <td style="font-size: 10px;">{{ $item->dni }}</td>
                    <td style="font-size: 10px;">{{ $item->film }}</td>   

                    <td style="font-size: 10px;">{{ $item->DOM1 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM1 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM1 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM2 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM2 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM2 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM3 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM3 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM3 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM4 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM4 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM4 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM5 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM5 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM5 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM6 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM6 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM6 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM7 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM7 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM7 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM8 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM8 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM8 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM9 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM9 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM9 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM10 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM10 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM10 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM11 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM11 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM11 }}</td>

                    <td style="font-size: 10px;">{{ $item->DOM12 }}</td>
                    <td style="font-size: 10px;">{{ $item->DRXM12 }}</td>
                    <td style="font-size: 10px;">{{ $item->EM12 }}</td>

                    <td style="font-size: 10px;">{{ $item->ACUMULADO_OP }}</td>
                    <td style="font-size: 10px;">{{ $item->ACUMULADO_RX }}</td>
                </tr>
            @endforeach
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
