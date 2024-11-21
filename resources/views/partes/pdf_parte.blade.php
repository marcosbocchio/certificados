<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento PDF</title>
    <style>
        main{
            width: 100%;
        }
        footer {
            width: 86%;
            position: fixed; bottom:200px;
            padding-top: 0px;
        }
        header{
            position: fixed; top:-46px;
            right: 2px;
            width: 100%;
        }
        body {
        font-family: Arial, sans-serif;
        font-size: 12px; /* Increased for better readability */
        }
        table th, table td{
            padding:0px;
        }
        .heade_table th, .heade_table td{
            padding:0px;
        }
        .table_datos {
        
        border-collapse: collapse;
        font-size: 11px; /* Increased for better readability */
        width: 100%;
        border: 2px solid black;
        }
        .table_datos th {
            border: 2px solid black;
            padding: 0px;
            text-align: center;
        }
        .table_datos td {
            border: 1px solid black;
            text-align: center;
            height: 27px;
        }

        .combined-table {
            border-collapse: collapse;
            font-size: 11px; /* Increased for better readability */
            width: 100%;
        }
        .combined-table th, .combined-table td {
            padding: 0px 3px;
            border: none;
            text-align: left;
            
        }
        footer img {
            height: 42px; /* Ajusta según la imagen */
            width: auto; /* Mantén la proporción del logo del cliente */
            position: absolute;
            bottom: 10px; /* Ajusta esto para mover el logo hacia arriba o hacia abajo */
            right: 10px; /* Ajusta esto para alinear horizontalmente el logo */
        }
</style>
</head>
<body>
    <header class="heade_table">
        <table style="border-collapse: collapse; width: 100%;">
            <!-- Fila 1 -->
            <tr>
                <th style="width: 545px;" >&nbsp;</th>
                <th style="width: 40px;"  >&nbsp;</th>
                <th style="width: 167px;" >&nbsp;</th>
                <th style="width: 234px;" >&nbsp;</th>
            </tr>
            <tr>
            <th rowspan="6" style="text-align:left; position: fixed; top:-30px;">
            &nbsp;
                <img src="{{ public_path('/img/logo-enod.png')}}" alt="Logo ENOD" style="height: 150px;">
            </th>
                <th colspan="3" style="background-color:#878883;padding: 0px;height: 30px;">PARTE DIARIO</th>
            </tr>
            <!-- Fila 2: No hay celdas aquí ya que se combinaron en la fila anterior -->
            
            <!-- Fila 3 -->
            <tr>
                <td colspan="3" style="text-align:center;padding: 0px;height: 10px;">DEPARTAMENTO DE INSPECCION</td>
            </tr>
            <!-- Fila 4 -->
            <tr>
                <td >&nbsp;</td>
                <td style="border-top: 2px solid black; border-bottom: 2px solid black; border-left: 2px solid black;padding-left: 5px;height: 10px;"><b>FECHA</b></td>
                <td style="border-top: 2px solid black; border-bottom: 2px solid black; border-right: 2px solid black;padding-right: 5px;height: 10px;text-align:right"><b>{{$parteManual->fecha}}</b></td>
            </tr>
            <!-- Fila 5 -->
            <tr>
                <td colspan="2">&nbsp;</td>
                <td style="border: 2px solid black;padding: 0px;">&nbsp;</td>
            </tr>
        </table>
    </header>
    <main>
        @php $filasPorTabla = 10; @endphp

        @for ($i = 0; $i < count($detalles); $i += $filasPorTabla)
            <!-- Inicio de la tabla -->
            <table class="table_datos" style="border: 2px solid black;position: fixed; top:67px;">
                <!-- Cabecera de la tabla -->
                <tr>
                    <th style="width: 20px;border: 2px solid black;">Técnica</th>
                    <th style="width: 20px;border: 2px solid black;">Cant.</th>
                    <th style="width: 100px;border: 2px solid black;">Planta</th>
                    <th style="width: 160px;border: 2px solid black;">Equipo/Linea</th>
                    <th style="width: 170px;border: 2px solid black;">Operadores</th>
                    <th style="width: 30px;border: 2px solid black;">Horario</th>
                    <th style="width: 160px;border: 2px solid black;">N° Informe</th>
                    <th style="width: 220px;border: 2px solid black;" colspan="2">FIRMAS</th>
                </tr>
                <!-- Bucle para las filas de la tabla actual -->
                @for ($j = $i; $j < $i + $filasPorTabla; $j++)
    <tr>
        <!-- Celdas con datos o en blanco si no hay detalles -->
        @if ($j < count($detalles))
            <td>{{ $detalles[$j]->tecnica }}</td>
            <td>{{ $detalles[$j]->cantidad }}</td>
            <td>{{ $detalles[$j]->planta_1 }} / {{ $detalles[$j]->planta_2 ?? '-' }}</td> <!-- Mostrar ambas plantas -->
            <td>{!! $dividirTexto($detalles[$j]->equipo) !!}</td> <!-- Utiliza la función aquí -->
            <td>
                {{ $detalles[$j]->operador1name ?? '-' }} / 
                {{ $detalles[$j]->operador2name ?? '-' }}
            </td>
            <td>{{ $detalles[$j]->horario }}</td>
            <td>{{ $detalles[$j]->informe_nro }}</td>
            <td>
                {{ $detalles[$j]->inspector1_name ?? '-' }} / 
                {{ $detalles[$j]->inspector2_name ?? '-' }}
            </td>
            <td>&nbsp;</td>
        @else
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        @endif
    </tr>
