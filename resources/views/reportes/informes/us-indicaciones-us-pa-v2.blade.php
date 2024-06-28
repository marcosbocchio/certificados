<table style="text-align: center;border-collapse: collapse;" class="bordered-td">
        <thead>
            <tr>
                <td style="border-bottom: 1px solid #000;background:#D8D8D8" colspan="14" >REGISTRO DE MEDICIONES</td>
            </tr>
            <tr>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: 15px; margin-right: 15px; padding: 0;">ELEMENTO</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -10px; margin-right: -10px; padding: 0; white-space: nowrap;">SOLDADORES</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -15px; margin-right: -15px; padding: 0; white-space: nowrap;">DIAMETRO</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -26px; margin-right: -26px; padding: 0; white-space: nowrap;">N° INDICACIÓN</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -10px; margin-right: -10px; padding: 0; white-space: nowrap;">BARRIDO</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -38px; margin-right: -38px; padding: 0; white-space: nowrap;">POSICION EXAMEN</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -30px; margin-right: -30px; padding: 0; white-space: nowrap;">ANG. INCIDENCIA</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -35px; margin-right: -35px; padding: 0; white-space: nowrap;">CAMINO SONICO</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -2px; margin-right: -2px; padding: 0; white-space: nowrap;">X (mm)</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -2px; margin-right: -2px; padding: 0; white-space: nowrap;">Y (mm)</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -2px; margin-right: -2px; padding: 0; white-space: nowrap;">Z (mm)</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -30px; margin-right: -20px; padding: 0; white-space: nowrap;">LONGITUD (mm)</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -30px; margin-right: -30px; padding: 0; white-space: nowrap;">NIVEL REGISTRO</p>
                </th>
                <th id="rotate" style="border-right: 1px solid #000; font-size: 13px; font-weight: normal;">
                    <p id="vertical" style="margin-left: -13px; margin-right: -13px; padding: 0; white-space: nowrap;">RESULTADO</p>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($indicaciones_us_pa  as $indicacion)
            <tr>
            <td style="font-size: 10px; height: 20px; text-align: center; word-wrap: break-word; white-space: normal;" class="bordered-td">{{ strtoupper($indicacion->elemento) }}</td>
            <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->soldador_p_id }} / {{ $indicacion->soldador_z_id }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">ø {{ $indicacion->diametro }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->nro_indicacion }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->barrido }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->posicion_examen) }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->angulo_incidencia) }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->camino_sonico }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->x }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->y }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->z }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->longitud }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->nivel_registro)}}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">
                    @if($indicacion->aceptable_sn)
                        AP
                    @else
                        RZ
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if( $informe_us->path1_indicacion || $informe_us->path2_indicacion )
        <div class="page_break"></div>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                   IMAGENES INDICACIONES
                </td>
                </tr>
            </tbody>
        </table>
        <table style="text-align: center;margin-top: 5px;" width="100%" >
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 680px;height: 275px;">

                                        @if ($informe_us->path1_indicacion)
                                            <img src="{{ public_path($informe_us->path1_indicacion) }}" alt="" style="width: 700px;height: 270px;">
                                        @endif

                                    </td>

                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 680px;height: 275px;">

                                        @if ($informe_us->path2_indicacion)
                                            <img src="{{ public_path($informe_us->path2_indicacion) }}" alt="" style="width: 700px;height: 270px;">
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

    @if($informe_us->path3_indicacion || $informe_us->path4_indicacion)
        <div class="page_break"></div>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                   IMAGENES INDICACIONES
                </td>
                </tr>
            </tbody>
        </table>
        <table style="text-align: center;margin-top: 5px;" width="100%" >
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 680px;height: 275px;">

                                        @if ($informe_us->path3_indicacion)
                                            <img src="{{ public_path($informe_us->path3_indicacion) }}" alt="" style="width: 700px;height: 270px;">
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 680px;height: 275px;">

                                        @if ($informe_us->path4_indicacion)
                                            <img src="{{ public_path($informe_us->path4_indicacion) }}" alt="" style="width: 700px;height: 270px;">
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

    @include('reportes.informes.partial.referencias')
