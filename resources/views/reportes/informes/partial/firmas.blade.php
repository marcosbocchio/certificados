<table width="100%">
    <tbody>
        <tr>
            <td style="font-size: 13px;" colspan="1"  rowspan="2"><b>Firmas </b></td>
            <td style="font-size: 13px;text-align: center;height: 90px;" colspan="2" width="33.33%">
                @if($firma)
                    <img src="{{ public_path($firma) }}" alt="" style="width: 180px;height: 90px;">
                @endif
            </td>
            <td style="font-size: 13px;" colspan="2"  width="33.33%">&nbsp;</td>
            <td style="font-size: 13px;" colspan="2" width="33.33%">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 14px; text-align: center;" colspan="2"><em>Evaluador </em></td>
            <td style="font-size: 14px; text-align: center;" colspan="2"><em>Cliente </em></td>
            <td style="font-size: 14px; text-align: center;" colspan="2"><em>Comitente </em></td>
        </tr>
    </tbody>
</table>
