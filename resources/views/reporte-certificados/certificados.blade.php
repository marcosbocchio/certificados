@extends('layouts.enod.master')

@section('contenido')

    <div id="app">

    <certificados
            :user= "{{ $user }}"
    ></certificados>

    </div>

@endsection
