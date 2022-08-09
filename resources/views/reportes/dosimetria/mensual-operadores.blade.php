<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DOSIMETRÍA OPERADORES {{ getNombreMes($month) }} {{$year}}</title>
</head>

<style>

@page {
        margin: 124px 15px 40px 15px !important;
        padding: 0px 0px 0px 0px !important;
       }
.EspecialCaracter {
    font-family: DejaVu Sans;
}

header {
    position:fixed;
    top: -81px;
}

footer {
    position: fixed; bottom:7px;
    padding-top: 1px;

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

.habilitadoArn {

color: rgb(255, 204, 0);
}

.deshabilitadoArn {

color:rgb(255, 255, 255);

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
                                <td style="font-size: 18px; height: 30px; text-align: center;width:520px;" rowspan="3"><b>DOSIMETRÍA OPERADORES ( {{ getNombreMes($month) }} {{$year}} )</b></td>
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

<footer>
    <table width="100%" class="bordered">
        <tbody>
            <tr>
                <td style="font-size: 10px;height: 18px"><span class="EspecialCaracter" style="margin-left:940px">* Valores expresados en μSv</span></td>
            </tr>
        </tbody>
    </table>
</footer>

<main>
    <table width="100%" class="bordered">
        <thead>
            <tr>
                <th style="font-size: 10px;width:160px;"  rowspan="2"><b>OPERADOR</b></th>
                <th style="font-size: 10px;width:50;" rowspan="2">DNI</th>
                <th style="font-size: 10px;width:30px;" rowspan="2">FILM</th>
                <th style="font-size: 10px;" colspan="31">MES</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= 31; $i++)
                    <th style="font-size: 10px;">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            {{ $cant_operadores = count($operadores) }}
            @foreach ($operadores as $operador)
                <tr>
                    <td style="font-size: 10px;background-color: black; border-bottom: white;"><span style="float: left;margin-left: 5px;" class="@if($operador->habilitado_arn_sn) habilitadoArn @else deshabilitadoArn @endif"> {{ $operador->name }}</span> </td>
                    <td style="font-size: 10px;">{{ $operador->dni }}</td>
                    <td style="font-size: 10px;">{{ $operador->film }}</td>

                    @for ($i = 0; $i <= 30; $i++)
                        <td style="font-size: 10px;">{{ $operador->data->microsievert[$i] }}</td>
                    @endfor
                </tr>

            @endforeach

            {{ $cantFilasTotal = count($operadores) }}
            {{ $filasPage = 40}}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}

            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>

                    @for ($c = 1; $c <= 34; $c++)

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
