<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 343px 40px !important;
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
    @include('reportes.partial.header-cliente-comitente-portrait')
    @include('reportes.partial.linea-gris')
    @include('reportes.partial.header-proyecto-portrait')
    @include('reportes.partial.linea-amarilla')
</header>

<footer>
    @include('reportes.partial.linea-amarilla')

    @include('reportes.informes.partial.observaciones')

    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.rd-diccionario', ['dictionaryFontSize' => 9, 'showObservaciones' => false])

    @include('reportes.partial.linea-amarilla')

    @include('reportes.informes.partial.firmas')

</footer>


<main>
    @include('reportes.informes.partial.header-detalle-rd-portrait')

    @include('reportes.partial.linea-amarilla')

    @php
        $defectosPorPosicion = collect($defectos_posiciones)->groupBy('posicion_id');
        $formatIndicaciones = function ($posicionId) use ($defectosPorPosicion) {
            return $defectosPorPosicion->get($posicionId, collect())->map(function ($defecto) {
                if ($defecto->posicion) {
                    return $defecto->codigo . '(' . $defecto->posicion . ')';
                }

                return $defecto->codigo;
            })->filter()->implode('/');
        };
    @endphp

    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td colspan="8"><strong style="font-size: 14px;">Indicaciones</strong></td>
            </tr>

            <tr>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Elem.</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Cu&ntilde;o</td>
                <td style="font-size: 11px; text-align: center" colspan="3" class="bordered-td">Placa</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Indicaciones</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">Resultado</td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Posicion</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Mng</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">SNRn</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">AP</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">RZ</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($juntas_posiciones as $junta_posicion)
                <tr>
                    <td style="font-size: 11px; text-align: center" class="bordered-td">{{ $junta_posicion->junta }}</td>
                    <td style="font-size: 11px; text-align: center" class="bordered-td">
                        {{ $junta_posicion->soldadorz }}
                        @if ($junta_posicion->soldadorp)
                            / {{ $junta_posicion->soldadorp }}
                        @endif
                    </td>
                    <td style="font-size: 11px; text-align: center" class="bordered-td">{{ $junta_posicion->posicion }}</td>
                    <td style="font-size: 11px; text-align: center" class="bordered-td">{{ $junta_posicion->mng }}</td>
                    <td style="font-size: 11px; text-align: center" class="bordered-td">{{ $junta_posicion->snrn }}</td>
                    <td style="font-size: 9px;" class="bordered-td">{{ $formatIndicaciones($junta_posicion->posicion_id) }}</td>
                    <td style="font-size: 11px; text-align: center" class="bordered-td">
                        @if ($informe_rd->resultado_pdf_sn && $junta_posicion->aceptable_sn)
                            X
                        @endif
                    </td>
                    <td style="font-size: 11px; text-align: center" class="bordered-td">
                        @if ($informe_rd->resultado_pdf_sn && !$junta_posicion->aceptable_sn)
                            X
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('reportes.informes.partial.modelos3d-portrait')
</main>

    @include('reportes.partial.nro_pagina')

    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 518;
            $y = 78;
            $text = "RG.27 Rev.01";
            $font = $fontMetrics->get_font("serif", "normal");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);


        }

    </script>

</body>
</html>
