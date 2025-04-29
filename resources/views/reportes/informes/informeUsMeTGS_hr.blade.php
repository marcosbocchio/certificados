<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>


@if($tecnica->codigo == 'US' || $tecnica->codigo == 'PA' || $tecnica->codigo=='FMC-TFM')
        /* reducimos el margin-top a 180px en vez de 260px */
        @page {
            margin: 180px 40px 260px 40px !important;
        }
    @else
        @page {
            margin: 180px 40px 160px 40px !important;
        }
    @endif

    header {
        position: fixed;
        top: -180px;    /* misma medida que el margin-top */
        left: 0;
        right: 0;
        /* opcional: fija la altura explícita si quieres */
        /* height: 180px; */
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
                        <td style="font-size: 13px;" colspan="2"  width="33.33%">lorem</td>
                        <td style="font-size: 13px;" colspan="2" width="33.33%">lorem</td>
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
<h3><b>EQUIPO: {{ $informe->componente }}</b><br>
PLANTA: {{$planta->nombre?? '-'}}
</h3>

@if ($componente_us->path3_componente)
    <img src="{{ public_path($componente_us->path3_componente) }}"
         alt=""
         style="width: 700px; height: 270px; margin-top:30px">
@endif
<h3><b>EJECUTOR DE ENSAYO: {{ $informe->componente }}</b><br>
DNI: {{$planta->nombre ?? '-'}}
</h3>
<div style="page-break-after: always;"></div>

<h3 style="text-align: center;">DATOS DEL EQUIPO</h3>

<table style="width: 100%; border-collapse: collapse; text-align: center;font-size:12px;">
    <!-- Bloque planta – area – OT -->
    <tr>
        <td rowspan="2" style="border:1px solid black;">PLANTA</td>
        <td rowspan="2" colspan="2" style="border:1px solid black; background-color: #c3c3c3;">{{$planta->nombre ?? '-'}}</td>
        <td style="border:1px solid black;">AREA</td>
        <td colspan="3" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->area}}</td>
        <td style="border:1px solid black;">OT N°</td>
        <td colspan="2" style="border:1px solid black; background-color: #c3c3c3;">{{$ot->numero}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">TIPO</td>
        <td colspan="3" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->area}}</td>
        <td style="border:1px solid black;">TIPO</td>
        <td colspan="3" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->area}}</td>
    </tr>

    <!-- Bloque Nº de equipo -->
    <tr>
        <td style="border:1px solid black;">N° DE EQUIPO</td>
        <td colspan="2" style="border:1px solid black; background-color: #c3c3c3;">{{$informe->componente}}</td>
        <td style="border:1px solid black;">MODELO</td>
        <td colspan="6" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->modelo_id ?? '-'}}</td>
    </tr>

    <!-- Bloque Denominación -->
    <tr>
        <td style="border:1px solid black;">DENOMINACION</td>
        <td colspan="2" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->denominacion}}</td>
        <td style="border:1px solid black;">AÑO</td>
        <td colspan="6" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->año}}</td>
    </tr>
    @php
        $count = $materialesUS->count();
    @endphp
    <tbody>
    @foreach($materialesUS as $idx => $mat)
      <tr>
        {{-- Sólo en la primera fila imprimimos “Material” con rowspan --}}
        @if ($idx === 0)
          <td rowspan="{{ $count }}" style=" border:1px solid black;">
            MATERIAL
          </td>
        @endif

        {{-- Descripción (colspan=2 para imitar tu diseño) --}}
        <td colspan="2" style=" border:1px solid black;">
          {{ $mat->descripcion }}
        </td>

        {{-- Grado --}}
        @if ($idx === 0)
          <td rowspan="{{ $count }}" style=" border:1px solid black;">
            GRADO
          </td>
        @endif>
        <td style=" border:1px solid black;">
          {{ number_format($mat->grado, 2) }}
        </td>

        {{-- Espesor Nominal --}}
        @if ($idx === 0)
          <td rowspan="{{ $count }}" style=" border:1px solid black;">
            ESP. NOMINAL
          </td>
        @endif
        <td style=" border:1px solid black;">
          {{ number_format($mat->espesor_nominal, 2) }}
        </td>

        {{-- Espesor Mínimo Medido --}}
        @if ($idx === 0)
          <td rowspan="{{ $count }}" style=" border:1px solid black;">
            ESP. MIN. MEDIDO
          </td>
        @endif
        <td style=" border:1px solid black;">
          {{ number_format($mat->espesor_minimo_medido, 2) }}
        </td>

        {{-- Unidad --}}
        @if ($idx === 0)
          <td rowspan="{{ $count }}" style=" border:1px solid black;">
          [mm]
          </td>
        @endif
      </tr>
    @endforeach

    <!-- Bloque Temperatura / Presión -->
    <tr>
        <td rowspan="2" style="border:1px solid black;">TEMPERATURA</td>
        <td style="border:1px solid black;">DISEÑO</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->temp_diseño}}</td>
        <td rowspan="2" style="border:1px solid black;">[°C]</td>
        <td rowspan="2" colspan="2" style="border:1px solid black;">PRESION</td>
        <td colspan="2" style="border:1px solid black;">DISEÑO</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->presion_diseño}}</td>
        <td rowspan="2" style="border:1px solid black;">kg/cm²</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">OPERACION</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->temp_operacion}}</td>
        <td colspan="2" style="border:1px solid black;">OPERACION</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->presion_operacion}}</td>
    </tr>

    <!-- Bloque Fluido -->
    <tr>
        <td rowspan="3" style="border:1px solid black;">FLUIDO</td>
        <td rowspan="3" colspan="3" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->fluido_id ?? '-'}}</td>
        <td rowspan="3" colspan="4" style="border:1px solid black;">SOBREESPESOR POR CORROSION</td>
        <td rowspan="3" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->sobreespesor_por_corrocion}}</td>
        <td rowspan="3" style="border:1px solid black;">[mm]</td>
    </tr>
    <tr></tr><tr></tr>
    <tr>
        <td style="border:1px solid black;">DIAM. EXTERIOR</td>
        <td colspan="2" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->diam_exterior}}</td>
        <td style="border:1px solid black;">[mm]</td>
        <td colspan="4" style="border:1px solid black;">LONGITUD TOTAL</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->longitud_total}}</td>
        <td style="border:1px solid black;">[mm]</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">TRAT. TERMICO</td>
        <td colspan="2" style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->tratamiento_termico}}</td>
        <td colspan="2" style="border:1px solid black;">RADIOGRAFIADO</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->radiografiado}}</td>
        <td colspan="2" style="border:1px solid black;">NORMA FABRIC.</td>
        <td colspan="2" style="border:1px solid black; background-color:#c3c3c3;">{{$componente_us->norma_fabric_id ?? '-'}}</td>
    </tr>
    <tr>
        <td style="border:1px solid black;">AISLACION</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->asilacion}}</td>
        <td style="border:1px solid black;">TIPO</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->tipo_id}}</td>
        <td colspan="2" style="border:1px solid black;">MATERIAL</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->material_id}}</td>
        <td style="border:1px solid black;">ESPESOR</td>
        <td style="border:1px solid black; background-color: #c3c3c3;">{{$componente_us->espesor}}</td>
        <td style="border:1px solid black;">[mm]</td>
    </tr>
