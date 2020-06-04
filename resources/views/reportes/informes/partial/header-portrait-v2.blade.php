
        <table width="100%" >
            <tbody>
                <tr>                         
                    <td style="font-size: 10px;width: 190px;"><span class="titulosHead">Cliente</span> </td>  

                    <td style="width: 130px;" rowspan="3">

                        @if($ot->logo_cliente_sn && $cliente->path)
                            <img  src="{{ public_path($cliente->path)}}" alt="" style="height: 43px;max-width: 120px; margin-top: 5px;">
                        @else
                            <img  src="{{ public_path('img/blank.png')}}" alt="" style="height: 43px;margin-top: 5px;">
                        @endif    

                    </td>         

                    <td style="font-size: 10px; width: 195px;">

                        @if($contratista)
                          <span class="titulosHead" style="margin-left: 10px;">Comitente</span> 
                        @endif                                               
                        
                    </td> 

                    <td  rowspan="3"> 

                        @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                            <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height:43px;max-width: 120px; margin-top: 5px;">
                        @else
                            <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 43px;margin-top: 5px;">
                        @endif

                    </td>      

                </tr>  
                <tr>
                    <td style="font-size: 10px;width: 190px;" class="datosHead">{{$cliente->nombre_fantasia}}</td> 
                    <td style="font-size: 10px;width: 190px;" class="datosHead"><span>{{$contratista->nombre}}</span></td>  
                </tr>

            </tbody>
        </table>          


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
