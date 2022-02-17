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
                            <td colspan="4">{{$informe->procedimiento['titulo']}}</td>
                       </tr>

                       <tr>
                            <th colspan="4">EPS / WPS</th>
                       </tr>
                       <tr>
                            <td colspan="4">{{ $informe->OtTipoSoldadura['eps']}}</td>
                       </tr>
                       <tr>
                           <th colspan="2">Temp. Inicial </th>
                           <th colspan="2">Temp. Subida </th>
                       </tr>
                       <tr>
                           <td colspan="2">{{$informe->informeTt->temperatura_inicial}} °C</td>
                           <td colspan="2">{{$informe->informeTt->temperatura_subida}} °C/Hs</td>
                       </tr>
                       <tr>
                        <th colspan="4">Temp. Final </th>
                    </tr>
                    <tr>
                        <td colspan="4">{{$informe->informeTt->temperatura_final}} °C</td>
                    </tr>
                    <tr>
                        <th colspan="2">Ejecutor Ensayo</th>
                        <th colspan="2">Solicitante</th>
                    </tr>
                    <tr>
                        <td colspan="2">{{$informe->ejecutor_ensayo['name']}}</td>
                        <td colspan="2">
                            @if($informe->solicitadoPor)
                                 {{ $informe->solicitadoPor['name'] }}
                            @else
                                &nbsp;
                            @endif
                        </td>
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
                        <tr>
                            <th width="50%" colspan="2">Material</th>
                            <th width="50%" colspan="2">
                                @if($informe->material2)
                                    Material ( {{ $informe->material2_tipo }})
                                @else
                                    &nbsp;
                                @endif
                            </th>
                        </tr>
                        <tr >
                            <td colspan="2">{{$informe->material['codigo']}}</td>
                            <td colspan="2">
                                 @if($informe->material2)
                                      {{$informe->material2['codigo']}}
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
                         <tr>
                            <th colspan="4">PQR</th>
                        </tr>
                        <tr >
                            <td colspan="4">
                                @if($informe->OtTipoSoldadura)
                                    {{$informe->OtTipoSoldadura['pqr']}}
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th colspan="4">Equipo</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{$informe->internoEquipo->equipo->codigo}}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Temp. Mantenimiento </th>
                            <th colspan="2">Temp. Enfriado </th>
                        </tr>
                        <tr>
                            <td colspan="2">{{$informe->informeTt->temperatura_mantenimiento}} °C</td>
                            <td colspan="2">{{$informe->informeTt->temperatura_enfriado}} °C/Hs</td>
                        </tr>
                        <tr>
                            <th colspan="2">Norma Evaluación</th>
                            <th colspan="2">Norma Ensayo</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{$informe->normaEvaluacion['codigo']}}</td>
                            <td colspan="2">{{$informe->normaEnsayo['codigo']}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
