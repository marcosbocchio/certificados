@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <costuras
        :user= "{{ $user }}"
    ></costuras>

    </div>

@endsection


