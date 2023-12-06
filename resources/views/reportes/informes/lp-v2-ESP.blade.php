<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORME {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />
</head>

<style>
body{
    font-family: "Encode Sans",Arial,sans-serif;
}
main{
    border: 3px solid black;
    margin-top:-3mm;
}
footer{
    font-family: "Encode Sans",Arial,sans-serif;
    border: 3px solid black;
    width: 164mm;
}
.logo{
    width: 20%;
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
    font-size: 6pt;
    text-align:left;
    margin-left:2px;
}
#font7{
    font-size: 7.3pt;
    text-align:left;
    margin-left:2px;
}
.tablamain td {
        border: 1.5px solid black;
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
    font-size:9pt;
}

</style>

<main>
<table class="header">
    <tbody>
        <tr>
            <td class="logo">
                <img src="{{ public_path('img/aesa.png')}}" alt="x">
            </td>
            <td style="width: 55%;">
                <table style="border-collapse: collapse;">
                    <tbody style="text-align: center;">
                        <tr>
                            <td style="font-size: 7pt;">
                                FORMULARIO
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 9.8pt;">
                                <b>INFORME DE ENSAYOS POR LÍQUIDOS PENETRANTES
                                    / DYE PENETRANT EXAMINATION REPORT</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 8.80pt;">
                                <b>Radiographic Examination Report</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">
                                FGE-CA-034 - Rev.1 (02/01/2020 - AESA Privada)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 25%;">
                @if($contratista && $ot->logo_contratista_sn && $contratista->path_logo)
                    <img  src="{{ public_path($contratista->path_logo)}}" alt="" style="height:60px; margin-top: 5px;">
                @else
                    <img  src="{{ public_path('img/blank.png')}}" alt=""  style="height: 42px;margin-top: 5px;">
                @endif
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
@if ($contratista && $contratista->reporte_especial_en_cliente == 1)
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
@endif
<table class="tablamain">
    <tbody>
        <tr><td colspan="2" style="width: 78mm; height:4mm;" id="titulo"><b>Identificación del Material / Material Identification</b></td></tr>
        <tr>
            <td style="width: 77mm; height: 4mm;" id="font7">Cliente / Customer</td>
            <td style="width: 86mm; height: 4mm;" id="font7">Obra / Job</td>
        </tr>
        <tr>
            <td style=" height: 7.5mm;"><b>YPF/TR</b></td>
            @if(isset($informe))
                <td><span class="datosHead" style=" height: 7.5mm;"><b>{{$informe->obra}}</b></span></td>
            @else
                <td><span class="datosHead" style=" height: 7.5mm;"></span><b>{{$ot->obra}}</b></td>
            @endif
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="width: 61mm;height: 4mm;" id="font7">Equipo / Equipment</td>
            <td style="width: 102mm;height: 4mm;" id="font7">Componentes a Ensayar / Components to Test</td>
        </tr>
        <tr>
            <td style="height: 7.5mm;"><b>{{$equipo->equipo->codigo}}</b></td>
            <td style="height: 7.5mm;"><b>{{$informe->componente}}</b></td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="width: 77mm;height: 4mm;" id="font7">Material / Material</td>
            <td style="width: 86mm;height: 4mm;" id="font7">Espesor / Thickness</td>
        </tr>
        <tr>
            <td style="height: 7mm;">
                <b>{{$material->codigo}}</b>
            </td>
            <td style="height: 7mm;">
                                    @if ($informe->espesor_chapa)
                                        <b>{{ $informe->espesor_chapa }}</b>
                                    @elseif($informe->espesor_especifico)
                                        <b>{{ $informe->espesor_especifico }}</b>
                                    @else
                                        <b>{{ $diametro_espesor->espesor }}</b>
                                    @endif
            </td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr><td colspan="3" style="height: 5mm;" id="titulo"><b>Procedimiento / Procedure</b></td></tr>
        <tr>
            <td style="width: 55mm;height: 4mm;" id="font7">Procedimiento Nº y rev./ Procedure Nº and rev</td>
            <td style="width: 52mm;" id="font7">Norma de Ensayo / Standard Test</td>
            <td style="width: 55mm;" id="font7">Norma de Eval. / Evaluation Standard</td>
        </tr>
        <tr>
            <td style="height: 7.5mm;"><b>{{$procedimiento_inf->titulo}}</b></td>
            <td><b>{{$norma_ensayo->codigo}}</b></td>
            <td><b>{{$norma_evaluacion->codigo}}</b></td>
        </tr>
        <tr>
            <td style="height: 4mm;" id="font7">Cond. Superficial/ Surface Condition</td>
            <td id="font7">Limpieza Previa / Precleaning</td>
            <td id="font7">Temp. Superficie/ Surface Temperature</td>
        </tr>
        <tr>
            <td style="height: 7.5mm;">&nbsp;</td>
            <td><b>{{$informe_lp->limpieza_previa}}</b></td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="width: 77mm;height: 4mm;" id="font7">Temperatura de Consumibles / Consumables Temperature</td>
            <td style="width: 86mm;" id="font7">Termómetro / Thermometer</td>
        </tr>
        <tr>
            <td style="height: 7.5mm; ">&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="height: 4mm; " id="font7">Marca y Designación del Penetrante / Penetrant Brand and Design</td>
            <td id="font7">Modo de Aplicación / Aplicated by</td>
        </tr>
        <tr>
            <td style="height: 7.5mm; ">
                                    <b>{{$penetrante->tipo}}</b>

                                    @if ($penetrante->marca)
                                    &nbsp;/&nbsp;<b>{{$penetrante->marca}}</b>
                                    @else
                                         &nbsp;
                                    @endif
            </td>
            <td><b>{{$penetrante_aplicacion->codigo}}</b></td>
        </tr>
        <tr>
            <td style="height: 4mm; " id="font7">Marca y Designación del Removedor / Remover Brand and Design.</td>
            <td id="font7">Forma de Remoción / Removed by</td>
        </tr>
        <tr>
            <td style="height: 7.5mm; ">
                                    <b>{{$removedor->tipo}}</b>
                                    @if ($removedor->marca)

                                    &nbsp;/&nbsp;<b>{{$removedor->marca}}</b>

                                    @endif
            </td>
            <td><b>{{$removedor_aplicacion->codigo}}</b></td>
        </tr>
        <tr>
            <td style="height: 4mm; " id="font7">Marca y Designación del Revelador / Developer Brand and Design.</td>
            <td id="font7">Modo de Aplicación / Aplicated by</td>
        </tr>
        <tr>
            <td style="height: 7.5mm; ">
                                    <b>{{$revelador->tipo}}</b>
                                    @if ($revelador->marca)

                                        &nbsp;/&nbsp;<b>{{$revelador->marca}}</b>

                                    @endif
            </td>
            <td><b>{{$revelador_aplicacion->codigo}}</b></td>
        </tr>
    </tbody>
