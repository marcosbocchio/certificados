    <table class="header-detalle-principal" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <td width="32.666%">
                    <table style="font-size: 12px;" width="100%" class="header-detalle">
                        <tbody >
                            <tr>
                                <th width="100%" colspan="4">Componente</th>
                            </tr>
                            <tr >
                                <td colspan="4">{{$informe->componente}}</td>
                            </tr>

                            <tr>
                                <th colspan="4" >Plano / Isométrico</th>
                            </tr>
                            <tr>
                                 <td colspan="4">{{$informe->plano_isom}}
                                    @if ($informe->hoja)
                                     -H:{{ $informe->hoja}}
                                     @endif
                                 </td>
                            </tr>

                            <tr>
                                <th colspan="4">EPS / WPS</th>
                            </tr>
                            <tr>
                                @if($informe_ri->reparacion_sn)
                                  <td colspan="4">{{$ot_tipo_soldadura->proc_reparacion}}</td>
                                @else
                                    <td colspan="4">{{$ot_tipo_soldadura->eps}}</td>
                                @endif

                            </tr>

                            <tr>
                                <th colspan="2">Equipo</th>
                                <th colspan="2">Fuente</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$interno_equipo->equipo->codigo}}</td>
                                <td colspan="2">
                                    @if ($interno_fuente)

                                        {{$interno_fuente->fuente->codigo}}

                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Lado</th>
                                <th colspan="2">Dist. Fuente / Film</th>
                           </tr>

                           <tr>
                                <td colspan="2">{{$informe_ri->lado}}</td>
                                <td colspan="2">{{$informe_ri->distancia_fuente_pelicula}}</td>
                           </tr>


                           <tr>
                                <th colspan="2">Técnica empleada</th>
                                <th colspan="2"> &nbsp;</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="noBorder">{{$tecnica->codigo}}</td>
                                <td colspan="2" rowspan="4" style="text-align: center;"><img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height:100px;margin-top: -10px;"></td>
                            </tr>

                        </tbody>
                    </table>
                </td>
                <td width="1%">
                    &nbsp;
                </td>
                <td width="32.666%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>
                            <tr>
                                <th colspan="2">Material</th>
                                <th width="50%" colspan="2">
                                    @if($material2)
                                        Material ( {{ $informe->material2_tipo }})
                                     @else
                                          &nbsp;
                                      @endif
                                 </th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$material->codigo}}</td>
                                <td colspan="2">
                                     @if($material2)
                                          {{$material2->codigo}}
                                     @endif
                                </td>
                            </tr>

                            <tr>
                                <th colspan="4">Procedimiento</th>
                            </tr>
                            <tr>
                                <td colspan="4">{{$procedimiento_inf->titulo}}</td>
                            </tr>

                            @if($cliente->id != 158)
                                <tr>
                                    <th colspan="4">PQR</th>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        @if( !$informe_ri->reparacion_sn && $ot_tipo_soldadura->pqr)
                                            {{$ot_tipo_soldadura->pqr}}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                @if ($interno_fuente)
                                    <th colspan="2">Actividad Fuente</th>
                                    <th colspan="2">Foco</th>
                                @else
                                    <th colspan="2">kv</th>
                                    <th colspan="2">mA</th>
                                @endif
                            </tr>
                            
                            <tr>
                                @if ($interno_fuente)
                                    <td colspan="2">{{$actividad}}</td>
                                    <td colspan="2">
                                            @if ($interno_fuente)
                                            {{$interno_fuente->foco}}
                                            @else
                                                {{$interno_equipo->foco}}
                                            @endif
                                    </td>
                                @else                                        
                                    <td colspan="2">{{ $informe_ri->kv }}</td>
                                    <td colspan="2"> {{ $informe_ri->ma }} </td>
                                @endif
                            </tr>

                            <tr>
                               <th colspan="4">Norma Evaluación</th>
                            </tr>
                            <tr>
                                <td colspan="4">{{$norma_evaluacion->codigo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">ICI</th>
                                <th colspan="2">Nº de exposiciones</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$ici->codigo}}</td>
                                <td colspan="2">{{$informe_ri->exposicion}}</td>
                            </tr>

                        </tbody>
                    </table>
                </td>
                <td width="1%">
                    &nbsp;
                </td>
                <td width="32.666%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>
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
                                <th colspan="2">Diámetro</th>
                                <th colspan="2">Espesor</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if ($informe->diametro_espesor_id)
                                        {{$diametro_espesor->diametro}}
                                    @else
                                        {{$informe->diametro_especifico}}
                                    @endif
                                </td>
                                <td colspan="2">
                                    @if ($informe->espesor_chapa)
                                        {{ $informe->espesor_chapa }}
                                    @elseif($informe->espesor_especifico)
                                        {{ $informe->espesor_especifico }}
                                    @elseif($diametro_espesor->diametro == 'VARIOS')
                                        VARIOS
                                    @else
                                        {{ $diametro_espesor->espesor }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Película</th>
                                <th colspan="2">Tipo</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$tipo_pelicula->fabricante}}</td>
                                <td colspan="2">{{$tipo_pelicula->codigo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Pantalla</th>
                                <th colspan="1">Ant</th>
                                <th colspan="1">Pos</th>
                           </tr>
                           <tr>
                                <td colspan="2">Pb</td>
                                <td colspan="1">{{$informe_ri->pos_ant}}</td>
                                <td colspan="1">{{$informe_ri->pos_pos}}</td>
                           </tr>

                            <tr>
                                <th colspan="4">Norma Ensayo</th>
                            </tr>
                            <tr>
                                <td colspan="4" class="borderFilabottom">{{$norma_ensayo->codigo}}</td>
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
