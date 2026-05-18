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
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$procedimiento_inf->titulo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">EPS / WPS</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ot_tipo_soldadura->eps}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Método</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$metodo->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Instrumento Medición</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$instrumento_medicion->equipo->codigo}}</div>
                               </td>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Tipo</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$instrumento_medicion->equipo->instrumento_medicion}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Vehículo</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                       @if($informe_pm->vehiculo)
                                           {{$informe_pm->vehiculo}}
                                       @else
                                            &nbsp;
                                       @endif
                                   </div>
                               </td>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Aditivo</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                       @if($informe_pm->aditivo)
                                           {{$informe_pm->aditivo}}
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Partícula</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$particula->tipo}} / {{$particula->marca}}</div>
                               </td>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Color Partícula</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$particula->color->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Contraste</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                       @if ($contraste)
                                           {{$contraste->tipo}} / {{$contraste->marca}}
                                       @else
                                            &nbsp;
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Técnica</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$tecnica->descripcion}}</div>
                               </td>
                               <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Ejecutor Ensayo</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ejecutor_ensayo->name}}</div>
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
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$material->codigo}}</div>
                               </td>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">
                                       @if($material2)
                                           Material ( {{ $informe->material2_tipo }})
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                       @if($material2)
                                            {{$material2->codigo}}
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
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Diámetro</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$diametro_espesor->diametro}}</div>
                               </td>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Espesor</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
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
                               <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">PQR</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                       @if($ot_tipo_soldadura->pqr)
                                           {{$ot_tipo_soldadura->pqr}}
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Equipo</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$interno_equipo->equipo->codigo}}</div>
                               </td>
                               <td colspan="1" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">V</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_pm->voltaje}}</div>
                               </td>
                               <td colspan="1" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">A</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_pm->amperaje}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Tipo Magnetización</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                       @if($tipo_magnetizacion)
                                           {{$tipo_magnetizacion->codigo}}
                                       @else
                                           &nbsp;
                                       @endif
                                   </div>
                               </td>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Desmagnetización</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">
                                       @if ($desmagnetizacion_sn)
                                           SI
                                       @else
                                           NO
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Magnetización</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$magnetizacion->codigo}}</div>
                               </td>
                               <td colspan="1" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Fueza Portante</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$magnetizacion->fuerza_portante}}</div>
                               </td>
                               <td colspan="1" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Concentración</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_pm->concentracion}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Iluminación</div>
                                   <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$iluminacion->codigo}}</div>
                               </td>
                           </tr>

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

                           <tr>
                               <td colspan="4" style="padding:4px 5px 5px;vertical-align:top;">
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
