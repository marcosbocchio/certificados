@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <certificados-partes
            :user= "{{ $user }}"
    ></certificados-partes>

    </div>

@endsection
