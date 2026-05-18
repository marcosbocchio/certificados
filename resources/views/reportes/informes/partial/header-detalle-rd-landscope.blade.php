<table width="100%" style="border-collapse:collapse;font-size:12px;">
    <tbody>
        <tr>
            <td width="32.666%">
                <table width="100%" style="border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Componente</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe->componente}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Plano / Isométrico</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe->plano_isom}}
                                    @if ($informe->hoja)
                                     -H:{{ $informe->hoja}}
                                     @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">EPS / WPS</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                    @if($informe_rd->reparacion_sn)
                                      {{$ot_tipo_soldadura->proc_reparacion}}
                                    @else
                                        {{$ot_tipo_soldadura->eps}}
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Equipo</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$interno_equipo->equipo->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Fuente</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                    @if ($interno_fuente)
                                        {{$interno_fuente->fuente->codigo}}
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Lado</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_rd->lado}}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Dist. Fuente / Film</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_rd->distancia_fuente_pelicula}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Técnica empleada</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$tecnica->codigo}}</div>
                            </td>
                            <td colspan="2" rowspan="4" style="text-align: center;vertical-align:middle;"><img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height:65px;"></td>
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
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Material</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$material->codigo}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Procedimiento</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$procedimiento_inf->titulo}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">PQR</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                    @if( !$informe_rd->reparacion_sn && $ot_tipo_soldadura->pqr)
                                          {{$ot_tipo_soldadura->pqr}}
                                    @else
                                        &nbsp;
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Actividad</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$actividad !== '' ? $actividad . ' Ci' : ''}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Evaluación</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_evaluacion->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Filtros Aplicados</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{ $filtro_aplicado_rd ? $filtro_aplicado_rd->descripcion : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">ICI</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$ici->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Nº de exposiciones</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_rd->exposicion}}</div>
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
                            <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Linea</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                    @if($informe->linea)
                                        {{$informe->linea}}
                                    @else
                                        &nbsp;
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Diámetro</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                    @if ($informe->diametro_espesor_id)
                                        {{$diametro_espesor->diametro}}
                                    @else
                                        {{$informe->diametro_especifico}}
                                    @endif
                                </div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Espesor</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">
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
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Dimensión detector</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{ $dimension_detector ? $dimension_detector->descripcion . ' cm' : '' }}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Tipo centellador</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{ $tipo_centellador ? $tipo_centellador->descripcion : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Pitch</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{ $informe_rd->pitch ? $informe_rd->pitch . ' µm' : '' }}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">SRb DWI</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{ $informe_rd->srb_dwi ? $informe_rd->srb_dwi . ' µm' : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Ensayo</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_ensayo->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Soft. de Adq.</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{ $software_adquisicion_rd ? $software_adquisicion_rd->descripcion : '' }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Ejecutor Ensayo</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$ejecutor_ensayo->name}}</div>
                            </td>
                            <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Solicitante</div>
                                <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_solicitado_por ? $informe_solicitado_por->name : '' }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
