    <table class="header-detalle-principal">
        <tbody>
            <tr>
                <td width="49%">
                    <table style="font-size: 12px;" width="100%" class="header-detalle">
                        <tbody>

                           <tr>
                               <th width="100%" colspan="4">Componente</th>
                           </tr>
                           <tr>
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
                                <th colspan="2">Método</th>
                                <th colspan="2">Penetrante</th>
                           </tr>
                           <tr>
                                <td colspan="2">{{$metodo->tipo}}-{{$metodo->metodo}}</td>
                                <td colspan="2">
                                    @if($metodo->tipo =='TIPO I')
                                        Fluorescente
                                    @else
                                        Visible
                                    @endif
                                </td>
                           </tr>
                           <tr>
                                <th colspan="2">Líquido Revelador</th>
                                <th colspan="2">Aplicación Revelador</th>
                           </tr>
                           <tr>
                                <td colspan="2">
                                    {{$revelador->tipo}}
                                    @if ($revelador->marca)

                                        &nbsp;/&nbsp;{{$revelador->marca}}

                                    @endif
                                </td>
                                <td colspan="2">{{$revelador_aplicacion->codigo}}</td>
                           </tr>

                           <tr>
                                <th colspan="2">Limpieza Previa</th>
                                <th colspan="2">Limpieza Intermedia</th>
                           </tr>
                            <tr>
                                <td colspan="2" class="borderFilabottom">{{$informe_lp->limpieza_previa}}</td>
                                <td colspan="2" class="borderFilabottom">{{$informe_lp->limpieza_intermedia}}</td>
                            </tr>

                            <tr>
                                <th colspan="4">Limpieza Final</th>
                           </tr>
                           <tr>
                                <td colspan="4" class="borderFilabottom">
                                    @if ($informe_lp->limpieza_final)
                                         {{$informe_lp->limpieza_final}}
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
                                <th colspan="3">Instrumento Medición</th>
                                <th colspan="1">Iluminaciones </th>
                            </tr>
                            <tr>
                                <td colspan="3">{{$equipo->equipo->instrumento_medicion}} / {{$equipo->equipo->codigo}}</td>
                                <td colspan="1">{{$iluminacion->codigo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Líquido Penetrante.</th>
                                <th colspan="2">Aplicación Penetrante</th>
                           </tr>
                           <tr>
                                <td colspan="2">
                                    {{$penetrante->tipo}}

                                    @if ($penetrante->marca)
                                    &nbsp;/&nbsp;{{$penetrante->marca}}
                                    @else
                                         &nbsp;
                                    @endif

                                </td>
                                <td colspan="2">
                                    {{$penetrante_aplicacion->codigo}}
                                </td>
                           </tr>


                           <tr>
                            <th colspan="2">Líquido Removedor </th>
                            <th colspan="2">Aplicación Removedor </th>
                           </tr>
                           <tr>
                                <td colspan="2">
                                    {{$removedor->tipo}}
                                    @if ($removedor->marca)

                                    &nbsp;/&nbsp;{{$removedor->marca}}

                                    @endif
                                </td>
                                <td colspan="2">{{$removedor_aplicacion->codigo}}</td>
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
                                <td colspan="4" class="borderFilabottom">{{$ejecutor_ensayo->name}}</td>
                           </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
