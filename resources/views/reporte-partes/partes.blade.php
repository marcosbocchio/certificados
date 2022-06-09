@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <partes
            :user= "{{ $user }}"
    ></partes>

    </div>

@endsection
