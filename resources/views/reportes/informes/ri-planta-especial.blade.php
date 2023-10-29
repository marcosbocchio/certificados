<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>
body{
    font-family: "Encode Sans",Arial,sans-serif;

}
main{
    border: 3px solid black;

}
footer {
    border: 3px solid black;
    margin-top:20px;
}
.logo{
    width: 30%;
}
.logo img{
    height: 60px;
}
.tablamain{
        font-size: 7pt;
        border-collapse: collapse;
        width: 100%;
}
.tablamain td {
        border: 1.2px solid black;
        text-align: center;
        padding: 0px 0px 0px 0px;
}
.tablamain .gris{
        background-color: #D9D9D9;
}
.tablamain .celda-corta {
        width: 25%;
}
.tablamain .celda-larga {
        width: 75%;
}
.vertical-text {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    margin: 0;
    padding: 0;
}
.fecha_firma ._1{
    width: 30%;
}
.fecha_firma ._2{

    width: 70%;
}
#fecha_h{
    height: 6mm;
}
#qr{
    font-size: 8.80pt;
    width: 22mm;
    height: 22mm;
}
#left{
    text-align:left;
    margin-left:2px;
}
#left p{
    margin-left:5px;
}
#alto td{
    height: 21mm;
    font-size: 9px;
}
#alto_final td{
    height: 4.5mm;
    padding:0px
}
#alto_final p{
    margin: 0px;
}
#firmas td{
    height: 5mm;
    padding: 0px
}
#firmas p{
    margin: 0px 0px 0px 4px;
}
footer {
        position: fixed;
        bottom: 100px;
        width: 100%;
}
</style>

<body>

<main>
    @include('reportes.partial.header-sec1-especial')    
    @include('reportes.partial.header-proyecto-sect2')
    @include('reportes.informes.partial.header-detalle-ri-sect3')
    @include('reportes.informes.partial.modelos3d-portrait')
    <table class="tablamain">
        <tbody>
            <tr class="gris" style="font-size: 9.3px;">
                <td colspan="4" style="width: 30mm;">Identificación de la/s Soldadura/s</td>
                <td colspan="3" style="width: 33mm;">Soldadores según Proceso</td>
                <td colspan="10" style="width: 59mm;">Indicaciones</td>
                <td colspan="2" style="width: 25mm;">Resultados</td>
            </tr>
            <tr id="alto">
                <td><p style="width: 20mm;">Nº de Soldadura</p></td>
                <td><p style="margin: 0 -6mm;" class="vertical-text">Densidad</p></td>
                <td><p style="margin: 0 -8mm;" class="vertical-text">Reparación</p></td>
                <td><p style="margin: 0 -6mm;" class="vertical-text">Posición</p></td>
                <td><p style="margin: 0 -3mm;" class="vertical-text">GTAW</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">SMAW</p></td>
                <td><p style="margin: 0 -3mm;" class="vertical-text">SAW</p></td>
                <td><p style="margin: 0 -2mm;" class="vertical-text">Porosidad</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Inclusión de Escoria</p></td>
                <td><p style="margin: 0 -8mm;" class="vertical-text">Inclusión de Tungsteno</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Falta de Penetración</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Falta de Fusión</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Socavación</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Concavidad</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Desalineación</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Fisuras</p></td>
                <td><p style="margin: 0 -5mm;" class="vertical-text">Película Defectuosa</p></td>
                <td><p style="margin: 0 -10mm;" class="vertical-text">Resultado</p></td>
                <td><p style="width: 35mm;">Ubicación de los defectos a reparar</p></td>
            </tr>
            @for ($i = 1; $i <= 26; $i++)
            @php
                $junta_posicion = isset($juntas_posiciones[$i - 1]) ? $juntas_posiciones[$i - 1] : null;
                $defectoEspecial = !empty($defectos_posiciones[$i - 1]) ? $defectos_posiciones[$i - 1]->defecto_Esp : null;
            @endphp
                <tr id="alto_final">
                    <td>
                        <p>{{ $junta_posicion ? $junta_posicion->junta : '' }}</p>
                    </td>
                    <td>
                        <p>{{ $junta_posicion ? $junta_posicion->densidad : '' }}</p>
                    </td>
                    <td>
                        <p>    
                        @if ($informe_ri->reparacion_sn == 1)
                            x
                        @endif
                        </p>
                    </td>
                    <td>
                        <p>{{ $junta_posicion ? $junta_posicion->posicion : '' }}</p>
                    </td>
                    @if ($informe_ri->proceso_soldadores !== null)
                        <td>
                            @if ($informe_ri->proceso_soldadores === 'GTAW')
                                <p>
                                    @if ($junta_posicion && $junta_posicion->soldadorz !== null)
                                        {{ $junta_posicion->soldadorz }}
                                    @endif
                                    @if ($junta_posicion && $junta_posicion->soldadorl !== null)
                                        {{ $junta_posicion->soldadorl }}
                                    @endif
                                    @if ($junta_posicion && $junta_posicion->soldadorp !== null)
                                        {{ $junta_posicion->soldadorp }}
                                    @endif
                                </p>
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td>
                            @if ($informe_ri->proceso_soldadores === 'SMAW')
                                <p>
                                    @if ($junta_posicion && $junta_posicion->soldadorz !== null)
                                        {{ $junta_posicion->soldadorz }}
                                    @endif
                                    @if ($junta_posicion && $junta_posicion->soldadorl !== null)
                                        {{ $junta_posicion->soldadorl }}
                                    @endif
                                    @if ($junta_posicion && $junta_posicion->soldadorp !== null)
                                        {{ $junta_posicion->soldadorp }}
                                    @endif
                                </p>
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td>
                            @if ($informe_ri->proceso_soldadores === 'SAW')
                                <p>
                                    @if ($junta_posicion && $junta_posicion->soldadorz !== null)
                                        {{ $junta_posicion->soldadorz }}
                                    @endif
                                    @if ($junta_posicion && $junta_posicion->soldadorl !== null)
                                        {{ $junta_posicion->soldadorl }}
                                    @endif
                                    @if ($junta_posicion && $junta_posicion->soldadorp !== null)
                                        {{ $junta_posicion->soldadorp }}
                                    @endif
                                </p>
                            @else
                            &nbsp;
                            @endif
                        </td>
                    @else
                        <td>
                            <p>
                                &nbsp;
                            </p>
                        </td>
                        <td>
                            <p>
                                &nbsp;
                            </p>
                        </td>
                        <td>
                            <p>
                                &nbsp;
                            </p>
                        </td>
                    @endif
                    <!-- Porosidad -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Porosidad')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Inclusión de Escoria -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Inclusión de Escoria')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Inclusión de Tungsteno -->
                        <td>
                            <p>
                            @if (!empty($defectoEspecial) && $defectoEspecial === 'Inclusión de Tungsteno')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Falta de Penetración -->
                        <td>
                            <p>
                            @if (!empty($defectoEspecial) && $defectoEspecial === 'Falta de Penetración')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Falta de Fusión -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Falta de Fusión')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Socavación -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Socavación')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Concavidad -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Concavidad')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Desalineación -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Desalineación')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Fisuras -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Fisuras')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>

                        <!-- Película Defectuosa -->
                        <td>
                            <p>
                                @if (!empty($defectoEspecial) && $defectoEspecial === 'Película Defectuosa')
                                    x
                                @else
                                    &nbsp;
                                @endif
                            </p>
                        </td>
                        <td>
                            <p>
                                @if ($junta_posicion && $informe_ri->resultado_pdf_sn)
                                    @if ($junta_posicion->aceptable_sn)
                                        A
                                    @else
                                        RZ
                                    @endif
                                @else
                                    &nbsp;
                                @endif  
                            </p>
                        </td>
                        <td>
                            <p>&nbsp;</p>
                        </td>
                </tr>
            @endfor
        </tbody>
    </table>
