@extends('layouts.enod.master')

@section('contenido')

<?php // return dd($ot_informes);?>

<div id="app">

   <ot-informes
    :usuario_metodos_data = '{{$usuario_metodos}}'
    :ot_data = '{{$ot}}'
    :ot_metodos_ensayos_data ="{{$ot_metodos_ensayos}}"
    :numero_informe_formateado_xc="'{{$numero_informe_formateado_xc}}'"
   ></ot-informes>

</div>
@endsection
