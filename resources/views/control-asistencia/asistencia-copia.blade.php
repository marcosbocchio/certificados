@extends('layouts.enod.master')

@section('contenido')
<div id="app">
   <asistencia-copia 
   :asistencia-id="{{ $id }}"
   :frentes_opciones="{{$frente_sn}}"
   :operarios_opciones="{{$operarios}}"
   :contratistas_opciones="{{$contratistas}}"
   :fechas_por_frente="{{ json_encode($fechasPorFrente) }}"
   ></asistencia-copia>
</div>
@endsection