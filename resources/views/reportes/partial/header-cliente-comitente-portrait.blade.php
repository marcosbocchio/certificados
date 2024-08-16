
<table width="100%" >
    <tbody>
        <tr>                         
            <td style="font-size: 12px;width: 215px;"><span class="titulosHead">Cliente</span> </td>  

            <td style="width: 130px;" rowspan="3">

                @if($ot->logo_cliente_sn && $cliente->path)
                    <img  src="{{ public_path($cliente->path)}}" alt="" style="height: 42px;max-width: 120px; margin-top: 5px;">
                @else
                    <img  src="{{ public_path('img/blank.png')}}" alt="" style="height: 42px;margin-top: 5px;">
                @endif    

            </td>         

            <td style="font-size: 12px; width: 175px;">

                @if($contratista)
                    <span class="titulosHead" style="margin-left: 12px;">Comitente</span> 
                @endif                                               
                
            </td> 

            <td  rowspan="3"> 

                @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                    <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height:42px;max-width: 120px; margin-top: 5px;">
                @else
                    <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 42px;margin-top: 5px;">
                @endif

            </td>    

        </tr>  
        <tr>
            <td style="font-size: 12px;width: 195px;" class="datosHead">{{$cliente->nombre_fantasia}}</td> 
            <td style="font-size: 12px;width: 195px; " class="datosHead"><span style="margin-left: 12px">
            @if($contratista)
                {{$contratista->nombre}}
            @endif
            </span></td>  
        </tr>

    </tbody>
</table>          


        
