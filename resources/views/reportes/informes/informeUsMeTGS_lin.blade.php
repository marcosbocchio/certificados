<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page {
            margin: 100px 40px 160px 40px !important;
    }


    header {
        position: fixed;
        top: -100px;    /* misma medida que el margin-top */
        left: 0;
        right: 0;
        margin: 0px ;
    }
    main {
        margin: 0;
        padding: 0;
    }

footer {
    position: fixed; bottom:0px;
    padding-top: 0px;
}
.bordered {
        border-collapse: collapse;
        margin-bottom: 20px; /* Espacio entre tablas */
    }

.bordered th, .bordered td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
    }

.bordered th {
        background-color: #D8D8D8;
    }

.title-row {
        background-color: #9ACD32; /* Color verde para los títulos de los accesorios */
    }
.page_break { page-break-before: always; }

.my-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    text-align: center;
  }
  .my-table td,
  .my-table th {
    border: 1px solid black;
    padding: 2px; /* o pon 2px si prefieres un poco de espacio */
  }
  /* Columnas 1–10: cambia los % a tu gusto */
  .my-table col.col-1  { width:  8%; }   /* PLANTA */
  .my-table col.col-2  { width: 16%; }   /* valor planta */
  .my-table col.col-3  { width:  8%; }   /* AREA/TIPO/… */
  .my-table col.col-4  { width: 24%; }   /* valor area/tipo/... */
  .my-table col.col-5  { width:  8%; }   /* OT N° */
  .my-table col.col-6  { width: 16%; }   /* valor OT */
  .my-table col.col-7  { width:  8%; }   /* modelo, año, etc. */
  .my-table col.col-8  { width: 16%; }   /* valor modelo, año, etc. */
  .my-table col.col-9  { width:  8%; }   /* unidad, [mm], [°C], etc. */
  .my-table col.col-10 { width: 16%; }   /* valor unidad o espacio extra */


</style>

<body>
<header>
    <table style="text-align: center;" width="100%">
        <tbody>
            <tr>
                <td>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="width: 210px;">
                                    <img src="{{ public_path('img/logo-enod-web.jpg')}}" alt="" style="height: 60px;margin-left:2px;">
                                </td>
                                <td style="font-size: 18px; height: 30px;width: 295px; text-align: center;" rowspan="4"><b>{{ $titulo }}</b></td>
                                <td style="font-size: 10px;" ><b style="margin-left:35px;">
                                {{ $tipo_reporte}}</b>{{ $nro }}
                            </td>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;"><b style="margin-left: 35px;">FECHA: </b>{{ $fecha }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"><b style="margin-left: 35px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="font-size: 11px;">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    @include('reportes.partial.linea-amarilla')
</header>



    <footer>
    @if($tecnica->codigo == 'US' || $tecnica->codigo=='PA' || $tecnica->codigo=='FMC-TFM')
        @include('reportes.partial.linea-amarilla')
        @include('reportes.informes.partial.observaciones')
        @include('reportes.partial.linea-amarilla')
        @include('reportes.informes.partial.firmas')
    @else
        @include('reportes.partial.linea-amarilla')
            <table width="100%">
                <tbody>
                    <tr>
                        <td style="font-size: 13px;" colspan="1"  rowspan="2"><b>Firmas </b></td>
                        <td style="font-size: 13px;text-align: center;height: 85px;" colspan="2" width="33.33%">
                            @if($firma)
                                <img src="{{ public_path($firma) }}" alt="" style="width: 175px;height: 85px;">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; text-align: center;" colspan="2"><em>Evaluador </em></td>
                        <td style="font-size: 14px; text-align: center;" colspan="2"><em>Cliente </em></td>
                        <td style="font-size: 14px; text-align: center;" colspan="2"><em>Comitente </em></td>
                    </tr>
                </tbody>
            </table>
    @endif 
    </footer>

