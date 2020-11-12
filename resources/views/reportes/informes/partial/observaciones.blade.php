<!--Este archivo no se está usando -->
<table width="100%" style="border-collapse: collapse;">
    <tbody>
        <tr>
            <td><strong style="font-size: 13px;">Observaciones</strong></td>
        </tr>
        <tr>
            <td style="font-size: 13px; height:47px;" class="bordered-td"><span style="margin-left: 5px;">
                @if($informe->numero_offline)
                    Referencia : {{ $informe->numero_offline}} /
                @endif
                {{$observaciones}}
            </span></td>
        </tr>
    </tbody>
</table>

