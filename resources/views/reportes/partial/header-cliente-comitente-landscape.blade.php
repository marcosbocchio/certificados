<table width="100%" style="border-collapse:collapse;margin-top:3px;">
    <tbody>
        <tr>
            <td style="width:260px;vertical-align:middle;padding:1px 0;">
                <span style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Cliente:</span>
                <span style="font-size:11px;font-style:italic;color:#1C2340;margin-left:4px;">{{$cliente->nombre_fantasia}}</span>
            </td>
            <td style="width:110px;vertical-align:middle;text-align:center;padding:0 6px;">
                @if($ot->logo_cliente_sn && $cliente->path)
                    <img src="{{ public_path($cliente->path)}}" alt="" style="height:28px;max-width:100px;">
                @endif
            </td>
            <td style="width:260px;vertical-align:middle;padding:1px 0 1px 10px;">
                @if($contratista)
                    <span style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Comitente:</span>
                    <span style="font-size:11px;font-style:italic;color:#1C2340;margin-left:4px;">{{$contratista->nombre}}</span>
                @endif
            </td>
            <td style="width:110px;vertical-align:middle;text-align:center;padding:0 6px;">
                @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                    <img src="{{ public_path($contratista->path_logo)}}" alt="" style="height:28px;max-width:100px;">
                @endif
            </td>
        </tr>
    </tbody>
</table>
