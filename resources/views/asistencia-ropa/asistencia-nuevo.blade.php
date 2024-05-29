@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <asignacion-nuevo
        :productos_opciones="{{ $productos }}"
        :operadores_opciones="{{ $operadores }}"
        :remitos_opciones="{{ $remitos }}"
    ></asignacion-nuevo>
</div>

@endsection