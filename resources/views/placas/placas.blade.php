@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <placas
            :user= "{{ $user }}"
    ></placas>

    </div>

@endsection
