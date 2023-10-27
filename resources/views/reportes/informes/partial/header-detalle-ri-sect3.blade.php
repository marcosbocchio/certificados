<table class="tablamain">
    <tbody id="fecha_h">
        <tr class="gris">
            <td width= "43mm" height="4mm" id="left" style="padding-left:1px;">NUMERO DE ENSAYO: </td>
            <td width= "61mm" height="4mm">&nbsp;</td>
            <td width= "18mm" height="4mm">&nbsp;</td>
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
            <td style="width: 34mm;" >Equipo</td>
            <td style="width: 16mm;" >Material</td>
            <td style="width: 13mm;" >Diametro</td>
            <td style="width: 13mm;" >Esp. Material</td>
            <td style="width: 13mm;" >Esp. Sold</td>
            <td style="width: 21mm;" >Esp. Refuerzo</td>
        </tr>
        <tr style="height: 4mm;">
            <td>
                @if(isset($informe))
                    <span>{{$informe->obra}}</span>
                @else
                    <span>{{$ot->obra}}</span>
                @endif
            </td>
            <td>
                @if($contratista)
                    <span>Comitente</span>
                @endif
            </td>
            <td>{{$interno_equipo->equipo->codigo}}</td>
            <td>
                {{ substr($material->codigo, 0, 10) }}
            </td>
            <td>
                @if ($informe->diametro_espesor_id)
                    {{$diametro_espesor->diametro}}
                @else
                    {{$informe->diametro_especifico}}
                @endif
            </td>
            <td>
                @if ($informe->espesor_chapa)
                    {{ $informe->espesor_chapa }}
                @elseif($informe->espesor_especifico)
                    {{ $informe->espesor_especifico }}
                @elseif($diametro_espesor->diametro == 'VARIOS')
                    VARIOS
                @else
                    {{ $diametro_espesor->espesor }}
                @endif
            </td>
            <td>a</td>
            <td>a</td>
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
            <td style="width: 37mm;" >Plantillas de PB</td>
            <td style="width: 61mm;" >Tecnica Empleada</td>
        </tr>
        <tr>
            <td>{{$tipo_pelicula->fabricante}} {{$tipo_pelicula->codigo}}</td>
            <td>
                
                    @if ($interno_fuente)
                        {{$interno_fuente->fuente->codigo}}
                    @endif
                
            </td>
            <td>{{$actividad}}</td>
            <td>
                
                    @if ($interno_fuente)
                        {{$interno_fuente->foco}}
                    @else
                        {{$interno_equipo->foco}}
                    @endif
                
            </td>
            <td>
                <table class="tablamain">
                    <tbody>
                        <tr>
                            <td style="width: 20mm;" >Delantera:</td>
                            <td style="width: 16mm;" >{{$informe_ri->pos_ant}}</td>
                        </tr>
                        <tr>
                            <td style="width: 19mm;" >Trasera:</td>
                            <td style="width: 16mm;" >{{$informe_ri->pos_pos}}</td>
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
            <td style="width: 37mm;" >Ubicacion ICI</td>
            <td style="width: 32mm;" >Ubicacion Marcadores</td>
            <td style="width: 50mm;" >Minima Distancia Fuente - Objeto</td>
            <td style="width: 61mm;" >Maxima Distancia Objeto - Pelicula</td>
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
                {{$informe_ri->distancia_fuente_pelicula}}
            </td>
        </tr>
    </tbody>
</table>

<table class="tablamain">
    <tbody>
        <tr class="gris" style="font-size: 6.20pt;">
            <td style="width: 27mm;" >Hilo/Esencial</td>
            <td style="width: 26mm;" >Cantidad de Radiografia</td>
            <td style="width: 21mm;" >Películas por Funda</td>
            <td style="width: 29mm;" >Procedimientos/Rev</td>
            <td style="width: 31mm;" >Norma de Ensayo</td>
            <td style="width: 47mm;" >Criterio de Aceptación</td>
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