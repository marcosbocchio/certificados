@foreach ($informe_modelos_3d as $item)
<div class="page-break"></div>

    <table style="text-align: center;margin-top:50px;" width="100%">
        <tbody>
            <tr>
                <th style="text-align: center;">{{$item->codigo}}</th>
            </tr>
            <tr>
                <td style="text-align: center;">
                    @if ($item->path_imagen!=null)
                        <img src="{{ public_path($item->path_imagen) }}" alt="" style="height: 300; width: 300;margin-top:40px">
                    @endif
                </td>
            </tr>

        </tbody>
    </table>

@endforeach