<main>
<h3 style="text-align: center" ><b>EQUIPO: </b>{{ $informe->componente }}</h3>
<h3 style="text-align: center" ><b>PLANTA: </b>{{$planta->nombre?? '-'}}</h3>
<h3 style="text-align: center" ><b>AREA: </b>{{$componente_us->area ?? '-'}}</h3>

@if ($componente_us->path3_componente)
<div style="text-align: center; margin: 30px 0;">
  <img src="{{ public_path($componente_us->path3_componente) }}"
       alt=""
       style="max-width: 500px; max-height: 500px; width: auto; height: auto;">
</div>

    
@endif

<h3 style="text-align: center" ><b>EJECUTOR DE ENSAYO: </b>{{ $ejecutor_ensayo->name }}</h3>
<h3 style="text-align: center" ><b>DNI: </b>{{ $ejecutor_ensayo->dni }}</h3>

<div style="page-break-after: always;"></div>

<h3 style="text-align: center;">DATOS DEL EQUIPO</h3>

<table class="my-table">
<colgroup>
    <col class="col-1"/>
    <col class="col-2"/>
    <col class="col-3"/>
    <col class="col-4"/>
    <col class="col-5"/>
    <col class="col-6"/>
    <col class="col-7"/>
    <col class="col-8"/>
    <col class="col-9"/>
    <col class="col-10"/>
  </colgroup>

  <tbody>
    <!-- Bloque planta – area – OT -->
    <tr>
      <td rowspan="2">PLANTA</td>
      <td rowspan="2" colspan="3" style="background-color: #c3c3c3;">
        {{ $planta->nombre ?? '-' }}
      </td>
      <td>AREA</td>
      <td colspan="2" style="background-color: #c3c3c3;">
        {{ $componente_us->area }}
      </td>
      <td rowspan="2">OT N°</td>
      <td colspan="3" rowspan="2" style="background-color: #c3c3c3;">
        {{ $ot->numero }}
      </td>
    </tr>
    <tr>
      <td>PLANO</td>
      <td colspan="2" style="background-color: #c3c3c3;">
        {{ $informe->plano_isom }}
      </td>
    </tr>

    <!-- Bloque Nº de equipo -->
    <tr>
      <td>N° DE Linea</td>
      <td style="background-color: #c3c3c3;">
        {{ $informe->linea }}
      </td>
      <td>Diametro</td>
      <td style="background-color: #c3c3c3;">{{$diametro_espesor->diametro ?? $informe->diametro_especifico}}</td>
      <td>SCH</td>
      <td colspan="2">{{$diametro_espesor->cuadrante}}</td>
      <td>Espesor nom</td>
      <td colspan="2" style="background-color: #c3c3c3;">{{$diametro_espesor->espesor ?? $informe->espesor_especifico}}</td>
      <td>mm</td>
    </tr>

    <tr>
      <td>Material</td>
      <td style="background-color: #c3c3c3;">
        {{ $material->codigo ?? $material2->codigo }}
      </td>
      <td>Grado</td>
     @if($materialesUS->isNotEmpty())
        @foreach($materialesUS as $mat)
          <td style="background-color: #c3c3c3;">
            {!! $mat->grado != 0 
                ? number_format($mat->grado, 2) 
                : '&nbsp;' !!}
          </td>
        @endforeach
      @else
        {{-- Si no hay nada en materialesUS mostramos un único TD vacío --}}
        <td style="background-color: #c3c3c3;">&nbsp;</td>
      @endif
      <td>Fluido</td>
      <td colspan="2"> {{ $componenteEntero->fluido->codigo ?? '-' }}</td>
      <td colspan="2">Espesor min medido</td>
      <td style="background-color: #c3c3c3;">{{$espesorMinimo_formateado}}</td>
      <td>mm</td>
    </tr>
    @php
      $inf             = $informes_us_me->first();
      $espMinReq2      = $inf->espesor_minimo_me;
    @endphp
    <tr>
      <td>Pres. diseño</td>
      <td style="background-color: #c3c3c3;">
        {{ $componente_us->presion_diseño ?? '-' }}
      </td>
      <td>kg/cm</td>
      <td>temp Diseño</td>
      <td style="background-color: #c3c3c3;">{{ $componente_us->temp_diseño }}</td>
      <td>(°c)</td>
      <td colspan="3">espesor min de calculo</td>
      <td style="background-color: #c3c3c3;">{{$espMinReq2}}</td>
      <td>mm</td>
    </tr>

    <tr>
      <td>Pres. oper</td>
      <td style="background-color: #c3c3c3;">
        {{ $componente_us->presion_operacion }}
      </td>
      <td>kg/cm</td>
      <td>temp oper</td>
      <td style="background-color: #c3c3c3;">{{ $componente_us->temp_operacion }}</td>
      <td>(°c)</td>
      <td>aislacion</td>
      <td colspan="2" style="background-color: #c3c3c3;">{{ $componente_us->aislacion }}</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

  </tbody>
