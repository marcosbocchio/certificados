<tr>
    <td class="bordered" style="border-bottom: none;">
        <table width="100%" >
            <tbody>
                <tr>                         
                    <td style="font-size: 10px;width: 190px;height: 45px;"><b>CLIENTE:</b>{{$cliente->nombre_fantasia}}</td>  

                    <td style="width: 130px;">
                        @if($ot->logo_cliente_sn && $cliente->path)
                            <img  src="{{ public_path($cliente->path)}}" alt=""  style="height: 43px;max-width: 120px; margin-top: 5px;">
                        @else
                            <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 43px;margin-top: 5px;">
                        @endif    
                    </td>                                    
                
                    <td style="font-size: 10px; width: 195px;">
                        
                            @if($contratista)
                                <b>COMITENTE: </b>{{$contratista->nombre}}
                            @endif                                               
                        
                    </td> 
                    <td>
                        
                        @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                            <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height:43px;max-width: 120px; margin-top: 5px;">
                        @else
                            <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 43px;margin-top: 5px;">
                        @endif

                    </td>                                                    
                </tr>  
            </tbody>
        </table>          
    </td>
</tr> 
<tr>
    <td>
        <table width="100%" >
            <tbody>             
                <tr>                                                  
                    <td style="font-size: 10px; width: 480px;"><b>PROYECTO: </b>{{$ot->proyecto}}</td>  
                    @if(isset($informe))
                        <td style="font-size: 10px;"><b>OBRA: </b>{{$informe->obra}}</td>     
                    @else
                        <td style="font-size: 10px;"><b>OBRA: </b>{{$ot->obra}}</td>
                    @endif         
                    <td style="font-size: 10px;"><b>OT N°: </b>{{$ot->numero}}</td>     
                </tr>   
            </tbody>
        </table>          
    </td>
</tr> 
 
