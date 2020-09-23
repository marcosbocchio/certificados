@foreach ($informe_modelos_3d as $item)
<div class="page-break"></div>

    <table style="text-align: center;margin-top:5px;" width="100%">
        <tbody>
            <tr>
                <th style="text-align: center;">{{$item->codigo}}</th>
            </tr>
            <tr>
                <td style="text-align: center;">
                    @if ($item->path_imagen!=null)
                        <img src="{{ public_path($item->path_imagen) }}" alt="" style="height: 200px; width: 200px;margin-top:20px">
                    @endif
                </td>
            </tr>

        </tbody>
    </table>

@endforeach
