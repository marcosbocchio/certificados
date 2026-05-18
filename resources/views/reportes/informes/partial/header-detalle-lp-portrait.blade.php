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
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Método</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$metodo->tipo}}-{{$metodo->metodo}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Penetrante</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($metodo->tipo =='TIPO I')
                                           Fluorescente
                                       @else
                                           Visible
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Líquido Revelador</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       {{$revelador->tipo}}
                                       @if ($revelador->marca)
                                           &nbsp;/&nbsp;{{$revelador->marca}}
                                       @endif
                                   </div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Aplicación Revelador</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$revelador_aplicacion->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Limpieza Previa</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_lp->limpieza_previa}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Limpieza Intermedia</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_lp->limpieza_intermedia}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="4" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Limpieza Final</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if ($informe_lp->limpieza_final)
                                            {{$informe_lp->limpieza_final}}
                                       @else
                                             &nbsp;
                                       @endif
                                   </div>
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
                               <td colspan="3" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Instrumento Medición</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($equipo && $equipo->equipo)
                                           {{ $equipo->equipo->instrumento_medicion . ' / ' . $equipo->equipo->codigo }}
                                       @else
                                           {{ '-' }}
                                       @endif
                                   </div>
                               </td>
                               <td colspan="1" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Iluminaciones</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       @if($equipo && $equipo->equipo)
                                           {{$iluminacion->codigo}}
                                       @else
                                           luz natural
                                       @endif
                                   </div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Líquido Penetrante.</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       {{$penetrante->tipo}}
                                       @if ($penetrante->marca)
                                       &nbsp;/&nbsp;{{$penetrante->marca}}
                                       @else
                                            &nbsp;
                                       @endif
                                   </div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Aplicación Penetrante</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$penetrante_aplicacion->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Líquido Removedor</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">
                                       {{$removedor->tipo}}
                                       @if ($removedor->marca)
                                       &nbsp;/&nbsp;{{$removedor->marca}}
                                       @endif
                                   </div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Aplicación Removedor</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$removedor_aplicacion->codigo}}</div>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Evaluación</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_evaluacion->codigo}}</div>
                               </td>
                               <td colspan="2" style="padding:1px 4px 2px;vertical-align:top;">
                                   <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Ensayo</div>
                                   <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_ensayo->codigo}}</div>
                               </td>
                           </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
