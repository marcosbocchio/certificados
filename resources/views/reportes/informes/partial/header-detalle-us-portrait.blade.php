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
                                <th colspan="2" >Linea</th>
                                <th colspan="2" >Plano / Isométrico</th>
                           </tr>
                           <tr>
                                <td colspan="2">{{$informe->linea}}</td>
                                <td colspan="2">{{$informe->plano_isom}}
                                    @if ($informe->hoja)
                                        - H:{{ $informe->hoja}}
                                    @endif
                                </td>
                            </tr>

                           <tr>
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
                                <th colspan="2">Encoder</th>
                                <th colspan="2">Estado Superficie</th>
                           </tr>
                           <tr>
                                <td colspan="2">{{$informe_us->encoder}}</td>
                                <td colspan="2">{{$estado_superficie->codigo}}</td>
                           </tr>

                            <tr>
                                <th colspan="2">Agente Acoplamiento </th>
                                <th colspan="2">Técnica</th>
                           </tr>
                           <tr>
                                <td colspan="2">{{$agente_acoplamiento->codigo}}</td>
                                <td colspan="2">{{$tecnica->descripcion}}</td>
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
                                <th colspan="2">Diámetro</th>
                                <th colspan="2">Espesor</th>
                           </tr>
                            <tr>
                                <td colspan="2">{{$diametro_espesor->diametro}}</td>
                                <td>
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
                                <th colspan="4">Equipo</th>

                            </tr>
                            <tr>
                                <td colspan="4">{{$interno_equipo->equipo->codigo}}</td>

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
                                <th colspan="4">Ejecutor Ensayo</th>
                            </tr>
                            <tr>
                                <td colspan="4">{{$ejecutor_ensayo->name}}</td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