</main>
<footer>
    <table class="tablamain">
        <tbody>
            <tr class="gris">
                <td colspan="2" id="left">Observaciones / notas: </td>
                <td style="width: 40mm;">Código de Abreviaturas</td>
            </tr>
            <tr>
                <td style="width: 97mm;">
                    @if($informe->numero_offline)
                        Referencia : {{ $informe->numero_offline}} /
                    @endif
                    {{$observaciones}}
                </td>
                <td style="width: 43mm;">
                    <p>planta</p>
                </td>
                <td id="left" style="width: 41mm;">
                    <b>A:</b>
                    Aceptable<br>
                    <b>Rz:</b>
                    Reparar<br>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="tablamain" >
        <tbody>
            <tr class="gris">
                <td style="width: 43mm;" >Evaluador AESA</td>
                <td style="width: 40mm;" >Inspector de AESA</td>
                <td style="width: 50mm;" >Inspector del Cliente</td>
                <td style="width: 48mm;" >Inspector Autorizado</td>
            </tr>
            <tr id="firmas">
                <td id="left"><p>Firma:</p></td>
                <td id="left"><p>Firma:</p></td>
                <td id="left"><p>Firma:</p></td>
                <td id="left"><p>Firma:</p></td>
            </tr>
            <tr id="firmas">
                <td>
                    <table class="tablamain">
                        <tbody>
                            <tr>
                                <td id="left" style="width: 10%;"><p>Fecha:</p></td>
                                <td ><p>{{ $fecha }}</p></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td id="left"><p>Fecha:</p></td>
                <td id="left"><p>Fecha:</p></td>
                <td id="left"><p>Fecha:</p></td>
            </tr>
            <tr>
                <td colspan="4" >&nbsp;</td>
            </tr>
        </tbody>
    </table>
</footer>
    
<script type="text/php">

    if ( isset($pdf) ) {
        $x = 520;
        $y = 810;
        $text = "Pagina {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif");
        $size = 7;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        $x = 500;
        $y = 10;
        $text = "AESA - Pública";
        $font = $fontMetrics->get_font("serif");
        $size = 8.80;
        $color = array(0, 0, 0);
        $pdf->page_text($x, $y, $text, $font, $size, $color);
    }

</script>

</body>
</html>
