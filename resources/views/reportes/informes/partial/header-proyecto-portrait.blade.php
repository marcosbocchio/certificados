<table width="100%" style="margin-top:10px">
    <tbody>             
        <tr>                                                  
            <td width="50%" style="font-size: 12px;"><b>Proyecto: </b></td>  
            <td width="25%%" style="font-size: 12px;"><b>Obra </b></td> 
            <td width="25%%" style="font-size: 12px;"><b>OT N° </b></td>     
        </tr>   
        <tr>
            <td style="font-size: 12px;"><span class="datosHead">{{$ot->proyecto}}</span></td>
            
            @if(isset($informe))
                <td style="font-size: 12px;" ><span class="datosHead">{{$informe->obra}}</span></td>     
            @else
                <td style="font-size: 12px;"><span class="datosHead"></span>{{$ot->obra}}</td>
            @endif   
            <td style="font-size: 12px;"><span class="datosHead"><span class="datosHead"></span>{{$ot->numero}}</td>
        </tr>
    </tbody>
</table>  