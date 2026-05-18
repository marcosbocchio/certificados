<table width="100%" style="border-collapse:collapse;margin-top:6px;">
    <tbody>
        <tr>
            <td style="width:210px;vertical-align:top;padding:2px 0;">
                <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Cliente</div>
                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$cliente->nombre_fantasia}}</div>
            </td>
            <td style="width:110px;vertical-align:middle;text-align:center;padding:0 6px;">
                @if($ot->logo_cliente_sn && $cliente->path)
                    <img src="{{ public_path($cliente->path)}}" alt="" style="height:40px;max-width:100px;">
                @endif
            </td>
            <td style="width:210px;vertical-align:top;padding:2px 0 2px 12px;">
                @if($contratista)
                    <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Comitente</div>
                    <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$contratista->nombre}}</div>
                @endif
            </td>
            <td style="width:110px;vertical-align:middle;text-align:center;padding:0 6px;">
                @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                    <img src="{{ public_path($contratista->path_logo)}}" alt="" style="height:40px;max-width:100px;">
                @endif
            </td>
        </tr>
    </tbody>
</table>
