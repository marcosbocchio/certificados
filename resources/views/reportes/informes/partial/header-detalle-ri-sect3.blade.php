<table class="tablamain">
    <tbody id="fecha_h">
        <tr class="gris">
            <td width= "44mm" height="4mm" id="left" style="padding-left:1px;">NUMERO DE ENSAYO: </td>
            <td width="60.7mm" height="4mm">
                @if($planta !== null)
                    RT-{{$planta->codigo}}-ENOD-{{$nroAESA}}
                @else
                    ENOD-{{$nroAESA}}
                @endif
            </td>   
            <td width="18mm" height="4mm">
                @if($informe_ri->ptt_sn !== null)
                    @if($informe_ri->ptt_sn == 1)
                        PTT
                    @elseif($informe_ri->ptt_sn == 0)
                        &nbsp;
                    @endif
                @else
                    <!-- Manejar el caso cuando ptt_sn es null, si es necesario -->
                    &nbsp;
                @endif
            </td>
            <td width= "23mm" height="4mm">FECHA:</td>
            <td width= "37mm" height="4mm" id="left">{{ $fecha }}</td>
        </tr>
    </tbody>
</table>

<table class="tablamain">
    <tbody>
        <tr class="gris" style="height: 6mm;">
            <td style="width: 19mm;" >Obra n°</td>
            <td style="width: 50mm;" >Cliente</td>
            <td style="width: 34mm;" >Equipo/Linea</td>
            <td style="width: 20mm;" >Material</td>
            <td style="width: 13mm;" >Diametro</td>
            <td style="width: 13mm;" >Esp. Material</td>
            <td style="width: 13mm;" >Esp. Sold</td>
            <td style="width: 17mm;" >Esp. Refuerzo</td>
        </tr>
        <tr style="height: 4mm;" id="font4tobloque">
            <td>
                @if(isset($informe))
                    <span>{{$informe->obra}}</span>
                @else
                    <span>{{$ot->obra}}</span>
                @endif
            </td>
            <td>
                @if($contratista)
                    <span>{{ $contratista->nombre }}</span>
                @endif
            </td>
            <td>{{$informe->linea}}</td>
            <td>
                {{ $material->codigo }}
            </td>
            <td>
                @if ($informe->diametro_espesor_id)
                    {{$diametro_espesor->diametro}} ''
                @else
                    {{$informe->diametro_especifico}} ''
                @endif
            </td>
            <td>
                @if ($informe->espesor_chapa)
                    {{ $informe->espesor_chapa }} mm
                @elseif($informe->espesor_especifico)
                    {{ $informe->espesor_especifico }} mm
                @elseif($diametro_espesor->diametro == 'VARIOS')
                    VARIOS
                @else
                    {{ $diametro_espesor->espesor }} mm
                @endif
            </td>
            <td>
                @php
                    $espesor = 0;

                    if ($informe->espesor_chapa) {
                        $espesor = $informe->espesor_chapa + 3.2;
                    } elseif ($informe->espesor_especifico) {
                        $espesor = $informe->espesor_especifico + 3.2;
                    } elseif ($diametro_espesor->diametro == 'VARIOS') {
                        $espesor = 'VARIOS';
                    } else {
                        $espesor = $diametro_espesor->espesor + 3.2;
                    }
                @endphp

                @if ($espesor == 'VARIOS')
                    VARIOS
                @else
                    {{ $espesor }} mm
                @endif
            </td>
            <td>3.2 mm</td>
        </tr>
    </tbody>
</table>

<table class="tablamain">
    <tbody>
        <tr class="gris">
            <td style="width: 37mm;" >Pelicula (marca / clase)</td>
            <td style="width: 15mm;" >fuente / Kv</td>
            <td style="width: 17mm;" >Actv. [Ci]/mAm</td>
            <td style="width: 13mm;" >Tamaño Focal</td>
            <td style="width: 41mm;" >Plantillas de PB</td>
            <td style="width: 57mm;" >Tecnica Empleada</td>
        </tr>
        <tr>
            <td>{{$tipo_pelicula->fabricante}} {{$tipo_pelicula->codigo}}</td>
            <td>
                @php
                    $codigoFuente = $interno_fuente->fuente->codigo;
                    $partesCodigo = explode(' - ', $codigoFuente);
                    $codigoDeseado = $partesCodigo[0];
                @endphp
                    @if ($codigoDeseado)
                        {{$codigoDeseado}}
                    @endif
                
            </td>
            <td>{{$actividad}}</td>
            <td>
                
                    @if ($interno_fuente)
                        {{$interno_fuente->foco}} mm
                    @else
                        {{$interno_equipo->foco}} mm
                    @endif
                
            </td>
            <td>
                <table class="tablamain">
                    <tbody>
                        <tr>
                            <td style="width: 20mm;" >Delantera:</td>
                            <td style="width: 16mm;" >{{$informe_ri->pos_ant}} mm</td>
                        </tr>
                        <tr>
                            <td style="width: 19mm;" >Trasera:</td>
                            <td style="width: 16mm;" >{{$informe_ri->pos_pos}} mm</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                {{$tecnica->codigo}}
            </td>
        </tr>
    </tbody>
</table>

<table class="tablamain">
    <tbody>
        <tr class="gris">
            <td style="width: 37.1mm;" >Ubicacion ICI</td>
            <td style="width: 32mm;" >Ubicacion Marcadores</td>
            <td style="width: 54mm;" >Minima Distancia Fuente - Objeto</td>
            <td style="width: 57mm;" >Maxima Distancia Objeto - Pelicula</td>
        </tr>
        <tr>
            <td>
                {{$informe_ri->lado}}
            </td>
            <td>
                {{$informe_ri->lado}}
            </td>
            <td>
                {{$informe_ri->distancia_fuente_pelicula}}
            </td>
            <td>
                {{$espesor}} mm
            </td>
        </tr>
    </tbody>
</table>

<table class="tablamain">
    <tbody>
        <tr class="gris" style="font-size: 6.20pt;">
            <td style="width: 27mm;" >Hilo/Esencial</td>
            <td style="width: 26mm;" >Cantidad de Radiografia</td>
            <td style="width: 24mm;" >Películas por Funda</td>
            <td style="width: 30mm;" >Procedimientos/Rev</td>
            <td style="width: 29.5mm;" >Norma de Ensayo</td>
            <td style="width: 45mm;" >Criterio de Aceptación</td>
        </tr>
        <tr style="font-size: 9px;">
            <td >
                {{$ici->codigo}}
            </td>
            <td >
                {{$informe_ri->exposicion}}
            </td>
            <td >
                1
            </td>
            <td >
                {{$procedimiento_inf->titulo}}
            </td>
            <td >
                {{$norma_ensayo->codigo}}
            </td>
            <td >
                {{$norma_evaluacion->codigo}}
            </td>
        </tr>
    </tbody>
</table>