<table class="header-detalle-principal">
    <tbody>
        <tr>
            <td width="49%">
                <table style="font-size: 12px;" width="100%" class="header-detalle">
                    <tbody>

                       <tr>
                           <th colspan="2">Componente</th>
                           <th colspan="2">Extensión de ensayo</th>
                        </tr>
                       <tr>
                           <td colspan="2">{{$informe->componente}}</td>
                           <td colspan="2">{{$informe_cv->extension_ensayo}}</td>
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
                            <th colspan="2">Campana</th>
                            <th colspan="2">Presión Máx. Manómetro</th>
                       </tr>
                       <tr>
                            <td colspan="2">{{$campana->designacion}}-@if($campana->tipo_angular_sn == true)
                                Angular
                            @else
                                Rectangular
                            @endif</td>
                            <td colspan="2">
                                {{$informe_cv->presion_max_manometro}} mmHg
                            </td>
                       </tr>
                       <tr>
                            <th colspan="2">Dimensiones</th>
                            <th colspan="2">Bomba</th>
                       </tr>
                       <tr>
                            <td colspan="2">
                                @if ($campana->tipo_angular_sn)

                                {{$informe_cv->ancho}} x {{$informe_cv->alto}} x {{$informe_cv->profundidad}} mm

                                @endif
                            </td>
                            <td colspan="2">{{$bomba->designacion}}</td>
                       </tr>

                       <tr>
                            <th colspan="2">Líquido</th>
                            <th colspan="2">Modo de aplicación</th>
                       </tr>
                        <tr>
                            <td colspan="2">{{$informe_cv->liquido}}</td>
                            <td colspan="2">{{$aplicacion->codigo}}</td>
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
                            <th colspan="2">Presión trabajo mín.</th>
                            <th colspan="2">Presión trabajo máx.</th>
                       </tr>
                        <tr>
                            <td colspan="2">{{$informe_cv->presion_trabajo_min}} mmHg</td>
                            <td colspan="2">{{$informe_cv->presion_trabajo_max}} mmHg</td>
                        </tr>

                        <tr>
                            <th colspan="2">Caudal</th>
                            <th colspan="2">Voltaje </th>
                        </tr>
                        <tr>
                            <td colspan="2">{{$informe_cv->caudal}} CFM</td>
                            <td colspan="2">{{$informe_cv->voltaje}}</td>
                        </tr>

                        <tr>
                            <th colspan="4">Estado del Producto</th>
                       </tr>
                       <tr>
                            <td colspan="4">
                                {{$informe_cv->estado_producto}}
                            </td>
                       </tr>
                       <tr>
                        <th colspan="2">Ejecutor Ensayo</th>
                        <th colspan="2">Solicitante</th>
                        </tr>
                        <tr>
                         <td colspan="2" class="borderFilabottom">{{$ejecutor_ensayo->name}}</td>
                         <td colspan="2" class="borderFilabottom">{{$informe_solicitado_por ? $informe_solicitado_por->name : '' }}</td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
