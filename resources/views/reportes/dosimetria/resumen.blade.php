<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DOSIMETRÍA {{$year}}</title>
</head>

<style>

@page {
        margin: 123px 15px 40px 15px !important;
        padding: 0px 0px 0px 0px !important;
       }


header {
    position:fixed;
    top: -83px;
}

footer {
    position: fixed; bottom:8px;
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

.habilitadoArn {

color: rgb(255, 204, 0);
}

.deshabilitadoArn {

color:rgb(255, 255, 255);
}


footer table tbody tr td .abreviaturas{

    float: left;
    margin-left: 10px;
    padding-top: 3px;

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

<footer>
    <table style="text-align: center" width="100%" class="bordered">
        <tbody>
        {{ $cliente_sn = filter_var($resumen_cliente_sn,FILTER_VALIDATE_BOOLEAN) }}
        @if (!$cliente_sn)

            <tr>
                <td style="font-size: 10px;height: 18px;width: 100px;" class="bordered-td"><strong style="margin-left: 10px;"> ESTADOS </strong></td>
                <td style="font-size: 10px;height: 18px;" class="bordered-td">
                    <div class="abreviaturas">
                        <strong>O:</strong> Ok
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>B:</strong> Baja
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>N:</strong> No vinculado
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>P:</strong> Perdido
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>D:</strong> Deteriorado
                    </div>
                </td>
            </tr>

        @endif
        </tbody>
    </table>
</footer>

<main>
<table width="100%" class="bordered">
    <thead>
        {{ $cliente_sn = filter_var($resumen_cliente_sn,FILTER_VALIDATE_BOOLEAN) }}
        {{ $colspan_mes = $cliente_sn ? 1 : 3 }}
        <tr>
            <th style="font-size: 10px;width: 160px;" rowspan="2"><b>OPERADOR</b></th>
            <th style="font-size: 10px;width: 50px;" rowspan="2">DNI</th>
            <th style="font-size: 10px;width: 30px;" rowspan="2">FILM</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">ENE</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">FEB</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">MAR</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">ABR</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">MAY</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">JUN</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">JUL</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">AGO</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">SEP</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">OCT</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">NOV</th>
            <th style="font-size: 10px;" colspan="{{ $colspan_mes }}">DIC</th>
            @if(!$cliente_sn)
                 <th style="font-size: 10px;" colspan="2">ACUM</th>
            @endif
        </tr>
        <tr>
            @for ($x = 1 ; $x <=12 ; $x++)

                 @if ($cliente_sn)
                   <th style="font-size: 10px;">RX</th>
                 @else
                    <th style="font-size: 10px;">OP</th>
                    <th style="font-size: 10px;">RX</th>
                    <th style="font-size: 10px;">E</th>
                 @endif

            @endfor
            @if(!$cliente_sn)
                <th style="font-size: 10px;">OP</th>
                <th style="font-size: 10px;">RX</th>
            @endif
        </tr>
    </thead>
    <tbody>
            @foreach ($resumen as $item)
                <tr>
                    <td style="font-size: 10px;background-color: black; border-bottom: white;"><span style="float: left;margin-left: 5px;" class="@if($item->habilitado_arn_sn) habilitadoArn @else deshabilitadoArn @endif"> {{ $item->operador }}</span> </td>
                    <td style="font-size: 10px;">{{ $item->dni }}</td>
                    <td style="font-size: 10px;">{{ $item->film }}</td>

                    @if ($cliente_sn)
                        @if ($months[0])
                            <td style="font-size: 10px;" class="@if($item->DRXM1 > $Max_Rx_Mensual->valor) maxRxMensual  @endif @if(abs($item->DOM1 - $item->DRXM1) > $Max_dif_op_rx->valor)  maxDifOpRx @endif" >{{ $item->DRXM1 }}</td>
                        @else
                             <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM1 > $Max_Rx_Mensual->valor) maxRxMensual  @endif @if(abs($item->DOM1 - $item->DRXM1) > $Max_dif_op_rx->valor)  maxDifOpRx @endif"> {{ $item->DOM1 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM1 > $Max_Rx_Mensual->valor) maxRxMensual  @endif @if(abs($item->DOM1 - $item->DRXM1) > $Max_dif_op_rx->valor)  maxDifOpRx @endif" >{{ $item->DRXM1 }}</td>
                        <td style="font-size: 10px;" ><span style="color: {{$item->CM1}}"> {{ $item->EM1[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[1])
                            <td style="font-size: 10px;" class="@if($item->DRXM2 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM2 - $item->DRXM2) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM2 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM2 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM2 - $item->DRXM2) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM2 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM2 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM2 - $item->DRXM2) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM2 }}</td>
                        <td style="font-size: 10px;"><span style="color: {{$item->CM2}}"> {{ $item->EM2[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[2])
                            <td style="font-size: 10px;" class="@if($item->DRXM3 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM3 - $item->DRXM3) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM3 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;"><span style="color: {{$item->CM3}}"> {{ $item->EM3[0] }}</span></td>
                        <td style="font-size: 10px;" class="@if($item->DOM3 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM3 - $item->DRXM3) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM3 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM3 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM3 - $item->DRXM3) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM3 }}</td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[3])
                            <td style="font-size: 10px;" class="@if($item->DRXM4 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM4 - $item->DRXM4) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM4 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM4 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM4 - $item->DRXM4) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM4 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM4 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM4 - $item->DRXM4) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM4 }}</td>
                        <td style="font-size: 10px;"><span style="color: {{$item->CM4}}"> {{ $item->EM4[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[4])
                            <td style="font-size: 10px;" class="@if($item->DRXM5 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM5 - $item->DRXM5) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM5 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM5 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM5 - $item->DRXM5) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM5 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM5 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM5 - $item->DRXM5) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM5 }}</td>
                        <td style="font-size: 10px;"><span style="color: {{$item->CM5}}"> {{ $item->EM5[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[5])
                            <td style="font-size: 10px;" class="@if($item->DRXM6 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM6 - $item->DRXM6) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM6 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM6 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM6 - $item->DRXM6) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM6 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM6 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM6 - $item->DRXM6) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM6 }}</td>
                        <td style="font-size: 10px;"><span style="color: {{$item->CM6}}"> {{ $item->EM6[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[6])
                            <td style="font-size: 10px;" class="@if($item->DRXM7 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM7 - $item->DRXM7) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM7 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM7 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM7 - $item->DRXM7) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM7 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM7 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM7 - $item->DRXM7) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM7 }}</td>
                        <td style="font-size: 10px;"><span style="color: {{$item->CM7}}"> {{ $item->EM7[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[7])
                            <td style="font-size: 10px;" class="@if($item->DOM8 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM8 - $item->DRXM8) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM8 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM8 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM8 - $item->DRXM8) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM8 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DOM8 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM8 - $item->DRXM8) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM8 }}</td>
                        <td style="font-size: 10px;"><span style="color: {{$item->CM8}}"> {{ $item->EM8[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[8])
                            <td style="font-size: 10px;" class="@if($item->DRXM9 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM9 - $item->DRXM9) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM9 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM9 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM9 - $item->DRXM9) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM9 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM9 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM9 - $item->DRXM9) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM9 }}</td>
                        <td style="font-size: 10px;"><span style="color: {{$item->CM9}}"> {{ $item->EM9[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[9])
                            <td style="font-size: 10px;" class="@if($item->DRXM10 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM10 - $item->DRXM10) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM10 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM10 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM10 - $item->DRXM10) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM10 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM10 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM10 - $item->DRXM10) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM10 }}</td>
                        <td style="font-size: 10px;"><span style="color:{{$item->CM10}}"> {{ $item->EM10[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[10])
                            <td style="font-size: 10px;" class="@if($item->DRXM11 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM11 - $item->DRXM11) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM11 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM11 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM11 - $item->DRXM11) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM11 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM11 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM11 - $item->DRXM11) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM11 }}</td>
                        <td style="font-size: 10px;"><span style="color:{{$item->CM11}}"> {{ $item->EM11[0] }}</span></td>
                    @endif

                    @if ($cliente_sn)
                        @if ($months[11])
                            <td style="font-size: 10px;" class="@if($item->DRXM12 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM12 - $item->DRXM12) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM12 }}</td>
                        @else
                            <td style="font-size: 10px;" > - </td>
                        @endif
                    @else
                        <td style="font-size: 10px;" class="@if($item->DOM12 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM12 - $item->DRXM12) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DOM12 }}</td>
                        <td style="font-size: 10px;" class="@if($item->DRXM12 > $Max_Rx_Mensual->valor) maxRxMensual @endif  @if(abs($item->DOM12 - $item->DRXM12) > $Max_dif_op_rx->valor)  maxDifOpRx @endif">{{ $item->DRXM12 }}</td>
                        <td style="font-size: 10px;"><span style="color:{{$item->CM12}}"> {{ $item->EM12[0] }}</span></td>
                    @endif

                    @if (!$cliente_sn)
                        <td style="font-size: 10px;">{{ $item->ACUMULADO_OP }}</td>
                        <td style="font-size: 10px;">{{ $item->ACUMULADO_RX }}</td>
                    @endif
                </tr>
            @endforeach


            {{ $cantFilasTotal = count($resumen) }}
            {{ $filasPage = 40}}
            {{ $filasACompletar = pdfCantFilasACompletar($filasPage,$cantFilasTotal) }}

            @for ( $x=0 ;  $x < $filasACompletar ; $x++)
                <tr>
                    @if (!$cliente_sn)

                        @for ($c = 1; $c <= 41; $c++)

                            <td style="font-size: 10px;">&nbsp;</td>

                        @endfor

                    @else

                        @for ($c = 1; $c <= 15; $c++)

                            <td style="font-size: 10px;">&nbsp;</td>

                        @endfor

                    @endif

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
