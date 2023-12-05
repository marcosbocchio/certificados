<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>
main{
    font-family: "Encode Sans",Arial,sans-serif;
    border: 3px solid black;
    width: 164mm;
    margin-left: 20mm;
}
footer{
    font-family: "Encode Sans",Arial,sans-serif;
    border: 3px solid black;
    width: 164mm;
}
.logo{
    width: 30%;
}
.logo img{
    height: 60px;
}
#bordernone{
    border:none;
}
.tablamain{
        font-size: 7pt;
        border-collapse: collapse;
        width: 100%;
}
#left{
    text-align:left;
    margin-left:2px;
}
#tabla6{
    text-align:left;
    margin-left:2px;
    font-size:6pt;
}
.tablamain td {
        border: 1.2px solid black;
        text-align: center;
        padding: 0px 0px 0px 0px;
}
.tablamain .gris{
        background-color: #D9D9D9;
}
.tablamain .celda-corta {
        width: 25%;
}
.tablamain .celda-larga {
        width: 75%;
}
.tablafooter{
        font-size: 7pt;
        border-collapse: collapse;
        width: 100%;
}

.header{
    height: 31.92px;
    width: 100%;
    padding: 5px 0px 0px 0px; 
}
.cont{
    width:100%;
    margin: -4px 0px 2px 0px;
    box-shadow: rgba(0, 0, 0, 0.45) 0px 25px 20px -20px;
}
.color1 {
    display:inline-block;
    height: 5px;
    width: 25%;
    background: #7f8e2b;
    padding:0px;
    margin: 0px -4px 0px -2px;
}

.color2 {
    display:inline-block;
    height: 5px;
    width: 25%;
  background: #c0504d;
  padding:0px;
  margin: 0px -2px 0px 0px;
  box-shadow: rgba(0, 0, 0, 0.45) 0px 25px 20px -20px;
}

.color3 {
    display:inline-block;
    height: 5px;
    width: 25%;
    background: #f1ab00;
    padding:0px;
    margin: 0px 0px 0px -2px;
}

.color4 {
    display:inline-block;
    height: 5px;
    width: 25%;
    background: #4f81bd;
    padding:0px;
    margin: 0px 0px 0px -4px;
}
    .col1 {
        width: 35.72mm;
    }
    .col1 b{
        padding-left:1px;
    }
    .col2 {
        width: 40mm;
    }
    .col3{
        width: 25.82mm;
    }
    .col4{
        width: 40.60mm;
    }
    .col3 b{
        padding-left:1px;
    }
    #qr{
    font-size: 8pt;
    width: 19mm;
    height: 19mm;
}
#titulo{
    font-size:10pt;
}

</style>

<main>
<table class="header">
    <tbody>
        <tr>
            <td class="logo">
                <img src="{{ public_path('img/aesa.png')}}" alt="x">
            </td>
            <td style="width: 50%;">
                <table style="border-collapse: collapse;">
                    <tbody style="text-align: center;">
                        <tr>
                            <td style="font-size: 7pt;">
                                FORMULARIO
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 9.8pt;">
                                <b>INFORME DE ENSAYO RADIOGRAFICO</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 8.80pt;">
                                <b>Radiographic Examination Report</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">
                                FGE-CA-031- Rev.0 (04/12/2017 - AESA Privada)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 20%;">
                    <img  src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fes.m.wikipedia.org%2Fwiki%2FArchivo%3ALogo_de_YPF.svg&psig=AOvVaw1a2ApdfBUuBw1r8hXJv96c&ust=1700881025628000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCPim-dzR24IDFQAAAAAdAAAAABAD" alt=""  style="height: 42px;margin-top: 5px;">
            </td>
        </tr>
    </tbody>
</table>
<div class="cont">
    <div class="color1"></div>
    <div class="color2"></div>
    <div class="color3"></div>
    <div class="color4"></div>
