<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>

    @page {
        margin: 240px 40px 255px 40px !important;
        padding: 0px 0px 0px 0px !important;
    }

header {
    position:fixed;
    top: -230px;
}

footer {
    position: fixed; bottom:0px;
    padding-top: 0px;
}

</style>

<body>
<header>
    @include('reportes.partial.header-principal-landscape')
    @include('reportes.partial.linea-amarilla')
    @include('reportes.partial.header-cliente-comitente-landscape')
    @include('reportes.partial.linea-gris')
    @include('reportes.partial.header-proyecto-landscape')
    @include('reportes.partial.linea-amarilla')
</header>
<footer>

    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.rd-diccionario', ['dictionaryFontSize' => 11, 'showObservaciones' => true])
    @include('reportes.partial.linea-amarilla')
    @include('reportes.informes.partial.firmas')
</footer>


<main>
    @include('reportes.informes.partial.header-detalle-rd-landscope')

    @php
        $pasadasPorJunta = collect($pasadas_juntas)->groupBy('junta_id');
        $defectosPorPosicion = collect($defectos_posiciones)->groupBy('posicion_id');
        $getPasada = function ($juntaId, $numero) use ($pasadasPorJunta) {
            return optional($pasadasPorJunta->get($juntaId, collect())->first(function ($pasada) use ($numero) {
                return (int) $pasada->numero === (int) $numero;
            }));
        };
        $formatTipos = function ($posicionId) use ($defectosPorPosicion) {
            return $defectosPorPosicion->get($posicionId, collect())->pluck('codigo')->filter()->implode('/');
        };
        $formatUbicaciones = function ($posicionId) use ($defectosPorPosicion) {
            return $defectosPorPosicion->get($posicionId, collect())->map(function ($defecto) {
                if (!$defecto->pasada) {
                    return null;
                }

                if ($defecto->pasada == 'RAIZ') {
                    $sector = 'R';
                } elseif ($defecto->pasada == 'RELLENO') {
                    $sector = 'Y';
                } elseif ($defecto->pasada == 'SOBREMONTA') {
                    $sector = 'S';
                } else {
                    $sector = '';
                }

                return $defecto->codigo . '(' . $defecto->posicion . ')' . $sector;
            })->filter()->implode('/');
        };
    @endphp

    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <td colspan="23"><strong style="font-size: 14px;">Indicaciones</strong></td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center" colspan="3" class="bordered-td">Junta</td>
                <td style="font-size: 11px; text-align: center" colspan="13" class="bordered-td">Cu&ntilde;o</td>
                <td style="font-size: 11px; text-align: center" colspan="3" class="bordered-td">Placa</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">Indicaciones</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">Resultados</td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Pk</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Elem.</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Tipo</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">L</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">P</td>
                <td style="font-size: 11px; text-align: center" class="bordered-td">Z</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Posicion</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Mng</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">SNRn</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Tipo</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">Posicion</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">AP</td>
                <td style="font-size: 11px; text-align: center" rowspan="2" class="bordered-td">RZ</td>
            </tr>
            <tr>
                <td style="font-size: 11px; text-align: center" colspan="3" class="bordered-td">1&deg; Pasada</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">2&deg; Pasada</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">3&deg; Pasada</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">4&deg; Pasada</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">5&deg; Pasada</td>
                <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">6&deg; Pasada</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($juntas_posiciones as $junta_posicion)
                <tr>
                    <td style="font-size: 10px; text-align: center" rowspan="3" class="bordered-td">{{ $informe->km ?: '' }}</td>
                    <td style="font-size: 10px; text-align: center" rowspan="3" class="bordered-td">{{ $junta_posicion->junta }}</td>
                    <td style="font-size: 10px; text-align: center" rowspan="3" class="bordered-td">{{ $ot_tipo_soldadura->TipoSoldadura->codigo }}</td>

                    @for ($numero = 1; $numero <= 6; $numero++)
                        @php
                            $pasada = $getPasada($junta_posicion->id, $numero);
                            $campos = $numero === 1 ? ['soldadorp', 'soldadorl', 'soldadorz'] : ['soldadorp', 'soldadorz'];
                        @endphp
                        @foreach ($campos as $campo)
                            <td style="font-size: 9px; text-align: center" class="bordered-td">{{ $pasada->$campo ?? '' }}</td>
                        @endforeach
                    @endfor

                    <td style="font-size: 9px; text-align: center" rowspan="3" class="bordered-td">{{ $junta_posicion->codigo }}</td>
                    <td style="font-size: 9px; text-align: center" rowspan="3" class="bordered-td">{{ $junta_posicion->mng !== null ? intval($junta_posicion->mng) : '' }}</td>
                    <td style="font-size: 9px; text-align: center" rowspan="3" class="bordered-td">{{ $junta_posicion->snrn !== null ? intval($junta_posicion->snrn) : '' }}</td>
                    <td style="font-size: 9px; text-align: center" rowspan="3" class="bordered-td">{{ $formatTipos($junta_posicion->posicion_id) }}</td>
                    <td style="font-size: 9px; text-align: center" rowspan="3" class="bordered-td">{{ $formatUbicaciones($junta_posicion->posicion_id) }}</td>
                    <td style="font-size: 9px; text-align: center" rowspan="3" class="bordered-td">
                        @if ($junta_posicion->aceptable_sn)
                            X
                        @endif
                    </td>
                    <td style="font-size: 9px; text-align: center" rowspan="3" class="bordered-td">
                        @if (!$junta_posicion->aceptable_sn)
                            X
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 11px; text-align: center" colspan="3" class="bordered-td">7&deg; Pasada</td>
                    <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">8&deg; Pasada</td>
                    <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">9&deg; Pasada</td>
                    <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">10&deg; Pasada</td>
                    <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">11&deg; Pasada</td>
                    <td style="font-size: 11px; text-align: center" colspan="2" class="bordered-td">12&deg; Pasada</td>
                </tr>
                <tr>
                    @for ($numero = 7; $numero <= 12; $numero++)
                        @php
                            $pasada = $getPasada($junta_posicion->id, $numero);
                            $campos = $numero === 7 ? ['soldadorp', 'soldadorl', 'soldadorz'] : ['soldadorp', 'soldadorz'];
                        @endphp
                        @foreach ($campos as $campo)
                            <td style="font-size: 9px; text-align: center" class="bordered-td">{{ $pasada->$campo ?? '' }}</td>
                        @endforeach
                    @endfor
                </tr>
            @endforeach

        </tbody>
    </table>

    @include('reportes.informes.partial.modelos3d-landscope')

</main>

    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 666;
            $y = 60;
            $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
            $font = $fontMetrics->get_font("serif", "bold");
            $size = 9;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        /*    $pdf->line(44,180,819,180,array(0,0,0),1.5);  */
        }

    </script>

    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 764;
            $y = 70;
            $text = "RG.27 Rev.02";
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
