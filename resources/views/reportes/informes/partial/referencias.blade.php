@foreach ( $detalles as $detalle )
    @if ( $detalle->referencia)
        @php
            $referencia = $detalle->referencia;
        @endphp
        <div class="page_break"></div>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                         IMAGENES REFERENCIAS
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 12px;padding-top:10px"><strong>ELEMENTO: </strong>
                        @isset($detalle->elemento)
                            {{ $detalle->elemento }}
                        @endisset
                        @isset($detalle->pieza)
                            {{ $detalle->pieza }}
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 12px"><strong>OBSERVACIÓN: </strong>  {{$referencia->descripcion }} </td>
                </tr>
            </tbody>
        </table>
        <table style="text-align: center; margin-top: 10px;" class="" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table style="border-spacing: 15px 1rem;">
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 300px;height: 200px">
                                            @if ($referencia->path1!='/img/imagen1.jpg')
                                                <img src="{{ public_path($referencia->path1) }}" alt="" style="height: 150; width: 218;">
                                            @endif

                                    </td>
                                    <td style="text-align: center; width: 300px;height: 200px">
                                        @if ($referencia->path2!='/img/imagen2.jpg')
                                            <img src="{{  public_path($referencia->path2) }}" alt="" style="height: 150; width: 218;">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 300px;height: 200px">
                                        @if ($referencia->path3!='/img/imagen3.jpg')
                                            <img src="{{  public_path($referencia->path3) }}" alt="" style="height: 150; width: 218;">
                                    @endif
                                    </td>
                                    <td style="text-align: center; width: 300px;height: 200px">
                                        @if ($referencia->path4!='/img/imagen4.jpg')
                                            <img src="{{  public_path($referencia->path4) }}" alt="" style="height: 150; width: 218;">
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
@endforeach


