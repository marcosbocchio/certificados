<style>
    .bordered {
        border-collapse: collapse;
        width: 100%;
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

@foreach ($medicionesAgrupadas as $elemento => $datos)
    @php
        $columnas = $datos['columnas'];
        $columnasMostradas = 0;
    @endphp

    @while ($columnasMostradas < count($columnas))
        <table class="bordered">
            <thead>
                <tr>
                    <th colspan="{{ min(count($columnas) - $columnasMostradas, 15) + 1 }}">{{ $elemento }}</th>
                </tr>
                <tr>
                    <th>Puntos</th>
                    @foreach (array_slice($columnas, $columnasMostradas, 15) as $columna)
                        <th>{{ $columna }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($datos['accesorios'] as $nombreAccesorio => $medicionesAccesorio)
                    <!-- Título del accesorio -->
                    <tr class="title-row">
                        <td colspan="{{ min(count($columnas) - $columnasMostradas, 15) + 1 }}">
                            {{ strtoupper($nombreAccesorio) }}
                        </td>
                    </tr>
                    <!-- Datos del accesorio -->
                    @foreach ($medicionesAccesorio as $valores)
                        <tr>
                            @foreach (array_slice($valores, $columnasMostradas, 15) as $indice => $valor)
                                @if ($indice == 0)
                                    <td>{{ $valor }}</td>
                                @else
                                    <td>{{ $valor ?? 'S/A' }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @php
            $columnasMostradas += 15;
        @endphp
        @if ($columnasMostradas < count($columnas))
            <!-- Agregar aquí cualquier marcado necesario para dividir las tablas, como un salto de página si es para imprimir -->
        @endif
    @endwhile
@endforeach


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
<table width="100%" style="border-collapse: collapse;">
        <tbody style="padding: 20px;"> 
            <tr>
                <td><strong style="font-size: 13px;">Observaciones</strong></td>
            </tr>   
            <tr>           
                <td style="font-size: 13px; height:150px;" class="bordered-td"><span style="margin-left: 5px; ">{{$observaciones}}</span></td> 
            </tr>
        </tbody>
</table>
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