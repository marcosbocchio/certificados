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
    writing-mode: vertical-rl;
    transform: rotate(270deg); /* Si necesitas invertir la dirección */
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
#font4tobloque td{
    font-size:6pt;
}
#left p{
    margin-left:5px;
}
#alto td{
    height: 21mm;
    font-size: 6.6pt;
}
#alto_final td{
    height: 5.78mm;
    padding: 0px;
}
#alto_final p{
    margin: 0px;
    font-size:6.4pt;
}
#firmas td{
    height: 5mm;
    padding: 0px
}
#firmas p{
    margin: 0px 0px 0px 4px;
}
#resaltar-borde {
    border-right: 3px solid black;
}
footer {
        position: fixed;
        bottom: 100px;
        width: 100%;
        border: 3px solid black;
}
</style>

<body>

<main>
    @include('reportes.partial.header-sec1-especial')

    @if ($contratista && $contratista->reporte_especial_en_cliente == 1)
        @include('reportes.partial.header-proyecto-sect2')
    @endif      
   
    @include('reportes.informes.partial.header-detalle-ri-sect3')
    
    <table class="tablamain" style="width: 100%;">
        <tbody>
            <tr class="gris" style="font-size: 9.3px;">
                <td colspan="4" style="width: 16%;" id="resaltar-borde">Identificación de la/s Soldadura/s</td>
                <td colspan="5" style="width: 27%;" id="resaltar-borde">Soldadores según Proceso</td>
                <td colspan="10" style="width: 40%;" id="resaltar-borde">Indicaciones</td>
                <td colspan="2" style="width: 30%;">Resultados</td>
            </tr>
            <tr id="alto">
                <td style="width: 18mm;"><p>Nº de Soldadura</p></td>
                <td><p style="margin: 0mm -5mm;" class="vertical-text">Densidad</p></td>
                <td><p style="margin: 0mm -10mm;"class="vertical-text">Reparación</p></td>
                <td id="resaltar-borde" style="width: 8mm;"><p class="vertical-text" >Posición</p></td>
                <td><p style="margin: 0mm -6mm;" class="vertical-text">GTAW / SMAW</p></td>
                <td><p style="margin: 0mm -6mm;" class="vertical-text">GTAW</p></td>
                <td><p style="margin: 0mm -6mm;" class="vertical-text">SAW</p></td>
                <td><p style="margin: 0mm -6mm;" class="vertical-text">SMAW</p></td>
                <td id="resaltar-borde"><p style="margin: 0mm -6mm;" class="vertical-text" >FCAW</p></td>
                <td><p style="margin: 0mm -2mm;" class="vertical-text">Porosidad</p></td>
                <td><p style="margin: 0mm -5mm;" class="vertical-text">Inclusión de Escoria</p></td>
                <td><p style="margin: 0mm -8mm;" class="vertical-text">Inclusión de Tungsteno</p></td>
                <td><p style="margin: 0mm -5mm;" class="vertical-text">Falta de Penetración</p></td>
                <td><p style="margin: 0mm -5mm;" class="vertical-text">Falta de Fusión</p></td>
                <td><p style="margin: 0mm -5mm;" class="vertical-text">Socavación</p></td>
                <td><p style="margin: 0mm -5mm;" class="vertical-text">Concavidad</p></td>
                <td><p style="margin: 0mm -5mm;" class="vertical-text">Desalineación</p></td>
                <td><p style="margin: 0mm -1mm;" class="vertical-text">Fisuras</p></td>
                <td id="resaltar-borde"><p style="margin: 0mm -3mm;" class="vertical-text" >Película Defectuosa</p></td>
                <td style="width: 5mm;"><p style="margin: 0mm -25mm;" class="vertical-text">Resultado</p></td>
                <td><p style="width: 25.5mm;">Ubicación de los defectos a reparar</p></td>
            </tr>

            @php
            $filas_por_hoja = ($contratista && $contratista->reporte_especial_en_cliente == 1) ? 21 : 25;
            $contadorFilas = 0;
            @endphp

