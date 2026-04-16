@php
    $dictionaryFontSize = $dictionaryFontSize ?? 11;
    $showObservaciones = $showObservaciones ?? true;
@endphp

<table width="100%" style="border-collapse: collapse;">
    <tbody>
        <tr>
            <td colspan="6" style="font-size: 14px;"><strong>Diccionario</strong></td>
        </tr>
        <tr>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>F:</b> Fisura</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>FF:</b> Falta de fusion</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>FP:</b> Falta de Penetraci&oacute;n</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>FPD:</b> FP por Desalineaci&oacute;n</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>FFP:</b> FF por Pasadas</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>HL:</b> Desalineaci&oacute;n</td>
        </tr>
        <tr>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>PE:</b> Penetraci&oacute;n Excesiva</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>Q:</b> Quemaduras</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>CI:</b> Concavidad Interna</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>CE:</b> Concavidad Externa</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>SI:</b> Socavado Interior</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>SE:</b> Socavado Exterior</td>
        </tr>
        <tr>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>ME:</b> Escoria Aislada</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>MEL:</b> Escoria Lineal</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>P:</b> Poros</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>NP:</b> Nido de Poros</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>PV:</b> Poro Vermicular</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>CH:</b> Cord&oacute;n Hueco</td>
        </tr>
        <tr>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>IT:</b> Inclusi&oacute;n de Tungsteno</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>SA:</b> Salto de Arco</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>AD:</b> Acumulaci&oacute;n de Discontinuidades</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>DP:</b> Defecto de Placa</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>RP:</b> Repetir Placa</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>MDC:</b> Material dentro del ca&ntilde;o</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>R:</b> Raiz</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>Y:</b> Relleno</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>S:</b> Sobremonta</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>AP:</b> Aprobado</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>RZ:</b> Rechazado</td>
        </tr>
        <tr>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>SNRn:</b> Relacion Se&ntilde;al Ruido Normalizada</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>MNG:</b> Media Nivel de Gris</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td"><b>SRB:</b> Resolucion Espacial Basica</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td">&nbsp;</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td">&nbsp;</td>
            <td style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td">&nbsp;</td>
        </tr>
        @if ($showObservaciones)
            <tr>
                <td colspan="6" style="font-size: {{ $dictionaryFontSize }}px;" class="bordered-td">
                    <b>Observaciones:</b>
                    @if (!empty($informe->numero_offline))
                        Referencia: {{ $informe->numero_offline }} /
                    @endif
                    {{ $informe->observaciones }}
                </td>
            </tr>
        @endif
    </tbody>
</table>
