@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <asignacion-nuevo
        :productos_opciones="{{ $productos }}"
        :operadores_opciones="{{ $operadores }}"
        :remitos_opciones="{{ $remitos }}"
        :remito_data="{{ $remito_data }}"
        :operador_seleccionado="{{ $operador }}"
    ></asignacion-nuevo>
</div>

@endsection