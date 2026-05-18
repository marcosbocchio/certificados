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
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Línea</div>
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
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Estado superficie</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_estado_superficie->codigo}}</div>
                           </td>
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Medicion Dureza</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_unidad_medicion_dureza->descripcion}}</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Probeta calibración</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_interno_equipo->probeta}}</div>
                           </td>
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Dureza calibración</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_interno_equipo->dureza_calibracion}} HLD</div>
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
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">EPS / WPS</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$ot_tipo_soldadura->eps}}</div>
                           </td>
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
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
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Temperatura del material</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_dz->temperatura_material}}</div>
                           </td>
                           <td colspan="2" style="padding:4px 5px 5px;border-bottom:1px solid #EEF2F7;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Equipo</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$informe_interno_equipo->nro_serie}}</div>
                           </td>
                       </tr>

                       <tr>
                           <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Evaluación</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$norma_evaluacion->codigo}}</div>
                           </td>
                           <td colspan="2" style="padding:4px 5px 5px;vertical-align:top;">
                               <div style="font-size:8px;font-weight:bold;color:#4F8CFF;text-transform:uppercase;letter-spacing:0.3px;margin-bottom:2px;">Norma Ensayo</div>
                               <div style="font-size:12px;font-style:italic;color:#1C2340;">{{$norma_ensayo->codigo}}</div>
                           </td>
                       </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
