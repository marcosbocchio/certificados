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

    $pqr = (!$informe_rd->reparacion_sn && $ot_tipo_soldadura->pqr) ? $ot_tipo_soldadura->pqr : '';
    $fuente = $interno_fuente ? $interno_fuente->fuente->codigo : '';
    $solicitante = $informe_solicitado_por ? $informe_solicitado_por->name : '';
@endphp

<table width="100%" class="header-detalle" style="font-size: 12px; border-collapse: collapse;">
    <tbody>
        <tr>
            <th colspan="2">Componente</th>
            <th colspan="2">Material</th>
            <th colspan="2">Linea</th>
        </tr>
        <tr>
            <td colspan="2">{{ $informe->componente ?: 'N/A' }}</td>
            <td colspan="2">{{ $material ? $material->codigo : '' }}</td>
            <td colspan="2">{{ $informe->linea ?: 'N/A' }}</td>
        </tr>

        <tr>
            <th colspan="2">Plano / Isom&eacute;trico</th>
            <th colspan="2">Procedimiento</th>
            <th>Di&aacute;metro</th>
            <th>Espesor</th>
        </tr>
        <tr>
            <td colspan="2">
                {{ $informe->plano_isom ?: 'N/A' }}
                @if ($informe->hoja)
                    - H:{{ $informe->hoja }}
                @endif
            </td>
            <td colspan="2">{{ $procedimiento_inf->titulo }}</td>
            <td>{{ $diametro }}</td>
            <td>{{ $espesor }}</td>
        </tr>

        <tr>
            <th colspan="2">EPS / WPS</th>
            <th colspan="2">PQR</th>
            <th>Dimension Detector</th>
            <th>Tipo Sentellador</th>
        </tr>
        <tr>
            <td colspan="2">
                @if($informe_rd->reparacion_sn)
                    {{ $ot_tipo_soldadura->proc_reparacion }}
                @else
                    {{ $ot_tipo_soldadura->eps }}
                @endif
            </td>
            <td colspan="2">{{ $pqr }}</td>
            <td>{{ $dimension_detector ? $dimension_detector->descripcion : '' }}</td>
            <td>{{ $tipo_centellador ? $tipo_centellador->descripcion : '' }}</td>
        </tr>

        <tr>
            <th>Equipo</th>
            <th>Fuente</th>
            <th colspan="2">Actividad</th>
            <th>Picht</th>
            <th>SRb DWI</th>
        </tr>
        <tr>
            <td>{{ $interno_equipo->equipo->codigo }}</td>
            <td>{{ $fuente }}</td>
            <td colspan="2">{{ $actividad }}</td>
            <td>{{ $informe_rd->pitch }}</td>
            <td>{{ $informe_rd->srb_dwi }}</td>
        </tr>

        <tr>
            <th>Lado Detector</th>
            <th>Dist. Fuente / Film</th>
            <th>Norma Evaluacion</th>
            <th>Filtros Aplicados</th>
            <th>Norma Ensayo</th>
            <th>Soft. de Adq.</th>
        </tr>
        <tr>
            <td>{{ $informe_rd->lado }}</td>
            <td>{{ $informe_rd->distancia_fuente_pelicula }}</td>
            <td>{{ $norma_evaluacion->codigo }}</td>
            <td>{{ $filtro_aplicado_rd ? $filtro_aplicado_rd->descripcion : '' }}</td>
            <td>{{ $norma_ensayo->codigo }}</td>
            <td>{{ $software_adquisicion_rd ? $software_adquisicion_rd->descripcion : '' }}</td>
        </tr>

        <tr>
            <th>Tecnica empleada</th>
            <th>ICI</th>
            <th>N&deg; de exposiciones</th>
            <th>Ejecutor Ensayo</th>
            <th colspan="2">Solicitante</th>
        </tr>
        <tr>
            <td class="borderFilabottom">{{ $tecnica->codigo }}</td>
            <td class="borderFilabottom">{{ $ici->codigo }}</td>
            <td class="borderFilabottom">{{ $informe_rd->exposicion }}</td>
            <td class="borderFilabottom">{{ $ejecutor_ensayo->name }}</td>
            <td colspan="2" class="borderFilabottom">{{ $solicitante }}</td>
        </tr>
    </tbody>
</table>
