@extends('layouts.enod.master')

@section('contenido')

<div id="app">
   <asistencia-edit 
   :asistencia-id="{{ $id }}"
   :frentes_opciones="{{$frente_sn}}"
   :operarios_opciones="{{$operarios}}"
   :contratistas_opciones="{{$contratistas}}"
   :metodo_ensayos="{{ json_encode($metodoEnsayos) }}"
   ></asistencia-edit>
</div>
@endsection