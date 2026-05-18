<table width="100%" style="border-collapse:collapse;font-size:12px;">
    <tbody>
        <tr>
            {{-- ══ COLUMNA IZQUIERDA ══ --}}
            <td width="49%" style="vertical-align:top;padding-right:6px;">
                <table width="100%" style="border-collapse:collapse;">
                    <tbody>

                        {{-- Componente --}}
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Componente</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->componente}}</div>
                            </td>
                        </tr>

                        {{-- Linea --}}
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Línea</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $informe->linea ?: '—' }}</div>
                            </td>
                        </tr>

                        {{-- Procedimiento --}}
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Procedimiento</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$procedimiento_inf->titulo}}</div>
                            </td>
                        </tr>

                        {{-- EPS / WPS --}}
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">EPS / WPS</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ot_tipo_soldadura->eps}}</div>
                            </td>
                        </tr>

                        {{-- Película | Tipo --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Película</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$tipo_pelicula->fabricante}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Tipo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$tipo_pelicula->codigo}}</div>
                            </td>
                        </tr>

                        {{-- Pantalla | Ant | Pos --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Pantalla</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">Pb</div>
                            </td>
                            <td colspan="1" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Ant</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_ri->pos_ant}}</div>
                            </td>
                            <td colspan="1" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Pos</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_ri->pos_pos}}</div>
                            </td>
                        </tr>

                        {{-- Lado | Dist. Fuente / Film --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Lado</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_ri->lado}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Dist. Fuente / Film</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_ri->distancia_fuente_pelicula}}</div>
                            </td>
                        </tr>

                        {{-- Técnica Empleada + diagrama --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Técnica Empleada</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$tecnica->codigo}}</div>
                            </td>
                            <td colspan="2" rowspan="4" style="text-align:center;padding:4px 5px;vertical-align:middle;">
                                <img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height:96px;margin-top:-6px;">
                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>

            <td width="2%">&nbsp;</td>

            {{-- ══ COLUMNA DERECHA ══ --}}
            <td width="49%" style="vertical-align:top;padding-left:6px;">
                <table width="100%" style="border-collapse:collapse;">
                    <tbody>

                        {{-- Material --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Material</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$material->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                @if($material2)
                                    <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Material ({{ $informe->material2_tipo }})</div>
                                    <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$material2->codigo}}</div>
                                @endif
                            </td>
                        </tr>

                        {{-- Plano / Isométrico --}}
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Plano / Isométrico</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    {{$informe->plano_isom}}@if($informe->hoja) - H:{{$informe->hoja}}@endif
                                </div>
                            </td>
                        </tr>

                        {{-- Diámetro | Espesor --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Diámetro</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($informe->diametro_espesor_id) {{$diametro_espesor->diametro}} @else {{$informe->diametro_especifico}} @endif
                                </div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Espesor</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($informe->espesor_chapa) {{$informe->espesor_chapa}}
                                    @elseif($informe->espesor_especifico) {{$informe->espesor_especifico}}
                                    @elseif($diametro_espesor->diametro == 'VARIOS') VARIOS
                                    @else {{$diametro_espesor->espesor}} @endif
                                </div>
                            </td>
                        </tr>

                        {{-- PQR --}}
                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">PQR</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if(!$informe_ri->reparacion_sn && $ot_tipo_soldadura->pqr) {{$ot_tipo_soldadura->pqr}} @else &nbsp; @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Equipo | Fuente --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Equipo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$interno_equipo->equipo->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Fuente</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $interno_fuente ? $interno_fuente->fuente->codigo : '—' }}</div>
                            </td>
                        </tr>

                        {{-- Actividad Fuente / kv | Foco / mA --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">
                                    @if($interno_fuente) Actividad Fuente @else kv @endif
                                </div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($interno_fuente) {{$actividad}} @else {{$informe_ri->kv}} @endif
                                </div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">
                                    @if($interno_fuente) Foco @else mA @endif
                                </div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($interno_fuente) {{$interno_fuente->foco}} @else {{$informe_ri->ma}} @endif
                                </div>
                            </td>
                        </tr>

                        {{-- ICI | Nº de exposiciones --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">ICI</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ici->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Nº de exposiciones</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_ri->exposicion}}</div>
                            </td>
                        </tr>

                        {{-- Norma Evaluación | Norma Ensayo --}}
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Evaluación</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$norma_evaluacion->codigo}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Ensayo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$norma_ensayo->codigo}}</div>
                            </td>
                        </tr>

                        {{-- Ejecutor Ensayo | Solicitante / Tamaño bola --}}
                        @if($informe_ri->perfil_sn)
                            <tr>
                                <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                    <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Ejecutor Ensayo</div>
                                    <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ejecutor_ensayo->name}}</div>
                                </td>
                                <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                    <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Tamaño bola comparadora</div>
                                    <div style="font-size:12px;font-style:italic;color:#1C2340;">25.4 mm</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="padding:4px 5px 5px;vertical-align:top;">
                                    <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Solicitante</div>
                                    <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $informe_solicitado_por ? $informe_solicitado_por->name : '—' }}</div>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                    <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Ejecutor Ensayo</div>
                                    <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ejecutor_ensayo->name}}</div>
                                </td>
                                <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                    <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Solicitante</div>
                                    <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $informe_solicitado_por ? $informe_solicitado_por->name : '—' }}</div>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
