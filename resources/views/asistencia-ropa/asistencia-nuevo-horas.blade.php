@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <asignacion-nuevo-horas
        :productos_opciones="{{ $productos }}"
        :operadores_opciones="{{ $operadores }}"
        :remitos_opciones="{{ $remitos }}"
        :remito_data="{{ $remito_data }}"
        :operador_seleccionado="{{ $operador }}"
    ></asignacion-nuevo-horas>
</div>

@endsection