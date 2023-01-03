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
                            <td style="font-size: 19px; height: 30px;width: 360px; text-align: center;margin-left: 0px" rowspan="3"><b>{{ $titulo }}</b></td>
                            <td style="font-size: 11px;width: 200px" ><b style="margin-left: 80px;">&nbsp;</td>
                        </tr>
                        <tr>
                            @if ($informe->km === -1)
                            {
                               <td style="font-size: 10px;" ><b style="margin-left: 80px;">INFORME N°: </b>PDJ-{{$ot_tipo_soldadura->TipoSoldadura->codigo}}-{{ $nro }}
                               </td>

                            }
                            @else{
                                <td style="font-size: 10px;" ><b style="margin-left: 80px;">INFORME N°: </b>{{$informe->km}}-{{$ot_tipo_soldadura->TipoSoldadura->codigo}}-{{ $nro }}
                                </td>
                               }
                            @endif

                        </tr>
                        <tr>
                            <td style="font-size: 11px;"><b style="margin-left: 80px;">FECHA: </b>{{ $fecha }}</td>
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
