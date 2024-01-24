<style>
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
</style>

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
    <h2>{{ strtoupper($nombreObjeto) }}</h2>

    @if (count($datos['medicionesTranspuestas'][0]) - 2 <= $datos['cantidad_generatrices_linea_pdf_me'])
        {{-- Formato agrupado --}}
        <table class="bordered">
            <thead>
                <tr>
                    <th>Puntos</th>
                    @foreach (array_slice($datos['medicionesTranspuestas'][0], 1, -1) as $encabezado)
                        <th>{{ $encabezado }}</th>
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
                            <td colspan="{{ count($datos['medicionesTranspuestas'][0]) - 1 }}">{{ $ultimoValor }}</td>
                        </tr>
                    @endif

                    <tr>
                        @foreach (array_slice($medicion, 0, -1) as $key => $valor)
                            <td style="color: {{ $key >= 2 && $valor !== 'S/A' && $valor < $espesorMinimo ? 'red' : 'inherit' }}">{{ $valor }}</td>
                        @endforeach
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
            <table class="bordered">
                <thead>
                    <tr>
                        <th>Puntos</th>
                        <th>Ø</th>
                        @foreach ($columnasMostrar as $encabezado)
                            <th>{{ $encabezado }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos['medicionesTranspuestas'] as $indice => $medicion)
                        @if ($indice > 0)
                            <tr>
                                <td>{{ $medicion[0] }}</td>
                                <td>{{ $medicion[1] }}</td>
                                @foreach (array_slice($medicion, $inicio, $fin - $inicio) as $key => $valor)
                                    <td style="color: {{ $key + $inicio >= 2 && $valor !== 'S/A' && $valor < $espesorMinimo ? 'red' : 'inherit' }}">{{ $valor }}</td>
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

@if( $informe_us->path1_indicacion || $informe_us->path2_indicacion )
<div class="page_break"></div>
<table width="100%">
    <tbody>
        <tr>
            <td style="border: 1px solid #000;background:#D8D8D8;text-align: center;" >
           IMAGENES INDICACIONES
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
                                    <img src="{{ public_path($informe_us->path1_indicacion) }}" alt="" style="width: 700px;height: 270px;">
                                @endif

                            </td>

                        </tr>
                        <tr>
                            <td style="text-align: center; width: 680px;height: 275px;">

                                @if ($informe_us->path2_indicacion)
                                    <img src="{{ public_path($informe_us->path2_indicacion) }}" alt="" style="width: 700px;height: 270px;">
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
           IMAGENES INDICACIONES
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
                                    <img src="{{ public_path($informe_us->path3_indicacion) }}" alt="" style="width: 700px;height: 270px;">
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; width: 680px;height: 275px;">

                                @if ($informe_us->path4_indicacion)
                                    <img src="{{ public_path($informe_us->path4_indicacion) }}" alt="" style="width: 700px;height: 270px;">
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