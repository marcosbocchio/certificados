<table width="100%" style="border-collapse:collapse;font-size:12px;">
    <tbody>
        <tr>
            <td width="32.666%">
                <table width="100%" style="border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Componente</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->componente}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Plano / Isométrico</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->plano_isom}}
                                    @if ($informe->hoja)
                                     -H:{{ $informe->hoja}}
                                     @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">EPS / WPS</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($informe_rd->reparacion_sn)
                                      {{$ot_tipo_soldadura->proc_reparacion}}
                                    @else
                                        {{$ot_tipo_soldadura->eps}}
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Equipo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$interno_equipo->equipo->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Fuente</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if ($interno_fuente)
                                        {{$interno_fuente->fuente->codigo}}
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Lado</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_rd->lado}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Dist. Fuente / Film</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_rd->distancia_fuente_pelicula}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Técnica empleada</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$tecnica->codigo}}</div>
                            </td>
                            <td colspan="2" rowspan="4" style="text-align: center;vertical-align:middle;"><img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height:100px;margin-top: -10px;"></td>
                        </tr>

                    </tbody>
                </table>
            </td>
            <td width="1%">
                &nbsp;
            </td>
            <td width="32.666%">
                <table width="100%" style="border-collapse:collapse;float:right;">
                    <tbody>
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Material</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$material->codigo}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Procedimiento</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$procedimiento_inf->titulo}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">PQR</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if( !$informe_rd->reparacion_sn && $ot_tipo_soldadura->pqr)
                                          {{$ot_tipo_soldadura->pqr}}
                                    @else
                                        &nbsp;
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Actividad</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$actividad !== '' ? $actividad . ' Ci' : ''}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Evaluación</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$norma_evaluacion->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Filtros Aplicados</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $filtro_aplicado_rd ? $filtro_aplicado_rd->descripcion : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">ICI</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ici->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Nº de exposiciones</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_rd->exposicion}}</div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>
            <td width="1%">
                &nbsp;
            </td>
            <td width="32.666%">
                <table width="100%" style="border-collapse:collapse;float:right;">
                    <tbody>
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Linea</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($informe->linea)
                                        {{$informe->linea}}
                                    @else
                                        &nbsp;
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Diámetro</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if ($informe->diametro_espesor_id)
                                        {{$diametro_espesor->diametro}}
                                    @else
                                        {{$informe->diametro_especifico}}
                                    @endif
                                </div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Espesor</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if ($informe->espesor_chapa)
                                        {{ $informe->espesor_chapa }}
                                    @elseif($informe->espesor_especifico)
                                        {{ $informe->espesor_especifico }}
                                    @elseif($diametro_espesor->diametro == 'VARIOS')
                                        VARIOS
                                    @else
                                        {{ $diametro_espesor->espesor }}
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Dimensión detector</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $dimension_detector ? $dimension_detector->descripcion . ' cm' : '' }}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Tipo centellador</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $tipo_centellador ? $tipo_centellador->descripcion : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Pitch</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $informe_rd->pitch ? $informe_rd->pitch . ' µm' : '' }}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">SRb DWI</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $informe_rd->srb_dwi ? $informe_rd->srb_dwi . ' µm' : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Ensayo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$norma_ensayo->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Soft. de Adq.</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $software_adquisicion_rd ? $software_adquisicion_rd->descripcion : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Ejecutor Ensayo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ejecutor_ensayo->name}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Solicitante</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_solicitado_por ? $informe_solicitado_por->name : '' }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
