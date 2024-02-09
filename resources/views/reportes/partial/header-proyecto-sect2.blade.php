<style>
    .col1 {
        width: 34.2mm;
    }
    .col1 b{
        padding-left:1px;
    }
    .col2 {
        width: 36mm;
    }
    .col3{
        width: 56mm;
    }
    .col3 b{
        padding-left:1px;
    }
</style>

<table class="tablamain" style="height: 20mm;">
    <tbody>
        <tr>
            <td class="col1" id="left"><b>PROYECTO:</b></td>
            <td colspan="3"><span class="datosHead">{{$ot->proyecto}}</span></td>
            <td rowspan="5" id="qr"><b>CODIGO QR</b></td>
        </tr>
        <tr>
            <td id="left" class="col1"><b>CONTRATISTA</b></td>
            <td colspan="3">
                AESA
            </td>
        </tr>
        <tr>
            <td class="col1" id="left"><b>SISTEMA / SUBSIST.:</b></td>
            <td class="col2">&nbsp;</td>
            <td class="col1" id="left"><b>PIE / N° ACTIVIDAD:</b></td>
            <td class="col3">RLC-NCB-CA-PIE-PI-001 R0 / RT: 4.4/4.9</td>
        </tr>
        <tr class="fila-4">
            <td class="col1" id="left"><b>ELEMENTO</b></td>
            <td class="col2">&nbsp;</td>
            <td class="col1" id="left"><b>TIPO DE INSPECCION:</b></td>
            <td class="col3">W/W</td>
        </tr>
        <tr class="fila-5">
            <td class="col1" id="left"><b>PAQ. DE PRUEBA:</b></td>
            <td class="col2">&nbsp;</td>
            <td class="col1" id="left"><b>N° REPORTE / RFI:</b></td>
            <td class="col3">{{$informe_ri->N_Reporte_RFI}}</td>
        </tr>
    </tbody>
</table>