</div>
<table class="tablamain">
    <tbody>
        <tr>
            <td class="col1" id="left"><b>PROYECTO:</b></td>
            <td colspan="3"><span class="datosHead">{{$ot->proyecto}}</span></td>
            <td rowspan="5" id="qr"><b>CODIGO QR</b></td>
        </tr>
        <tr>
            <td id="left" class="col1"><b>CONTRATISTA</b></td>
            <td colspan="3">
                AESA
            </td>
        </tr>
        <tr>
            <td class="col1" id="left"><b>SISTEMA / SUBSIST.:</b></td>
            <td class="col2">&nbsp;</td>
            <td class="col3" id="tabla6"><b>PIE / N° ACTIVIDAD:</b></td>
            <td class="col4"> R0 / RT: 4.4/4.9</td>
        </tr>
        <tr >
            <td class="col1" id="left"><b>ELEMENTO</b></td>
            <td class="col2">&nbsp;</td>
            <td class="col3" id="tabla6"><b>TIPO DE INSPECCION:</b></td>
            <td class="col4">&nbsp;</td>
        </tr>
        <tr>
            <td class="col1" id="left"><b>PAQ. DE PRUEBA:</b></td>
            <td class="col2">&nbsp;</td>
            <td class="col3" id="tabla6"><b>N° REPORTE / RFI:</b></td>
            <td class="col4">--</td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr><td colspan="2" style="width: 78mm; height:4mm;" id="titulo"><b>Identificación del Material / Material Identification</b></td></tr>
        <tr>
            <td style="width: 77mm; height: 4mm;" >Cliente / Customer</td>
            <td style="width: 86mm; height: 4mm;">Obra / Job</td>
        </tr>
        <tr>
            <td style=" height: 8mm;"> YPF/TR</td>
            @if(isset($informe))
                <td><span class="datosHead" style=" height: 8mm;">{{$informe->obra}}</span></td>
            @else
                <td><span class="datosHead" style=" height: 8mm;"></span>{{$ot->obra}}</td>
            @endif
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="width: 61mm;height: 4mm;">Equipo / Equipment</td>
            <td style="width: 102mm;height: 4mm;">Componentes a Ensayar / Components to Test</td>
        </tr>
        <tr>
            <td style="height: 8mm;">{{$equipo->equipo->codigo}}</td>
            <td style="height: 8mm;">{{$informe->componente}}</td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="width: 77mm;height: 4mm;">Material / Material</td>
            <td style="width: 86mm;height: 4mm;">Espesor / Thickness</td>
        </tr>
        <tr>
            <td style="height: 8mm;">
                {{$material->codigo}}
            </td>
            <td style="height: 8mm;">
                                    @if ($informe->espesor_chapa)
                                        {{ $informe->espesor_chapa }}
                                    @elseif($informe->espesor_especifico)
                                        {{ $informe->espesor_especifico }}
                                    @else
                                        {{ $diametro_espesor->espesor }}
                                    @endif
            </td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr><td colspan="3" style="height: 5mm;" id="titulo"><b>Procedimiento / Procedure</b></td></tr>
        <tr>
            <td style="width: 55mm;height: 4mm;">Procedimiento Nº y rev./ Procedure Nº and rev</td>
            <td style="width: 52mm;">Norma de Ensayo / Standard Test</td>
            <td style="width: 55mm;">Norma de Eval. / Evaluation Standard</td>
        </tr>
        <tr>
            <td style="height: 8mm;">{{$procedimiento_inf->titulo}}</td>
            <td>{{$norma_ensayo->codigo}}</td>
            <td>{{$norma_evaluacion->codigo}}</td>
        </tr>
        <tr>
            <td style="height: 4mm;">Cond. Superficial/ Surface Condition</td>
            <td>Limpieza Previa / Precleaning</td>
            <td>Temp. Superficie/ Surface Temperature</td>
        </tr>
        <tr>
            <td style="height: 8mm;">&nbsp;</td>
            <td>{{$informe_lp->limpieza_previa}}</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="width: 77mm;height: 4mm;" id="tabla6">Temperatura de Consumibles / Consumables Temperature</td>
            <td style="width: 86mm;" id="tabla6">Termómetro / Thermometer</td>
        </tr>
        <tr>
            <td style="height: 8mm; ">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="height: 4mm; " id="tabla6">Marca y Designación del Penetrante / Penetrant Brand and Design</td>
            <td id="tabla6">Modo de Aplicación / Aplicated by</td>
        </tr>
        <tr>
            <td style="height: 8mm; ">
                                    {{$penetrante->tipo}}

                                    @if ($penetrante->marca)
                                    &nbsp;/&nbsp;{{$penetrante->marca}}
                                    @else
                                         &nbsp;
                                    @endif
            </td>
            <td>{{$penetrante_aplicacion->codigo}}</td>
        </tr>
        <tr>
            <td style="height: 4mm; " id="tabla6">Marca y Designación del Removedor / Remover Brand and Design.</td>
            <td id="tabla6">Forma de Remoción / Removed by</td>
        </tr>
        <tr>
            <td style="height: 8mm; ">
                                    {{$removedor->tipo}}
                                    @if ($removedor->marca)

                                    &nbsp;/&nbsp;{{$removedor->marca}}

                                    @endif
            </td>
            <td>{{$removedor_aplicacion->codigo}}</td>
        </tr>
        <tr>
            <td style="height: 4mm; " id="tabla6">Marca y Designación del Revelador / Developer Brand and Design.</td>
            <td id="tabla6">Modo de Aplicación / Aplicated by</td>
        </tr>
        <tr>
            <td style="height: 8mm; ">
                                    {{$revelador->tipo}}
                                    @if ($revelador->marca)

                                        &nbsp;/&nbsp;{{$revelador->marca}}

                                    @endif
            </td>
            <td>{{$revelador_aplicacion->codigo}}</td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="height:7mm">Técnica Technique</td>
            <td>Tipo de Penetrante Penetrant Type</td>
            <td>Limpieza Final Post Examination Cleaning</td>
            <td>Equipo de Iluminación Lighting Equipment;</td>
        </tr>
        <tr>
            <td style="height:9mm">
                                    @if($metodo->tipo =='TIPO I')
                                        Fluorescente
                                    @else
                                        Visible
                                    @endif
            </td>
            <td>{{$equipo->equipo->instrumento_medicion}}</td>
            <td>
                @if ($informe_lp->limpieza_final)
                                         {{$informe_lp->limpieza_final}}
                                    @else
                                          &nbsp;
                                    @endif
            </td>
            <td>{{$iluminacion->codigo}}</td>
        </tr>
    </tbody>
