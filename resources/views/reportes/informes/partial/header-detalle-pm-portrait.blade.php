    <table width="100%" style="border-collapse:collapse;font-size:12px;">
        <tbody>
            <tr>
                <td width="49%">
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
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Procedimiento</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$procedimiento_inf->titulo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">EPS / WPS</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$ot_tipo_soldadura->eps}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Método</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$metodo->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Instrumento Medición</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$instrumento_medicion->equipo->codigo}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Tipo</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$instrumento_medicion->equipo->instrumento_medicion}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Vehículo</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($informe_pm->vehiculo)
                                           {{$informe_pm->vehiculo}}
                                       @else
                                            &nbsp;
                                       @endif
                                   </div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Aditivo</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($informe_pm->aditivo)
                                           {{$informe_pm->aditivo}}
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Partícula</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$particula->tipo}} / {{$particula->marca}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Color Partícula</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$particula->color->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Contraste</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if ($contraste)
                                           {{$contraste->tipo}} / {{$contraste->marca}}
                                       @else
                                            &nbsp;
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Técnica</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$tecnica->descripcion}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Ejecutor Ensayo</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$ejecutor_ensayo->name}}</div>
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
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Material</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$material->codigo}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">
                                       @if($material2)
                                           Material ( {{ $informe->material2_tipo }})
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($material2)
                                            {{$material2->codigo}}
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Plano / Isométrico</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe->plano_isom}}
                                       @if ($informe->hoja)
                                           - H:{{ $informe->hoja}}
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Diámetro</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$diametro_espesor->diametro}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Espesor</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if ($informe->espesor_chapa)
                                           {{ $informe->espesor_chapa }}
                                       @elseif($informe->espesor_especifico)
                                           {{ $informe->espesor_especifico }}
                                       @else
                                           {{ $diametro_espesor->espesor }}
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">PQR</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($ot_tipo_soldadura->pqr)
                                           {{$ot_tipo_soldadura->pqr}}
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Equipo</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$interno_equipo->equipo->codigo}}</div>
                               </td>
                               <td colspan="1" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">V</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_pm->voltaje}}</div>
                               </td>
                               <td colspan="1" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">A</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_pm->amperaje}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Tipo Magnetización</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($tipo_magnetizacion)
                                           {{$tipo_magnetizacion->codigo}}
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Desmagnetización</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if ($desmagnetizacion_sn)
                                           SI
                                       @else
                                           NO
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Magnetización</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$magnetizacion->codigo}}</div>
                               </td>
                               <td colspan="1" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Fueza Portante</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$magnetizacion->fuerza_portante}}</div>
                               </td>
                               <td colspan="1" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Concentración</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_pm->concentracion}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Iluminación</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$iluminacion->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Evaluación</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_evaluacion->codigo}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Ensayo</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_ensayo->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;vertical-align:top;">
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
