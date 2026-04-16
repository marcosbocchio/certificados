@php
    $diametro = '';
    if ($informe->diametro_espesor_id && $diametro_espesor) {
        $diametro = $diametro_espesor->diametro;
    } else {
        $diametro = $informe->diametro_especifico;
    }

    $espesor = '';
    if ($informe->espesor_chapa) {
        $espesor = $informe->espesor_chapa;
    } elseif ($informe->espesor_especifico) {
        $espesor = $informe->espesor_especifico;
    } elseif ($diametro_espesor && $diametro_espesor->diametro == 'VARIOS') {
        $espesor = 'VARIOS';
    } elseif ($diametro_espesor) {
        $espesor = $diametro_espesor->espesor;
    }
@endphp

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
                            <td colspan="4">{{ $informe->componente ?: 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th colspan="4">Linea</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{ $informe->linea ?: 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th colspan="4">Procedimiento</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{ $procedimiento_inf->titulo }}</td>
                        </tr>

                        <tr>
                            <th colspan="4">EPS / WPS</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                @if($informe_rd->reparacion_sn)
                                    {{ $ot_tipo_soldadura->proc_reparacion }}
                                @else
                                    {{ $ot_tipo_soldadura->eps }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Pelicula</th>
                            <th colspan="2">Tipo</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $tipo_pelicula->fabricante }}</td>
                            <td colspan="2">{{ $tipo_pelicula->codigo }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Pantalla</th>
                            <th>Ant</th>
                            <th>Pos</th>
                        </tr>
                        <tr>
                            <td colspan="2">Pb</td>
                            <td>{{ $informe_rd->pos_ant }}</td>
                            <td>{{ $informe_rd->pos_pos }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Lado Detector</th>
                            <th colspan="2">Dist. Fuente / Film</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $informe_rd->lado }}</td>
                            <td colspan="2">{{ $informe_rd->distancia_fuente_pelicula }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Tecnica empleada</th>
                            <th colspan="2">&nbsp;</th>
                        </tr>
                        <tr>
                            <td class="noBorder" colspan="2">{{ $tecnica->codigo }}</td>
                            <td colspan="2" rowspan="4" style="text-align: center;"><img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height: 100px;margin-top: -10px;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="49%">
                <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                    <tbody>
                        <tr>
                            <th width="50%" colspan="2">Material</th>
                            <th width="50%" colspan="2">
                                @if($material2)
                                    Material ( {{ $informe->material2_tipo }})
                                @else
                                    &nbsp;
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $material->codigo }}</td>
                            <td colspan="2">{{ $material2 ? $material2->codigo : '' }}</td>
                        </tr>

                        <tr>
                            <th colspan="4">Plano / Isometrico</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{ $informe->plano_isom }}
                                @if ($informe->hoja)
                                    - H:{{ $informe->hoja }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Diametro</th>
                            <th colspan="2">Espesor</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $diametro }}</td>
                            <td colspan="2">{{ $espesor }}</td>
                        </tr>

                        <tr>
                            <th colspan="4">PQR</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{ $ot_tipo_soldadura->pqr ?: '' }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Dimension detector</th>
                            <th colspan="2">Tipo Sentellador</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $dimension_detector ? $dimension_detector->descripcion : '' }}</td>
                            <td colspan="2">{{ $tipo_centellador ? $tipo_centellador->descripcion : '' }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Equipo</th>
                            <th colspan="2">Fuente</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $interno_equipo->equipo->codigo }}</td>
                            <td colspan="2">{{ $interno_fuente ? $interno_fuente->fuente->codigo : '' }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Actividad</th>
                            <th colspan="2">Picht</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $actividad }}</td>
                            <td colspan="2">{{ $informe_rd->pitch }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">SRb DWI</th>
                            <th colspan="2">ICI</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $informe_rd->srb_dwi }}</td>
                            <td colspan="2">{{ $ici->codigo }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">N&deg; de exposiciones</th>
                            <th colspan="2">Norma Evaluacion</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $informe_rd->exposicion }}</td>
                            <td colspan="2">{{ $norma_evaluacion->codigo }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Filtros Aplicados</th>
                            <th colspan="2">Norma Ensayo</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $filtro_aplicado_rd ? $filtro_aplicado_rd->descripcion : '' }}</td>
                            <td colspan="2">{{ $norma_ensayo->codigo }}</td>
                        </tr>

                        <tr>
                            <th colspan="2">Soft. de Adq.</th>
                            <th colspan="2">Ejecutor Ensayo</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $software_adquisicion_rd ? $software_adquisicion_rd->descripcion : '' }}</td>
                            <td colspan="2" class="borderFilabottom">{{ $ejecutor_ensayo->name }}</td>
                        </tr>

                        <tr>
                            <th colspan="4">Solicitante</th>
                        </tr>
                        <tr>
                            <td colspan="4" class="borderFilabottom">{{ $informe_solicitado_por ? $informe_solicitado_por->name : '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