</table>
{{-- Sección Alcance --}}
<h4 style="margin: 0;"><strong>Alcance:</strong></h4>
<p style="margin: 0;">
  El presente informe está basado en los lineamientos de los “Procedimientos de Integridad” para la
  medición de espesores generados por la aplicación de la norma API RP 581 implementada por TGS.
  Se realizó medición de espesores externa en el Equipo de referencia, con los resultados que se
  muestran en tablas adjuntas y con las consideraciones que de ellos se desprenden.
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
                                  {{$calibracion_us->block_calibracion}}
                                </td>
                           </tr>
                           <tr>
                                <th colspan="4">Ultimo Control</th>
                           </tr>
                           <tr>
                                <td colspan="4">-</td>
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
                                <td colspan="4">-</td>
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
                               <td colspan="4">{{$equipoPalpador->codigo}}-{{$equipoPalpador->descripcion}}</td>
                           </tr>
                           <tr>
                                <th colspan="4" >Rangos</th>
                           </tr>
                           <tr>
                                <td colspan="4">{{$informe->plano_isom}}
                                </td>
                            </tr>

                           <tr>
                                <th colspan="4">Ente regulador</th>
                           </tr>
                            <tr>
                                <td colspan="4">
                                -
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

    <table style="width:100%; border-collapse:collapse; font-size:9.5px; border:1px solid black; margin: 10px 0px 10px 0px;">
  <thead>
    <tr>
      <th colspan="4" style="text-align:center; padding:6px; background:#c3c3c3; font-size:14px;">
        <strong>ESQUEMA DE MEDICION</strong>
      </th>
    </tr>
  </thead>
