<table style="text-align: center;" width="100%">
    <tbody>
        <tr>
            <td>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td rowspan="4" style="text-align: left;width: 200px;">
                                <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px; margin-left: 25px;">
                            </td>   
                            <td style="font-size: 19px; height: 30px;width: 375px; text-align: center;margin-left: 0px" rowspan="2"><b>{{ $titulo1 }}</b></td>
                            <td style="font-size: 11px;width: 200px" ><b style="margin-left: 110px;">&nbsp;</td>          
                        </tr>
                        <tr>
                            <td style="font-size: 11px;" ><b style="margin-left: 110px;">{{ $tipo_reporte }}</b> {{ $nro}} </td>     
                            
                        </tr>
                        <tr>
                            <td style="font-size: 15px;text-align: center;height: 20px;">{{ $titulo2 }}</td>
                            <td style="font-size: 11px;"><b style="margin-left: 110px;">FECHA: </b>{{ $fecha }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;">&nbsp;</td>                     
                            <td style="font-size: 11px;">&nbsp;</td>            
                        </tr>               
                    </tbody>
                </table>          
            </td>
        </tr>
    </tbody>
</table>