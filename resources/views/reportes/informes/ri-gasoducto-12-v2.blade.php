<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>
    @page {
        margin: 240px 40px 270px 40px !important;
        padding: 0px 0px 0px 0px !important;
    }

    header {
        position: fixed;
        top: -230px;
    }

    footer {
        position: fixed;
        bottom: 0px;
        padding-top: 0px;
    }

    .page-break {
        page-break-before: always;
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

        <table width="100%" style="border-collapse: collapse;margin-bottom: -10px;"" >
        <tbody>
            <tr>
                <td colspan="6" style="font-size:10px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;padding-bottom:2px;"><strong>Diccionario</strong></td>
            </tr>
            <tr>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>F: </b>Fisura</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>FF: </b>Falta de fusion</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>FP: </b>Falta de Penetración</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>FPD: </b>FP por Desalineación</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>FFP: </b>FF por Pasadas</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>HL: </b>Desalineación</td>
            </tr>
            <tr>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>PE: </b>Penetración Excesiva</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>Q: </b>Quemaduras</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>CI: </b>Concavidad Interna</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>CE: </b>Concavidad Externa</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>SI: </b>Socavado Interior</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>SE: </b>Socavado Exterior</td>
            </tr>
            <tr>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>ME: </b>Escoria Aislada</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>MEL: </b>Escoria Lineal</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>P: </b>Poros</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>NP: </b>Nido de Poros</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>PV: </b>Poro Vermicular</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>CH: </b>Cordón Hueco</td>
            </tr>
            <tr>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>IT: </b>Inclusión de Tungteno</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>SA: </b>Salto de Arco</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;" colspan="2"><b>AD: </b>Acumulación de Discontinuidades</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>DP: </b>Defecto de Placa</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>RP: </b>Repetir Placa</td>
            </tr>
            <tr>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>MDC: </b>Material dentro del caño</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>R: </b>Raiz</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>Y: </b>Relleno</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>S: </b>Sobremonta</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>AP: </b>Aprobado</td>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;"><b>RZ: </b>Rechazado</td>
            </tr>
            <tr>
                <td style="font-size:9px;border:1px solid #CBD5E1;padding:1px 4px;" colspan="6"><b>Observaciones: </b>
                    @if($informe->numero_offline)
                    Referencia : {{ $informe->numero_offline}} /
                    @endif
                    {{$informe->observaciones}}
                </td>
            </tr>
            </tbody>
        </table>

        <div style="margin-bottom: -60px;">
            @include('reportes.partial.linea-amarilla')
        </div>
        <div style="margin-top: -20px;">
            @include('reportes.informes.partial.firmas')
        </div>
    </footer>


    <main>
        @include('reportes.informes.partial.header-detalle-ri-landscope')

        {{-- Agrupar las juntas en bloques de 4 --}}
        @foreach ($juntas_posiciones->chunk(4) as $bloque)
        <table width="100%" style="border-collapse: collapse; page-break-inside: avoid; margin-bottom: 15px;">
            <thead>
                <tr>
                    <td colspan="22"><strong style="font-size: 14px;">Indicaciones</strong></td>
                </tr>
                <tr>
                    <td style="font-size: 11px; text-align: center;" colspan="3" rowspan="1" class="bordered-td">Junta</td>
                    <td style="font-size: 11px; text-align: center;" colspan="13" rowspan="1" class="bordered-td">Cuño</td>
                    <td style="font-size: 11px; text-align: center;" colspan="2" rowspan="1" class="bordered-td">Placa</td>
                    <td style="font-size: 11px; text-align: center;" colspan="2" rowspan="1" class="bordered-td">Indicaciones</td>
                    <td style="font-size: 11px; text-align: center;" colspan="2" rowspan="1" class="bordered-td">Resultados</td>
                </tr>
                <tr>
                    <td style="font-size: 11px; text-align: center;" class="bordered-td">Pk</td>
                    <td style="font-size: 11px; text-align: center;" class="bordered-td">Elem.</td>
                    <td style="font-size: 11px; text-align: center;" class="bordered-td">Tipo</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">L</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">P</td>
                    <td style="font-size: 11px; width:28px;  text-align: center;" class="bordered-td">Z</td>
                    <td style="font-size: 11px;  text-align: center;" class="bordered-td">Posición</td>
                    <td style="font-size: 11px;  text-align: center;" class="bordered-td"><span class="EspecialCaracter">ρ</span></td>
                    <td style="font-size: 11px;  text-align: center;" class="bordered-td">Tipo</td>
                    <td style="font-size: 11px;  text-align: center;" class="bordered-td">Posición</td>
                    <td style="font-size: 11px;  text-align: center;" class="bordered-td">AP</td>
                    <td style="font-size: 11px;  text-align: center;" class="bordered-td">RZ</td>
                </tr>
            </thead>
            <tbody>
                {{-- Renderizar hasta 4 juntas completas --}}
                @foreach ($bloque as $junta_posiciones)

                @include('reportes.informes.partial.junta-completa-v12', [
                'junta_posiciones' => $junta_posiciones,
                'pasadas_juntas' => $pasadas_juntas,
                'defectos_posiciones' => $defectos_posiciones,
                'informe_ri' => $informe_ri,
                'informe' => $informe,
                'ot_tipo_soldadura' => $ot_tipo_soldadura
                ])

                @endforeach
            </tbody>
        </table>
        @endforeach

        <div style="page-break-inside: avoid;">
            @include('reportes.informes.partial.modelos3d-landscope')
        </div>
    </main>


    <script type="text/php">

        if ( isset($pdf) ) {
            $x = 755;
            $y = 12;
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
