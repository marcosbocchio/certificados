<table width="100%" style="border-collapse:collapse;margin-top:3px;">
    <tbody>
        <tr>
            <td width="50%" style="padding:1px 0;">
                <span style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Proyecto:</span>
                <span style="font-size:11px;font-style:italic;color:#1C2340;margin-left:4px;">{{$ot->proyecto}}</span>
            </td>
            <td width="30%" style="padding:1px 0;">
                <span style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Obra:</span>
                @if(isset($informe))
                    <span style="font-size:11px;font-style:italic;color:#1C2340;margin-left:4px;">{{$informe->obra}}</span>
                @else
                    <span style="font-size:11px;font-style:italic;color:#1C2340;margin-left:4px;">{{$ot->obra}}</span>
                @endif
            </td>
            <td width="20%" style="padding:1px 0;">
                <span style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">OT N°:</span>
                <span style="font-size:11px;font-style:italic;color:#1C2340;margin-left:4px;">{{$ot->numero}}</span>
            </td>
        </tr>
    </tbody>
</table>
