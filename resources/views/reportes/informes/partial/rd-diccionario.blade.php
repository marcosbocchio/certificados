@php
    $dictionaryFontSize = $dictionaryFontSize ?? 9;
    $showObservaciones = $showObservaciones ?? true;
    $cellStyle = "font-size:{$dictionaryFontSize}px;border:1px solid #CBD5E1;padding:1px 4px;";
@endphp

<table width="100%" style="border-collapse: collapse;">
    <tbody>
        <tr>
            <td colspan="6" style="font-size:10px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;padding-bottom:2px;">Diccionario</td>
        </tr>
        <tr>
            <td style="{{ $cellStyle }}"><b>F:</b> Fisura</td>
            <td style="{{ $cellStyle }}"><b>FF:</b> Falta de fusion</td>
            <td style="{{ $cellStyle }}"><b>FP:</b> Falta de Penetraci&oacute;n</td>
            <td style="{{ $cellStyle }}"><b>FPD:</b> FP por Desalineaci&oacute;n</td>
            <td style="{{ $cellStyle }}"><b>FFP:</b> FF por Pasadas</td>
            <td style="{{ $cellStyle }}"><b>HL:</b> Desalineaci&oacute;n</td>
        </tr>
        <tr>
            <td style="{{ $cellStyle }}"><b>PE:</b> Penetraci&oacute;n Excesiva</td>
            <td style="{{ $cellStyle }}"><b>Q:</b> Quemaduras</td>
            <td style="{{ $cellStyle }}"><b>CI:</b> Concavidad Interna</td>
            <td style="{{ $cellStyle }}"><b>CE:</b> Concavidad Externa</td>
            <td style="{{ $cellStyle }}"><b>SI:</b> Socavado Interior</td>
            <td style="{{ $cellStyle }}"><b>SE:</b> Socavado Exterior</td>
        </tr>
        <tr>
            <td style="{{ $cellStyle }}"><b>ME:</b> Escoria Aislada</td>
            <td style="{{ $cellStyle }}"><b>MEL:</b> Escoria Lineal</td>
            <td style="{{ $cellStyle }}"><b>P:</b> Poros</td>
            <td style="{{ $cellStyle }}"><b>NP:</b> Nido de Poros</td>
            <td style="{{ $cellStyle }}"><b>PV:</b> Poro Vermicular</td>
            <td style="{{ $cellStyle }}"><b>CH:</b> Cord&oacute;n Hueco</td>
        </tr>
        <tr>
            <td style="{{ $cellStyle }}"><b>IT:</b> Inclusi&oacute;n de Tungsteno</td>
            <td style="{{ $cellStyle }}"><b>SA:</b> Salto de Arco</td>
            <td style="{{ $cellStyle }}"><b>AD:</b> Acumulaci&oacute;n de Discontinuidades</td>
            <td style="{{ $cellStyle }}"><b>DP:</b> Defecto de Placa</td>
            <td style="{{ $cellStyle }}"><b>RP:</b> Repetir Placa</td>
            <td style="{{ $cellStyle }}">&nbsp;</td>
        </tr>
        <tr>
            <td style="{{ $cellStyle }}"><b>MDC:</b> Material dentro del ca&ntilde;o</td>
            <td style="{{ $cellStyle }}"><b>R:</b> Raiz</td>
            <td style="{{ $cellStyle }}"><b>Y:</b> Relleno</td>
            <td style="{{ $cellStyle }}"><b>S:</b> Sobremonta</td>
            <td style="{{ $cellStyle }}"><b>AP:</b> Aprobado</td>
            <td style="{{ $cellStyle }}"><b>RZ:</b> Rechazado</td>
        </tr>
        <tr>
            <td style="{{ $cellStyle }}"><b>SNRn:</b> Relacion Se&ntilde;al Ruido Normalizada</td>
            <td style="{{ $cellStyle }}"><b>MNG:</b> Media Nivel de Gris</td>
            <td style="{{ $cellStyle }}"><b>SRB:</b> Resolucion Espacial Basica</td>
            <td style="{{ $cellStyle }}">&nbsp;</td>
            <td style="{{ $cellStyle }}">&nbsp;</td>
            <td style="{{ $cellStyle }}">&nbsp;</td>
        </tr>
        @if ($showObservaciones)
            <tr>
                <td colspan="6" style="{{ $cellStyle }}">
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
