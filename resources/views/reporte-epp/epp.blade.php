@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <reporte-epp
            :user= "{{ $user }}"
            :operadores_data= "{{ $operadores }}"
    ></reporte-epp>

    </div>

@endsection
