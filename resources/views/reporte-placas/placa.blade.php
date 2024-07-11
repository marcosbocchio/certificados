@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <reporte-placas
            :user= "{{ $user }}"
    ></reporte-placas>

    </div>

@endsection
