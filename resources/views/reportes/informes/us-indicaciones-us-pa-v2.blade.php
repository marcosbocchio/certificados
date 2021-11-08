
    <table style="text-align: center;border-collapse: collapse;" class="bordered-td">
        <thead>
            <tr>
                <td style="border-bottom: 1px solid #000;background:#D8D8D8" colspan="12" >REGISTRO DE MEDICIONES</td>
            </tr>
            <tr>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 85px;margin-right:85px;">ELEMENTO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -6px;margin-right: -6px;">DIAMETRO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -30px;margin-right: -30px;">N° INDICACIÓN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -45px;margin-right: -45px;">POSICION EXAMEN</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -35px;margin-right: -35px;">ANG. INCIDENCIA</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -33px;margin-right:  -33px;">CAMINO SONICO</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 4px;margin-right: 4px;">X (cm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 2px;margin-right: 2px;">Y (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: 2px;margin-right: 2px;">Z (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -34px;margin-right: -34px;">LONGITUD (mm)</div></th>
                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;"><div id="vertical" style="margin-left: -37.8px;margin-right: -37.8px;">NIVEL REGISTRO</div></th>

                <th id="rotate" style="border-right: 1px solid #000;font-size: 13px;font-weight: normal;" ><div id="vertical" style="margin-left: -16px;margin-right: -16px;">RESULTADO</div></th>

            </tr>
        </thead>
        <tbody>
            @foreach ($indicaciones_us_pa  as $indicacion)
            <tr>
                  <td style="font-size: 10px;height: 16px;text-align: center;" class="bordered-td">{{ strtoupper($indicacion->elemento) }}</td>
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

    @if( $informe_us->path1_calibracion || $informe_us->path2_calibracion)
        <div class="page_break"></div>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                   IMAGENES CALIBRACIONES
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

                                        @if ($informe_us->path1_calibracion)
                                            <img src="{{ public_path($informe_us->path1_calibracion) }}" alt="" style="width: 400px;height: 270px;">
                                        @endif

                                    </td>

                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 680px;height: 275px;">

                                        @if ($informe_us->path2_calibracion)
                                            <img src="{{ public_path($informe_us->path2_calibracion) }}" alt="" style="width: 400px;height: 270px;">
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

    @if($informe_us->path3_calibracion || $informe_us->path4_calibracion)
        <div class="page_break"></div>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                   IMAGENES CALIBRACIONES
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

                                        @if ($informe_us->path3_calibracion)
                                            <img src="{{ public_path($informe_us->path3_calibracion) }}" alt="" style="width: 400px;height: 270px;">
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 680px;height: 275px;">

                                        @if ($informe_us->path4_calibracion)
                                            <img src="{{ public_path($informe_us->path4_calibracion) }}" alt="" style="width: 400px;height: 270px;">
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
