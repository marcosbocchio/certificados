<table class="header-detalle-principal">
    <tbody>
        <tr>
            <td width="49%">
                <table style="font-size: 12px;" width="100%" class="header-detalle">
                    <tbody>

                       <tr>
                           <th colspan="4">Componente</th>
                        </tr>
                       <tr>
                           <td colspan="4">{{$informe->componente}}</td>
                       </tr>

                       <tr>
                            <th colspan="4" >Línea</th>
                       </tr>
                       <tr>
                            <td colspan="4">
                                @if($informe->linea)
                                  {{$informe->linea}}
                                @else
                                     &nbsp;
                                @endif
                            </td>
                       </tr>

                        <tr>
                            <th colspan="4">Procedimiento</th>
                       </tr>
                       <tr>
                            <td colspan="4">{{$procedimiento_inf->titulo}}</td>
                       </tr>

                       <tr>
                            <th colspan="2">Estado superficie</th>
                            <th colspan="2">Medicion Dureza</th>
                       </tr>
                       <tr>
                        <td colspan="2">
                            {{$informe_estado_superficie->codigo}}
                        </td>
                            <td colspan="2">
                            {{$informe_unidad_medicion_dureza->descripcion}}
                            </td>
                       </tr>
                       <tr>
                            <th colspan="2">Probeta calibración</th>
                            <th colspan="2">Dureza calibración</th>
                       </tr>
                       <tr>
                        <td colspan="2">{{$informe_interno_equipo->probeta}}</td>
                        <td colspan="2">{{$informe_interno_equipo->dureza_calibracion}}</td>
                       </tr>
                       <tr>
                        <th colspan="2">Ejecutor Ensayo</th>
                        <th colspan="2">Solicitante</th>
                        </tr>
                        <tr>
                         <td colspan="2">{{$ejecutor_ensayo->name}}</td>
                         <td colspan="2">{{$informe_solicitado_por ? $informe_solicitado_por->name : '' }}</td>
                        </tr>

                    </tbody>
                </table>
            </td>
            <td width="2%">
                &nbsp;
            </td>
            <td width="49%">
                <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                    <tbody>

                       <tr >
                           <th width="50%" colspan="2">Material</th>
                           <th width="50%" colspan="2">
                            @if($material2)
                                Material ( {{ $informe->material2_tipo }})
                             @else
                                  &nbsp;
                              @endif
                         </th>
                       </tr>
                       <tr >
                           <td colspan="2">{{$material->codigo}}</td>
                           <td colspan="2">
                                @if($material2)
                                     {{$material2->codigo}}
                                @endif
                           </td>
                       </tr>

                        <tr>
                            <th colspan="4" >Plano / Isométrico</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{$informe->plano_isom}}
                                @if ($informe->hoja)
                                    - H:{{ $informe->hoja}}
                                @endif
                            </td>
                        </tr>

                        <tr >
                            <th colspan="2">EPS / WPS</th>
                            <th colspan="2">PQR</th>
                        </tr>
                        <tr >
                            <td colspan="2">{{$ot_tipo_soldadura->eps}}</td>
                            <td colspan="2">
                                @if($ot_tipo_soldadura->pqr)
                                    {{$ot_tipo_soldadura->pqr}}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>

                       <tr>
                            <th colspan="2">Temperatura del material</th>
                            <th colspan="2">Equipo</th>
                       </tr>
                        <tr>
                            <td colspan="2">{{$informe_dz->temperatura_material}}</td>
                            <td colspan="2">{{$informe_interno_equipo->nro_serie}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Norma Evaluación</th>
                            <th colspan="2">Norma Ensayo</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{$norma_evaluacion->codigo}}</td>
                            <td colspan="2">{{$norma_ensayo->codigo}}</td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
