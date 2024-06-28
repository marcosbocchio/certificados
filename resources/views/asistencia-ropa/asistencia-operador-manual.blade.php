@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <asignacion-operador-manual
        :productos_opciones="{{ $productos }}"
        :operador_seleccionado="{{ $operador }}"
        :fecha_data="'{{ $fecha }}'"
    ></asignacion-operador-manual>
</div>

@endsection