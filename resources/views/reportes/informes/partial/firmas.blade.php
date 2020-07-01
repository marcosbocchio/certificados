<table width="100%">
    <tbody>
        <tr>
            <td style="font-size: 13px;" colspan="6"><b>Firmas </b></td> 
        </tr>
        <tr>
            <td style="font-size: 13px;text-align: center;height: 50px;" colspan="2">
                @if($evaluador && $evaluador->path)
                    <img src="{{ public_path($evaluador->path)}}" alt="" style="width: 100px;height: 50px;">
                @endif
            </td> 
            <td style="font-size: 13px;" colspan="2">&nbsp;</td> 
            <td style="font-size: 13px;" colspan="2">&nbsp;</td> 
        </tr>
        <tr>                               
            <td style="font-size: 14px; text-align: center;"" colspan="2"><em>Evaluador </em></td>   
            <td style="font-size: 14px; text-align: center;" colspan="2"><em>Cliente </em></td> 
            <td style="font-size: 14px; text-align: center;" colspan="2"><em>Comitente </em></td>                              
        </tr>
    </tbody>
</table> 
