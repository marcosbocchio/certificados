@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <asignacion-operador
    :operador_data="{{ $operador_data }}"
    ></asignacion-operador>
</div>

@endsection