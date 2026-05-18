<table width="100%" style="border-collapse:collapse;margin-top:8px;">
    <tbody>
        <tr>
            <td style="font-size:10px;font-weight:bold;color:#1C2340;width:55px;vertical-align:top;padding-top:4px;">Firmas</td>
            <td style="width:33%;text-align:center;height:60px;">
                @if($evaluador && $evaluador->path)
                    <img src="{{ public_path($evaluador->path)}}" alt="" style="width:120px;height:55px;">
                @endif
            </td>
            <td style="width:33%;text-align:center;">&nbsp;</td>
            <td style="width:33%;text-align:center;">&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td style="font-size:11px;font-style:italic;text-align:center;color:#64748B;border-top:1px solid #CBD5E1;padding-top:3px;">Responsable</td>
            <td style="font-size:11px;font-style:italic;text-align:center;color:#64748B;border-top:1px solid #CBD5E1;padding-top:3px;">Cliente</td>
            <td style="font-size:11px;font-style:italic;text-align:center;color:#64748B;border-top:1px solid #CBD5E1;padding-top:3px;">Comitente</td>
        </tr>
    </tbody>
</table>
