<table width="100%" style="border-collapse:collapse;font-size:12px;">
    <tbody>
        <tr>
            <td width="49%">
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
                           <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Procedimiento</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->procedimiento['titulo']}}</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">EPS / WPS</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{ $informe->OtTipoSoldadura['eps']}}</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Temp. Inicial</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->informeTt->temperatura_inicial}} °C</div>
                           </td>
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Temp. Subida</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->informeTt->temperatura_subida}} °C/Hs</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Temp. Final</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->informeTt->temperatura_final}} °C</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Ejecutor Ensayo</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->ejecutor_ensayo['name']}}</div>
                           </td>
                           <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Solicitante</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                   @if($informe->solicitadoPor)
                                        {{ $informe->solicitadoPor['name'] }}
                                   @else
                                       &nbsp;
                                   @endif
                               </div>
                           </td>
                       </tr>

                    </tbody>
                </table>
            </td>
            <td width="2%">
                &nbsp;
            </td>
            <td width="49%">
                <table width="100%" style="border-collapse:collapse;float:right;">
                    <tbody>
                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Material</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->material['codigo']}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">
                                    @if($informe->material2)
                                        Material ( {{ $informe->material2_tipo }})
                                    @else
                                        &nbsp;
                                    @endif
                                </div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($informe->material2)
                                         {{$informe->material2['codigo']}}
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Plano / Isométrico</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->plano_isom}}
                                    @if ($informe->hoja)
                                        - H:{{ $informe->hoja}}
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">PQR</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                    @if($informe->OtTipoSoldadura)
                                        {{$informe->OtTipoSoldadura['pqr']}}
                                    @else
                                        &nbsp;
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Equipo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->internoEquipo->equipo->codigo}}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Temp. Mantenimiento</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->informeTt->temperatura_mantenimiento}} °C</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Temp. Enfriado</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->informeTt->temperatura_enfriado}} °C/Hs</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Evaluación</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->normaEvaluacion['codigo']}}</div>
                            </td>
                            <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Ensayo</div>
                                <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe->normaEnsayo['codigo']}}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