</table>
<table class="tablamain">
    <tbody>
        <tr>
            <td style="height:7mm; width:40mm">Técnica<br>Technique</td>
            <td style="width:37mm">Tipo de Penetrante<br>Penetrant Type</td>
            <td style="width:41mm">Limpieza Final<br>Post Examination Cleaning</td>
            <td style="width:45mm">Equipo de Iluminación<br>Lighting Equipment;</td>
        </tr>
        <tr>
            <td style="height:9mm">
                                    @if($metodo->tipo =='TIPO I')
                                        <b>Fluorescente</b>
                                    @else
                                        <b>Visible</b>
                                    @endif
            </td>
            <td><b>{{$equipo->equipo->instrumento_medicion}}</b></td>
            <td>
                @if ($informe_lp->limpieza_final)
                                         <b>{{$informe_lp->limpieza_final}}</b>
                                    @else
                                          &nbsp;
                                    @endif
            </td>
            <td><b>{{$iluminacion->codigo}}</b></td>
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
                    <img src="{{ asset($detalleReferencia->path1) }}" alt="Imagen"  style="max-height: 30mm; margin: 1mm;">
                </td>
            </tr>
            <tr>
                <td style="height:5mm" id="titulo"><b>Informe / Report:</b></td>
            </tr>
            <tr>
                <td style="height:13mm">{{$detalleReferencia->descripcion}}</td>
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
                            <td style="width: 3mm;">&nbsp;</td>
                            <td id="bordernone">Aceptado / Accepted</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 3mm">&nbsp;</td>
                            <td id="bordernone">Observado / Observed</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
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
            <td style="height:10mm;">
                <table>
                    <tbody>
                        <tr>
                            <td style="text-align:left;width: 30mm;padding-bottom:5mm"   id="bordernone">Evaluador / Evaluated by </td>
                        </tr>
                        <tr>
                            <td  id="bordernone" style="text-align:left">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone" style="text-align:left">
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
                            <td style="width: 40mm;text-align:left;padding-bottom:5mm"   id="bordernone">Inspector AESA / Manufacture </td>
                        </tr>
                        <tr>
                            <td  id="bordernone" style="text-align:left">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone" style="text-align:left">
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
                            <td style="width: 40mm;text-align:left;padding-bottom:5mm"   id="bordernone">Inspector Cliente / Coustomer </td>
                        </tr>
                        <tr>
                            <td  id="bordernone" style="text-align:left">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone" style="text-align:left">
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
                            <td style="width: 40mm;text-align:left;padding-bottom:5mm"   id="bordernone">Insp. Autorizado / AI </td>
                        </tr>
                        <tr>
                            <td  id="bordernone" style="text-align:left">Firma:</td>
                        </tr>
                        <tr>
                            <td id="bordernone" style="text-align:left">
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
