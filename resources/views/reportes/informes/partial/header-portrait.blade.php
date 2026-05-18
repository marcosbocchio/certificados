<tr>
    <td class="bordered" style="border-bottom:none;padding:4px 6px;">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="width:195px;vertical-align:top;">
                        <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Cliente</div>
                        <div style="font-size:11px;font-style:italic;color:#1C2340;">{{$cliente->nombre_fantasia}}</div>
                    </td>
                    <td style="width:120px;vertical-align:middle;text-align:center;">
                        @if($ot->logo_cliente_sn && $cliente->path)
                            <img src="{{ public_path($cliente->path)}}" alt="" style="height:38px;max-width:110px;">
                        @else
                            <img src="{{ public_path('img/blank.png')}}" alt="" style="height:38px;">
                        @endif
                    </td>
                    <td style="width:195px;vertical-align:top;padding-left:10px;">
                        @if($contratista)
                            <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Comitente</div>
                            <div style="font-size:11px;font-style:italic;color:#1C2340;">{{$contratista->nombre}}</div>
                        @endif
                    </td>
                    <td style="vertical-align:middle;text-align:center;">
                        @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                            <img src="{{ public_path($contratista->path_logo)}}" alt="" style="height:38px;max-width:110px;">
                        @else
                            <img src="{{ public_path('img/blank.png')}}" alt="" style="height:38px;">
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td style="padding:4px 6px;border-top:1px solid #CBD5E1;">
        <table width="100%">
            <tbody>
                <tr>
                    <td style="width:50%;vertical-align:top;">
                        <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Proyecto</div>
                        <div style="font-size:11px;font-style:italic;color:#1C2340;">{{$ot->proyecto}}</div>
                    </td>
                    <td style="width:25%;vertical-align:top;padding-left:6px;">
                        <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">Obra</div>
                        @if(isset($informe))
                            <div style="font-size:11px;font-style:italic;color:#1C2340;">{{$informe->obra}}</div>
                        @else
                            <div style="font-size:11px;font-style:italic;color:#1C2340;">{{$ot->obra}}</div>
                        @endif
                    </td>
                    <td style="width:25%;vertical-align:top;padding-left:6px;">
                        <div style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;">OT N°</div>
                        <div style="font-size:11px;font-style:italic;color:#1C2340;">{{$ot->numero}}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
