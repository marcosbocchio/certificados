<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>

 <style>
.bordered {
    border-color: #000000;
    border-style: solid;
    border-width: 2px; 
    border-collapse: collapse;   
}

td {
  padding: 2px;
}

td b,td span {
  margin-left: 10px;
} 
</style>


  <body>
     <table style="text-align: center" class="bordered" width="100%">
        <tbody>
            <tr> 
                <td class="bordered">
                    <table width="100%">
                        <tbody>
                            <tr>
                            <td style="font-size: 14px; height: 30px;" colspan="3"><b style="margin-left: 50px;">PROYECTO: </b>{{ $ot->proyecto}} </td>
                            </tr>
                            <tr>
                            <td style="font-size: 13px;" colspan="2"><b>CLIENTE: </b>{{$cliente->nombre_fantasia}}</td>
                            
                            <td rowspan="3" style="text-align: right;">
                                <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-right: 25px;">
                            </td>               
                                        
                            </tr>
                            <tr>
                            <td style="font-size: 13px;"><b>OBRA: </b>{{$ot->obra}}</td>
                            <td style="font-size: 13px;"><b>FECHA: </b>{{ date('d-m-Y', strtotime($ot->fecha_hora)) }}</td>    
                            </tr>                  
                            <tr>
                            <td style="font-size: 13px;"><b>OT N°: </b>{{$ot->numero}}</td>
                            <td style="font-size: 13px;"><b>FTS N°: </b>{{$ot->presupuesto}}</td>
            
                            </tr>
                        </tbody>
                    </table>          
                </td>
             </tr>
             <tr>
                 <td class="bordered">
                     <table>
                         <tbody>
                             <tr>
                                <td style="font-size: 13px;" > <b>{{ $tabla }}: </b>  {{$modelo->descripcion}}</td>  
                             </tr>
                         </tbody>
                     </table>
                 </td>
             </tr>
             <tr>
                 <td>
                    <table>
                        <tbody>
                            <tr>
                                <td style="font-size: 15px;">
                                    <p><strong>Observaciones: </strong>{{$ot_referencia->descripcion}}</p> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                 </td>
             </tr>
             <tr>
                 <td>                     
                    <table>    
                        <tbody>
                             <tr>
                                <td style="text-align: center; width: 360px;height: 300px">
                                        @if ($detalle_pm_referencia->path1!='/img/imagen1.jpg')
                                            <img src="{{ public_path($detalle_pm_referencia->path1) }}" alt="" style="height: 174; width: 255;">
                                        @endif  
                                          
                                    </td>
                                    <td style="text-align: center; width: 360px;height: 300px">
                                     @if ($detalle_pm_referencia->path2!='/img/imagen2.jpg')
                                            <img src="{{  public_path($detalle_pm_referencia->path2) }}" alt="" style="height: 174; width: 255;">
                                     @endif  
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 360px;height: 300px">
                                     @if ($detalle_pm_referencia->path3!='/img/imagen3.jpg')
                                            <img src="{{  public_path($detalle_pm_referencia->path3) }}" alt="" style="height: 174; width: 255;">
                                    @endif  
                                    </td>
                                    <td style="text-align: center; width: 360px;height: 300px">
                                     @if ($detalle_pm_referencia->path4!='/img/imagen4.jpg')
                                            <img src="{{  public_path($detalle_pm_referencia->path4) }}" alt="" style="height: 174; width: 255;">
                                    @endif  
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                 </td>
             </tr>        
        </tbody>
    </table>
  </body>
</html>
