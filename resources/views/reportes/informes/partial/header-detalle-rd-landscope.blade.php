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
                            <td colspan="4">{!! $informe->componente ? e($informe->componente) : '&nbsp;' !!}</td>
                        </tr>

                        <tr>
                            <th colspan="4" >Plano / Isométrico</th>
                        </tr>
                        <tr>
                             <td colspan="4">{!! $informe->plano_isom ? e($informe->plano_isom) : '&nbsp;' !!}
                                @if ($informe->hoja)
                                 -H:{{ $informe->hoja}}
                                 @endif
                             </td>
                        </tr>

                        <tr>
                            <th colspan="4">EPS / WPS</th>
                        </tr>
                        <tr>
                            @if($informe_rd->reparacion_sn)
                              <td colspan="4">{!! $ot_tipo_soldadura->proc_reparacion ? e($ot_tipo_soldadura->proc_reparacion) : '&nbsp;' !!}</td>
                            @else
                                <td colspan="4">{!! $ot_tipo_soldadura->eps ? e($ot_tipo_soldadura->eps) : '&nbsp;' !!}</td>
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
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Lado</th>
                            <th colspan="2">Dist. Fuente / Film</th>
                       </tr>

                       <tr>
                            <td colspan="2">{!! $informe_rd->lado ? e($informe_rd->lado) : '&nbsp;' !!}</td>
                            <td colspan="2">{!! $informe_rd->distancia_fuente_pelicula ? e($informe_rd->distancia_fuente_pelicula) : '&nbsp;' !!}</td>
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
                            <th colspan="4">Material</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{$material->codigo}}</td>
                        </tr>

                        <tr>
                            <th colspan="4">Procedimiento</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{$procedimiento_inf->titulo}}</td>
                        </tr>

                        <tr>
                            <th colspan="4">PQR</th>
                        </tr>
                        <tr >
                            <td colspan="4">
                            @if( !$informe_rd->reparacion_sn && $ot_tipo_soldadura->pqr)
                                  {{$ot_tipo_soldadura->pqr}}
                            @else
                                &nbsp;
                            @endif
                            </td>
                        </tr>
                        @if($es_rayos_x)
                        <tr>
                            <th colspan="2">Kv</th>
                            <th colspan="2">mA</th>
                        </tr>
                        <tr>
                            <td colspan="2">{!! $kv ? e($kv) : '&nbsp;' !!}</td>
                            <td colspan="2">{!! $ma ? e($ma) : '&nbsp;' !!}</td>
                        </tr>
                        @else
                        <tr>
                            <th colspan="4">Actividad</th>
                        </tr>
                        <tr>
                            <td colspan="4">{!! $actividad !== '' ? e($actividad . ' Ci') : '&nbsp;' !!}</td>
                        </tr>
                        @endif
                        <tr>
                            <th colspan="2">Norma Evaluación</th>
                            <th colspan="2">Filtros Aplicados</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{$norma_evaluacion->codigo}}</td>
                            <td colspan="2">{!! $filtro_aplicado_rd ? e($filtro_aplicado_rd->descripcion) : '&nbsp;' !!}</td>
                        </tr>

                        <tr>
                            <th colspan="2">ICI</th>
                            <th colspan="2">Nº de exposiciones</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{$ici->codigo}}</td>
                            <td colspan="2">{{$informe_rd->exposicion}}</td>
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
                            <th colspan="2">Dimensión detector</th>
                            <th colspan="2">Tipo centellador</th>
                        </tr>
                        <tr>
                            <td colspan="2">{!! $dimension_detector ? e($dimension_detector->descripcion . ' cm') : '&nbsp;' !!}</td>
                            <td colspan="2">{!! $tipo_centellador ? e($tipo_centellador->descripcion) : '&nbsp;' !!}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Pitch</th>
                            <th colspan="2">SRb DWI</th>
                        </tr>
                        <tr>
                            <td colspan="2">{!! $informe_rd->pitch ? e($informe_rd->pitch . ' µm') : '&nbsp;' !!}</td>
                            <td colspan="2">{!! $informe_rd->srb_dwi ? e($informe_rd->srb_dwi . ' µm') : '&nbsp;' !!}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Norma Ensayo</th>
                            <th colspan="2">Soft. de Adq.</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{$norma_ensayo->codigo}}</td>
                            <td colspan="2">{!! $software_adquisicion_rd ? e($software_adquisicion_rd->descripcion) : '&nbsp;' !!}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Ejecutor Ensayo</th>
                            <th colspan="2">Solicitante</th>
                        </tr>
                        <tr>
                            <td colspan="2" class="">{{$ejecutor_ensayo->name}}</td>
                            <td colspan="2" class="">{!! $informe_solicitado_por ? e($informe_solicitado_por->name) : '&nbsp;' !!}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
