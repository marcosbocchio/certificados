    <table class="header-detalle-principal">
        <tbody>
            <tr>
                <td width="49%">
                    <table style="font-size: 12px;" width="100%" class="header-detalle">
                        <tbody>

                            <tr>
                                <th colspan="4">Tipo servicio</th>                       
                            </tr>
                            <tr>
                                <td colspan="4">{{$parte->tipo_servicio}}</td>                     
                            </tr>   

                            <tr>
                                <th colspan="4">Movilidad propia</th>
                            </tr>
                            <tr>
                                <td colspan="4" class="borderFilabottom">         
                                    @if ($parte->movilidad_propia_sn)
                                        SI   
                                    @else
                                        NO
                                    @endif  
                               </td>
                            </tr>

                            <tr>
                                <th  colspan="4">Informes del parte</th>
                            </tr>
                            <tr>
                                <td style="font-size: 12px;width: 233px;" colspan="4" class="borderFilabottom">

                                    @foreach ($metodos_informe as $item)
                
                                        @if (!$loop->first)
                                        ,
                                        @endif 
                
                                        <a href="{{ route('pdfInformes',$item->informe_id)}}">{{$item->numero_formateado}}</a>                       
                                        
                                    @endforeach
                                 
                                </td>                                 
                            </tr>

                        </tbody>
                    </table>
                </td>
                <td width="2%">
                    &nbsp;
                </td>
                <td width="49%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>

                            <tr>
                                <th colspan="4">Horario</th>                              
                            </tr>
                            <tr>
                                <td colspan="4" class="borderFilabottom">
                                    @if($parte->horario)
                                        {{$parte->horario}}
                                    @else
                                         &nbsp;
                                    @endif
                                </td>
                            </tr>  
                         
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>








