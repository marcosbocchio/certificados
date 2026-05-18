<table width="100%" style="border-collapse:collapse;margin-top:6px;">
    <tbody>
        <tr>
            <td width="50%" style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;padding-bottom:1px;">Proyecto</td>
            <td width="25%" style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;padding-bottom:1px;">Obra</td>
            <td width="25%" style="font-size:9px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;padding-bottom:1px;">FST N°</td>
        </tr>
        <tr>
            <td style="font-size:12px;font-style:italic;color:#1C2340;">{{$ot->proyecto}}</td>
            @if(isset($informe))
                <td style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->obra}}</td>
            @else
                <td style="font-size:12px;font-style:italic;color:#1C2340;">{{$ot->obra}}</td>
            @endif
            <td style="font-size:12px;font-style:italic;color:#1C2340;">{{$ot->presupuesto}}</td>
        </tr>
    </tbody>
</table>
