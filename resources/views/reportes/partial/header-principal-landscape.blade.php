<table width="100%" style="border-collapse:collapse;border-bottom:2px solid #4F8CFF;">
    <tbody>
        <tr>
            <td style="width:130px;text-align:center;vertical-align:middle;background-color:#F0F5FF;border-right:2px solid #4F8CFF;padding:4px 4px;">
                <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height:45px;">
            </td>
            <td style="text-align:center;vertical-align:middle;padding:4px 14px;">
                <div style="font-size:15px;font-weight:bold;color:#1C2340;letter-spacing:0.2px;">{{ $titulo }}</div>
            </td>
            <td style="width:190px;vertical-align:top;padding:4px 0 4px 10px;border-left:1px solid #CBD5E1;">
                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Informe N°</div>
                <div style="font-size:11px;color:#1C2340;margin-bottom:2px;">
                    @if ($informe->km === -1)
                        PDJ-{{$ot_tipo_soldadura->TipoSoldadura->codigo}}-{{ $nro }}
                    @else
                        {{$informe->km}}-{{$ot_tipo_soldadura->TipoSoldadura->codigo}}-{{ $nro }}
                    @endif
                </div>
                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Fecha</div>
                <div style="font-size:11px;color:#1C2340;">{{ $fecha }}</div>
            </td>
        </tr>
    </tbody>
</table>
