<table width="100%">
    <tbody>
        <tr>
            <td style="font-size: 13px;" colspan="4"><b>Firmas </b></td> 
        </tr>
        <tr>
            <td style="font-size: 13px;text-align: center;height: 50px;" colspan="2" width="50%">
                @if($evaluador && $evaluador->path)
                    <img src="{{ public_path($evaluador->path)}}" alt="" style="width: 100px;height: 50px;">
                @endif     
            </td>    
            <td style="font-size: 13px;" colspan="2" width="50%">&nbsp;</td> 
        </tr>
        <tr>                               
            <td style="font-size: 14px; text-align: center;"" colspan="2"><em>Responsable OT </em></td>   
            <td style="font-size: 14px; text-align: center;" colspan="2"><em>Generador OT </em></td> 
        </tr>
    </tbody>
</table>