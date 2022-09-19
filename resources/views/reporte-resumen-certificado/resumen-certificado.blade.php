@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <reporte-resumen-certificado
            :user= "{{ $user }}"
    ></reporte-resumen-certificado>

    </div>

@endsection