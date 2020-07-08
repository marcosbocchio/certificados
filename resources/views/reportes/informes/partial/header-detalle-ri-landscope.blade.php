    <table class="header-detalle-principal" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <td width="32%">
                    <table style="font-size: 12px;" width="100%" class="header-detalle">
                        <tbody >
                            <tr>
                                <th width="100%" colspan="4">Componente</th>
                            </tr>
                            <tr >
                                <td colspan="4">{{$informe->componente}}</td>
                            </tr>

                            <tr>                          
                                <th colspan="2">Diámetro</th>
                                <th colspan="2">Espesor</th>
                           </tr>                   
                            <tr>                           
                                <td colspan="2">{{$diametro_espesor->diametro}}</td>
                                <td>              
                                    @if ($informe->espesor_chapa)
                                        {{ $informe->espesor_chapa }}
                                    @elseif($informe->espesor_especifico)
                                        {{ $informe->espesor_especifico }}
                                    @else
                                        {{ $diametro_espesor->espesor }}
                                    @endif   
                                </td>
                            </tr>

                            <tr>
                                <th colspan="4">Procedimiento</th>
                            </tr>
                            <tr>
                                <td colspan="4">{{$procedimiento_inf->titulo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Actividad Fuente</th>
                                <th colspan="2">Foco</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$actividad}}</td>
                                <td colspan="2">
                                    @if ($interno_fuente)
                                        {{$interno_fuente->foco}}
                                    @else
                                        {{$interno_equipo->foco}}    
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Lado</th>
                                <th colspan="2">Dist. Fuente / F Film</th>                               
                           </tr>

                           <tr>
                                <td colspan="2">{{$informe_ri->lado}}</td>
                                <td colspan="2">{{$informe_ri->distancia_fuente_pelicula}}</td>
                           </tr>

                            <tr>
                                <th colspan="2">Técnica empleada</th>
                                <th colspan="2"> &nbsp;</th>                               
                            </tr>
                            <tr>
                                <td colspan="2" class="noBorder">{{$tecnica->codigo}}</td>
                                <td colspan="2" rowspan="4" style="text-align: center;"><img src="{{ public_path($tecnicas_grafico->path)}}" alt="" style="height:100px;margin-top: -10px;"></td>
                            </tr>      
                        </tbody>
                    </table>
                </td>
                <td width="2%">
                    &nbsp;
                </td>
                <td width="32%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>
                            <tr>
                                <th colspan="2">Material</th>
                                <th colspan="2">Material Accesorio</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$material->codigo}}</td>
                                <td colspan="2">
                                     @if($material_accesorio)
                                          {{$material_accesorio->codigo}}
                                     @endif
                                </td>
                            </tr>   

                            <tr >
                                <th colspan="4">EPS</th>
                            </tr>
                            <tr >
                                <td colspan="4">{{$ot_tipo_soldadura->eps}}</td>
                            </tr> 

                            <tr>
                                <th colspan="2">Equipo</th>
                                <th colspan="2">Fuente</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$interno_equipo->equipo->codigo}}</td>
                                <td colspan="2">                           
                                    @if ($interno_fuente)

                                        {{$interno_fuente->fuente->codigo}} 
                                        
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Pantalla</th>
                                <th colspan="1">Ant</th>
                                <th colspan="1">Pos</th>
                           </tr>
                           <tr>
                                <td colspan="2">Pb</td>
                                <td colspan="1">{{$informe_ri->pos_ant}}</td>
                                <td colspan="1">{{$informe_ri->pos_pos}}</td>
                           </tr>

                            <tr>
                               <th colspan="4">Norma Evaluación</th>                              
                            </tr>
                            <tr>
                                <td colspan="4" class="borderFila">{{$norma_evaluacion->codigo}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="2%">
                    &nbsp;
                </td>
                <td width="32%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>
                            <tr>
                                <th  width="100%" colspan="4">Plano / Isométrico</th>
                            </tr>                     
                            <tr>
                                 <td colspan="4">{{$informe->plano_isom}}</td>
                            </tr>

                            <tr>
                                <th colspan="4">PQR</th>
                            </tr>
                            <tr >
                                <td colspan="4">
                                @if($ot_tipo_soldadura->pqr)
                                      {{$ot_tipo_soldadura->pqr}}
                                @else
                                    &nbsp;
                                @endif
                                </td>
                            </tr>

                            <tr >
                                <th colspan="2">Película</th>
                                <th colspan="2">Tipo</th>
                            </tr>
                            <tr >
                                <td colspan="2">{{$tipo_pelicula->fabricante}}</td>
                                <td colspan="2">{{$tipo_pelicula->codigo}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">ICI</th>
                                <th colspan="2">Nº de exposiciones</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$ici->codigo}}</td>
                                <td colspan="2">{{$informe_ri->exposicion}}</td>
                            </tr>

                            <tr>
                                <th colspan="2">Norma Ensayo</th>
                                <th colspan="2">Ejecutor Ensayo</th>
                            </tr>
                            <tr>
                                <td colspan="2" class="borderFila">{{$norma_ensayo->codigo}}</td>
                                <td colspan="2" class="borderFila">{{$ejecutor_ensayo->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
 