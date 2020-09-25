@if(count($informe_modelos_3d) > 0 )

    <div class="page-break"></div>
    <h4 style="color: gray">Capturas de modelos 3d</h4>

    <table style="text-align: center;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table style="text-align: center;margin-top:5px;" width="100%">
                        <tbody>
                            <tr>
                                <td style="text-align: center;">
                                    @if ($informe_modelos_3d[0]->path_imagen!=null)
                                        <img src="{{ public_path($informe_modelos_3d[0]->path_imagen) }}" alt="" height="150">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center;">{{$informe_modelos_3d[0]->codigo}}</th>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ route('viewer-3d',$informe_modelos_3d[0]->id)}}">Abrir en visualizador 3D</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    @isset($informe_modelos_3d[1])
                        <table style="text-align: center;margin-top:5px;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">
                                        @if ($informe_modelos_3d[1]->path_imagen!=null)
                                            <img src="{{ public_path($informe_modelos_3d[1]->path_imagen) }}" alt="" height="150">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">{{$informe_modelos_3d[1]->codigo}}</th>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('viewer-3d',$informe_modelos_3d[1]->id)}}">Abrir en visualizador 3D</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endisset
                </td>
            </tr>

            <tr>
                <td>
                    @isset($informe_modelos_3d[2])
                        <table style="text-align: center;margin-top:25px;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">
                                        @if ($informe_modelos_3d[2]->path_imagen!=null)
                                            <img src="{{ public_path($informe_modelos_3d[2]->path_imagen) }}" alt="" height="150">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">{{$informe_modelos_3d[2]->codigo}}</th>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('viewer-3d',$informe_modelos_3d[2]->id)}}">Abrir en visualizador 3D</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endisset
                </td>
                <td>
                    @isset($informe_modelos_3d[3])
                        <table style="text-align: center;margin-top:25px;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">
                                        @if ($informe_modelos_3d[3]->path_imagen!=null)
                                            <img src="{{ public_path($informe_modelos_3d[3]->path_imagen) }}" alt="" height="150">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">{{$informe_modelos_3d[3]->codigo}}</th>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('viewer-3d',$informe_modelos_3d[3]->id)}}">Abrir en visualizador 3D</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endisset
                </td>
            </tr>

        </tbody>
    </table>

@endif

