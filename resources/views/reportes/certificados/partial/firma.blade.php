<table width="100%">
    <tbody>
        <tr>
            <td style="font-size: 13px;" colspan="1"  rowspan="2" ><b>Firmas </b></td>
            <td style="font-size: 13px;text-align: center;height: 85px;" colspan="2"  width="50%">
                @if($evaluador && $evaluador->path)
                    <img src="{{ public_path($evaluador->path)}}" alt="" style="width: 155px;height: 75px;">
                @endif
            </td>
            <td style="font-size: 13px;" colspan="2"  width="50%">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 14px; text-align: center;"  colspan="2"><em>Certificador </em></td>
            <td style="font-size: 14px; text-align: center;"  colspan="2"><em>Cliente </em></td>
        </tr>
    </tbody>
</table>
