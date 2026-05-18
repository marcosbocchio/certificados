<table width="100%" style="border-collapse:collapse;border-bottom:2px solid #4F8CFF;">
    <tbody>
        <tr>
            <td style="width:165px;text-align:center;vertical-align:middle;background-color:#F0F5FF;border-right:2px solid #4F8CFF;padding:8px 6px;">
                <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height:70px;">
            </td>
            <td style="text-align:center;vertical-align:middle;padding:6px 18px;">
                <div style="font-size:18px;font-weight:bold;color:#1C2340;letter-spacing:0.2px;">{{ $titulo1 }}</div>
                @if(isset($titulo2) && $titulo2)
                    <div style="font-size:13px;color:#64748B;margin-top:4px;">{{ $titulo2 }}</div>
                @endif
            </td>
            <td style="width:195px;vertical-align:top;padding:8px 0 8px 12px;border-left:1px solid #CBD5E1;">
                <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">{{ $tipo_reporte }}</div>
                <div style="font-size:12px;color:#1C2340;margin-bottom:6px;">{{ $nro }}</div>
                <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Fecha</div>
                <div style="font-size:12px;color:#1C2340;">{{ $fecha }}</div>
            </td>
        </tr>
    </tbody>
</table>
