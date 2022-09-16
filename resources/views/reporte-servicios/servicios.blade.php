@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <reporte-servicios
            :user= "{{ $user }}"
    ></reporte-servicios>

    </div>

@endsection