</table>
  

  <div style="page-break-after: always;"></div>

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

  <div style="page-break-after: always;"></div>
 
  <table
  style="
    width:100%;
    font-size:12px;
    border-collapse: collapse;
    table-layout: fixed;
    border: 1px solid black;
  "
>

  <tbody>
    @foreach($tablaInforme as $categoria)
      @php
        // número total de filas para calcular el rowspan
        $filas = count($categoria['items']) + 1;
      @endphp

      {{-- 1) Fila de PRESENTE? con la celda de categoría --}}
      <tr>
        <td
          style="border:1px solid black; padding:0; vertical-align:top; font-weight:bold;"
          rowspan="{{ $filas }}"
        >
          {{ $categoria['categoria'] }}
        </td>
        <td style="border:1px solid black; padding:0; text-align:left; font-weight:bold;background:#ccc;">
          PRESENTE?
        </td>
        <td style="border:1px solid black; padding:0; text-align:center;background:#ccc;">
          <b>SI</b>
        </td>
        <td style="border:1px solid black; padding:0; text-align:center;background:#ccc;">
          <b>NO</b>
        </td>
        <td style="border:1px solid black; padding:0; text-align:center;background:#ccc;">
          <b>N/A</b>
        </td>
      </tr>

      {{-- 2) Filas de cada ítem --}}
      @foreach($categoria['items'] as $item)
        <tr>
          <td style="border:1px solid black; padding:0; text-align:left;">
            {{ $item['nombre'] }}
          </td>
          <td style="border:1px solid black; padding:0; text-align:center;">
            {{ $item['respuesta'] === 'SI'  ? 'X' : '' }}
          </td>
          <td style="border:1px solid black; padding:0; text-align:center;">
            {{ $item['respuesta'] === 'NO'  ? 'X' : '' }}
          </td>
          <td style="border:1px solid black; padding:0; text-align:center;">
            {{ $item['respuesta'] === 'N/A' ? 'X' : '' }}
          </td>
        </tr>
      @endforeach
    @endforeach
  </tbody>
</table>

</main>

@include('reportes.partial.nro_pagina')

@if($tecnica->codigo=='US')

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 520;
            $y = 78;
            $text = "RG.30 Rev.02";
            $font = $fontMetrics->get_font("serif", "normal");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
    @elseif ($tecnica->codigo=='FMC-TFM')

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 520;
            $y = 78;
            $text = "RG.79 Rev.01";
            $font = $fontMetrics->get_font("serif", "normal");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
@elseif ($tecnica->codigo=='PA')

    <script type="text/php">
        if ( isset($pdf) ) {
            $x = 520;
            $y = 78;
            $text = "RG.79 Rev.01";
            $font = $fontMetrics->get_font("serif", "normal");
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>

 @else

 <script type="text/php">
    if ( isset($pdf) ) {
        $x = 518;
        $y = 78;
        $text = "RG.33 Rev.02";
        $font = $fontMetrics->get_font("serif", "normal");
        $size = 8;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>

@endif


</body>

</html>
