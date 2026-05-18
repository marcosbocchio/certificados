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
                               <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Recorrido del Terminal (mm)</div>
                               <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_rg->recorrido_terminal}}</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="4" style="padding:1px 4px 2px;vertical-align:top;">
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
                               <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Evaluación</div>
                               <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_evaluacion->codigo}}</div>
                           </td>
                           <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Norma Ensayo</div>
                               <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$norma_ensayo->codigo}}</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Cut off (mm)</div>
                               <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_rg->cut_off}}</div>
                           </td>
                           <td colspan="2" style="padding:1px 4px 2px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:7px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:0;">Rango (µm)</div>
                               <div style="font-size:10px;font-style:italic;color:#1C2340;">{{$informe_rg->rango_inicial}}-{{$informe_rg->rango_final}}</div>
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
