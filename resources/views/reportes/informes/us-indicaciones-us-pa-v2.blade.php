
    <table style="text-align: center;border-collapse: collapse;" class="bordered-td">
        <thead>
            <tr>
                <td style="border-bottom: 1px solid #000;background:#D8D8D8" colspan="13" >REGISTRO DE MEDICIONES</td>
            </tr>
            <tr>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 20px;      margin-right:20px;">ELEMENTO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -15px;      margin-right: -15px;">SOLDADORES</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -15px;      margin-right: -15px;">DIAMETRO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -20px;     margin-right: -20px;">N° INDICACIÓN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -15px;     margin-right: -15px;">POSICION EXAMEN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -20px;     margin-right: -20px;">ANG. INCIDENCIA</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -15px;     margin-right:  -15px;">CAMINO SONICO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 5px;       margin-right: 5px;">X (cm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 5px;       margin-right: 5px;">Y (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 5px;       margin-right: 5px;">Z (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -20px;     margin-right: -20px;">LONGITUD (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -20px;   margin-right: -20px;">NIVEL REGISTRO</div></th>

                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;" ><div id="vertical" style="margin-left: -13px;margin-right: -13px;">RESULTADO</div></th>

            </tr>
        </thead>    
        <tbody>
        @foreach ($indicaciones_us_pa  as $indicacion)
            <tr>
                <td style="font-size: 10px;height: 20px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->elemento) }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->soldador_p_id }} / {{ $indicacion->soldador_z_id }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">ø {{ $indicacion->diametro }}</td>
                <td style="font-size: 10px;text-align: center;" class="bordered-td">{{ $indicacion->nro_indicacion }}</td>
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
