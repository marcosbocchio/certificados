@extends('layouts.enod.master')

@section('contenido')

<div id="app">
    <subcategoria v-bind:secciones="{{$resultados}}"></subcategoria>
</div>

@endsection
