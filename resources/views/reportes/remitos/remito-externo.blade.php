<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   

 <style>
       

@page {
  size: A4;
  margin: 0mm;
}

header .fecha span {

    font-size: 15px;
}         

header .fecha .dia {

    position: absolute;
    top: 127px;
    left: 620px;
}

header .fecha .mes {

    position: absolute;
    top: 127px;
    left: 665px;
}

header .fecha .anio {

    position: absolute;
    top: 127px;
    left: 705px;
}

header .receptor  {

    position: absolute;
    top: 248.5px;
    left: 125px;

}

header .destino {

    position: absolute;
    top: 271px;
    left:125px;

}

.detalle {

    position: absolute;
    top: 390px;
    left:70px;
}
.producto {
    word-wrap: break-word;
}
 </style>  
</head>

<body onload="Imprimir()">
    
<header>
    <div class="fecha">   
        <div class="dia">
            <span>{{date('d', strtotime($remito->fecha))}}</span>
        </div>   
        <div class="mes">
            <span>{{ date('m', strtotime($remito->fecha))}}</span>
        </div>  
        <div class="anio">
           <span>{{ date('Y', strtotime($remito->fecha))}}</span>
        </div>  
    </div>
    <div class="receptor" >
            <span>{{$remito->receptor}}</span>
    </div>
    <div class="destino" >
        <span>{{$remito->destino}}</span>
    </div>
</header>   

<div class="detalle">
    <table>
        <tbody>
            @foreach ( $detalle as $producto )
               <tr>
                <td style="width: 50px;">                         
                    <span class="cantidad">{{ $producto->cantidad}} </span>           
                </td>
                <td style="width: 610px;">
                    <span class="producto">{{ $producto->producto}} </span>    
                </td> 
              </tr>
            @endforeach
            
            @foreach ( $remito_interno_equipos as $remito_interno_equipo )
                <tr>
                <td style="width: 50px;">                         
                    <span class="cantidad"> 1 </span>           
                </td>
                <td style="width: 610px;">
                    <span class="producto">{{ $remito_interno_equipo->InternoEquipo->equipo->codigo }} - N° Serie : {{ $remito_interno_equipo->InternoEquipo->nro_serie}} - N° Int : {{$remito_interno_equipo->InternoEquipo->nro_interno}} 
                         @if ($remito_interno_equipo->InternoEquipo->internoFuente)
                             
                         - Fuente : {{$remito_interno_equipo->InternoEquipo->internoFuente->fuente->codigo}}

                         @endif </span>    
                </td>
              </tr>
            @endforeach
            
        </tbody>
    </table>
    <table>
        <tbody>
            @foreach($observacionesRemito as $observacion)
                <tr>
                    <td style="width: 50px;">
                        <span class="cantidad">{{ $observacion->cantidad }}</span>           
                    </td>
                    <td style="width: 610px;">
                        <span class="producto">{{ $observacion->observaciones }}</span>    
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>



<script>
function Imprimir() {
    window.print();
}
</script>
</body>
</html>