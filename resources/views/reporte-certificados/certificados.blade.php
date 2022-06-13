@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <reporte-certificados
            :user= "{{ $user }}"
    ></reporte-certificados>

    </div>

@endsection
