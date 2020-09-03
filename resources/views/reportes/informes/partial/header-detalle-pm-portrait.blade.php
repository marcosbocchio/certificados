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
                               <th  width="100%" colspan="4">Plano / Isométrico</th>
                           </tr>
                           <tr>
                                <td colspan="4">{{$informe->plano_isom}}</td>
                           </tr>

                           <tr >
                                <th colspan="4">EPS</th>
                           </tr>
                           <tr>
                                <td colspan="4">{{$ot_tipo_soldadura->eps}}</td>
                           </tr>

                           <tr>
                                <th colspan="4">Procedimiento</th>
                           </tr>
                           <tr>
                                <td colspan="4">{{$procedimiento_inf->titulo}}</td>
                           </tr>

                           <tr>
                                <th colspan="4">Método</th>
                           </tr>
                           <tr>
                               <td colspan="4">{{$metodo->codigo}}</td>
                           </tr>

                           <tr>
                                <th colspan="2">Instrumento Medición</th>
                                <th colspan="2">Tipo</th>
                           </tr>
                           <tr>
                                <td colspan="2">{{$instrumento_medicion->equipo->codigo}}</td>
                                <td colspan="2">{{$instrumento_medicion->equipo->instrumento_medicion}}</td>
                           </tr>

                           <tr>
                                <th colspan="2">Vehículo</th>
                                <th colspan="2">Aditivo</th>
                           </tr>
                           <tr>
                                <td colspan="2">
                                    @if($informe_pm->vehiculo)
                                        {{$informe_pm->vehiculo}}
                                    @else
                                         &nbsp;
                                    @endif
                                </td>
                                <td colspan="2">
                                    @if($informe_pm->aditivo)
                                        {{$informe_pm->aditivo}}
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                           </tr>

                           <tr>
                               <th colspan="2">Partícula</th>
                               <th colspan="2">Color Partícula</th>
                           </tr>
                           <tr>
                               <td colspan="2">{{$particula->tipo}} / {{$particula->marca}}</td>
                               <td colspan="2">{{$particula->color->codigo}}</td>
                           </tr>

                           <tr>
                               <th colspan="4">Contraste</th>
                           </tr>
                           <tr>
                               <td colspan="4">
                                @if ($contraste)

                                    {{$contraste->tipo}} / {{$contraste->marca}}

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

                           <tr >
                               <th width="50%" colspan="2">Material</th>
                               <th width="50%" colspan="2">Material ( {{ $informe->material2_tipo }})</th>
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
                                <th colspan="2">Diámetro</th>
                                <th colspan="2">Espesor</th>
                           </tr>
                            <tr>
                                <td colspan="2">{{$diametro_espesor->diametro}}</td>
                                <td colspan="2">
                                    @if ($informe->espesor_chapa)
                                        {{ $informe->espesor_chapa }}
                                    @elseif($informe->espesor_especifico)
                                        {{ $informe->espesor_especifico }}
                                    @else
                                        {{ $diametro_espesor->espesor }}
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
                                <th colspan="2">Equipo</th>
                                <th colspan="1">Kv</th>
                                <th colspan="1">mA</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$interno_equipo->equipo->codigo}}</td>
                                <td colspan="1">{{$informe_pm->voltaje}}</td>
                                <td colspan="1">{{$informe_pm->amperaje}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Tipo Magnetización</th>
                                <th colspan="2">Desmagnetización</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if($tipo_magnetizacion)
                                        {{$tipo_magnetizacion->codigo}}
                                    @else
                                        &nbsp;
                                    @endif
                                </td>
                                <td colspan="2">
                                    @if ($desmagnetizacion_sn)
                                        SI
                                    @else
                                        NO
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Magnetización</th>
                                <th colspan="1">Fueza Portante</th>
                                <th colspan="1">Concentración</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$magnetizacion->codigo}}</td>
                                <td colspan="1">{{$magnetizacion->fuerza_portante}}</td>
                                <td colspan="1">{{$informe_pm->concentracion}}</td>
                            </tr>

                            <tr>
                                <th colspan="4">Iluminación</th>
                            </tr>
                            <tr>
                                <td colspan="4">{{$iluminacion->codigo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Norma Evaluación</th>
                                <th colspan="2">Norma Ensayo</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$norma_evaluacion->codigo}}</td>
                                <td colspan="2">{{$norma_ensayo->codigo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Técnica</th>
                                <th colspan="2">Ejecutor Ensayo</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="borderFilabottom">{{$tecnica->descripcion}}</td>
                                <td colspan="2" class="borderFilabottom">{{$ejecutor_ensayo->name}}</td>
                            </tr>
                       </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
