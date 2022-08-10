@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

        <reporte-interno-equipos-ri
            :user= "{{ $user }}"
        ></reporte-interno-equipos-ri>

    </div>

@endsection