</table>


{{-- Sección Alcance --}}
<h4 style="margin: 10px 0px 0px 0px;"><strong>Alcance:</strong></h4>
<p style="margin: 0;">
  El presente informe esta basado en los lineamientos de los “Procedimientos de Integridad” para la 
  medición de espesores generados por la aplicación de la norma API RP 581 implementada por TGS. Se 
  realizó medición de espesores externa en el Equipo de referencia, con los resultados que se muestran 
  en tablas adjuntas y con las consideraciones que de ellos se desprenden.
</p>

{{-- Sección Normas de referencia --}}
<h4 style="margin: 1em 0 0 0;"><strong>Normas de referencia:</strong></h4>
<p style="margin: 0;">Norma ensayo: {{ $norma_ensayo->codigo }}</p>
<p style="margin: 0;">Norma de evaluación: {{ $norma_evaluacion->codigo }}</p>


<table style="width:100%; border-collapse:collapse; font-size:9.5px; border:1px solid black; margin: 10px 0px 10px 0px;">
  <thead>
    <tr>
      <th colspan="4" style="text-align:center; padding:6px; background:#c3c3c3; font-size:14px;">
        <strong>EQUIPO DE MEDICIÓN</strong>
      </th>
    </tr>
  </thead>
</table>
<table class="header-detalle-principal">
        <tbody>
            <tr>
                <td width="49%">
                    <table style="font-size: 12px;" width="100%" class="header-detalle">
                        <tbody>
                           <tr>
                               <th width="100%" colspan="4">Equipo</th>
                           </tr>
                           <tr >
                               <td colspan="4">{{$equipo->codigo}}-{{$equipo->descripcion}}</td>
                           </tr>
                           <tr>
                               <th colspan="4" >Probeta</th>
                           </tr>
                           <tr>
                                <td colspan="4">
                                  {{$calibracion_us->block_calibracion ?? '-'}}
                                </td>
                           </tr>
                           <tr>
                                <th colspan="4">Tecnica</th>
                           </tr>
                           <tr>
                                <td colspan="4">CONTACTO</td>
                           </tr>
                            <tr>
                                <th colspan="4">Velocidad Acustica del acero</th>
                           </tr>
                           <tr>
                                <td colspan="4">5290 m/seg</td>
                           </tr>
                        </tbody>
                    </table>
                </td>
                <td width="2%">
                    &nbsp;
                </td>
                <td width="49%">
                    <table style="font-size: 12px;float:right;" width="100%" class="header-detalle">
                        <tbody>
                           <tr >
                               <th width="100%" colspan="4">Palpador</th>
                           </tr>
                           <tr >
                               <td colspan="4">{{$equipoPalpador->codigo ?? '-'}}-{{$equipoPalpador->descripcion ?? '-'}}</td>
                           </tr>
                           <tr>
                                <th colspan="4" >Rangos</th>
                           </tr>
                           <tr>
                                <td colspan="4">{{$calibracion_us->rango?? '-'}}
                                </td>
                            </tr>
                            <tr >
                                <th colspan="4">Acoplante</th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                {{$agente_acoplamiento->codigo}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="page-break-after: always;"></div>

@if(! empty($informe_us->path1_calibracion))
  <table style="width:100%; border-collapse:collapse; font-size:9.5px; border:1px solid black; margin:10px 0;">
    <thead>
      <tr>
        <th style="text-align:center; padding:6px; background:#c3c3c3; font-size:14px;">
          <strong>PROCEDIMIENTO</strong>
        </th>
      </tr>
    </thead>
    <tbody>
    <tr>
      <td style="text-align: center; padding: 10px 100px;border:1px solid black;height: 700px">
        <img
          src="{{ public_path($informe_us->path1_calibracion) }}"
          alt=""
          style="
            display: block;
            max-width: 500px;
            max-height: 700px;
            width: auto;
            height: auto;
            margin: 0 auto;
          "
        >
      </td>
    </tr>
    </tbody>
  </table>



  <div style="page-break-after: always;"></div>
@endif
    <table width="100%">
      <tbody>
          <tr>
              <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
              REGISTRO DE MEDICIONES
          </td>
          </tr>
      </tbody>
  </table>

  @foreach ($medicionesAgrupadas as $nombreObjeto => $datos)
    <h2 style="font-size: 15px;">{{ strtoupper($nombreObjeto) }}</h2>

    @if (count($datos['medicionesTranspuestas'][0]) - 2 <= $datos['cantidad_generatrices_linea_pdf_me'])
        {{-- Formato agrupado --}}
        <table class="bordered" style="font-size: 13px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="min-width: 15px;height:20px;">Puntos</th>
                    @foreach (array_slice($datos['medicionesTranspuestas'][0], 1, -1) as $encabezado)
                        <th style="min-width: 28px;height:20px;">{{ $encabezado }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php 
                $currentSection = null;
                $espesorMinimo = $datos['espesor_minimo_me']; 
                @endphp
                @foreach (array_slice($datos['medicionesTranspuestas'], 1) as $medicion)
                    @php $ultimoValor = end($medicion); @endphp

                    @if ($ultimoValor !== null && $ultimoValor !== $currentSection)
                        @php $currentSection = $ultimoValor; @endphp
                        <tr class="title-row">
                            <td colspan="{{ count($datos['medicionesTranspuestas'][0]) - 1 }}" style="font-size: 14px;height:20px;">{{ $ultimoValor }}</td>
                        </tr>
                    @endif

                    <tr>
                        @foreach (array_slice($medicion, 0, -1) as $key => $valor)
                        <td style="color: {{ $key >= 2 && is_numeric($valor) && $valor !== 'S/A' && $valor < $espesorMinimo ? 'red' : 'inherit' }}; font-size: 13px;height:20px;">{{ $valor }}</td>                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Formato no agrupado con columnas fijas y divisiones según cantidad_generatrices_linea_pdf_me --}}
        @php
            $encabezados = $datos['medicionesTranspuestas'][0];
            $maxColumnas = $datos['cantidad_generatrices_linea_pdf_me'];
            $totalColumnas = count($encabezados) - 1; 
            $inicio = 2; 
            $espesorMinimo = $datos['espesor_minimo_me']; 
        @endphp

        @while ($inicio < $totalColumnas)
            @php
                $fin = min($inicio + $maxColumnas, $totalColumnas);
                $columnasMostrar = array_slice($encabezados, $inicio, $fin - $inicio);
            @endphp
            <table class="bordered" style="font-size: 14px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="min-width: 28px;">Puntos</th>
                        <th style="min-width: 28px;">Ø</th>
                        @foreach ($columnasMostrar as $encabezado)
                            <th style="min-width: 28px;">{{ $encabezado }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos['medicionesTranspuestas'] as $indice => $medicion)
                        @if ($indice > 0)
                            <tr>
                                <td style="height:20px;">{{ $medicion[0] }}</td>
                                <td style="height:20px;">{{ $medicion[1] }}</td>
                                @foreach (array_slice($medicion, $inicio, $fin - $inicio) as $key => $valor)
                                <td style="color: {{ $key + $inicio >= 2 && is_numeric($valor) && $valor !== 'S/A' && $valor < $espesorMinimo ? 'red' : 'inherit' }}; font-size: 13px;height:20px;">{{ $valor }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @php $inicio = $fin; @endphp
        @endwhile
    @endif
@endforeach


@if( $informe_us->path1_indicacion || $informe_us->path2_indicacion )

<div class="page_break"></div>
<table width="100%">
    <tbody>
        <tr>
            <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
           REGISTRO FOTOGRAFICA
        </td>
        </tr>
    </tbody>
</table>
<table style="text-align: center;margin-top: 5px;" width="100%" >
    <tbody>
        <tr>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td style="text-align: center; width: 680px;height: 275px;">
                                @if ($informe_us->path1_indicacion)
                                    <img src="{{ public_path($informe_us->path1_indicacion) }}" alt="" style="max-width: 700px; max-height: 270px; width: auto; height: auto;">
                                @endif

                            </td>

                        </tr>
                        <tr>
                            <td style="text-align: center; width: 680px;height: 275px;">

                                @if ($informe_us->path2_indicacion)
                                    <img src="{{ public_path($informe_us->path2_indicacion) }}" alt="" style="max-width: 700px; max-height: 270px; width: auto; height: auto;">
                                @endif

                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endif

@if($informe_us->path3_indicacion || $informe_us->path4_indicacion)
<div class="page_break"></div>
<table width="100%">
    <tbody>
        <tr>
            <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
            REGISTRO FOTOGRAFICA
        </td>
        </tr>
    </tbody>
</table>
<table style="text-align: center;margin-top: 5px;" width="100%" >
    <tbody>
        <tr>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td style="text-align: center; width: 680px;height: 275px;">

                                @if ($informe_us->path3_indicacion)
                                    <img src="{{ public_path($informe_us->path3_indicacion) }}" alt="" style="max-width: 700px; max-height: 270px; width: auto; height: auto;">
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; width: 680px;height: 275px;">

                                @if ($informe_us->path4_indicacion)
                                    <img src="{{ public_path($informe_us->path4_indicacion) }}" alt="" style="max-width: 700px; max-height: 270px; width: auto; height: auto;">
                                @endif

                            </td>

                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endif
<div style="page-break-after: always;"></div>

  
@php
  // Helper para recortar ceros y punto sobrante
  $trimZeros = function($n) {
    return rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.');
  };

  // Datos del informe
  $inf             = $informes_us_me->first();
  $espMinAnterior  = $inf->espesor_minimo_anterior_me;
  $anos            = $inf->años_ultima_inspeccion_me;
  $espMinReq       = $inf->espesor_minimo_me;
  // $espesorMinimo_formateado viene de fuera

  // 1) Velocidad de corrosión
  $canCalcVel = ($espMinAnterior > 0 && $espesorMinimo_formateado > 0 && $anos > 0);
  if ($canCalcVel) {
    $velocidad    = max(0, ($espMinAnterior - $espesorMinimo_formateado) / $anos);
    $velocidadFmt = $trimZeros($velocidad);
  } else {
    $velocidadFmt = 's / n';
  }

  // 2) Vida remanente
  $canCalcVida = ($espesorMinimo_formateado > 0 && $espMinReq > 0 && !empty($velocidad) && $velocidad > 0);
  if ($canCalcVida) {
    $vidaRem    = max(0, ($espesorMinimo_formateado - $espMinReq) / $velocidad);
    $vidaRemFmt = $trimZeros($vidaRem);
  } else {
    $vidaRemFmt = 's / n';
  }
@endphp

<table width="100%">
  <tbody>
    <tr>
      <td style="border:1px solid #000;background:#D8D8D8;text-align:center;">
        FORMULAS
      </td>
    </tr>
  </tbody>
</table>

<table style="width:100%; border-collapse:collapse; font-size:13px; text-align:center; border:1px solid black; margin:10px 0;">
  <colgroup>
    <col style="width:20%;" /><col style="width:30%;" /><col style="width:5%;" />
    <col style="width:20%;" /><col style="width:5%;" /><col style="width:20%;" />
  </colgroup>
  <thead>
    <tr>
      <th style="border:1px solid black; padding:4px;">Cálculo</th>
      <th style="border:1px solid black; padding:4px;">Fórmula</th>
      <th style="border:1px solid black; padding:4px;"><b>-></b></th>
      <th style="border:1px solid black; padding:4px;">Valores</th>
      <th style="border:1px solid black; padding:4px;"><b>-></b></th>
      <th style="border:1px solid black; padding:4px;">Resultado</th>
    </tr>
  </thead>
  <tbody>
    <!-- Velocidad de corrosión -->
    <tr>
      <td style="border:1px solid black; padding:4px; text-align:left;">
        Velocidad de corrosión<br><small>(mm/año)</small>
      </td>
      <td style="border:1px solid black; padding:4px; text-align:left;">
        <u>espesor mínimo anterior - espesor mínimo</u><br>
        años entre inspecciones
      </td>
      <td style="border:1px solid black; padding:4px;"><b>-></b></td>
      <td style="border:1px solid black; padding:4px; text-align:center;">
        {!! 
          '<u>'
            . ($espMinAnterior  > 0 ? $trimZeros($espMinAnterior) : '&nbsp;')
            . ' - '
            . ($espesorMinimo_formateado > 0 ? $trimZeros($espesorMinimo_formateado) : '&nbsp;')
          . '</u><br>'
          . ($anos > 0 ? $trimZeros($anos) : '&nbsp;')
        !!}
      </td>
      <td style="border:1px solid black; padding:4px;"><b>-></b></td>
      <td style="border:1px solid black; padding:4px;">
        {{ $velocidadFmt }}
      </td>
    </tr>

    <!-- Vida remanente -->
    <tr>
      <td style="border:1px solid black; padding:4px; text-align:left;">
        Vida remanente<br><small>(años)</small>
      </td>
      <td style="border:1px solid black; padding:4px; text-align:left;">
        <u>espesor mínimo - espesor mínimo req.</u><br>
        velocidad de corrosión
      </td>
      <td style="border:1px solid black; padding:4px;"><b>-></b></td>
      <td style="border:1px solid black; padding:4px; text-align:center;">
        {!! 
          '<u>'
            . ($espesorMinimo_formateado > 0 ? $trimZeros($espesorMinimo_formateado) : '&nbsp;')
            . ' - '
            . ($espMinReq > 0 ? $trimZeros($espMinReq) : '&nbsp;')
          . '</u><br>'
          . (!empty($velocidad) && $velocidad > 0 ? $trimZeros($velocidad) : 's / n')
        !!}
      </td>
      <td style="border:1px solid black; padding:4px;"><b>-></b></td>
      <td style="border:1px solid black; padding:4px;">
        {{ $vidaRemFmt }}
      </td>
    </tr>
  </tbody>
</table>



<div style="width: 100%;page-break-inside: avoid;">
    @include('reportes.partial.linea-amarilla')
        <table width="100%" style="border-collapse: collapse;">
            <tbody style="padding: 20px;"> 
                <tr>
                    <td><strong style="font-size: 13px;">Observaciones</strong></td>
                </tr>   
                <tr>           
                    <td style="font-size: 13px; height:70px; text-align: right;" class="bordered-td">
                        <span style="display: block; text-align: left; margin: 5px;">{{$observaciones}}</span>
                    </td> 
                </tr>
            </tbody>
        </table>
    @include('reportes.partial.linea-amarilla')
    </div>
</table>

</main>

 <script type="text/php">
    if ( isset($pdf) ) {
        $x = 518;
        $y = 62;
        $text = "RG.33 Rev.02";
        $font = $fontMetrics->get_font("serif", "normal");
        $size = 8;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
    if ( isset($pdf) ) {
        $x = 445;
        $y = 31;
        $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 8;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

        /* $pdf->line(34,167,561,167,array(0,0,0),1.5); */

    }
   
</script>




</body>

</html>
