@extends('layouts.enod.master')

@section('contenido')

<div id="app">

   <asistencia-nuevo
   :frentes_opciones="{{$frente_sn}}"
   :operarios_opciones="{{$operarios}}"
   :contratistas_opciones="{{$contratistas}}"
   ></asistencia-nuevo>

</div>
@endsection