</table>
@forelse ($detallesReferencia as $detalleReferencia)
    <table class="tablamain" style="page-break-inside: avoid;">
        <tbody>
            <tr>
                <td style="height:5mm" id="titulo"><b>Croquis / Sketch</b></td>
            </tr>
            <tr>
                <td style="height:32mm;">
                    <img src="{{ asset($detalleReferencia->path1) }}" alt="Imagen"  style="max-height: 32mm; margin: 4mm;">
                </td>
            </tr>
            <tr>
                <td style="height:5mm" id="titulo"><b>Informe / Report:</b></td>
            </tr>
            <tr>
                <td style="height:5mm">{{$detalleReferencia->descripcion}}</td>
            </tr>
        </tbody>
    </table>
@empty
    <table class="tablamain">
        <!-- Espacios en blanco para imagen y observación -->
        <tbody>
            <tr>
                <td style="height:5mm" id="titulo"><b>Croquis / Sketch</b></td>
            </tr>
            <tr>
                <td style="height:15mm;"></td>
            </tr>
            <tr>
                <td style="height:5mm" id="titulo"><b>Informe / Report:</b></td>
            </tr>
            <tr>
                <td style="height:16mm;"></td>
            </tr>
        </tbody>
    </table>
@endforelse
<table class="tablamain">
    <tbody>
        <tr>
            <td style="height:9mm">
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 3mm">&nbsp;</td>
                            <td id="bordernone">Aceptado / Accepted</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="height:9mm">
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 3mm">&nbsp;</td>
                            <td id="bordernone">Observado / Observed</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="height:9mm">
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 3mm">&nbsp;</td>
                            <td  id="bordernone">Rechazado / Reject</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 30mm;"   id="bordernone">Evaluador / Evaluated by </td>
                        </tr>
                        <tr>
                            <td  id="bordernone">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td  id="bordernone">Fecha</td>
                                            <td  id="bordernone">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 40mm;"   id="bordernone">Inspector AESA / Manufacture </td>
                        </tr>
                        <tr>
                            <td  id="bordernone">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td  id="bordernone">Fecha</td>
                                            <td  id="bordernone">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 40mm;"   id="bordernone">Inspector Cliente / Coustomer </td>
                        </tr>
                        <tr>
                            <td  id="bordernone">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td  id="bordernone">Fecha</td>
                                            <td  id="bordernone">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 40mm;"   id="bordernone">Insp. Autorizado / AI </td>
                        </tr>
                        <tr>
                            <td  id="bordernone">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td  id="bordernone">Fecha</td>
                                            <td  id="bordernone">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</main>
<script type="text/php">

if ( isset($pdf) ) {
    $x = 270;
    $y = 805;
    $text = "Pagina {PAGE_NUM}";
    $font = $fontMetrics->get_font("serif");
    $size = 10;
    $color = array(0,0,0);
    $word_space = 0.0;  //  default
    $char_space = 0.0;  //  default
    $angle = 0.0;   //  default
    $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

    $x = 420;
    $y = 10;
    $text = "Clasificación YPF: No Confidencial";
    $font = $fontMetrics->get_font("serif");
    $size = 8.80;
    $color = array(0, 0, 0);
    $pdf->page_text($x, $y, $text, $font, $size, $color);

    $x = 420;
    $y = 805;
    $text = "Clasificación YPF: No Confidencial";
    $font = $fontMetrics->get_font("serif");
    $size = 8.80;
    $color = array(0, 0, 0);
    $pdf->page_text($x, $y, $text, $font, $size, $color);
}

</script>
</html>
