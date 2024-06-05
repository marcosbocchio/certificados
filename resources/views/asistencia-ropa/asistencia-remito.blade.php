@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <asignacion-remito
    :operadores_opciones="{{ $operadores }}"
    :remito_data="{{ $remito_data }}"
    ></asignacion-remito>
</div>

@endsection