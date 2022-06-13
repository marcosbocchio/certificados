@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <reporte-partes
            :user= "{{ $user }}"
    ></reporte-partes>

    </div>

@endsection