@endfor
            </table>
            <footer>
                <table class="combined-table">
                <tr>
                    <th colspan="4" style="text-align:center;"><b>REFERENCIAS</b></th>
                    <th colspan="1" style="width: 10px;">&nbsp;</th>
                    <th colspan="2" style="text-align:center;">HORARIO</th>
                </tr>
                <tr>
                    <td style="width: 10px;"><b>CR</b></td>
                    <td style="width: 60px;">GAMMAGRAFIADO DIGITAL</td>
                    <td style="width: 10px;"><b>USAT</b></td>
                    <td style="width: 60px;">ULTRASONIDO ALTA TEMPERATURA</td>
                    <td>
                        &nbsp;
                    </td>
                    <td style="text-align: center;width: 150px;">LUNES A VIERNES 7 - A 16.30 HS</td>
                    <td style="width: 10px;"><b>A</b></td>
                </tr>
                <tr>
                    <td><b>ADM</b></td>
                    <td>ADMINISTRATIVO</td>
                    <td><b>USN2</b></td>
                    <td>ULTRASONIDO NUVEL 2</td>
                    <td>
                        &nbsp;
                    </td>
                    <td style="text-align: center;">LUNES A VIERNES 7 - A 19HS</td>
                    <td><b>B</b></td>
                </tr>
                <tr>
                    <td><b>LP</b></td>
                    <td>LIQUIDOS PENETRANTES</td>
                    <td><b>USPHA</b></td>
                    <td>US PASHED ARRAY</td>
                    <td>
                        &nbsp;
                    </td>
                    <td style="text-align: center;">SABADOS - DOMINGOS - FERIADOS - 7 A 19 HS</td>
                    <td><b>C</b></td>
                </tr>
                <tr>
                    <td><b>PM</b></td>
                    <td>PARTICULAS MAGNETICAS</td>
                    <td><b>DU</b></td>
                    <td>DUREZA</td>
                    <td>
                        &nbsp;
                    </td>
                    <td style="text-align: center;">LUNES A DOMINGO - HORARIO NOCTURNO </td>
                    <td><b>D</b></td>
                </tr>
                <tr>
                    <td><b>PMI</b></td>
                    <td>POSITIVA MATERIAL IDENTIFICATION</td>
                    <td><b>RM</b></td>
                    <td>REPLICAS METALOGRAFICAS</td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><b>RG</b></td>
                    <td>GAMMAGRAFIADO</td>
                    <td><b>TT</b></td>
                    <td>TRATAMIENTO TERMICO</td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td><b>US</b></td>
                    <td>ULTRASONIDO</td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </table>
            <div>
                        @if($cliente && $ot->logo_cliente_sn && $cliente->path)
                            <img  src="{{ public_path($cliente->path)}}" alt="" style="height:42px;max-width: 120px;position: fixed; bottom:70px; right:270px">
                        @else
                            <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height:42px;max-width: 120px;position: fixed; bottom:70px; right:270px">
                        @endif
            </div>
            </footer>
            @if ($i + $filasPorTabla < count($detalles))
                <div style="page-break-before: always;"></div>
            @endif
        @endfor
    </main>
            
            <script type="text/php">

    if ( isset($pdf) ) {
        $x = 680;
        $y = 71;
        $text = "PAGINA : {PAGE_NUM} de {PAGE_COUNT}";
        $font = $fontMetrics->get_font("serif", "bold");
        $size = 9;
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