<table class="header-detalle-principal">
    <tbody>
        <tr>
            <td width="49%">
                <table style="font-size: 12px;" width="100%" class="header-detalle">
                    <tbody>

                       <tr>
                           <th width="100%" colspan="4">Componente</th>
                       </tr>
                       <tr >
                           <td colspan="4">{{$informe->componente}}</td>
                       </tr>

                       <tr>
                          <th colspan="4" >Linea</th>
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
                            <th colspan="4">EPS / WPS</th>
                       </tr>
                       <tr>
                            <td colspan="4">{{$ot_tipo_soldadura->eps}}</td>
                       </tr>


                       <tr>
                            <th colspan="4">Equipo</th>
                       </tr>
                       <tr>
                           <td colspan="4">{{$equipo->id}}</td>
                       </tr>
                        <tr>
                            <th colspan="4">Ejecutor Ensayo</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{$ejecutor_ensayo->name}}</td>
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
                            <th colspan="4">PQR</th>
                        </tr>
                        <tr >
                            <td colspan="4">
                                @if($ot_tipo_soldadura->pqr)
                                    {{$ot_tipo_soldadura->pqr}}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Norma Evaluación</th>
                            <th colspan="2">Norma Ensayo</th>
                        </tr>
                        <tr>
                            <td colspan="2" class="borderFilabottom">{{$norma_evaluacion->codigo}}</td>
                            <td colspan="2" class="borderFilabottom">{{$norma_ensayo->codigo}}</td>
                        </tr>
                        <tr>
                            <th colspan="4">Estado de la Superficie</th>
                       </tr>
                       <tr>
                            <td colspan="4">{{$informe_pmi->estado_superficie}}</td>
                       </tr>
                        <tr>
                            <th colspan="4">Solicitante</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{$informe_solicitado_por ? $informe_solicitado_por->name : '' }}</td>
                        </tr>
                   </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
