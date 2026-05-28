<table style="text-align: center;" width="100%">
    <tbody>
        <tr>
            <td>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td rowspan="4" style="width: 210px;">
                                <img src="{{ public_path('img/logo-empresa.png')}}" alt="" style="max-width: 120px; max-height: 50px; margin-left: 2px;">
                            </td>
                            <td style="font-size: 18px; height: 30px;width: 295px; text-align: center;" rowspan="4"><b>{{ $titulo }}</b></td>
                            <td style="font-size: 10px;" ><b style="margin-left:35px;">
                                {{ $tipo_reporte}}</b>{{ $nro }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 10px;"><b style="margin-left: 35px;">FECHA: </b>{{ $fecha }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;"><b style="margin-left: 35px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

