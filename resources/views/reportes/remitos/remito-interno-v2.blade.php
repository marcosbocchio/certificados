<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$tipo_reporte}} {{ $nro }}</title>
    <link rel="stylesheet" href="{{ asset('/css/reportes/pdf.css') }}" media="all" />

</head>

<style>

    @page { margin: 260px 40px 60px 40px !important;
            padding: 0px 0px 0px 0px !important; }

header {
    position:fixed;
    top: -237px;    
}        
    
footer {
    position: fixed; bottom:0px; 
    padding-top: 0px;
}

</style>

<body>

<header>
    @include('reportes.partial.header-principal-portrait')     
    @include('reportes.partial.linea-amarilla')                
    @include('reportes.partial.header-cliente-comitente-portrait')    
    @include('reportes.partial.linea-gris')        
    @include('reportes.partial.header-proyecto-portrait')    
    @include('reportes.partial.linea-amarilla') 
</header>

<footer>

    @include('reportes.partial.linea-amarilla') 
    <table>
        <tbody>
            <tr>
                <td style="font-size: 12px;  text-align: left;">RESPONSABLE REMITO : {{$user->name}}</td>                                         
            </tr>
        </tbody>
    </table>
  
</footer>

<main>   
    
    <table width="100%" class="bordered" style="border: none;" >
        <thead>
            <tr>
                <th style="font-size: 13px; width:40px;text-align: center;" >Cantidad</th>
                <th style="font-size: 13px; text-align: left;"><span style="margin-left:15px">Descripción</span></th>  
            </tr>
        </thead>
        
        <tbody>   
            @foreach ($detalle as $producto)

                    <tr>
                        <td style="font-size: 13px;width:41.5px;text-align: center;">{{ $producto->cantidad }}</td>     
                        <td style="font-size: 13px;text-align: left"><span style="margin-left:15px"> {{ $producto->producto }} {{ $producto->medida}} {{ $producto->unidad_medida}} </span></td>     
                    </tr>  

            @endforeach   

            @foreach ( $remito_interno_equipos as $remito_interno_equipo )

              
                    <tr class="bordered-0">
                        <td style="font-size: 13px;  width:41.5px;text-align: center;">1</td>     
                        <td style="font-size: 13px;  text-align: left"><span style="margin-left:15px">

                         {{ $remito_interno_equipo->InternoEquipo->equipo->codigo }} - N° Serie : {{ $remito_interno_equipo->InternoEquipo->nro_serie}} - N° Int : {{$remito_interno_equipo->InternoEquipo->nro_interno}} 
                         @if ($remito_interno_equipo->InternoEquipo->internoFuente)
                             
                         - Fuente : {{$remito_interno_equipo->InternoEquipo->internoFuente->fuente->codigo}}

                         @endif
                         
                          </span></td>     
                    </tr>  
              
            @endforeach

        </tbody>
    </table>
</main>   
     
    @include('reportes.partial.nro_pagina') 
  

</body>
</html>