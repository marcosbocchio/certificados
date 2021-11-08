    <table width="100%">
        <tbody>
            <tr>
                <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
                REGISTRO DE MEDICIONES
            </td>
            </tr>
        </tbody>
    </table>

    @foreach ($informes_us_me as $informe_us_me)

            @php
                $pos_gen = 1;
                $max_cant_genetratices_fila = 20;
                $genetratrices_fila = $max_cant_genetratices_fila;
            @endphp
            <table>
                <tbody>
                    <tr>
                         <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Elemento : {{ strtoupper($informe_us_me->elemento)}}</span></td>
                    </tr>
                    @if ($informe_us_me->umbral)
                        <tr>
                             <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Espesor Nominal : {{ strtoupper($informe_us_me->umbral)}}</span></td>
                        </tr>
                    @endif

                    @if ($informe_us_me->espesor_minimo)
                        <tr>
                             <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Espesor Mínimo : {{ strtoupper($informe_us_me->espesor_minimo)}}</span></td>
                        </tr>
                    @endif
                    <tr>
                        <td style="font-size: 14px;height:20px;"><span style="margin-left: 22px;">Ø : {{ $informe_us_me->diametro}}</span></td>
                    </tr>
                </tbody>
            </table>
            @while($pos_gen <= $informe_us_me->cantidad_generatrices)
                <table  style="text-align: center;margin-left:18px;border-collapse: collapse;margin-bottom: 20px;"  class="bordered">
                    <thead>
                        <tr>
                            <th style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8"  class="bordered-td">&nbsp;</th>
                            @while( ($pos_gen <= $genetratrices_fila) && ($pos_gen <= $informe_us_me->cantidad_generatrices))
                                <th style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8" class="bordered-td">
                                    @foreach ($generatrices as $generatriz )

                                        @if($generatriz->nro == $pos_gen)
                                            {{  $generatriz->valor }}
                                        @endif

                                    @endforeach

                                </th>
                                {{ $pos_gen = $pos_gen + 1}}
                            @endwhile
                            {{ $genetratrices_fila = $genetratrices_fila + $max_cant_genetratices_fila }}
                        </tr>
                      </thead>
                      <tbody>
                        @for ( $pos_pos= 1 ;  $pos_pos <= $informe_us_me->cantidad_posiciones ; $pos_pos++)
                                <tr>
                                    <td style="font-size: 13px; text-align: left;width:28px;text-align: center;background:#D8D8D8" class="bordered-td">{{$pos_pos}}</td>
                                    @for ($pos_gen_fila = ($genetratrices_fila - (2*$max_cant_genetratices_fila)+1) ; $pos_gen_fila <= $pos_gen - 1 ; $pos_gen_fila++)

                                    {{ $x =0  }}

                                        @foreach ($informe_us_me->detalle_us_me as $item_detalle )

                                            @foreach ($generatrices as $generatriz)

                                                @if ($pos_pos==$item_detalle->posicion && $pos_gen_fila == $generatriz->nro && $item_detalle->generatriz==$generatriz->valor)

                                                    @if(($informe_us_me->espesor_minimo) && (strval($item_detalle->valor) < strval($informe_us_me->espesor_minimo)))

                                                       <td style="font-size: 13px; text-align: left;width:28px;text-align: center;color:red" class="bordered-td">{{$item_detalle->valor}}</td>

                                                    @else

                                                        <td style="font-size: 13px; text-align: left;width:28px;text-align: center" class="bordered-td">{{$item_detalle->valor}}</td>

                                                    @endif

                                                    {{ $x =1  }}

                                                @endif

                                            @endforeach

                                    @endforeach

                                    @if ($x==0)
                                            <td style="font-size: 13px; text-align: left;width:28px;text-align: center" class="bordered-td">X</td>
                                    @endif

                                    @endfor
                                </tr>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            @endwhile
    @endforeach

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