@foreach ($juntas_posiciones as $junta_posicion)

    @php 
        $contadorFilas++;
        $datosAgrupados = collect($juntas_posiciones_procesos)->groupBy('codigo');
        $procesoInfo = $datosAgrupados->get($junta_posicion->junta);
    @endphp

    <tr id="alto_final">
        <td><p>{{ $junta_posicion->junta ?? '' }}</p></td>
        <td><p>{{ $junta_posicion->densidad ?? '' }}</p></td>
        <td><p>@if ($informe_ri->reparacion_sn == 1) x @endif</p></td>
        <td id="resaltar-borde"><p>{{ $junta_posicion->posicion ?? '' }}</p></td>
        @if ($procesoInfo)
        <td>
            @foreach ($procesoInfo->where('proceso_soldadores', 'GMAW') as $dato)
                @if ($dato->soldadorz || $dato->soldadorp)
                    <p>{{ $dato->soldadorz ?? '' }}<br>{{ $dato->soldadorp ?? '' }}</p>
                @else
                    <p>&nbsp;</p>
                @endif
            @endforeach
        </td>
        <td>
            @foreach ($procesoInfo->where('proceso_soldadores', 'GTAW') as $dato)
                @if ($dato->soldadorz || $dato->soldadorp)
                <p>
                    {{ $dato->soldadorz ?? '' }}<br>
                    {{ $dato->soldadorp ?? '' }}
                </p>
                @else
                    <p>&nbsp;</p>
                @endif
            @endforeach
        </td>
        <td>
            @foreach ($procesoInfo->where('proceso_soldadores', 'SAW') as $dato)
                @if ($dato->soldadorz || $dato->soldadorp)
                    <p>{{ $dato->soldadorz ?? '' }}<br>{{ $dato->soldadorp ?? '' }}</p>
                @else
                    <p>&nbsp;</p>
                @endif
            @endforeach
        </td>
        <td>
            @foreach ($procesoInfo->where('proceso_soldadores', 'SMAW') as $dato)
                @if ($dato->soldadorz || $dato->soldadorp)
                    <p>{{ $dato->soldadorz ?? '' }}<br>{{ $dato->soldadorp ?? '' }}</p>
                @else
                    <p>&nbsp;</p>
                @endif
            @endforeach
        </td>
        <td id="resaltar-borde">
            @foreach ($procesoInfo->where('proceso_soldadores', 'FCAW') as $dato)
                @if ($dato->soldadorz || $dato->soldadorp)
                    <p>{{ $dato->soldadorz ?? '' }}<br>{{ $dato->soldadorp ?? '' }}</p>
                @else
                    <p>&nbsp;</p>
                @endif
            @endforeach
        </td>
        @else
            {{-- Si no hay información de proceso, mostrar celdas vacías --}}
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td><p>&nbsp;</p></td>
            <td id="resaltar-borde"><p>&nbsp;</p></td>
        @endif

                        @php
                            $porosidad = null;
                            $inclusionEscoria = null;
                            $inclusionTungsteno = null;
                            $faltaPenetracion = null;
                            $faltaFusion = null;
                            $socavacion = null;
                            $concavidad = null;
                            $desalineacion = null;
                            $fisuras = null;
                            $peliculaDefectuosa = null;
                            $Ubicacióndefectos = ["-"];
                        @endphp

                        @foreach ($defectos_posiciones as $defecto)
                            @if ($defecto->posicion_id === $junta_posicion->posicion_id)
                                @if ($defecto->defecto_Esp === 'Porosidad')
                                    @php $porosidad = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Inclusión de Escoria')
                                    @php $inclusionEscoria = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Inclusión de Tungsteno')
                                    @php $inclusionTungsteno = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Falta de Penetración')
                                    @php $faltaPenetracion = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Falta de Fusión')
                                    @php $faltaFusion = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Socavación')
                                    @php $socavacion = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Concavidad')
                                    @php $concavidad = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Desalineación')
                                    @php $desalineacion = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Fisuras')
                                    @php $fisuras = 'x'; @endphp
                                @elseif ($defecto->defecto_Esp === 'Película Defectuosa')
                                    @php $peliculaDefectuosa = 'x'; @endphp
                                @endif
                                @if ($defecto->defecto_Esp !== null)
                                    @php
                                        $posicion = $defecto->posicion ?: '-';
                                        $UbicacionDefecto[] = $posicion;
                                    @endphp
                                @endif 
                            @endif
                        @endforeach

                        <!-- Fuera del foreach -->
                        <td>
                            <p>{{ $porosidad }}</p>
                        </td>
                        <td>
                            <p>{{ $inclusionEscoria }}</p>
                        </td>
                        <td>
                            <p>{{ $inclusionTungsteno }}</p>
                        </td>
                        <td>
                            <p>{{ $faltaPenetracion }}</p>
                        </td>
                        <td>
                            <p>{{ $faltaFusion }}</p>
                        </td>
                        <td>
                            <p>{{ $socavacion }}</p>
                        </td>
                        <td>
                            <p>{{ $concavidad }}</p>
                        </td>
                        <td>
                            <p>{{ $desalineacion }}</p>
                        </td>
                        <td>
                            <p>{{ $fisuras }}</p>
                        </td>
                        <td id="resaltar-borde">
                            <p>{{ $peliculaDefectuosa }}</p>
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
                        @if (isset($UbicacionDefecto) && !empty($UbicacionDefecto))
                            <td>
                                <p>{{ implode(' / ', $UbicacionDefecto) }}</p>
                            </td>
                        @else
                            <td>
                                <p>&nbsp;</p>
                            </td>
                        @endif
                        @php
                            $porosidad = null;
                            $inclusionEscoria = null;
                            $inclusionTungsteno = null;
                            $faltaPenetracion = null;
                            $faltaFusion = null;
                            $socavacion = null;
                            $concavidad = null;
                            $desalineacion = null;
                            $fisuras = null;
                            $peliculaDefectuosa = null;
                            $UbicacionDefecto = [];                        
                        @endphp
                </tr>
                <!-- Insertar salto de página después de 21 filas y reiniciar el contador -->
                @if ($contadorFilas == $filas_por_hoja)
                    </tbody>
                    </table>
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
                                    @if($planta)
                                        planta {{$planta->nombre}}
                                    @endif
                                        &nbsp;
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
                                <td style="width: 43mm;">
                                    @if($contratista->nombre === 'ENOD')
                                        Evaluador ENOD
                                    @else
                                        Evaluador AESA
                                    @endif
                                </td>
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
                    @php $contadorFilas = 0; @endphp
                    <div class="page-break"></div>
                    @include('reportes.partial.header-sec1-especial')

                    @if ($contratista && $contratista->reporte_especial_en_cliente == 1)
                        @include('reportes.partial.header-proyecto-sect2')
                    @endif      
                
                    @include('reportes.informes.partial.header-detalle-ri-sect3')   
                    <table class="tablamain">
                        <tbody>
                        <tr class="gris" style="font-size: 9.3px;">
                            <td colspan="4" style="width: 16%;" id="resaltar-borde">Identificación de la/s Soldadura/s</td>
                            <td colspan="5" style="width: 27%;" id="resaltar-borde">Soldadores según Proceso</td>
                            <td colspan="10" style="width: 40%;" id="resaltar-borde">Indicaciones</td>
                            <td colspan="2" style="width: 30%;">Resultados</td>
                        </tr>
                        <tr id="alto">
                            <td style="width: 18mm;"><p>Nº de Soldadura</p></td>
                            <td><p style="margin: 0mm -5mm;" class="vertical-text">Densidad</p></td>
                            <td><p style="margin: 0mm -10mm;"class="vertical-text">Reparación</p></td>
                            <td id="resaltar-borde" style="width: 8mm;"><p class="vertical-text" >Posición</p></td>
                            <td><p style="margin: 0mm -6mm;" class="vertical-text">GTAW / SMAW</p></td>
                            <td><p style="margin: 0mm -6mm;" class="vertical-text">GTAW</p></td>
                            <td><p style="margin: 0mm -6mm;" class="vertical-text">SAW</p></td>
                            <td><p style="margin: 0mm -6mm;" class="vertical-text">SMAW</p></td>
                            <td id="resaltar-borde"><p style="margin: 0mm -6mm;" class="vertical-text" >FCAW</p></td>
                            <td><p style="margin: 0mm -2mm;" class="vertical-text">Porosidad</p></td>
                            <td><p style="margin: 0mm -5mm;" class="vertical-text">Inclusión de Escoria</p></td>
                            <td><p style="margin: 0mm -8mm;" class="vertical-text">Inclusión de Tungsteno</p></td>
                            <td><p style="margin: 0mm -5mm;" class="vertical-text">Falta de Penetración</p></td>
                            <td><p style="margin: 0mm -5mm;" class="vertical-text">Falta de Fusión</p></td>
                            <td><p style="margin: 0mm -5mm;" class="vertical-text">Socavación</p></td>
                            <td><p style="margin: 0mm -5mm;" class="vertical-text">Concavidad</p></td>
                            <td><p style="margin: 0mm -5mm;" class="vertical-text">Desalineación</p></td>
                            <td><p style="margin: 0mm -1mm;" class="vertical-text">Fisuras</p></td>
                            <td id="resaltar-borde"><p style="margin: 0mm -3mm;" class="vertical-text" >Película Defectuosa</p></td>
                            <td style="width: 5mm;"><p style="margin: 0mm -25mm;" class="vertical-text">Resultado</p></td>
                            <td><p style="width: 25.5mm;">Ubicación de los defectos a reparar</p></td>
                        </tr>
                    @php $contadorFilas = 0; @endphp
                @endif
                @endforeach

                @php
                    $filas_vacias = $filas_por_hoja - $contadorFilas;
                @endphp
                @for ($i = 0; $i < $filas_vacias; $i++)
                    <tr id="alto_final">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td id="resaltar-borde">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td id="resaltar-borde">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td id="resaltar-borde">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
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
                @if($planta)
                    planta {{$planta->nombre}}
                @endif
                    &nbsp;
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
            <td style="width: 43mm;">
                @if($contratista->nombre === 'ENOD')
                    Evaluador ENOD
                @else
                    Evaluador AESA
                @endif
            </td>
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


</body>
</html>
